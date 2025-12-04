<!DOCTYPE html>
<html>
<head>
    <title>Enter Code</title>
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f5f5f5;
            font-family: Arial, sans-serif;
        }

        input[type="text"] {
            padding: 15px;
            font-size: 24px;
            width: 200px;
            text-align: center;
            border: 2px solid #ccc;
            border-radius: 8px;
            outline: none;
            transition: 0.2s;
        }

        input[type="text"]:focus {
            border-color: #888;
        }

        form {
            margin: 0;
        }
    </style>
</head>
<body>

<form action="view.php" method="get">
    <input type="text" name="code" maxlength="4" autofocus required>
</form>

</body>
</html>
