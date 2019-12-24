<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Charles Lawrenson | Ball Bounce!</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style-game.css">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>

<div id='seconds-counter'> </div>
<canvas id="gameCanvas" width="1080" height="500"></canvas>

<button class="startBtn" onclick="startGame();" id="startBtnId">Start The Game</button>
<button class="endBtn" onclick="endGame();" id="endBtnId">End The Game</button>

<script>
    var canvas = document.getElementById("gameCanvas");
    var endBtn1 = document.getElementById("endBtnId").style.visibility = "hidden";
    var ctx = canvas.getContext("2d");
    var x = canvas.width/2; // Defines the starting position of the ball
    var y = canvas.height-30; // Defines the starting position of the ball
    var dx = 4; // Speed of the ball on x-axis and its direction
    var dy = -4; // Speed of the ball on x-axis and its direction
    var ballRadius = 12; // Defines the size of the ball; needed for collision detection
    var paddleHeight = 12; //Defines the paddle height manipulated by keyboard input
    var paddleWidth = 95; //Defines the paddle width manipulated by keyboard input
    var paddleX = (canvas.width-paddleWidth) / 2; // Determines the x-axis value of the paddle. We do not define 'paddleY' variable because we do not want it to move vertically
    var brickRowCount = 2; // Defines the number of rows of bricks
    var brickColumnCount = 7; // Defines the number of columns of bricks
    var brickWidth = 120; // Brick width
    var brickHeight = 30; // Brick height
    var brickPadding = 20; // Default brick padding
    var brickPaddingHeight = 20; // Spacing around brick
    var brickPaddingWidth = 90; // Spacing around brick
    var brickOffsetTop = 50; // Brick Position y-axis
    var brickOffsetLeft = 60; // Brick Position x-axis
    var bricks = [];
    var score = 0;
    var lives = 3;


    // Generating bricks
    for (var c = 0; c < brickColumnCount; c++) {
        bricks[c] = [];
        for (var r = 0; r < brickRowCount; r++) {
            bricks[c][r] = { x: 0, y: 0, status: 1 };
        }
    }

    function collisionDetection() {
        for (var c = 0; c < brickColumnCount; c++) {
            for (var r = 0; r < brickRowCount; r++) {
                var b = bricks[c][r];
                if (b.status === 1) {
                    if (x > b.x && x < b.x + brickWidth && y > b.y && y < b.y + brickHeight) {
                        dy = -dy;
                        b.status = 0;
                        score++;
                        if (score === brickRowCount * brickColumnCount) {
                            alert ("You WIN!, Congratulations!");
                            document.location.reload();
                            clearInterval(interval);
                        }
                    }
                }
            }
        }
    }

    function drawBall() {
        ctx.beginPath();
        ctx.arc(x, y, ballRadius, 0, Math.PI * 2);
        ctx.fillStyle = "#0095DD";
        ctx.fill();
        ctx.closePath();
    }

    function drawPaddle() {
        ctx.beginPath();
        ctx.rect(paddleX, canvas.height - paddleHeight, paddleWidth, paddleHeight);
        ctx.fillStyle = "#0095DD";
        ctx.fill();
        ctx.closePath();
    }

    function drawBricks() {
        for (var c = 0; c < brickColumnCount; c++) {
            for (var r = 0; r < brickRowCount; r++) {
                if (bricks[c][r].status === 1) {
                    var brickX = (c * (brickWidth + brickPadding)) + brickOffsetLeft;
                    var brickY = (r * (brickHeight + brickPadding)) + brickOffsetTop;
                    bricks[c][r].x = brickX;
                    bricks[c][r].y = brickY;
                    ctx.beginPath();
                    ctx.rect(brickX, brickY, brickWidth, brickHeight);
                    ctx.fillStyle = "#0095DD";
                    ctx.fill();
                    ctx.closePath();
                }
            }
        }
    }

    function drawScore() {
        ctx.font = "25px Arial";
        ctx.fillStyle = "#0095DD";
        ctx.fillText("Score: "+score, 20, 20);
    }

    function drawLives() {
        ctx.font = "25px Arial";
        ctx.fillStyle = "#0095DD";
        ctx.fillText("Lives: "+lives, canvas.width-105, 20);
    }

    function draw() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        drawBricks();
        drawBall();
        drawPaddle();
        collisionDetection();
        drawScore();
        drawLives()

        if (x + dx > canvas.width - ballRadius || x + dx < ballRadius) {
            dx = -dx;
        }
        if (y + dy < ballRadius) {
            dy = -dy;
        }
        else if (y + dy > canvas.height - ballRadius) {
            if (x > paddleX && x < paddleX + paddleWidth) {
                if (y = y - paddleHeight) {
                    dy = -dy;
                }
            }
            else {
                lives--;
                if(!lives) {
                    alert("GAME OVER");
                    document.location.reload();
                    clearInterval(interval);
                }
                else {
                    x = canvas.width/2;
                    y = canvas.height-30;
                    paddleX = (canvas.width-paddleWidth)/2;
                }
            }
        }

        if (rightPressed && paddleX < canvas.width - paddleWidth) {
            paddleX += 7;
        }
        else if (leftPressed && paddleX > 0) {
            paddleX -= 7;
        }

        x += dx;
        y += dy;
    }

    function startGame() {
        var interval = setInterval(draw, 10);
        var element = document.getElementById("startBtnId").style.visibility = "hidden";
        var endBtn1 = document.getElementById("endBtnId").style.visibility = "visible"; // This changes the state of the end game button to visivle to 'visible' once the start button has been pressed.
    }

    function endGame() {
        var element = document.getElementById("endBtnId").style.visibility = "hidden"; // We want the end game button to be hidden as the page loads
        document.location.reload();
        clearInterval(interval);
    }

</script>
<script type="text/javascript" src="js/user_controls.js"></script>

</body>
</html>