<?php
try {
    $form = $_POST;

    if(empty($form['api_key'])) {
        echo json_encode([
            'status' => 0,
            'status_code' => 422,
            'message' => "Api Key Required",
            "info_error" => 'Failing validation, there may be fields that are not filled in.',
            'data' => null
        ], JSON_PRETTY_PRINT);
        die;
    }

    if(empty($form['api_key_secret'])) {
        echo json_encode([
            'status' => 0,
            'status_code' => 422,
            'message' => "Api Key Secret Required",
            "info_error" => 'Failing validation, there may be fields that are not filled in.',
            'data' => null
        ], JSON_PRETTY_PRINT);
        die;
    }

    if(empty($form['authentication'])) {
        echo json_encode([
            'status' => 0,
            'status_code' => 422,
            'message' => "Authentication Required",
            "info_error" => 'Failing validation, there may be fields that are not filled in.',
            'data' => null
        ], JSON_PRETTY_PRINT);
        die;
    }

    if(empty($form['storage_uuid'])) {
        echo json_encode([
            'status' => 0,
            'status_code' => 422,
            'message' => "Storage UUID Required",
            "info_error" => 'Failing validation, there may be fields that are not filled in.',
            'data' => null
        ], JSON_PRETTY_PRINT);
        die;
    }

    if(empty($form['hosting_uuid'])) {
        echo json_encode([
            'status' => 0,
            'status_code' => 422,
            'message' => "Hosting UUID Required",
            "info_error" => 'Failing validation, there may be fields that are not filled in.',
            'data' => null
        ], JSON_PRETTY_PRINT);
        die;
    }

    setcookie('onedionys_apillon_api_key', $form['api_key'], time() + 3600, '/');
    setcookie('onedionys_apillon_api_key_secret', $form['api_key_secret'], time() + 3600, '/');
    setcookie('onedionys_apillon_authentication', $form['authentication'], time() + 3600, '/');
    setcookie('onedionys_apillon_storage_uuid', $form['storage_uuid'], time() + 3600, '/');
    setcookie('onedionys_apillon_hosting_uuid', $form['hosting_uuid'], time() + 3600, '/');

	echo json_encode([
		'status' => 1,
		'status_code' => 200,
		'message' => "Successfully added the data into the cookie",
		"info_error" => null,
		'data' => null
	], JSON_PRETTY_PRINT);
    die;
} catch (Exception $e) {
	echo json_encode([
		'status' => 0,
		'status_code' => 422,
		'message' => "Failed to add data to the cookie",
		"info_error" => $e->getMessage(),
		'data' => null
	], JSON_PRETTY_PRINT);
    die;
}