<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Refund - HASTA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fef9f3;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            width: 100%;
            max-width: 500px;
            text-align: center;
        }

        h2 {
            color: #ff6b35;
            margin-bottom: 20px;
        }

        p {
            color: #666;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
        }

        input:focus {
            outline: none;
            border-color: #ff6b35;
        }

        .btn-submit {
            background-color: #ff6b35;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
            transition: background-color 0.2s;
        }

        .btn-submit:hover {
            background-color: #e55a2b;
        }
        
        .alert {
            background-color: #fff3cd;
            color: #856404;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: left;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Refund Request</h2>
    
    <div class="alert">
        <strong>Payment Issue:</strong> Your previous payment was marked as "Incorrect Amount". 
        Please provide your bank details below so we can process a refund for the amount you transferred.
    </div>

    <p>
        Rental: {{ $rental->car->model ?? 'Car' }} ({{ $rental->plate_no }})<br>
        Date: {{ \Carbon\Carbon::parse($rental->start_time)->format('Y-m-d') }}
    </p>

    <form action="{{ route('payment.refund.store', $rental->id) }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="bank_name">Bank Name</label>
            <input type="text" id="bank_name" name="bank_name" placeholder="e.g. Maybank, CIMB" required>
        </div>

        <div class="form-group">
            <label for="bank_account">Bank Account Number</label>
            <input type="text" id="bank_account" name="bank_account" placeholder="Enter account number" required>
        </div>

        <button type="submit" class="btn-submit">Submit Refund Details</button>
    </form>
</div>

</body>
</html>
