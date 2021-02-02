<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Laptop Zone | Sign Up</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/AdminLTE.min.css')?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/iCheck/square/blue.css')?>">
  <!-- Custom Css -->
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/custom.css')?>"> 

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition register-page">

<div class="register-box">
  <div class="register-logo">
    <img class="lpz-logo" src="<?php echo base_url('assets/images/logo.png')?>" alt="Laptop Zone Logo"><br>
    <!-- <a href="#"><b>Laptop</b>Zone</a> -->
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">Register a new membership</p>

          <?php echo form_open('login/login/user_signup',['class'=>'form_horizontal']); ?>

              <div class="form-group form-group has-feedback">
              <?php echo form_input(['name'=>'fname','class'=>'form-control','placeholder'=>'First Name','value'=>set_value('firstname')]); ?>
              <span class="glyphicon glyphicon-user form-control-feedback"></span>
                <div class="alert error-msg">
                  <?php echo form_error('fname');?>
                </div>
              </div>
              <div class="form-group form-group has-feedback">
              <?php echo form_input(['name'=>'lname','class'=>'form-control','placeholder'=>'Last Name','value'=>set_value('lastname')]); ?>
              <span class="glyphicon glyphicon-user form-control-feedback"></span>
                <div class="alert error-msg">
                  <?php echo form_error('lname');?>
                </div>
              </div>
              <div class="form-group form-group has-feedback">
              <?php echo form_input(['name'=>'email','class'=>'form-control','placeholder'=>'Email','value'=>set_value('email')]); ?>
              <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                <div class="alert error-msg">
                  <?php echo form_error('email');?>
                </div>                
              </div>
              <div class="form-group form-group has-feedback">
              <?php echo form_input(['name'=>'uname','class'=>'form-control','placeholder'=>'User Name','value'=>set_value('uname')]); ?>
              <span class="glyphicon glyphicon-user form-control-feedback"></span>
                <div class="alert error-msg">
                  <?php echo form_error('uname');?>
                </div>                
              </div>
              <div class="form-group form-group has-feedback">
                <?php echo form_password(['name'=>'password','class'=>'form-control','placeholder'=>'Password']); ?>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                <div class="alert error-msg">
                  <?php echo form_error('password');?>
                </div>                
              </div>
              <div class="form-group form-group has-feedback">
                <?php echo form_password(['name'=>'confirm_password','class'=>'form-control','placeholder'=>'Confirm Password']); ?>
                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                <div class="alert error-msg">
                  <?php echo form_error('confirm_password');?>
                </div>               
              </div>

              <div class="row">
                <div class="col-xs-8">
                  <div class="checkbox icheck">
                    <!-- <label>
                      <input type="checkbox"> I agree to the <a href="#">terms</a>
                    </label> -->
                  </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                <?php echo form_submit(['name'=>'submit','value'=>'Register','class'=>'btn btn-primary btn-block btn-flat']); ?>                  
                </div>
                <!-- /.col -->
              </div>              

          </form>
              <a href="<?php echo base_url();?>login/login/" class="text-center">I already have a membership</a>
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->


<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url('assets/plugins/jQuery/jquery-2.2.3.min.js');?>"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js');?>"></script>
<!-- iCheck -->
<script src="<?php echo base_url('assets/plugins/iCheck/icheck.min.js');?>"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>