<?php
namespace Application\Services;

require_once("Application/Interfaces/ITextureService.php");
require_once("Core/DataInterfaces/ITextureRepository.php");
require_once("Core/DataInterfaces/IElementTextureRepository.php");
require_once("Core/Entities/Texture.php");
require_once("Core/Entities/ElementTexture.php");
require_once("Helpers/ElementIdFolderTranslater.php");

use Application\Interfaces\ITextureService;
use Core\DataInterfaces\IElementTextureRepository;
use Core\DataInterfaces\ITextureRepository;
use Core\Entities\Texture;
use Core\Entities\ElementTexture;
use Exception;
use Helpers\ElementIdFolderTranslater;

class TextureService implements ITextureService {
    private $textureRepository;
    private $elementTextureRepository;

    public function __construct(ITextureRepository $textureRepository,
                                IElementTextureRepository $elementTextureRepository) 
    {
        $this->textureRepository = $textureRepository;
        $this->elementTextureRepository = $elementTextureRepository;
    }

    public function GetTexturesByElementId($elementId) {
        $textures = $this->elementTextureRepository->getTexturesByElementId($elementId);
        
        if (isset($textures)) {
            return $textures;
        }

        return new Exception("Для такого элемента нет текстуры");
    }

    public function AddTexture($elementId) {
        $destinationPath = $_SERVER["DOCUMENT_ROOT"] . "\\" . ElementIdFolderTranslater::TranslateElementToFolder($elementId) . "\\";

        if (!empty($_FILES['newTextureFile']['error'])) {
            return false;
        } else {
            try {
                move_uploaded_file($_FILES["newTextureFile"]["tmp_name"], $destinationPath . $_FILES["newTextureFile"]["name"]);
            } catch (Exception $e) {
                return false;
            }
        }

        $savingPath = "./" . ElementIdFolderTranslater::TranslateElementToFolder(
            $elementId,
             "/")
            . "/" 
            . $_FILES["newTextureFile"]["name"];

        try {
            $newTexture = $this->textureRepository->addTexture($savingPath);
        } catch (Exception $e) {
            return false;
        }

        try {
            $this->elementTextureRepository->addElementTexture($elementId, $newTexture->getId());
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    public function getTexturePathById(int $textureId) {
        return $this->textureRepository->getPathById($textureId);
    }

    public function getIdByPath($path) {
        return $this->textureRepository->getIdByPath($path);
    }

    private function moveImage($sourcePath, $destinationPath) {
        try {
            if (!file_exists($sourcePath)) {
                throw new Exception("Файл не найден: $sourcePath");
            }
        
            if (!is_writable($destinationPath)) {
                throw new Exception("Нет доступа для записи в директорию: $destinationPath");
            }
        
            if (copy($sourcePath, $destinationPath))
            echo "Файл скопирован";
          else
            echo "Файл не был скопирован";
        } catch (Exception $e) {
            return "Ошибка: " . $e->getMessage();
        }
    }
}
