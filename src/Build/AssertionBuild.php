<?php

namespace IdPExample\Build;

use IdPExample\Assertion;
use IdPExample\AttributeStatement;
use IdPExample\AuthnStatement;
use IdPExample\Conditions;
use IdPExample\Issuer;
use IdPExample\Subject;
use Ramsey\Uuid\Uuid;

class AssertionBuild
{
    private Assertion $assertion;

    public function __construct(\DateTime $date)
    {
        $this->assertion = new Assertion();
        $uuid = Uuid::uuid1();
        $this->assertion->setID(sprintf("_%s", $uuid->toString()));
        $this->assertion->setIssueInstant(clone $date);
    }

    public function issuer($value)
    {
        $issuer = new Issuer();
        $issuer->setContent($value);
        $this->assertion->addChild($issuer);
        
        return $this;
    }

    public function subject(string $name, array $props)
    {
        $subject = new Subject();
        $subject->setNameId($name);
        $subject->setSubjectConfirmationData($props);
        $this->assertion->addChild($subject);

        return $this;
    }

    public function conditions(\DateTime $date)
    {
        $conditions = new Conditions();
        $conditions->setNotBefore(clone $date);
        $conditions->setNotOnOrAfter(clone $date);
        $conditions->setAudience('');
        $this->assertion->addChild($conditions);

        return $this;
    }

    public function authnStatement(string $sessionId, \DateTime $date)
    {
        $authnStatement = new AuthnStatement();
        $authnStatement->setAuthnInstant($date);
        $authnStatement->setSessionNotOnOrAfter(clone $date);
        $authnStatement->setSessionIndex($sessionId);
        $authnStatement->setAuthnContextClassRef('urn:oasis:names:tc:SAML:2.0:ac:classes:PasswordProtectedTransport');
        $this->assertion->addChild($authnStatement);

        return $this;
    }

    public function attributeStatement(array $attributes)
    {
        $attributeStatement = new AttributeStatement();
        $attributeStatement->addAttribute('role', 'ROLE_ADMIN_CLIENTES');
        foreach($attributes as $attribute => $value) {
            $attributeStatement->addAttribute($attribute, $value);
        }
        $this->assertion->addChild($attributeStatement);

        return $this;
    }

    public function getAssertion() : Assertion
    {
        return $this->assertion;
    }
}