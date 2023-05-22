var isDivision = false;
var isZero = false;
var isFirstParenthesis = false;
var isSecondParenthesis = false;
var isError = false;
var isBonus = false;

var notNumbers = ["+", "-", "/", "*", "M", "(", ")", "MOD"];
var operators = ["+", "-", "/", "*", "M", "D", "MOD"];

function addInput(value){
    console.log(value)

    if(isError){
        clearScreen();
        isError = false;
    }

    if(isBonus){
        clearScreen();
        isBonus = false;
    }

    checkBeginningError(value);
    checkDivisionByZeroError(value);
    checkFirstParenthesisError(value);
    checkSecondParenthesisError(value);

    if(!isError){
        var screen = document.getElementById("screen");
        screen.value += value; 
    }
}

function clearScreen(){
    var screen = document.getElementById("screen");
    screen.value = "";

    isDivision = false;
    isZero = false;
    isFirstParenthesis = false;
    isSecondParenthesis = false;
    isError = false;
    isBonus = false;
}

function computeResult(){

    if(isDivision && isZero){
        console.log("ERROR -  You can't divide a number by zero");
        isDivision = false;
        isZero = false;
        error();
        return;
    }

    checkEndingError();

    var screen = document.getElementById("screen");
    var operation = screen.value;
    if(operation.length > 0 && !isError){
        (async () => {
            // Encode operation in order to send '+' encoded
            const encodedOperation = encodeURIComponent(operation);
            const response = await fetch('../api/api_calculator.php?operation=' + encodedOperation);
            const data = await response.json();
            const { result, randomNumber, bonus } = JSON.parse(data);

            if(bonus){
                isBonus = true;
                screen.value = result + " + BONUS :)";
            }
            else {
                screen.value = result;
            }
            console.log("Result -> ", result);
            console.log("Random number -> ", randomNumber)
            console.log("Bonus -> ", bonus);
        })();
    }
}

function checkDivisionByZeroError(value){
     // There's an error if the user tries to do a division by zero
     if(isDivision && isZero && notNumbers.includes(value)){
        console.log("ERROR - You can't divide a number by zero");
        isDivision = false;
        isZero = false;
        error();
        return;
    }

    // Checks if the value is an operator and sets isDivision to true in case of it being a division
    if(value == "/"){
        isDivision = true;
    }
    else if(notNumbers.includes(value)){
        isDivision = false;
    }

    // Checks if the value is a number and sets isZero to true in case of it being zero
    if(value == "0"){
        isZero = true;
    }
    else if (!notNumbers.includes(value)){
        isZero = false;
    }
}

// First parenthesis must be at the beginning of the operation or have an operator on the left side and a number on the right side
// Example situations of first parenthesis error:
// number followed by first parenthesis ->  1+2(2-1)
// first parenthesis followed by operator -> 1+2+(+1
function checkFirstParenthesisError(value){
    var screen = document.getElementById("screen");
    var currentOperation = screen.value;

    if(isFirstParenthesis){
        // Right side constraint 
        if(operators.includes(value) || value == "."){
            console.log("ERROR - First Parenthesis must have a number on the right side");
            isFirstParenthesis = false;
            error();
            return;
        }
        isFirstParenthesis = false;
    }

    if(value == "("){
        isFirstParenthesis = true;

        // Left side constraint
        if(currentOperation.length > 0){
            var lastChar = currentOperation.charAt(currentOperation.length - 1);
            if(!operators.includes(lastChar)){
                console.log("ERROR - First Parenthesis must have an operator on the left side");
                isFirstParenthesis = false;
                error();
                return;
            }
        }
    }
}


// Second parenthesis must have a number on the left side and an operator on the right side
// Example situations of second parenthesis error:
// operator followed by second parenthesis ->  1+(2-)
// second parenthesis followed by number -> 1+(1-2)3
function checkSecondParenthesisError(value){
    var screen = document.getElementById("screen");
    var currentOperation = screen.value;    
    var lastChar = currentOperation.charAt(currentOperation.length - 1);

    if(isSecondParenthesis){
        // Right side constraint
        if(!operators.includes(value)){
            console.log("ERROR - Second Parenthesis must have an operator on the right side");
            isSecondParenthesis = false;
            error();
            return;
        }
        isSecondParenthesis = false;
    }


    if(value == ")"){
        isSecondParenthesis = true;

        // Left side constraint
        if(currentOperation.length == 0 || operators.includes(lastChar) || lastChar == "."){
            console.log("ERROR - Second Parenthesis must have a number on the left side");
            isSecondParenthesis = false;
            error();
            return;
        }
    }  
}

// The beginning of the operation can't be an operator
function checkBeginningError(value){
    var screen = document.getElementById("screen");
    var currentOperation = screen.value;

    if(currentOperation.length == 0 && operators.includes(value)){
        console.log("ERROR - Beginning must be a number or parenthesis");
        error();
        return;
    }
}

// The ending of the operation can't be an operator
function checkEndingError(){
    var screen = document.getElementById("screen");
    var currentOperation = screen.value;
    var lastChar = currentOperation.charAt(currentOperation.length - 1);

    if(operators.includes(lastChar)){
        console.log("ERROR - Ending must be a number or parenthesis");
        error();
        return;
    }
}


function error(){
    var screen = document.getElementById("screen");
    screen.value = "ERROR";
    isError = true;

    isDivision = false;
    isZero = false;
    isFirstParenthesis = false;
    isSecondParenthesis = false;
}