<?php
namespace App\Http\Controllers;
use App\Services\ClinicNotifications;
use Illuminate\Support\Facades\DB;
class ClinicNotificationController extends Controller
{
    public function index()
    {
        $this->syncPending();
        $query = ClinicNotifications::visible();
        $items = $query->select('n.id', 'n.message', 'n.path', 'n.created_at', 'r.read_at')
            ->orderByDesc('n.id')->limit(30)->get();
        
        return response()->json([
            'unread' => (clone $query)->whereNull('r.read_at')->count(),
            'items' => $items,
        ])->header('Cache-Control', 'no-store');
    }
    public function read($id)
    {
        $notification = ClinicNotifications::visible()->where('n.id', $id)->select('n.*')->first();
        abort_unless($notification, 404);
        DB::table('clinic_notification_reads')->updateOrInsert(
            ['notification_id' => $notification->id, 'reader' => ClinicNotifications::reader()],
            ['read_at' => now()]
        );

        return response()->json(['path' => $notification->path]);
    }
    public function unread($id)
    {
        $notification = ClinicNotifications::visible()->where('n.id', $id)->select('n.id')->first();
        abort_unless($notification, 404);
        DB::table('clinic_notification_reads')
            ->where('notification_id', $id)
            ->where('reader', ClinicNotifications::reader())
            ->delete();
        
        return response()->json(['success' => true]);
    }
    private function syncPending()
    {
        ClinicNotifications::reader();
        if (!in_array(session('role'), ['Admin', 'Super Admin', 'Dentist', 'Attendant'], true)) return;
       
        $pending = DB::table('appointment')
            ->where('campus', session('campus'))->whereNull('deleted_at')
            ->whereIn('status', ['Pending', 'For Approval'])
            ->whereDate('date', '>=', \Carbon\Carbon::today('Asia/Manila'))
            ->orderBy('id')->get(['id', 'date', 'time', 'status']);
      
        $key = 'pending-appointments:' . session('campus') . ':' . hash('sha256', $pending->toJson());
       
        DB::table('clinic_notifications')->where('campus', (string) session('campus'))
            ->where('role', session('role'))->where('event_key', 'like', 'pending-appointments:%')
            ->where('event_key', '<>', $key . ':' . session('role'))->delete();
        if ($pending->isNotEmpty()) {
            ClinicNotifications::publish($key, session('campus'), [session('role')],
                $pending->count() . ' appointment request' . ($pending->count() === 1 ? '' : 's') . ' pending approval.',
                '/view-status-appointment');
        }
    }
    public function readAll()
    {
        $this->syncPending();
        $reader = ClinicNotifications::reader();
        
        ClinicNotifications::visible()->whereNull('r.read_at')->select('n.id')->orderBy('n.id')->get()->chunk(200)->each(function ($items) use ($reader) {
            DB::table('clinic_notification_reads')->insertOrIgnore($items->map(function ($item) use ($reader) {
                return ['notification_id' => $item->id, 'reader' => $reader, 'read_at' => now()];
            })->all());
        });

        return response()->json(['success' => true]);
    }
}
