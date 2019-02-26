<?php require APPROOT . '/views/include/header.php' ?>
  <a href="<?php echo URLROOT . "/posts/index"; ?>" class="btn btn-light mb-2"> <i class="fa fa-backward"></i>  Back</a>
  <div class="card card-body bg-light border border-primary mt-5">
    <h2>Add New Goal</h2>
    <!-- <p>Fill in this form to add a post</p> -->
    <form action="<?php echo URLROOT; ?>/goals/add" method="post">
      <div class="form-group">
        <label for="title">Title <sup>*</sup></label>
        <input type="text" name="title" class="form-control <?php echo (($data['error']->title != '') ? 'is-invalid' : '');  ?>" value= "<?php echo $data['goal']->title ?>" >
        <span class="invalid-feedback"><?php echo $data['error']->title; ?></span>
      </div>
      <div class="form-group">
        <label for="body">Description <sup>*</sup></label>
        <textarea name="body" rows="6" class="form-control <?php echo (($data['error']->body != '') ? 'is-invalid' : '');  ?>"><?php echo $data['goal']->body ?></textarea>
        <span class="invalid-feedback"><?php echo $data['error']->body; ?></span>
      </div>
      <div class="form-group">
        <label for="due">Due Date for Completion <sup>*</sup></label>
        <input type="date" name="due" class="form-control <?php echo (($data['error']->due != '') ? 'is-invalid' : '');  ?>" value= "<?php echo $data['goal']->due ?>" >
        <span class="invalid-feedback"><?php echo $data['error']->due; ?></span>
      </div>
      <input type="submit" value="Add Goal" class="btn btn-primary">
    </form>
</div>
<?php require APPROOT . '/views/include/footer.php' ?>