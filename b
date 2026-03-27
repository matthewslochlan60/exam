<!DOCTYPE html>
<html>
<head>
    <title>Square Dodger</title>
    <style>
        body { margin: 0; display: flex; justify-content: center; align-items: center; height: 100vh; background: #222; color: white; font-family: sans-serif; overflow: hidden; }
        canvas { border: 2px solid #fff; background: #000; }
        .info { position: absolute; top: 10px; text-align: center; }
    </style>
</head>
<body>
    <div class="info">
        <h1>Square Dodger</h1>
        <p>Use <b>Arrow Keys</b> to move. Don't hit the red squares!</p>
        <h2 id="score">Score: 0</h2>
    </div>
    <canvas id="gameCanvas"></canvas>

    <script>
        const canvas = document.getElementById("gameCanvas");
        const ctx = canvas.getContext("2d");
        const scoreElement = document.getElementById("score");

        canvas.width = 600;
        canvas.height = 400;

        let score = 0;
        let gameActive = true;

        // Player object
        const player = { x: 50, y: 200, size: 20, color: "#00FF00", speed: 5 };

        // Enemies array
        const enemies = [];
        function createEnemy() {
            const size = Math.random() * 30 + 10;
            enemies.push({
                x: canvas.width,
                y: Math.random() * (canvas.height - size),
                size: size,
                speed: Math.random() * 4 + 8,
                color: "#FF4444"
            });
        }

        // Input handling
        const keys = {};
        window.addEventListener("keydown", e => keys[e.code] = true);
        window.addEventListener("keyup", e => keys[e.code] = false);

        function update() {
            if (!gameActive) return;

            // Move player
            if (keys["ArrowUp"] && player.y > 0) player.y -= player.speed;
            if (keys["ArrowDown"] && player.y < canvas.height - player.size) player.y += player.speed;
            if (keys["ArrowLeft"] && player.x > 0) player.x -= player.speed;
            if (keys["ArrowRight"] && player.x < canvas.width - player.size) player.x += player.speed;

            // Manage enemies
            if (Math.random() < 0.07) createEnemy();

            enemies.forEach((enemy, index) => {
                enemy.x -= enemy.speed;

                // Collision detection
                if (player.x < enemy.x + enemy.size &&
                    player.x + player.size > enemy.x &&
                    player.y < enemy.y + enemy.size &&
                    player.y + player.size > enemy.y) {
                    gameActive = false;
                    alert("Game Over! Score: " + score);
                    location.reload(); 
                }

                // Remove off-screen enemies and add score
                if (enemy.x + enemy.size < 0) {
                    enemies.splice(index, 1);
                    score++;
                    scoreElement.innerText = "Score: " + score;
                }
            });
        }

        function draw() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Draw player
            ctx.fillStyle = player.color;
            ctx.fillRect(player.x, player.y, player.size, player.size);

            // Draw enemies
            enemies.forEach(enemy => {
                ctx.fillStyle = enemy.color;
                ctx.fillRect(enemy.x, enemy.y, enemy.size, enemy.size);
            });

            if (gameActive) requestAnimationFrame(() => { update(); draw(); });
        }

        draw();
    </script>
</body>
</html>
