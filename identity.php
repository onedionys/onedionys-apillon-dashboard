<?php
include './config.php';

$baseUrl = getBaseUrl();

function getBaseUrl() {
    $isHttps = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    $protocol = $isHttps ? 'https://' : 'http://';
    $serverName = $_SERVER['SERVER_NAME'];
    $port = $_SERVER['SERVER_PORT'];
    $portSuffix = (($isHttps && $port == 443) || (!$isHttps && $port == 80)) ? '' : ':' . $port;
    $baseUrlPath = dirname($_SERVER['PHP_SELF']);
    $baseUrl = $protocol . $serverName . $portSuffix . $baseUrlPath;

    return $baseUrl.'/';
}

$authorization = $_COOKIE['onedionys_apillon_authentication'];

$generate = callAPI('POST', "https://onedionys-identity-apillon.vercel.app/generate-message", [], $authorization, 'identity');
if (isset($generate->error)) {
    echo json_encode([
        'status' => 0,
        'status_code' => 422,
        'message' => "Error Generate Message: " . $generate->error,
        "info_error" => 'Failed to identity wallet.',
        'data' => null
    ], JSON_PRETTY_PRINT);
    die;
}else {
    $signature = callAPI('POST', "https://onedionys-identity-apillon.vercel.app/validate-signature", [], $authorization, 'identity');
    if (isset($signature->error)) {
        echo json_encode([
            'status' => 0,
            'status_code' => 422,
            'message' => "Error Validate Signature: " . $signature->error,
            "info_error" => 'Failed to identity wallet.',
            'data' => null
        ], JSON_PRETTY_PRINT);
        die;
    }else {
        $identity = callAPI('POST', "https://onedionys-identity-apillon.vercel.app/wallet-identity", [], $authorization, 'identity');
        if (isset($identity->error)) {
            echo json_encode([
                'status' => 0,
                'status_code' => 422,
                'message' => "Error Wallet Identity: " . $identity->error,
                "info_error" => 'Failed to identity wallet.',
                'data' => null
            ], JSON_PRETTY_PRINT);
            die;
        }

        echo json_encode([
            'status' => 1,
            'status_code' => 200,
            'message' => "Successfully completed wallet identity, please check the quest on the apillon website",
            "info_error" => null,
            'data' => []
        ], JSON_PRETTY_PRINT);
        die;
    }
}