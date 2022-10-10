<?php

namespace IdPExample;

use OneLogin\Saml2\Utils;

class Signature
{
    private $xmlAuthnSigned;

    public function addSign(string $xmlAuthn)
    {
        $key = file_get_contents(getenv('PRIVATE_KEY_PATH') ?: '/var/www/certs/private_key.pem');
        $cert = file_get_contents(getenv('CERTIFICATE_PATH') ?: '/var/www/certs/certificate.crt');
        $this->xmlAuthnSigned = Utils::addSign($xmlAuthn, $key, $cert);
    }

    public function getSAMLResponseSigned()
    {
        return $this->xmlAuthnSigned;
    }
}
