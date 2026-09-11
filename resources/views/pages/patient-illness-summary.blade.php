@extends('layouts.contentLayoutMaster')
@section('title', 'Patient Illness Summary')

@section('content')
<style>
  .illness-layout{display:grid;grid-template-columns:236px minmax(0,1fr);gap:30px;align-items:start}.illness-sidebar{display:grid;gap:32px}.filter-card,.total-card,.table-card{background:#fff;border-radius:5px;box-shadow:0 8px 24px rgba(40,55,80,.10)}.filter-card{padding:26px}.filter-card label{display:block;margin-bottom:7px;color:#343b50;font-size:12px;text-transform:uppercase}.filter-card .form-control{height:39px;border-color:#d6dce5}.filter-card .btn{display:block;min-width:92px;margin:20px auto 0}.total-card{padding:26px 15px;text-align:center;color:#405a7d}.total-label{font-size:19px;text-transform:uppercase}.total-number{margin-top:4px;font-size:34px;font-weight:700}.table-card{padding:40px 25px 26px}.table-controls{display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;color:#405a7d;font-size:12px;text-transform:uppercase}.entries-control,.search-control{display:flex;align-items:center;gap:6px}.entries-control select{width:54px;height:32px}.search-control input{width:150px;height:32px}.illness-table{width:100%;min-width:1050px;margin:0;border-collapse:collapse}.illness-table th,.illness-table td{padding:8px 9px;border:1px solid #d8dde5}.illness-table th{color:#405a7d;font-size:11px;letter-spacing:.5px;text-align:center;text-transform:uppercase}.illness-table td{color:#718096;font-weight:600}.illness-name{min-width:165px}.month-count,.illness-count{text-align:center;min-width:54px}.illness-count{font-weight:700!important}.empty-summary{padding:42px!important;text-align:center;font-weight:400!important}.table-footer{display:flex;justify-content:space-between;align-items:center;margin-top:15px;color:#718096}.table-footer .pagination{margin:0}@media(max-width:850px){.illness-layout{grid-template-columns:1fr}.illness-sidebar{grid-template-columns:1fr 1fr}.table-card{padding:25px 15px}}@media(max-width:560px){.illness-sidebar{grid-template-columns:1fr}.table-controls,.table-footer{align-items:flex-start;flex-direction:column;gap:12px}.search-control input{width:190px}}
</style>

<div class="illness-layout">
  <aside class="illness-sidebar">
    <form method="GET" action="{{ route('patient-illness-summary') }}" class="filter-card">
      <label for="illness-year">Year:</label>
      <select id="illness-year" name="year" class="form-control @error('year') is-invalid @enderror" required>
        <option value="">-Select-</option>
        @foreach($years as $year)
          <option value="{{ $year }}" {{ (string) $selectedYear === (string) $year ? 'selected' : '' }}>{{ $year }}</option>
        @endforeach
      </select>
      @error('year')<div class="invalid-feedback">{{ $message }}</div>@enderror
      <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <div class="total-card">
      <div class="total-label">Over-All Total</div>
      <div class="total-number">{{ number_format($totalRecords) }}</div>
    </div>
  </aside>

  <section class="table-card">
    <form method="GET" action="{{ route('patient-illness-summary') }}" id="table-filter-form" class="table-controls">
      <input type="hidden" name="year" value="{{ $selectedYear }}">
      <div class="entries-control">
        <label for="per-page">Show</label>
        <select id="per-page" name="per_page" class="form-control" {{ !$selectedYear ? 'disabled' : '' }} onchange="this.form.submit()">
          @foreach([10, 25, 50, 100] as $size)<option value="{{ $size }}" {{ $perPage === $size ? 'selected' : '' }}>{{ $size }}</option>@endforeach
        </select>
        <span>Entries</span>
      </div>
      <div class="search-control">
        <label for="table-search">Search:</label>
        <input id="table-search" type="search" name="search" value="{{ $tableSearch }}" class="form-control" {{ !$selectedYear ? 'disabled' : '' }}>
      </div>
    </form>

    <div class="table-responsive">
      <table class="illness-table">
        <thead><tr><th class="illness-name">Illness</th>@foreach(['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'] as $month)<th class="month-count">{{ $month }}</th>@endforeach<th class="illness-count">Total</th></tr></thead>
        <tbody>
          @if(!$selectedYear)
            <tr><td colspan="14" class="empty-summary">Select a year to view the illness summary.</td></tr>
          @else
            @forelse($illnesses as $illness)
              <tr><td class="illness-name">{{ $illness->illness }}</td>@for($month = 1; $month <= 12; $month++)<td class="month-count">{{ number_format($illness->months[$month]) }}</td>@endfor<td class="illness-count">{{ number_format($illness->total) }}</td></tr>
            @empty
              <tr><td colspan="14" class="empty-summary">No illness records found for {{ $selectedYear }}.</td></tr>
            @endforelse
          @endif
        </tbody>
      </table>
    </div>

    @if($illnesses)
      <div class="table-footer">
        <span>Showing {{ $illnesses->firstItem() ?: 0 }} to {{ $illnesses->lastItem() ?: 0 }} of {{ $illnesses->total() }} entries</span>
        <span>{{ $illnesses->links() }}</span>
      </div>
    @endif
  </section>
</div>
@endsection

@section('page-scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  var search = document.getElementById('table-search');
  var timer;
  if (search) search.addEventListener('input', function () {
    clearTimeout(timer);
    timer = setTimeout(function () { document.getElementById('table-filter-form').submit(); }, 500);
  });
});
</script>
@endsection
