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

$spreadsheetId = "XXXXXXXXXXXXXXXXXXXXXXXXXXXXX";

$options = array('valueInputOption' => 'RAW');

$useragent=$_SERVER['HTTP_USER_AGENT'];
$user_id=$_SERVER['REMOTE_ADDR'];

$response = $service->spreadsheets_values->get($spreadsheetId, 'A2:J');
$values = $response->getValues();
$lastRowIpAddress = end($values)[9]; // Assuming IP address is in the 10th column (index 9)


echo('<pre>');
print_r( $lastRowIpAddress );
echo('</pre>');
die;

if( $lastRowIpAddress == $user_id ){
    echo json_encode([
        'success' => true
    ]);
    exit;
}

$values = [
    [        
        $_POST['Produit'],
        $_POST['Quantity'],
        $_POST['Nom'],
        $_POST['Tele'],
        $_POST['Address'],
        $_POST['Ville'],
        date("h:i:sa"),
        date("Y/m/d"),
        $useragent,
        $user_id,
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