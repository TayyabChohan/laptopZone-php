<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9">
  <link rel="icon" href="<?php echo base_url('assets/images/favicon-1.ico');?>">
  <?php 
    $hostname = $_SERVER['HTTP_HOST'];       
    $oraserver = "192.168.0.59:8081";
    $oraserver2 = "192.168.0.28";
    $oraserverLive = "71.78.236.22:8081";
    $oraserverLive2 = "71.78.236.20";
    $ecologixserver = "192.168.0.78:8081";
    $ecologixserverLive = "71.78.236.21:8081";
    $localserver = "wizmen-pc:8081";
    $localserver2 = "localhost";

    $server_name = '';
    if($hostname == $oraserver || $hostname == $oraserver2 || $hostname == $oraserverLive || $hostname == $oraserverLive2){
      $server_name .= " - OR";
    }elseif ($hostname == $ecologixserver || $hostname == $ecologixserverLive) {
      $server_name .= " - BG";
    }
  ?>
  <title><?php echo (isset($pageTitle)) ? $pageTitle.$server_name : 'Dashboard '.$server_name; ?> | Laptopzone</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css');?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/font-awesome.min.css');?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/AdminLTE.min.css');?>">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/skins/_all-skins.min.css');?>">
  <!-- iCheck -->
  <!-- <link rel="stylesheet" href="<?php //echo base_url('assets/plugins/iCheck/flat/blue.css');?>"> -->
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/morris/morris.css');?>">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css');?>">
    <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/iCheck/flat/green.css');?>">
    <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/iCheck/all.css');?>">
  <!-- Date Picker -->  
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/datepicker/datepicker3.css');?>">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/daterangepicker/daterangepicker.css');?>">

  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/datetimepicker/bootstrap-datetimepicker.css');?>">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/custom.css');?>">
  <!-- <link rel="stylesheet" href="<?php //echo base_url('assets/plugins/datatables/jquery.dataTables.min.css');?>"> -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/datatables/datatables.min.css');?>"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/umeditor-dev/themes/default/_css/umeditor.css');?>">
  <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.min.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- image gallery section -->
   <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/image_gallery_viewer.css');?>">
   <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/image_gallery_main.css');?>">
   <!-- //////////////////INPUTABLE DROPDOWN FILES///////////////////////////// -->
   <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/inputable/jqx.base.css'); ?>"/>
   <!-- /////////////////////////////////////////////// -->
  <!-- image gallery section -->
     <!--=============================================
=            spell check editor block            =
=============================================-->
<!-- <script src="https://cdn.ckeditor.com/ckeditor5/10.0.0/classic/ckeditor.js"></script> -->
<!--=====  End of spell check editor block  ======*/ -->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo base_url();?>dashboard/dashboard/" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LZ</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Admin</b> Laptop Zone</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

        <li class="tasks-menu">
          <select id="account_type" class="form-control" name="account_type" required>
          <?php $acc_type = $this->session->userdata('account_type');?>

            <option value="2" <?php if(@$acc_type == 2){echo 'selected';} ?> >Dfwonline</option>
            <option value="1" <?php if(@$acc_type == 1){echo 'selected';} ?>>Techbargains2015</option>
          </select>
        </li> 

          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo base_url('assets/dist/img/default-admin.png');?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php $emp_name = $this->session->userdata('employee_name'); echo $emp_name;?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo base_url('assets/dist/img/default-admin.png');?>" class="img-circle" alt="User Image">
                <p>
                  <?php 
                  $emp_name = $this->session->userdata('employee_name'); 
                  echo $emp_name;
                  ?>
                  <small>
                    <?php
                    date_default_timezone_set("America/New_York"); 
                    echo date("l jS \of F Y"); ?><br>
                    <?php echo date("h:i:s A"); ?>
                  </small>
                </p>
              </li>
              <li class="user-footer">
                <div class="pull-left">
                  <!-- <a href="#" class="btn btn-default btn-flat">Profile</a> -->
                </div>
                <div class="pull-right">
                  <a href="<?php echo base_url();?>login/login/logout" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo base_url('assets/dist/img/default-admin.png');?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php $emp_name = $this->session->userdata('employee_name'); echo $emp_name;?></p>
          <!-- <a href="#"><i class="fa fa-circle text-success"></i> Online</a> -->
        </div>
      </div>
      <!-- search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>

        <li class="treeview active">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-circle-o" aria-hidden="true"></i> Dashboard</a></li>
            <li class="active"><a href="<?php echo base_url();?>Analysis/c_Analysis/activeListing"><i class="fa fa-circle-o" aria-hidden="true"></i> Listing Analysis</a></li>            
             
            <li class="active" style="<?php if($hostname == $oraserver || $hostname == $oraserverLive || $hostname == $oraserver2 || $hostname == $oraserverLive2){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>"><a href="<?php echo base_url();?>charts/c_charts"><i class="fa fa-bar-chart" aria-hidden="true"></i> BigData Summary</a></li>
            <li class="active" style="<?php if($hostname == $oraserver || $hostname == $oraserverLive || $hostname == $oraserver2 || $hostname == $oraserverLive2){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>"><a href="<?php echo base_url();?>charts/c_mpn_charts"><i class="fa fa-bar-chart" aria-hidden="true"></i> MPN Summary</a></li>
            <li class="active" style="<?php if($hostname == $oraserver || $hostname == $oraserverLive || $hostname == $oraserver2 || $hostname == $oraserverLive2){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>"><a href="<?php echo base_url();?>charts/c_mpn_date"><i class="fa fa-bar-chart" aria-hidden="true"></i> MPN Date Summary</a></li>
          </ul>
        </li>

        <li class="treeview active" style="<?php if($hostname == $ecologixserver || $hostname == $ecologixserverLive){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>">
          <a href="#">
            <i class="fa fa-chevron-circle-down"></i>
            <span>Pre-Sale</span>
            <span class="pull-right-container">
              <span id="preMenu" class="label label-primary pull-right">
                <!-- getting values like 1, 2, 3 by JS -->
              </span>
            </span>
          </a>
          <ul id="Menu" class="treeview-menu">
            <li><a href="<?php echo base_url();?>listing/listing_search/search_item"><i class="fa fa-search" aria-hidden="true"></i>Search Item</a></li>
            <!-- <li><a href="<?php //echo base_url();?>listing/listing"><i class="fa fa-wpforms" aria-hidden="true"></i>Listing Form</a></li> -->
            <li><a href="<?php echo base_url();?>tolist/c_tolist/lister_view"><i class="fa fa-list" aria-hidden="true"></i>Item Listing</a></li>
            <li><a href="<?php echo base_url();?>locations/c_create_lot"><i class="fa fa-list" aria-hidden="true"></i>Create Lot</a></li>
            <li><a href="<?php echo base_url();?>locations/c_create_lot/my_lot_items"><i class="fa fa-list" aria-hidden="true"></i>My Lot</a></li>
            <li><a href="<?php echo base_url();?>tolist/c_tolist/listedItemsAudit"><i class="fa fa-list" aria-hidden="true"></i>Items Audit</a></li>
            <li><a href="<?php echo base_url();?>autoList/c_autolist/autolistedAudit"><i class="fa fa-list" aria-hidden="true"></i>Auto Listed Items</a></li>
            <li><a href="<?php echo base_url();?>tolist/c_tolist/pic_view"><i class="fa fa-picture-o" aria-hidden="true"></i>Pic Approval</a></li>
            <li><a href="<?php echo base_url();?>tolist/c_tolist/tolist_view"><i class="fa fa-list-ul" aria-hidden="true"></i>To-List View</a></li>
            <?php $login_id = $this->session->userdata('user_id'); 
            if($login_id == 2 || $login_id == 17 || $login_id == 21 || $login_id == 4){
              ?>
            <li><a href="<?php echo base_url();?>ListingAllocation/c_ListingAllocation/lister_view"><i class="fa fa-users" aria-hidden="true"></i>Listing Allocation</a></li>
            <?php } ?>
            <li><a href="<?php echo base_url();?>specifics/c_item_specifics"><i class="fa fa-wpforms" aria-hidden="true"></i>Item Specifics</a></li>
            <li><a href="<?php echo base_url();?>checklist/c_checklist/add"><i class="fa fa-wpforms" aria-hidden="true"></i>Add Checklist</a></li>
            <li><a href="<?php echo base_url();?>tester/c_tester_screen"><i class="fa fa-wpforms" aria-hidden="true"></i>Tester Screen</a></li>
            <li><a href="<?php echo base_url();?>item_pictures/c_item_pictures/master_view"><i class="fa fa-picture-o" aria-hidden="true"></i>Item Pictures</a></li>
            <li><a href="<?php echo base_url();?>locations/c_locations/barcode_notes"><i class="fa fa-list" aria-hidden="true"></i></i>Barcode Notes</a></li>
            <li><a href="<?php echo base_url();?>template/c_temp"><i class="fa fa-wpforms" aria-hidden="true"></i>Template Form</a></li>            
            
          </ul>
        </li>
        <!-- =============start catalogue to cash module =========== -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-chevron-circle-down"></i>
            <span>Catalogue To Cash</span>
            <span class="pull-right-container">
              <span id="cataCashMenu" class="label label-primary pull-right">
                <!-- getting values like 1, 2, 3 by JS -->
              </span>
            </span>
          </a>
          <ul id="cashMenu" class="treeview-menu">
            <li style="<?php if($hostname == $oraserver || $hostname == $oraserverLive || $hostname == $oraserver2 || $hostname == $oraserverLive2){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>"><a href="<?php echo base_url();?>catalogueToCash/c_purchasing"><i class="fa fa-list" aria-hidden="true"></i>Purchasing</a></li>
            <li style="<?php if($hostname == $oraserver || $hostname == $oraserverLive || $hostname == $oraserver2 || $hostname == $oraserverLive2){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>"><a href="<?php echo base_url();?>catalogueToCash/c_purchasing/purchasing_detail"><i class="fa fa-list" aria-hidden="true"></i>Purchasing Dashboard</a></li>
            <li style="<?php if($hostname == $ecologixserver || $hostname == $ecologixserverLive){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>"><a href="<?php echo base_url();?>catalogueToCash/c_receiving"><i class="fa fa-list" aria-hidden="true"></i>Receiving</a></li>
            <!-- <li style="<?php //if($hostname == $ecologixserver || $hostname == $ecologixserverLive){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>"><a href="<?php //echo base_url();?>catalogueToCash/c_technician"><i class="fa fa-list" aria-hidden="true"></i>Technician</a></li> -->
            <!-- <li style="<?php //if($hostname == $ecologixserver || $hostname == $ecologixserverLive){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>"><a href="<?php //echo base_url();?>catalogueToCash/c_Listing/lister_view"><i class="fa fa-list" aria-hidden="true"></i>Listing</a></li> -->
            <li style="<?php if($hostname == $oraserver || $hostname == $oraserverLive || $hostname == $oraserver2 || $hostname == $oraserverLive2){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>"><a href="<?php echo base_url();?>itemsToEstimate/c_itemsToEstimate"><i class="fa fa-list" aria-hidden="true"></i>Lot Purchasing</a></li>
            <li style="<?php if($hostname == $oraserver || $hostname == $oraserverLive || $hostname == $oraserver2 || $hostname == $oraserverLive2){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>"><a href="<?php echo base_url();?>itemsToEstimate/c_search_estimate"><i class="fa fa-list" aria-hidden="true"></i>Search Estimate</a></li>

            <li style="<?php if($hostname == $ecologixserver || $hostname == $ecologixserverLive){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>"><a href="<?php echo base_url();?>catalogueToCash/c_receiving/lot_items"><i class="fa fa-list" aria-hidden="true"></i>Lot Items Details</a></li>
            <!-- <li style=""><a href="<?php //echo base_url();?>catalogueToCash/c_lot_purchasing/lot_purchasing"><i class="fa fa-list" aria-hidden="true"></i>Lot Purchasing</a></li> -->
            
            <li style="<?php if($hostname == $ecologixserver || $hostname == $ecologixserverLive){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>"><a href="<?php echo base_url();?>tolist/c_tolist/bar_seed_view"><i class="fa fa-list" aria-hidden="true"></i>Seedview</a></li>

            <li style="<?php if($hostname == $oraserver || $hostname == $oraserverLive || $hostname == $oraserver2 || $hostname == $oraserverLive2){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>"><a href="<?php echo base_url();?>catalogueToCash/c_purchasing/purchasingFlag"><i class="fa fa-flag" aria-hidden="true"></i>Flags</a></li>
            <li style="<?php if($hostname == $oraserver || $hostname == $oraserverLive || $hostname == $oraserver2 || $hostname == $oraserverLive2){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>"><a href="<?php echo base_url();?>catalogueToCash/c_kitsCount/loadCounts"><i class="fa fa-list" aria-hidden="true"></i>Kits Count</a></li>
            <li style="<?php if($hostname == $oraserver || $hostname == $oraserverLive || $hostname == $oraserver2 || $hostname == $oraserverLive2){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>"><a href="<?php echo base_url();?>biddingItems/c_biddingItems/purchasing_detail"><i class="fa fa-gavel fa-bidding" aria-hidden="true"></i>Bidding &amp; Select for Purchase</a></li>
            <li style="<?php if($hostname == $oraserver || $hostname == $oraserverLive || $hostname == $oraserver2 || $hostname == $oraserverLive2){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>"><a href="<?php echo base_url();?>catalogueToCash/c_kit_analysis"><i class="fa fa-rss" aria-hidden="true"></i>KIT ANALYSIS</a></li>
             <li style="<?php if($hostname == $oraserver || $hostname == $oraserverLive || $hostname == $oraserver2 || $hostname == $oraserverLive2){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>"><a href="<?php echo base_url();?>priceVerify/c_priceVerify"><i class="fa fa-thumbs-up" aria-hidden="true"></i></i>Verify MPN Price</a></li>

             <li style="<?php if($hostname == $ecologixserver || $hostname == $ecologixserverLive){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>"><a href="<?php echo base_url();?>reports/c_offer_report/mpn_price"><i class="fa fa-thumbs-up" aria-hidden="true"></i></i>Verify MPNs </a></li>
              <li style="<?php if($hostname == $ecologixserver || $hostname == $ecologixserverLive){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>"><a href="<?php echo base_url();?>catalogueToCash/c_card_lots"><i class="fa fa-thumbs-up" aria-hidden="true"></i></i>Special Lots </a></li>
              <li><a href="<?php echo base_url();?>categories/c_categories"><i class="fa fa-list" aria-hidden="true"></i></i>Add Category Group</a></li> 
              <?php if($login_id == 2 || $login_id == 17 ){ ?>
              <li style="<?php if($hostname == $oraserver || $hostname == $oraserverLive || $hostname == $oraserver2 || $hostname == $oraserverLive2){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>"><a href="<?php echo base_url();?>catalogueToCash/c_tl_auction"><i class="fa fa-list" aria-hidden="true"></i>TL Auction</a></li>
              
             <?php } ?>
             
          </ul>
        </li>
        <!-- =====================end catalogue to cash module ============ -->
        
         <!-- =====================Start Dekiting pak us  module ============ -->
        <li class="treeview" style="<?php if($hostname == $ecologixserver || $hostname == $ecologixserverLive){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>">
          <a href="#">
            <i class="fa fa-chevron-circle-down"></i>
            <span>De-Kiting Pk-Us</span>
            <span class="pull-right-container">
              <span id="dekitMenu" class="label label-primary pull-right">
                <!-- getting values like 1, 2, 3 by JS -->
              </span>
            </span>
          </a>
          <ul id="dekitUsMenu" class="treeview-menu">
            <li><a href="<?php echo base_url();?>dekitting_pk_us/c_dekitting_us"><i class="fa fa-th-list" aria-hidden="true"></i></i>De-Kitting US</a></li>
            <li><a href="<?php echo base_url();?>dekitting_pk_us/c_pic_shoot_us"><i class="fa fa-camera" aria-hidden="true"></i>Pic-Shooting US</a></li>
            <li><a href="<?php echo base_url();?>dekitting_pk_us/c_comp_identi_pk"><i class="fa fa-list-alt" aria-hidden="true"></i></i>Comp-Identification Pk</a></li>
            <li><a href="<?php echo base_url();?>dekitting_pk_us/c_listing_pk_us"><i class="fa fa-list" aria-hidden="true"></i></i>Listing-pk-us</a></li>
            <li><a href="<?php echo base_url();?>dekitting_pk_us/c_dekit_audit/dekitAudit"><i class="fa fa-list" aria-hidden="true"></i></i>Dekit Audit</a></li>
            <li><a href="<?php echo base_url();?>ocr/c_ocr_detect_text"><i class="fa fa-list" aria-hidden="true"></i></i>Image Text Detection</a></li>
          </ul>
        </li>

         <!-- =====================end Dekiting pak us  module ============ -->
        <!-- =====================start of ebay stream menu==================-->
        <li class="treeview" style="<?php if($hostname == $oraserver || $hostname == $oraserverLive || $hostname == $oraserver2 || $hostname == $oraserverLive2){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>">
          <a href="#">
            <i class="fa fa-chevron-circle-down"></i>
            <span>eBay Stream</span>
            <span class="pull-right-container">
              <span id="streamMenu" class="label label-primary pull-right">
                <!-- getting values like 1, 2, 3 by JS -->
              </span>
            </span>
          </a>
          <ul id="eBayStreamMenu" class="treeview-menu">
        <li style="<?php if($hostname == $oraserver || $hostname == $oraserverLive || $hostname == $oraserver2 || $hostname == $oraserverLive2){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>"><a href="<?php echo base_url();?>rssfeed/c_rssfeed"><i class="fa fa-rss" aria-hidden="true"></i>eBay RSS Feed</a></li>
            <li style="<?php if($hostname == $oraserver || $hostname == $oraserverLive || $hostname == $oraserver2 || $hostname == $oraserverLive2){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>"><a href="<?php echo base_url();?>rssfeed/c_rssfeed/lookupFeed"><i class="fa fa-rss" aria-hidden="true"></i>LookUp Feed</a></li>
            <li style="<?php if($hostname == $oraserver || $hostname == $oraserverLive || $hostname == $oraserver2 || $hostname == $oraserverLive2){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>"><a href="<?php echo base_url();?>rssfeed/c_rssfeed/localFeed"><i class="fa fa-rss" aria-hidden="true"></i>Local | Dallas Feed</a></li>
            <li style="<?php if($hostname == $oraserver || $hostname == $oraserverLive || $hostname == $oraserver2 || $hostname == $oraserverLive2){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>"><a href="<?php echo base_url();?>rssfeed/c_rssfeed/categoryFeed"><i class="fa fa-rss" aria-hidden="true"></i>Category Feed</a></li>
            <li style="<?php if($hostname == $oraserver || $hostname == $oraserverLive || $hostname == $oraserver2 || $hostname == $oraserverLive2){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>"><a href="<?php echo base_url();?>rssfeed/c_rssfeed/autoBuy"><i class="fa fa-rss" aria-hidden="true"></i>Auto Buy Feed</a></li>

            <li style="<?php if($hostname == $oraserver || $hostname == $oraserverLive || $hostname == $oraserver2 || $hostname == $oraserverLive2){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>"><a href="<?php echo base_url();?>rssfeed/c_rssfeed/autoBuyauction"><i class="fa fa-rss" aria-hidden="true"></i>Auction Items</a></li>

            <li style="<?php if($hostname == $oraserver || $hostname == $oraserverLive || $hostname == $oraserver2 || $hostname == $oraserverLive2){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>"><a href="<?php echo base_url();?>rssfeed/c_rssfeed/catauction"><i class="fa fa-rss" aria-hidden="true"></i>Main Category Auction</a></li>

            <li style="<?php if($hostname == $oraserver || $hostname == $oraserverLive || $hostname == $oraserver2 || $hostname == $oraserverLive2){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>"><a href="<?php echo base_url();?>rssfeed/c_rssfeed/autoBin"><i class="fa fa-rss" aria-hidden="true"></i>Auto BIN</a></li>

            <li style="<?php if($hostname == $oraserver || $hostname == $oraserverLive || $hostname == $oraserver2 || $hostname == $oraserverLive2){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>"><a href="<?php echo base_url();?>rssfeed/c_rssfeed/addrssfeedurl"><i class="fa fa-rss" aria-hidden="true"></i>Add RSS Feed URL</a></li>
            <li style="<?php if($hostname == $oraserver || $hostname == $oraserverLive || $hostname == $oraserver2 || $hostname == $oraserverLive2){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>"><a href="<?php echo base_url();?>catalogueToCash/c_logs_analysis"><i class="fa fa-rss" aria-hidden="true"></i>LOGS ANALYSIS</a></li>
            </ul>
        </li>
        <!-- ==================end of ebay stream menu========================-->
        <li class="treeview" style="<?php if($hostname == $ecologixserver || $hostname == $ecologixserverLive){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>">
          <a href="#">
            <i class="fa fa-chevron-circle-down"></i>
            <span>Post Sale</span>
            <span class="pull-right-container">
              <span id="postMenu" class="label label-primary pull-right">
                <!-- getting values like 1, 2, 3 by JS -->
              </span>
            </span>
          </a>
          <ul id="PostSaleMenu" class="treeview-menu">
            <li><a href="<?php echo base_url();?>shipment/awaiting_shipment/downloadOrders"><i class="fa fa-cart-arrow-down"></i></i>Download Orders</a></li>
            <li><a href="<?php echo base_url();?>shipment/awaiting_shipment"><i class="fa fa-truck" aria-hidden="true"></i>Awaiting Shipment</a></li>
            <li><a href="<?php echo base_url();?>shiped/paid_shiped"><i class="fa fa-usd" aria-hidden="true"></i>Paid &amp; Shipped</a></li>
            <li><a href="<?php echo base_url();?>order_pulling/c_order_pulling"><i class="fa fa-wpforms" aria-hidden="true"></i>Order Pulling</a></li>
            <li><a href="<?php echo base_url();?>CustomerProfile/C_CustomerProfile"><i class="fa fa-users"></i>Customer Profile</a></li>

          </ul>
        </li>        


        <li class="treeview" style="<?php if($hostname == $ecologixserver || $hostname == $ecologixserverLive){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>">
          <a href="#">
            <i class="fa fa-chevron-circle-down"></i>
            <span>Transaction Form</span>
            <span class="pull-right-container">
              <span id="rsltTrans" class="label label-primary pull-right">
                <!-- getting values like 1, 2, 3 by JS -->
              </span>
            </span>
          </a>
          <ul id="TransMenu" class="treeview-menu">
            <li><a href="<?php echo base_url();?>single_entry/c_single_entry"><i class="fa fa-wpforms" aria-hidden="true"></i></i>Single Entry Form</a></li>
            <li><a href="<?php echo base_url();?>single_entry/c_single_entry/single_entry_two"><i class="fa fa-wpforms" aria-hidden="true"></i></i>Short Single Entry</a></li>

            <li><a href="<?php echo base_url();?>manifest_loading/c_manf_load"><i class="fa fa-wpforms" aria-hidden="true"></i>Manifest Loading</a></li>
            <?php 
               $login_id = $this->session->userdata('user_id');  
               if($login_id == 2 || $login_id == 17 || $login_id == 4 || $login_id == 21 ){
            ?>            
            <li><a href="<?php echo base_url();?>UnpostItem/C_UnpostItem"><i class="fa fa-trash-o" aria-hidden="true"></i>Unpost Item</a></li>
             <li><a href="<?php echo base_url();?>UnpostItem/C_UnpostItem/unpostBarcode"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete Item</a></li>
            <?php } ?>
            
          </ul>
        </li>
<!--         <li class="treeview" id="bklist">
          <a href="#" >
            <i class="fa fa-chevron-circle-down" id="bkSlide"></i>
            <span>Bundle-Kit</span>
            <span class="pull-right-container">
              <span id="bkPreMenu" class="label label-primary pull-right">
                
              </span>
            </span>
          </a>
          <ul id="bkMenu" class="treeview-menu">
            <li><a href="<?php //echo base_url();?>BundleKit/c_bkComponents"><i class="fa fa-wpforms" aria-hidden="true"></i>Components</a></li>
            <li><a href="<?php //echo base_url();?>BundleKit/c_bkTemplate"><i class="fa fa-wpforms" aria-hidden="true"></i>Templates</a></li> 
             <li><a href="<?php ////echo base_url();?>BundleKit/c_advanceCategories/"><i class="fa fa-wpforms" aria-hidden="true"></i>Search Category</a></li> 
            <li>
              <a href="<?php //echo base_url();?>BundleKit/c_bkProfiles"><i class="fa fa-wpforms" aria-hidden="true"></i>Profiles</a>
            </li>                       
             <li><a href="<?php //echo base_url();?>BundleKit/c_bk_kit"><i class="fa fa-wpforms" aria-hidden="true"></i>Kits</a></li>
             <li><a href="<?php //echo base_url();?>BundleKit/c_bk_webhook"><i class="fa fa-wpforms" aria-hidden="true"></i>webhooks</a></li>
          </ul>
        </li> -->
        <li class="treeview" style="<?php if($hostname == $ecologixserver || $hostname == $ecologixserverLive){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>">
          <a href="#">
            <i class="fa fa-chevron-circle-down"></i>
            <span>Reports</span>
            <span class="pull-right-container">
              <span id="rsltReports" class="label label-primary pull-right">
                <!-- getting values like 1, 2, 3 by JS -->
              </span>
            </span>
          </a>
          <ul id="reportMenu" class="treeview-menu">
            <li><a href="<?php echo base_url();?>lister/lister_screen/index"><i class="fa fa-list-ul" aria-hidden="true"></i>Lister View</a></li>           
            <li><a href="<?php echo base_url();?>reports/reports/manifest_pl"><i class="fa fa-file-text" aria-hidden="true"></i>Manifest P/L</a></li>
            <li><a href="<?php echo base_url();?>reports/reports/post_manifest_pl"><i class="fa fa-file-text" aria-hidden="true"></i>Post Manifest P/L Report</a></li>
            <li><a href="<?php echo base_url();?>reports/reports/sale_pl"><i class="fa fa-file-text" aria-hidden="true"></i>Sale P/L</a></li>
            <li><a href="<?php echo base_url();?>reports/c_ledgerReport"><i class="fa fa-file-text" aria-hidden="true"></i>Ledger Report</a></li>
            <li><a href="<?php echo base_url();?>reports/c_offer_report/off_report_load"><i class="fa fa-file-text" aria-hidden="true"></i>Offer Report</a></li>
            <li><a href="<?php echo base_url();?>reports/c_offer_report/load_reacvice_repo"><i class="fa fa-file-text" aria-hidden="true"></i>Reaciving Report</a></li>
            <li><a href="<?php echo base_url();?>reports/c_offer_report/post_receipt"><i class="fa fa-file-text" aria-hidden="true"></i>Post Reacipt Report</a></li>
            <li><a href="<?php echo base_url();?>reports/c_offer_report/pic_report"><i class="fa fa-file-text" aria-hidden="true"></i>Picture Report</a></li>
                        
          </ul>

        </li>
        <!--Pos Menu start-->
        <li class="treeview" style="<?php if($hostname == $ecologixserver || $hostname == $ecologixserverLive){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>">
          <a href="#">
            <i class="fa fa-chevron-circle-down"></i>
            <span>Point Of Sale</span>
            <span class="pull-right-container">
              <span id="posTree" class="label label-primary pull-right">
                
              </span>
            </span>
          </a>
          <ul id="posMenu" class="treeview-menu">
            <li><a href="<?php echo base_url();?>pos/c_pos_list/postedUnpostedData"><i class="fa fa-list-ul" aria-hidden="true"></i>POS Listing</a></li>           
            <li><a href="<?php echo base_url();?>pos/c_point_of_sale/pos_showForm"><i class="fa fa-wpforms" aria-hidden="true"></i>POS Form</a></li>
            <li><a href="<?php echo base_url();?>pos/c_pos_list/posReceiptView"><i class="fa fa-list" aria-hidden="true"></i>POS Receipt View</a></li>
            <li><a href="<?php echo base_url();?>pos/c_pos_single_entry"><i class="fa fa-wpforms" aria-hidden="true"></i>POS Single Entry</a></li>
                        
          </ul>

        </li>
        <!--Pos Menu end-->        

        <!-- Service Menu Start -->
        <li class="treeview" style="<?php if($hostname == $ecologixserver || $hostname == $ecologixserverLive){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>">
          <a href="#">
            <i class="fa fa-chevron-circle-down"></i>
            <span>Service Module</span>
            <span class="pull-right-container">
              <span id="serviceTree" class="label label-primary pull-right">
                
              </span>
            </span>
          </a>
          <ul id="serviceMenu" class="treeview-menu">
            <li><a href="<?php echo base_url();?>service/c_serviceForm/serviceView"><i class="fa fa-wpforms" aria-hidden="true"></i>Service Form</a></li> 
            <li><a href="<?php echo base_url();?>service/c_serviceReceipt/serviceReceiptView"><i class="fa fa-list" aria-hidden="true"></i>Service Receipt View</a></li>
            <li><a href="<?php echo base_url();?>service/c_serviceForm/addEquipment"><i class="fa fa-wpforms" aria-hidden="true"></i>Add Equipment</a></li>
            <li><a href="<?php echo base_url();?>service/c_serviceForm/returnShowForm"><i class="fa fa-list" aria-hidden="true"></i>Service Return</a></li>
            <li><a href="<?php echo base_url();?>service/c_partsIssue/partsIssuanceView"><i class="fa fa-wpforms" aria-hidden="true"></i>Parts Issuance Form</a></li> 
            <li><a href="<?php echo base_url();?>service/c_partsIssue/partsIssueDetailView"><i class="fa fa-wpforms" aria-hidden="true"></i>Parts Issuance Detail </a></li>                                
          </ul>

        </li>
        <!-- Service Menu End -->
        <!-- BigData Menu Start -->
        <li class="treeview" style="<?php if($hostname == $oraserver || $hostname == $oraserverLive || $hostname == $oraserver2 || $hostname == $oraserverLive2){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>">
          <a href="#">
            <i class="fa fa-chevron-circle-down"></i>
            <span>Big Data</span>
            <span class="pull-right-container">
              <span id="bigDataTree" class="label label-primary pull-right">
                
              </span>
            </span>
          </a>
          <ul id="bigDataMenu" class="treeview-menu">
            <li><a href="<?php echo base_url();?>bigData/c_bigData/addCategoryData"><i class="fa fa-wpforms" aria-hidden="true"></i>Add Category Data</a></li> 
            <li><a href="<?php echo base_url();?>bigData/c_bigData/"><i class="fa fa-list" aria-hidden="true"></i>Category Data View</a></li>
            <li><a href="<?php echo base_url();?>bigData/c_bd_recognize_data/createObject"><i class="fa fa-list" aria-hidden="true"></i>Recognize Data</a></li>
            <li><a href="<?php echo base_url();?>bigData/c_bd_recognize_data/recognizeWords"><i class="fa fa-font" aria-hidden="true"></i>Recognize Leftover Title</a></li>
            <li><a href="<?php echo base_url();?>bigData/c_bd_recognize_data/verifyData"><i class="fa fa-list" aria-hidden="true"></i>Verify Data</a></li>
            <li><a href="<?php echo base_url();?>bigData/c_bigData/categoryTreeview"><i class="fa fa-list-alt" aria-hidden="true"></i>Category Tree View</a></li>
            <li><a href="<?php echo base_url();?>bigData/c_categoryTeeList/categoryTreeview"><i class="fa fa-list-alt" aria-hidden="true"></i>Tree List</a></li>
            <li><a href="<?php echo base_url();?>catalogue/c_itemCatalogue"><i class="fa fa-list-alt" aria-hidden="true"></i>Catalogue</a></li>
            <li><a href="<?php echo base_url();?>catalogue/c_catalogueUploading"><i class="fa fa-list-alt" aria-hidden="true"></i>Catalogue Upload</a></li>
            <li><a href="<?php echo base_url();?>bigData/c_recog_title_mpn_kits"><i class="fa fa-list-alt" aria-hidden="true"></i>Recognize MPN</a></li>
            <li><a href="<?php echo base_url();?>bigData/c_autoCatalog"><i class="fa fa-list-alt" aria-hidden="true"></i>Auto Recognize MPN</a></li>
            <li><a href="<?php echo base_url();?>bigData/c_autoCatalog/specsByCategory"><i class="fa fa-list-alt" aria-hidden="true"></i>Specifics</a></li>
            <!-- <li><a href="<?php //echo base_url();?>bigData/c_bd_recognize_data/createObject"><i class="fa fa-list-alt" aria-hidden="true"></i>Create Object</a></li> -->
            <li><a href="<?php echo base_url();?>template/c_temp/object_temp"><i class="fa fa-wpforms" aria-hidden="true"></i>Object Template</a></li>
                  
          </ul>

        </li>

       
        <li class="treeview" style="<?php if($hostname == $ecologixserver || $hostname == $ecologixserverLive){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>">
          <a href="#" >
            <i class="fa fa-chevron-circle-down"></i>
            <span>Users</span>
            <span class="pull-right-container">
              <span id="preUsersMenu" class="label label-primary pull-right">
                <!-- getting values like 1, 2, 3 by JS -->
              </span>
            </span>
          </a>
          <ul id="usersMenu" class="treeview-menu">
            <?php  //if($login_id == 2 ||  $login_id == 4 || $login_id == 17 || $login_id == 21){ ?>
            <li><a href="<?php echo base_url();?>login/c_users"><i class="fa fa-wpforms" aria-hidden="true"></i>Users List</a></li>
            <?php //} ?> 
          </ul>
        </li>
                

        <!-- Service Menu End -->
        <!-- =====================Start Warehouse  module ============ -->
        <li class="treeview" style="<?php if($hostname == $ecologixserver || $hostname == $ecologixserverLive){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>">
          <a href="#">
            <i class="fa fa-chevron-circle-down"></i>
            <span>Warehouse</span>
            <span class="pull-right-container">
              <span id="wareHouse" class="label label-primary pull-right">
                <!-- getting values like 1, 2, 3 by JS -->
              </span>
            </span>
          </a>
          <ul id="warehouseMenu" class="treeview-menu">
             <li><a href="<?php echo base_url();?>locations/c_locations"><i class="fa fa-list" aria-hidden="true"></i></i>Add Warehouse</a></li>
             <li><a href="<?php echo base_url();?>locations/c_locations/view_rack"><i class="fa fa-list" aria-hidden="true"></i></i>Add Rack</a></li>
             <li><a href="<?php echo base_url();?>locations/c_locations/view_bin"><i class="fa fa-list" aria-hidden="true"></i></i>Add Bin</a></li>
             <li><a href="<?php echo base_url();?>locations/c_locations/transfer_location"><i class="fa fa-list" aria-hidden="true"></i></i>Transfer Location</a></li>
             <li><a href="<?php echo base_url();?>locations/c_locations/item_packing"><i class="fa fa-list" aria-hidden="true"></i></i>Item Packing</a></li>
             <li><a href="<?php echo base_url();?>locations/c_locations/transfer_bin"><i class="fa fa-list" aria-hidden="true"></i></i>Transfer Bin</a></li>
             <li><a href="<?php echo base_url();?>locations/c_locations/ViewPacking"><i class="fa fa-list" aria-hidden="true"></i></i>Add Packing</a></li>
             <li><a href="<?php echo base_url();?>locations/c_locations/loc_history"><i class="fa fa-list" aria-hidden="true"></i></i>Location History</a></li>
            

          </ul>
        </li>

         <!-- =====================end Warehouse  module ============ -->

        <!-- ===================== other merchant  module ============ -->
         <li class="treeview" style="<?php if($hostname == $ecologixserver || $hostname == $ecologixserverLive){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>">
          <a href="#" >
            <i class="fa fa-chevron-circle-down"></i>
            <span>Other Merchant Services</span>
            <span class="pull-right-container">
              <span id="preMerchantMenu" class="label label-primary pull-right">
                <!-- getting values like 1, 2, 3 by JS -->
              </span>
            </span>
          </a>
          <ul id="merchantMenu" class="treeview-menu">
            
            <li><a href="<?php echo base_url();?>merchant/c_merchant"><i class="fa fa-wpforms" aria-hidden="true"></i>Add Merchant</a></li>
            <li class="active"><a href="<?php echo base_url();?>merchant/c_merchant/merch_lot"><i class="fa fa-circle-o" aria-hidden="true"></i> Add Merchant Lots</a></li>
            <li><a href="<?php echo base_url();?>merchant/c_merchant/gen_barcode"><i class="fa fa-wpforms" aria-hidden="true"></i>Genrate Barcode</a></li>
           
          </ul>
        </li>
        <!-- =====================end other merchant  module ============ -->

        <!-- ===================== Shopify Item Import  module ============ -->
         <li class="treeview" style="<?php if($hostname == $ecologixserver || $hostname == $ecologixserverLive){echo 'display: none;';}elseif($hostname == $localserver || $hostname == $localserver2){ echo ""; } ?>">
          <a href="#" >
            <i class="fa fa-chevron-circle-down"></i>
            <span>Item Import Shopify</span>
            <span class="pull-right-container">
              <span id="preShopifyMenu" class="label label-primary pull-right">
                <!-- getting values like 1, 2, 3 by JS -->
              </span>
            </span>
          </a>
          <ul id="ShopifyMenu" class="treeview-menu">
            
            <li><a href="<?php echo base_url();?>shopify/c_listItemtoShopify"><i class="fa fa-shopping-bag"></i>Import Item</a></li>
            <li><a href="<?php echo base_url();?>shopify/c_ordersShopify"><i class="fa fa-shopping-bag"></i>Shopify Orders</a></li>
           
          </ul>
        </li>
        <!-- =====================end Shopify Item Import module ============ -->

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>


			
			<!-- <li class="active"><a href="<?php //echo base_url();?>dashboard/dashboard"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Dashboard</a></li>
			<li><a href="<?php //echo base_url();?>listing/listing"><svg class="glyph stroked calendar"><use xlink:href="#stroked-calendar"></use></svg>Listing Form</a></li>
			<li><a href="<?php //echo base_url();?>template/c_temp"><svg class="glyph stroked line-graph"><use xlink:href="#stroked-line-graph"></use></svg>Template Form</a></li>

			<li role="presentation" class="divider"></li>
			<li><a href="<?php //echo base_url();?>login/login/user_login"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Login Page</a></li> -->