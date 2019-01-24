<?php require APPROOT . '/views/include/header.php' ?>

<div class="row">
    <div class="col-md-6 mx-auto">
      <div class="card card-body bg-light mt-5">
        <h2>Create an account</h2>
        <!-- <p>Fill in this form to register</p> -->
        <form action="<?php echo URLROOT; ?>/users/register" method="post">
          <div class="form-group">
            <label for="name">Name <sup>*</sup></label>
            <input type="text" name="name" class="form-control form-control-lg <?php echo empty($data['err_name']) ? '' : 'is-invalid';  ?>" value= "<?php echo $data['name']; ?>" >
            <div class="invalid-feedback"><?php echo $data['err_name']; ?></div>
          </div>
          <div class="form-group">
            <label for="email">Email <sup>*</sup></label>
            <input type="email" name="email" class="form-control form-control-lg <?php echo (($data['err_email'] != '') ? 'is-invalid' : '');  ?>" value= "<?php echo $data['email']; ?>" >
            <span class="invalid-feedback"><?php echo $data['err_email']; ?></span>
          </div>
          <div class="form-group">
            <label for="password">Password <sup>*</sup></label>
            <input type="password" name="password" class="form-control form-control-lg <?php echo (($data['err_password'] != '') ? 'is-invalid' : '');  ?>" value= "<?php echo $data['password']; ?>" >
            <span class="invalid-feedback"><?php echo $data['err_password']; ?></span>
          </div>
          <div class="form-group">
            <label for="confirm_password">Confirm Password <sup>*</sup></label>
            <input type="password" name="confirm_password" class="form-control form-control-lg <?php echo (($data['err_confirm_password'] != '') ? 'is-invalid' : '');  ?>" value= "<?php echo $data['confirm_password']; ?>" >
            <span class="invalid-feedback"><?php echo $data['err_confirm_password']; ?></span>
          </div>
          <input type="submit" value="Register" class="btn btn-primary btn-block">
          <!-- <div class="row">
            <div class="col">
              <input type="submit" value="Register" class="btn btn-success btn-block">
            </div>
            <div class="col">
              <a href="<?php echo URLROOT . "/users/login"; ?>" class="btn btn-light btn-block">Login</a>
            </div>
          </div> -->
        </form>
      </div>
    </div>
  </div>

<?php require APPROOT . '/views/include/footer.php' ?>