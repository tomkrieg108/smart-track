<?php

class Tasks extends Controller {

  public function __construct() {
    if(!isLoggedIn()) {
      redirect('pages/index');
    }
    $this->taskModel = $this->model('Task');
    $this->goalModel = $this->model('Goal');
  }

  public function index($type) {
    $user_id = $_SESSION['user_id'];

    if($type == 'open') {
      $tasks = $this->taskModel->getTasksByUserID($user_id);
    } else {
      $tasks = $this->taskModel->getCompletedTasksByUserID($user_id);
    }
    
    foreach($tasks as $task) {
      $goal = $this->goalModel->getGoalById($task->goal_id);
      $task->goal_title = $goal->title;
    }
    $data = [
      'tasks' => $tasks,
      'type' => $type
    ];
    $this->view('tasks/index',$data);
  }

  public function add($goal_id) {
    // $goal_id is the goal that the new task belongs to
    if( $_SERVER['REQUEST_METHOD'] == POST) {

      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $task = (object) [
        'body' => trim($_POST['body']),
        'goal_id' => $goal_id
      ];

      $errors = (object) [
        'body' => '',
        'add_err' => false
      ];

      $data = [
        'task' => $task,
        'error' => $errors
      ];

      if(empty($task->body)) {
        $errors->body = 'Please enter a description.';
      } 
      
      if(empty($errors->body)) {
        if($this->taskModel->addTask($task)) {
          flash('goal_message', 'New task Added');
          redirect('goals/show/' . $goal_id);
        } else {
          die('Something went wrong');
        }
      } else  {
        //Reload the form with errors
        $errors->add_err = true;
        $this->view('goals/show', $data);
      }
    } else {  
      //form loaded
      $data = [
        'task' => (object) [
          'body' => ''
        ],
        'error' => $errors
      ];
      //Load the form
       $this->view('goals/add', $data);
    }
  }

  public function edit($goal_id, $task_id) {

    if( $_SERVER['REQUEST_METHOD'] == POST) {

      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      
      $task = (object) [
        'body' => trim($_POST['body']),
        'goal_id' => $goal_id,
        'task_id' => $task_id
      ];

      $errors = (object) [
        'body' => '',
        'edit_err' => false
      ];

      $data = [
        'task' => $task,
        'error' => $errors
      ];

      if(empty($task->body)) {
        $errors->body = 'Please enter a description.';
      } 
     
      if(empty($errors->body))  {
        if($this->taskModel->editTask($task)) {
          flash('goal_message', 'Task has been modified');
          redirect('goals/show/' . $goal_id);
        } else {
          die('Something went wrong');
        }
      } else  {
        //Load the form with errors
        $errors->edit_err = true;
        $this->view('goals/show', $data);
      }
    } 
  }

  public function delete($goal_id, $task_id) {
    if( $_SERVER['REQUEST_METHOD'] == POST) {

      $task = $this->taskModel->getTaskById($task_id);
      // if( $_SESSION['user_id'] != $goal->user_id ) {
      //   redirect('goals/index');
      // }

      if($this->taskModel->deleteTask($task_id)) {
        flash('goal_message', 'Task has been deleted');
        redirect('goals/show/' . $goal_id);
      } else {
        die('Something went wrong');
      }
    } else {
      redirect('goals/index/open');
    }
  }

  public function complete($goal_id, $task_id) {
    if( $_SERVER['REQUEST_METHOD'] == POST) {

      $task = $this->taskModel->getTaskById($task_id);
      // if( $_SESSION['user_id'] != $goal->user_id ) {
      //   redirect('goals/index');
      // }

      $now = new DateTime();
      $now->setTimezone(new DateTimeZone('Asia/Bangkok'));
      $date = $now->format('Y-m-d'); // $now->format('Y-m-d H:i:s'); 
      if($this->taskModel->completeTask($task_id,$date)) {
        flash('goal_message', 'Task has been completed');
        redirect('goals/show/' . $goal_id);
      } else {
        die('Something went wrong');
      }
    } else {
      redirect('goals/index/open');
    }
  }

  public function reopen($goal_id, $task_id) {
    if( $_SERVER['REQUEST_METHOD'] == POST) {

      $task = $this->taskModel->getTaskById($task_id);
      // if( $_SESSION['user_id'] != $goal->user_id ) {
      //   redirect('goals/index');
      // }
      if($this->taskModel->reopenTask($task_id)) {
        flash('goal_message', 'Task has been reopened');
        redirect('goals/show/' . $goal_id);
      } else {
        die('Something went wrong');
      }
    } else {
      redirect('goals/index/open');
    }
  }

}

?>