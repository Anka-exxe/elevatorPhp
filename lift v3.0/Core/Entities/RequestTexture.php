<?php
namespace Core\Entities;

class RequestTexture {
    private $requestId;
    private $elementId;
    private $textureId;

    public function __construct($requestId, $elementId, $textureId) {
        $this->requestId = $requestId;
        $this->elementId = $elementId;
        $this->textureId = $textureId;
    }

    public function getRequestId() {
        return $this->requestId;
    }

    public function getElementId() {
        return $this->elementId;
    }

    public function getTextureId() {
        return $this->textureId;
    }
}