<?php
namespace Helpers;

class ElementIdFolderTranslater {
        static private $elementToFolderKeys = [
            1 => ["Lift", "Стены"],
            2 => ["Lift", "Потолок"],
            3 => ["Lift", "Пол"],
            4 => ["Lift", "Табло"],
            5 => ["Lift", "Двери"],
        ];

    static public function TranslateElementToFolder (int $elementId, string $slash = "\\") {
        return implode($slash, self::$elementToFolderKeys[$elementId]);
    }

    static public function TranslateFolderToElement (string $path) {
        return array_search($path, self::$elementToFolderKeys);
    }
}