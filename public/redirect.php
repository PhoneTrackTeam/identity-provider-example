<?php

use IdPExample\Build\AssertionBuild;
use IdPExample\Issuer;
use IdPExample\Response;
use IdPExample\Signature;
use IdPExample\Status;
use OneLogin\Saml2\Constants;
use IdPExample\Helper\Utils;

require_once '../bootstrap.php';

if (isset($_SESSION['logged']) === false || $_SESSION['logged'] === false) {
    Utils::redirect('/login.php');
}

if (isset($_SESSION['AssertionConsumerServiceURL']) === false) {
    Utils::redirect('/');
}

$config = require_once '../config.php';
$phonetrack = $config['phonetrack'];

$user = $_SESSION['user'];
$requestId = $_SESSION['SAMLRequestID'];
$issueInstant = new \DateTime($_SESSION['IssueInstant']);

$sessionId = session_id();
$signedId = hash('sha256', uniqid($sessionId));

$issuer = new Issuer();
$issuer->setContent('http://localhost:8081');

$status = new Status();
$status->setStatusCode(Constants::STATUS_SUCCESS);

$assertionBuild = new AssertionBuild($issueInstant);

$assertionBuild
    ->issuer('http://localhost:8081')
    ->subject($user['name'], [
        'NotOnOrAfter' => clone $issueInstant,
        'Recipient' => '',
        'InResponseTo' => $requestId
    ])
    ->conditions($issueInstant)
    ->authnStatement($sessionId, $issueInstant)
    ->attributeStatement([
        'units_id' => $phonetrack['units_id'],
        'email' => $user['email'],
        'account_id' => $phonetrack['account_id'],
    ]);

$assertion = $assertionBuild->getAssertion();

$xmlResponse = new Response($signedId);
$xmlResponse->setIssueInstant($issueInstant);
$xmlResponse->setInResponseTo($requestId);
$xmlResponse->setIssuer($issuer);
$xmlResponse->setStatus($status);
$xmlResponse->setAssertion($assertion);

$signature = new Signature();
$signature->addSign($xmlResponse);

$samlResponse = base64_encode($signature->getSAMLResponseSigned());

$dataView = [
    'urlAcs' => $_SESSION['AssertionConsumerServiceURL'],
    'samlResponse' => $samlResponse,
    'relayState' => $_SESSION['RelayState'],
];

unset($_SESSION['AssertionConsumerServiceURL']);

echo Utils::view('redirect', $dataView);
