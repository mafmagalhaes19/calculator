<?php
    declare(strict_types = 1);

    class Calculator {
        public string $ip;
        public int $timestamp;
        public string $operation;
        public float $result;
        public bool $bonus;

        public function __construct(string $ip, int $timestamp, string $operation, float $result, bool $bonus){
            $this->ip = $ip;
            $this->timestamp = $timestamp;
            $this->operation = $operation;
            $this->result = $result;
            $this->bonus = $bonus;
        }

        static function computeCalculation(PDO $db, string $operation){
            $operators = ["+", "-", "*", "/"];
            $currentChar = "";
            $currentNumber="";
            $allNumbers = [];
            $allOperations = [];

            // for loop through $operation in order to separate the numbers and the operators of the current calculation
            for($i = 0; $i < strlen($operation); $i++){
                $currentChar = $operation[$i];

                if(in_array($currentChar, $operators)){
                    $allOperations[] = $currentChar;

                    $number = (float) $currentNumber;
                    $allNumbers[] = $number;
                    $currentNumber = "";
                }
                else if($currentChar == "M"){
                    $allOperations[] = "MOD";

                    $number = (float) $currentNumber;
                    $allNumbers[] = $number;
                    $currentNumber = "";

                    $i += 2;
                }
                else {
                    $currentNumber .= $currentChar;
                }
            };

            // the las number needs to be added into $allNumbers
            if(strlen($currentNumber) > 0){
                $number = (float) $currentNumber;
                $allNumbers[] = $number;
            }

            $result = self::getFinalResult($allNumbers, $allOperations);
            return $result;
        }

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

        function addCalculation(PDO $db, string $ip, int $timestamp, string $operation, float $result, bool $bonus){
            $stmt = $db->prepare('
                INSERT INTO Calculation (Ip, OperationTimestamp, Operation, Result, Bonus)
                VALUES (?, ?, ?, ?, ?)
            ');
            $stmt->execute([$ip, $timestamp, $operation, $result, $bonus]);
        }
          
    }
?>