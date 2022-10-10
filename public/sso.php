<?php

use IdPExample\Helper\Utils;
use IdPExample\Exception\IdPException;

require_once '../bootstrap.php';

try {

    $data = $_GET;

    if (!isset($data['SAMLRequest'])) {
        throw new IdPException('SAMLRequest not found.');
    }

    $decoded = base64_decode($data['SAMLRequest']);
    $xmlSamlRequest = gzinflate($decoded);

    $document = new DOMDocument();
    $document->loadXML($xmlSamlRequest);

    /** @var DOMElement */
    $xml = $document->firstChild;

    if (!$xml instanceof \DOMElement) {
        throw new IdPException('Malformed SAML message received.');
    }

    if (!$xml->hasAttribute('ID')) {
        throw new IdPException('Request ID not found.');
    }

    if (!$xml->hasAttribute('AssertionConsumerServiceURL')) {
        throw new IdPException('AssertionConsumerServiceURL not found.');
    }

    $_SESSION['AssertionConsumerServiceURL'] = $xml->getAttribute('AssertionConsumerServiceURL');
    $_SESSION['SAMLRequestID'] = $xml->getAttribute('ID');
    $_SESSION['IssueInstant'] = $xml->getAttribute('IssueInstant');
    $_SESSION['RelayState'] = isset($data['RelayState']) ? $data['RelayState'] : '/';

} catch (\Exception $e) {
    error_log($e->getMessage(), $e->getCode());
    Utils::redirect('/');
}

Utils::redirect('/login.php');
