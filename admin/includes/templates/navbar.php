  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="prof.php"><?php echo lang('admin home'); ?></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item ">
            <a class="nav-link" href="category.php"><?php echo lang('admin Categories'); ?><span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="item.php"><?php echo lang('Item'); ?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="member.php"><?php echo lang('Member'); ?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="comment.php"><?php echo lang('comment'); ?></a>
          </li>
        </ul>
        <ul class="navbar-nav mr-right">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php echo lang('Name'); ?>
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="member.php?do=Edit&userId=<?php echo $_SESSION['id']; ?>"><?php echo lang('Edit Profile'); ?></a>
              <a class="dropdown-item" href="../index.php">Visit Shop</a>
              <a class="dropdown-item" href="#"><?php echo lang('Setting'); ?></a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="logout.php"><?php echo lang('Logout'); ?></a>
            </ul>
          </li>
        </ul>
      </div>
    </div> 
  </nav>
