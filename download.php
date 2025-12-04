<?php
$code = preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['code'] ?? '');
$folder = __DIR__ . "/images/$code";

if (!is_dir($folder)) exit("Invalid album.");

$zip = new ZipArchive();
$zipFile = tempnam(sys_get_temp_dir(), 'zip');
$zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE);

$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folder));
foreach($files as $file){
    if(!$file->isDir()){
        $zip->addFile($file->getRealPath(), $file->getFilename());
    }
}
$zip->close();

header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="'.$code.'.zip"');
readfile($zipFile);
unlink($zipFile);
exit;
?>
