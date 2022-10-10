<?php

use IdPExample\Helper\Utils;

require_once '../bootstrap.php';

$_SESSION = array();
session_destroy();

Utils::redirect('/');
