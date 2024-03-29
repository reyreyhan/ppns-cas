<?php

/**
 *   Example for a simple cas 2.0 client
 *
 * PHP Version 5
 *
 * @file     example_simple.php
 * @category Authentication
 * @package  PhpCAS
 * @author   Joachim Fritschi <jfritschi@freenet.de>
 * @author   Adam Franco <afranco@middlebury.edu>
 * @license  http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link     https://wiki.jasig.org/display/CASC/phpCAS
 */

// Load the settings from the central config file
require_once 'config.php';
// Load the CAS lib
require_once 'vendor/apereo/phpcas/CAS.php';

// Enable debugging
phpCAS::setDebug('cas.log');
// Enable verbose error messages. Disable in production!

phpCAS::setVerbose(true);

// Initialize phpCAS
phpCAS::client(CAS_VERSION_3_0, $cas_host, $cas_port, $cas_context);

// For production use set the CA certificate that is the issuer of the cert
// on the CAS server and uncomment the line below
// phpCAS::setCasServerCACert($cas_server_ca_cert_path);

// For quick testing you can disable SSL validation of the CAS server.
// THIS SETTING IS NOT RECOMMENDED FOR PRODUCTION.
// VALIDATING THE CAS SERVER IS CRUCIAL TO THE SECURITY OF THE CAS PROTOCOL!
phpCAS::setNoCasServerValidation();

// force CAS authentication
phpCAS::forceAuthentication();

// at this step, the user has been authenticated by the CAS server
// and the user's login name can be read with phpCAS::getUser().

// logout if desired
if (isset($_REQUEST['logout'])) {
	phpCAS::logout();
}

// for this test, simply print that the authentication was successfull

$data = array(
    "success" => true,
    "message" => "success to login!",
    "data" => array (
        "userNumber" => phpCAS::getAttributes()["userNumber"],
        "uid" => phpCAS::getAttributes()["uid"],
        "displayName" => phpCAS::getAttributes()["displayName"],
        "firstName" => phpCAS::getAttributes()["firstName"],
        "lastName" => phpCAS::getAttributes()["lastName"],
        "userType" => phpCAS::getAttributes()["userType"],
        "email" => phpCAS::getAttributes()["email"]
    )
);

header('Content-Type: application/json');
echo json_encode($data);

?>
