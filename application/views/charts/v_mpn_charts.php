<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         MPN Summary Data
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Search &amp; Recognize Data</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content-header">
         
      <div class="row">
        <div class="col-sm-12">
          <div class="box">      
            <div class="box-body"> 

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
            <!-- </div> --> 

            <div class="col-sm-12">
              <form action="<?php echo base_url(); ?>charts/c_mpn_charts/mpnData" method="post" accept-charset="utf-8">
               <!--  <div class="col-sm-5">
                  <div class="form-group">
                    <label for="Search Webhook">Search:</label>
                      <input type="text" name="bd_mpn_search" class="form-control" placeholder="Search Product" value="<?php //echo htmlentities($this->session->userdata('keyword')); ?>" >    

                  </div>
                </div>  --> 
                 <div class="col-sm-4">
                  <div class="form-group">
                    <label for="Search Webhook">Search by Merchant:</label>
                      <input type="text" name="seller_mpn_id" class="form-control" placeholder="Search by Merchant" value="<?php echo htmlentities($this->session->userdata('seller_mpn_id')); ?>" >    
                                        
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="Conditions" class="control-label">Category:</label>
                    <select name="bd_mpn_category" class="form-control selectpicker" required="required" data-live-search="true">
                      <!-- <option value="0">All Categories  ...</option> -->
                      <?php                                
                         if(!empty($getCategories)){

                          foreach ($getCategories as $cat){

                              ?>
                              <option value="<?php echo $cat['CATEGORY_ID']; ?>" <?php if($this->session->userdata('bd_mpn_category') == $cat['CATEGORY_ID']){echo "selected";}?>> <?php echo $cat['CATEGORY_NAME'].'-'.$cat['CATEGORY_ID']; ?> </option>
                              <?php
                              } 
                          }
                      ?>  
                                          
                    </select>  
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group p-t-24">
                    <input type="submit" class="btn btn-primary btn-lg" name="bd_mpn_submit" id="bd_submit" value="Search">
                  </div>
                </div>

                                                        
            </div>


          </div>
            <!-- /.box-body -->       
        </div>
         

      </div>
        <!-- /.col -->
    </div>
      <!-- /.row -->
  </section>

<!--  ***********************************
      **********Filer Criteria*********** -->
<section class="content">
  

<div class ="row">
 <div class="panel panel-info ">
  <div class="panel-body">
   


  
<div class="col-lg-2 col-sm-4 col-xs-12">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <i class="fa fa-list fa-2x"></i>
                       
                        <span style="font-size:18px;">Listing Types</span>
                        <!-- <a href="javascript:void(0);" class="right reset-self-filter js-reset-self-filter" data-filtertype="listing-type"><i class="tp-icon-blocked2"></i></a -->
                    </div>
                    <div class="panel-body">
                        <div class="checkbox">
                            <label>
                            
                                <input type="checkbox" name="mpn_store" value="1" <?php if(isset($_POST['mpn_store'])) echo "checked='checked'"; ?> >
                                <span >Store Inventory</span>
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox"  value= "2" name="mpn_Auction" <?php if(isset($_POST['mpn_Auction'])) echo "checked='checked'"; ?> >
                                <span >Auction</span>
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value = "3" name="mpb_Fixed" <?php if(isset($_POST['mpb_Fixed'])) echo "checked='checked'"; ?> >
                                <span >Fixed Price</span>
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value = "4" name="mpn_BIN" <?php if(isset($_POST['mpn_BIN'])) echo "checked='checked'"; ?>  >
                                <span >Auction With BIN</span>
                            </label>
                        </div>
                       
                      
                    </div>
                </div>
            </div>

 
            <div class="col-lg-2 col-sm-4 col-xs-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <i class="fa fa-money fa-2x"></i>
                        <span style="font-size:18px;">Price Ranges</span>
                        <!-- <a href="javascript:void(0);" class="right reset-self-filter js-reset-self-filter" data-filtertype="start-price"><i class="tp-icon-blocked2"></i></a> -->
                    </div>
                    <div class="panel-body">
                        <div class="form-group ">
                           
                      <div class="input-group" >
                    
                        <input type="text" name ="mpn_start" class="form-control input-lg" VALUE="<?php echo  $this->session->userdata('mpn_start');?>"  />
                        <span class="input-group-addon" style="border-left: 0; border-right: 0;">To</span>
                        <input type="text" name ="mpn_end" class="form-control input-lg" VALUE="<?php echo  $this->session->userdata('mpn_end');?>" />
                      </div>
                        </div>
                    </div>
                </div>
            </div>  
            
           <div class="col-lg-3 col-sm-4 col-xs-12">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <i class="fa fa-calendar fa-2x"></i>
                        <span style="font-size:18px;">Date </span>
                        <!-- <a href="javascript:void(0);" class="right reset-self-filter js-reset-self-filter" data-filtertype="start-price"><i class="tp-icon-blocked2"></i></a> -->
                    </div>
                    <div class="panel-body">
                        <div class="form-group ">
                           
                   <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>

                          
                          <?php $rslt = $this->session->userdata('date2_r'); ?>
                          <input type="text" class="btn btn-default" name="mpn_date_range" id="mpn_date_range" value="<?php echo $rslt; ?>" />




                            </div>
                      <div class="checkbox" style="color:red;font-size: 12px;">
                            <label>
                                <input type="checkbox" value = "5" name="mpn_Skip"  <?php if(isset($_POST['mpn_Skip'])) echo "checked='checked'"; ?>  >
                                <span >Skip Date</span>
                            </label>
                      </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-4 col-xs-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <i class="fa fa-gift fa-2x"></i>
                        <span style="font-size:18px;">Item Condition </span>
                        <!-- <a href="javascript:void(0);" class="right reset-self-filter js-reset-self-filter" data-filtertype="start-price"><i class="tp-icon-blocked2"></i></a> -->
                    </div>
                    <div class="panel-body">
                       <div class="form-group">

                    <select name="mpn_item_con" class="form-control">
<option value="">All Conditions  ...</option>
        <?php
            $options = array("For parts or not working", "Used", "Manufacturer refurbished","New","Seller refurbished");
            foreach($options as $option){
                if($_POST['mpn_item_con'] == $option){
                    echo '<option selected="selected">' .$option. '</option>';
                }else{
                    echo '<option>' .$option. '</option>';
                }
            }
        ?>
    </select>
                    
                  </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-sm-12 col-xs-12 filter-footer text-right">
                <!-- <button type="reset" class="btn btn-default"><i class="fa fa-ban"></i> <span >Clear Filters</span></button> -->
                <!--                <button type="button" class="btn btn-default js-mobi-close-filter"><i class="icon-times"></i> Close Filters</button>-->
                
                <!-- <input type="submit" class="btn btn-primary " name="crit_submit" id="crit_submit" value="Apply Filter"> -->
            </div>

        </form>

</div>
</div>
</div>
</section>
  


<!--  **********************************
      *********end Filer Criteria*******-->

<!--  -->

<?php if(!empty(@$get_cards_data)){
  ?>
  <!-- 
  ***********************************************
  **************Start Summary Cards**************
 -->
 <!-- Main content -->
    <section class="content-header">
      <!-- Small boxes (Stat box) -->
      
      
      <div class="row">
       <div class="col-sm-12">
        <div class="box box-success">
          <div class="box-body">

      <?php foreach ($get_cards_data as $value):
  $TOTAL_SALE_VALUE = $value['TOTAL_SALE_VALUE'];
  $AVERAGE_PRICE = $value['AVERAGE_PRICE'];
  $SALE_UNIT = $value['SALE_UNIT'];
  
  $MIN_SALE_VALUE = $value['MIN_SALE'];
  $MAX_SALE_VALUE = $value['MAX_SALE'];
   
  ?>
  <?php endforeach;?> 
      
        <div class="col-lg-2">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
            
     
      <p style="font-size:18px;">$ <?php echo number_format((float)@$TOTAL_SALE_VALUE,2,'.',',');?></p>

              <p>Total Sale Price</p>
            </div>
            <div class="icon">
              <i class="fa fa-money fa-1x" aria-hidden="true"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-2 col-xs-6">
          
          <div class="small-box bg-green">
            <div class="inner">
              <p style="font-size:18px;"><?php echo $AVERAGE_PRICE; ?></p>

              <p>AVERAGE PRICE</p>
            </div>
            <div class="icon">
              <i class="fa fa-user fa-1x" aria-hidden="true"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-2 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-navy">
            <div class="inner">
              <p style="font-size:18px;"><?php echo $SALE_UNIT; ?></p>
              

              <p>Total Sale Unit</p>
            </div>
            <div class="icon">
            <i class="fa fa-cube fa-1x"  aria-hidden="true"></i>
              
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-2 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <p style="font-size:18px;">$ <?php echo number_format((float)@$MIN_SALE_VALUE,2,'.',',');?></p>

              <p>Min Sale Value</p>
            </div>
            <div class="icon">
              <i class="fa fa-arrow-down"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-olive">
            <div class="inner">
              <p style="font-size:18px;">$ <?php echo number_format((float)@$MAX_SALE_VALUE,2,'.',',');?></p>

              <p >Max Sale Value</p>
            </div>
            <div class="icon">
              <i class="fa fa-arrow-up"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        
        <!-- ./col -->
        </div>
        </div>

     </div>
      </div>
       
      </section>

      



<section class="content">
<div class="row">

  <div class="col-sm-6">
  
  <div class="box box-success">
 <div class="box">
            <div class="box-header">

              <h3 class="box-title">Sale Price</h3>

                          </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <!-- <table class="table table-hover">
                -->
<canvas id="mpnsale"></canvas>
            </div>
            <!-- /.box-body -->
          </div>
    </div>  


  </div>
  <div class="col-sm-6">
  
  <div class="box box-success">
 <div class="box">
            <div class="box-header">

              <h3 class="box-title">Sale Unit </h3>

                          </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <!-- <table class="table table-hover">
                -->
<canvas id="mpnunit"></canvas>
            </div>
            <!-- /.box-body -->
          </div>
    </div> 


  </div>
  
</div>
</section>
<section class="content">
<div class="row">

  <div class="col-sm-6">
  
  <div class="box box-success">
 <div class="box">
            <div class="box-header">

              <h3 class="box-title">Averg Sale Price</h3>

                          </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <!-- <table class="table table-hover">
                -->
<canvas id="mpnavg"></canvas>
            </div>
            <!-- /.box-body -->
          </div>
    </div>  


  </div>
  <div class="col-sm-6">
   <div class="box box-success">
 <div class="box">
            <div class="box-header">

              <h3 class="box-title">Conditon wise Sale Price</h3>

                          </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <!-- <table class="table table-hover">
                -->
<canvas id="mpn_cond_salevalue"></canvas>
            </div>
            <!-- /.box-body -->
          </div>
    </div>  
 


  </div>
  
</div>
</section>
<section class="content">
<div class="row">

  <div class="col-sm-6">
  
  <div class="box box-success">
 <div class="box">
            <div class="box-header">

              <h3 class="box-title">Conditoin Wise Sale UNIT</h3>

                          </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <!-- <table class="table table-hover">
                -->
<canvas id="mpn_sale_unit"></canvas>
            </div>
            <!-- /.box-body -->
          </div>
    </div>  


  </div>
  <div class="col-sm-6">
   <div class="box box-success">
 <div class="box">
            <div class="box-header">

            <!--   <h3 class="box-title">Conditon wise Sale Price</h3> -->

                          </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <!-- <table class="table table-hover">
                -->
<canvas //id="mpn_cond_salevalue"></canvas>
            </div>
            <!-- /.box-body -->
          </div>
    </div>  
 


  </div>
  
</div>
</section>

<?php } ?>


 
 <!-- 
  *****************OVERVIEW END**************
 ********************************************* -->
  <?php 
      $this->session->unset_userdata('webhook_condition');
      $this->session->unset_userdata('webhook_status');
      $this->session->unset_userdata('webhook_id');
   ?>
    <!-- /.content -->
</div>

<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>

<script>
$(document).ready(function(){
    $.ajax({
        //dataType: 'json',
        
       

        url: '<?php echo base_url(); ?>charts/c_mpn_charts/mpn_sale_value',
        method: "GET",
         dataType: "json",
          success: function(data) {
 //var data = jQuery.parseJSON(data);
 //alert(data[0].MPN);
      var mp = [];
      var sa = [];

      for(var i in data) {
        mp.push(data[i].MPN);
        sa.push(data[i].SALE_VALUE);
      }

      var chartdata = {
        labels: mp,
        datasets : [
          {
            label: 'Sale Price $',
            // backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#3e95cd","#3cba9f",],
             fillColor : "rgba(220,220,220,0.2)",
                        strokeColor : "rgba(220,220,220,1)",
                        pointColor : "rgba(220,220,220,1)",
                        pointStrokeColor : "#fff",
                        pointHighlightFill : "#fff",
                        pointHighlightStroke : "rgba(220,220,220,1)",

                         
             borderWidth: 8,
             borderColor: "#3e95cd",
      
            
            data: sa
          }
        ]
      };

      var ctx = $("#mpnsale");
      console.log(Chart.defaults.global);
      var barGraph = new Chart(ctx, {
        type: 'line',
        data: chartdata
      });
    },
    error: function(data) {
      console.log(data);
    }
  });
});


</script>
 

<script>
$(document).ready(function(){
    $.ajax({
        //dataType: 'json',
     
        url: '<?php echo base_url(); ?>charts/c_mpn_charts/mpn_sale_unit',
        method: "GET",
         dataType: "json",
          success: function(data) {
 // var data = jQuery.parseJSON(data);
 // alert(data[0].MPN);
      var mp = [];
      var sa = [];

      for(var i in data) {
        mp.push(data[i].MPN);
        sa.push(data[i].SALE_UNIT);
      }

      var chartdata = {
        labels: mp,
        datasets : [
          {
            label: 'Sale Unit',
             backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#3e95cd","#3cba9f",],

                         
             borderWidth: 2,
            
        
            
            data: sa
          }
        ]
      };

      var ctx = $("#mpnunit");

      var barGraph = new Chart(ctx, {
        type: 'bar',
        data: chartdata
      });
    },
    error: function(data) {
      console.log(data);
    }
  });
});


</script>

<script>
$(document).ready(function(){
    $.ajax({
        //dataType: 'json',
     
        url: '<?php echo base_url(); ?>charts/c_mpn_charts/mpn_avg_sale',
        method: "GET",
         dataType: "json",
          success: function(data) {
 // var data = jQuery.parseJSON(data);
 // alert(data[0].MPN);
      var mp = [];
      var sa = [];

      for(var i in data) {
        mp.push(data[i].MPN);
        sa.push(data[i].AVG_SALE);
      }

      var chartdata = {
        labels: mp,
        datasets : [
          {
            label: 'Sale Price',
           
                      
                     
                        
                  
             borderWidth: 3,
             borderColor: "#3cba9f",
            
            data: sa
          }
        ]
      };

      var ctx = $("#mpnavg");

      var barGraph = new Chart(ctx, {
        type: 'line',
        data: chartdata
      });
    },
   options: {
        scales: {
            xAxes: [{
                ticks: {
                min: 0
                }
            }],
            yAxes: [{
              stacked: false
            }]
        }

    }
  });
});


</script>

<script>
$(document).ready(function(){
    $.ajax({
        //dataType: 'json',
     
        url: '<?php echo base_url(); ?>charts/c_mpn_charts/mpn_cond_wise_salevalue',
        method: "GET",
         dataType: "json",
          success: function(data) {
 // var data = jQuery.parseJSON(data);
 // alert(data[0].MPN);
      var mp = [];
      var sa = [];

      for(var i in data) {
        mp.push(data[i].MPN);
        sa.push(data[i].SALE_VALUE);
      }

      var chartdata = {
        labels: mp,
        datasets : [
          {
            label: 'Sale Price',
            backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#3e95cd","#3cba9f",],

                         
             borderWidth: 2,
                      
                     
                        
          
             
            
            data: sa
          }
        ]
      };

      var ctx = $("#mpn_cond_salevalue");

      var barGraph = new Chart(ctx, {
        type: 'bar',
        data: chartdata
      });
    },
   options: {
        scales: {
            xAxes: [{
                ticks: {
                min: 0
                }
            }],
            yAxes: [{
              stacked: false
            }]
        }

    }
  });
});


</script>
<script>
$(document).ready(function(){
    $.ajax({
        //dataType: 'json',
     
        url: '<?php echo base_url(); ?>charts/c_mpn_charts/mpn_cond_wise_saleunit',
        method: "GET",
         dataType: "json",
          success: function(data) {
 // var data = jQuery.parseJSON(data);
 // alert(data[0].MPN);
      var mp = [];
      var sa = [];

      for(var i in data) {
        mp.push(data[i].MPN);
        sa.push(data[i].SALE_UNIT);
      }

      var chartdata = {
        labels: mp,
        datasets : [
          {
            label: 'Sale Unit',
            backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#3e95cd","#3cba9f",],

                         
             borderWidth: 2,
                      
                     
                        
          
             
            
            data: sa
          }
        ]
      };

      var ctx = $("#mpn_sale_unit");

      var barGraph = new Chart(ctx, {
        type: 'bar',
        data: chartdata
      });
    },
   options: {
        scales: {
            xAxes: [{
                ticks: {
                min: 0
                }
            }],
            yAxes: [{
              stacked: false
            }]
        }

    }
  });
});


</script>


<script >

  $(function() {
      //Date range as a button
      $('#mpn_date_range').daterangepicker(
          {

            ranges: {
              'Today': [moment(), moment()],
              'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            //   'Last 3 Days': [moment().subtract(3, 'days'), moment()],
               'Last 7 Days': [moment().subtract(6, 'days'), moment()],
               'Last 30 Days': [moment().subtract(29, 'days'), moment()],
               'This Month': [moment().startOf('month'), moment().endOf('month')],
               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
             },

            // startDate: moment().subtract(29, 'days'),
            // endDate: moment()
          },
          function (start, end) {
            $('#r_date_range').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
          }
      );

  });


</script>