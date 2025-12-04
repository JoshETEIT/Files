<?php
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $code = $_POST['code'] ?? '';
    $code = preg_replace('/[^a-zA-Z0-9_-]/', '', $code);

    // Admin upload shortcut
    if ($code === '1337') {
        $_SESSION['gallery_code'] = '1337';
        header("Location: upload.php");
        exit;
    }

    $folder = __DIR__ . "/images/" . $code;

    if (!is_dir($folder)) {
        $error = "No files found for code: " . htmlspecialchars($code);
    } else {
        $_SESSION['gallery_code'] = $code;
        header("Location: view.php");
        exit;
    }
}
?>
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
        .box {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            text-align: center;
            min-width: 300px;
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
        .error {
            color: red;
            margin-top: 15px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="box">
    <form action="" method="post">
        <input type="text" name="code" maxlength="10" autofocus required>
    </form>

    <?php if ($error): ?>
    <div class="error"><?= $error ?></div>
    <?php endif; ?>
</div>

</body>
</html>
