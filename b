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
        <p>Arrow Keys to move | Hold Space to shoot</p>
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

        const player = { x: 50, y: 200, size: 20, color: "#00FF00", speed: 5 };

        const enemies = [];
        const bullets = [];

        // 🔫 fire control
        let canShoot = true;
        const shootCooldown = 180; // slightly faster but still balanced

        function createEnemy() {
            const size = Math.random() * 30 + 10;
            enemies.push({
                x: canvas.width,
                y: Math.random() * (canvas.height - size),
                size: size,
                speed: Math.random() * 4 + 4,
                health: Math.ceil(size / 10),
                color: "#FF4444"
            });
        }

        const keys = {};

        window.addEventListener("keydown", e => {
            keys[e.code] = true;
        });

        window.addEventListener("keyup", e => {
            keys[e.code] = false;
        });

        function shoot() {
            bullets.push({
                x: player.x + player.size,
                y: player.y + player.size / 2 - 2,
                width: 10,
                height: 4,
                speed: 8
            });
        }

        function update() {
            if (!gameActive) return;

            // 🏃 Player movement
            if (keys["ArrowUp"] && player.y > 0) player.y -= player.speed;
            if (keys["ArrowDown"] && player.y < canvas.height - player.size) player.y += player.speed;
            if (keys["ArrowLeft"] && player.x > 0) player.x -= player.speed;
            if (keys["ArrowRight"] && player.x < canvas.width - player.size) player.x += player.speed;

            // 🔫 HOLD SPACE TO SHOOT (smooth firing)
            if (keys["Space"] && canShoot) {
                shoot();
                canShoot = false;
                setTimeout(() => canShoot = true, shootCooldown);
            }

            // Spawn enemies
            if (Math.random() < 0.07) createEnemy();

            // Move enemies + collision
            enemies.forEach((enemy, eIndex) => {
                enemy.x -= enemy.speed;

                // 💀 collision = game over
                if (
                    player.x < enemy.x + enemy.size &&
                    player.x + player.size > enemy.x &&
                    player.y < enemy.y + enemy.size &&
                    player.y + player.size > enemy.y
                ) {
                    gameActive = false;
                    alert("Game Over! Score: " + score);
                    location.reload();
                }

                if (enemy.x + enemy.size < 0) {
                    enemies.splice(eIndex, 1);
                    score++;
                    scoreElement.innerText = "Score: " + score;
                }
            });

            // Bullets
            bullets.forEach((bullet, bIndex) => {
                bullet.x += bullet.speed;

                if (bullet.x > canvas.width) {
                    bullets.splice(bIndex, 1);
                    return;
                }

                enemies.forEach((enemy, eIndex) => {
                    if (
                        bullet.x < enemy.x + enemy.size &&
                        bullet.x + bullet.width > enemy.x &&
                        bullet.y < enemy.y + enemy.size &&
                        bullet.y + bullet.height > enemy.y
                    ) {
                        enemy.health--;
                        bullets.splice(bIndex, 1);

                        if (enemy.health <= 0) {
                            enemies.splice(eIndex, 1);
                            score += 2;
                            scoreElement.innerText = "Score: " + score;
                        }
                    }
                });
            });
        }

        function draw() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Player
            ctx.fillStyle = player.color;
            ctx.fillRect(player.x, player.y, player.size, player.size);

            // Enemies
            enemies.forEach(enemy => {
                ctx.fillStyle = enemy.color;
                ctx.fillRect(enemy.x, enemy.y, enemy.size, enemy.size);
            });

            // Bullets
            ctx.fillStyle = "#FFFF00";
            bullets.forEach(bullet => {
                ctx.fillRect(bullet.x, bullet.y, bullet.width, bullet.height);
            });

            if (gameActive) requestAnimationFrame(() => { update(); draw(); });
        }

        draw();
    </script>
</body>
</html>
