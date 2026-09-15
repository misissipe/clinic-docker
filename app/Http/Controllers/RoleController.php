<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public const WORKSPACE_ROLES = [
        'Admin',
        'Nurse',
        'Nurse Attendant',
        'Attendant',
        'Dentist',
        'Doctor',
    ];

    public const WORKSPACE_DETAILS = [
        'Admin' => [
            'name' => 'Administrator',
            'description' => 'Full access',
            'initials' => 'A',
        ],
        'Nurse' => [
            'name' => 'Nurse',
            'description' => 'Medical access',
            'initials' => 'N',
        ],
        'Nurse Attendant' => [
            'name' => 'Nurse Attendant',
            'description' => 'Medical support',
            'initials' => 'NA',
        ],
        'Attendant' => [
            'name' => 'Dental Attendant',
            'description' => 'Dental support',
            'initials' => 'DA',
        ],
        'Dentist' => [
            'name' => 'Dentist',
            'description' => 'Dental access',
            'initials' => 'D',
        ],
        'Doctor' => [
            'name' => 'Doctor',
            'description' => 'Clinical access',
            'initials' => 'DR',
        ],
    ];

    public static function administratorWorkspaces($campus = 1)
    {
        return collect(self::WORKSPACE_ROLES)
            ->map(function ($role) use ($campus) {
                return [
                    'role' => $role,
                    'campus' => $campus,
                    'access_start' => null,
                    'access_end' => null,
                    'unlimited_access' => true,
                ];
            })
            ->all();
    }

    public static function canonicalWorkspaceRole($role)
    {
        $role = trim((string) $role);

        $aliases = [
            'nurse attendance' => 'Nurse Attendant',
            'dental attendant' => 'Attendant',
            'dental attendance' => 'Attendant',
        ];

        $normalizedRole = strtolower($role);
        if (isset($aliases[$normalizedRole])) {
            return $aliases[$normalizedRole];
        }

        foreach (self::WORKSPACE_ROLES as $workspaceRole) {
            if (strcasecmp($workspaceRole, $role) === 0) {
                return $workspaceRole;
            }
        }

        return null;
    }

    public static function accountRoles($value)
    {
        if (is_array($value)) {
            $roles = $value;
        } else {
            $decoded = json_decode((string) $value, true);
            $roles = is_array($decoded) ? $decoded : explode(',', (string) $value);
        }

        return collect($roles)
            ->map(function ($role) {
                return self::canonicalWorkspaceRole($role);
            })
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    public static function assignedWorkspaces($accounts, Carbon $today)
    {
        return collect($accounts)
            ->filter(function ($account) use ($today) {
                $roles = self::accountRoles($account->role ?? null);
                $startsOn = isset($account->access_start)
                    ? Carbon::parse($account->access_start, 'Asia/Manila')->startOfDay()
                    : null;
                $endsOn = isset($account->access_end)
                    ? Carbon::parse($account->access_end, 'Asia/Manila')->endOfDay()
                    : null;

                return !empty($roles)
                    && (!$startsOn || $startsOn->lte($today))
                    && (!$endsOn || $endsOn->gte($today));
            })
            ->flatMap(function ($account) {
                return collect(self::accountRoles($account->role))->map(function ($role) use ($account) {
                    return [
                        'role' => $role,
                        'campus' => $account->campus,
                        'access_start' => $account->access_start ?? null,
                        'access_end' => $account->access_end ?? null,
                        'unlimited_access' => false,
                    ];
                });
            })
            ->unique(function ($workspace) {
                return $workspace['role'].'|'.$workspace['campus'];
            })
            ->values()
            ->all();
    }

    public function index()
    {
        $workspaces = session('available_workspaces', []);

        if (empty($workspaces) || empty(session('employee_id'))) {
            return redirect('/login');
        }

        return view('pages.choose-workspace', [
            'workspaces' => $workspaces,
            'workspaceDetails' => self::WORKSPACE_DETAILS,
        ]);
    }

    public function select(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'workspace' => ['required', 'integer'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('workspace.choose')
                ->withErrors($validator);
        }

        $workspaces = session('available_workspaces', []);
        $workspace = $workspaces[$request->input('workspace')] ?? null;

        $role = $workspace ? self::canonicalWorkspaceRole($workspace['role'] ?? null) : null;

        if (!$workspace || !$role) {
            return redirect()->route('workspace.choose')
                ->withErrors(['workspace' => 'That workspace is not available for your account.']);
        }

        session([
            'role' => $role,
            'campus' => $workspace['campus'],
            'access_start' => $workspace['access_start'] ?? null,
            'access_end' => $workspace['access_end'] ?? null,
            'unlimited_access' => $workspace['unlimited_access'] ?? false,
        ]);

        return redirect('/');
    }
}
