### PHP Techdegree Project 7 - Todo Api

# Todo Api

**Todo Api** 

The listings_test demonstrates my ability to use Slim 3 to create API endpoints for the application. 

Note: 

Teamtreehouse.com PHP Techdegree exceeding grade changes: adding the subtasks table with CRUD operation and exception handling.

## How to setup on local machine

git clone https://github.com/allan9595/Php_Todo_Api_Starter.git

Place the repo in a web server of your choice (XAMPP for Windows, MAMP for Mac)

Open a terminal under the folder and type in "composer install" 

Then "composer update"

Open postman and testing the follow endpoints.

#### This API is versioned, all routes should be prefixed with **/api/v1**

#### You should have the following routes:
* [GET] /api/v1/todos
* [POST] /api/v1/todos
* [GET] /api/v1/todos/{id}
* [PUT] /api/v1/todos/{id}
* [DELETE] /api/v1/todos/{id}

#### When the app first starts it will attempt to fetch all Todos in the system.  Handle the request and return all the Todos.
* Route [GET] /api/v1/todos

#### When a Todo is **created** and the save link is clicked, it will make a request to the server.  Handle the request by creating a Todo and setting the proper status code.
* Route [POST] /api/v1/todos

#### When a previously saved Todo is **updated** and the save link is clicked, it will make a request to the server. Handle the request by updating the existing Todo.
* Route [PUT] /api/v1/todos/{id}

#### When a previously saved Todo is **deleted** and the save link is clicked, it will make a request to the server.  Handle the deletion and return a "message" that the resource has been deleted along with the proper status code.
* [DELETE] /api/v1/todos/{id}


* [GET] /api/v1/todos/{task_id}/subtasks
* [POST] /api/v1/todos/{task_id}/subtasks
* [GET] /api/v1/todos/{task_id}/subtasks/{subtask_id}
* [PUT] /api/v1/todos/{task_id}/subtasks/{subtask_id}
* [DELETE] /api/v1/todos/{task_id}/subtasks/{subtask_id}

## License

   The MIT License

    Copyright (c) BOHAN ZHANG

    Permission is hereby granted, free of charge, to any person obtaining a copy
    of this software and associated documentation files (the "Software"), to deal
    in the Software without restriction, including without limitation the rights
    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the Software is
    furnished to do so, subject to the following conditions:

    The above copyright notice and this permission notice shall be included in
    all copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
    THE SOFTWARE.
