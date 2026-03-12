<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get Queue Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --brand-900: #0f3c85;
            --brand-700: #1e55a6;
            --brand-100: #e8f1ff;
            --ink: #173154;
        }

        body {
            min-height: 100vh;
            margin: 0;
            font-family: Tahoma, Verdana, sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at 12% 14%, rgba(30, 85, 166, 0.12) 0%, rgba(30, 85, 166, 0) 45%),
                radial-gradient(circle at 88% 78%, rgba(15, 60, 133, 0.12) 0%, rgba(15, 60, 133, 0) 42%),
                linear-gradient(160deg, #f4f8ff 0%, #e9f2ff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .kiosk-wrap {
            width: 100%;
            max-width: 760px;
        }

        .kiosk-card {
            background: #ffffff;
            border: 1px solid #d7e5ff;
            border-radius: 18px;
            box-shadow: 0 14px 40px rgba(17, 64, 138, 0.14);
            overflow: hidden;
        }

        .kiosk-head {
            background: linear-gradient(135deg, var(--brand-900), var(--brand-700));
            color: #ffffff;
            text-align: center;
            padding: 22px 16px;
        }

        .kiosk-head h1 {
            margin: 0;
            font-size: clamp(1.4rem, 2.8vw, 1.9rem);
            letter-spacing: 0.4px;
            font-weight: 800;
        }

        .kiosk-head p {
            margin: 6px 0 0;
            font-size: 0.95rem;
            opacity: 0.92;
        }

        .kiosk-body {
            padding: 20px;
        }

        .field-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 700;
            font-size: 1.05rem;
        }

        .service-select {
            width: 100%;
            border: 1px solid #c6d8f6;
            border-radius: 12px;
            padding: 14px 16px;
            font-size: 1.08rem;
            color: #0f325b;
            background: #fff;
            outline: none;
        }

        .service-select:focus {
            border-color: #2d74d6;
            box-shadow: 0 0 0 3px rgba(45, 116, 214, 0.2);
        }

        .priority-row {
            margin-top: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.06rem;
            font-weight: 500;
        }

        .priority-row input {
            width: 22px;
            height: 22px;
            accent-color: var(--brand-700);
        }

        .ticket-btn {
            width: 100%;
            margin-top: 16px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #1f4f9b, #2d5db0);
            color: #fff;
            font-size: 1.9rem;
            font-weight: 800;
            letter-spacing: 0.4px;
            padding: 16px;
            cursor: pointer;
            transition: transform 0.15s ease, filter 0.15s ease;
        }

        .ticket-btn:hover {
            filter: brightness(1.04);
            transform: translateY(-1px);
        }

        .ticket-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .result-box {
            margin-top: 18px;
            border: 2px dashed #5f91de;
            border-radius: 14px;
            background: var(--brand-100);
            padding: 20px 16px;
            text-align: center;
            display: none;
        }

        .result-box.visible {
            display: block;
        }

        .result-title {
            margin: 0;
            font-size: 1.05rem;
            font-weight: 700;
            color: #21477f;
        }

        .result-queue {
            margin: 10px 0 8px;
            font-size: clamp(2.2rem, 8vw, 4rem);
            font-family: Consolas, monospace;
            font-weight: 900;
            color: #0f4b94;
            line-height: 1;
        }

        .result-note {
            margin: 0;
            font-size: 1rem;
            color: #2f5f96;
            font-weight: 600;
        }

        .error-box {
            margin-top: 16px;
            border-radius: 10px;
            background: #fee7e7;
            color: #8c1c1c;
            padding: 10px 12px;
            font-weight: 600;
            display: none;
        }

        .error-box.visible {
            display: block;
        }
    </style>
</head>
<body>
    <main class="kiosk-wrap">
        <section class="kiosk-card">
            <header class="kiosk-head">
                <h1><i class="fas fa-ticket-alt"></i> Queue Ticket Kiosk</h1>
                <p>Select your service to get a queue number</p>
            </header>

            <div class="kiosk-body">
                <form id="kioskForm">
                    <label for="kioskServiceType" class="field-label">Service Type</label>
                    <select id="kioskServiceType" class="service-select" required>
                        <option value="">Select service type</option>
                        <option value="bills">Bills</option>
                        <option value="complaints">Complaints</option>
                        <option value="customer_service">Customer Service</option>
                    </select>

                    <label class="priority-row" for="kioskPriority">
                        <input type="checkbox" id="kioskPriority">
                        <span>Priority Customer</span>
                    </label>

                    <button id="kioskSubmit" class="ticket-btn" type="submit">
                        <i class="fas fa-ticket-alt"></i>
                        Generate Queue Number
                    </button>
                </form>

                <div id="kioskError" class="error-box"></div>

                <div id="kioskResult" class="result-box" aria-live="polite">
                    <p class="result-title">Your Queue Number</p>
                    <p id="kioskQueueNumber" class="result-queue">---</p>
                    <p class="result-note">Please wait for your number to be called.</p>
                </div>
            </div>
        </section>
    </main>

    <script src="js/customer_kiosk.js"></script>
</body>
</html>
