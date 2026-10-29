<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../vendor/google/apiclient/src/Client.php';
//google-api-php-client/src/Google_Client.php';
require_once '../vendor/google/apiclient-services/src/GoogleAnalyticsAdmin.php';
//require_once 'google-api-php-client/src/contrib/Google_AnalyticsService.php';

const API_KEY = 'G-71565BD8QX';

$client = new Google_Client();

// Set the API Key
$client->setDeveloperKey($API_KEY);

// Build the Analytics Service object.
$analytics = new google_AnalyticsService($client);

// Start coding cool things.
?>
