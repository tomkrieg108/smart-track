<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-5">
  <div class="container">
    <a class="navbar-brand" href=" <?php echo URLROOT . '/pages/index'  ?> ">SMARTrack</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT . '/pages/index'  ?>">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT . '/pages/about'  ?>">About</a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <?php if(!isLoggedIn()) : ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo URLROOT . '/users/register'?>">Register</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo URLROOT . '/users/login'?>">Login</a>
          </li>
        <?php else : ?>
          <li class="nav-item">
              <a class="nav-link" href="<?php echo URLROOT . '/goals/completed'?>">Completed</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php echo "Welcome " . $_SESSION['user_name']?>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="<?php echo URLROOT . '/users/logout'?>">Logout</a>
              <!-- <a class="dropdown-item" href="#">Another action</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Something else here</a> -->
            </div>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo URLROOT . '/users/logout'?>">Logout</a>
            </li>
          </li>
        <?php endif; ?>
      </ul>
        <!-- <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form> -->
    </div>
  </div>
</nav>