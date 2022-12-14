<?php

class Promise {
    public int $id;
    public int $user_id;
    public string $task_name;
    public string $completed_date;
    public string $task;
    public int $cost;
    public bool $is_completed;

    private PDO $connection;
    private string $db_table = "_promise";

    public function __construct(int $id, int $user_id, string $task_name, string $completed_date,
                                string $task, PDO $connection, int $cost = 10, bool $is_completed = false) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->task_name = $task_name;
        $this->is_completed = $is_completed;
        $this->completed_date = $completed_date;
        $this->task = $task;
        $this->cost = $cost;
        $this->connection = $connection;
    }

    public function toString(): string {
        return $this->task . ". You started at " . $this->start_time . "and you should end in" . $this->completed_date . " for " . $this->cost . "points";
    }

    private function createPromise() {
        $query =    "INSERT INTO " . $this->db_table . " (id, user_id, task_name, completed_date, task, cost, is_completed )
                    VALUES ( $this->id , $this->user_id, $this->task_name, $this->completed_date, $this->task, $this->cost, $this->is_completed );";
        $stmt = $this->connection->prepare($query);
        if ($stmt->execute()) {
            $this->id = $this->connection->lastInsertId();
            return true;
        }

        return false;
    }

    public function insert() {
        $res = $this->getByName();
        if ($res) {
            // TODO если есть 1 или больше похожих задач
        } else {
            $this->createPromise();
        }
        return $this->id;
    }

    private function getByName() {
        $query = "SELECT * FROM " . $this->db_table . " WHERE task_name = $this->task_name";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}