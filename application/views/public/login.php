<?php
  Helper::init_abs_path(FCPATH);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon -->
    <link rel="icon" href="<?= base_url('assets/images/icons/fav.ico'); ?>" />

    <title><?= Helper::$APP_NAME; ?> | <?= $title; ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/css/adminlte/adminlte.min.css'); ?>">
    <!-- Login CSS -->
    <link rel="stylesheet" type="text/css" href="<?= base_url( Helper::file_version('assets/css/login.css') ); ?>">

  </head>
  <body>
    <div class="container-fluid">
      <div class="login-box">
        <form class="form" method="POST" action="<?php echo site_url('authentication/login'); ?>">
          <div class="mb-4 d-flex justify-content-center">
            <div class="align-self-center">
              <h1 class="mb-0"><?= Helper::$APP_NAME; ?></h1>
            </div>
          </div>
          <?php if($this->session->flashdata('message')): ?>
            <div class="mb-3 small p-2 rounded <?= $this->session->flashdata('class'); ?>">
              <?= $this->session->flashdata('message'); ?>
            </div>
          <?php endif; ?>
          <div class="form-group">
            <input type="text" name="username" class="form-control" autocomplete="off" required="" />
            <span class="label-input">Username</span>
          </div>
          <div class="form-group">
            <input type="password" name="password" class="form-control" autocomplete="off" required="" />
            <span class="label-input">Password</span>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-login btn-block">Login</button>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>
