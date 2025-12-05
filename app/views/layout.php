<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MVC PDO CRUD</title>
    <link rel="icon" type="png" href="UTM-LOGO-FULL.png">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #172B4C;
            min-height: 100vh;
            padding: 20px;
        }
        
        .main-container {
            max-width: 900px;
            margin: 0 auto;
            background: #FAF6EC;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 40px;
        }
        
        /* Form Container Styles */
        /*.container {
            background: #FAF6EC;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 500px;
            width: 100%;
            padding: 40px;
            margin: 0 auto;
        }*/
        
        /* Header Styles */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e0e0e0;
        }
        
        header h2 {
            color: #172B4C;
            font-size: 1.8rem;
        }
        
        header a[role="button"] {
            background: #172B4C;
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        header a[role="button"]:hover {
            background: #2a4a7a;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        /* Form Input Styles */
        input[type="text"], 
        input[type="email"], 
        input[type="date"], 
        textarea {
            width: 100%;
            padding: 12px 15px;
            margin-top: 5px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            background: #f8f9fa;
            box-sizing: border-box; 
            font-family: inherit;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        label {
            font-weight: 500;
            color: #172B4C;
        }

        /* Button Styles */
        .submit-btn {
            width: 100%;
            padding: 14px;
            background: white;
            color: black;
            border: 2px solid #172B4C;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 400;
            margin-top: 10px;
            box-sizing: border-box;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .submit-btn:hover {
            color: white;
            background-color: #172B4C;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        .backLink {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #172B4C;
            font-weight: 500;
        }

        .backLink:hover {
            text-decoration: underline;
        }
        /* Toggle Switch Styles */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
            margin-right: 10px;
            vertical-align: middle;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: 0.4s;
            border-radius: 24px;
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        .toggle-switch input:checked + .toggle-slider {
            background-color: #4CAF50;
        }

        .toggle-switch input:checked + .toggle-slider:before {
            transform: translateX(26px);
        }

        .status-text {
            font-weight: 500;
            vertical-align: middle;
        }
        
        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        
        th {
            background: #172B4C;
            color: white;
        }
        
        th:first-child {
            border-radius: 10px 0 0 0;
        }
        
        th:last-child {
            border-radius: 0 10px 0 0;
        }
        
        tr:hover {
            background: #f5f5f5;
        }
        
        td a {
            color: #172B4C;
            text-decoration: none;
            margin-right: 10px;
            padding: 5px 10px;
            border: 1px solid #172B4C;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        
        td a:hover {
            background: #172B4C;
            color: white;
        }
        
        button[type="submit"] {
            background: #172B4C;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        button[type="submit"]:hover {
            background: #2a4a7a;
        }

        /* Center content for form pages */
        body.form-page {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        body.form-page .main-container {
            padding: 0;
            background: transparent;
            box-shadow: none;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <?php include '../app/views/partials/flash.php'; ?>
        <?php echo $content; ?>
    </div>
</body>
</html>