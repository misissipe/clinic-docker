@extends('layouts.contentLayoutMaster')
@section('title', $account ? 'Manage Clinic Account' : 'Register Clinic Account')

@section('page-styles')
<link rel="stylesheet" href="{{ asset('css/pages/clinic-account-manage.css') }}">
@endsection

@section('content')
@php
  $assignments = old('assignments', $roleAssignments);
  $roleDetails = \App\Http\Controllers\RoleController::WORKSPACE_DETAILS;
  $defaultCampus = (int) $employeeRecord->campus;
  $adminSelected = !empty($assignments['Admin']['selected']);
@endphp

<div class="account-page">
  <div class="account-card">
    <header class="account-header">
      {{-- <div class="header-icon"><i class="bx bx-shield-quarter"></i></div> --}}
      <div>
        <h1>Manage User Roles</h1>
        <p>Assign workspaces and set the user's access period.</p>
      </div>
      <a href="{{ route('clinic-accounts.index') }}" class="close-button" aria-label="Close">
        <i class="bx bx-x"></i>
      </a>
    </header>

    <form method="POST" action="{{ route('clinic-accounts.save', $employeeRecord->id) }}">
      @csrf

      <section class="user-panel">
        <div class="user-details">
          <div class="user-avatar">{{ strtoupper(substr($employeeRecord->FirstName, 0, 1)) }}</div>
          <div>
            <h2>{{ trim($employeeRecord->FirstName.' '.$employeeRecord->MiddleName.' '.$employeeRecord->LastName) }}</h2>
            <p>{{ $employeeRecord->EmailAddress }} · ID {{ $employeeRecord->AgencyNumber }}</p>
          </div>
        </div>

        @if($supportsAccessPeriod)
          <div class="account-dates">
            <div class="field-group">
              <label for="access_start">Account Start Date</label>
              <input
                id="access_start"
                name="access_start"
                type="date"
                class="form-control"
                value="{{ old('access_start', $account->access_start ?? '') }}"
                {{ $adminSelected ? 'disabled' : '' }}
              >
              @error('access_start')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div class="field-group">
              <label for="access_end">Account End Date</label>
              <input
                id="access_end"
                name="access_end"
                type="date"
                class="form-control"
                value="{{ old('access_end', $account->access_end ?? '') }}"
                {{ $adminSelected ? 'disabled' : '' }}
              >
              @error('access_end')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div id="unlimited-access" class="unlimited-access {{ $adminSelected ? '' : 'd-none' }}">
              <i class="bx bx-infinite"></i>
              <span>Administrator has unlimited access</span>
            </div>
          </div>
        @endif
      </section>

      <section class="roles-section">
        <div class="roles-heading">
          <div>
            <h2>Account Roles</h2>
            <p>Select one or more workspaces for this user.</p>
          </div>
          <div class="date-tip">
            <i class="bx bx-calendar-check"></i>
            <span>The account dates above apply to all selected roles.</span>
          </div>
        </div>

        <div class="roles-grid">
          @foreach($roles as $role)
            @php
              $assignment = $assignments[$role] ?? ['selected' => false, 'campuses' => []];
              $selected = !empty($assignment['selected']);
              $campuses = !empty($assignment['campuses'])
                ? $assignment['campuses']
                : [$defaultCampus];
              $detail = $roleDetails[$role];
            @endphp

            <label class="role-card {{ $selected ? 'selected' : '' }}">
              <input class="role-check" type="checkbox" name="assignments[{{ $role }}][selected]" value="1" {{ $selected ? 'checked' : '' }}>

              @foreach($campuses as $campus)
                <input class="campus-value" type="hidden" name="assignments[{{ $role }}][campuses][]" value="{{ $campus }}" {{ $selected ? '' : 'disabled' }}>
              @endforeach

              <span class="role-initials">{{ $detail['initials'] }}</span>
              <span class="role-name">{{ $detail['name'] }}</span>
              <span class="role-description">{{ $detail['description'] }}</span>
              <span class="role-state"> <i class="bx {{ $selected ? 'bx-check-circle' : 'bx-circle' }}"></i>
                <span>{{ $selected ? 'Selected' : 'Select role' }}</span>
              </span>
            </label>
          @endforeach
        </div>

        @error('assignments')<div class="form-error">{{ $message }}</div>@enderror
        @foreach($roles as $role)
          @error("assignments.{$role}.campuses")<div class="form-error">{{ $message }}</div>@enderror
        @endforeach
      </section>

      <footer class="account-footer">
        <div class="footer-note">
          <i class="bx bx-info-circle"></i>
          <span>At least one role must remain selected.</span>
        </div>
        <div class="account-actions">
          <a href="{{ route('clinic-accounts.index') }}" class="btn btn-light">Cancel</a>
          <button type="submit" class="btn btn-primary">
            {{ $account ? 'Update Account' : 'Register Account' }}
          </button>
        </div>
      </footer>
    </form>
  </div>
</div>
@endsection

@section('page-scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  var roleCheckboxes = document.querySelectorAll('.role-check');
  var adminCheckbox = document.querySelector('.role-check[name="assignments[Admin][selected]"]');
  var startDate = document.getElementById('access_start');
  var endDate = document.getElementById('access_end');
  var unlimitedMessage = document.getElementById('unlimited-access');

  function updateAccountDates() {
    if (!adminCheckbox || !startDate || !endDate) {
      return;
    }

    var unlimited = adminCheckbox.checked;
    startDate.disabled = unlimited;
    endDate.disabled = unlimited;
    unlimitedMessage.classList.toggle('d-none', !unlimited);
  }

  roleCheckboxes.forEach(function (checkbox) {
    checkbox.addEventListener('change', function () {
      var card = checkbox.closest('.role-card');
      var stateIcon = card.querySelector('.role-state i');
      var stateText = card.querySelector('.role-state span');

      card.classList.toggle('selected', checkbox.checked);
      stateIcon.className = checkbox.checked ? 'bx bx-check-circle' : 'bx bx-circle';
      stateText.textContent = checkbox.checked ? 'Selected' : 'Select role';

      card.querySelectorAll('.campus-value').forEach(function (input) {
        input.disabled = !checkbox.checked;
      });

      updateAccountDates();
    });
  });

  updateAccountDates();
});
</script>
@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function () {
  Swal.fire({
    icon: 'success',
    title: 'Successfully Saved',
    text: @json(session('success')),
    timer: 2500,
    showConfirmButton: false
  });
});
</script>
@endif
@endsection
