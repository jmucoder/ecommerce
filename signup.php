<?php include 'includes/session.php'; ?>
<?php
  if(isset($_SESSION['user'])){
    header('location: cart_view.php');
  }
?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition register-page">
<div class="register-box">
  	<?php
      if(isset($_SESSION['error'])){
        echo "
          <div class='callout callout-danger text-center'>
            <p>".$_SESSION['error']."</p> 
          </div>
        ";
        unset($_SESSION['error']);
      }

      if(isset($_SESSION['success'])){
        echo "
          <div class='callout callout-success text-center'>
            <p>".$_SESSION['success']."</p> 
          </div>
        ";
        unset($_SESSION['success']);
      }
    ?>
  	<div class="register-box-body">
    	<p class="login-box-msg">Registro</p>

    	<form action="register.php" method="POST">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" name="firstname" placeholder="Nombre" value="<?php echo (isset($_SESSION['firstname'])) ? $_SESSION['firstname'] : '' ?>" required>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="text" class="form-control" name="lastname" placeholder="Apellido" value="<?php echo (isset($_SESSION['lastname'])) ? $_SESSION['lastname'] : '' ?>"  required>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
      		<div class="form-group has-feedback">
        		<input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo (isset($_SESSION['email'])) ? $_SESSION['email'] : '' ?>" required>
        		<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      		</div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" name="password" placeholder="Contraseña" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" name="repassword" placeholder="Repite Contraseña" required>
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
          </div>
          
          <hr>
      		<div class="row">
            <div class="col-xs-4 col-xs-offset-4" style="text-align: center;">
                <button type="submit" class="btn btn-primary" name="signup"><i class="fa fa-pencil"></i> Registarse </button>
            </div>
          </div>

    	</form>
      <br>
      <div class="row">
        <div class="col-lg-6 col-lg-offset-3" style="text-align: center;">
          <a href="login.php">Ya tengo una cuenta</a><br><br>   
        </div>
      
        <div class="col-xs-4 col-xs-offset-4" style="text-align: center;">
          <a href="index.php"><i class="fa fa-home"></i> Inicio</a>
        </div>
      </div>
  	</div>
</div>
	
<?php  include 'includes/scripts.php' ?>
</body>
</html>
