<?php
namespace APP\Model;
use App\Exception\ApiException;
use PDO;
class SubTask {
    protected $database;
    //set the database pdo obj
    public function __construct(PDO $database){
        $this->database = $database;
    }

    //retrieve task
    public function getSubTasksByTaskId($taskId){
        $taskId = filter_var($taskId, FILTER_SANITIZE_NUMBER_INT);
        $sql = '
            SELECT * FROM subtasks WHERE task_id = ? ORDER BY id ;
        ';
        $pdo = $this->database->prepare($sql);
        $pdo->bindValue(1, $taskId, PDO::PARAM_INT);
        $pdo->execute();
        $subtasks = $pdo->fetchAll();
        if(empty($subtasks)){
            throw new ApiException(ApiException::SUBTASK_NOT_FOUND,404);
        }
        return $subtasks;
    }

    //retrieve one task only
    public function getSubTaskByTaskId($id){
        $taskId = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $sql = '
            SELECT * FROM subtasks WHERE id = ?;
        ';
        $pdo = $this->database->prepare($sql);
        $pdo->bindValue(1, $taskId, PDO::PARAM_INT);
        $pdo->execute();
        $subtask = $pdo->fetch();
        if(empty($subtask)){
            throw new ApiException(ApiException::SUBTASK_NOT_FOUND,404);
        }
        return $subtask;
    }

    //create one task
    public function addSubTaskByTaskId($data){
        if(empty($data['status']) || empty($data['name'])){
            throw new ApiException(ApiException::SUBTASK_INFO_REQUIRED,400);
        }
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
        if($pdo->rowCount()<1){
            throw new ApiException(ApiException::SUBTASK_CREATION_FAILED,400);
        }
        return $this->getSubtaskByTaskId($this->database->lastInsertId());
    }

    //update one task
    public function updateSubtaskByTaskId($data){
        if(empty($data['taskId']) || empty($data['task']) || empty($data['status'])){
            throw new ApiException(ApiException::TASK_INFO_REQUIRED,400);
        }
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
        if($pdo->rowCount()<1){
            throw new ApiException(ApiException::SUBTASK_UPDATE_FAILED,400);
        }
        return $this->getSubtaskByTaskId($taskId);
    }

     //delete one task
     public function deleteSubtaskBySubTaskId($id){
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $this->getReviewByTaskId($id);
        $sql = '
            DELETE FROM subtasks WHERE id = ?; 
        ';
        $pdo = $this->database->prepare($sql);
        $pdo->bindValue(1, $id, PDO::PARAM_INT);
        $pdo->execute();
        if($pdo->rowCount()<1){
            throw new ApiException(ApiException::SUBTASK_DELETE_FAILED,400);
        }
        return ['message' => 'The subtask was deleted'];
    }
}

?>