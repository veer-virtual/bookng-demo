<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

if (isset($_POST["productCode"]) && !empty($_POST["productCode"])) {
    $send_parameters =  http_build_query([
        'productCode' => $_POST["productCode"],
        'startTimeLocal' => $_POST["startTime"] . ' 00:00:00',
        'endTimeLocal' => date('Y-m-d', strtotime('+3 days', strtotime($_POST["startTime"]))) . ' 00:00:00'
    ]);
    $url = "https://api.rezdy-staging.com/v1/availability?apiKey=69f708868ddc45eaa1f9b9fad1ddeba5&" . $send_parameters;

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($curl);
    if (curl_errno($curl)) {
        echo 'Curl error: ' . curl_error($curl);
    }
    curl_close($curl);
    // echo $response;
    if ($response) {
        $decodeData = json_decode($response)->sessions;
        $availability = [];
        if (count($decodeData)) {
            foreach ($decodeData as $key => $value) {
                $newValue = [
                    'date' => date('d M Y', strtotime($value->startTimeLocal)),
                    'seat' => $value->seatsAvailable,
                ];
                $availability[] = $newValue;
            }
        } else {
            for ($i = 0; $i < 4; $i++) {
                $newValue = [
                    'date' => date('d M Y', strtotime(date('Y-m-d', strtotime('+'.$i.' days', strtotime($_POST["startTime"]))))),
                    'seat' => 0,
                ];
                $availability[] = $newValue;
            }
        }
        echo json_encode($availability);
        // $result = count($decodeData) ? $decodeData[0]->seatsAvailable : 0;
        // echo $result > 0 ? $result : 999999;
        exit;
    } else {
        echo "invalid product code";
        exit;
    }
} else {
    echo "invalid product code";
    exit;
}
