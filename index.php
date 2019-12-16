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
    var brickColumnCount = 7; // Defines the number of columns of bricks
    var brickWidth = 100; // Brick width
    var brickHeight = 30; // Brick height
    var brickPadding = 20; // Default brick padding
    var brickPaddingHeight = 20; // Spacing around brick
    var brickPaddingWidth = 50; // Spacing around brick
    var brickOffsetTop = 30; // Brick Position y-axis
    var brickOffsetLeft = 30; // Brick Position x-axis
    // var bricks = []; // Defines the number of bricks to generate - relies on 'brickRowCount' and 'brickColumnCount'

    // for (var c=0; c < brickColumnCount; c++) {
    //     bricks [c] = [];
    //     for (var r=0; r < brickColumnCount; r++) {
    //         bricks[c][r] = { x: 0, y: 0, status: = 1};
    //     }
    // }

    //------------------------------------------------------------//

    function drawBall() { // The following function "draw" defines the parameters for the ball and it called upon by 'setInterval' to refresh every 10 seconds
        ctx.beginPath();
        ctx.arc(x, y, ballRadius, 0, Math.PI*2);
        ctx.fillStyle = "#3ab918";
        ctx.fill();
        ctx.closePath();
    }

    function drawPaddle() { // Defines the surface controlled by the user
        ctx.beginPath();
        ctx.rect(paddleX, canvas.height - paddleHeight, paddleWidth, paddleHeight);
        ctx.fillStyle = "#0095DD";
        ctx.fill();
        ctx.closePath();
    }

    // Creates number of columns and rows until meets defined limit in variables 'brickColumnCount' and 'brickRowCount'
    function drawBricks() {
        for (var c = 0; c < brickColumnCount; c++) {
            for (var r = 0; r < brickRowCount; r++) {
                if (bricks[c][r].status == 1) {
                    var brickX = (c * (brickWidth + brickPadding)) + brickOffsetLeft;
                    var brickY = (r * (brickHeight + brickPadding)) + brickOffsetTop;
                    // var brickX = (c * (brickWidth + brickPaddingWidth)) + brickOffsetLeft;             // Original
                    // var brickY = (r * (brickHeight + brickPaddingHeight)) + brickOffsetTop;             // Original
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
    // End of Bricks

    // Bricks: Collision detection
    function brickCollisionDetection() {
        for(var c=0; c < brickColumnCount; c++) {
            for(var r=0; r < brickRowCount; r++) {
                var b = bricks[c][r];
                // The following if statement defines:
                    // For the center of the ball to be inside the brick, all four of the following statements need to be true:
                    // The x position of the ball is greater than the x position of the brick.
                    // The x position of the ball is less than the x position of the brick plus its width.
                    // The y position of the ball is greater than the y position of the brick.
                    // The y position of the ball is less than the y position of the brick plus its height.
                if(x > b.x && x < b.x+brickWidth && y > b.y && y < b.y+brickHeight) {
                    dy = -dy;
                    b.status = 0;
            }
        }
    }

    // End of Bricks: Collision detection

    function draw() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        drawBricks(); // We want these items to draw at the same time as 'interval= setInterval(draw, 10);' refreshes
        drawBall(); // Used to link the draw function to the drawball function; this format just keeps the code clean // We want these items to draw at the same time as 'interval= setInterval(draw, 10);' refreshes
        drawPaddle(); // We want these items to draw at the same time as 'interval= setInterval(draw, 10);' refreshes
        brickCollisionDetection();
    }


        if(x + dx > canvas.width-ballRadius || x + dx < ballRadius) { // Define the left and right wall barrier - prevent the ball from leaving the screen
            dx = -dx;
        }
        if(y + dy < ballRadius) {
            dy = -dy;
        } else if(y + dy > canvas.height-ballRadius) {
            if (x > paddleX && x < paddleX + paddleWidth) {
                dy =- dy
            }
            else {
                // alert("GAME OVER");
                document.location.reload();
                clearInterval(interval); // Needed for Chrome to end game
            }
        }

            if (rightPressed) { // Defines how much to move the paddle by when pressed
                paddleX += 7; // Applies a positive integer on the x-axis
                if (paddleX + paddleWidth > canvas.width) {
                    paddleX = canvas.width - paddleWidth;
                }
            }
            else if (leftPressed) {
                paddleX -= 7; // Applies a negative integer on the x-axis
                if (paddleX < 0) {
                    paddleX = 0;
                }
            }
        x += dx;
        y += dy;
    }
    var interval= setInterval(draw, 10); // This calls the function 'draw' 10 times per second


</script>

</body>
</html>