<?php
require_once("Constants/ConnectionStrings.php");
require_once("Data/Repositories/TextureRepository.php");
require_once("Data/Repositories/ElementTextureRepository.php");
require_once("Data/Repositories/UserRepository.php");
require_once("Data/Repositories/RequestRepository.php");
require_once("Data/Repositories/RequestTextureRepository.php");
require_once("Application/Services/TextureService.php");
require_once("Application/Services/UserService.php");
require_once("Application/Services/RequestService.php");

use Data\Repositories\TextureRepository;
use Data\Repositories\ElementTextureRepository;
use Data\Repositories\RequestRepository;
use Data\Repositories\UserRepository;
use Data\Repositories\RequestTextureRepository;

use Constants\ConnectionStrings;
use Application\Services\TextureService;
use Application\Services\UserService;
use Application\Services\RequestService;

$connection = new mysqli(HOST, USER, PASSWORD, DATABASE);

$elementRep = new ElementTextureRepository($connection);
$textureRep = new TextureRepository($connection);
$userRep = new UserRepository($connection);
$requestRep = new RequestRepository($connection);
$requestTextureRep = new RequestTextureRepository($connection);

$textureService = new TextureService($textureRep, $elementRep);
$userService = new UserService($userRep);
$requestService = new RequestService($requestRep, $requestTextureRep);

?>
