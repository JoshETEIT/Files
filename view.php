<?php
session_start();

$code = $_SESSION['gallery_code'] ?? '';

if ($code === '') {
    header("Location: index.php");
    exit;
}

$folder = __DIR__ . "/images/" . $code;

if (!is_dir($folder)) {
    header("Location: index.php");
    exit;
}

$files = array_diff(scandir($folder), ['.', '..']);

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
<title>Gallery</title>
<style>
    body { margin: 0; font-family: Arial; background: #fafafa; }

    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 15px;
        padding: 20px;
        max-width: 1300px;
        margin: auto;
    }

    .grid-item,
    .file-item {
        position: relative;
        width: 100%;
        aspect-ratio: 1/1;
        border-radius: 8px;
        overflow: hidden;
        background: #eee;
        transition: .25s;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .grid-item:hover,
    .file-item:hover {
        transform: scale(1.05);
    }

    .grid-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        pointer-events: none;
    }

    .file-item {
        background: #f8f8f8;
        border: 1px solid #e2e2e2;
        flex-direction: column;
    }

    .file-icon-box {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 46px;
    }

    .filename {
        background: white;
        padding: 6px;
        font-size: 13px;
        text-align: center;
        width: 100%;
    }

    /* Remove hyperlink styling from file items */
.file-item a,
.file-item a:link,
.file-item a:visited,
.file-item a:hover,
.file-item a:active {
    text-decoration: none;
    color: inherit;
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
}


    /* Modal */
    .modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.9);
        justify-content: center;
        align-items: center;
        flex-direction: column;
        z-index: 9999;
    }

    .modal img {
        max-width: 90vw;
        max-height: 80vh;
        border-radius: 8px;
    }

    .modal-close {
        position: absolute;
        top: 20px;
        right: 30px;
        font-size: 40px;
        color: white;
        cursor: pointer;
    }

    .modal-download-wrapper {
        margin-top: 25px;
        text-align: center;
    }
    .modal-download-wrapper a {
        padding: 10px 25px;
        background: white;
        border-radius: 6px;
        text-decoration: none;
        color: black;
        border: 1px solid #ccc;
    }

    .zip-btn {
        display: block;
        margin: 20px auto;
        padding: 12px 25px;
        width: 200px;
        text-align: center;
        background: black;
        color: white;
        border-radius: 6px;
        text-decoration: none;
        font-size: 15px;
    }
</style>
</head>
<body>

<a class="zip-btn" href="download.php?code=<?= urlencode($code) ?>">Download ZIP</a>

<div class="grid">

<?php foreach ($images as $img): ?>
<div class="grid-item" data-img="images/<?= $code ?>/<?= urlencode($img) ?>">
    <img src="images/<?= $code ?>/<?= urlencode($img) ?>">
</div>
<?php endforeach; ?>

<?php foreach ($otherFiles as $file): ?>
<div class="file-item">
    <a href="images/<?= $code ?>/<?= urlencode($file) ?>" download>
        <div class="file-icon-box">📄</div>
        <div class="filename"><?= htmlspecialchars($file) ?></div>
    </a>
</div>
<?php endforeach; ?>

</div>


<!-- Modal -->
<div id="modal" class="modal">
    <span id="closeModal" class="modal-close">&times;</span>

    <img id="modalImg">

    <div class="modal-download-wrapper">
        <a id="modalDownload" href="#" download>Download</a>
    </div>
</div>

<script>
const modal = document.getElementById("modal");
const modalImg = document.getElementById("modalImg");
const modalDownload = document.getElementById("modalDownload");
const closeModal = document.getElementById("closeModal");

document.querySelectorAll(".grid-item").forEach(item => {
    item.addEventListener("click", () => {
        let src = item.getAttribute("data-img");
        modalImg.src = src;
        modalDownload.href = src;
        modal.style.display = "flex";
    });
});

closeModal.onclick = () => modal.style.display = "none";
modal.onclick = e => { if (e.target === modal) modal.style.display = "none"; };
</script>

</body>
</html>
