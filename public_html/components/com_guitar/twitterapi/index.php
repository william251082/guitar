<?php

// Keys and Tokens
$consumerkey = 'nWOmB3AJAbfCRaJePYP2gOEWz';
$consumersecret = 'daqZ41um5tDwTWdK1kxedqLLqJdHADthM3CnqdCWqK7tT2YR6d';
$access_token = '394346626-nph5V9N2jDpkXYB91v72DfXclJnFxpo7WAMPkerP';
$access_token_secret = 'pOb3uzCHhITVrHdbfPpiggudAfbB5UMNDw3XzylBpdqlk';

// Include Library
require "twitteroauth/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

// Connect to api
$connection = new TwitterOAuth($consumerkey, $consumersecret, $access_token, $access_token_secret);
$content = $connection->get("account/verify_credentials");

// Create tweet
$new_status = $connection->post("statuses/update", ["status" => "Twitter tweet"]);

// Get tweets
$statuses = $connection->get("statuses/home_timeline", ["count" => 25, "exclude_replies" => true]);

print_r($statuses);