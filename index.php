<?php
    declare(strict_types = 1);
    require_once(__DIR__ . '/database/connection.php');

    $db = getDatabaseConnection();
?>

<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>Calculator</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <script src="/javascript/script.js"></script>
    </head>

    <body>

        <header>
            <h1>Calculator</h1>
        </header>

        <main>
            <table id="calculator">
                <tr>
                    <td colspan="4">
                        <input type="text" id="screen" readonly>
                    </td>
                </tr>
                <tr>
                    <td>
                        <button type="button" class="btn btn-dark" value="RESET" onclick="clearScreen()">RESET</button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-secondary" value="(" onclick="addInput(this.value)">(</button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-secondary" value=")" onclick="addInput(this.value)">)</button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary" value="MOD" onclick="addInput(this.value)">MOD</button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <button type="button" class="btn btn-light" value="7" onclick="addInput(this.value)">7</button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-light" value="8" onclick="addInput(this.value)">8</button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-light" value="9" onclick="addInput(this.value)">9</button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary" value="/" onclick="addInput(this.value)">/</button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <button type="button" class="btn btn-light" value="4" onclick="addInput(this.value)">4</button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-light" value="5" onclick="addInput(this.value)">5</button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-light" value="6" onclick="addInput(this.value)">6</button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary" value="*" onclick="addInput(this.value)">*</button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <button type="button" class="btn btn-light" value="1" onclick="addInput(this.value)">1</button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-light" value="2" onclick="addInput(this.value)">2</button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-light" value="3" onclick="addInput(this.value)">3</button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary" value="-" onclick="addInput(this.value)">-</button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <button type="button" class="btn btn-light" value="0" onclick="addInput(this.value)">0</button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-secondary" value="." onclick="addInput(this.value)">.</button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-dark" value="=" onclick="computeResult()">=</button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary" value="+" onclick="addInput(this.value)">+</button>
                    </td>
                </tr>

        </main>

    </body>
</html>