<?php

namespace IdPExample;

use OneLogin\Saml2\Constants;

class Response extends Node
{
    public function __construct(string $id)
    {
        $this->setTagOpen('<samlp:Response');
        $this->setTagClose('</samlp:Response>');
        $this->addProp('xmlns:saml', Constants::NS_SAML);
        $this->addProp('xmlns:samlp', Constants::NS_SAMLP);
        $this->addProp('Version', "2.0");
        $this->addProp('ID', $id);
    }

    public function setIssueInstant(\DateTime $date)
    {
        $this->addProp('IssueInstant', $date->format('Y-m-d\TH:i:s\Z'));
    }

    public function setInResponseTo(string $inResponseTo)
    {
        $this->addProp('InResponseTo', $inResponseTo);
    }

    public function setIssuer(Issuer $issuer)
    {
        $this->addChild($issuer);
    }

    public function setStatus(Status $status)
    {
        $this->addChild($status);
    }

    public function setAssertion(Assertion $assertion)
    {
        $this->addChild($assertion);
    }
}