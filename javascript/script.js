var isDivision = false;
var isZero = false;
var isFirstParentheses = false;
var isSecondParentheses = false;
var isError = false;

var notNumbers = ["+", "-", "/", "*", "M", "(", ")", "MOD"];
var operators = ["+", "-", "/", "*", "M", "D"];

function addInput(value){
    console.log(value)

    if(isError){
        clearScreen();
        isError = false;
    }

    checkDivisionByZeroError(value);
    checkFirstParenthesesError(value);
    checkSecondParenthesesError(value);

    var screen = document.getElementById("screen");
    screen.value += value;
}

function clearScreen(){
    var screen = document.getElementById("screen");
    screen.value = "";
}

function computeResult(){

    if(isDivision && isZero){
        console.log("ERROR -  DIVISION");
        isDivision = false;
        isZero = false;
        error();
        return;
    }

    var screen = document.getElementById("screen");
    var operation = screen.value;
    if(operation.length > 0){
        (async () => {
            // Encode operation in order to send '+' encoded
            const encodedOperation = encodeURIComponent(operation);
            const response = await fetch('../api/api_calculator.php?operation=' + encodedOperation);
            const result = await response.json()
            screen.value = result
        })();
    }
}

function checkDivisionByZeroError(value){
     // There's an error if the user tries to do a division by zero
     if(isDivision && isZero && notNumbers.includes(value)){
        console.log("ERROR - DIVISION");
        isDivision = false;
        isZero = false;
        error();
        return;
    }

    // Checks if the value is an operator and sets isDivision to true in case of it being a division
    if(value == "/"){
        console.log("ISDIVISION")
        isDivision = true;
    }
    else if(notNumbers.includes(value)){
        isDivision = false;
    }

    // Checks if the value is a number and sets isZero to true in case of it being zero
    if(value == "0"){
        console.log("ISZERO");
        isZero = true;
    }
    else if (!notNumbers.includes(value)){
        isZero = false;
    }
}

// First parentheses must be at the beggining of the operation or have an operator on the left side and a number on the right side
// Example situations of first parentheses error:
// number followed by first parentheses ->  1+2(2-1)
// first parentheses followed by operator -> 1+2+(+1
function checkFirstParenthesesError(value){
    var screen = document.getElementById("screen");
    var currentOperation = screen.value;

    if(isFirstParentheses){
        // Right side constraint 
        if(notNumbers.includes(value) || value == "."){
            console.log("ERROR - First Parentheses must have a number on the right side");
            isFirstParentheses = false;
            error();
            return;
        }
        isFirstParentheses = false;
    }

    if(value == "("){
        isFirstParentheses = true;

        // Left side constraint
        if(currentOperation.length != 0){
            var lastChar = currentOperation.charAt(currentOperation.length - 1);
            if(!operators.includes(lastChar)){
                console.log("ERROR - First Parentheses must have an operator on the left side");
                isFirstParentheses = false;
                error();
                return;
            }
        }
    }
}


// Second parentheses must have a number on the left side and an operator on the right side
// Example situations of second parentheses error:
// operator followed by second parentheses ->  1+(2-)
// second parentheses followed by number -> 1+(1-2)3
function checkSecondParenthesesError(value){
    var screen = document.getElementById("screen");
    var currentOperation = screen.value;    
    var lastChar = currentOperation.charAt(currentOperation.length - 1);


    if(value == ")"){
        isSecondParentheses = true;

        // Left side constraint
        if(currentOperation.length == 0 || notNumbers.includes(lastChar) || lastChar == "."){
            console.log("ERROR - Second Parentheses must have a number on the left side");
            isSecondParentheses = false;
            error();
            return;
        }
    }

    if(isSecondParentheses){
        // Right side constraint
        if(!operators.includes(value)){
            console.log("ERROR - Second Parentheses must have an operator on the right side");
            isSecondParentheses = false;
            error();
            return;
        }
        isSecondParentheses = false;
    }
}

function error(){
    console.log("Inside error function");
    var screen = document.getElementById("screen");
    screen.value = "ERROR";
    isError = true;
}