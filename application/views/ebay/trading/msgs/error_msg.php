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
               echo $error->SeverityCode === Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning'."<br>".$error->ShortMessage."<br>".$error->LongMessage;
              ?>
            </div>
          </div>
        </div>
      </div>  
		</div>
	</section>
</div>	

<?php $this->load->view('template/footer.php'); ?>