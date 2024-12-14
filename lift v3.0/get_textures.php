<?php
require("program.php");

header('Content-Type: application/json'); 

if (isset($_GET['elementId'])) {
    $elementId = intval($_GET['elementId']);

    try {
        $textures = $textureService->GetTexturesByElementId($elementId);
        $texturePaths = array_map(function($texture) {
            return $texture->getTexturePath(); 
        }, $textures);
        echo json_encode($texturePaths); 
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'elementId не указан']);
}