<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Новогодний Квест | Тайный Санта</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to bottom, #00274d, #005b99);
            color: #fff;
            text-align: center;
            overflow: hidden;
            position: relative; /* Добавляем позиционирование для тела */
        }

        header {
            background-color: #00467f;
            padding: 20px;
            position: relative; /* Заголовок на переднем плане */
            z-index: 10;
        }

        header img {
            height: 50px;
        }

        .content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 90px);
            position: relative; /* Контент поверх снега */
            z-index: 10;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            max-width: 600px;
        }

        .btn-start {
            font-size: 1.5rem;
            color: #fff;
            background-color: #0073e6;
            border: none;
            padding: 15px 30px;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-start:hover {
            background-color: #005bb5;
        }

        .game-level {
            display: none;
        }

        .level-active {
            display: block;
        }

        .tree-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .tree {
            width: 300px;
            height: 400px;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
        }

        .tree .triangle {
            width: 0;
            height: 0;
            border-left: 150px solid transparent;
            border-right: 150px solid transparent;
            border-bottom: 250px solid #228B22;
            position: relative;
        }

        .decorations {
            display: flex;
            justify-content: space-between;
            width: 250px;
            margin-top: 20px;
        }

        .decoration {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: grab;
            transition: background-color 0.3s;
        }

        .drop-zone {
            position: absolute;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.4);
        }

        .hover {
            background-color: rgba(255, 255, 255, 0.8);
        }

        .congratulations {
            display: none;
            margin-top: 50px;
        }

        .congratulations img {
            width: 300px;
            border-radius: 15px;
        }

        /* Канвас для снега */
        .snow {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1; /* Помещаем снег на задний план */
        }
    </style>
</head>
<body>
    <header>
        <img src="https://habrastorage.org/getpro/moikrug/uploads/company/071/901/644/logo/medium_75e34589307aee734c345f6a384d8f1a.jpg" alt="Sigma IT">
    </header>
    <div class="content">
        <h1>Добро пожаловать в Новогодний "Квест!"</h1>
        <p>Тайный Санта положил подарок под ёлку, укрась её, чтобы подарок появился.</p>
        <button class="btn-start" onclick="startGame()">Начать Квест</button>
    </div>

    <div class="game-level tree-container">
        <h2>Украсьте ёлочку</h2>
        <h4>(треугольная - значит ёлка :D)</h4>
        <div class="tree">
            <div class="triangle"></div>
            <div class="drop-zone" style="top: 50px; left: 125px;"></div>
            <div class="drop-zone" style="top: 150px; left: 75px;"></div>
            <div class="drop-zone" style="top: 150px; left: 175px;"></div>
            <div class="drop-zone" style="top: 250px; left: 50px;"></div>
            <div class="drop-zone" style="top: 250px; left: 200px;"></div>
        </div>
        <div class="decorations">
            <div class="decoration" draggable="true" data-color="#FF0000" style="background-color: #FF0000;"></div>
            <div class="decoration" draggable="true" data-color="#00FF00" style="background-color: #00FF00;"></div>
            <div class="decoration" draggable="true" data-color="#0000FF" style="background-color: #0000FF;"></div>
            <div class="decoration" draggable="true" data-color="#FFD700" style="background-color: #FFD700;"></div>
            <div class="decoration" draggable="true" data-color="#FF1493" style="background-color: #FF1493;"></div>
        </div>
    </div>

    <div class="congratulations">
        <h2>Поздравляем! Ёлка украшена!</h2>
        <img src="https://via.placeholder.com/300" alt="Подарок">
    </div>

    <canvas class="snow"></canvas>

    <script>
        // Переход на следующий этап
        function startGame() {
            document.querySelector('.content').style.display = 'none';
            document.querySelector('.game-level').classList.add('level-active');
        }

        // Эффект снега
        const canvas = document.querySelector('.snow');
        const ctx = canvas.getContext('2d');
        let particles = [];

        // Инициализация снега
        function initSnow() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            particles = Array.from({ length: 150 }).map(() => ({
                x: Math.random() * canvas.width,
                y: Math.random() * canvas.height,
                r: Math.random() * 4 + 1, // Размер частиц
                d: Math.random() * 5 + 1 // Скорость движения
            }));
        }

        // Рисование снега
        function drawSnow() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.fillStyle = 'rgba(255, 255, 255, 0.8)';
            ctx.beginPath();
            particles.forEach(p => {
                ctx.moveTo(p.x, p.y);
                ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
            });
            ctx.fill();
            updateSnow();
        }

        // Обновление позиции частиц снега
        function updateSnow() {
            particles.forEach(p => {
                p.y += Math.pow(p.d, 0.5); // Падение частиц
                if (p.y > canvas.height) {
                    p.y = -p.r; // Перезапуск с верхней части экрана
                    p.x = Math.random() * canvas.width; // Случайная горизонтальная позиция
                }
            });
        }

        function animateSnow() {
            drawSnow();
            requestAnimationFrame(animateSnow);
        }

        initSnow();
        animateSnow();

        window.addEventListener('resize', initSnow);

        // Логика drag-and-drop для украшения ёлки
        const decorations = document.querySelectorAll('.decoration');
        const dropZones = document.querySelectorAll('.drop-zone');
        const congratulations = document.querySelector('.congratulations');

        let draggedElement = null;
        let filledZones = 0; // Счётчик занятых зон

        decorations.forEach(decoration => {
            decoration.addEventListener('mousedown', dragStart);
            decoration.addEventListener('mouseup', dragEnd);
            decoration.addEventListener('mousemove', dragMove);
            decoration.addEventListener('touchstart', dragStartTouch);
            decoration.addEventListener('touchend', dragEndTouch);
            decoration.addEventListener('touchmove', dragMoveTouch);
        });

        dropZones.forEach(zone => {
            zone.addEventListener('dragover', dragOver);
            zone.addEventListener('dragenter', dragEnter);
            zone.addEventListener('dragleave', dragLeave);
            zone.addEventListener('drop', drop);
            zone.addEventListener('touchstart', dropTouch);
        });

        function dragStart(e) {
            draggedElement = e.target;
            draggedElement.style.opacity = '0.5';
        }

        function dragMove(e) {
            if (draggedElement) {
                draggedElement.style.left = `${e.pageX - draggedElement.offsetWidth / 2}px`;
                draggedElement.style.top = `${e.pageY - draggedElement.offsetHeight / 2}px`;
            }
        }

        function dragEnd() {
            if (draggedElement) {
                draggedElement.style.opacity = '1';
                draggedElement.style.position = 'static';
            }
        }

        function dragStartTouch(e) {
            draggedElement = e.target;
            draggedElement.style.opacity = '0.5';
        }

        function dragMoveTouch(e) {
            if (draggedElement) {
                draggedElement.style.left = `${e.touches[0].pageX - draggedElement.offsetWidth / 2}px`;
                draggedElement.style.top = `${e.touches[0].pageY - draggedElement.offsetHeight / 2}px`;
            }
        }

        function dragEndTouch() {
            if (draggedElement) {
                draggedElement.style.opacity = '1';
            }
        }

        function dragOver(e) {
            e.preventDefault();
        }

        function dragEnter(e) {
            e.preventDefault();
            e.target.classList.add('hover');
        }

        function dragLeave(e) {
            e.target.classList.remove('hover');
        }

        function drop(e) {
            e.preventDefault();
            e.target.classList.remove('hover');
            if (draggedElement) {
                e.target.appendChild(draggedElement);
                draggedElement.style.position = 'static';
                draggedElement.style.opacity = '1';
                draggedElement.setAttribute('draggable', 'false');
                filledZones++;
                if (filledZones === dropZones.length) {
                    congratulations.style.display = 'block';
                }
            }
        }

        function dropTouch(e) {
            e.preventDefault();
            e.target.classList.remove('hover');
            if (draggedElement) {
                e.target.appendChild(draggedElement);
                draggedElement.style.position = 'static';
                draggedElement.style.opacity = '1';
                draggedElement.setAttribute('draggable', 'false');
                filledZones++;
                if (filledZones === dropZones.length) {
                    congratulations.style.display = 'block';
                }
            }
        }
    </script>
</body>
</html>
