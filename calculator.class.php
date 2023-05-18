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

        function addCalculation(PDO $db){
            $stmt = $db->prepare('
                INSERT INTO Calculation (Ip, OperationTimestamp, Operation, Result, Bonus)
                VALUES (?, ?, ?, ?, ?)
            ');
            $stmt->execute(array($this->ip, $this->timestamp, $this->operation, $this->result, $this->bonus));
        }
    }
?>