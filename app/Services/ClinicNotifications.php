<?php
namespace App\Services;
use Illuminate\Support\Facades\DB;
class ClinicNotifications
{
    public static function publish($key, $campus, array $roles, $message, $path)
    {
        foreach ($roles as $role) {
            DB::table('clinic_notifications')->insertOrIgnore([
                'event_key' => $key . ':' . $role,
                'campus' => (string) $campus,
                'role' => $role,
                'message' => $message,
                'path' => $path,
                'created_at' => now(),
            ]);
        }
    }
    public static function reader()
    {
        // The login stores a stable employee identifier; workspace roles have separate read state.
        abort_unless(session('employee_id') && session('campus') && session('role'), 403);
        return hash('sha256', session('employee_id') . ':' . session('campus') . ':' . session('role'));
    }
    public static function visible()
    {
        $query = DB::table('clinic_notifications as n')
            ->leftJoin('clinic_notification_reads as r', function ($join) {
                $join->on('n.id', '=', 'r.notification_id')->where('r.reader', self::reader());
            })
            ->where('n.campus', (string) session('campus'))
            ->where('n.message', '<>', 'Dental appointment submitted.');
        if (in_array(session('role'), ['Admin', 'Super Admin'], true)) {
            // One recipient per workflow avoids duplicate copies of the same event.
            return $query->whereIn('n.role', ['Doctor', 'Nurse', 'Dentist', session('role')])
                ->where(function ($scope) {
                    $scope->where('n.event_key', 'not like', 'pending-appointments:%')->orWhere('n.role', session('role'));
                });
        }
        return $query->where('n.role', session('role'));
    }
}
