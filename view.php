<?php
$code = $_GET['code'] ?? '';
$imagesBase = __DIR__ . "/images/";

// ------------------------------------------------------
// 1. Admin upload form
// ------------------------------------------------------
if ($code === '1337') {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Create Album</title>
        <style>
            body { font-family: Arial; background: #fafafa; padding: 40px; }
            .box { background: white; padding: 20px; max-width: 500px; margin: auto; border-radius: 8px; }
            input, button { padding: 10px; margin: 5px 0; width: 100%; }
        </style>
    </head>
    <body>

    <div class="box">
        <h2>Create New Album</h2>

        <form action="upload.php" method="post" enctype="multipart/form-data">
            <label>Album Code:</label>
            <input type="text" name="newcode" maxlength="10" required>

            <label>Select Files:</label>
            <input type="file" name="photos[]" multiple required>

            <button type="submit">Upload</button>
        </form>
    </div>

    </body>
    </html>
    <?php
    exit;
}

// ------------------------------------------------------
// 2. Normal user: Load an album
// ------------------------------------------------------
$folder = $imagesBase . $code;

if (!is_dir($folder)) {
    echo "<h3 style='text-align:center;font-family:Arial;margin-top:40px;'>No files found for code: $code</h3>";
    exit;
}

// Get all files
$files = array_diff(scandir($folder), ['.', '..']);

// Separate images and other files
$images = [];
$otherFiles = [];
foreach ($files as $file) {
    if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $file)) {
        $images[] = $file;
    } else {
        $otherFiles[] = $file;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gallery <?php echo htmlspecialchars($code); ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #fafafa; }
        h1 { text-align: center; padding: 20px 0; margin: 0; font-size: 28px; }

        /* Image gallery (old style) */
        .image-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 12px;
            padding: 20px;
            max-width: 1200px;
            margin: auto;
        }
        .image-gallery img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
        }

        /* Other files gallery */
.file-gallery {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 16px;
    padding: 20px;
    max-width: 1200px;
    margin: auto;
    text-align: center; /* center icons without a box */
}

.file-item {
    cursor: pointer; /* just clickable, no box */
}

.file-item .icon {
    font-size: 48px;
}

.file-item .filename {
    margin-top: 8px;
    font-size: 14px;
    word-wrap: break-word;
}

    </style>
</head>
<body>

<h1>Welcome <?php echo htmlspecialchars($code); ?></h1>

<?php
// Display images
if (!empty($images)) {
    echo '<div class="image-gallery">';
    foreach ($images as $file) {
        $url = 'images/' . urlencode($code . '/' . $file);
        echo '<a href="' . $url . '" download><img src="' . $url . '"></a>';
    }
    echo '</div>';
}

// Display other files
if (!empty($otherFiles)) {
    echo '<div class="file-gallery">';
    foreach ($otherFiles as $file) {
        $url = 'images/' . urlencode($code . '/' . $file);
        echo '<div class="file-item">';
        echo '<a href="' . $url . '" download><div class="icon">📄</div></a>';
        echo '<div class="filename">' . htmlspecialchars($file) . '</div>';
        echo '</div>';
    }
    echo '</div>';
}
?>

</body>
</html>
