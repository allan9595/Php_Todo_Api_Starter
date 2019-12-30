<?php
use Slim\Http\Request;
use Slim\Http\Response;

//redirect to proper route
$app->get('/', function ($request, $response, $args) { 
    $endpoints = [
        'all tasks' => $this->api['api_url'].'/todos',
        'single task' => $this->api['api_url'].'/todos/{task_id}'
    ];
    $result = [
        'msg' => 'Welcome to todos api!',
        'endpoints' => $endpoints,
        'version' => $this->api['version']
    ];
    return $response->withJson($result, 200, JSON_PRETTY_PRINT); 
});

$app->group('/api/v1/todos', function() use($app) {
    //get all tasks
    $app->get('', function ($request, $response, $args) {
        $result = $this->task->getTasks();
        return $response->withJson($result, 200, JSON_PRETTY_PRINT);
    });

    //get one task
    $app->get('/{id}', function ($request, $response, $args) {
        $result = $this->task->getTask($args['id']);
        return $response->withJson($result, 200, JSON_PRETTY_PRINT);
    });

    //post one task
    $app->post('', function ($request, $response, $args) {
        $result = $this->task->addTask($request->getParsedBody());
        return $response->withJson($result, 201, JSON_PRETTY_PRINT);
    });
    
    //put one task
    $app->put('/{id}', function ($request, $response, $args) {
        $data = $request->getParsedBody();
        $data['id'] = $args['id']; //assign the id to the data['id']
        $result = $this->task->updateTask($data);
        return $response->withJson($result, 200, JSON_PRETTY_PRINT);
    }); 

    //delete one task
    $app->delete('/{id}', function ($request, $response, $args) {
        $result = $this->task->deleteTask($args['id']);
        return $response->withJson($result, 200, JSON_PRETTY_PRINT);
    });


    //subtasks section
    $app->group('/{task_id}/subtasks', function() use($app) {
        //get all subtasks
        $app->get('', function ($request, $response, $args) {
            $result = $this->subtask->getSubTasksByTaskId($args['task_id']);
            return $response->withJson($result, 200, JSON_PRETTY_PRINT);
        });
 
        //get a subtasks
        $app->get('/{subtask_id}', function ($request, $response, $args) {
            $result = $this->subtask->getSubTaskByTaskId($args['subtask_id']);
            return $response->withJson($result, 200, JSON_PRETTY_PRINT);
        });

        //add a subtasks
        $app->post('', function ($request, $response, $args) {
            $this->task->getTask($args['task_id']); //check if the primart task exist
            $data = $request->getParsedBody();
            $data['taskId'] = $args['task_id']; //assign the id to the data['id']
            $result = $this->subtask->addSubTaskByTaskId($data);
            return $response->withJson($result, 201, JSON_PRETTY_PRINT);
        });

        //update a subtasks
        $app->put('/{subtask_id}', function ($request, $response, $args) {
            $data = $request->getParsedBody();
            $data['taskId'] = $args['subtask_id']; //assign the id to the data['id']
            $result = $this->subtask->updateSubTaskByTaskId($data);
            return $response->withJson($result, 200, JSON_PRETTY_PRINT);
        });

        //delete subtask
        $app->delete('/{subtask_id}', function ($request, $response, $args) {
            $result = $this->subtask->deleteSubtaskBySubTaskId($args['subtask_id']);
            return $response->withJson($result, 200, JSON_PRETTY_PRINT);
        });
    });
});

