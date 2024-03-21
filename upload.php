<?php
include './config.php';

$form = $_POST;
$type = "buckets";
if(isset($form['type']) && !empty($form['type'])) {
    $type = $form['type'];
}

if($type == "buckets") {
    $dirPath = 'files/storage';
}else {
    $dirPath = 'files/hosting';
}

$folderName = '';
$wrappedDirectory = 'dirr';

$wrapWithDirectory = !empty($wrappedDirectory);
$files = array_diff(scandir($dirPath), array('.', '..'));

$uploadData = [];
foreach ($files as $file) {
    $filePath = $dirPath . '/' . $file;

    if (is_file($filePath)) {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($filePath);

        $uploadData[] = [
            'fileName' => $file,
            'contentType' => $mimeType,
            'filePath' => $filePath
        ];
    }
}

if (!empty($uploadData)) {
    $response = uploadToBucket($type, $uploadData, $folderName);
    echo json_encode($response, JSON_PRETTY_PRINT);
}else {
    echo json_encode([
        'status' => 0,
        'status_code' => 422,
        'message' => "No files to upload, make sure the files folder is filled with something",
        "info_error" => 'Failed to upload the file.',
        'data' => null
	], JSON_PRETTY_PRINT);
    die;
}
