<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsDashboardController extends Controller
{
    public function index(Request $request)
    {
        $currentYear = Carbon::now('Asia/Manila')->year;
        $requestedYear = $request->get('year', $currentYear);
        $allYears = $requestedYear === 'all';
        $year = $allYears ? 'all' : (int) $requestedYear;
        if (!$allYears && ($year < 2023 || $year > $currentYear)) {
            $year = $currentYear;
        }

        $campus = session('campus');
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
            ['link' => '/', 'name' => 'Home'],
            ['name' => 'Analytics Dashboard'],
        ];

        $medicalBase = DB::table('medicalrecord')
            ->where('campus', $campus)
            ->whereNull('deleted_at');

        $dentalBase = DB::table('treatmentrecord')
            ->where('campus', $campus)
            ->whereNull('deleted_at');

        $appointmentBase = DB::table('appointment')
            ->where('campus', $campus)
            ->whereNull('deleted_at');

        $assessmentBase = DB::table('assessment')
            ->where('campus', $campus);

        if (!$allYears) {
            $medicalBase->whereYear('date', $year);
            $dentalBase->whereYear('date', $year);
            $appointmentBase->whereYear('date', $year);
            $assessmentBase->whereYear('created_at', $year);
        }

        $medicalCount = (clone $medicalBase)->count();
        $dentalCount = (clone $dentalBase)->count();
        $appointmentCount = (clone $appointmentBase)->count();
        $assessmentCount = (clone $assessmentBase)->count();
        $completedAppointments = (clone $appointmentBase)->where('status', 'Done')->count();

        $medicalPatients = (clone $medicalBase)->pluck('patientId');
        $dentalPatients = (clone $dentalBase)->pluck('patientId');
        $uniquePatients = $medicalPatients->merge($dentalPatients)->filter()->unique()->count();

        $monthlyCounts = function ($query, $column) {
            return $query->selectRaw('MONTH(' . $column . ') as month_number, COUNT(*) as total')
                ->groupBy(DB::raw('MONTH(' . $column . ')'))
                ->pluck('total', 'month_number');
        };

        $medicalMonthly = $monthlyCounts(clone $medicalBase, 'date');
        $dentalMonthly = $monthlyCounts(clone $dentalBase, 'date');
        $appointmentMonthly = $monthlyCounts(clone $appointmentBase, 'date');
        $assessmentMonthly = $monthlyCounts(clone $assessmentBase, 'created_at');

        $months = collect(range(1, 12));
        $trend = [
            'labels' => $months->map(function ($month) {
                return Carbon::create(null, $month, 1)->format('M');
            })->values(),
            'medical' => $months->map(function ($month) use ($medicalMonthly) {
                return (int) ($medicalMonthly[$month] ?? 0);
            })->values(),
            'dental' => $months->map(function ($month) use ($dentalMonthly) {
                return (int) ($dentalMonthly[$month] ?? 0);
            })->values(),
            'appointments' => $months->map(function ($month) use ($appointmentMonthly) {
                return (int) ($appointmentMonthly[$month] ?? 0);
            })->values(),
            'assessments' => $months->map(function ($month) use ($assessmentMonthly) {
                return (int) ($assessmentMonthly[$month] ?? 0);
            })->values(),
        ];

        $medicalServices = [
            'Consultation', 'Wound Dressing', 'Blood Pressure', 'Provision of Comfort',
            'OTC Medicine', 'Physical Assessment', 'Other Concerns',
            'Issuance of Certificate', 'Referral',
        ];
        $medicalServiceCounts = collect($medicalServices)->map(function ($service) use ($medicalBase) {
            return (clone $medicalBase)->whereJsonContains('purpose', $service)->count();
        });

        $dentalServices = ['Consultation', 'Oral Restoration', 'Oral Prophylaxis', 'Tooth Extraction'];
        $dentalServiceCounts = collect($dentalServices)->map(function ($service) use ($dentalBase) {
            return (clone $dentalBase)->whereJsonContains('remarks', $service)->count();
        });

        $appointmentStatuses = (clone $appointmentBase)
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->orderByDesc('total')
            ->get();

        $roleCounts = collect(['Student' => 0, 'Employee' => 0, 'Dependent' => 0]);
        foreach ([(clone $medicalBase), (clone $dentalBase)] as $query) {
            $query->select('role', DB::raw('COUNT(*) as total'))
                ->groupBy('role')
                ->get()
                ->each(function ($row) use ($roleCounts) {
                    $role = $row->role ?: 'Unknown';
                    $roleCounts[$role] = (int) ($roleCounts->get($role, 0) + $row->total);
                });
        }

        $availableYears = collect(range($currentYear, 2023));

        $kpis = [
            'encounters' => $medicalCount + $dentalCount,
            'patients' => $uniquePatients,
            'appointments' => $appointmentCount,
            'assessments' => $assessmentCount,
            'completion_rate' => $appointmentCount > 0
                ? round(($completedAppointments / $appointmentCount) * 100, 1)
                : 0,
        ];

        return view('pages.clinic-analytics-dashboard', compact(
            'pageConfigs', 'breadcrumbs', 'year', 'availableYears', 'kpis', 'trend',
            'medicalServices', 'medicalServiceCounts', 'dentalServices',
            'dentalServiceCounts', 'appointmentStatuses', 'roleCounts'
        ));
    }
}
