<?php
namespace Core\DTO;

class RequestInfoResponce {
    public $requestId;
    public $userId;
    public $email;
    public $price;
    public array $elementTexture;

    public function __construct(int $requestId, int $userId, array $elementTexture, string $email, float $price) {
        foreach ($elementTexture as $element) {
            if (!($element instanceof RequestElementTexture)) {
                throw new \Exception("Неверные элемнеты");
            }
        }

        $this->elementTexture = $elementTexture;
        $this->requestId = $requestId;
        $this->userId = $userId;
        $this->email = $email;
        $this->price = $price;
    }
}