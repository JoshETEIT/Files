<?php
session_start();

if (!isset($_SESSION['gallery_code']) || $_SESSION['gallery_code'] !== '1337') {
    header("Location: index.php");
    exit;
}

// If no POST yet → show upload form
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
?>
<!DOCTYPE html>
<html>
<head>
<title>Upload</title>
<style>
    body {
        background: #f5f5f5;
        font-family: Arial;
        margin: 0;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .box {
        background: white;
        padding: 30px;
        border-radius: 10px;
        width: 350px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        text-align: center;
    }
    input, button {
        width: 100%;
        padding: 12px;
        border-radius: 6px;
        border: 1px solid #ccc;
        margin-top: 10px;
    }
    button {
        background: black;
        color: white;
        cursor: pointer;
    }
</style>
</head>
<body>

<div class="box">
    <h2>Upload Album</h2>

    <form method="post" enctype="multipart/form-data">
        <input type="text" name="newcode" placeholder="Album code" required>
        <input type="file" name="photos[]" multiple required>
        <button type="submit">Upload</button>
    </form>
</div>

</body>
</html>
<?php
exit;
}


// --------------------
// Handle upload
// --------------------

$newcode = preg_replace('/[^a-zA-Z0-9_-]/', '', $_POST['newcode']);
$files = $_FILES['photos'] ?? null;

if ($newcode === '' || empty($files) || empty($files['tmp_name'][0])) {
    exit("Invalid album code or no files uploaded.");
}

$folder = __DIR__ . "/images/" . $newcode;

if (!is_dir($folder)) {
    mkdir($folder, 0777, true);
}

foreach ($files['tmp_name'] as $i => $tmp) {
    if ($tmp !== '') {
        $ext = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
        $name = uniqid() . '.' . $ext;
        move_uploaded_file($tmp, $folder . "/" . $name);
    }
}

// Save album in session so view.php loads it
$_SESSION['gallery_code'] = $newcode;

header("Location: view.php", true, 303);
exit;
?>
