<?php
try {
    if (isset($_COOKIE['onedionys_apillon_api_key'])) {
        setcookie('onedionys_apillon_api_key', '', time() - 3600, '/');
    }

    if (isset($_COOKIE['onedionys_apillon_api_key_secret'])) {
        setcookie('onedionys_apillon_api_key_secret', '', time() - 3600, '/');
    }

    if (isset($_COOKIE['onedionys_apillon_authentication'])) {
        setcookie('onedionys_apillon_authentication', '', time() - 3600, '/');
    }

    if (isset($_COOKIE['onedionys_apillon_storage_uuid'])) {
        setcookie('onedionys_apillon_storage_uuid', '', time() - 3600, '/');
    }

    if (isset($_COOKIE['onedionys_apillon_hosting_uuid'])) {
        setcookie('onedionys_apillon_hosting_uuid', '', time() - 3600, '/');
    }

	echo json_encode([
		'status' => 1,
		'status_code' => 200,
		'message' => "Successfully deleted the stored cookies",
		"info_error" => null,
		'data' => null
	], JSON_PRETTY_PRINT);
    die;
} catch (Exception $e) {
	echo json_encode([
		'status' => 0,
		'status_code' => 422,
		'message' => "Failed to delete the stored cookies",
		"info_error" => $e->getMessage(),
		'data' => null
	], JSON_PRETTY_PRINT);
    die;
}