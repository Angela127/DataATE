<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Confirm Booking</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <style>
        :root {
            --primary-color: #bd4e73ff;
            --primary-hover: #cd3a70ff;
            --secondary-color: #f3e5f5;
            --background-color: #bac3d1ff; /* ✅ True pale sky-blue background */
            --text-color: #2c3e50;
            --text-secondary: #7f8c8d;
            --card-bg: #ffffff;
            --border-color: #d6e5f3;
            --shadow: 0 6px 18px rgba(130, 160, 220, 0.08); /* Cool-toned shadow */
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
            padding: 20px;
            min-height: 100vh;
            transition: background-color 0.3s ease;
        }

        .container {
            max-width: 480px;
            margin: 0 auto;
        }

        /* Header - Centered Title */
        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 16px 0 24px;
            margin-bottom: 20px;
        }

        .back-button {
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--card-bg);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-color);
            font-size: 24px;
            cursor: pointer;
            transition: all 0.2s ease;
            z-index: 2;
        }

        .back-button:hover {
            background-color: #f8fbff;
            transform: translateY(-50%) scale(1.05);
        }

        .header-title {
            font-size: 22px;
            font-weight: 700;
            color: var(--text-color);
            text-align: center;
            letter-spacing: -0.4px;
        }

        /* Instruction */
        .qr-instruction {
            text-align: center;
            font-size: 16px;
            color: var(--text-secondary);
            margin-bottom: 16px;
            font-weight: 500;
            padding: 0 10px;
        }

        /* QR Section */
        .qr-container {
            background-color: var(--card-bg);
            border-radius: 16px;
            padding: 28px;
            box-shadow: var(--shadow);
            margin-bottom: 30px;
            text-align: center;
            border: 1px dashed var(--border-color);
        }

        .qr-code {
            width: 260px;
            height: 260px;
            background-color: var(--primary-color);
            padding: 20px;
            border-radius: 12px;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(233, 30, 99, 0.2);
            border: 4px solid white;
        }

        .qr-code-content {
            color: white;
            font-size: 14px;
            text-align: center;
            font-weight: bold;
        }

        .qr-label {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        /* Upload Button */
        .upload-area {
            margin: 0 20px 20px;
            text-align: center;
        }

        .upload-button {
            background-color: var(--secondary-color);
            border: none;
            border-radius: 14px;
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            cursor: pointer;
            transition: all 0.25s ease;
            font-size: 16px;
            font-weight: 600;
            color: var(--primary-color);
            width: 100%;
            margin: 0 auto;
            box-shadow: 0 2px 8px rgba(225, 190, 237, 0.4);
        }

        .upload-button:hover {
            background-color: #dfc0e8;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(225, 190, 237, 0.5);
        }

        .upload-button svg {
            color: var(--primary-color);
        }

        .upload-button span {
            color: var(--primary-color);
        }

        /* Preview */
        .preview-container {
            text-align: center;
            margin: 16px 20px;
        }

        #preview {
            max-width: 100%;
            max-height: 300px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            display: none;
        }

        #filename {
            margin-top: 12px;
            font-size: 14px;
            color: var(--text-secondary);
        }

        /* Submit Button */
        .submit-button {
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 16px;
            padding: 18px 32px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            display: block;
            width: calc(100% - 40px);
            margin: 30px 20px 0;
            box-shadow: 0 6px 16px rgba(233, 30, 99, 0.3);
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .submit-button:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(233, 30, 99, 0.4);
        }

        .submit-button:active {
            transform: translateY(0);
        }

        /* Responsive */
        @media (max-width: 480px) {
            .header-title {
                font-size: 20px;
            }

            .qr-code {
                width: 220px;
                height: 220px;
                padding: 16px;
            }

            .upload-button {
                padding: 14px 18px;
                font-size: 15px;
                gap: 8px;
            }

            .submit-button {
                padding: 16px;
                font-size: 16px;
            }

            .qr-instruction {
                font-size: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="back-button">←</div>
            <h1 class="header-title">Confirm Booking</h1>
        </div>

        <!-- Form -->
        <form action="{{ route('payment.storeReceipt') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
            @csrf

            <p class="qr-instruction">
                Please scan the QR code below using your banking app to complete the payment.
            </p>

            <!-- QR Code -->
            <div class="qr-container">
               <div class="qr-code">
    <img 
        src="{{ asset('image/my_QR_TNG.jpeg') }}" 
        alt="Touch 'n Go Payment QR Code" 
        style="width: 100%; height: 100%; object-fit: contain;"
    />
</div>
                <div class="qr-label">Malaysia National QR</div>
            </div>

            <!-- Upload -->
            <div class="upload-area">
                <label for="receipt" class="upload-button" id="uploadLabel">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="17 8 12 3 7 8"></polyline>
                        <line x1="12" y1="3" x2="12" y2="15"></line>
                    </svg>
                    <span id="uploadText">Upload Payment Receipt</span>
                </label>
                <input type="file" name="receipt" id="receipt" accept="image/*,application/pdf" style="display: none;" required />
            </div>

            <!-- Preview -->
            <div class="preview-container">
                <img id="preview" src="#" alt="Preview" />
                <p id="filename"></p>
            </div>

            <!-- Submit -->
            <button type="submit" class="submit-button">Confirm & Book Now</button>
        </form>
    </div>

    <!-- Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fileInput = document.getElementById('receipt');
            const uploadLabel = document.getElementById('uploadLabel');
            const uploadText = document.getElementById('uploadText');
            const preview = document.getElementById('preview');
            const filename = document.getElementById('filename');
            const backButton = document.querySelector('.back-button');

            if (backButton) {
                backButton.addEventListener('click', function () {
                    window.history.back();
                });
            }

            fileInput.addEventListener('change', function () {
                const file = fileInput.files[0];
                if (!file) return;

                filename.textContent = 'Selected: ' + file.name;

                if (file.type.startsWith('image/')) {
                    preview.src = URL.createObjectURL(file);
                    preview.style.display = 'block';
                } else {
                    preview.style.display = 'none';
                    filename.textContent += ' (PDF)';
                }

                uploadText.textContent = 'Change Receipt';
            });

            uploadLabel.addEventListener('click', function (e) {
                e.preventDefault();
                fileInput.click();
            });
        });
    </script>
</body>
</html>