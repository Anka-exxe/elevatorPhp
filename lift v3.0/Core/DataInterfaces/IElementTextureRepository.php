<?php
namespace Core\DataInterfaces;

interface IElementTextureRepository {
    function getAllElementTextures();
    function getElementTexture($elementId, $textureId);
    function addElementTexture($elementId, $textureId);
    function getTexturesByElementId($elementId);
}