<?php
namespace Application\Interfaces;

interface ITextureService {
    function GetTexturesByElementId($elementId);
    function AddTexture($elementId);
    function getTexturePathById(int $textureId);
    function getIdByPath($path);
}