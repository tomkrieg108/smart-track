<?php require APPROOT . '/views/include/header.php' ?>
<?php flash('goal_message');?>
<div class="row">
  <div class="col">
    <h2>Goals Completed</h2>
  </div>
  <div class="col">
    <a href="<?php echo URLROOT . '/goals/add'  ?>" class="btn btn-primary float-right"> <i class="fas fa-pencil-alt"></i> New Goal</a>
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