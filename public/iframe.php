<?php

use IdPExample\Helper\Utils;

require_once '../bootstrap.php';
$config = require_once '../config.php';

$dataView = [
    'name' => $config['idp']['name'],
    'host' => $config['phonetrack']['host'],
    'pathsaml' => '/saml/login',
    'redirect_url' => '/account/painel?embedded=true&client_id=' . $config['phonetrack']['units_id']
];

echo Utils::view('iframe', $dataView);
