<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Dental Appointment Request Received</title>
</head>
<body style="margin:0;padding:24px;background:#f4f7fb;font-family:Arial,sans-serif;color:#243b5a;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0" style="max-width:600px;width:100%;background:#ffffff;border:1px solid #dbe5f2;border-radius:10px;">
                    <tr>
                        <td style="padding:24px;background:#0758e8;color:#ffffff;border-radius:10px 10px 0 0;">
                            <h1 style="margin:0;font-size:22px;">SLSU Clinic</h1>
                            <p style="margin:6px 0 0;">Dental Appointment Request</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:28px;">
                            <p style="margin-top:0;">Hello {{ $patientName ?: 'Patient' }},</p>
                            <p>Your dental appointment request has been received. The clinic will review and confirm your schedule.</p>

                            <table role="presentation" width="100%" cellspacing="0" cellpadding="8" border="0" style="background:#f6f9fd;border-radius:8px;">
                                <tr><td><strong>Service</strong></td><td>{{ $services }}</td></tr>
                                <tr><td><strong>Date</strong></td><td>{{ $appointment->date->format('F d, Y') }}</td></tr>
                                <tr><td><strong>Time</strong></td><td>{{ date('h:i A', strtotime($appointment->time)) }}</td></tr>
                                <tr><td><strong>Location</strong></td><td>SLSU Clinic, Student Center</td></tr>
                                <tr><td><strong>Status</strong></td><td>Pending</td></tr>
                            </table>

                            <p>Please arrive at least 15 minutes before your confirmed schedule.</p>
                            <p style="margin-bottom:0;">Thank you,<br><strong>SLSU Clinic</strong></p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
