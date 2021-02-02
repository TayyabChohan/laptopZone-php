<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Laptop Zone | Log in</title>
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
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <img class="lpz-logo" src="<?php echo base_url('assets/images/logo.png')?>" alt="Laptop Zone Logo"><br>
    <!-- <a href="#"><b>Laptop</b>Zone</a> -->
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
          <?php echo form_open('login/login/user_login',['class'=>'form_horizontal']); ?>
            <fieldset>
              <div class="form-group has-feedback">
              <?php echo form_input(['name'=>'uname','class'=>'form-control','placeholder'=>'User Name','value'=>set_value('uname')]); ?>
                  <span class="glyphicon glyphicon-user form-control-feedback"></span>
                  <?php $login_error = $this->session->userdata('login_error'); ?>
                  <?php 
                  if($login_error)
                    { 
                      echo "<div class='alert error-msg'>Username is invalid.</div>";
                    }
                  ?>                
              </div>
              <div class="form-group has-feedback">
                <?php echo form_password(['name'=>'password','class'=>'form-control','placeholder'=>'Password']); ?>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                <?php $login_error = $this->session->userdata('login_error'); ?>
                  <?php 
                  if($login_error)
                    { 
                      echo "<div class='alert error-msg'>Password is invalid.</div>"; 
                      $this->session->unset_userdata('login_error');
                    }
                  ?>
                  <?php $redirect_url = $this->session->userdata('current_page'); ?>
                  <!-- <input type="text" name="redirect_url" value="<?php //if(!empty($redirect_url)){ echo $redirect_url; } ?>"> -->
                   <!-- <input type="text" name="cookie_url" value="<?php //if(!empty($cookie_url)){echo $cookie_url;}  ?>"> -->
              </div>
              <div class="form-group has-feedback">
                <select id="account_type" class="form-control" name="account_type" required>
                  <option value="">Select Account Type</option>
                  <option value="2" selected>Dfwonline</option>
                  <option value="1">Techbargains2015</option>
                </select>
                  <?php 
                  // $login_error = $this->session->userdata('login_error');
                  // if($login_error){ echo "<div class='alert error-msg'>Password is invalid.</div>";$this->session->unset_userdata('login_error');}
                  ?>
              </div>
              <div class="form-group has-feedback">
               
                <select id="merchant" class="form-control" name="merchant" placeholder="merchant" required>
                  <option value="0">Select Merchant</option>
                  <?php foreach ($merchant as $value) { 
                    if(strtoupper($value['CONTACT_PERSON']) == 'DFWONLINE') {
                      $selected = "selected='selected'";
                    }else{
                      $selected = "";
                    }
                    ?>
                    <option value="<?php echo $value['MERCHANT_ID'] ;?>" <?php echo $selected; ?>><?php echo $value['BUISNESS_NAME'] ;?></option>
                  <?php } ?>
                  
                  
                </select>
              </div>
              <div class="row">
                <div class="col-xs-8">
                  <div class="checkbox icheck">
                    <label>
                      <!-- <input type="checkbox"> Remember Me -->
                    </label>
                  </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">

                <?php echo form_submit(['name'=>'submit','value'=>'Sign In','class'=>'btn btn-primary btn-block btn-flat']); ?>                                    
                </div>
                <!-- /.col -->
              </div>
            </fieldset>
          </form>
    <!-- <div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
        Google+</a>
    </div> -->
    <!-- /.social-auth-links -->
    <!-- <a href="#">I forgot my password</a> --><br>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
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