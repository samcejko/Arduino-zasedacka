<?php
$input = file_get_contents('php://input');

if ($input) {
    $json = json_decode($input);
    if ($json !== null) {
        file_put_contents('events.json', json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        echo "OK";
    } else {
        http_response_code(400);
        echo "Bad JSON";
    }
}
?>