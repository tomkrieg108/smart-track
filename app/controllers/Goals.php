<?php

class Goals extends Controller {
  public function __construct() {
    if(!isLoggedIn()) {
      redirect('pages/index');
    }
    $this->goalModel = $this->model('Goal');
    $this->userModel = $this->model('User');  //not used!
  }

  public function index() {
    $user_id = $_SESSION['user_id'];
    $goals = $this->goalModel->getGoals($user_id);

    $data = [
      'goals' => $goals
    ];
    $this->view('goals/index',$data);
  }

  public function completed() {
    $data = [
      'goals' =>$this->goalModel->getCompletedGoals($_SESSION['user_id'])
    ];
    $this->view('goals/completed',$data);
  }

  public function add() {
    if( $_SERVER['REQUEST_METHOD'] == POST) {

      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $goal = (object) [
        'title' => trim($_POST['title']),
        'body' => trim($_POST['body']),
        'due_on' => trim($_POST['due']),
        'user_id' => $_SESSION['user_id']
      ];

      $errors = (object) [
        'title' => '',
        'body' => '',
        'due_on' => '',
        'add_err' => false
      ];

      $data = [
        'goal' => $goal,
        'error' => $errors
      ];

      if(empty($goal->title)) {
        $errors->title = 'Please enter the title';
      } elseif ($this->goalModel->findGoalByTitle($goal)) {
        $errors->title = 'This title is already being used.';
      }
      if(empty($goal->body)) {
        $errors->body = 'Please enter the description';
      } 
      if(empty($goal->due_on)) {
        $errors->due = 'Please enter the due date';
      } 

      if(empty($errors->title) && empty($errors->body) && empty($errors->due_on)) {
        if($this->goalModel->addGoal($goal)) {
          flash('goal_message', 'New goal Added');
          redirect('goals/index');
        } else {
          die('Something went wrong');
        }
      } else  {
        //Reload the form with errors
        $errors->add_err = true;
        //Need to also supply the full list in 
        $data['goals'] = $this->goalModel->getGoals($_SESSION['user_id']);
        $this->view('goals/index', $data);
      }
    } else {  
      //form loaded
      $data = [
        'goal' => (object) [
          'title' => '',
          'body' => '',
          'due_on' => ''
        ],
        'error' => $errors
      ];

      //Load the form
       $this->view('goals/add', $data);
    }
  }

  public function edit($goal_id) {
    // $goal = $this->goalModel->getGoalById($goal_id);

    if( $_SERVER['REQUEST_METHOD'] == POST) {

      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $goal = (object) [
        'goal_id' => $goal_id,
        'title' => trim($_POST['title']),
        'body' => trim($_POST['body']),
        'due_on' => trim($_POST['due']),
      ];

      $errors = (object) [
        'title' => '',
        'body' => '',
        'due_on' => '',
        'edit_err' => false
      ];

      $data = [
        'goal' => $goal,
        'error' => $errors
      ];

      if(empty($goal->title)) {
        $errors->title = 'Please enter the title';
      } 
      if(empty($goal->body)) {
        $errors->body = 'Please enter the description';
      } 
      if(empty($goal->due_on)) {
        $errors->due = 'Please enter the due date';
      } 

      if(empty($errors->title) && empty($errors->body) && empty($errors->due_on))  {
        if($this->goalModel->editGoal($goal)) {
          flash('goal_message', 'Goal has been modified');
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

  public function update($goal_id) {
    if( $_SERVER['REQUEST_METHOD'] == POST) {

      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $goal = (object) [
        'goal_id' => $goal_id,
        'progress' => trim($_POST['progress']),
        'comments' => trim($_POST['comments']),
      ];

      //Won't't be any errors for this atm
      $errors = (object) [
        'progress' => '',
        'bcommentsody' => '',
        'update_err' => false
      ];

      $data = [
        'goal' => $goal,
        'error' => $errors
      ];

      if(empty($goal->progress)) {
        $goal->progress = 0;
      } 
      if(empty($goal->comments)) {
        $goal->comments = '';
      } 
      
      if($this->goalModel->updateProgress($goal)) {
        flash('goal_message', 'Progress has been updated');
        redirect('goals/show/' . $goal_id);
      } else {
        die('Something went wrong');
      }
    } 
  }

  public function show($goal_id) {
    $goal = $this->goalModel->getGoalById($goal_id);

    $data = [
      'goal' => $goal,
    ];

    $this->view('goals/show', $data);
  }

  public function complete($goal_id) {
    if( $_SERVER['REQUEST_METHOD'] == POST) {

      $goal = $this->goalModel->getGoalById($goal_id);
      if( $_SESSION['user_id'] != $goal->user_id ) {
        redirect('goals/index');
      }

      $now = new DateTime();
      $now->setTimezone(new DateTimeZone('Asia/Bangkok'));
      $date = $now->format('Y-m-d'); // $now->format('Y-m-d H:i:s'); 
      if($this->goalModel->completeGoal($goal_id,$date)) {
        flash('goal_message', 'Goal has been completed');
        redirect('goals/completed');
      } else {
        die('Something went wrong');
      }
    } else {
      redirect('goals/index');
    }
  }

  public function delete($goal_id) {
    if( $_SERVER['REQUEST_METHOD'] == POST) {

      $goal = $this->goalModel->getGoalById($goal_id);
      if( $_SESSION['user_id'] != $goal->user_id ) {
        redirect('goals/index');
      }

      if($this->goalModel->deleteGoal($goal_id)) {
        flash('goal_message', 'Goal has been deleted');
        redirect('goals/index');
      } else {
        die('Something went wrong');
      }
    } else {
      redirect('goals/index');
    }
  }

}
