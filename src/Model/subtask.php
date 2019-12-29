<?php
namespace APP\Model;
use PDO;
class SubTask {
    protected $database;
    //set the database pdo obj
    public function __construct(PDO $database){
        $this->database = $database;
    }

    //retrieve task
    public function getReviewsByTaskId($taskId){
        $taskId = filter_var($taskId, FILTER_SANITIZE_NUMBER_INT);
        $sql = '
            SELECT * FROM subtasks WHERE task_id = ? ORDER BY id ;
        ';
        $pdo = $this->database->prepare($sql);
        $pdo->bindValue(1, $taskId, PDO::PARAM_INT);
        $pdo->execute();
        return $pdo->fetchAll();
    }

    //retrieve one task only
    public function getReviewByTaskId($id){
        $taskId = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $sql = '
            SELECT * FROM subtasks WHERE id = ?;
        ';
        $pdo = $this->database->prepare($sql);
        $pdo->bindValue(1, $taskId, PDO::PARAM_INT);
        $pdo->execute();
        return $pdo->fetch();
    }

    //create one task
    public function addReviewByTaskId($data){
        $task = filter_var($data['name'], FILTER_SANITIZE_STRING);
        $status = filter_var($data['status'], FILTER_SANITIZE_NUMBER_INT);
        $taskId = filter_var($data['taskId'], FILTER_SANITIZE_NUMBER_INT);
        $sql = '
            INSERT INTO subtasks(name, status, task_id) VALUES (?, ?, ?);
        ';
        $pdo = $this->database->prepare($sql);
        $pdo->bindValue(1, $task, PDO::PARAM_STR);
        $pdo->bindValue(2, $status, PDO::PARAM_INT);
        $pdo->bindValue(3, $taskId, PDO::PARAM_INT);
        $pdo->execute();
        return $this->getReviewByTaskId($this->database->lastInsertId());
    }

    //update one task
    public function updateReviewByTaskId($data){
        $task = filter_var($data['name'], FILTER_SANITIZE_STRING);
        $status = filter_var($data['status'], FILTER_SANITIZE_NUMBER_INT);
        $taskId = filter_var($data['taskId'], FILTER_SANITIZE_NUMBER_INT);
        $sql = '
            UPDATE subtasks SET name = ?, status = ? WHERE id = ?;
        ';
        $pdo = $this->database->prepare($sql);
        $pdo->bindValue(1, $task, PDO::PARAM_STR);
        $pdo->bindValue(2, $status, PDO::PARAM_INT);
        $pdo->bindValue(3, $taskId, PDO::PARAM_INT);
        $pdo->execute();
        return $this->getReviewByTaskId($taskId);
    }

     //delete one task
     public function deleteReviewBySubTaskId($id){
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $sql = '
            DELETE FROM subtasks WHERE id = ?; 
        ';
        $pdo = $this->database->prepare($sql);
        $pdo->bindValue(1, $id, PDO::PARAM_INT);
        $pdo->execute();
        return ['message' => 'The subtask was deleted'];
    }
}

?>