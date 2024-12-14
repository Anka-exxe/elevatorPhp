import * as THREE from "three";
import { OrbitControls } from "jsm/controls/OrbitControls.js";

const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
camera.position.set(0, 0, 6);

const renderer = new THREE.WebGLRenderer({ antialias: true });
renderer.setSize(window.innerWidth, window.innerHeight);
renderer.setClearColor(0xD3D3D3); 
document.body.appendChild(renderer.domElement);

const scene = new THREE.Scene();
scene.background = new THREE.Color(0xD3D3D3); 

let width = 2, height = 3, depth = 2;
const geometry = new THREE.BoxGeometry(width, height, depth);

const materials = [
    new THREE.MeshStandardMaterial({ color: 0xffffff, side: THREE.BackSide, roughness: 0.1, metalness: 0.8 }), // Левая сторона
    new THREE.MeshStandardMaterial({ color: 0xffffff, side: THREE.BackSide, roughness: 0.1, metalness: 0.8 }), // Правая сторона
    new THREE.MeshStandardMaterial({ color: 0xffffff, side: THREE.BackSide, roughness: 0.1, metalness: 0.8 }), // Верхняя сторона (потолок)
    new THREE.MeshStandardMaterial({ color: 0xffffff, side: THREE.BackSide, roughness: 0.1, metalness: 0.8 }), // Нижняя сторона (пол)
    new THREE.MeshStandardMaterial({ color: 0xffffff, side: THREE.BackSide, roughness: 0.1, metalness: 0.8 }), // Передняя сторона (дверь)
    new THREE.MeshStandardMaterial({ color: 0xffffff, side: THREE.BackSide, roughness: 0.1, metalness: 0.8 })  // Задняя сторона
];

const cube = new THREE.Mesh(geometry, materials);
scene.add(cube);

const light = new THREE.PointLight(0xffffff, 6);
light.position.set(0, height- 0.1, 0).normalize();

scene.add(light);

const infoBoardGeometry = new THREE.PlaneGeometry(0.7, 1.5);
const infoBoardMaterial = new THREE.MeshBasicMaterial({ color: 0xffffff, side: THREE.DoubleSide }); 
const infoBoard = new THREE.Mesh(infoBoardGeometry, infoBoardMaterial);

infoBoard.position.set(0.999, 0.5, 0.25); 
infoBoard.rotation.y = Math.PI / 2; 

cube.add(infoBoard);

function updateCubeSize(newWidth, newHeight, newDepth) {
    cube.geometry.dispose();
    cube.geometry = new THREE.BoxGeometry(newWidth, newHeight, newDepth);

    infoBoard.position.set(newWidth / 2 - 0.0001, newHeight / 5.5, 0.25);
}

const sizeSelect = document.getElementById('size-select');

sizeSelect.addEventListener('change', () => {
  const selectedSize = sizeSelect.value;

  switch (selectedSize) {
    case '40x40':
      updateCubeSize(2, 3, 2);
      break;
    case '40x60':
      updateCubeSize(2, 3, 3);
      break;
    case '50x70':
      updateCubeSize(2.5, 3, 3.5);
      break;
    default:
      break;
  }
});


const selectedTextures = {
  walls: './Lift/Стены/texture20.png',
  ceiling: './Lift/Потолок/texture21.png',
  floor: './Lift/Пол/texture8.png',
  board: './Lift/Табло/texture18.png',
  door: './Lift/Двери/texture19.png',
};


function MakeStartLift(){
    loadTexture('./Lift/Стены/texture20.png', 0, 'walls')
    loadTexture('./Lift/Стены/texture20.png', 1, 'walls')
    loadTexture('./Lift/Стены/texture20.png', 5, 'walls')
    loadTexture('./Lift/Потолок/texture21.png', 2, 'ceiling')
    loadTexture('./Lift/Пол/texture8.png', 3, 'floor')
    loadTexture('./Lift/Двери/texture19.png', 4, 'door')
    loadTexture('./Lift/Табло/texture18.png', 0, 'board')
}

MakeStartLift();


function loadTexture(imageUrl, index, target) {
    const textureLoader = new THREE.TextureLoader();

    textureLoader.load(imageUrl, (texture) => {
        if (target === 'board') {
          selectedTextures[target] = imageUrl; // Сохраняем текстуру
          localStorage.setItem('selectedTextures', JSON.stringify(selectedTextures)); 
            infoBoard.material.map = texture;
            infoBoard.material.needsUpdate = true; 
 
        } else {
          selectedTextures[target] = imageUrl; // Сохраняем текстуру
          localStorage.setItem('selectedTextures', JSON.stringify(selectedTextures)); 
            materials[index].map = texture;
            materials[index].color.set(0xffffff); 
            materials[index].needsUpdate = true; 
        }
    }, undefined, (error) => {
        console.error('Ошибка загрузки текстуры:', error);
    });
}


    export { loadTexture };

    window.onload = function() {
      const savedTextures = localStorage.getItem('selectedTextures');
      if (savedTextures) {
          Object.assign(selectedTextures, JSON.parse(savedTextures));
          console.log(selectedTextures); // Для отладки
      }
  };
  
  // Отправка заявки
  const button = document.getElementById('sendRequest-button');

  if(button) {
    document.getElementById('sendRequest-button').addEventListener('click', () => {
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = 'send_request.php';
  
      const selectedTextures = {
          walls: null,
          ceiling: null,
          floor: null,
          board: null,
          door: null,
      };
  
      // Заполняем выбранные текстуры
      // Предположим, что вы уже сохранили их в localStorage или переменной
      const savedTextures = localStorage.getItem('selectedTextures');
      if (savedTextures) {
          Object.assign(selectedTextures, JSON.parse(savedTextures));
      }
  
      // Добавляем данные в форму
      for (const [key, value] of Object.entries(selectedTextures)) {
          const input = document.createElement('input');
          input.type = 'hidden';
          input.name = key;
          input.value = value;
          form.appendChild(input);
      }
  
      document.body.appendChild(form);
      form.submit(); // Отправляем форму
  });
  }
  
      const controls = new OrbitControls(camera, renderer.domElement);
      controls.enableDamping = true;
      controls.dampingFactor = 0.25;
      controls.screenSpacePanning = false;

 

function animate() {
    requestAnimationFrame(animate);
    controls.update();

    const cameraDirection = new THREE.Vector3();
    camera.getWorldDirection(cameraDirection);

    const wallNormal = new THREE.Vector3(-1, 0, 0); 

    const dotProduct = wallNormal.dot(cameraDirection);

    const visibilityThreshold = 0.1;

    infoBoard.visible = dotProduct < visibilityThreshold;

    renderer.render(scene, camera);
}
      animate();

      window.addEventListener('resize', () => {
          camera.aspect = window.innerWidth / window.innerHeight;
          camera.updateProjectionMatrix();
          renderer.setSize(window.innerWidth, window.innerHeight);
      });