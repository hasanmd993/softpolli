<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Lead Inquiry - SoftPolli</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            margin: 0;
            padding: 30px 15px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }
        .header {
            background-color: #0f172a;
            padding: 24px 32px;
            border-bottom: 3px solid #f1592a;
        }
        .header h1 {
            color: #ffffff;
            font-size: 20px;
            margin: 0;
            font-weight: 700;
        }
        .header p {
            color: #94a3b8;
            font-size: 13px;
            margin: 4px 0 0;
        }
        .body {
            padding: 32px;
        }
        .badge {
            display: inline-block;
            padding: 4px 10px;
            font-size: 11px;
            font-weight: 700;
            border-radius: 9999px;
            text-transform: uppercase;
            background: #fff7ed;
            color: #ea580c;
            border: 1px solid #ffedd5;
            margin-bottom: 20px;
        }
        .field {
            margin-bottom: 16px;
        }
        .field-label {
            font-size: 11px;
            text-transform: uppercase;
            font-weight: 700;
            color: #64748b;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .field-value {
            font-size: 14px;
            color: #0f172a;
            font-weight: 500;
        }
        .message-box {
            background-color: #f1f5f9;
            border-left: 4px solid #f1592a;
            padding: 16px;
            border-radius: 8px;
            font-size: 14px;
            line-height: 1.6;
            margin-top: 20px;
            white-space: pre-line;
        }
        .features-list {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 4px;
        }
        .feature-tag {
            background: #e2e8f0;
            color: #334155;
            font-size: 12px;
            padding: 2px 8px;
            border-radius: 6px;
        }
        .footer {
            background: #f8fafc;
            padding: 20px 32px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
            font-size: 12px;
            color: #94a3b8;
        }
        .btn {
            display: inline-block;
            background: #f1592a;
            color: #ffffff !important;
            padding: 10px 20px;
            font-weight: 700;
            font-size: 13px;
            border-radius: 8px;
            text-decoration: none;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>SoftPolli Back-Office</h1>
            <p>New Inbound Prospect Lead</p>
        </div>
        <div class="body">
            <span class="badge">{{ strtoupper($inquiry->type) }} INQUIRY</span>

            <div class="field">
                <div class="field-label">Prospect Name</div>
                <div class="field-value">{{ $inquiry->name }}</div>
            </div>

            <div class="field">
                <div class="field-label">Email Address</div>
                <div class="field-value"><a href="mailto:{{ $inquiry->email }}">{{ $inquiry->email }}</a></div>
            </div>

            @if($inquiry->phone)
            <div class="field">
                <div class="field-label">Phone Number</div>
                <div class="field-value"><a href="tel:{{ $inquiry->phone }}">{{ $inquiry->phone }}</a></div>
            </div>
            @endif

            @if($inquiry->company)
            <div class="field">
                <div class="field-label">Company / Organization</div>
                <div class="field-value">{{ $inquiry->company }}</div>
            </div>
            @endif

            @if($inquiry->service)
            <div class="field">
                <div class="field-label">Service Required</div>
                <div class="field-value"><strong>{{ $inquiry->service }}</strong></div>
            </div>
            @endif

            @if(!empty($inquiry->selected_features) && is_array($inquiry->selected_features))
            <div class="field">
                <div class="field-label">Selected Specifications / Features</div>
                <div class="features-list">
                    @foreach($inquiry->selected_features as $feature)
                        <span class="feature-tag">{{ $feature }}</span>
                    @endforeach
                </div>
            </div>
            @endif

            @if($inquiry->budget_range)
            <div class="field">
                <div class="field-label">Estimated Budget</div>
                <div class="field-value">{{ $inquiry->budget_range }}</div>
            </div>
            @endif

            @if($inquiry->timeline)
            <div class="field">
                <div class="field-label">Target Timeline</div>
                <div class="field-value">{{ $inquiry->timeline }}</div>
            </div>
            @endif

            @if($inquiry->message)
            <div class="field">
                <div class="field-label">Client Notes & Message</div>
                <div class="message-box">{{ $inquiry->message }}</div>
            </div>
            @endif

            <a href="{{ url('/admin/inquiries') }}" class="btn">View in Admin Panel &rarr;</a>
        </div>
        <div class="footer">
            Automated lead dispatch generated by SoftPolli Agency System &bull; {{ date('Y') }}
        </div>
    </div>
</body>
</html>
