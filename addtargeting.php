<?php
error_reporting(1);
require 'vendor/autoload.php';

//use FacebookAds\Api;

// Add after echo "You are logged in "

// Initialize a new Session and instantiate an API object
/*
Api::init(
  '129906367827982', // App ID
  '58c4b6bbb3383346bbd5a16e7aaa8e82',
  '' // Your user access token
);
*/
//$me = new AdUser('me');
//$my_adaccount = $me->getAdAccounts()->current();
//print_r($my_adaccount->getData());
// Configurations

// Configurations - End
if (is_null($access_token) || is_null($app_id) || is_null($app_secret)) {
  throw new \Exception(
    'You must set your access token, app id and app secret before executing'
  );
}
if (is_null($account_id)) {
  throw new \Exception(
    'You must set your account id before executing');
}
define('SDK_DIR', __DIR__ . '/..'); // Path to the SDK directory
$loader = include 'vendor/autoload.php';
use FacebookAds\Api;
Api::init($app_id, $app_secret, $access_token);
// use the namespace for Custom Audiences and Fields
use FacebookAds\Object\CustomAudience;
use FacebookAds\Object\Fields\CustomAudienceFields;
use FacebookAds\Object\Values\CustomAudienceTypes;
use FacebookAds\Object\Values\CustomAudienceSubtypes;
// Create a custom audience object, setting the parent to be the account id
$audience = new CustomAudience(null, $account_id);
$audience->setData(array(
  CustomAudienceFields::NAME => 'My Custom Audiece',
  CustomAudienceFields::DESCRIPTION => 'Lots of people',
  CustomAudienceFields::SUBTYPE => CustomAudienceSubtypes::CUSTOM,
));
// Create the audience
$audience->create();
echo "Audience ID: " . $audience->id."\n";
// Assuming you have an array of emails:
// NOTE: The SDK will hash (SHA-2) your data before submitting
// it to Facebook servers
$emails = array(
  'pushprajkatiyar@gmail.com',
  'linierdataquest@gmail.com'
);
$audience->addUsers($emails, CustomAudienceTypes::EMAIL);
$audience->read(array(CustomAudienceFields::APPROXIMATE_COUNT));
echo "Estimated Size:"
  . $audience->{CustomAudienceFields::APPROXIMATE_COUNT}."\n";