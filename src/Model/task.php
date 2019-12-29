<?php
namespace APP\Model;
use App\Exception\ApiException;
use PDO;

class Task {
    protected $database;
    //set the database pdo obj
    public function __construct(PDO $database){
        $this->database = $database;
    }

    //retrieve task
    public function getTasks(){
        $sql = '
            SELECT * FROM tasks ORDER BY id;
        ';
        $pdo = $this->database->prepare($sql);
        $pdo->execute();
        $tasks = $pdo->fetchAll();
        if(empty($tasks)){
            throw new ApiException(ApiException::TASK_NOT_FOUND,404);
        }
        return $tasks;
    }

    //retrieve one task only
    public function getTask($taskId){
        $taskId = filter_var($taskId, FILTER_SANITIZE_NUMBER_INT);
        $sql = '
            SELECT * FROM tasks WHERE id = ?;
        ';
        $pdo = $this->database->prepare($sql);
        $pdo->bindValue(1, $taskId, PDO::PARAM_INT);
        $pdo->execute();
        $task = $pdo->fetch();
        if(empty($task)){
            throw new ApiException(ApiException::TASK_NOT_FOUND,404);
        }
        return $task;
    }

    //create one task
    public function addTask($data){
        if(empty($data['task']) || empty($data['status'])){
            throw new ApiException(ApiException::TASK_INFO_REQUIRED,400);
        }
        $task = filter_var($data['task'], FILTER_SANITIZE_STRING);
        $status = filter_var($data['status'], FILTER_SANITIZE_NUMBER_INT);
        $sql = '
            INSERT INTO tasks(task, status) VALUES (?, ?);
        ';
        $pdo = $this->database->prepare($sql);
        $pdo->bindValue(1, $task, PDO::PARAM_STR);
        $pdo->bindValue(2, $status, PDO::PARAM_INT);
        $pdo->execute();
        if($pdo->rowCount()<1){
            throw new ApiException(ApiException::TASK_CREATION_FAILED,400);
        }
        return $this->getTask($this->database->lastInsertId());
    }

    //update one task
    public function updateTask($data){
        if(empty($data['id']) || empty($data['task']) || empty($data['status'])){
            throw new ApiException(ApiException::TASK_INFO_REQUIRED,400);
        }
        $task = filter_var($data['task'], FILTER_SANITIZE_STRING);
        $status = filter_var($data['status'], FILTER_SANITIZE_NUMBER_INT);
        $taskId = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);
        $sql = '
            UPDATE tasks SET task = ?, status = ? WHERE id = ?;
        ';
        $pdo = $this->database->prepare($sql);
        $pdo->bindValue(1, $task, PDO::PARAM_STR);
        $pdo->bindValue(2, $status, PDO::PARAM_INT);
        $pdo->bindValue(3, $taskId, PDO::PARAM_INT);
        $pdo->execute();
        if($pdo->rowCount()<1){
            throw new ApiException(ApiException::TASK_CREATION_FAILED,400);
        }
        return $this->getTask($taskId);
    }

     //delete one task
     public function deleteTask($taskId){
        $taskId = filter_var($taskId, FILTER_SANITIZE_NUMBER_INT);
        $this->getTask($taskId);
        $sql = '
            DELETE FROM tasks WHERE id = ?; 
        ';
        $pdo = $this->database->prepare($sql);
        $pdo->bindValue(1, $taskId, PDO::PARAM_INT);
        $pdo->execute();
        if($pdo->rowCount()<1){
            throw new ApiException(ApiException::TASK_DELETE_FAILED,400);
        }
        return ['message' => 'The task was deleted'];
    }
}

?>