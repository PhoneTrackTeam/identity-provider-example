<?php

namespace IdPExample;

class Node
{
    private $tagOpen = '';

    private $tagClose = '';

    private $content = '';

    private $props = [];

    private $children = [];

    public function setTagOpen(string $tag)
    {
        $this->tagOpen = rtrim($tag, '>');
    }

    public function setTagClose(string $tag)
    {
        $this->tagClose = $tag;
    }

    public function getTagOpen()
    {
        return $this->tagOpen;
    }

    public function getTagClose()
    {
        return $this->tagClose;
    }

    public function setContent(string $value)
    {
        $this->content = $value;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function addProp(string $prop, string $value)
    {
        $this->props[$prop] = $value;
    }

    public function getProp(string $prop)
    {
        return $this->props[$prop];
    }

    public function setProps(array $props)
    {
        foreach ($props as $prop => $value) {
            $this->addProp($prop, $value);
        }
    }

    public function getProps()
    {
        return $this->props;
    }

    public function addChild(Node $child)
    {
        $this->children[] = $child;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function hasChildren()
    {
        return count($this->children) > 0;
    }

    public function __toString()
    {
        $attributeFirstPart = [];
        $attributeFirstPart[] = $this->getTagOpen();
        foreach ($this->getProps() as $prop => $value) {
            $attributeFirstPart[] = sprintf('%s="%s"', $prop, $value);
        }

        $attribute = implode(' ', $attributeFirstPart);

        $hasContentOrChild = (count($this->getChildren()) || empty($this->getContent()) === false);
        if ($hasContentOrChild) {
            $attribute .= '>';
            if (empty($this->getContent()) === false) {
                $attribute .= $this->getContent();
            } else {
                foreach ($this->getChildren() as $child) {
                    $attribute .= $child;
                }
            }
        }

        $attribute .= $hasContentOrChild ? $this->getTagClose() : '/>';
        return $attribute;
    }
}