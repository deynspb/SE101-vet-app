<?php require_once('../config.php') ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
 <?php require_once('inc/header-login.php') ?> 
<body class="hold-transition ">
  
  <style>
    html, body{
      height:100%;
      width:100%;
      margin: 0;
      padding: 0;
    }
    body{
      background-image: url("<?php echo validate_image($_settings->info('cover')) ?>");
      background-size:cover;
      background-repeat:no-repeat;
    }
    .login-title{
      text-shadow: 2px 2px black;
    }
    #login{
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }
    #logo-img{
        height:150px;
        width:150px;
        object-fit:scale-down;
        object-position:center center;
        border-radius:100%;
    }
    #login .col-7,#login .col-5{
      width: 100%;
      max-width:unset;
    }
  </style>
  <div id="login">
    <div class="col-7 d-flex justify-content-center align-items-center">
      <div>
        <center><img src="<?= validate_image($_settings->info('logo')) ?>" alt="" id="logo-img"></center>
        <h1 class="text-center py-5 login-title"><b><?php echo $_settings->info('name') ?>  </b></h1>
      </div>
      
    </div>
    <div class="col-5 bg-gradient">
      <div class="d-flex w-100 h-100 justify-content-center align-items-center">
        <div class="card col-sm-12 col-md-6 col-lg-3 card-outline card-primary rounded-0 shadow">
          <div class="card-header rounded-0">
            <h4 class="text-purle text-center"><b>Login</b></h4>
          </div>
          <div class="card-body rounded-0">
            <form id="login-frm" action="login-submit.php" method="post">
              <div class="input-group mb-3">
                <input type="text" class="form-control" autofocus name="username" placeholder="Username">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-user"></span>
                  </div>
                </div>
              </div>
              <div class="input-group mb-3">
    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
    <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
            <i class="fas fa-eye"></i>
        </button>
    </div>
</div>

              <div class="row">
    <div class="col-8">
        <a href="<?php echo base_url ?>">Go Back Home</a>
    </div>
    <!-- /.col -->
    <div class="col-4">
        <button type="submit" name="login" class="btn btn-primary btn-block btn-flat">Sign In</button>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <a href="../forgot-password/index.php">Forgot Password</a>
    </div>
</div>
<!-- <div class="row">
    <div class="col-12 text-center"> Add text-center class here -->
    <!-- <p class="mb-0">Don't have an account yet?</p> Insert the text here -->
        <!-- <a href="../create_acc.php">Create Account</a>
    </div>  -->
</div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>



  <script>
    document.getElementById("togglePassword").addEventListener("click", function () {
        var passwordField = document.getElementById("password");
        var buttonIcon = document.querySelector("#togglePassword i");

        if (passwordField.type === "password") {
            passwordField.type = "text";
            buttonIcon.classList.remove("fa-eye");
            buttonIcon.classList.add("fa-eye-slash");
        } else {
            passwordField.type = "password";
            buttonIcon.classList.remove("fa-eye-slash");
            buttonIcon.classList.add("fa-eye");
        }
    });
</script>




<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App
<script src="dist/js/adminlte.min.js"></script> -->


</body>
</html>
