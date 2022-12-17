<?php

class User {
    public int $id;
    public int $balance;

    private PDO $connection;
    private string $db_table = "_user";

    public function __construct(int $id, PDO $connection, int $balance = 100) {
        $this->id = $id;
        $this->balance = $balance;
        $this->connection = $connection;
    }

    public function createUser(): bool {
        $query = "INSERT INTO " . $this->db_table . "(id, balance) VALUES (" . $this->id . ", " . $this->balance .");";
        $stmt = $this->connection->prepare($query);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function updateBalance(int $new_balance) {
        $query = "UPDATE " . $this->db_table . " SET balance = " . $new_balance . " WHERE id = " . $this->id . ";";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
    }

    public function getUser() {
        $query = "SELECT balance FROM " . $this->db_table . " WHERE id = " . $this->id . ";";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->balance = (int)$dataRow['balance'];
        return $this->balance;
    }

}