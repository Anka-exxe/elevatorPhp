<?php
namespace Core\Entities;

class ElementTexture {
    private $elementId;
    private $textureId;

    public function __construct($elementId, $textureId) {
        $this->elementId = $elementId;
        $this->textureId = $textureId;
    }

    public function getElementId() {
        return $this->elementId;
    }

    public function getTextureId() {
        return $this->textureId;
    }
}