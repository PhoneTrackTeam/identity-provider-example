<?php

namespace IdPExample;

use OneLogin\Saml2\Constants;

class Assertion extends Node
{
    public function __construct()
    {
        $this->setTagOpen('<saml:Assertion');
        $this->setTagClose('</saml:Assertion>');

        $this->addProp('xmlns:saml', Constants::NS_SAML);
        $this->addProp('xmlns:xs', Constants::NS_XS);
        $this->addProp('xmlns:xsi', Constants::NS_XSI);
        $this->addProp('Version', "2.0");
    }

    public function setID(string $id)
    {
        $this->addProp('ID', $id);
    }

    public function setIssueInstant(\DateTime $date)
    {
        $this->addProp('IssueInstant', $date->format('Y-m-d\TH:i:s\Z'));
    }
}