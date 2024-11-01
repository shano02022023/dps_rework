<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Status Update</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }

        .container {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #555;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">Update on Your Application Status</div>

        <p>Dear {{ $applicant->firstname }} {{ $applicant->lastname }},</p>

        <p>Thank you for your interest in <strong>[Position/Program Name]</strong> at <strong>[Company/Organization
                Name]</strong>. After careful consideration, we regret to inform you that we will not be moving forward
            with your application at this time.</p>

        <p>We appreciate the time and effort you put into your application and encourage you to stay connected with us
            for future opportunities that may align with your skills and aspirations.</p>

        <p>Thank you once again for considering <strong>[Company/Organization Name]</strong>.</p>

        <div class="footer">
            Best regards,<br>
            DPS<br>
        </div>
    </div>

</body>

</html>