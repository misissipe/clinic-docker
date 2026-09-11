<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Prescription</title>
  <style>
    @page { size: A5 portrait; margin: 0; }
    * { box-sizing: border-box; }
    html, body { margin: 0; padding: 0; }
    body { color: #000; font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
    /* Dompdf uses the CSS content box when calculating fixed dimensions.
       Subtract the padding from A5 (148mm x 210mm) to prevent overflow. */
    .page { position: relative; width: 128mm; height: 195mm; padding: 9mm 10mm 6mm; overflow: hidden; }
    .letterhead { position: relative; height: 20mm; }
    .campus-logo { position: absolute; top: 0; left: 8mm; width: 65mm; height: 18mm; object-fit: contain; }
    .bagong-logo { position: absolute; top: 0; right: 20mm; width: 15mm; height: 15mm; object-fit: contain; }
    .motto { position: absolute; right: 0; bottom: 1.5mm; left: 0; color: #666; font-family: "Times New Roman", Times, serif; font-size: 9px; text-align: center; white-space: nowrap; }
    .rule { border-top: .35mm solid #777; }
    .doctor { margin-top: 9.5mm; text-align: center; }
    .doctor-name { font-size: 16.5px; font-weight: 700; line-height: 1.15; }
    .doctor-title, .doctor-license { font-size: 13.5px; line-height: 1.3; }
    .doctor-title { margin-top: 1mm; }
    .patient-info { margin-top: 14mm; font-size: 13px; }
    .patient-row { height: 13mm; white-space: nowrap; }
    .line { display: inline-block; height: 5mm; border-bottom: .25mm solid #000; vertical-align: bottom; }
    .name-line { width: 79mm; }
    .age-line { width: 15mm; }
    .address-line { width: 108mm; }
    .rx { display: block; width: 17mm; height: 15mm; margin-top: 1mm; margin-left: 1mm; }
    .rx-pad { position: relative; min-height: 68mm; padding: 2mm 0 0 21mm; font-family: "Doctor", "DejaVu Serif", serif; font-style: normal; }
    .rx-pad .rx { position: absolute; top: 1mm; left: 0; margin: 0; }
    .preview-list { margin: 0; padding-left: 6mm; font-size: 8pt; line-height: 1.45; }
    .preview-list li { margin-bottom: 3mm; padding-left: 1mm; }
    .medicine-name { font-size: 8pt; font-weight: 400; font-style: normal; text-transform: uppercase; font-family: 'Aptos'}
    .medicine-details { font-size: 8pt;font-family: 'Aptos' }
    .preview-instructions { margin-top: 5mm; font-size: 8pt; line-height: 1.45; }
    .preview-instructions strong { font-family: "DejaVu Sans", Arial, sans-serif; font-size: 10pt; font-style: normal; }
    .instruction-text { margin-top: 1mm; font-style: normal; white-space: pre-line; }
    .text-muted { color: #555; font-style: italic; }
    .signature { position: absolute; right: 7mm; bottom: 19mm; width: 52mm; text-align: center; }
    .signature-line { height: 6mm; border-bottom: .3mm solid #000; }
    .signature-label { margin-top: 1mm; font-size: 13px; }
    .certifications { position: absolute; right: 20mm; bottom: 5mm; height: 12mm; white-space: nowrap; }
    .certifications img { height: 12mm; object-fit: contain; vertical-align: middle; }
    .qs-logo { width: 14mm; margin-right: 1mm; }
    .socotec-logo { width: 23mm; }
    @font-face {
      font-family: "Doctor";
      src: url("file://{{ public_path('fonts/doctor.ttf') }}") format("truetype");
      font-weight: 400;
      font-style: normal;
    }


    @font-face {
    font-family: 'Aptos';
    src: url("file://{{ public_path('fonts/Aptos-Regular.ttf') }}") format('truetype');
    font-weight: 400;
    font-style: normal;
}

@font-face {
    font-family: 'Aptos';
    src: url("file://{{ public_path('fonts/Aptos-Bold.ttf') }}") format('truetype');
    font-weight: 700;
    font-style: normal;
}

@font-face {
    font-family: 'Aptos';
    src: url("file://{{ public_path('fonts/Aptos-Italic.ttf') }}") format('truetype');
    font-weight: 400;
    font-style: italic;
}
  </style>
</head>
<body>
@php
  $campusCode = session('campus');
  $campusLogos = [
    1 => 'main-campus-logo.png',
    2 => 'maasin-logo.png',
    3 => 'tomas-oppus.png',
    4 => 'bontoc.png',
    5 => 'san-juan.png',
    6 => 'hinunangan.png',
  ];
  $campusLogo = $campusLogos[$campusCode] ?? 'main-campus-logo.png';
  $patientName = trim(implode(' ', array_filter([
    $patient->FirstName ?? $patient->firstname ?? null,
    $patient->MiddleName ?? $patient->middlename ?? null,
    $patient->LastName ?? $patient->lastname ?? null,
  ])));
  $patientAddress = implode(', ', array_filter([
    $patient->RBarangay ?? $patient->brgy ?? $patient->barangay ?? null,
    $patient->citymunDesc ?? $patient->city ?? $patient->municipality ?? null,
    $patient->provDesc ?? $patient->province ?? null,
  ]));
  $patientAge = $medical->age ?? $patient->age ?? '';
  $patientSex = $medical->gender ?? $patient->gender ?? $patient->sex ?? '';
@endphp

<div class="page aptos">
  <div class="letterhead">
    <img class="campus-logo" src="{{ public_path('images/logo/' . $campusLogo) }}" alt="Southern Leyte State University">
    <img class="bagong-logo" src="{{ public_path('images/logo/bagong_pilipinas.png') }}" alt="Bagong Pilipinas">
    <div class="motto">Excellence | Service | Leadership and Good Governance | Innovation | Social Responsibility | Integrity | Professionalism | Spirituality</div>
  </div>
  <div class="rule"></div>

  <div class="doctor">
    <div class="doctor-name" style="text-transform: uppercase">{{$doctor->FirstName}}{{$doctor->MiddleName}}{{$doctor->LastName}}</div>
    <div class="doctor-title">Visiting Physician</div>
    <div class="doctor-license">Lic. # {{ $doctor->license ?? '0162240' }}</div>
  </div>

  <div class="patient-info">
    <div class="patient-row">
      <span>Name: </span><span class="line name-line">{{ $patientName }}</span>
      <span>Age/Sex: </span><span class="line age-line">{{ implode(' / ', array_filter([$patientAge, $patientSex])) }}</span>
    </div>
    <div class="patient-row">
      <span>Address: </span><span class="line address-line">{{ $patientAddress }}</span>
    </div>
  </div>

    <div class="rx-pad">
          <img class="rx" src="file://{{ public_path('images/logo/rx-prescription.svg') }}" alt="Rx">
          <ol class="preview-list" style="font-size: 8px">
            @forelse ($medicines as $medicine)
              <li>
                <div class="medicine-name">{{ $medicine['name'] }}</div>
                <div class="medicine-details">
                  {{ implode(' · ', array_filter([
                    $medicine['dose'] ?? null,
                    $medicine['route'] ?? null,
                    $medicine['frequency'] ?? null,
                    $medicine['duration'] ?? null,
                  ])) }}
                </div>
              </li>
            @empty
              <li class="text-muted">No medications added.</li>
            @endforelse
          </ol>

          <div class="preview-instructions">
            <strong>Instructions:</strong>
            <div class="instruction-text">{{ $instructions ?: '—' }}</div>
          </div>
        </div>

  <div class="signature">
    <div class="signature-line"></div>
    <div class="signature-label">Signature &amp; Date</div>
  </div>

  <div class="certifications">
    <img class="qs-logo" src="{{ public_path('images/logo/qs_star.png') }}" alt="QS Stars">
    <img class="socotec-logo" src="{{ public_path('images/logo/socotec.png') }}" alt="SOCOTEC ISO 9001">
  </div>
</div>
</body>
</html>
