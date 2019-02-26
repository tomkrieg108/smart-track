<?php require APPROOT . '/views/include/header.php' ?>
<!-- <?php flash('goal_message');?> -->
<div class="row">
  <div class="col">
    <h3> <?php echo ($data['type'] == 'open' ? "Open Tasks" : "Completed Tasks"); ?></h3>
  </div>
  <div class="col">
    <!-- <a href="<?php echo URLROOT . '/goals/add'  ?>" class="btn btn-primary float-right"> <i class="fas fa-pencil-alt"></i>New Task</a> -->
    <!-- <a href="#" class="btn btn-primary float-right" data-toggle="modal" data-target="#addModal"><i class="fas fa-pencil-alt"></i> New Goal</a> -->
  </div>
</div>
<hr class="my-2 border">

<?php foreach($data['tasks'] as $task ) : ?>
  <div class="row bg-light border p-4 my-4">

    <div class="col-lg-7">
      <div class="pb-2">
        <p class="d-inline-block my-0 mr-3"><?php echo "Task ID: #" . $task->task_id; ?></p>
      </div>
      <p><?php echo $task->body;  ?></p>
      <div class="pt-2">
        Linked Goal:
        <a href="<?php echo URLROOT . '/goals/show/' . $task->goal_id; ?>"><?php echo $task->goal_title; ?></a>
      </div>
    </div>

    <div class="col-lg-5 text-lg-right">
      <?php if(!isset($task->completed_on)) : ?>
        <p class="my-1">Status: On-going</p>
      <?php else: ?>
        <p class="mb-1">Status: Done!</p>
      <?php endif; ?> 
    </div>

  </div>
<?php endforeach;?>

<?php require APPROOT . '/views/include/footer.php' ?>
