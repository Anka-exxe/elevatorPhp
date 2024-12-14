<?php
require_once("program.php");

$requestList = $requestService->getAllRequests();

if (!empty($_GET["processRequestId"])) {
    header("Location: http://localhost:3000/processRequest.php?processRequestId=" . $_GET["processRequestId"]);
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Просмотр заявок</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f9f9f9;
        }
        .request-container {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        .request {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .request-info {
            flex-grow: 1;
        }
        .request-buttons {
            display: flex;
            justify-content: flex-end; 
            margin-top: 10px; 
            flex-direction: column;
        }
        .request-button {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            background-color: #007bff;
            color: white;
            margin-bottom: 5px; 
        }
        .request-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h2>Список заявок на расчёт</h2>
    
    <?php 
    foreach ($requestList as $request) {
    echo "<form method='get'>";
    echo "<div class='request-container' id='$request->requestId'>";
    echo "<input type='hidden' name='processRequestId' value='$request->requestId'>"; 

    echo "<div class='request' style='display: flex; justify-content: space-between; align-items: center;'>"; 
    echo "<div class='request-info'>";
    echo "<strong>Пользователь:</strong> " . 
    ($userService->findUserById($request->userId))->getName() . 
    "<br>";
    echo "<strong>Email:</strong> $request->email<br>";
    if ($request->price == 0) {
        echo "<strong>Цена:</strong> <span id='price1'>Не установлена</span>";  
    } else {
        echo "<strong>Цена:</strong> <span id='price1'>$request->price $</span>";
    }
    echo "</div>";
    echo "<div class='request-buttons'>";

    echo "<input type='submit' class='request-button' value='Установить цену'>";
    echo "</form>";

    if ($request->price != 0) {
        echo "<button type='button' class='request-button' onClick='sendResult()'>Отправить на email</button>";
    } 

    echo "</div>";
    echo "</div>"; 
    echo "</div>"; 
}
?>

    <script>
        function sendResult() {
            alert("Результат отправлен");
        }
    </script>
</body>
</html>