<?php
require_once("program.php");
require_once("Core/DTO/RequestElementTexture.php");

use Core\DTO\RequestElementTexture;

$selectedTextures = [];

if (!empty($_POST['walls'])) {
    $selectedTextures = [
        'walls' => $_POST['walls'] ?? null,
        'ceiling' => $_POST['ceiling'] ?? null,
        'floor' => $_POST['floor'] ?? null,
        'board' => $_POST['board'] ?? null,
        'door' => $_POST['door'] ?? null,
    ];
}


if (!empty($_GET["sendBidButton"])) {
    if (empty($_GET["emailField"]) || !filter_var($_GET["emailField"], FILTER_VALIDATE_EMAIL)) {
        echo "error";
    }
    else {
        $elementTexture = [
            new RequestElementTexture(
                1, 
                $textureService->
                getIdByPath($_GET["wallsPath"])
            ),
            new RequestElementTexture(
                2, 
                $textureService->
                getIdByPath($_GET["ceilingPath"])
            ),
            new RequestElementTexture(
                3, 
                $textureService->
                getIdByPath($_GET["floorPath"])
            ),
            new RequestElementTexture(
                4, 
                $textureService->
                getIdByPath($_GET["boardPath"])
            ),
            new RequestElementTexture(
                5, 
                $textureService->
                getIdByPath($_GET["doorPath"])
            ),
        ];

        $requestService->createRequest(
            $_SESSION["userId"],
            $_GET["emailField"], 
            0, 
            $elementTexture
        );

       header("Location: http://localhost:3000/liftUser.html");
       exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заявка на расчёт</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh; 
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
            text-align: center;
        }
        h2 {
            color: #555;
            margin-top: 20px;
            font-size: 20px;
        }
        .texture-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }
        .texture-item:hover {
            transform: scale(1.02);
        }
        img {
            max-width: 50px;
            max-height: 70px;
            margin-right: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .email-container {
            margin-top: 30px;
            text-align: center;
            width: 100%;
            max-width: 400px;
        }
        input[type="email"] {
            padding: 10px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.2s;
        }
        input[type="email"]:focus {
            border-color: #28a745;
            outline: none;
        }
        button {
            margin-top: 10px;
            padding: 10px 15px;
            border: none;
            background-color: #28a745;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.2s;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h1>Выбранные текстуры</h1>
    <div id="textures-display">

    <div class="texture-item">
    <span>Walls:</span>
    <img src="<?php echo $selectedTextures["walls"]?>" alt="walls texture">
</div>
<div class="texture-item">
    <span>Ceiling:</span>
    <img src="<?php echo $selectedTextures["ceiling"]?>" alt="ceiling texture">
</div>
<div class="texture-item">
    <span>Floor:</span>
    <img src="<?php echo $selectedTextures["floor"]?>" alt="floor texture">
</div>
<div class="texture-item">
    <span>Board:</span>
    <img src="<?php echo $selectedTextures["board"]?>" alt="board texture">
</div>
<div class="texture-item">
    <span>Door:</span>
    <img src="<?php echo $selectedTextures["door"]?>" alt="door texture">
</div>
    </div> 

    <div class="email-container">
        <form method="get">
        <input name = "wallsPath" type = "text" value = <?php echo  $selectedTextures["walls"]?> hidden>
        <input name = "ceilingPath" type = "text" value = <?php echo  $selectedTextures["ceiling"]?> hidden>
        <input name = "floorPath" type = "text" value = <?php echo  $selectedTextures["floor"]?> hidden>
        <input name = "boardPath" type = "text" value = <?php echo  $selectedTextures["board"]?> hidden>
        <input name = "doorPath" type = "text" value = <?php echo  $selectedTextures["door"]?> hidden>

        <h2>Введите ваш email</h2>
        <input name="emailField" type="email" id="email-input" placeholder="Ваш email" required>
        <input  type='submit' name="sendBidButton" id="submit-button" value='Отправить заявку'>
        </form>
    </div>

</body>
</html>