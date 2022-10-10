<?php

namespace IdPExample;

use OneLogin\Saml2\Constants;

class Conditions extends Node
{
    private $audienceRestriction;

    public function __construct()
    {
        $this->setTagOpen('<saml:Conditions');
        $this->setTagClose('</saml:Conditions>');

        $this->audienceRestriction = new Node;
        $this->audienceRestriction->setTagOpen('<saml:AudienceRestriction');
        $this->audienceRestriction->setTagClose('</saml:AudienceRestriction>');
    }

    public function setNotBefore(\DateTime $date)
    {
        $date->sub(new \DateInterval('PT' . Constants::ALLOWED_CLOCK_DRIFT . 'S'));
        $this->addProp('NotBefore', $date->format('Y-m-d\TH:i:s\Z'));
    }

    public function setNotOnOrAfter(\DateTime $date)
    {
        $date->add(new \DateInterval('PT' . Constants::ALLOWED_CLOCK_DRIFT . 'S'));
        $this->addProp('NotOnOrAfter', $date->format('Y-m-d\TH:i:s\Z'));
    }

    /**
     * @param string|Node $value
     * @return void
     */
    public function setAudience($value)
    {
        $audience = new Node;
        $audience->setTagOpen('<saml:Audience');
        $audience->setTagClose('</saml:Audience>');
        if ($value instanceof Node) {
            $audience->addChild($value);
        } else {
            $audience->setContent($value);
        }
        $this->audienceRestriction->addChild($audience);
    }

    public function __toString()
    {
        if ($this->audienceRestriction->hasChildren()) {
            $this->addChild($this->audienceRestriction);
        }

        return parent::__toString();
    }
}
