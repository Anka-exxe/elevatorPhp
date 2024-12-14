import { loadTexture } from './lift.js';

const translate = {
    'walls': 1,
    'ceiling': 2,
    'floor': 3,
    'board': 4,
    'door': 5
};

const images = {}; 

window.showImages = function(element) {
    const content = document.getElementById('content');
    content.innerHTML = ''; 

    let elementId = translate[element];

    fetch(`get_textures.php?elementId=${elementId}`)
    .then(response => {
        if (!response.ok) {
            throw new Error('Ошибка сети: ' + response.status);
        }
        return response.json(); 
    })
    .then(data => {
        if (data.error) {
            console.error(data.error); 
            return;
        }

        if (!Array.isArray(data)) {
            console.error('Полученные данные не являются массивом:', data);
            return;
        }

        images[element] = data; 

        images[element].forEach((image) => {
            const imgContainer = document.createElement('div');
            imgContainer.className = 'image-container';
            const img = document.createElement('img');
            img.src = image;
            img.alt = `${element} image`;
            imgContainer.appendChild(img);
            content.appendChild(imgContainer);

            if (element === 'door') {
                img.addEventListener('click', () => {
                    loadTexture(image, 4, element);
                });
            } else if (element === 'ceiling') {
                img.addEventListener('click', () => {
                    loadTexture(image, 2, element);
                });
            } else if (element === 'walls') {
                img.addEventListener('click', () => {
                    loadTexture(image, 0, element);
                    loadTexture(image, 1, element);
                    loadTexture(image, 5, element);
                });
            } else if (element === 'floor') {
                img.addEventListener('click', () => {
                    loadTexture(image, 3, element);
                });
            } else if (element === 'board') {
                img.addEventListener('click', () => {
                    loadTexture(image, 0, element);
                });
            }
        });
    })
    .catch(error => {
        console.error('Ошибка:', error);
    });
};