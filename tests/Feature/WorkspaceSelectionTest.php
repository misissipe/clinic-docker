<?php

namespace Tests\Feature;

use App\Http\Controllers\RoleController;
use Carbon\Carbon;
use Tests\TestCase;

class WorkspaceSelectionTest extends TestCase
{
    public function test_administrator_is_given_every_clinic_workspace()
    {
        $workspaces = RoleController::administratorWorkspaces(1);

        $this->assertSame(RoleController::WORKSPACE_ROLES, array_column($workspaces, 'role'));
        $this->assertSame([1, 1, 1, 1, 1, 1], array_column($workspaces, 'campus'));
    }

    public function test_only_database_assigned_roles_become_workspaces()
    {
        $nurseOnly = RoleController::assignedWorkspaces([
            (object) ['role' => 'Nurse', 'campus' => 1],
        ], Carbon::parse('2026-09-14'));

        $this->assertSame(['Nurse'], array_column($nurseOnly, 'role'));

        $nurseAndAttendant = RoleController::assignedWorkspaces([
            (object) ['role' => 'Nurse', 'campus' => 1],
            (object) ['role' => 'Nurse Attendant', 'campus' => 1],
        ], Carbon::parse('2026-09-14'));

        $this->assertSame(['Nurse', 'Nurse Attendant'], array_column($nurseAndAttendant, 'role'));
    }

    public function test_role_array_in_one_account_row_becomes_multiple_workspaces()
    {
        $workspaces = RoleController::assignedWorkspaces([
            (object) [
                'role' => json_encode(['Nurse', 'Doctor']),
                'campus' => 1,
                'access_start' => '2026-09-01',
                'access_end' => '2027-08-31',
            ],
        ], Carbon::parse('2026-09-14'));

        $this->assertSame(['Nurse', 'Doctor'], array_column($workspaces, 'role'));
        $this->assertSame([1, 1], array_column($workspaces, 'campus'));
    }

    public function test_assignment_starting_today_is_available_in_manila_timezone()
    {
        $workspaces = RoleController::assignedWorkspaces([
            (object) [
                'role' => 'Nurse',
                'campus' => 1,
                'access_start' => '2026-09-14',
                'access_end' => '2026-09-17',
            ],
        ], Carbon::create(2026, 9, 14, 0, 0, 0, 'Asia/Manila'));

        $this->assertSame(['Nurse'], array_column($workspaces, 'role'));
    }

    public function test_workspace_page_requires_a_pending_login()
    {
        $this->get('/choose-workspace')->assertRedirect('/login');
    }

    public function test_user_can_select_an_assigned_workspace()
    {
        $response = $this->withSession([
            'employee_id' => 42,
            'name' => 'Juan Dela Cruz',
            'available_workspaces' => [
                ['role' => 'Nurse', 'campus' => 1],
                ['role' => 'Doctor', 'campus' => 2],
            ],
        ])->post('/choose-workspace', ['workspace' => 1]);

        $response->assertRedirect('/');
        $response->assertSessionHas('role', 'Doctor');
        $response->assertSessionHas('campus', 2);
        $response->assertSessionHas('available_workspaces');
    }

    public function test_non_admin_role_is_normalized_when_selected()
    {
        $response = $this->withSession([
            'employee_id' => 42,
            'available_workspaces' => [
                ['role' => ' nurse ', 'campus' => 1],
            ],
        ])->post('/choose-workspace', ['workspace' => 0]);

        $response->assertRedirect('/');
        $response->assertSessionHas('role', 'Nurse');
        $response->assertSessionHas('campus', 1);
    }

    public function test_legacy_attendant_role_names_are_supported()
    {
        $this->assertSame(
            'Nurse Attendant',
            RoleController::canonicalWorkspaceRole('Nurse Attendance')
        );
        $this->assertSame(
            'Attendant',
            RoleController::canonicalWorkspaceRole('Dental Attendant')
        );
    }

    public function test_dashboard_logout_returns_user_to_workspace_selection()
    {
        $response = $this->withSession([
            'employee_id' => 42,
            'name' => 'Juan Dela Cruz',
            'role' => 'Nurse',
            'campus' => 1,
            'available_workspaces' => [
                ['role' => 'Admin', 'campus' => 1],
                ['role' => 'Nurse', 'campus' => 1],
            ],
        ])->get('/logout');

        $response->assertRedirect('/choose-workspace');
        $response->assertSessionMissing('role');
        $response->assertSessionMissing('campus');
        $response->assertSessionHas('available_workspaces');
        $response->assertSessionHas('employee_id', 42);
    }

    public function test_sign_out_from_workspace_selector_ends_the_login_session()
    {
        $response = $this->withSession([
            'employee_id' => 42,
            'available_workspaces' => [
                ['role' => 'Admin', 'campus' => 1],
            ],
        ])->get('/choose-workspace/sign-out');

        $response->assertRedirect('/login');
        $response->assertSessionMissing('employee_id');
        $response->assertSessionMissing('available_workspaces');
    }

    public function test_all_clinic_workspace_labels_are_rendered()
    {
        $workspaces = collect(['Admin', 'Nurse', 'Nurse Attendant', 'Attendant', 'Dentist', 'Doctor'])
            ->map(function ($role) {
                return ['role' => $role, 'campus' => 1];
            })
            ->all();

        $response = $this->withSession([
            'employee_id' => 42,
            'name' => 'Juan Dela Cruz',
            'available_workspaces' => $workspaces,
        ])->get('/choose-workspace');

        $response->assertOk();
        $response->assertSeeText('Administrator');
        $response->assertSeeText('Nurse');
        $response->assertSeeText('Nurse Attendant');
        $response->assertSeeText('Dental Attendant');
        $response->assertSeeText('Dentist');
        $response->assertSeeText('Doctor');
    }

    public function test_user_cannot_select_an_unassigned_workspace()
    {
        $response = $this->withSession([
            'employee_id' => 42,
            'available_workspaces' => [
                ['role' => 'Nurse', 'campus' => 1],
            ],
        ])->post('/choose-workspace', ['workspace' => 9]);

        $response->assertRedirect('/choose-workspace');
        $response->assertSessionMissing('role');
        $response->assertSessionHasErrors('workspace');
    }
}
