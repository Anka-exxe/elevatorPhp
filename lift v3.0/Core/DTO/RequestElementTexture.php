<?php
namespace Core\DTO;

class RequestElementTexture {
    public $elementId;
    public $textureId;

    public function __construct($elementId, $textureId) {
        $this->elementId = $elementId;
        $this->textureId = $textureId;
    }
}