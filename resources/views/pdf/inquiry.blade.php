<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Inquiry #{{ $inquiry->id }} - Softpolli</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            font-size: 13px;
            line-height: 1.5;
            padding: 20px;
        }
        .header {
            border-bottom: 2px solid #0284c7;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .brand {
            font-size: 24px;
            font-weight: bold;
            color: #0369a1;
            letter-spacing: -0.5px;
        }
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            background: #e0f2fe;
            color: #0369a1;
            float: right;
        }
        .title {
            font-size: 16px;
            font-weight: 700;
            margin-top: 10px;
            color: #0f172a;
        }
        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 25px;
        }
        .meta-table th, .meta-table td {
            padding: 8px 12px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }
        .meta-table th {
            width: 25%;
            background-color: #f8fafc;
            color: #64748b;
            font-size: 11px;
            text-transform: uppercase;
        }
        .message-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
            margin-top: 15px;
        }
        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 1px solid #e2e8f0;
            font-size: 10px;
            color: #94a3b8;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <span class="badge">{{ strtoupper($inquiry->status) }}</span>
        <div class="brand">SOFTPOLli</div>
        <div style="color: #64748b; font-size: 11px; margin-top: 2px;">Enterprise Software & Technology Solutions</div>
    </div>

    <div class="title">Client Inquiry & Project Specification Sheet #{{ $inquiry->id }}</div>
    <div style="font-size: 11px; color: #64748b; margin-top: 4px;">Received on {{ $inquiry->created_at?->format('F d, Y \a\t h:i A') }}</div>

    <table class="meta-table">
        <tr>
            <th>Client Name</th>
            <td><strong>{{ $inquiry->name }}</strong></td>
            <th>Submission Type</th>
            <td>{{ ucfirst($inquiry->type) }}</td>
        </tr>
        <tr>
            <th>Email Address</th>
            <td>{{ $inquiry->email }}</td>
            <th>Phone / Contact</th>
            <td>{{ $inquiry->phone ?? 'Not provided' }}</td>
        </tr>
        <tr>
            <th>Company / Organization</th>
            <td>{{ $inquiry->company ?? 'Not provided' }}</td>
            <th>Requested Service</th>
            <td>{{ $inquiry->service ?? 'General Technical Inquiry' }}</td>
        </tr>
        <tr>
            <th>Budget Allocation</th>
            <td>{{ $inquiry->budget_range ?? 'Unspecified' }}</td>
            <th>Target Timeline</th>
            <td>{{ $inquiry->timeline ?? 'Standard' }}</td>
        </tr>
    </table>

    @if(!empty($inquiry->selected_features) && is_array($inquiry->selected_features))
    <div style="font-weight: 700; margin-top: 20px; font-size: 12px; text-transform: uppercase; color: #475569;">Selected Technical Features</div>
    <ul style="margin-top: 8px; padding-left: 20px; color: #334155;">
        @foreach($inquiry->selected_features as $feature)
            <li style="margin-bottom: 4px;">{{ is_array($feature) ? json_encode($feature) : $feature }}</li>
        @endforeach
    </ul>
    @endif

    <div style="font-weight: 700; margin-top: 20px; font-size: 12px; text-transform: uppercase; color: #475569;">Client Message & Requirements</div>
    <div class="message-box">
        {!! nl2br(e($inquiry->message ?: 'No additional message provided.')) !!}
    </div>

    <div class="footer">
        Confidential Document &bull; Softpolli Enterprise &bull; Generated on {{ date('Y-m-d H:i:s') }}
    </div>
</body>
</html>

