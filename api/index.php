<?php
/*
    I'm using this free open public API
    https://github.com/fawazahmed0/currency-api
    I use it to get 2 fields: time and uah
    One downside is that it updates only once a day
*/

$emailsFile = '../data/emails.txt';
$prefix = '/api';

function getCurrentRate()
{
    $apiUrl = 'https://cdn.jsdelivr.net/gh/fawazahmed0/currency-api@1/latest/currencies/btc/uah.json';
    $response = file_get_contents($apiUrl);
    $data = json_decode($response, true);
    if (isset($data['uah'])) {
        return $data['uah'];
    }
    return false;
}

function subscribeEmail($email)
{
    // I think it would be resonable to implement additional email validation here
    $emails = [];
    if (file_exists($GLOBALS['emailsFile'])) {
        $emails = file($GLOBALS['emailsFile'], FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
    }
    if (!in_array($email, $emails)) {
        $emails[] = $email;
        file_put_contents($GLOBALS['emailsFile'], implode(PHP_EOL, $emails));
        return true;
    }
    return false;
}

function sendEmails()
{
    $rate = getCurrentRate();
    if ($rate !== false) {
        $emails = [];
        if (file_exists($GLOBALS['emailsFile'])) {
            $emails = file($GLOBALS['emailsFile'], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        }
        if (!empty($emails)) {
            foreach ($emails as $email) {
                // Server should provide SMTP
                mail($email, 'BTC to UAH update', 'Current rate: ' . $rate);
            }
        }
        return true;
    }
    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($_SERVER['REQUEST_URI'] === $prefix.'/rate') {
        $rate = getCurrentRate();
        if ($rate !== false) {
            http_response_code(200);
            echo $rate;
        } else {
            http_response_code(400);
            echo 'Invalid status value';
        }
    } else {
        http_response_code(404);
        echo 'Not found.';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_SERVER['REQUEST_URI'] === $prefix.'/subscribe') {
        $requestData = json_decode(file_get_contents('php://input'), true);
        if (isset($requestData['email'])) {
            if (subscribeEmail($requestData['email'])) {
                http_response_code(200);
                echo 'Subscribed successfully.';
            } else {
                http_response_code(409);
                echo 'Email already subscribed.';
            }
        }
        // else { // I think it would be better to return 400 if "email" is missing
        //     http_response_code(400);
        //     echo 'Email missing in request.';
        // }
    } elseif ($_SERVER['REQUEST_URI'] === $prefix.'/sendEmails') {
        if (sendEmails()) {
            http_response_code(200);
            echo 'Emails sent successfully.';
        }
        // else { // I think it would be better to return 500 if email sending failed
        //     http_response_code(500);
        //     echo 'Failed to send emails.';
        // }
    } else {
        http_response_code(404);
        echo 'Not found.';
    }
} else {
    http_response_code(405);
    echo 'Method not allowed.';
}
?>