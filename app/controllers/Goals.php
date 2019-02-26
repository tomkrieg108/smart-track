<?php

class Goals extends Controller {
  public function __construct() {
    if(!isLoggedIn()) {
      redirect('pages/index');
    }
    $this->goalModel = $this->model('Goal');
    $this->taskModel = $this->model('Task');
    $this->commentModel = $this->model('Comment');
    $this->userModel = $this->model('User');  //not used!
  }

  public function index($type) {
    $user_id = $_SESSION['user_id'];
    if($type == 'open') {
      $goals = $this->goalModel->getGoals($user_id);
    } else {
      $goals = $this->goalModel->getCompletedGoals($user_id);
    }

    $data = [
      'goals' => $goals,
      'type' => $type
    ];
    $this->view('goals/index',$data);
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
          redirect('goals/index/open');
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
    //Get the goal object from the goal id
    $goal = $this->goalModel->getGoalById($goal_id);
    //Get array of task objects associated with this goal id
    $tasks = $this->taskModel->getTasks($goal_id);
    //Get array of comment objects associated with this goal id
    $comments = $this->commentModel->getComments($goal_id);

    $data = [
      'goal' => $goal,
      'tasks' => $tasks,
      'comments' => $comments,
    ];

    $this->view('goals/show', $data);
  }

  public function complete($goal_id) {
    if( $_SERVER['REQUEST_METHOD'] == POST) {

      $goal = $this->goalModel->getGoalById($goal_id);
      if( $_SESSION['user_id'] != $goal->user_id ) {
        redirect('goals/index/open');
      }

      $now = new DateTime();
      $now->setTimezone(new DateTimeZone('Asia/Bangkok'));
      $date = $now->format('Y-m-d'); // $now->format('Y-m-d H:i:s'); 
      if($this->goalModel->completeGoal($goal_id,$date)) {
        flash('goal_message', 'Goal has been completed');
        redirect('goals/show/' . $goal_id);
      } else {
        die('Something went wrong');
      }
    } else {
      redirect('goals/index/open');
    }
  }

  public function reopen($goal_id) {
    if( $_SERVER['REQUEST_METHOD'] == POST) {
      $goal = $this->goalModel->getGoalById($goal_id);
      if( $_SESSION['user_id'] != $goal->user_id ) {
        redirect('goals/index/open');
      } 
      if($this->goalModel->reopenGoal($goal_id)) {
        flash('goal_message', 'Goal has been re-opened');
        redirect('goals/show/' . $goal_id);
      } else {
        die('Something went wrong');
      }
    } else {
      redirect('goals/index/open');
    }
  }

  public function delete($goal_id) {
    if( $_SERVER['REQUEST_METHOD'] == POST) {

      $goal = $this->goalModel->getGoalById($goal_id);
      if( $_SESSION['user_id'] != $goal->user_id ) {
        redirect('goals/index/open');
      }

      if($this->goalModel->deleteGoal($goal_id)) {
        flash('goal_message', 'Goal has been deleted');
        redirect('goals/index/closed');
      } else {
        die('Something went wrong');
      }
    } else {
      redirect('goals/index/open');
    }
  }

}
