<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Charles Lawrenson | Ball Bounce!</title>
    <link rel="stylesheet" type="text/css" href="assets/css/stylesheet.css">
    <script type="text/javascript" src="js/user_controls.js"></script> <!-- Linking javascript files to index.php-->
</head>
<body>

<div id='seconds-counter'> </div>
<canvas id="myCanvas" width="1080" height="500"></canvas>

<script>
    var canvas = document.getElementById("myCanvas");
    var ctx = canvas.getContext("2d");
    var x = canvas.width/2; // Defines the starting position of the ball
    var y = canvas.height-30; // Defines the starting position of the ball
    var dx = 4; // Speed of the ball on x-axis and its direction
    var dy = -4; // Speed of the ball on x-axis and its direction
    var ballRadius = 12; // Defines the size of the ball; needed for collision detection
    var paddleHeight = 10; //Defines the paddle height manipulated by keyboard input
    var paddleWidth = 75; //Defines the paddle width manipulated by keyboard input
    var paddleX = (canvas.width-paddleWidth) / 2; // Determines the x-axis value of the paddle. We do not define 'paddleY' variable because we do not want it to move vertically
    var brickRowCount = 3; // Defines the number of rows of bricks
    var brickColumnCount = 8; // Defines the number of columns of bricks
    var brickWidth = 100; // Brick width
    var brickHeight = 30; // Brick height
    var brickPadding = 20; // Default brick padding
    var brickPaddingHeight = 20; // Spacing around brick
    var brickPaddingWidth = 90; // Spacing around brick
    var brickOffsetTop = 30; // Brick Position y-axis
    var brickOffsetLeft = 60; // Brick Position x-axis
    var bricks = [];


    //------------------------------------------------------------//

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
                if (b.status == 1) {
                    if (x > b.x && x < b.x + brickWidth && y > b.y && y < b.y + brickHeight) {
                        dy = -dy;
                        b.status = 0;
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
                if (bricks[c][r].status == 1) {
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

    function draw() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        drawBricks();
        drawBall();
        drawPaddle();
        collisionDetection();

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
                // alert("GAME OVER");
                document.location.reload();
                clearInterval(interval); // Needed for Chrome to end game
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

    var interval = setInterval(draw, 10);

</script>

</body>
</html>