<?php

ini_set('session.cookie_samesite', 'None');
ini_set('session.cookie_secure', true);

ini_set('session.save_handler', 'redis');
ini_set('session.save_path', 'tcp://redis:6379');

require_once __DIR__ . '/vendor/autoload.php';

if (empty(session_id())) {
    session_start();
}
