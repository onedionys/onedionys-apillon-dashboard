<?php
include './config.php';

function createCollection($collectionData) {
    global $authorization;
    $url = "https://api.apillon.io/nfts/collections";
  
    $response = callAPI('POST', $url, $collectionData, $authorization);
    if (isset($response->error)) {
        return [
            'status' => 0,
            'status_code' => 422,
            'message' => "Error Creating Collection: " . $response->error,
            "info_error" => 'Failed to mint nfts.',
            'data' => null
        ];
    }
  
    return [
        'status' => 1,
        'status_code' => 200,
        'message' => "New collection with UUID " . $response->data->collectionUuid . " created successfully!",
        "info_error" => null,
        'data' => $response->data->collectionUuid
    ];
}
  
function mintNFT($collectionUuid, $mintData) {
    global $authorization;
    $url = "https://api.apillon.io/nfts/collections/$collectionUuid/mint";
  
    $response = callAPI('POST', $url, $mintData, $authorization);
    if (isset($response->error)) {
         return [
            'status' => 0,
            'status_code' => 422,
            'message' => "Error Minting NFTs: " . $response->error,
            "info_error" => 'Failed to mint nfts.',
            'data' => null
        ];
    }
  
    if ($response->status == 201) {
        return [
            'status' => 1,
            'status_code' => 200,
            'message' => "Successfully mint nfts, please check on the apillon website",
            "info_error" => null,
            'data' => []
        ];
    } else {
        return [
            'status' => 0,
            'status_code' => 422,
            'message' => "Failed to mint nfts, please contact admin",
            "info_error" => 'Failed to mint nfts.',
            'data' => null
        ];
    }
}
  

$collectionData = [
    "chain" => 1287,
    "collectionType" => 1,
    "name" => 'Space Explorers',
    "description" => 'Space Explorers NFT collection',
    "symbol" => 'SPCE',
    "royaltiesFees" => 0,
    "royaltiesAddress" => '0x0000000000000000000000000000000000000000',
    "baseUri" => 'https://test.com/metadata/',
    "baseExtension" => '.json',
    "maxSupply" => 100,
    "isRevokable" => false,
    "isSoulbound" => false,
    "drop" => true,
    "dropStart" => 1730415600,
    "dropPrice" => 0.1,
    "dropReserve" => 5
];
  
$mintData = [
    "receivingAddress" => "0xdAC17F958D2ee523a2206206994597C13D831ec7",
    "quantity" => 1
];
  
$collectionUuid = createCollection($collectionData);
if ($collectionUuid['status'] == 1) {
    $responseMint = mintNFT($collectionUuid['data'], $mintData);
    echo json_encode($responseMint, JSON_PRETTY_PRINT);
}else {
    echo json_encode($collectionUuid, JSON_PRETTY_PRINT);
}