<?php

function Post(): mixed
{
    if ($_SERVER['REQUEST_METHOD'] != "POST") {
        return null;
    }

    $content_type = isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : '';

    if (strpos($content_type, 'application/json') !== false) {
        $postData = json_decode(file_get_contents('php://input'));
    } else {
        $postData = (object)$_POST;
    }

    return $postData;
}

function Get(): object|null
{
    if ($_SERVER['REQUEST_METHOD'] != "GET") {
        return null;
    }

    $queryString = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';

    parse_str($queryString, $queryParams);

    return (object)$queryParams;
}

function verify_post_method(): void
{
    if ($_SERVER['REQUEST_METHOD'] != "POST") {
        echo json_encode([
            "status" => "error",
            "message" => "invalid_method"
        ]);
        exit;
    }

}
function verify_get_method(): void
{
    if ($_SERVER['REQUEST_METHOD'] != "GET") {
        echo json_encode([
            "status" => "error",
            "message" => "invalid_method"
        ]);
    }
    return;
}

function TreatedJson($arr): bool|string
{
    $json = json_encode($arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    if (json_last_error() !== JSON_ERROR_NONE) {
        return json_last_error_msg();
    }
    return $json;
}

function makePostRequest($url, $postData): bool|string {
    // Initialize cURL session
    $ch = curl_init($url);

    // Encode the data array into a JSON string
    $payload = json_encode($postData);

    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
    curl_setopt($ch, CURLOPT_POST, true); // Set the request method to POST
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload); // Attach the payload to the request
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json', // Specify that the request body is JSON
        'Content-Length: ' . strlen($payload) // Specify the length of the request body
    ]);

   
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }

    curl_close($ch);

    return $response;
}

function header_json(): void {
    header('Content-Type: application/json');
}

/**
 * Rodrigo Monteiro Junior (TsukiGva2)
 * sex 23 ago 2024 11:20:12
 *
 * converte uma string no formato "HH:mm:ss" (H:i:s)
 *
 * @param  string $str	String que vai ser convertida
 * @return DateTime     Objeto DateTime do PHP
 **/
function stringToDateTime(string $str) {
	return DateTime::createFromFormat("H:i:s", $str);
}

/** 
 * Rodrigo Monteiro Junior (TsukiGva2)
 * sex 23 ago 2024 16:40:52 -03
 *
 * converte um objeto DateTime para o formato "H:i:s" ou "HH:mm:ss"
 *
 * @param  DateTime $dt	String que vai ser convertida
 * @return string 	Objeto DateTime do PHP
 **/
function dateTimeToString(DateTime $dt) {
	return $dt->format("H:i:s");
}

function printData($data, $die = true) {

    echo "<pre>";
    if(is_object($data) || is_array($data)) {
        print_r($data);
    }
    else {
        die(PHP_EOL . "END" . PHP_EOL);
    }

}

function isValidInteger($value, $min = PHP_INT_MIN, $max = PHP_INT_MAX) {
    return is_numeric($value) && intval($value) == $value && $value >= $min && $value <= $max;
}