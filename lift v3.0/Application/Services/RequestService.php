<?php
namespace Application\Services;

require_once("Data/Repositories/RequestRepository.php");
require_once("Data/Repositories/RequestTextureRepository.php");
require_once("Core/Entities/Request.php");
require_once("Core/DTO/RequestElementTexture.php");
require_once("Core/Entities/RequestTexture.php");
require_once("Core/DTO/RequestInfoResponce.php");

use Core\DTO\RequestElementTexture;
use Data\Repositories\RequestRepository;
use Core\Entities\Request;
use Data\Repositories\RequestTextureRepository;
use Core\Entities\RequestTexture;
use Core\DTO\RequestInfoResponce;

class RequestService {
    private $requestTextureRepository;
    private $requestRepository;

    public function __construct(RequestRepository $requestRepository, RequestTextureRepository $requestTextureRepository) {
        $this->requestRepository = $requestRepository;
        $this->requestTextureRepository = $requestTextureRepository;
    }

    public function createRequest($userId, $email, $price, array $requestElementTexture): bool {
        try {
            foreach ($requestElementTexture as $element) {
                if(!($element instanceof RequestElementTexture)) {
                    echo "Неверный тип";
                    throw new \Exception("Неверный тип");
                }
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }

        $request = null;

        try {
            $request = new Request($userId, $email, $price);
            $request = $this->requestRepository->add($request);
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }

        try {
            $requestTextureArray = [];
            foreach ($requestElementTexture as $element) {
                array_push(
                    $requestTextureArray, 
                    new RequestTexture(
                        $request->getRequestId(), 
                        $element->elementId, 
                        $element->textureId
                    )
                ); 
            }

            foreach ($requestTextureArray as $element) {
                $this->requestTextureRepository->save($element);
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }

        return true;
    }

    public function getRequestById(int $requestId): ?RequestInfoResponce {
        $requestInfo = $this->requestRepository->findById($requestId);
        $requestTextureInfo = $this->requestTextureRepository->findByRequestId($requestId);

        $requestElementTexture = [];
        //var_dump($requestTextureInfo);

        foreach ($requestTextureInfo as $element) {
            array_push(
                $requestElementTexture, 
                new RequestElementTexture(
                    $element["element_id"],
                    $element["texture_id"]
                )
            );
        }

        return new RequestInfoResponce(
            $requestInfo->getRequestId(),
            $requestInfo->getUserId(), 
            $requestElementTexture, $requestInfo->getEmail(), 
            $requestInfo->getPrice()
        );
    }

    public function getAllRequests():array {
        $requests = $this->requestRepository->getAllRequests();
        $requestsInfo = [];

        for ($i = 0; $i < count($requests); $i++) {
            $requestsInfo[] = $this->getRequestById($requests[$i]["request_id"]);
        }
        
        return $requestsInfo;
    }

    public function setNewPrice(int $requestId, float $newPrice):bool {
        return $this->requestRepository->setNewPrice($requestId, $newPrice);
    }
}