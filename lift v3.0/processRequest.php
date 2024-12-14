<?php
require_once("program.php");

$request = $requestService->getRequestById($_GET["processRequestId"]);
$elements = $request->elementTexture;

if(!empty($_POST["setPriceButton"])) {
    if (!empty($_POST["newPrice"]) && is_numeric($_POST["newPrice"])) {
        $requestService->setNewPrice($request->requestId,$_POST["newPrice"]);
        $_POST["newPrice"] = null;
        header("Location: http://localhost:3000/request.php");
        exit();
    }
    else {
        echo "Ошибка заполнения цены";
        $_POST["newPrice"] = null;
    }
}   

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Установка цены заявки</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f9f9f9;
        }
        h2 {
            text-align: center;
        }
        .form-container {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            margin: 0 auto;
            max-width: 600px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .input-field {
            margin-bottom: 15px;
        }
        .input-field label {
            display: block;
            margin-bottom: 5px;
        }
        .input-field input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .submit-button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
        }
        .submit-button:hover {
            background-color: #0056b3;
        }
        .images-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin-top: 20px;
        }
        .image-container {
        width: calc(33% - 10px);
        box-sizing: border-box;
      }
        .image-item {
            margin: 10px;
            text-align: center;
        }
        .image-item img {
            max-width: 150px;
            max-height: 150px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <h2>Установка цены заявки</h2>
    <div class="form-container">
        <div class="input-field">
            <label for="requestId">ID Заявки:</label>
            <input type="text" value="<?php echo $request->requestId;?>" id="requestId" disabled>
        </div>
        
        <div class="images-container">
        <div class="image-item">
            <img style="min-width: 100px;" src='<?php 
                echo $textureService->
                getTexturePathById(
                    $elements[4]->textureId
                );
                ?>' alt="Двери">
                <p>Двери</p>
            </div>
            <div class="image-item">
                <img src='<?php 
                echo $textureService->
                getTexturePathById(
                    $elements[0]->textureId
                );
                ?>' 
                alt="Стены">
                <p>Стены</p>
            </div>
           
            <div class="image-item">
                <img src='<?php 
                echo $textureService->
                getTexturePathById(
                    $elements[1]->textureId
                );
                ?>'
                alt="Потолок">
                <p>Потолок</p>
            </div>
            <div class="image-item">
            <img src='<?php 
                echo $textureService->
                getTexturePathById(
                    $elements[2]->textureId
                );
                ?>' alt="Пол">
                <p>Пол</p>
            </div>
            <div class="image-item">
            <img src='<?php 
                echo $textureService->
                getTexturePathById(
                    $elements[3]->textureId
                );
                ?>' alt="Табло">
                <p>Табло</p>
            </div>
        </div>

        <div class="input-field">
            <label>Размер лифта:</label>
            <input type="text" value="40x40" disabled>
        </div>
        
        <div class="input-field">
            <label for="currentPrice">Текущая цена:</label>
            <input type="text" value=<?=$request->price?> id="currentPrice" disabled>
        </div>
        <form method="post">
            <div class="input-field">
                <label for="newPrice">Введите новую цену:</label>
                <input name="newPrice" type="text" id="newPrice" placeholder="Например, 2000 руб.">
            </div>
            <input class="submit-button" name="setPriceButton" id="setPriceButton" value="Установить цену" type="submit">
        </form>
    </div>

</body>
</html>