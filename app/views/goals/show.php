
<?php require APPROOT . '/views/include/header.php' ?>
  <?php $goal = new CGoal($data['goal'])  ?>

  <!-- <a href="<?php echo URLROOT . (!isset($goal->completed_on) ? '/goals/index' : '/goals/completed'); ?>" class="btn btn-light mb-2"> <i class="fa fa-backward"></i>  Back</a> -->
  <?php flash('goal_message');?>
  <div class="bg-light border px-3">
  
    <!-- start heading row -->
    <div class="row border-bottom py-3 ">
      <div class="col-lg-8">
        <h4 class="d-inline-block my-0 mr-3"><?php echo $goal->title;  ?></h4>

        <?php if(isset($goal->completed_on)) :  ?>
          <!-- Goal is closed - show re-open and delete buttons -->
          <button class="actions__btn actions__btn--edit"  data-toggle="modal" data-target="#modal-reopen" data-type="goal" >
          <ion-icon name="color-wand"></ion-icon>
          </button>
          <!-- Will also want to delete all comments and tasks for this goal too -->
          <button class="actions__btn actions__btn--delete"  data-toggle="modal" data-target="#modal-delete" data-type="goal" >
          <ion-icon name="ios-close"></ion-icon>
          </button>
        <?php else :  ?>
          <!-- Goal is open - show the complete and update buttons -->
          <!-- set or check that all tasks have been marked complete too ? -->
          <button class="actions__btn actions__btn--complete" data-toggle="modal"   data-target="#modal-complete" data-type="goal">
            <ion-icon name="ios-checkmark-circle-outline"></ion-icon>
          </button>
          <button class="actions__btn actions__btn--edit" data-toggle="modal" data-target="#modal-goal">
            <ion-icon name="md-create"></ion-icon>
          </button>
        <?php endif;  ?>
      </div>
      <div class="col-lg-4 text-lg-right">
        <span class="align-middle small">
          <?php echo '#' . $goal->goal_id;  ?>
          <?php echo ' - Created: ' . $goal->created_on;  ?>
        </span>
      </div>
    </div>
    <!-- end heading row -->

    <!-- start row for spec and status -->
    <div class="row pt-3">

      <!-- start col for description and metrics -->
      <div class="col-lg-8">
        <h6>Description</h6>
        <p><?php echo $goal->body;  ?></p>
      </div>
      <!-- end col for description and metrics -->
        
      <!--start col for status info  -->
      <div class="col-lg-4 text-lg-right">
        <?php if(!isset($goal->completed_on)) : ?>
          <p class="mb-1">Status: Open</p>
          <p class="mb-1">Due: <?php echo $goal->due_on ?>
            <span class="<?php echo $goal->getDueClass();?>">
              <?php echo $goal->daysUntilDue(); ?>
            </span>
          </p>
        <?php else: ?>
          <p class="mb-1">Status: Closed</p>
          <p class="mb-1">Completed: <?php echo $goal->completed_on ?>
            <span>
              <?php echo $goal->daysSinceCompleted(); ?>
            </span>
          </p>
        <?php endif; ?> 

        <!-- progress bar -->
        <div class="my-3">
          <h6 class= "d-inline-block mr-3">Progress</h6>
          <?php if(!isset($goal->completed_on)) : ?>
            <button class="actions__btn actions__btn--edit" data-toggle="modal" data-target="#modal-progress">
            <ion-icon name="md-create"></ion-icon>
            </button>
          <?php endif; ?> 
          <div class="progress mb-3">
          <div class="<?php echo 'progress-bar ' . $goal->getProgressClass() ?>" style="<?php echo $goal->getProgressStyle() ?>"><?php echo $goal->getProgressVal() ?></div>
          </div>
          
        </div>
        <!-- end progress bar -->
      
      </div>
       <!--end col for status info  -->
    </div>
    <!-- end row for spec and status -->
    <hr>

    <div class="mb-2">
      <h6 class= "d-inline-block my-0 mr-3">Task List</h6>
      <?php if(!isset($goal->completed_on)) :  ?>
        <button class="actions__btn actions__btn--add" data-toggle="modal" data-target="#modal-task">
          <ion-icon name="add"></ion-icon>
        </button>
      <?php endif; ?>
    </div>
    
    <?php foreach($data['tasks'] as $task ) : ?>

      <!-- start row for task -->
      <div class="row pl-3 mb-3 ">
        <!-- start col for task info -->
        <div class="col-lg-7 py-2 bg-white rounded">
            <div class="pb-2">
              <p class="d-inline-block my-0 mr-3"><?php echo "Task ID: #" . $task->task_id; ?></p>
              <?php if(!isset($goal->completed_on)) :  ?>
                <?php if(!isset($task->completed_on)) :  ?>
                  <!-- task is open - show complete button -->
                  <button class="actions__btn actions__btn--complete" data-toggle="modal" data-target="#modal-complete" data-type="task" data-id="<?php echo $task->task_id;?>">
                  <ion-icon name="ios-checkmark-circle-outline"></ion-icon>
                  </button>
                <?php else : ?>
                  <!-- task is closed - show re-open and buttons -->
                   <button class="actions__btn actions__btn--edit"  data-toggle="modal" data-target="#modal-reopen" data-type="task" data-id="<?php echo $task->task_id;?>" >
                  <ion-icon name="color-wand"></ion-icon>
                  </button>
                <?php endif; ?>
                <button class="actions__btn actions__btn--edit" data-toggle="modal" data-target="#modal-task" data-id="<?php echo $task->task_id;?>" data-body="<?php echo $task->body;?>">
                <ion-icon name="md-create"></ion-icon>
                </button>
                <button class="actions__btn actions__btn--delete"  data-toggle="modal" data-target="#modal-delete" data-type="task" data-id="<?php echo $task->task_id;?>" >
                <ion-icon name="ios-close"></ion-icon>
                </button>
              <?php endif; ?>
            </div>
            <p><?php echo $task->body; ?></p>
        </div>
        <!-- end col for task info -->

        <!-- start col for task status -->
        <div class="col-lg-3 bg-white rounded text-lg-right">
            <?php if(!isset($task->completed_on)) : ?>
              <p class="my-1">Status: On-going</p>
            <?php else: ?>
              <p class="mb-1">Status: Done!</p>
            <?php endif; ?> 
        </div>
        <!-- end col for task status -->
      </div>
      <!-- end row for task -->
    <?php endforeach;?>
    <hr>

    <div class="mb-2">
      <h6 class= "d-inline-block my-0 mr-3">Comments</h6>
      <?php if(!isset($goal->completed_on)) :  ?>
        <button class="actions__btn actions__btn--add" data-toggle="modal" data-target="#modal-comment">
            <ion-icon name="add"></ion-icon>
        </button>
      <?php endif; ?>
    </div>
    
    <?php foreach($data['comments'] as $comment ) : ?>
       <!-- start row for comment -->
      <div class="row pl-3 mb-3">
        <!-- start col for comment -->
        <div class="col-lg-10 py-2 bg-white rounded">
          <div class="pb-2">
          <p class="d-inline-block my-0 mr-3"><?php echo "#" . $comment->comment_id . " " . $comment->created_on; ?></p>
            <?php if(!isset($goal->completed_on)) :  ?>
              <button class="actions__btn actions__btn--edit" data-toggle="modal" data-target="#modal-comment" data-id="<?php echo $comment->comment_id;?>" data-body="<?php echo $comment->body;?>">
                <ion-icon name="md-create"></ion-icon>
              </button>
              <button class="actions__btn actions__btn--delete" data-toggle="modal" data-target="#modal-delete" data-type="comment" data-id="<?php echo $comment->comment_id;?>" >
                <ion-icon name="ios-close"></ion-icon>
              </button>
            <?php endif; ?>
          </div>
          <p><?php echo $comment->body; ?></p>
        </div>
        <!-- end col for comment -->
      </div>
      <!-- end row for comment -->
    <?php endforeach;?>
    
  </div>
<?php require APPROOT . '/views/include/footer.php' ?>

  <!-- Create / Edit comment modal -->
  <div class="modal fade" id="modal-comment">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h6 class="modal-title">Edit Comment</h6>
          <button class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="post">
            <div class="form-group">
              <label for="comment">Comment</label>
              <textarea class="form-control" rows="5" name="comment"></textarea>
            </div>
            <input type="submit" value="Save Changes" class="btn btn-primary">
          </form>
        </div>
      </div>
    </div>
  </div>

    <!-- Create / Edit task modal -->
    <div class="modal fade" id="modal-task">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h6 class="modal-title">Edit Task</h6>
          <button class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="post">
            <div class="form-group">
              <label for="body">Description</label>
              <textarea class="form-control" rows="5" name="body"></textarea>
            </div>
            <input type="submit" value="Save Changes" class="btn btn-primary">
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- edit goal modal -->
  <div class="modal fade" id="modal-goal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Edit Goal</h5>
          <button class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="<?php echo URLROOT . '/goals/edit/' . $goal->goal_id; ?>" method="post">
            <div class="form-group">
              <label for="title">Title <sup>*</sup></label>
              <input type="text" name="title" class="form-control <?php echo (($data['error']->title != '') ? 'is-invalid' : '');  ?>" value= "<?php echo $goal->title ?>" >
              <span class="invalid-feedback"><?php echo $data['error']->title; ?></span>
            </div>
            <div class="form-group">
              <label for="body">Description <sup>*</sup></label>
              <textarea name="body" rows="8" class="form-control <?php echo (($data['error']->body != '') ? 'is-invalid' : '');  ?>"><?php echo $goal->body ?></textarea>
              <span class="invalid-feedback"><?php echo $data['error']->body; ?></span>
            </div>
            <div class="form-group">
              <label for="due">Due Date for Completion <sup>*</sup></label>
              <input type="date" name="due" class="form-control <?php echo (($data['error']->due_on != '') ? 'is-invalid' : '');  ?>" value= "<?php echo $goal->due_on ?>" >
              <span class="invalid-feedback"><?php echo $data['error']->due_on; ?></span>
            </div>
            <input type="submit" value="Save Changes" class="btn btn-primary">
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Update progress modal -->
  <div class="modal fade" id="modal-progress">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Update Progress</h5>
          <button class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="<?php echo URLROOT . '/goals/update/' . $goal->goal_id; ?>" method="post">
            <!-- <div class="form-group">
              <label for="progress">Progress</label>
              <input type="text" class="form-control" name="progress" value="<?php echo $goal->progress; ?>">
            </div> -->
            <div class="form-group">
                <label for="progress">Progress</label>
                <input class="custom-range" min="0" max="100" step="1" name="progress" value="<?php echo $goal->progress; ?>" type="range">
            </div>
            <!-- <div class="form-group">
              <label for="comments">Comments</label>
              <textarea class="form-control" rows="8" name="comments"><?php echo $data['goal']->comments; ?></textarea>
            </div> -->
            <input type="submit" value="Save Changes" class="btn btn-primary">
          </form>
        </div>
      </div>
    </div>
  </div>

   <!-- delete modal -->
   <div class="modal fade" id="modal-delete">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title">Delete</h5>
          <button class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body m-4">
          <p>Click on 'Confirm' to delete this item.</p>
          <form action="" method="post">
            <input type="submit" value="Confirm" class="btn btn-danger">
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- complete modal -->
  <div class="modal fade" id="modal-complete">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title">Mark Complete</h5>
          <button class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body m-4">
          <p>Click on 'Confirm' to mark this item as completed.</p>
          <form action="" method="post">
            <input type="submit" value="Confirm" class="btn btn-success">
          </form>
        </div>
      </div>
    </div>
  </div>

   <!-- reopen modal -->
   <div class="modal fade" id="modal-reopen">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title">Reopen</h5>
          <button class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body m-4">
          <p>Click on 'Confirm' to reopen this item.</p>
          <form action="" method="post">
            <input type="submit" value="Confirm" class="btn btn-success">
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>

    <?php if(isset($data['error'])  && ($data['error']->edit_err) ) : ?>
      $('#modal-goal').modal('show');
    <?php endif; ?> 

    //triggered when modal is about to be shown
    $('#modal-comment').on('show.bs.modal', function(e) {
     //get data attribute of the clicked element
      var commentID = $(e.relatedTarget).data('id');
      var commentBody = $(e.relatedTarget).data('body');
      var url = '';
      if(commentID === undefined) {
        // new comment
        $(e.currentTarget).find('.modal-title').text('Add Comment');
        $(e.currentTarget).find('textarea[name="comment"]').val('');
        $(e.currentTarget).find('form input').val('OK');
        url = "<?php echo URLROOT . '/comments/add/' . $goal->goal_id; ?>";
      } else {
        //edit comment
        $(e.currentTarget).find('.modal-title').text('Edit Comment');
        $(e.currentTarget).find('textarea[name="comment"]').val(commentBody);
        url = "<?php echo URLROOT . '/comments/edit/' . $goal->goal_id . '/'; ?>" + commentID; 
      }
      // console.log('ID: ', commentID);
      // console.log('body: ', commentBody);
       $(e.currentTarget).find('form').attr('action', url ); 
    });

    $('#modal-task').on('show.bs.modal', function(e) {
      var taskID = $(e.relatedTarget).data('id');
      var taskBody = $(e.relatedTarget).data('body');
      var url = '';
      if(taskID === undefined) {
        // new task
        $(e.currentTarget).find('.modal-title').text('Add Task');
        $(e.currentTarget).find('textarea[name="body"]').val('');
        $(e.currentTarget).find('form input').val('OK');
        url = "<?php echo URLROOT . '/tasks/add/' . $goal->goal_id; ?>";
      } else {
        //edit task
        $(e.currentTarget).find('.modal-title').text('Edit Task');
        $(e.currentTarget).find('textarea[name="body"]').val(taskBody);
        url = "<?php echo URLROOT . '/tasks/edit/' . $goal->goal_id . '/'; ?>" + taskID; 
      }
       $(e.currentTarget).find('form').attr('action', url ); 
    });

   $('#modal-delete').on('show.bs.modal', function(e) {
      var id = $(e.relatedTarget).data('id');
      var type = $(e.relatedTarget).data('type');
      var url = '';
      if(type == 'comment') {
        url = "<?php echo URLROOT . '/comments/delete/' . $goal->goal_id . '/'; ?>" + id;
      } else if (type == 'task') {
        url = "<?php echo URLROOT . '/tasks/delete/' . $goal->goal_id . '/'; ?>" + id;
      } else if (type == 'goal') {
        url = "<?php echo URLROOT . '/goals/delete/' . $goal->goal_id; ?>" 
      }
      if(url != '') {
        $(e.currentTarget).find('form').attr('action', url ); 
      }
    });

    $('#modal-complete').on('show.bs.modal', function(e) {
      var id = $(e.relatedTarget).data('id');
      var type = $(e.relatedTarget).data('type');
      var url = '';
      if(type == 'task') {
        url = "<?php echo URLROOT . '/tasks/complete/' . $goal->goal_id . '/'; ?>" + id;
      } else if (type == 'goal') {
        url = "<?php echo URLROOT . '/goals/complete/' . $goal->goal_id; ?>";
      }
      if(url != '') {
        $(e.currentTarget).find('form').attr('action', url ); 
      }
    });

     $('#modal-reopen').on('show.bs.modal', function(e) {
      var id = $(e.relatedTarget).data('id');
      var type = $(e.relatedTarget).data('type');
      var url = '';
      if(type == 'task') {
        url = "<?php echo URLROOT . '/tasks/reopen/' . $goal->goal_id . '/'; ?>" + id;
      } else if (type == 'goal') {
        url = "<?php echo URLROOT . '/goals/reopen/' . $goal->goal_id; ?>";
      }
      if(url != '') {
        $(e.currentTarget).find('form').attr('action', url ); 
      }
      // console.log('type: ', type);
      // console.log('id: ', id);
      // console.log('url: ', url);
    });

  </script>