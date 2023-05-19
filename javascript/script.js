
function addInput(value){
    console.log(value)
    var screen = document.getElementById("screen");
    screen.value += value;
}

function clearScreen(){
    var screen = document.getElementById("screen");
    screen.value = "";
}

function computeResult(){
    var screen = document.getElementById("screen");
    var operation = screen.value;
    if(operation.length > 0){
        (async () => {
            const response = await fetch('../api/api_calculator.php?operation=' + operation)
            const result = await response.json()
            screen.value = result
        })();
    }
}
  