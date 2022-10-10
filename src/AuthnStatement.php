<?php

namespace IdPExample;

use OneLogin\Saml2\Constants;

class AuthnStatement extends Node
{
    private $authnContext;

    public function __construct()
    {
        $this->setTagOpen('<saml:AuthnStatement');
        $this->setTagClose('</saml:AuthnStatement>');

        $this->authnContext = new Node;
        $this->authnContext->setTagOpen('<saml:AuthnContext');
        $this->authnContext->setTagClose('</saml:AuthnContext>');
    }

    public function setAuthnInstant(\DateTime $date)
    {
        $this->addProp('AuthnInstant', $date->format('Y-m-d\TH:i:s\Z'));
    }

    public function setSessionNotOnOrAfter(\DateTime $date)
    {
        $date->add(new \DateInterval('P1D'));
        $this->addProp('SessionNotOnOrAfter', $date->format('Y-m-d\TH:i:s\Z'));
    }

    public function setSessionIndex(string $sessionIndex)
    {
        $this->addProp('SessionIndex', $sessionIndex);
    }

    public function setAuthnContextClassRef(string $value)
    {
        $authnContextClassRef = new Node;
        $authnContextClassRef->setTagOpen('<saml:AuthnContextClassRef');
        $authnContextClassRef->setTagClose('</saml:AuthnContextClassRef>');
        $authnContextClassRef->setContent($value);

        $this->authnContext->addChild($authnContextClassRef);
    }

    public function __toString()
    {
        if ($this->authnContext->hasChildren()) {
            $this->addChild($this->authnContext);
        }
    
        return parent::__toString();
    }
}
