<?php

namespace IdPExample;

use OneLogin\Saml2\Constants;

class Subject extends Node
{
    private $subjectConfirmation;

    public function __construct()
    {
        $this->setTagOpen('<saml:Subject');
        $this->setTagClose('</saml:Subject>');

        $this->subjectConfirmation = new Node;
        $this->subjectConfirmation->setTagOpen('<saml:SubjectConfirmation');
        $this->subjectConfirmation->setTagClose('</saml:SubjectConfirmation>');
        $this->subjectConfirmation->addProp('Method', Constants::CM_BEARER);
    }

    public function setNameId(string $value, string $format = Constants::NAMEID_EMAIL_ADDRESS)
    {
        $nameId = new Node;
        $nameId->setTagOpen('<saml:NameID');
        $nameId->setTagClose('</saml:NameID>');
        $nameId->addProp('Format', $format);
        $nameId->setContent($value);

        $this->addChild($nameId);
    }

    public function setSubjectConfirmationData(array $props = [], Node $child = null)
    {
        $subjectConfirmationData = new Node;
        $subjectConfirmationData->setTagOpen('<saml:SubjectConfirmationData');
        $subjectConfirmationData->setTagClose('</saml:SubjectConfirmationData>');

        foreach ($props as $prop => $value) {
            if ($prop == 'NotOnOrAfter' && $value instanceof \DateTime) {
                $value->add(new \DateInterval('PT' . Constants::ALLOWED_CLOCK_DRIFT . 'S'));
                $value = $value->format('Y-m-d\TH:i:s\Z');
            }
            $subjectConfirmationData->addProp($prop, $value);
        }
        if (is_null($child) === false) {
            $subjectConfirmationData->addChild($child);
        }

        $this->subjectConfirmation->addChild($subjectConfirmationData);
    }

    public function __toString()
    {
        if ($this->subjectConfirmation->hasChildren()) {
            $this->addChild($this->subjectConfirmation);
        }
        return parent::__toString();
    }
}
