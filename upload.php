<?php
$newcode = $_POST['newcode'] ?? '';
$files = $_FILES['photos'] ?? null;

$folder = __DIR__ . "/images/" . $newcode;

// Create folder if it doesn't exist
if (!is_dir($folder)) {
    mkdir($folder, 0777, true);
}

// Save each uploaded file
foreach ($files['tmp_name'] as $index => $tmpPath) {
    if ($tmpPath != '') {
        $name = basename($files['name'][$index]);
        move_uploaded_file($tmpPath, $folder . "/" . $name);
    }
}

// Redirect to the new album
header("Location: view.php?code=" . urlencode($newcode));
exit;
