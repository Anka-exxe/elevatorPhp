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

      <div>
        <button class="action-button" id="newDesignesButton">Добавить элемент дизайна</button>
      </div>
   

      <div>
        <button class="action-button" id="requestsButton">Просмотр заявок</button>
      </div>
    </div>

    <script >

document.getElementById('newDesignesButton').addEventListener('click', function() {
  window.location.href = 'addNewDesignes.php'; 
});

      document.getElementById('requestsButton').addEventListener('click', function() {
  window.location.href = 'request.php'; 
});
    </script>
    <script type="module" src="lift.js"></script> 
    <script type="module" src="showImg.js"></script> 
  </body>
</html>