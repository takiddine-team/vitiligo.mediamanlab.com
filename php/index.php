<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('Africa/Casablanca');

require __DIR__ . '/vendor/autoload.php';

// Dotenv
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();


$client = new Google_Client();
$client->setApplicationName('Google Sheets API PHP Quickstart');
$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
$client->setAccessType('offline');
$client->setAuthConfig( __DIR__ .'/credentials.json');

$service = new Google_Service_Sheets($client);


$spreadsheetId = '1UVxEqROAtJsiUt0y3oN_G5n4QWTdwpWbfogBS7PJnx8';

$options = array('valueInputOption' => 'RAW');



$values = [
    [        
        $_POST['quantity'],
        $_POST['fullname'],
        $_POST['phone'],
        $_POST['Address'],
        date("h:i:sa"),
        date("Y/m/d"),
    ]
];

$body   = new Google_Service_Sheets_ValueRange(['values' => $values]);

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $result = $service->spreadsheets_values->append($spreadsheetId, 'A1:C1', $body, $options);
    // print_r($result);

} else {

    echo json_encode([
        'success' => true
    ]);
    exit;
}

echo json_encode([
    'success' => true
]);

exit;