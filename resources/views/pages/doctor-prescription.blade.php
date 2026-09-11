```blade
@extends('layouts.app')

@section('content')

<style>
    .medical-page {
        background: #f5f7fb;
        min-height: 100vh;
        padding: 20px;
    }

    .medical-header,
    .medical-card,
    .prescription-paper {
        background: #fff;
        border: 1px solid #e1e7f0;
        border-radius: 10px;
    }

    .medical-header {
        padding: 18px 24px;
        margin-bottom: 12px;
    }

    .medical-card {
        height: 100%;
        overflow: hidden;
    }

    .card-title {
        font-size: 15px;
        font-weight: 700;
        color: #123c8c;
        text-transform: uppercase;
    }

    .step-number {
        width: 25px;
        height: 25px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #0d6efd;
        color: white;
        border-radius: 5px;
        font-size: 13px;
        font-weight: 700;
        margin-right: 8px;
    }

    .section-title {
        font-size: 12px;
        font-weight: 700;
        color: #173b72;
        margin-bottom: 7px;
    }

    .medical-card-body {
        padding: 20px;
    }

    .form-control,
    .form-select {
        border-color: #dce3ed;
        font-size: 13px;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 .15rem rgba(13,110,253,.1);
    }

    .vital-box {
        border: 1px solid #dce3ed;
        border-radius: 7px;
        text-align: center;
        padding: 10px 4px;
        height: 85px;
    }

    .vital-label {
        font-size: 11px;
        color: #50627a;
        display: block;
    }

    .vital-value {
        font-weight: 700;
        font-size: 14px;
        color: #182b49;
    }

    .medicine-card {
        border: 1px solid #dce3ed;
        border-radius: 7px;
        padding: 13px;
        margin-bottom: 10px;
    }

    .medicine-name {
        font-size: 13px;
        font-weight: 700;
        color: #172b4d;
    }

    .medicine-label {
        font-size: 10px;
        color: #64748b;
        display: block;
        margin-bottom: 2px;
    }

    .medicine-value {
        font-size: 12px;
        font-weight: 600;
    }

    .prescription-paper {
        padding: 25px;
        min-height: 600px;
        box-shadow: 0 2px 8px rgba(0,0,0,.04);
    }

    .clinic-name {
        font-size: 17px;
        font-weight: 800;
        color: #172b4d;
    }

    .rx-symbol {
        font-size: 45px;
        font-family: serif;
        color: #172b4d;
    }

    .prescription-list li {
        margin-bottom: 13px;
        font-size: 12px;
    }

    .prescription-list strong {
        font-size: 13px;
    }

    .doctor-signature {
        margin-top: 55px;
        text-align: right;
    }

    .signature-line {
        width: 160px;
        border-top: 1px solid #555;
        margin-left: auto;
    }

    .info-footer {
        background: #f4f8ff;
        border: 1px solid #dce8ff;
        border-radius: 8px;
        padding: 13px 18px;
        color: #173b72;
        font-size: 12px;
    }

    @media (max-width: 1200px) {
        .medical-page {
            padding: 10px;
        }
    }

    @media print {
        body * {
            visibility: hidden;
        }

        #prescriptionPreview,
        #prescriptionPreview * {
            visibility: visible;
        }

        #prescriptionPreview {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            border: none;
            box-shadow: none;
        }

        .no-print {
            display: none !important;
        }
    }
</style>


<div class="medical-page">

    {{-- =========================================================
        HEADER
    ========================================================== --}}
    <div class="medical-header">

        <div class="row align-items-center">

            <div class="col-lg-5">

                <div class="d-flex align-items-center">

                    <i class="bi bi-clipboard2-pulse text-primary"
                       style="font-size:35px;"></i>

                    <div class="ms-3">

                        <h4 class="mb-0 fw-bold text-primary">
                            CONSULTATION & PRESCRIPTION
                        </h4>

                        <small class="text-muted">
                            Doctor's End - From Consultation to Prescription
                        </small>

                    </div>

                </div>

            </div>


            <div class="col-lg-7">

                <div class="row text-lg-end mt-3 mt-lg-0">

                    <div class="col-md-4">

                        <small class="text-muted d-block">
                            Patient
                        </small>

                        <strong>
                            {{ $patient->fullname ?? 'Maria Santos' }}
                        </strong>

                    </div>

                    <div class="col-md-4">

                        <small class="text-muted d-block">
                            Age / Sex
                        </small>

                        <strong>
                            {{ $patient->age ?? '21' }}
                            /
                            {{ $patient->sex ?? 'Female' }}
                        </strong>

                    </div>

                    <div class="col-md-4">

                        <small class="text-muted d-block">
                            Date
                        </small>

                        <strong>
                            {{ now()->format('M d, Y') }}
                        </strong>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        MAIN FORM
    ========================================================== --}}

    <form action="{{ route('doctor.prescription.store') }}"
          method="POST"
          id="consultationForm">

        @csrf

        <input type="hidden"
               name="patient_id"
               value="{{ $patient->id ?? '' }}">


        <div class="row g-3">


            {{-- =================================================
                COLUMN 1
                CONSULTATION & NOTES
            ================================================== --}}

            <div class="col-xl-4">

                <div class="medical-card">

                    <div class="medical-card-body">

                        <div class="card-title mb-4">

                            <span class="step-number">
                                1
                            </span>

                            Consultation & Notes

                        </div>


                        {{-- Chief Complaint --}}
                        <div class="mb-3">

                            <div class="section-title">
                                Chief Complaint
                            </div>

                            <textarea
                                class="form-control"
                                rows="3"
                                name="chief_complaint"
                                id="chiefComplaint"
                                placeholder="Enter chief complaint..."
                            >{{ $record->findings ?? '' }}</textarea>

                        </div>


                        {{-- History --}}
                        <div class="mb-3">

                            <div class="section-title">
                                History of Present Illness
                            </div>

                            <textarea
                                class="form-control"
                                rows="4"
                                name="history"
                                placeholder="Enter history of present illness..."
                            >{{ old('history', $record->history ?? '') }}</textarea>

                        </div>


                        {{-- Vital Signs --}}
                        <div class="section-title">
                            Vital Signs
                        </div>

                        <div class="row g-2 mb-3">

                            <div class="col-3">

                                <div class="vital-box">

                                    <span class="vital-label">
                                        Temp
                                    </span>

                                    <div class="vital-value">
                                        {{ $record->temperature ?? '38.5' }} °C
                                    </div>

                                </div>

                            </div>


                            <div class="col-3">

                                <div class="vital-box">

                                    <span class="vital-label">
                                        BP
                                    </span>

                                    <div class="vital-value">
                                        {{ $record->blood_pressure ?? '110/70' }}
                                    </div>

                                    <small>mmHg</small>

                                </div>

                            </div>


                            <div class="col-3">

                                <div class="vital-box">

                                    <span class="vital-label">
                                        HR
                                    </span>

                                    <div class="vital-value">
                                        {{ $record->pulse ?? '88' }}
                                    </div>

                                    <small>bpm</small>

                                </div>

                            </div>


                            <div class="col-3">

                                <div class="vital-box">

                                    <span class="vital-label">
                                        RR
                                    </span>

                                    <div class="vital-value">
                                        {{ $record->respiratory_rate ?? '20' }}
                                    </div>

                                    <small>/min</small>

                                </div>

                            </div>

                        </div>


                        {{-- Physical Examination --}}
                        <div class="mb-3">

                            <div class="section-title">
                                Physical Examination
                            </div>

                            <textarea
                                class="form-control"
                                rows="4"
                                name="physical_examination"
                                placeholder="Enter physical examination..."
                            >{{ old('physical_examination', $record->physical_examination ?? '') }}</textarea>

                        </div>


                        {{-- Diagnosis --}}
                        <div class="mb-3">

                            <div class="section-title">
                                Assessment / Diagnosis
                            </div>

                            <input
                                type="text"
                                class="form-control"
                                name="diagnosis"
                                id="diagnosis"
                                value="{{ old('diagnosis') }}"
                                placeholder="Enter diagnosis..."
                            >

                        </div>


                        {{-- Treatment Plan --}}
                        <div class="mb-3">

                            <div class="section-title">
                                Treatment Plan
                            </div>

                            <textarea
                                class="form-control"
                                rows="3"
                                name="treatment_plan"
                                id="treatmentPlan"
                                placeholder="Enter treatment plan..."
                            ></textarea>

                        </div>


                        <div class="d-flex gap-2">

                            <button
                                type="button"
                                class="btn btn-outline-primary w-50">

                                <i class="bi bi-save"></i>
                                Save Notes

                            </button>


                            <button
                                type="button"
                                class="btn btn-primary w-50"
                                onclick="scrollToPrescription()">

                                Proceed to Prescription

                                <i class="bi bi-arrow-right"></i>

                            </button>

                        </div>

                    </div>

                </div>

            </div>



            {{-- =================================================
                COLUMN 2
                CREATE PRESCRIPTION
            ================================================== --}}

            <div class="col-xl-4">

                <div class="medical-card"
                     id="prescriptionSection">

                    <div class="medical-card-body">

                        <div class="card-title mb-4">

                            <span class="step-number">
                                2
                            </span>

                            Create Prescription

                        </div>


                        {{-- Patient --}}
                        <div class="border rounded p-3 mb-3">

                            <div class="row">

                                <div class="col-6">

                                    <small class="text-muted">
                                        Patient
                                    </small>

                                    <div class="fw-semibold">
                                        {{ $patient->fullname ?? 'Maria Santos' }}
                                    </div>

                                </div>

                                <div class="col-6">

                                    <small class="text-muted">
                                        Date
                                    </small>

                                    <div class="fw-semibold">
                                        {{ now()->format('M d, Y') }}
                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- Medicines --}}
                        <div class="d-flex justify-content-between align-items-center mb-2">

                            <div class="section-title mb-0">
                                MEDICATIONS
                            </div>

                            <button
                                type="button"
                                class="btn btn-sm btn-outline-primary"
                                id="addMedicine">

                                <i class="bi bi-plus"></i>
                                Add Medicine

                            </button>

                        </div>


                        <div id="medicineList">

                            {{-- Medicine 1 --}}
                            <div class="medicine-card">

                                <div class="d-flex justify-content-between">

                                    <input
                                        type="text"
                                        name="medicine_name[]"
                                        class="form-control form-control-sm border-0 fw-bold"
                                        placeholder="Medicine name"
                                        value="Paracetamol 500mg"
                                        oninput="updatePreview()">

                                    <button
                                        type="button"
                                        class="btn btn-sm text-danger removeMedicine">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </div>


                                <div class="row g-2 mt-2">

                                    <div class="col-6">

                                        <span class="medicine-label">
                                            Dose
                                        </span>

                                        <input
                                            type="text"
                                            name="dose[]"
                                            class="form-control form-control-sm"
                                            value="1 tablet"
                                            oninput="updatePreview()">

                                    </div>


                                    <div class="col-6">

                                        <span class="medicine-label">
                                            Route
                                        </span>

                                        <select
                                            name="route[]"
                                            class="form-select form-select-sm"
                                            onchange="updatePreview()">

                                            <option>Oral (PO)</option>
                                            <option>Parenteral (Injection)</option>
                                            <option>Topical &amp; Transdermal</option>
                                            <option>Inhalation</option>
                                            <option>Sublingual and Buccal</option>
                                            <option>Rectal and Vaginal</option>

                                        </select>

                                    </div>


                                    <div class="col-6">

                                        <span class="medicine-label">
                                            Frequency
                                        </span>

                                        <select
                                            name="frequency[]"
                                            class="form-select form-select-sm"
                                            onchange="updatePreview()">

                                            <option value="QD">QD — Once daily (one time a day)</option>
                                            <option value="BID">BID — Twice a day (every 12 hours)</option>
                                            <option value="TID">TID — Three times a day (every 8 hours)</option>
                                            <option value="QID">QID — Four times a day (every 6 hours)</option>
                                            <option value="Q4H">Q4H — Every 4 hours</option>
                                            <option value="Q6H">Q6H — Every 6 hours</option>
                                            <option value="Q8H">Q8H — Every 8 hours</option>
                                            <option value="PRN">PRN — As needed for symptoms</option>
                                            <option value="HS">HS — At bedtime</option>

                                        </select>

                                    </div>


                                    <div class="col-6">

                                        <span class="medicine-label">
                                            Duration
                                        </span>

                                        <input
                                            type="text"
                                            name="duration[]"
                                            class="form-control form-control-sm"
                                            value="3 days"
                                            oninput="updatePreview()">

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- Instructions --}}
                        <div class="mb-3">

                            <div class="section-title">
                                Instructions to Patient
                            </div>

                            <textarea
                                name="instructions"
                                id="instructions"
                                class="form-control"
                                rows="5"
                                oninput="updatePreview()"
                                placeholder="Enter instructions..."
                            >Take medicines after meals.
Complete the full course of antibiotics.
Rest and drink plenty of fluids.</textarea>

                        </div>


                        <div class="d-flex gap-2">

                            <button
                                type="button"
                                class="btn btn-outline-secondary w-50">

                                Cancel

                            </button>


                            <button
                                type="button"
                                class="btn btn-primary w-50"
                                onclick="updatePreview()">

                                Preview Prescription

                                <i class="bi bi-arrow-right"></i>

                            </button>

                        </div>

                    </div>

                </div>

            </div>



            {{-- =================================================
                COLUMN 3
                PRESCRIPTION PREVIEW
            ================================================== --}}

            <div class="col-xl-4">

                <div class="medical-card">

                    <div class="medical-card-body">

                        <div class="card-title mb-4">

                            <span class="step-number">
                                3
                            </span>

                            Prescription Preview

                        </div>


                        <div
                            class="prescription-paper"
                            id="prescriptionPreview">


                            {{-- Clinic --}}
                            <div class="text-center mb-4">

                                <div class="d-flex justify-content-center align-items-center">

                                    <i
                                        class="bi bi-heart-pulse-fill text-primary me-2"
                                        style="font-size:35px;">
                                    </i>

                                    <div class="text-start">

                                        <div class="clinic-name">
                                            SLLSU UNIVERSITY CLINIC
                                        </div>

                                        <small>
                                            Anahawan, Southern Leyte
                                        </small>

                                        <br>

                                        <small>
                                            Tel. No.: 0912-345-6789
                                        </small>

                                    </div>

                                </div>

                            </div>


                            {{-- Rx --}}
                            <div class="d-flex justify-content-between align-items-end mb-3">

                                <div class="rx-symbol">
                                    ℞
                                </div>

                                <small>
                                    Date:
                                    {{ now()->format('M d, Y') }}
                                </small>

                            </div>


                            {{-- Patient --}}
                            <div class="mb-4"
                                 style="font-size:12px;">

                                <div>
                                    <strong>Patient:</strong>
                                    {{ $patient->fullname ?? 'Maria Santos' }}
                                </div>

                                <div>
                                    <strong>Age:</strong>
                                    {{ $patient->age ?? '21' }}
                                </div>

                                <div>
                                    <strong>Sex:</strong>
                                    {{ $patient->sex ?? 'Female' }}
                                </div>

                            </div>


                            {{-- Medicine Preview --}}
                            <ol
                                class="prescription-list ps-4"
                                id="medicinePreview">

                                <li>

                                    <strong>
                                        Paracetamol 500mg
                                    </strong>

                                    <br>

                                    Take 1 tablet by mouth
                                    every 6 hours for 3 days.

                                </li>

                            </ol>


                            {{-- Instructions --}}
                            <div style="font-size:12px;">

                                <strong>
                                    Instructions:
                                </strong>

                                <div
                                    id="instructionPreview"
                                    class="mt-2"
                                    style="white-space: pre-line;">
                                    Take medicines after meals.
                                    Complete the full course of antibiotics.
                                    Rest and drink plenty of fluids.
                                </div>

                            </div>


                            {{-- Signature --}}
                            <div class="doctor-signature">

                                <div class="signature-line"></div>

                                <strong>
                                    Dr. Juan Dela Cruz
                                </strong>

                                <br>

                                <small>
                                    General Physician
                                </small>

                                <br>

                                <small>
                                    License No. 1234567
                                </small>

                            </div>

                        </div>


                        {{-- Actions --}}
                        <div class="d-flex gap-2 mt-3 no-print">

                            <button
                                type="button"
                                class="btn btn-outline-primary flex-fill"
                                onclick="printPrescription()">

                                <i class="bi bi-printer"></i>
                                Print

                            </button>


                            <button
                                type="button"
                                class="btn btn-outline-primary flex-fill"
                                onclick="downloadPrescription()">

                                <i class="bi bi-download"></i>
                                Download PDF

                            </button>


                            <button
                                type="submit"
                                class="btn btn-primary flex-fill">

                                <i class="bi bi-save"></i>
                                Save Prescription

                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </form>


    {{-- =========================================================
        FOOTER INFORMATION
    ========================================================== --}}

    <div class="info-footer mt-3">

        <i class="bi bi-info-circle me-2"></i>

        Review the consultation details, enter the prescription,
        and preview the prescription before saving.

        <br>

        <span class="ms-4">
            Once saved, the prescription will become part of the
            patient's medical record.
        </span>

    </div>

</div>



{{-- =============================================================
    JAVASCRIPT
============================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    updatePreview();

});


/*
|--------------------------------------------------------------------------
| Add Medicine
|--------------------------------------------------------------------------
*/

document.getElementById('addMedicine').addEventListener('click', function () {

    const medicineList = document.getElementById('medicineList');

    const medicine = document.createElement('div');

    medicine.classList.add('medicine-card');

    medicine.innerHTML = `

        <div class="d-flex justify-content-between">

            <input
                type="text"
                name="medicine_name[]"
                class="form-control form-control-sm border-0 fw-bold"
                placeholder="Medicine name"
                oninput="updatePreview()">

            <button
                type="button"
                class="btn btn-sm text-danger removeMedicine">

                <i class="bi bi-trash"></i>

            </button>

        </div>

        <div class="row g-2 mt-2">

            <div class="col-6">

                <span class="medicine-label">
                    Dose
                </span>

                <input
                    type="text"
                    name="dose[]"
                    class="form-control form-control-sm"
                    placeholder="Dose"
                    oninput="updatePreview()">

            </div>

            <div class="col-6">

                <span class="medicine-label">
                    Route
                </span>

                <select
                    name="route[]"
                    class="form-select form-select-sm"
                    onchange="updatePreview()">

                    <option>Oral (PO)</option>
                    <option>Parenteral (Injection)</option>
                    <option>Topical &amp; Transdermal</option>
                    <option>Inhalation</option>
                    <option>Sublingual and Buccal</option>
                    <option>Rectal and Vaginal</option>

                </select>

            </div>

            <div class="col-6">

                <span class="medicine-label">
                    Frequency
                </span>

                <select
                    name="frequency[]"
                    class="form-select form-select-sm"
                    onchange="updatePreview()">

                    <option value="QD">QD — Once daily (one time a day)</option>
                    <option value="BID">BID — Twice a day (every 12 hours)</option>
                    <option value="TID">TID — Three times a day (every 8 hours)</option>
                    <option value="QID">QID — Four times a day (every 6 hours)</option>
                    <option value="Q4H">Q4H — Every 4 hours</option>
                    <option value="Q6H">Q6H — Every 6 hours</option>
                    <option value="Q8H">Q8H — Every 8 hours</option>
                    <option value="PRN">PRN — As needed for symptoms</option>
                    <option value="HS">HS — At bedtime</option>

                </select>

            </div>

            <div class="col-6">

                <span class="medicine-label">
                    Duration
                </span>

                <input
                    type="text"
                    name="duration[]"
                    class="form-control form-control-sm"
                    placeholder="Duration"
                    oninput="updatePreview()">

            </div>

        </div>
    `;

    medicineList.appendChild(medicine);

});


/*
|--------------------------------------------------------------------------
| Remove Medicine
|--------------------------------------------------------------------------
*/

document.addEventListener('click', function (e) {

    if (e.target.closest('.removeMedicine')) {

        const medicine = e.target.closest('.medicine-card');

        medicine.remove();

        updatePreview();

    }

});


/*
|--------------------------------------------------------------------------
| Update Prescription Preview
|--------------------------------------------------------------------------
*/

function updatePreview() {

    const names = document.querySelectorAll(
        'input[name="medicine_name[]"]'
    );

    const doses = document.querySelectorAll(
        'input[name="dose[]"]'
    );

    const routes = document.querySelectorAll(
        'select[name="route[]"]'
    );

    const frequencies = document.querySelectorAll(
        'select[name="frequency[]"]'
    );

    const durations = document.querySelectorAll(
        'input[name="duration[]"]'
    );


    const preview = document.getElementById(
        'medicinePreview'
    );

    preview.innerHTML = '';


    names.forEach(function (name, index) {

        if (!name.value.trim()) {
            return;
        }

        const dose =
            doses[index]?.value || '';

        const route =
            routes[index]?.value || 'Oral (PO)';

        const frequency =
            frequencies[index]?.value || '';

        const duration =
            durations[index]?.value || '';


        let routeText =
            route === 'Oral (PO)'
                ? 'by mouth'
                : route;


        const li = document.createElement('li');

        li.innerHTML = `

            <strong>
                ${escapeHtml(name.value)}
            </strong>

            <br>

            Take ${escapeHtml(dose)}
            ${routeText}
            ${escapeHtml(frequency)}
            for ${escapeHtml(duration)}.

        `;

        preview.appendChild(li);

    });


    if (!preview.children.length) {

        preview.innerHTML = `
            <li class="text-muted">
                No medication added.
            </li>
        `;

    }


    /*
    |--------------------------------------------------------------------------
    | Instructions
    |--------------------------------------------------------------------------
    */

    const instructions =
        document.getElementById('instructions').value;

    document.getElementById(
        'instructionPreview'
    ).textContent = instructions || '—';

}


/*
|--------------------------------------------------------------------------
| Prevent HTML Injection
|--------------------------------------------------------------------------
*/

function escapeHtml(text) {

    const div =
        document.createElement('div');

    div.textContent = text;

    return div.innerHTML;

}


/*
|--------------------------------------------------------------------------
| Scroll to Prescription
|--------------------------------------------------------------------------
*/

function scrollToPrescription() {

    document.getElementById(
        'prescriptionSection'
    ).scrollIntoView({

        behavior: 'smooth',
        block: 'start'

    });

}


/*
|--------------------------------------------------------------------------
| Print Prescription
|--------------------------------------------------------------------------
*/

function printPrescription() {

    window.print();

}


/*
|--------------------------------------------------------------------------
| Download PDF
|--------------------------------------------------------------------------
|
| This requires your Laravel PDF route/controller.
|--------------------------------------------------------------------------
*/

function downloadPrescription() {

    const url =
        "{{ route('doctor.prescription.pdf', $patient->id ?? 0) }}";

    window.open(url, '_blank');

}

</script>

@endsection
```
