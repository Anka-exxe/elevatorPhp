<?php
require_once("program.php");

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>3D Конфигуратор Лифта</title>
    <style>
      body { margin: 0; display: flex; flex-direction: column; align-items: center; }
      canvas { display: block; }
      .controls { position: absolute; top: 10px; left: 10px; background: rgba(255, 255, 255, 0.8); padding: 20px; border-radius: 5px; }
      #menu {
        background-color: #f0f0f0;
        padding: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        display: flex;
        width: 100%;
        overflow-x: auto; 
      }
      #menu a {
        padding: 5px 10px;
        text-decoration: none;
        color: #333;
        font-size: 14px; 
        margin-right: 10px;
        white-space: nowrap; 
      }
      #menu a:hover {
        background-color: #e0e0e0;
      }
      #content {
        padding: 20px;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        max-width: 380px; 
        margin-left: 0;
        box-sizing: border-box; 
        overflow-y: auto;
      }
      #newDesignImage {
        padding: 20px;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        max-width: 380px; 
        margin-left: 0; 
        box-sizing: border-box; 
        overflow-y: auto;
      }
      .image-container {
        width: calc(33% - 10px);
        box-sizing: border-box;
      }
      img {
        width: 100%;
        height: 100%; 
        border-radius: 5px;
        display: block; 
        object-fit: cover;
      }
      @media (max-width: 600px) {
        .image-container {
          width: calc(50% - 10px);
        }
      }
      @media (max-width: 400px) {
        .image-container {
          width: 100%;
        }
      }
      .action-button, .upload-button, .size-select, .element-select {
        margin: 5px;
        padding: 8px 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        cursor: pointer;
      }
      .action-button:hover, .upload-button:hover {
        background-color: #0056b3;
        color: #fff;
      }
      .size-select:hover, .element-select:hover {
        border-color: #0056b3;
      }
    </style>
    <script type="importmap">
      {
        "imports": {
          "three": "https://cdn.jsdelivr.net/npm/three@0.131/build/three.module.js",
          "jsm/": "https://cdn.jsdelivr.net/npm/three@0.131/examples/jsm/"
        }
      }
    </script>
  </head>
  <body>
    <div class="controls">
      <div id="menu">
        <a href="#" onclick="showImages('walls')">Стены</a>
        <a href="#" onclick="showImages('ceiling')">Потолок</a>
        <a href="#" onclick="showImages('floor')">Пол</a>
        <a href="#" onclick="showImages('board')">Табло</a>
        <a href="#" onclick="showImages('door')">Двери</a>
      </div>
      <h3>Размеры:</h3>
      <select class="size-select" id="size-select">
        <option value="40x40">40x40</option>
        <option value="40x60">40x60</option>
        <option value="50x70">50x70</option>
      </select>
      <div id="content">
        <!-- Изображения будут отображаться здесь -->
      </div>


      <form enctype="multipart/form-data" method="POST" action="">
      <div>
        <select name = "elementForNewDesign" class="element-select" id="element-select">
          <option value='walls'>Стены</option>
          <option value='floor'>Пол</option>
          <option value='ceiling'>Потолок</option>
          <option value='door'>Двери</option>
          <option value='board'>Табло</option>
        </select>
      </div>

        <input type="file" class="upload-button" name="newTextureFile" id="image-upload" accept="image/*" required><br>
        <div id="newDesignImage"></div>
        <input type="submit" name="isUploaded" class="action-button" value="Добавить элемент дизайна">
      </form>

    </div>

    <script type="module">
      import { loadTexture } from './lift.js';

      let currentElement = 'walls'; 

      document.getElementById('element-select').addEventListener('change', function(event) {
        currentElement = event.target.value;
      });

      document.getElementById('image-upload').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.classList.add('image-container');

            const contentDiv = document.getElementById('newDesignImage');
            contentDiv.innerHTML = ''; 
            contentDiv.appendChild(img);

            switch(currentElement){
              case 'walls':
                loadTexture(img.src, 0, currentElement);
                loadTexture(img.src, 1, currentElement);
                loadTexture(img.src, 5, currentElement);
                break;
              case 'ceiling':
                loadTexture(img.src, 2, currentElement);
                break;
              case 'floor':
              loadTexture(img.src, 3, currentElement);
                break;
              case 'door':
                loadTexture(img.src, 4, currentElement);
                break;
              case 'board':
                loadTexture(img.src, 0, currentElement);
                break;
              default:
                break;
            }
          };
          reader.readAsDataURL(file);
        }
      });

      document.getElementById('adddesign-button').addEventListener('click', function() {
        const contentDiv = document.getElementById('newDesignImage');
        contentDiv.innerHTML = ''; 
        document.getElementById('image-upload').value = ''; 
      });

    </script>
    <script type="module" src="lift.js"></script> 
    <script type="module" src="showImg.js"></script> 
  </body>
</html>

<?php
$translator =[
  'walls' => 1,
  'ceiling' => 2,
  'floor' => 3,
  'board' => 4,
  'door' => 5
];

if (!empty($_POST["isUploaded"]) && !empty($_FILES["newTextureFile"])) {
  $elementName = $_POST["elementForNewDesign"];
  $elementId = $translator[$elementName];

    if (!($textureService->AddTexture($elementId))) {
      echo "Ошибка";
    }
    
    $_POST = [];
    $_FILES = [];
}

$_POST = [];
$_FILES = [];
?>