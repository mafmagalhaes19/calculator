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
            $operationArray = str_split($operation);
            $newNumber="";

            foreach($operationArray as $val){
                $newNumber .= $val;
                $aux = (float) $newNumber;
            }
            $result = $aux + 1;
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