<?php
    declare(strict_types = 1);

    class Calculator {
        static function computeCalculation(PDO $db, string $operation){
            $operators = ["+", "-", "*", "/"];
            $currentChar = "";
            $currentNumber="";
            $allNumbers = [];
            $allOperations = [];
            $isNestedOperation = false;

            // For loop through $operation in order to separate the numbers and the operators of the current calculation
            for($i = 0; $i < strlen($operation); $i++){
                $currentChar = $operation[$i];

                if(in_array($currentChar, $operators)){
                    $allOperations[] = $currentChar;

                    // Without this condition, after a nested operation we would add a 0 to the operation
                    if(!$isNestedOperation){
                        $number = (float) $currentNumber;
                        $allNumbers[] = $number;
                        $currentNumber = "";
                    }
                    else{
                        $isNestedOperation = false;
                    }
                }
                else if($currentChar == "M"){
                    $allOperations[] = "MOD";

                    if(!$isNestedOperation){
                        $number = (float) $currentNumber;
                        $allNumbers[] = $number;
                        $currentNumber = "";
                    }
                    else{
                        $isNestedOperation = false;
                    }
                    
                    $i += 2;
                }
                else if($currentChar == "("){
                    $newOperation = "";

                    for($j = $i; $j < strlen($operation); $j++){
                        $currentChar = $operation[$j];
                        if($currentChar != ")"){
                            $newOperation .= $currentChar;
                        }
                        else {
                            // Calculate nested operation
                            $jsonResult = self::computeCalculation($db, $newOperation);
                            $auxResult = json_decode($jsonResult, true);

                            $number = $auxResult['result'];
                            $allNumbers[] = $number;

                            $i = $j;
                            $isNestedOperation = true;
                            break;
                        }
                    }
                }
                else {
                    $currentNumber .= $currentChar;
                }
            };

            // The last number needs to be added into $allNumbers
            if(strlen($currentNumber) > 0){
                $number = (float) $currentNumber;
                $allNumbers[] = $number;
            }

            // Compute final result of $operation
            $result = self::getFinalResult($allNumbers, $allOperations);

            // Get the server IP
            $serverIP = gethostbyname($_SERVER['SERVER_NAME']);

            // Get the current timestamp
            $timestamp = time();
 
            // Generate random number in order to check if there's bonus in the current operaation
            $randomNumber = rand(1, 100);

            // Bonus starts as false
            $bonus = false;
 
            // Check if there's bonus
            if($result == $randomNumber){
                $bonus = true;
            }
 
            // Add the current calculation into the database
            self::addCalculation($db, $serverIP, $timestamp, $operation, $result, $bonus);
 
            $response = array(
                'result' => $result,
                'randomNumber' => $randomNumber,
                'bonus' => $bonus
            );
 
            // Encode the response as JSON
            $jsonResponse = json_encode($response);

            return $jsonResponse;
        }

        // Computes the final result of the current calculation
        static function getFinalResult(array $allNumbers, array $allOperations){
            $result = $allNumbers[0];
            
            for($i = 0; $i < sizeof($allOperations); $i++){
                $operation = $allOperations[$i];
                $number = $allNumbers[$i + 1];

                switch($operation) {
                    case "+":
                        $result += $number;
                        break;
                    case "-":
                        $result -= $number;
                        break;
                    case "*":
                        $result *= $number;
                        break;
                    case "/":
                        $result /= $number;
                        break;
                    case "MOD":
                        $result %= $number;
                        break;
                }
            }

            return $result;
        }

        // Adds calculation to the database
        static function addCalculation(PDO $db, string $ip, int $timestamp, string $operation, float $result, bool $bonus){
            $stmt = $db->prepare('
                INSERT INTO Calculator (Ip, OperationTimestamp, Operation, Result, Bonus)
                VALUES (?, ?, ?, ?, ?)
            ');

            if($bonus){
                $finalBonus = 1;
            }
            else {
                $finalBonus = 0;
            }
            $stmt->execute([$ip, $timestamp, $operation, $result, $finalBonus]);
        }
    }
?>