@extends('layouts.contentLayoutMaster')
@section('title', 'Clinic Accounts')

@section('content')
<style>
  .account-shell{max-width:1050px;margin:0 auto}.account-card{background:#fff;border:1px solid #e2e8f2;border-radius:14px;box-shadow:0 14px 35px rgba(35,62,99,.08);overflow:hidden}.account-head{padding:24px 28px;background:linear-gradient(135deg,#4e83d7,#76a2e3);color:#fff}.account-head h3{margin:0;color:#fff}.account-head p{margin:5px 0 0;color:rgba(255,255,255,.82)}.account-body{padding:26px}.employee-search{position:relative;margin-bottom:24px}.employee-search .form-control{height:48px;border-color:#3978ee;border-radius:9px;padding:0 44px 0 14px;box-shadow:0 0 0 1px rgba(57,120,238,.08)}.search-icon{position:absolute;right:15px;top:14px;color:#3978ee;font-size:20px}.search-results{display:none;position:absolute;z-index:30;top:54px;left:0;width:100%;max-height:310px;overflow-y:auto;background:#fff;border:1px solid #cfd9e8;border-radius:8px;box-shadow:0 12px 26px rgba(35,62,99,.16)}.search-results.is-open{display:block}.search-option{display:block;padding:12px 14px;color:#263f61;border-bottom:1px solid #edf0f5}.search-option:last-child{border-bottom:0}.search-option:hover,.search-option:focus{background:#f2f6ff;color:#245fbd}.search-option-name{display:block;font-weight:700}.search-option-meta{display:block;margin-top:2px;color:#8391a5;font-size:11px}.search-message{padding:14px;color:#8391a5;font-size:12px}.employee-table th{color:#607795;font-size:11px;text-transform:uppercase}.employee-name{color:#263f61;font-weight:700}.employee-meta{display:block;color:#8897aa;font-size:11px}.role-badge{display:inline-block;padding:5px 9px;border-radius:14px;background:#eaf2ff;color:#3269b7;font-size:11px;font-weight:700}.not-registered{color:#9aa7b7;font-size:12px}.empty-result{padding:40px;text-align:center;color:#8391a5}@media(max-width:600px){.account-body{padding:18px}}
</style>

<div class="account-shell">
  <div class="account-card">
    <div class="account-head">
      <h3>Clinic Accounts</h3>
      <p>Search for an employee before registering or managing their clinic role.</p>
    </div>
    <div class="account-body">
      <div class="employee-search">
        <input type="search" id="employee-search" class="form-control" placeholder="Type an employee name, ID, or email" autocomplete="off" autofocus aria-label="Search employees" aria-controls="employee-search-results" aria-expanded="false">
        <i class="bx bx-search search-icon" aria-hidden="true"></i>
        <div id="employee-search-results" class="search-results" role="listbox"></div>
      </div>

      <div class="table-responsive">
        <table class="table employee-table">
          <thead><tr><th>Employee</th><th>Email</th><th>Clinic Role</th><th class="text-right">Action</th></tr></thead>
          <tbody>
          @forelse($employees as $employee)
            <tr>
              <td>
                <a class="employee-name" href="{{ route('clinic-accounts.manage', $employee->id) }}">{{ trim($employee->FirstName.' '.$employee->MiddleName.' '.$employee->LastName) }}</a>
                <span class="employee-meta">Employee ID: {{ $employee->AgencyNumber }}</span>
              </td>
              <td>{{ $employee->EmailAddress ?: 'No email recorded' }}</td>
              <td>
                @if($employee->clinic_role)<span class="role-badge">{{ $employee->clinic_role }}</span>
                @else<span class="not-registered">Not registered</span>@endif
              </td>
              <td class="text-right">
                <a href="{{ route('clinic-accounts.manage', $employee->id) }}" class="btn btn-sm btn-outline-primary">
                  {{ $employee->clinic_role ? 'Manage Role' : 'Select' }}
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="empty-result">
                {{ $search === '' ? 'Search for an employee to view account details.' : 'No employees found.' }}
              </td>
            </tr>
          @endforelse
          </tbody>
        </table>
      </div>

      <div class="d-flex justify-content-center mt-2">{{ $employees->links() }}</div>
    </div>
  </div>
</div>
@endsection

@section('page-scripts')
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
