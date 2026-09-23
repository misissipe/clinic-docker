<aside class="card monitoring-history" aria-labelledby="monitoringHistoryHeading">
  <header class="monitoring-history-heading">
    <h3 id="monitoringHistoryHeading">Previous Consultations</h3>
    <p>{{ trim(($name->FirstName ?? '') . ' ' . ($name->MiddleName ?? '') . ' ' . ($name->LastName ?? '')) }}</p>
  </header>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-sm recordTable table-bordered table-striped" id="recordTable">
        <thead><tr><th>Date</th><th>Purpose</th><th>Findings</th><th>Parameters</th><th>Treatment</th></tr></thead>
        <tbody id="viewAllRecord">
          @foreach ($view as $data)
            <tr>
              <td data-order="{{ $data->date }}">{{ date('m-d-Y', strtotime($data->date)) }}</td>
              <td>{{ implode(', ', json_decode($data->purpose, true) ?: []) }}</td>
              <td class="history-note">{{ $data->findings ?: '—' }}</td>
              <td class="history-parameters">
                @if ($data->parameters)
                  {!! $data->parameters !!}
                @else
                  <div>W: {{ $data->weight ?: '—' }}</div>
                  <div>H: {{ $data->height ?: '—' }}</div>
                  <div>B-Type: {{ $data->blood_type ?: '—' }}</div>
                  <div>Temp: {{ $data->temp ?: '—' }}</div>
                  <div>Pulse: {{ $data->pulse ?: '—' }}</div>
                  <div>Res Rate: {{ $data->res_rate ?: '—' }}</div>
                  <div>BP: {{ $data->bp ?: '—' }}</div>
                @endif
              </td>
              <td class="history-note">{{ $data->recommendation ?: '—' }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</aside>
