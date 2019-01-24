<?php require APPROOT . '/views/include/header.php' ?>
<?php flash('goal_message');?>
<div class="row">
  <div class="col">
    <h2>Goals in progress</h2>
  </div>
  <div class="col">
    <!-- <a href="<?php echo URLROOT . '/goals/add'  ?>" class="btn btn-primary float-right"> <i class="fas fa-pencil-alt"></i> New Goal</a> -->
    <a href="#" class="btn btn-primary float-right" data-toggle="modal" data-target="#addModal"><i class="fas fa-pencil-alt"></i> New Goal</a>
  </div>
</div>
<hr class="my-2 border border-primary">
<?php foreach($data['goals'] as $goal ) : ?>
  <div class="bg-light border border-success p-4 my-4">
    <h4><?php echo $goal->title;  ?></h4>
    <div>
      <p class="lead"><?php echo $goal->body;  ?> Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto ducimus culpa incidunt ipsum. Nulla ducimus suscipit sapiente, consectetur numquam soluta iste praesentium temporibus illum atque, magni aspernatur! Autem, harum atque!</p>
    </div>
    <p>Due date: <?php echo $goal->due_on; ?> </p>
    <p>Percent complete: <?php echo $goal->progress; ?> </p>
    <a href="<?php echo URLROOT . '/goals/show/' . $goal->goal_id; ?>" class="btn btn-dark">Details</a>
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