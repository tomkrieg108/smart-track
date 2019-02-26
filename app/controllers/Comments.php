<?php

class Comments extends Controller {

  public function __construct() {
    if(!isLoggedIn()) {
      redirect('pages/index');
    }
    $this->commentModel = $this->model('Comment');
  }

  public function add($goal_id) {
    // $goal_id is the goal that the new comment belongs to
    if( $_SERVER['REQUEST_METHOD'] == POST) {

      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $comment = (object) [
        'body' => trim($_POST['comment']),
        'goal_id' => $goal_id
      ];

      $errors = (object) [
        'body' => '',
        'add_err' => false
      ];

      $data = [
        'comment' => $comment,
        'error' => $errors
      ];

      if(empty($comment->body)) {
        $errors->body = 'Please enter a comment.';
      } 
      
      if(empty($errors->body)) {
        if($this->commentModel->addComment($comment)) {
          // flash('goal_message', 'New goal Added');
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
        'comment' => (object) [
          'body' => ''
        ],
        'error' => $errors
      ];
      //Load the form
       $this->view('goals/add', $data);
    }
  }

  public function edit($goal_id, $comment_id) {

    if( $_SERVER['REQUEST_METHOD'] == POST) {

      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      
      $comment = (object) [
        'body' => trim($_POST['comment']),
        'goal_id' => $goal_id,
        'comment_id' => $comment_id
      ];

      $errors = (object) [
        'body' => '',
        'edit_err' => false
      ];

      $data = [
        'comment' => $comment,
        'error' => $errors
      ];

      if(empty($comment->body)) {
        $errors->body = 'Please enter a comment.';
      } 
     
      if(empty($errors->body))  {
        if($this->commentModel->editComment($comment)) {
          // flash('goal_message', 'Goal has been modified');
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

  public function delete($goal_id, $comment_id) {
    if( $_SERVER['REQUEST_METHOD'] == POST) {

      $comment = $this->commentModel->getCommentById($comment_id);
      // if( $_SESSION['user_id'] != $goal->user_id ) {
      //   redirect('goals/index');
      // }

      if($this->commentModel->deleteComment($comment_id)) {
        // flash('goal_message', 'Goal has been deleted');
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