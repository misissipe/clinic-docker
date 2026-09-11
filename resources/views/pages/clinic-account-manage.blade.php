@extends('layouts.contentLayoutMaster')
@section('title', $account ? 'Manage Clinic Role' : 'Register Clinic Account')

@section('content')
<style>
  .access-shell{max-width:1100px;margin:0 auto 35px}.access-card{padding:48px 56px;background:#fff;border:1px solid #e5e9f0;border-radius:8px;box-shadow:0 10px 30px rgba(40,55,80,.06)}.access-brand{text-align:center;margin-bottom:34px}.access-brand img{width:78px;height:78px;object-fit:contain;margin-bottom:10px}.access-brand h3{margin:0;color:#303443;font-size:25px;font-weight:700}.access-brand p{margin:3px 0 0;color:#a6a9b1}.employee-fields{display:grid;grid-template-columns:1fr 1fr;gap:24px}.field-label{display:block;margin-bottom:7px;color:#3e4558;font-size:13px;font-weight:700}.readonly-field{height:44px;background:#fff!important;color:#555866}.access-summary{margin:30px 0 26px;color:#555866}.access-summary strong{display:block;margin-bottom:10px;color:#343b50;font-size:13px}.access-table-wrap{overflow-x:auto}.access-table-title{text-align:center;color:#3e4558;font-weight:700}.access-table{width:100%;margin-top:12px}.access-table th{padding:10px 20px;color:#555866;font-size:12px;font-weight:500;letter-spacing:1px;text-transform:uppercase}.access-table td{padding:11px 20px;color:#555866}.role-choice{display:flex;align-items:center;gap:16px;margin:0;cursor:pointer}.role-choice input,.campus-check{width:18px;height:18px;accent-color:#1760cf}.campus-cell{text-align:center}.period-card{margin-top:35px;padding:22px;border:1px solid #e0e3e8;border-radius:7px}.period-title{display:flex;align-items:center;gap:10px;margin-bottom:18px;color:#4b4e59;font-size:16px}.period-title i{font-size:20px}.period-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}.period-help{display:block;margin-top:6px;color:#aaadb5;font-size:12px}.access-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:28px}.access-actions .btn{min-width:150px}@media(max-width:650px){.access-card{padding:25px 20px}.employee-fields,.period-grid{grid-template-columns:1fr}.access-table th,.access-table td{padding:10px}.access-actions .btn{flex:1}}
</style>

@php
  $campusNames = [1 => 'SG', 4 => 'BN', 3 => 'TO', 5 => 'SJ', 6 => 'HN', 2 => 'MCC'];
  $selectedCampuses = array_map('intval', old('campuses', $accountCampusIds ?? [(int) session('campus')]));
  $selectedRole = old('role', $account->role ?? '');
@endphp

<div class="access-shell"><div class="access-card">
  <div class="access-brand">
    <img src="{{ asset('images/logo/SLSU Logo.png') }}" alt="Southern Leyte State University">
    <h3>Clinic Account Management</h3>
    <p>Register and manage account roles</p>
  </div>

  <form method="POST" action="{{ route('clinic-accounts.save', $employeeRecord->id) }}">
    @csrf
    <div class="employee-fields">
      <div><label class="field-label">Name</label><input class="form-control readonly-field" value="{{ trim($employeeRecord->FirstName.' '.$employeeRecord->MiddleName.' '.$employeeRecord->LastName) }}" readonly></div>
      <div><label class="field-label">Email</label><input class="form-control readonly-field" value="{{ $employeeRecord->EmailAddress }}" readonly></div>
    </div>

    <div class="access-summary">
      <strong>Campus Access</strong>
      <span id="campusAccessSummary">{{ collect($campusNames)->only($selectedCampuses)->keys()->isNotEmpty() ? collect($campusNames)->only($selectedCampuses)->implode(', ') : 'No campus selected' }}</span> | <span id="roleAccessSummary">{{ $selectedRole ?: 'No clinic role selected' }}</span>
    </div>

    <div class="access-table-wrap">
    <div class="access-table-title">Account and Campus Access</div>
    <table class="access-table">
      <thead><tr><th>Account Role</th>@foreach($campusNames as $campusName)<th class="campus-cell">{{ $campusName }}</th>@endforeach</tr></thead>
      <tbody>
      @foreach($roles as $role)
        <tr>
          <td><label class="role-choice"><input type="radio" name="role" value="{{ $role }}" {{ $selectedRole === $role ? 'checked' : '' }} required><span>{{ $role }}</span></label></td>
          @foreach($campusNames as $campusId => $campusName)
            <td class="campus-cell"><input class="campus-check" type="checkbox" name="campuses[]" value="{{ $campusId }}" data-campus-name="{{ $campusName }}" {{ $selectedRole === $role && in_array($campusId, $selectedCampuses, true) ? 'checked' : '' }} {{ $selectedRole === $role ? '' : 'disabled' }} aria-label="{{ $campusName }} access for {{ $role }}"></td>
          @endforeach
        </tr>
      @endforeach
      </tbody>
    </table>
    </div>
    @error('role')<div class="text-danger mt-1">{{ $message }}</div>@enderror
    @error('campuses')<div class="text-danger mt-1">{{ $message }}</div>@enderror

    @if($supportsAccessPeriod)
    <div class="period-card">
      <div class="period-title"><i class="bx bx-calendar-check"></i> Set Account Access Period</div>
      <div class="period-grid">
        <div><label class="field-label" for="access_start">Start Date</label><input type="date" id="access_start" name="access_start" class="form-control" value="{{ old('access_start', $account->access_start ?? '') }}">@error('access_start')<div class="text-danger mt-1">{{ $message }}</div>@enderror</div>
        <div><label class="field-label" for="access_end">End Date</label><input type="date" id="access_end" name="access_end" class="form-control" value="{{ old('access_end', $account->access_end ?? '') }}"><span class="period-help">Leave blank to allow indefinite access.</span>@error('access_end')<div class="text-danger mt-1">{{ $message }}</div>@enderror</div>
      </div>
    </div>
    @endif

    <div class="access-actions"><a href="{{ route('clinic-accounts.index') }}" class="btn btn-light">Cancel</a><button type="submit" class="btn btn-primary">{{ $account ? 'Update Account' : 'Register Account' }}</button></div>
  </form>
</div></div>
@endsection

@section('page-scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  var roleInputs = document.querySelectorAll('input[name="role"]');
  var roleSummary = document.getElementById('roleAccessSummary');
  var campusSummary = document.getElementById('campusAccessSummary');

  function refreshSummary() {
    var selectedRole = document.querySelector('input[name="role"]:checked');
    var selectedCampuses = document.querySelectorAll('.campus-check:checked:not(:disabled)');
    roleSummary.textContent = selectedRole ? selectedRole.value : 'No clinic role selected';
    campusSummary.textContent = selectedCampuses.length
      ? Array.prototype.map.call(selectedCampuses, function (input) { return input.dataset.campusName; }).join(', ')
      : 'No campus selected';
  }

  roleInputs.forEach(function (roleInput) {
    roleInput.addEventListener('change', function () {
      var selectedCampusValues = Array.prototype.map.call(
        document.querySelectorAll('.campus-check:checked'),
        function (input) { return input.value; }
      );

      document.querySelectorAll('.campus-check').forEach(function (checkbox) {
        var belongsToSelectedRole = checkbox.closest('tr').contains(roleInput);
        checkbox.disabled = !belongsToSelectedRole;
        checkbox.checked = belongsToSelectedRole && selectedCampusValues.indexOf(checkbox.value) !== -1;
      });
      refreshSummary();
    });
  });

  document.querySelectorAll('.campus-check').forEach(function (checkbox) {
    checkbox.addEventListener('change', refreshSummary);
  });
  refreshSummary();
});
</script>
@endsection
