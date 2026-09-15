@extends('layouts.contentLayoutMaster')
@section('title', 'Clinic Accounts')

@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/tables/datatable/datatables.min.css') }}">
@endsection

@section('content')
<style>
  .clinic-account-card {
    margin-bottom: 24px;
    background: #fff;
    border-radius: 4px;
    box-shadow: 0 8px 20px rgba(35, 62, 99, 0.12);
  }

  .clinic-account-body {
    padding: 24px 26px;
  }

  .account-toolbar,
  .table-controls,
  .table-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
  }

  .account-toolbar {
    justify-content: flex-end;
  }

  .employee-search {
    position: relative;
    width: 310px;
  }

  .employee-search .form-control {
    height: 40px;
    padding-right: 48px;
    border-color: #5a8dee;
    border-radius: 4px;
  }

  .search-button {
    position: absolute;
    top: 0;
    right: 0;
    width: 48px;
    height: 40px;
    padding: 0;
    color: #fff;
    background: #5a8dee;
    border: 0;
    border-radius: 0 4px 4px 0;
    font-size: 20px;
  }

  .search-results {
    display: none;
    position: absolute;
    z-index: 30;
    top: 45px;
    left: 0;
    width: 100%;
    max-height: 310px;
    overflow-y: auto;
    background: #fff;
    border: 1px solid #cfd9e8;
    border-radius: 4px;
    box-shadow: 0 12px 26px rgba(35, 62, 99, 0.16);
  }

  .search-results.is-open { display: block; }
  .search-option { display: block; padding: 12px 14px; color: #263f61; border-bottom: 1px solid #edf0f5; }
  .search-option:last-child { border-bottom: 0; }
  .search-option:hover, .search-option:focus { color: #245fbd; background: #f2f6ff; }
  .search-option-name { display: block; font-weight: 600; }
  .search-option-meta, .search-message { color: #8391a5; font-size: 11px; }
  .search-option-meta { display: block; margin-top: 2px; }
  .search-message { padding: 14px; }

  .dataTables_wrapper {
    margin-top: 28px;
  }

  .dataTables_wrapper .dataTables_length,
  .dataTables_wrapper .dataTables_filter {
    color: #405b7e;
    font-size: 12px;
    text-transform: uppercase;
  }

  .table-controls {
    margin: 28px 0 12px;
    color: #405b7e;
    font-size: 12px;
    text-transform: uppercase;
  }

  .table-controls select {
    width: 56px;
    height: 34px;
    margin: 0 5px;
    color: #526d90;
    border: 1px solid #d5deea;
    border-radius: 4px;
  }

  .account-table {
    min-width: 980px;
    margin-bottom: 0;
    color: #687b94;
    border: 1px solid #d9e1ec;
  }

  .account-table thead th {
    padding: 8px 10px;
    color: #fff;
    background: #6e9bde;
    border-color: #d9e1ec;
    font-size: 12px;
    font-weight: 600;
    text-align: center;
    text-transform: uppercase;
  }

  .account-table tbody tr:nth-child(odd) { background: #f7f7f7; }
  .account-table tbody tr:nth-child(even) { background: #fff; }

  .account-table td {
    padding: 13px 10px;
    vertical-align: middle;
    border-color: #d9e1ec;
  }

  .employee-id,
  .action-cell {
    text-align: center;
  }

  .employee-name {
    color: #566d8a;
    font-weight: 500;
  }

  .role-badge {
    display: inline-block;
    color: #3269b7;
    font-size: 12px;
    font-weight: 600;
  }

  .not-registered { color: #9aa7b7; font-size: 12px; }

  .manage-button {
    width: 38px;
    height: 34px;
    padding: 0;
    color: #486585;
    background: transparent;
    border: 0;
    font-size: 19px;
  }

  .manage-button:hover { color: #5a8dee; }
  .empty-result { padding: 40px !important; text-align: center; color: #8391a5; }

  .table-footer {
    margin-top: 14px;
    color: #687b94;
    font-size: 13px;
  }

  .table-footer .pagination { margin: 0; }

  @media (max-width: 700px) {
    .clinic-account-body { padding: 18px; }
    .account-toolbar { align-items: stretch; flex-direction: column; }
    .employee-search { width: 100%; }
    .table-footer { align-items: flex-start; flex-direction: column; }
  }
</style>

<div class="clinic-account-card">
  <div class="clinic-account-body">
    <div class="account-toolbar">
      <div class="employee-search">
        <input
          type="search"
          id="employee-search"
          class="form-control"
          placeholder="Search employee"
          autocomplete="off"
          autofocus
          aria-label="Search employees"
          aria-controls="employee-search-results"
          aria-expanded="false"
        >
        <button class="search-button" type="button" aria-label="Search">
          <i class="bx bx-search" aria-hidden="true"></i>
        </button>
        <div id="employee-search-results" class="search-results" role="listbox"></div>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered table-striped zero-configuration account-table">
        <thead>
          <tr>
            <th>Employee ID</th>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Email</th>
            <th>Clinic Role</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        @forelse($employees as $employee)
          <tr>
            <td class="employee-id">{{ $employee->AgencyNumber }}</td>
            <td>{{ $employee->LastName }}</td>
            <td>{{ $employee->FirstName }}</td>
            <td>{{ $employee->MiddleName ?: '—' }}</td>
            <td>{{ $employee->EmailAddress ?: 'No email recorded' }}</td>
            <td>
              @if($employee->clinic_role)
                <span class="role-badge">{{ implode(', ', \App\Http\Controllers\RoleController::accountRoles($employee->clinic_role)) }}</span>
              @else
                <span class="not-registered">Not registered</span>
              @endif
            </td>
            <td class="action-cell">
              <a
                href="{{ route('clinic-accounts.manage', $employee->id) }}"
                class="manage-button"
                aria-label="{{ $employee->clinic_role ? 'Manage roles' : 'Register account' }} for {{ $employee->FirstName }} {{ $employee->LastName }}"
                title="{{ $employee->clinic_role ? 'Manage roles' : 'Register account' }}"
              >
                <i class="bx bx-folder-open" aria-hidden="true"></i>
              </a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="empty-result">
              {{ $search === '' ? 'No active clinic accounts found for this campus.' : 'No employees found.' }}
            </td>
          </tr>
        @endforelse
        </tbody>
      </table>
    </div>

  </div>
</div>
@endsection

@section('vendor-scripts')
<script src="{{ asset('vendors/js/tables/datatable/datatables.min.js') }}"></script>
<script src="{{ asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js') }}"></script>
@endsection

@section('page-scripts')
<script src="{{ asset('js/scripts/datatables/datatable.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  var input = document.getElementById('employee-search');
  var results = document.getElementById('employee-search-results');
  var timer;

  function hideResults() {
    results.classList.remove('is-open');
    input.setAttribute('aria-expanded', 'false');
  }

  function showMessage(message) {
    results.innerHTML = '<div class="search-message">' + message + '</div>';
    results.classList.add('is-open');
    input.setAttribute('aria-expanded', 'true');
  }

  input.addEventListener('input', function () {
    clearTimeout(timer);
    var query = input.value.trim();
    if (!query) {
      hideResults();
      results.innerHTML = '';
      return;
    }

    showMessage('Searching...');
    timer = setTimeout(function () {
      fetch(@json(route('clinic-accounts.search')) + '?q=' + encodeURIComponent(query), {
        headers: {'Accept': 'application/json'}
      })
        .then(function (response) { return response.json(); })
        .then(function (employees) {
          results.innerHTML = '';
          if (!employees.length) {
            showMessage('No records found.');
            return;
          }
          employees.forEach(function (employee) {
            var option = document.createElement('a');
            option.className = 'search-option';
            option.href = employee.url;
            option.setAttribute('role', 'option');
            var name = document.createElement('span');
            name.className = 'search-option-name';
            name.textContent = employee.name;
            var meta = document.createElement('span');
            meta.className = 'search-option-meta';
            meta.textContent = 'Employee ID: ' + employee.employee_id + (employee.email ? ' · ' + employee.email : '');
            option.appendChild(name);
            option.appendChild(meta);
            results.appendChild(option);
          });
          results.classList.add('is-open');
          input.setAttribute('aria-expanded', 'true');
        })
        .catch(function () { showMessage('Unable to search employees. Please try again.'); });
    }, 250);
  });

  document.addEventListener('click', function (event) {
    if (!event.target.closest('.employee-search')) hideResults();
  });
});
</script>
@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function () {
  Swal.fire({ icon: 'success', title: 'Successfully Saved', text: @json(session('success')), timer: 3000, showConfirmButton: false });
});
</script>
@endif
@endsection
