<?php $this->load->view('template/header.php');
use \DTS\eBaySDK\Constants;
use \DTS\eBaySDK\Trading\Services;
use \DTS\eBaySDK\Trading\Types;
use \DTS\eBaySDK\Trading\Enums;
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Listing eBay
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
		<div class="row">
      <div class='col-sm-12'>
        <div class='box'>
          <div class='box box-body'>
            <div id='errorMsg' class='text-danger'>
                  

<?php 
        if(!empty($itemID)){
                  echo "
                    The item was <strong>Revised</strong> on eBay With the Following Details:<br>
                    <ul>
                        <li>Ebay Id: ".$response->ItemID."</li>
                        <li>Ebay Account: ".$account_type."</li>
                        <li>Listed By: " .$emp_name." </li>
                        <li>Timestamp: " .$response->Timestamp->format('Y-m-d H:i:s')." </li>
                    </ul>";


        }else{

          echo  "
                The item was <strong>Listed</strong> on eBay With the Following Details:<br>
                <ul>
                    <li>Ebay Id: ".$response->ItemID."</li>
                    <li>Ebay Account: ".$account_type."</li>
                    <li>Listed By: " .$emp_name." </li>
                    <li>Timestamp: " .$response->Timestamp->format('Y-m-d H:i:s')." </li>
                </ul>";                

              }
?>
  <div class="col-sm-12">
    <div class="form-group">
      <a class="btn btn-primary" href='<?php echo base_url(); ?>/listing/listing/print_label?>'>Print Sticker</a>
    </div>
  </div>

          </div>
        </div>   
      </div>
		</div>
    </div>
	</section>
</div>	

<?php $this->load->view('template/footer.php'); ?>