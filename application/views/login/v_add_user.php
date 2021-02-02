<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Laptop Zone | Add User</title>
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
          
           <?php if($this->session->flashdata('success')){ ?>
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php }else if($this->session->flashdata('error')){  ?>
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php }else if($this->session->flashdata('warning')){  ?>
                <div class="alert alert-warning">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>Error!</strong> <?php echo $this->session->flashdata('warning'); ?>
                </div>
            <?php }else if($this->session->flashdata('compo')){  ?>
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>Error!</strong> <?php echo $this->session->flashdata('compo'); ?>
                </div>
            <?php } ?>
          <!-- <?php //echo form_open('login/c_addUser/addUser',['class'=>'form_horizontal']); ?> -->

          <form action="<?php echo base_url('login/c_users/addUser'); ?>" method="post" accept-charset="utf-8" class="form_horizontal">
            <fieldset>
              <div class="form-group has-feedback">
                  <input type="text" name="first_name" class="form-control" placeholder="First Name" required="required" value="<?php if(isset($_POST['first_name'])){ echo $_POST['first_name']; }?>" >
                  <span class="glyphicon glyphicon-user form-control-feedback"></span>                    
              </div>
              <div class="form-group has-feedback">
                  <input type="text" name="last_name" class="form-control" placeholder="Last Name" value="<?php if(isset($_POST['last_name'])){ echo $_POST['last_name']; }?>" required="required">
                  <span class="glyphicon glyphicon-user form-control-feedback"></span>                    
              </div>
               <div class="form-group has-feedback">
                  <input type="text" name="user_name" class="form-control" placeholder="User Name" value="<?php if(isset($_POST['user_name'])){ echo $_POST['user_name']; }?>" required="required">
                  <span class="glyphicon glyphicon-user form-control-feedback"></span>                    
              </div>
              <div class="form-group has-feedback">
                  <input type="password" name="user_password" class="form-control" placeholder="Password" value="<?php if(isset($_POST['user_password'])){ echo $_POST['user_password']; }?>"required="required">
                  <span class="glyphicon glyphicon-lock form-control-feedback"></span>
              </div>
             <!--  <div class="form-group has-feedback">
                 <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required="required">
                 <span class="glyphicon glyphicon-lock form-control-feedback"></span>
             </div> -->
             
               <div class="form-group has-feedback">
                <select id="user_location" class="form-control" name="user_location" placeholder="Location" value="<?php if(isset($_POST['user_location'])){ echo $_POST['user_location']; }?>" required>
                  <option value="">Select User Location</option>
                  <option value="US">US</option>
                  <option value="PK">PK</option>
                </select>
              </div>
              <div class="form-group has-feedback">
               
                <select id="merchant" class="form-control" name="merchant" placeholder="merchant" required>
                  <option value="0">Select Merchant</option>
                  <?php foreach ($merchant as $value) { ?>
                    <option value="<?php echo $value['MERCHANT_ID'] ;?>" ><?php echo $value['BUISNESS_NAME'] ;?></option>
                  <?php } ?>
                  
                  
                </select>
              </div>
              <div class="form-group has-feedback">
                  <input type="email" name="user_email" class="form-control" placeholder="User Email" value="<?php if(isset($_POST['user_email'])){ echo $_POST['user_email']; }?>" required="required">
                  <span class="glyphicon glyphicon-user form-control-feedback"></span>                    
              </div>
              <div class="row">
                <!-- /.col -->
                <div class="col-xs-4">
                  <?php echo form_submit(['name'=>'add_user','value'=>'Add User','class'=>'btn btn-primary btn-block btn-flat']); ?> 
                </div>
                <!-- /.col -->
              </div>
            </fieldset>
          </form><br>
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
</body>
</html>