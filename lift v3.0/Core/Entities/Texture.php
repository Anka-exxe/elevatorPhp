<?php
namespace Core\Entities;

class Texture {
    private $id;
    private $texturePath;

    public function __construct($id, $texturePath) {
        $this->id = $id;
        $this->texturePath = $texturePath;
    }

    public function getId() {
        return $this->id;
    }

    public function getTexturePath() {
        return $this->texturePath;
    }
}
