<?php require APPROOT . '/views/include/header.php' ?>
<?php flash('goal_message');?>
<div class="row">
  <div class="col">
    <h3 class="d-inline-block my-0 mr-3"> <?php echo ($data['type'] == 'open' ? "Goals In Progress" : "Goals Completed"); ?></h3>
    <button class="actions__btn actions__btn--add" data-toggle="modal" data-target="#addModal">
        <ion-icon name="add" size="large"></ion-icon>
    </button>
  </div>
</div>
<hr class="my-4 border">

<?php foreach($data['goals'] as $goal ) : ?>
  <?php $goal = new CGoal($goal)  ?>

  <div class="bg-light border p-3 mb-4">
    
    <!-- start heading row -->
    <div class="row border-bottom pb-2 ">
        <div class="col-lg-8">
          <h5 class="d-inline-block my-0 mr-3"><?php echo $goal->title;  ?></h5>
          <a href="<?php echo URLROOT . '/goals/show/' . $goal->goal_id; ?>" class="actions__btn actions__btn--edit">
          <ion-icon name="share-alt"></ion-icon>
          </a>
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

        <!-- start col for description -->
        <div class="col-lg-8">
          <p><?php echo $goal->shortBody(180);  ?></p>
        </div>
        <!-- end col for description -->
    
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

          <!-- progress -->
          <div>
            <p class= "d-inline-block">Progress: <?php echo $goal->getProgressVal(); ?></p>
          </div>
          <!-- end progress -->
      </div>
      <!--end col for status info  -->
    </div>
    <!-- end row for spec and status -->
  </div>
<?php endforeach;?>

<?php require APPROOT . '/views/include/footer.php' ?>

<!-- add modal -->
<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Add New Goal</h5>
          <button class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="<?php echo URLROOT . '/goals/add' ; ?>" method="post">

            <div class="form-group">
              <label for="title">Title <sup>*</sup></label>
              <input type="text" name="title" class="form-control <?php echo (($data['error']->title != '') ? 'is-invalid' : '');  ?>" value= "<?php echo $data['goal']->title ?>" >
              <span class="invalid-feedback"><?php echo $data['error']->title; ?></span>
            </div>

            <div class="form-group">
              <label for="body">Description <sup>*</sup></label>
              <textarea name="body" rows="8" class="form-control <?php echo (($data['error']->body != '') ? 'is-invalid' : '');  ?>"><?php echo $data['goal']->body ?></textarea>
              <span class="invalid-feedback"><?php echo $data['error']->body; ?></span>
            </div>
            
            <div class="form-group">
              <label for="due">Due Date for Completion <sup>*</sup></label>
              <input type="date" name="due" class="form-control <?php echo (($data['error']->due_on != '') ? 'is-invalid' : '');  ?>" value= "<?php echo $data['goal']->due_on ?>" >
              <span class="invalid-feedback"><?php echo $data['error']->due_on; ?></span>
            </div>

            <input type="submit" value="Add Goal" class="btn btn-primary">
          </form>
        </div>
      </div>
    </div>
  </div>

  <?php
    if(isset($data['error'])) {
      if($data['error']->add_err) {
        echo "<script>$('#addModal').modal('show'); </script>";
      }
    }
  ?>