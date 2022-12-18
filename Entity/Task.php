<?php

class Task
{
    public int $id;
    public int $user_id;
    public string $task_name;
    public string $completed_date;
    public string $task;
    public int $cost;
    public bool $is_completed;

    private PDO $connection;
    private string $db_table = "_task";

    public function __construct(int    $id, int $user_id, string $task_name, string $completed_date,
                                string $task, PDO $connection, int $cost = 10, bool $is_completed = false)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->task_name = $task_name;
        $this->is_completed = $is_completed;
        $this->completed_date = $completed_date;
        $this->task = $task;
        $this->cost = $cost;
        $this->connection = $connection;
    }

    public function toString(): string
    {
        $task = $this->task;
        if ($this->task = "''") {
            $task = "";
        }
        return $this->task_name . ".\n $task \n You should end in " . $this->completed_date . " for " . $this->cost . " points";
    }

    public function createTask(): bool
    {
        $query = "INSERT INTO " . $this->db_table . " (id, user_id, task_name, completed_date, task, cost) VALUES ( $this->id , $this->user_id, $this->task_name, $this->completed_date, $this->task, $this->cost );";
        $stmt = $this->connection->prepare($query);
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }


    private function getByName()
    {
        $query = "SELECT * FROM " . $this->db_table . " WHERE task_name = $this->task_name";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}