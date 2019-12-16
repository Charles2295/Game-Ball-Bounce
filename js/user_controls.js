// Keyboard Controls
var rightPressed = false; // Are set to false until keyDownHandler down function changes state
var leftPressed = false; // Are set to false until keyDownHandler down function changes state

document.addEventListener("keydown", keyDownHandler, false); // Listens for if the key has been pressed. The function 'keyDownHandler' determines what key to listen for
document.addEventListener("keyup", keyUpHandler, false); // Listens for if the key has been pressed. The function 'keyDownHandler' determines what key to listen for

function keyDownHandler(e) { // Defines the behaviour once the key is pressed, it does not account for key release, this is specified using the function 'keyUpHandler'
    if (e.key === "Right" || e.key === "ArrowRight") { // == If the right arrow key is pressed, move right
        rightPressed = true;
    }
    else if (e.key === "Left" || e.key === "ArrowLeft") { // == If the left arrow key is pressed, move left
        leftPressed = true;
    }
}

function keyUpHandler(e) { // Defines the behaviour of controls once the key is released.
    if (e.key === "Right" || e.key === "ArrowRight") { // == If the right arrow key is released, stop moving right
        rightPressed = false;
    } else if (e.key === "Left" || e.key === "ArrowLeft") { // == If the left arrow key is release, stop moving left
        leftPressed = false;
    }
}

// Mouse Controls
var relativeX = e.clientX - canvas.offsetLeft;

document.addEventListener("mousemove", mouseMoveHandler, false);

function mouseMoveHandler(e) {
    var relativeX = e.clientX - canvas.offsetLeft;
    if(relativeX > 0 && relativeX < canvas.width) {
        paddleX = relativeX - paddleWidth/2;
    }
}