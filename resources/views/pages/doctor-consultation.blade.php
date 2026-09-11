@extends('layouts.contentLayoutMaster')
@section('title', 'Doctor Consultation')

@php
    $patientName = trim(
        ($patient->FirstName ?? '') . ' ' .
        ($patient->MiddleName ?? '') . ' ' .
        ($patient->LastName ?? '')
    );
    $purposes = json_decode($medical->purpose, true) ?: [];
    $patientAddress = implode(', ', array_filter([
        $patient->RBarangay ?? $patient->brgy ?? $patient->barangay ?? null,
        $patient->citymunDesc ?? $patient->city ?? $patient->municipality ?? null,
        $patient->provDesc ?? $patient->province ?? null,
    ]));
    $doctorName = 'Amiel Anthony P. Ansalae';
@endphp

@section('content')
<link rel="stylesheet" href="{{ asset('css/pages/doctor-consultation.css') }}">
<form method="POST"
      action="{{ route('medical.doctor-consultation.save', $medical->id) }}"
      id="consultationForm"
      class="consultation-flow">
  @csrf

  {{-- Step navigation --}}
  <div class="flow-tabs">
    <button type="button" class="flow-tab active" data-step="1">Consultation</button>
    <button type="button" class="flow-tab" data-step="2">Prescription</button>
    <button type="button" class="flow-tab" data-step="3">Preview</button>
  </div>

  <div class="flow-grid">
    @if ($errors->any())
      <div class="alert alert-danger validation-alert">
        Please enter Treatment/Recommendation and check the prescription quantities.
      </div>
    @endif

    {{-- STEP 1: CONSULTATION --}}
    <section class="flow-panel active" id="consultationPanel" data-panel="1">
      <div class="flow-head">
        <a href="{{ route('medical.doctor-consultations') }}" class="back-icon">
          <i class="bx bx-left-arrow-alt"></i>
        </a>
        <h4>Consultation</h4>
      </div>

      <div class="flow-body">
       

        <label class="field-label">Purpose of Visit</label>
        <div class="read-box mb-3" style="min-height: auto;">
          {{ implode(', ', $purposes) }}
        </div>

         <label class="field-label">Chief Complaint / Nurse Findings</label>
        <div class="read-box mb-3">{{ $medical->findings }}</div>

        <label class="field-label">Physiological Parameters</label>
        <div class="info-strip mb-3">
          <div class="info-item"><small>Blood Pressure</small><strong>{{ $medical->bp ?: '—' }}</strong></div>
          <div class="info-item"><small>Temperature</small><strong>{{ $medical->temp ?: '—' }}</strong></div>
          <div class="info-item"><small>Pulse</small><strong>{{ $medical->pulse ?: '—' }}</strong></div>
          <div class="info-item"><small>Respiratory Rate</small><strong>{{ $medical->res_rate ?: '—' }}</strong></div>
          <div class="info-item"><small>Weight</small><strong>{{ $medical->weight ? $medical->weight . ' kg' : '—' }}</strong></div>
          <div class="info-item"><small>Height</small><strong>{{ $medical->height ? $medical->height . ' cm' : '—' }}</strong></div>
        </div>

        <label class="field-label" for="recommendation">Treatment / Recommendation *</label>
        <textarea id="recommendation" name="recommendation" rows="5" required class="form-control" placeholder="Enter treatment and recommendation...">{{ old('recommendation', $medical->recommendation) }}</textarea>

        <div class="panel-actions">
          <a href="{{ route('medical.doctor-consultations') }}" class="btn btn-outline-primary">Cancel</a>
          <button type="button" id="nextPrescription" class="btn btn-deep">Next: Prescription</button>
        </div>
      </div>
    </section>

    {{-- STEP 2: PRESCRIPTION --}}
    <section class="flow-panel" id="prescriptionPanel" data-panel="2">
      <div class="flow-head">
        <button type="button" class="back-icon step-back" data-target="1">
          <i class="bx bx-left-arrow-alt"></i>
        </button>
        <h4>New Prescription</h4>
      </div>

      <div class="flow-body">
        <div class="patient-card">
          <div>
            <small>Patient</small>
            <strong>{{ $patientName }}</strong>
          </div>
          <div>
            <small>Date</small>
            <strong>{{ date('M d, Y', strtotime($medical->date)) }}</strong>
          </div>
        </div>

        <div class="section-row">
          <h5>Medications</h5>
          <button type="button" id="addMedicine" class="btn btn-outline-primary btn-sm">+ Add Medicine</button>
        </div>

        <div id="medicineEmpty" class="medicine-empty">
          No medicine added. Select “Add Medicine” to create a prescription.
        </div>

        <div id="medicines"></div>
        <label class="field-label mt-3">Instructions to Patient</label>
        <textarea id="patientInstructions"name="patient_instructions"rows="3"class="form-control"placeholder="Example: Take medicines after meals."></textarea>

        <div class="panel-actions">
          <button type="button" class="btn btn-outline-primary step-back" data-target="1">Back</button>
          <button type="button" id="nextPreview" class="btn btn-deep">Preview Prescription</button>
        </div>
      </div>
    </section>

    {{-- STEP 3: PRESCRIPTION PREVIEW --}}
    <section class="flow-panel preview-panel" data-panel="3">
      <div class="flow-head">
        <button type="button" class="back-icon step-back" data-target="2">
          <i class="bx bx-left-arrow-alt"></i>
        </button>
        <h4>Prescription Preview</h4>
      </div>

      <div class="preview-paper" id="prescriptionPreview">
        <div class="prescription-letterhead">
          <img class="slsu-letterhead" src="{{ asset('images/logo/new-SLSU-letter-head.png') }}" alt="Southern Leyte State University">
          <img class="bagong-logo" src="{{ asset('images/logo/bagong_pilipinas.png') }}" alt="Bagong Pilipinas">
        </div>
        <div class="letterhead-values">Excellence | Service | Leadership and Good Governance | Innovation | Social Responsibility | Integrity | Professionalism | Spirituality</div>

        <div class="doctor-heading">
          <h2>{{ strtoupper($doctorName) }}, MD</h2>
          <div>Visiting Physician</div>
          <div>Lic. # {{ $doctor->license ?? '—' }}</div>
        </div>

        <div class="patient-lines">
          <div class="patient-line patient-name-line"><strong>Name</strong><span>{{ $patientName }}</span></div>
          <div class="patient-line age-sex-line"><strong>Age/Sex</strong><span>{{ $medical->age ?: '—' }} / {{ $medical->gender ?: '—' }}</span></div>
          <div class="patient-line address-line"><strong>Address</strong><span>{{ $patientAddress ?: '—' }}</span></div>
          <div class="prescription-date">Date: {{ date('F d, Y', strtotime($medical->date)) }}</div>
        </div>

        <div class="rx-pad">
          <div class="rx">℞</div>
          <ol id="previewMedicines" class="preview-list">
            <li class="text-muted">No medications added.</li>
          </ol>

          <div class="preview-instructions">
            <strong>Instructions:</strong>
            <div id="previewInstructions">—</div>
          </div>
        </div>

        <div class="pad-bottom">
          <div class="accreditation-logos">
            <img src="{{ asset('images/logo/qs_star.png') }}" alt="QS Rated Good">
            <img src="{{ asset('images/logo/socotec.png') }}" alt="SOCOTEC ISO 9001">
          </div>
          <div class="signature">
            <div class="signature-line">{{ $doctorName }}, MD</div>
            <div>Signature &amp; Date</div>
          </div>
        </div>
      </div>

      <div class="preview-actions">
        <button type="button" class="btn btn-outline-primary step-back" data-target="2">Back</button>
        <button type="submit"
                class="btn btn-outline-primary"
                formaction="{{ route('medical.doctor-prescription.pdf', $medical->id) }}"
                formtarget="_blank">
          <i class="bx bx-printer"></i> Open A5 PDF
        </button>
        <button type="submit" id="saveConsultation" class="btn btn-deep">Save Consultation</button>
      </div>
    </section>
  </div>
</form>
{{-- Medicine form markup used by the Add Medicine button. --}}
<template id="medicineTemplate">
  <div class="medicine-row">
    <button type="button" class="remove-medicine" aria-label="Remove medicine">
      <i class="bx bx-trash"></i>
    </button>

    <div class="medicine-grid">
      <div class="medicine-name-field">
        <label class="mini-label">Medicine <span class="text-danger">*</span></label>
        <input type="text"
               name="medicine_name[]"
               class="form-control med-name"
               placeholder="Search medicine..."
               autocomplete="off">

        <input type="hidden" name="medicine_stock_id[]" class="med-stock-id">
        <input type="hidden" name="medicine_lot_no[]" class="med-lot-no">
        <div class="medicine-results"></div>
      </div>

      <div>
        <label class="mini-label">Quantity</label>
        <input type="number"
               min="1"
               name="medicine_quantity[]"
               class="form-control med-quantity"
               placeholder="10">
      </div>

      <div>
        <label class="mini-label">Dose</label>
        <div class="dose-with-unit">
          <input type="number"
                 min="0"
                 step="any"
                 name="medicine_dose[]"
                 class="form-control med-dose"
                 placeholder="1">
          <select name="medicine_dose_unit[]"
                  class="form-control med-dose-unit"
                  aria-label="Unit of measure">
            <option value="">Select unit</option>
            <option>Tablet</option>
            <option>Capsule</option>
            <option>Milligram</option>
            <option>Gram</option>
            <option>Milliliter</option>
            <option>Teaspoon</option>
            <option>Tablespoon</option>
            <option>Drop</option>
            <option>Puff</option>
            <option>Unit</option>
          </select>
        </div>
      </div>

      <div>
        <label class="mini-label">Route</label>
        <select name="medicine_route[]" class="form-control med-route">
          <option value="">Select route</option>
          <option>Oral</option>
          <option>Parenteral (Injection)</option>
          <option>Topical and Transdermal</option>
          <option>Inhalation</option>
          <option>Sublingual and Buccal</option>
          <option>Rectal and Vaginal</option>
        </select>
      </div>

      <div>
        <label class="mini-label">Frequency</label>
        <select name="medicine_frequency[]" class="form-control med-frequency">
          <option value="">Select frequency</option>
          <option>Once daily (one time a day)</option>
          <option>Twice a day (every 12 hours)</option>
          <option>Three times a day (every 8 hours)</option>
          <option>Four times a day (every 6 hours)</option>
          <option>Every 4 hours</option>
          <option>Every 6 hours</option>
          <option>Every 8 hours</option>
          <option>As needed for symptoms</option>
          <option>At bedtime</option>
        </select>
      </div>

      <div>
        <label class="mini-label">Duration</label>
        <input name="medicine_duration[]" class="form-control med-duration" placeholder="5 days">
      </div>

      <div class="medicine-stock-status">
        <span class="stock-warning">Low stock!</span>
        <span class="stock-left"></span>
        <span class="expiration-warning"></span>
      </div>
    </div>
  </div>
</template>
@endsection
{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/buttons.html5.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/buttons.print.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/buttons.bootstrap.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/pdfmake.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/vfs_fonts.js')}}"></script>
@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('js/scripts/datatables/datatable.js')}}"></script>
<script>
$.ajaxSetup({ headers : { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') }});

(function () {
  var medicinesContainer = document.getElementById('medicines');
  var medicineEmptyMessage = document.getElementById('medicineEmpty');

  // Prevent user-entered text from being inserted as HTML.
  function safe(value) {
    return String(value || '').replace(/[<>]/g, '');
  }

  // Refresh the prescription preview whenever a medicine field changes.
  function refreshPreview() {
    var medicineRows = medicinesContainer.querySelectorAll('.medicine-row');
    var previewList = document.getElementById('previewMedicines');
    var instructions = document.getElementById('patientInstructions').value;

    previewList.innerHTML = '';
    medicineEmptyMessage.style.display = medicineRows.length ? 'none' : 'block';

    if (!medicineRows.length) {
      previewList.innerHTML = '<li class="text-muted">No medications added.</li>';
    }

    medicineRows.forEach(function (row) {
      var name = row.querySelector('.med-name').value || 'Unnamed medicine';
      var dose = row.querySelector('.med-dose').value || 'as directed';
      var doseUnit = row.querySelector('.med-dose-unit').value;
      var route = row.querySelector('.med-route').value;
      var frequency = row.querySelector('.med-frequency').value;
      var duration = row.querySelector('.med-duration').value;
      var previewItem = document.createElement('li');

      var direction = 'Take ' + safe(dose);
      if (doseUnit) direction += ' ' + safe(doseUnit.toLowerCase());
      if (route) direction += ' by ' + safe(route.toLowerCase());
      if (frequency) direction += ' ' + safe(frequency.toLowerCase());
      if (duration) direction += ' for ' + safe(duration.toLowerCase());

      previewItem.innerHTML = '<strong>' + safe(name) + '</strong><br>' + direction + '.';
      previewList.appendChild(previewItem);
    });

    document.getElementById('previewInstructions').textContent = instructions || '—';
  }

  // Medicine inventory search (same approach as Patient Monitoring OTC).
  $(document).ready(function () {
    // Add another medicine card.
    $('#addMedicine').click(function () {
      var medicineCard = $($('#medicineTemplate').html());
      $('#medicines').append(medicineCard);
      $('#medicineEmpty').hide();
      medicineCard.find('.med-name').focus();
      refreshPreview();
    });

    // Remove a medicine card.
    $(document).on('click', '.remove-medicine', function () {
      $(this).closest('.medicine-row').remove();
      refreshPreview();
    });

    // Search medicines from stock while typing.
    $(document).on('keyup', '.med-name', function () {
      var medicineInput = $(this);
      var OTCmedDescript = medicineInput.val();
      var medicineField = medicineInput.closest('.medicine-name-field');
      var medicineRow = medicineInput.closest('.medicine-row');
      var results = medicineField.find('.medicine-results');

      medicineField.find('.med-stock-id').val('');
      medicineField.find('.med-lot-no').val('');
      medicineRow.find('.stock-left').text('');
      medicineRow.find('.stock-warning').hide();
      medicineRow.find('.expiration-warning').text('').hide();
      medicineRow.find('.med-quantity').removeAttr('max').attr('placeholder', '10');

      if (OTCmedDescript === '') {
        results.fadeOut();
        return;
      }

      results
        .html('<div class="medicine-result-empty">Searching medicines...</div>')
        .fadeIn();

      $.ajax({
        url: '/searchItems',
        method: 'post',
        data: { OTCmedDescript: OTCmedDescript },
        dataType: 'json',
        success: function (data) {
          results.html('').fadeIn();

          if (data.length === 0) {
            results.append('<div class="medicine-result-empty">No records found.</div>');
            return;
          }

          $.each(data, function (index, item) {
            var resultItem = $('<div class="medicine-result"></div>');
            var resultName = $('<strong></strong>').text(item.item_name);
            var resultDetails = $('<small></small>').text(
              item.item_quantity + ' pcs · Lot ' + (item.lotno || '—') +
              (item.expiration_date ? ' · Exp. ' + item.expiration_date : '')
            );

            resultItem
              .data('id', item.id)
              .data('lotno', item.lotno)
              .data('item_name', item.item_name)
              .data('stock', item.item_quantity)
              .data('expiration', item.expiration_date)
              .append(resultName)
              .append(resultDetails);

            results.append(resultItem);
          });
        }
      });
    });

    // Fill the medicine fields when a stock result is selected.
    $(document).on('click', '.medicine-result', function () {
      var selectedItem = $(this);
      var medicineRow = selectedItem.closest('.medicine-row');
      var stock = Number(selectedItem.data('stock'));
      var expiration = selectedItem.data('expiration');
      var expirationDate = expiration ? new Date(expiration) : null;
      var currentDate = new Date();
      var threeMonthsLater = new Date();

      medicineRow.find('.med-name').val(selectedItem.data('item_name'));
      medicineRow.find('.med-stock-id').val(selectedItem.data('id'));
      medicineRow.find('.med-lot-no').val(selectedItem.data('lotno'));
      medicineRow.find('.med-quantity').attr('max', stock).attr('placeholder', 'Max ' + stock);
      medicineRow.find('.stock-left').text('Stock Left: ' + stock);

      if (stock < 50) {
        medicineRow.find('.stock-warning').show();
      } else {
        medicineRow.find('.stock-warning').hide();
      }

      threeMonthsLater.setMonth(currentDate.getMonth() + 3);

      if (expirationDate && expirationDate <= currentDate) {
        medicineRow.find('.expiration-warning')
          .text('Warning: Expiration Date has passed (' + expiration + ')')
          .show();
      } else if (expirationDate && expirationDate <= threeMonthsLater) {
        medicineRow.find('.expiration-warning')
          .text('Warning: Expiration Date is within 3 months (' + expiration + ')')
          .show();
      } else {
        medicineRow.find('.expiration-warning').hide();
      }

      selectedItem.parent('.medicine-results').fadeOut();
      refreshPreview();
    });

    // Close search results when clicking outside a medicine field.
    $(document).click(function (event) {
      if (!$(event.target).closest('.medicine-name-field').length) {
        $('.medicine-results').fadeOut();
      }
    });
  });

  document.getElementById('patientInstructions').addEventListener('input', refreshPreview);

  // Display one form step at a time.
  function showStep(step) {
    document.querySelectorAll('.flow-panel').forEach(function (panel) {
      panel.classList.toggle('active', Number(panel.dataset.panel) === step);
    });

    document.querySelectorAll('.flow-tab').forEach(function (tab) {
      var tabNumber = Number(tab.dataset.step);
      tab.classList.toggle('active', tabNumber === step);
      tab.classList.toggle('done', tabNumber < step);
    });

    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  function consultationIsValid() {
    var recommendation = document.getElementById('recommendation');

    if (!recommendation.value.trim()) {
      recommendation.reportValidity();
      return false;
    }

    return true;
  }

  document.getElementById('nextPrescription').addEventListener('click', function () {
    if (consultationIsValid()) showStep(2);
  });

  document.getElementById('nextPreview').addEventListener('click', function () {
    refreshPreview();
    showStep(3);
  });

  document.querySelectorAll('.step-back').forEach(function (button) {
    button.addEventListener('click', function () {
      showStep(Number(button.dataset.target));
    });
  });

  document.querySelectorAll('.flow-tab').forEach(function (tab) {
    tab.addEventListener('click', function () {
      var targetStep = Number(tab.dataset.step);
      var currentStep = Number(document.querySelector('.flow-tab.active').dataset.step);

      if (targetStep > 1 && !consultationIsValid()) return;
      if (targetStep <= currentStep + 1 || targetStep < currentStep) showStep(targetStep);
    });
  });

  document.getElementById('consultationForm').addEventListener('submit', function (event) {
    var submitButton = event.submitter;

    // The PDF button keeps its own independent submit action.
    if (!submitButton || submitButton.id !== 'saveConsultation') return;

    event.preventDefault();

    var form = event.currentTarget;
    submitButton.disabled = true;

    fetch(form.action, {
      method: 'POST',
      body: new FormData(form),
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
      .then(function (response) {
        return response.json().then(function (data) {
          if (!response.ok) throw data;
          return data;
        });
      })
      .then(function (data) {
        Swal.fire({
          icon: 'success',
          title: 'Successfully Saved',
          text: data.message,
          showConfirmButton: false,
          timer: 1000,
          timerProgressBar: true
        });
      })
      .catch(function (error) {
        var message = error && error.errors
          ? Object.values(error.errors)[0][0]
          : 'The consultation could not be saved. Please try again.';

        submitButton.disabled = false;
        Swal.fire('Unable to Save', message, 'error');
      });
  });

})();
</script>
@endsection
