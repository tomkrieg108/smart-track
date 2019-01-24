<?php require APPROOT . '/views/include/header.php' ?>
  <?php flash('goal_message');?>
  <a href="<?php echo URLROOT . "/goals/index"; ?>" class="btn btn-light mb-2"> <i class="fa fa-backward"></i>  Back</a>
  <div class="bg-light border border-success p-4 my-4">
    <h4><?php echo $data['goal']->title;  ?></h4>
    <div>
      <p class="lead"><?php echo $data['goal']->body;  ?> Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam expedita sapiente ullam cumque minus, aut earum soluta ad amet ea beatae repudiandae excepturi reiciendis. Quisquam molestiae odit non animi recusandae!</p>
    </div>
    <p>Due date: <?php echo $data['goal']->due_on; ?> </p>
    <p>Percent complete: <?php echo $data['goal']->progress; ?> </p>
    <p>Comments: <?php echo $data['goal']->comments; ?> </p>

    <?php if(!isset($data['goal']->completed_on)) : ?>
      <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#updateProgressModal">Update Progress</a>
      <a href="#" class="btn btn-success" data-toggle="modal" data-target="#markCompleteModal">Mark as Complete</a>
      <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#editModal">Edit Goal</a>
      <a href="#" class="btn btn-danger"  data-toggle="modal" data-target="#deleteModal">Delete</a>
    <?php endif; ?> 
  </div>
<?php require APPROOT . '/views/include/footer.php' ?>

 <!-- Update progress modal -->
 <div class="modal fade" id="updateProgressModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Update Progress</h5>
          <button class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="<?php echo URLROOT . '/goals/update/' . $data['goal']->goal_id; ?>" method="post">
            <div class="form-group">
              <label for="progress">Progress</label>
              <input type="text" class="form-control" name="progress" value="<?php echo $data['goal']->progress; ?>">
            </div>
            <div class="form-group">
              <label for="comments">Comments</label>
              <textarea class="form-control" name="comments"><?php echo $data['goal']->comments; ?></textarea>
            </div>
            <input type="submit" value="Save Changes" class="btn btn-primary">
          </form>
        </div>
      </div>
    </div>
  </div>

<!-- edit modal -->
 <div class="modal fade" id="editModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-warning text-white">
          <h5 class="modal-title">Edit Goal</h5>
          <button class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="<?php echo URLROOT . '/goals/edit/' . $data['goal']->goal_id; ?>" method="post">

            <div class="form-group">
              <label for="title">Title <sup>*</sup></label>
              <input type="text" name="title" class="form-control form-control-lg <?php echo (($data['error']->title != '') ? 'is-invalid' : '');  ?>" value= "<?php echo $data['goal']->title ?>" >
              <span class="invalid-feedback"><?php echo $data['error']->title; ?></span>
            </div>

            <div class="form-group">
              <label for="body">Description <sup>*</sup></label>
              <textarea name="body" class="form-control form-control-lg <?php echo (($data['error']->body != '') ? 'is-invalid' : '');  ?>"><?php echo $data['goal']->body ?></textarea>
              <span class="invalid-feedback"><?php echo $data['error']->body; ?></span>
            </div>
            
            <div class="form-group">
              <label for="due">Due Date for Completion <sup>*</sup></label>
              <input type="date" name="due" class="form-control form-control-lg <?php echo (($data['error']->due_on != '') ? 'is-invalid' : '');  ?>" value= "<?php echo $data['goal']->due_on ?>" >
              <span class="invalid-feedback"><?php echo $data['error']->due_on; ?></span>
            </div>

            <input type="submit" value="Save Changes" class="btn btn-warning">
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- delete goal modal -->
 <div class="modal fade" id="deleteModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title">Delete Goal</h5>
          <button class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body m-4">
          <p>Clicking on 'Confirm Delete' below will permanently delete this goal.</p>
          <form action="<?php echo URLROOT . '/goals/delete/' . $data['goal']->goal_id; ?>" method="post">
            <input type="submit" value="Confirm Delete" class="btn btn-danger">
          </form>
        </div>
      </div>
    </div>
  </div>

   <!-- complete goal modal -->
 <div class="modal fade" id="markCompleteModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title">Mark Goal As Complete</h5>
          <button class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body m-4">
          <p>Clicking on 'Confirm Complete' below will move this goal from the 'goals pending list over into the completed list.</p>
          <form action="<?php echo URLROOT . '/goals/complete/' . $data['goal']->goal_id; ?>" method="post">
            <input type="submit" value="Confirm Complete" class="btn btn-success">
          </form>
        </div>
      </div>
    </div>
  </div>

  <?php
    if(isset($data['error'])) {
      if($data['error']->edit_err) {
        echo "<script>$('#editModal').modal('show'); </script>";
      }
    }
  ?>