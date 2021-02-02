<?php $this->load->view('template/header'); 
ini_set('memory_limit', '-1'); // add for picture loading issue
?>
<!-- Content Wrapper. Contains page content -->
 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Categories</h1>
    <small>List View</small>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Categories List View</li>
    </ol>
  </section>

    <!-- Main content -->
  <section class="content"><!-- Direct Chat -->
    <div class="col-sm-12">
      <div class="box">
        <div class="box-body">
          <div class="col-md-3">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <h3 class="box-title"><a href="<?php echo base_url().'bigData/c_categoryTeeList/showDetail/220' ?>">Toys &amp; Hobbies (220)</a></h3>
              </div><!-- /.box-header -->
              <div class="box-body"><!-- Conversations are loaded here -->
              <?php if($data['toys']->num_rows() > 0){ ?>
                  <ul class="contacts-list">
                  <?php 
                    $i=0;
                    foreach($data['toys']->result_array() as $row){
                      if ($i <=4) { ?>
                          <li><a href="<?php echo base_url().'bigData/c_categoryTeeList/showDetail/'.$row['ID']; ?>" style="font-size: 12px;"><?php echo $row['CATEGORY_NAME']." (".$row['ID'].")"; ?></a><a href="<?php echo base_url().'bigData/c_categoryTeeList/pullData/'.$row['ID']; ?>" class="btn btn-primary btn-xs pull-right" ><i class="fa fa-arrow-circle-down"></i>
                  </a></li>
                     <?php  }else { ?>
                          <li class="toys_and_hobbies" style="display: none;"><a href="<?php echo base_url().'bigData/c_categoryTeeList/showDetail/'.$row['ID']; ?>" style="font-size: 12px;"><?php echo $row['CATEGORY_NAME']." (".$row['ID'].")"; ?></a><a href="<?php echo base_url().'bigData/c_categoryTeeList/pullData/'.$row['ID']; ?>" class="btn btn-primary btn-xs pull-right" ><i class="fa fa-arrow-circle-down"></i>
                  </a></li>
                    <?php  }
                      $i++; 
                     } ?>
                  </ul>

                  <a class="btn btn-primary btn-xs small-box-footer pull-right" id="show_toys" style="margin-top: 9px;">
                    Show More <i class="fa fa-arrow-circle-down"></i>
                  </a>
                  <a class="btn btn-primary btn-xs small-box-footer pull-right" id="hide_toys" style="display: none;">
                    Show Less <i class="fa fa-arrow-circle-up"></i>
                  </a>
                  <?php } ?>
              </div>
              <!-- /.box-footer-->
            </div>
            <!--/.direct-chat -->
          </div><!-- /.col -->
          <!-- =========================================================== -->
          <div class="col-md-3">
            <div class="box box-success box-solid">
              <div class="box-header with-border">
                <h3 class="box-title"><a href="<?php echo base_url().'bigData/c_categoryTeeList/showDetail/267' ?>"> Books (267)</a></h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body"><!-- Conversations are loaded here -->
               <?php if($data['books']->num_rows() > 0){ ?>
                  <ul class="contacts-list">
                  <?php 
                    $i=0;
                    foreach($data['books']->result_array() as $row){
                      if ($i <=4) { ?>
                          <li><a href="<?php echo base_url().'bigData/c_categoryTeeList/showDetail/'.$row['ID']; ?>" style="font-size: 12px;"><?php echo $row['CATEGORY_NAME']." (".$row['ID'].")"; ?></a><a href="<?php echo base_url().'bigData/c_categoryTeeList/pullData/'.$row['ID']; ?>" class="btn btn-primary btn-xs pull-right" ><i class="fa fa-arrow-circle-down"></i>
                  </a></li>
                     <?php  }else { ?>
                          <li class="books" style="display: none;"><a href="<?php echo base_url().'bigData/c_categoryTeeList/showDetail/'.$row['ID']; ?>" style="font-size: 12px;"><?php echo $row['CATEGORY_NAME']." (".$row['ID'].")"; ?></a><a href="<?php echo base_url().'bigData/c_categoryTeeList/pullData/'.$row['ID']; ?>" class="btn btn-primary btn-xs pull-right" ><i class="fa fa-arrow-circle-down"></i>
                  </a></li>
                    <?php  }
                      $i++; 
                     } ?>
                  </ul>

                  <a class="btn btn-primary btn-xs small-box-footer pull-right" id="show_books" style="margin-top: 9px;">
                    Show More <i class="fa fa-arrow-circle-down"></i>
                  </a>
                  <a class="btn btn-primary btn-xs small-box-footer pull-right" id="hide_books" style="display: none;">
                    Show Less <i class="fa fa-arrow-circle-up"></i>
                  </a>
                  <?php } ?>
              </div>
              <!-- /.box-footer-->
            </div>
            <!--/.direct-chat -->
          </div><!-- /.col -->
          <!-- =========================================================== -->
          <div class="col-md-3">
            <div class="box box-warning box-solid">
              <div class="box-header with-border">
                <h3 class="box-title"><a href="<?php echo base_url().'bigData/c_categoryTeeList/showDetail/281' ?>"> Jewelry &amp; Watches- 281 </a></h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body"><!-- Conversations are loaded here -->
                  <?php if($data['jewelry']->num_rows() > 0){ ?>
                  <ul class="contacts-list">
                  <?php 
                    $i=0;
                    foreach($data['jewelry']->result_array() as $row){
                      if ($i <=4) { ?>
                          <li><a href="<?php echo base_url().'bigData/c_categoryTeeList/showDetail/'.$row['ID']; ?>" style="font-size: 12px;"><?php echo $row['CATEGORY_NAME']." (".$row['ID'].")"; ?></a><a href="<?php echo base_url().'bigData/c_categoryTeeList/pullData/'.$row['ID']; ?>" class="btn btn-primary btn-xs pull-right" ><i class="fa fa-arrow-circle-down"></i>
                  </a></li>
                     <?php  }else { ?>
                          <li class="jewelry" style="display: none;"><a href="<?php echo base_url().'bigData/c_categoryTeeList/showDetail/'.$row['ID']; ?>" style="font-size: 12px;"><?php echo $row['CATEGORY_NAME']." (".$row['ID'].")"; ?></a><a href="<?php echo base_url().'bigData/c_categoryTeeList/pullData/'.$row['ID']; ?>" class="btn btn-primary btn-xs pull-right" ><i class="fa fa-arrow-circle-down"></i>
                  </a></li>
                    <?php  }
                      $i++; 
                     } ?>
                  </ul>

                  <a class="btn btn-primary btn-xs small-box-footer pull-right" id="show_jewelry" style="margin-top: 9px;">
                    Show More <i class="fa fa-arrow-circle-down"></i>
                  </a>
                  <a class="btn btn-primary btn-xs small-box-footer pull-right" id="hide_jewelry" style="display: none;">
                    Show Less <i class="fa fa-arrow-circle-up"></i>
                  </a>
                  <?php } ?>
              </div>   
              <!-- /.box-footer-->
            </div>
            <!--/.direct-chat -->
          </div><!-- /.col -->
          <!-- =========================================================== -->
          <div class="col-md-3">
            <div class="box box-danger box-solid">
              <div class="box-header with-border">
                <h3 class="box-title"><a href="<?php echo base_url().'bigData/c_categoryTeeList/showDetail/293' ?>"> Consumer Electronics - 293</a></h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body"><!-- Conversations are loaded here -->
                   <?php if($data['electronics']->num_rows() > 0){ ?>
                  <ul class="contacts-list">
                  <?php 
                    $i=0;
                    foreach($data['electronics']->result_array() as $row){
                      if ($i <=4) { ?>
                          <li><a href="<?php echo base_url().'bigData/c_categoryTeeList/showDetail/'.$row['ID']; ?>" style="font-size: 12px;"><?php echo $row['CATEGORY_NAME']." (".$row['ID'].")"; ?></a><a href="<?php echo base_url().'bigData/c_categoryTeeList/pullData/'.$row['ID']; ?>" class="btn btn-primary btn-xs pull-right" ><i class="fa fa-arrow-circle-down"></i>
                  </a></li>
                     <?php  }else { ?>
                          <li class="electronics" style="display: none;"><a href="<?php echo base_url().'bigData/c_categoryTeeList/showDetail/'.$row['ID']; ?>" style="font-size: 12px;"><?php echo $row['CATEGORY_NAME']." (".$row['ID'].")"; ?></a><a href="<?php echo base_url().'bigData/c_categoryTeeList/pullData/'.$row['ID']; ?>" class="btn btn-primary btn-xs pull-right" ><i class="fa fa-arrow-circle-down"></i>
                  </a></li>
                    <?php  }
                      $i++; 
                     } ?>
                  </ul>

                  <a class="btn btn-primary btn-xs small-box-footer pull-right" id="show_electronics" style="margin-top: 9px;">
                    Show More <i class="fa fa-arrow-circle-down"></i>
                  </a>
                  <a class="btn btn-primary btn-xs small-box-footer pull-right" id="hide_electronics" style="display: none;">
                    Show Less <i class="fa fa-arrow-circle-up"></i>
                  </a>
                  <?php } ?>
              </div>
              <!-- /.box-footer-->
            </div>
            <!--/.direct-chat -->
          </div><!-- /.col -->
         <!-- </div> -->

    <!-- =======================ROW 2 ==================================== --> 
  <!-- <div class="row"> -->
          <div class="col-md-3">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <h3 class="box-title"><a href="<?php echo base_url().'bigData/c_categoryTeeList/showDetail/619' ?>">  Musical Instruments &amp; Gear - 619</a></h3>
              </div><!-- /.box-header -->
              <div class="box-body"><!-- Conversations are loaded here -->
                   <?php if($data['music']->num_rows() > 0){ ?>
                  <ul class="contacts-list">
                  <?php 
                    $i=0;
                    foreach($data['music']->result_array() as $row){
                      if ($i <=4) { ?>
                          <li><a href="<?php echo base_url().'bigData/c_categoryTeeList/showDetail/'.$row['ID']; ?>" style="font-size: 12px;"><?php echo $row['CATEGORY_NAME']." (".$row['ID'].")"; ?></a><a href="<?php echo base_url().'bigData/c_categoryTeeList/pullData/'.$row['ID']; ?>" class="btn btn-primary btn-xs pull-right" ><i class="fa fa-arrow-circle-down"></i>
                  </a></li>
                     <?php  }else { ?>
                          <li class="music" style="display: none;"><a href="<?php echo base_url().'bigData/c_categoryTeeList/showDetail/'.$row['ID']; ?>" style="font-size: 12px;"><?php echo $row['CATEGORY_NAME']." (".$row['ID'].")"; ?></a><a href="<?php echo base_url().'bigData/c_categoryTeeList/pullData/'.$row['ID']; ?>" class="btn btn-primary btn-xs pull-right" ><i class="fa fa-arrow-circle-down"></i>
                  </a></li>
                    <?php  }
                      $i++; 
                     } ?>
                  </ul>

                  <a class="btn btn-primary btn-xs small-box-footer pull-right" id="show_music" style="margin-top: 9px;">
                    Show More <i class="fa fa-arrow-circle-down"></i>
                  </a>
                  <a class="btn btn-primary btn-xs small-box-footer pull-right" id="hide_music" style="display: none;">
                    Show Less <i class="fa fa-arrow-circle-up"></i>
                  </a>
                  <?php } ?>
              </div>
              <!-- /.box-footer-->

            </div>
            <!--/.direct-chat -->
          </div><!-- /.col -->
          <!-- ///////////////////////// -->
          <div class="col-md-3">
            <div class="box box-success box-solid">
              <div class="box-header with-border">
                <h3 class="box-title"><a href="<?php echo base_url().'bigData/c_categoryTeeList/showDetail/625' ?>">  Cameras &amp; Photo - 625</a></h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body"><!-- Conversations are loaded here -->
                  <?php if($data['camera']->num_rows() > 0){ ?>
                  <ul class="contacts-list">
                  <?php 
                    $i=0;
                    foreach($data['camera']->result_array() as $row){
                      if ($i <=4) { ?>
                          <li><a href="<?php echo base_url().'bigData/c_categoryTeeList/showDetail/'.$row['ID']; ?>" style="font-size: 12px;"><?php echo $row['CATEGORY_NAME']." (".$row['ID'].")"; ?></a><a href="<?php echo base_url().'bigData/c_categoryTeeList/pullData/'.$row['ID']; ?>" class="btn btn-primary btn-xs pull-right" ><i class="fa fa-arrow-circle-down"></i>
                  </a></li>
                     <?php  }else { ?>
                          <li class="camera" style="display: none;"><a href="<?php echo base_url().'bigData/c_categoryTeeList/showDetail/'.$row['ID']; ?>" style="font-size: 12px;"><?php echo $row['CATEGORY_NAME']." (".$row['ID'].")"; ?></a><a href="<?php echo base_url().'bigData/c_categoryTeeList/pullData/'.$row['ID']; ?>" class="btn btn-primary btn-xs pull-right" ><i class="fa fa-arrow-circle-down"></i>
                  </a></li>
                    <?php  }
                      $i++; 
                     } ?>
                  </ul>

                  <a class="btn btn-primary btn-xs small-box-footer pull-right" id="show_camera" style="margin-top: 9px;">
                    Show More <i class="fa fa-arrow-circle-down"></i>
                  </a>
                  <a class="btn btn-primary btn-xs small-box-footer pull-right" id="hide_camera" style="display: none;">
                    Show Less <i class="fa fa-arrow-circle-up"></i>
                  </a>
                  <?php } ?>
              </div>
              <!-- /.box-footer-->
            </div>
            <!--/.direct-chat -->
          </div><!-- /.col -->
          <!-- ///////////////////////// -->
          <div class="col-md-3">
            <div class="box box-warning box-solid">
              <div class="box-header with-border">
                <h3 class="box-title"><a href="<?php echo base_url().'bigData/c_categoryTeeList/showDetail/1249' ?>">  Video Games &amp; Consoles - 1249</a></h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body"><!-- Conversations are loaded here -->
                 <?php if($data['games']->num_rows() > 0){ ?>
                  <ul class="contacts-list">
                  <?php 
                    $i=0;
                    foreach($data['games']->result_array() as $row){
                      if ($i <=4) { ?>
                          <li><a href="<?php echo base_url().'bigData/c_categoryTeeList/showDetail/'.$row['ID']; ?>" style="font-size: 12px;"><?php echo $row['CATEGORY_NAME']." (".$row['ID'].")"; ?></a><a href="<?php echo base_url().'bigData/c_categoryTeeList/pullData/'.$row['ID']; ?>" class="btn btn-primary btn-xs pull-right" ><i class="fa fa-arrow-circle-down"></i>
                  </a></li>
                     <?php  }else { ?>
                          <li class="games" style="display: none;"><a href="<?php echo base_url().'bigData/c_categoryTeeList/showDetail/'.$row['ID']; ?>" style="font-size: 12px;"><?php echo $row['CATEGORY_NAME']." (".$row['ID'].")"; ?></a><a href="<?php echo base_url().'bigData/c_categoryTeeList/pullData/'.$row['ID']; ?>" class="btn btn-primary btn-xs pull-right" ><i class="fa fa-arrow-circle-down"></i>
                  </a></li>
                    <?php  }
                      $i++; 
                     } ?>
                  </ul>

                  <a class="btn btn-primary btn-xs small-box-footer pull-right" id="show_games" style="margin-top: 9px;">
                    Show More <i class="fa fa-arrow-circle-down"></i>
                  </a>
                  <a class="btn btn-primary btn-xs small-box-footer pull-right" id="hide_games" style="display: none;">
                    Show Less <i class="fa fa-arrow-circle-up"></i>
                  </a>
                  <?php } ?>
              </div>   
              <!-- /.box-footer-->
            </div>
            <!--/.direct-chat -->
          </div><!-- /.col -->
           <!-- ///////////////////////// -->
          <div class="col-md-3">
            <div class="box box-danger box-solid">
              <div class="box-header with-border">
                <h3 class="box-title"><a href="<?php echo base_url().'bigData/c_categoryTeeList/showDetail/11450' ?>">  Clothing, Shoes &amp; Accessories - 11450</a></h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body"><!-- Conversations are loaded here -->
                 <?php if($data['clothing']->num_rows() > 0){ ?>
                  <ul class="contacts-list">
                  <?php 
                    $i=0;
                    foreach($data['clothing']->result_array() as $row){
                      if ($i <=4) { ?>
                          <li><a href="<?php echo base_url().'bigData/c_categoryTeeList/showDetail/'.$row['ID']; ?>" style="font-size: 12px;"><?php echo $row['CATEGORY_NAME']." (".$row['ID'].")"; ?></a><a href="<?php echo base_url().'bigData/c_categoryTeeList/pullData/'.$row['ID']; ?>" class="btn btn-primary btn-xs pull-right" ><i class="fa fa-arrow-circle-down"></i>
                  </a></li>
                     <?php  }else { ?>
                          <li class="clothing" style="display: none;"><a href="<?php echo base_url().'bigData/c_categoryTeeList/showDetail/'.$row['ID']; ?>" style="font-size: 12px;"><?php echo $row['CATEGORY_NAME']." (".$row['ID'].")"; ?></a><a href="<?php echo base_url().'bigData/c_categoryTeeList/pullData/'.$row['ID']; ?>" class="btn btn-primary btn-xs pull-right" ><i class="fa fa-arrow-circle-down"></i>
                  </a></li>
                    <?php  }
                      $i++; 
                     } ?>
                  </ul>

                  <a class="btn btn-primary btn-xs small-box-footer pull-right" id="show_clothing" style="margin-top: 9px;">
                    Show More <i class="fa fa-arrow-circle-down"></i>
                  </a>
                  <a class="btn btn-primary btn-xs small-box-footer pull-right" id="hide_clothing" style="display: none;">
                    Show Less <i class="fa fa-arrow-circle-up"></i>
                  </a>
                  <?php } ?>
              </div>
              <!-- /.box-footer-->
            </div>
            <!--/.direct-chat -->
          </div><!-- /.col -->
  <!--        </div> -->

    <!-- ====================ROW 3 ======================================= -->  
  <!--   <div class="row"> -->
          <div class="col-md-3">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <h3 class="box-title"><a href="<?php echo base_url().'bigData/c_categoryTeeList/showDetail/12576' ?>">  Business &amp; Industrial - 12576</a></h3>
              </div><!-- /.box-header -->
              <div class="box-body"><!-- Conversations are loaded here -->
                 <?php if($data['business']->num_rows() > 0){ ?>
                  <ul class="contacts-list">
                  <?php 
                    $i=0;
                    foreach($data['business']->result_array() as $row){
                      if ($i <=4) { ?>
                          <li><a href="<?php echo base_url().'bigData/c_categoryTeeList/showDetail/'.$row['ID']; ?>" style="font-size: 12px;"><?php echo $row['CATEGORY_NAME']." (".$row['ID'].")"; ?></a><a href="<?php echo base_url().'bigData/c_categoryTeeList/pullData/'.$row['ID']; ?>" class="btn btn-primary btn-xs pull-right" ><i class="fa fa-arrow-circle-down"></i>
                  </a></li>
                     <?php  }else { ?>
                          <li class="business" style="display: none;"><a href="<?php echo base_url().'bigData/c_categoryTeeList/showDetail/'.$row['ID']; ?>" style="font-size: 12px;"><?php echo $row['CATEGORY_NAME']." (".$row['ID'].")"; ?></a><a href="<?php echo base_url().'bigData/c_categoryTeeList/pullData/'.$row['ID']; ?>" class="btn btn-primary btn-xs pull-right" ><i class="fa fa-arrow-circle-down"></i>
                  </a></li>
                    <?php  }
                      $i++; 
                     } ?>
                  </ul>

                  <a class="btn btn-primary btn-xs small-box-footer pull-right" id="show_business" style="margin-top: 9px;">
                    Show More <i class="fa fa-arrow-circle-down"></i>
                  </a>
                  <a class="btn btn-primary btn-xs small-box-footer pull-right" id="hide_business" style="display: none;">
                    Show Less <i class="fa fa-arrow-circle-up"></i>
                  </a>
                  <?php } ?>
              </div>
              <!-- /.box-footer-->

            </div>
            <!--/.direct-chat -->
          </div><!-- /.col -->
          <!-- ///////////////////////// -->
          <div class="col-md-3">
            <div class="box box-success box-solid">
              <div class="box-header with-border">
                <h3 class="box-title"><a href="<?php echo base_url().'bigData/c_categoryTeeList/showDetail/15032' ?>"> Cell Phones &amp; Accessories - 15032</a></h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body"><!-- Conversations are loaded here -->
                <?php if($data['accessory']->num_rows() > 0){ ?>
                  <ul class="contacts-list">
                  <?php 
                    $i=0;
                    foreach($data['accessory']->result_array() as $row){
                      if ($i <=4) { ?>
                          <li><a href="<?php echo base_url().'bigData/c_categoryTeeList/showDetail/'.$row['ID']; ?>" style="font-size: 12px;"><?php echo $row['CATEGORY_NAME']." (".$row['ID'].")"; ?></a><a href="<?php echo base_url().'bigData/c_categoryTeeList/pullData/'.$row['ID']; ?>" class="btn btn-primary btn-xs pull-right" ><i class="fa fa-arrow-circle-down"></i>
                  </a></li>
                     <?php  }else { ?>
                          <li class="accessory" style="display: none;"><a href="<?php echo base_url().'bigData/c_categoryTeeList/showDetail/'.$row['ID']; ?>" style="font-size: 12px;"><?php echo $row['CATEGORY_NAME']." (".$row['ID'].")"; ?></a><a href="<?php echo base_url().'bigData/c_categoryTeeList/pullData/'.$row['ID']; ?>" class="btn btn-primary btn-xs pull-right" ><i class="fa fa-arrow-circle-down"></i>
                  </a></li>
                    <?php  }
                      $i++; 
                     } ?>
                  </ul>

                  <a class="btn btn-primary btn-xs small-box-footer pull-right" id="show_accessory" style="margin-top: 9px;">
                    Show More <i class="fa fa-arrow-circle-down"></i>
                  </a>
                  <a class="btn btn-primary btn-xs small-box-footer pull-right" id="hide_accessory" style="display: none;">
                    Show Less <i class="fa fa-arrow-circle-up"></i>
                  </a>
                  <?php } ?>
              </div>
              <!-- /.box-footer-->
            </div>
            <!--/.direct-chat -->
          </div><!-- /.col -->
          <!-- ///////////////////////// -->
          <div class="col-md-3">
            <div class="box box-warning box-solid">
              <div class="box-header with-border">
                <h3 class="box-title"><a href="<?php echo base_url().'bigData/c_categoryTeeList/showDetail/26395' ?>">  Health &amp; Beauty - 26395</a></h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body"><!-- Conversations are loaded here -->
                <?php if($data['health']->num_rows() > 0){ ?>
                  <ul class="contacts-list">
                  <?php 
                    $i=0;
                    foreach($data['health']->result_array() as $row){
                      if ($i <=4) { ?>
                          <li><a href="<?php echo base_url().'bigData/c_categoryTeeList/showDetail/'.$row['ID']; ?>" style="font-size: 12px;"><?php echo $row['CATEGORY_NAME']." (".$row['ID'].")"; ?></a><a href="<?php echo base_url().'bigData/c_categoryTeeList/pullData/'.$row['ID']; ?>" class="btn btn-primary btn-xs pull-right" ><i class="fa fa-arrow-circle-down"></i>
                  </a></li>
                     <?php  }else { ?>
                          <li class="health" style="display: none;"><a href="<?php echo base_url().'bigData/c_categoryTeeList/showDetail/'.$row['ID']; ?>" style="font-size: 12px;"><?php echo $row['CATEGORY_NAME']." (".$row['ID'].")"; ?></a><a href="<?php echo base_url().'bigData/c_categoryTeeList/pullData/'.$row['ID']; ?>" class="btn btn-primary btn-xs pull-right" ><i class="fa fa-arrow-circle-down"></i>
                  </a></li>
                    <?php  }
                      $i++; 
                     } ?>
                  </ul>

                  <a class="btn btn-primary btn-xs small-box-footer pull-right" id="show_health" style="margin-top: 9px;">
                    Show More <i class="fa fa-arrow-circle-down"></i>
                  </a>
                  <a class="btn btn-primary btn-xs small-box-footer pull-right" id="hide_health" style="display: none;">
                    Show Less <i class="fa fa-arrow-circle-up"></i>
                  </a>
                  <?php } ?>
              </div>   
              <!-- /.box-footer-->
            </div>
            <!--/.direct-chat -->
          </div><!-- /.col -->
           <!-- ///////////////////////// -->
          <div class="col-md-3">
            <div class="box box-danger box-solid">
              <div class="box-header with-border">
                <h3 class="box-title"><a href="<?php echo base_url().'bigData/c_categoryTeeList/showDetail/58058' ?>"> Computers/Tablets &amp; Networking - 58058</a></h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body"><!-- Conversations are loaded here -->
                <?php if($data['computers']->num_rows() > 0){ ?>
                  <ul class="contacts-list">
                  <?php 
                    $i=0;
                    foreach($data['computers']->result_array() as $row){
                      if ($i <=4) { ?>
                          <li><a href="<?php echo base_url().'bigData/c_categoryTeeList/showDetail/'.$row['ID']; ?>" style="font-size: 12px;"><?php echo $row['CATEGORY_NAME']." (".$row['ID'].")"; ?></a><a href="<?php echo base_url().'bigData/c_categoryTeeList/pullData/'.$row['ID']; ?>" class="btn btn-primary btn-xs pull-right" ><i class="fa fa-arrow-circle-down"></i>
                  </a></li>
                     <?php  }else { ?>
                          <li class="computers" style="display: none;"><a href="<?php echo base_url().'bigData/c_categoryTeeList/showDetail/'.$row['ID']; ?>" style="font-size: 12px;"><?php echo $row['CATEGORY_NAME']." (".$row['ID'].")"; ?></a><a href="<?php echo base_url().'bigData/c_categoryTeeList/pullData/'.$row['ID']; ?>" class="btn btn-primary btn-xs pull-right" ><i class="fa fa-arrow-circle-down"></i>
                  </a></li>
                    <?php  }
                      $i++; 
                     } ?>
                  </ul>

                  <a class="btn btn-primary btn-xs small-box-footer pull-right" id="show_computers" style="margin-top: 9px;">
                    Show More <i class="fa fa-arrow-circle-down"></i>
                  </a>
                  <a class="btn btn-primary btn-xs small-box-footer pull-right" id="hide_computers" style="display: none;">
                    Show Less <i class="fa fa-arrow-circle-up"></i>
                  </a>
                  <?php } ?>
              </div>
              <!-- /.box-footer-->
            </div>
            <!--/.direct-chat -->
          </div><!-- /.col -->
       </div>
      </div> 
    </div>
  </section><!-- /.content -->
</div>
  <!-- /.content-wrapper -->
<?php $this->load->view('template/footer'); ?>
<script type="text/javascript">
  $(document).ready(function(){
    /*////////// FOR TOYS AND HOBBIES /////////////////////*/
  $("#show_toys").click(function() {
    $(".toys_and_hobbies").show();
    $("#hide_toys").show();
    $("#show_toys").hide(); 
      $("#hide_toys").click(function() {
        $(".toys_and_hobbies").hide();
        $("#hide_toys").hide();
        $("#show_toys").show();
      });  
  }); 
      /*////////// FOR BOOKS /////////////////////*/
  $("#show_books").click(function() {
    $(".books").show();
    $("#hide_books").show();
    $("#show_books").hide(); 
      $("#hide_books").click(function() {
        $(".books").hide();
        $("#hide_books").hide();
        $("#show_books").show();
      });  
  });
        /*////////// FOR JEWELRY /////////////////////*/
  $("#show_jewelry").click(function() {
    $(".jewelry").show();
    $("#hide_jewelry").show();
    $("#show_jewelry").hide(); 
      $("#hide_jewelry").click(function() {
        $(".jewelry").hide();
        $("#hide_jewelry").hide();
        $("#show_jewelry").show();
      });  
  });
          /*////////// FOR ELECTRONICS /////////////////////*/
  $("#show_electronics").click(function() {
    $(".electronics").show();
    $("#hide_electronics").show();
    $("#show_electronics").hide(); 
      $("#hide_electronics").click(function() {
        $(".electronics").hide();
        $("#hide_electronics").hide();
        $("#show_electronics").show();
      });  
  });
            /*////////// FOR music /////////////////////*/
  $("#show_music").click(function() {
    $(".music").show();
    $("#hide_music").show();
    $("#show_music").hide(); 
      $("#hide_music").click(function() {
        $(".music").hide();
        $("#hide_music").hide();
        $("#show_music").show();
      });  
  });
            /*////////// FOR camera /////////////////////*/
  $("#show_camera").click(function() {
    $(".camera").show();
    $("#hide_camera").show();
    $("#show_camera").hide(); 
      $("#hide_camera").click(function() {
        $(".camera").hide();
        $("#hide_camera").hide();
        $("#show_camera").show();
      });  
  });
            /*////////// FOR games /////////////////////*/
  $("#show_games").click(function() {
    $(".games").show();
    $("#hide_games").show();
    $("#show_games").hide(); 
      $("#hide_games").click(function() {
        $(".games").hide();
        $("#hide_games").hide();
        $("#show_games").show();
      });  
  });
            /*////////// FOR clothing /////////////////////*/
  $("#show_clothing").click(function() {
    $(".clothing").show();
    $("#hide_clothing").show();
    $("#show_clothing").hide(); 
      $("#hide_clothing").click(function() {
        $(".clothing").hide();
        $("#hide_clothing").hide();
        $("#show_clothing").show();
      });  
  });
            /*////////// FOR business /////////////////////*/
  $("#show_business").click(function() {
    $(".business").show();
    $("#hide_business").show();
    $("#show_business").hide(); 
      $("#hide_business").click(function() {
        $(".business").hide();
        $("#hide_business").hide();
        $("#show_business").show();
      });  
  });
            /*////////// FOR accessory /////////////////////*/
  $("#show_accessory").click(function() {
    $(".accessory").show();
    $("#hide_accessory").show();
    $("#show_accessory").hide(); 
      $("#hide_accessory").click(function() {
        $(".accessory").hide();
        $("#hide_accessory").hide();
        $("#show_accessory").show();
      });  
  });
            /*////////// FOR health /////////////////////*/
  $("#show_health").click(function() {
    $(".health").show();
    $("#hide_health").show();
    $("#show_health").hide(); 
      $("#hide_health").click(function() {
        $(".health").hide();
        $("#hide_health").hide();
        $("#show_health").show();
      });  
  });
            /*////////// FOR computers /////////////////////*/
  $("#show_computers").click(function() {
    $(".computers").show();
    $("#hide_computers").show();
    $("#show_computers").hide(); 
      $("#hide_computers").click(function() {
        $(".computers").hide();
        $("#hide_computers").hide();
        $("#show_computers").show();
      });  
  });
///////////////////////////////////////////////////
});   
</script>