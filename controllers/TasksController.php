<?php
require_once '../models/Task.php';
require_once '../config/database.php';

class TasksController {
    private $db;
    private $task;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->task = new Task($this->db);
    }

    public function index() {
        $stmt = $this->task->read();
        include '../views/tasks/index.php';
    }

    public function create() {
        if ($_POST) {
            $this->task->title = $_POST['title'];
            $this->task->description = $_POST['description'];
            
            if ($this->task->create()) {
                header("Location: /tasks");
            }
        }
        include '../views/tasks/create.php';
    }

    public function edit() {
        $this->task->id = $_GET['id'];
        $this->task->readOne();
        
        if ($_POST) {
            $this->task->title = $_POST['title'];
            $this->task->description = $_POST['description'];
            
            if ($this->task->update()) {
                header("Location: /tasks");
            }
        }
        include '../views/tasks/edit.php';
    }

    public function delete() {
        $this->task->id = $_GET['id'];
        if ($this->task->delete()) {
            header("Location: /tasks");
        }
    }
}
?>