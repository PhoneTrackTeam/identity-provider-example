<?php

namespace IdPExample;

class Issuer extends Node
{
    public function __construct()
    {
        $this->setTagOpen('<saml:Issuer');
        $this->setTagClose('</saml:Issuer>');
    }
}