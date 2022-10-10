<?php

namespace IdPExample;

class Status extends Node
{
    public function __construct()
    {
        $this->setTagOpen('<samlp:Status');
        $this->setTagClose('</samlp:Status>');
    }

    public function setStatusCode(string $value)
    {
        $statusCode = new Node;
        $statusCode->setTagOpen('<samlp:StatusCode');
        $statusCode->addProp('Value', $value);

        $this->addChild($statusCode);
    }
}
        