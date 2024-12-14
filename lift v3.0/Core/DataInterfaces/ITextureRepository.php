<?php
namespace Core\DataInterfaces;

interface ITextureRepository {
    function getAllTextures();
    function getTextureById($id);
    function addTexture($texturePath);
    function getPathById($textureId);
    function getIdByPath($path);
}