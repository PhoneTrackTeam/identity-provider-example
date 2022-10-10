<?php

use IdPExample\Helper\Utils;

require_once '../bootstrap.php';

$protocol = isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$sso = sprintf("%s://%s/sso.php", $protocol, $host);
$binding = 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST';
$sls = sprintf("%s://%s/logout.php", $protocol, $host);
$entity = sprintf("%s://%s", $protocol, $host);

$dataView = [
    'name' => 'idpexample',
    'entity' => $entity,
    'cert' => file_get_contents(getenv('CERTIFICATE_PATH') ?: '/var/www/certs/certificate.crt'),
    'sso' => $sso,
    'sls' => $sls,
    'binding' => $binding
];

echo Utils::view('info', $dataView);
