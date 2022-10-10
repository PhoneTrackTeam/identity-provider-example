#!/bin/bash

set -x

openssl req -newkey rsa:3072 -new -x509 -days 3652 -nodes -out ${CERTIFICATE_PATH} -keyout ${PRIVATE_KEY_PATH} -subj "/C=US/ST=Denial/L=Springfield/O=Dis/CN=www.example.com"

composer -n install --prefer-dist

service apache2 restart | tail -f /dev/null