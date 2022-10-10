<?php

namespace IdPExample;

use OneLogin\Saml2\Constants;

class AttributeStatement extends Node
{
    public function __construct()
    {
        $this->setTagOpen('<saml:AttributeStatement');
        $this->setTagClose('</saml:AttributeStatement>');
    }

    public function addAttribute(string $name, string $value, string $nameFormat = Constants::ATTRNAME_FORMAT_BASIC)
    {
        $attributeValue = new Node;
        $attributeValue->setTagOpen('<saml:AttributeValue');
        $attributeValue->addProp('xmlns:xsi', Constants::NS_XSI);
        $attributeValue->addProp('xsi:type', 'xs:string');
        $attributeValue->setContent($value);
        $attributeValue->setTagClose('</saml:AttributeValue>');

        $attribute = new Node;
        $attribute->setTagOpen('<saml:Attribute');
        $attribute->addProp('NameFormat', $nameFormat);
        $attribute->addProp('Name', $name);
        $attribute->addChild($attributeValue);
        $attribute->setTagClose('</saml:Attribute>');

        $this->addChild($attribute);
    }
}