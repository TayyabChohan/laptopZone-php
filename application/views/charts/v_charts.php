<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Summary Data
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
              <form action="<?php echo base_url(); ?>charts/c_charts/queryData" method="post" accept-charset="utf-8">
                <div class="col-sm-5">
                  <div class="form-group">
                    <label for="Search Webhook">Search:</label>
                      <input type="text" name="bd_search" class="form-control" placeholder="Search Product" value="<?php echo htmlentities($this->session->userdata('keyword')); ?>" >    

                  </div>
                </div>  
                 <div class="col-sm-2">
                  <div class="form-group">
                    <label for="Search Webhook">Search by Seller:</label>
                      <input type="text" name="seller_search" class="form-control" placeholder="Search by Seller" value="<?php echo htmlentities($this->session->userdata('seller_id')); ?>" >    
                                        
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="Conditions" class="control-label">Category:</label>
                    <select name="bd_category" class="form-control selectpicker" required="required" data-live-search="true">
                      <!-- <option value="0">All Categories  ...</option> -->
                      <?php                                
                         if(!empty($getCategories)){

                          foreach ($getCategories as $cat){

                              ?>
                              <option value="<?php echo $cat['CATEGORY_ID']; ?>" <?php if($this->session->userdata('category_id') == $cat['CATEGORY_ID']){echo "selected";}?>> <?php echo $cat['CATEGORY_NAME'].'-'.$cat['CATEGORY_ID']; ?> </option>
                              <?php
                              } 
                          }
                      ?>  
                                          
                    </select>  
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group p-t-24">
                    <input type="submit" class="btn btn-primary btn-lg" name="bd_submit" id="bd_submit" value="Search">
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
                            
                                <input type="checkbox" name="store" value="1" <?php if(isset($_POST['store'])) echo "checked='checked'"; ?> >
                                <span >Store Inventory</span>
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox"  value= "2" name="Auction" <?php if(isset($_POST['Auction'])) echo "checked='checked'"; ?> >
                                <span >Auction</span>
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value = "3" name="Fixed" <?php if(isset($_POST['Fixed'])) echo "checked='checked'"; ?> >
                                <span >Fixed Price</span>
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value = "4" name="BIN" <?php if(isset($_POST['BIN'])) echo "checked='checked'"; ?>  >
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
                    
                        <input type="text" name ="end_one" class="form-control input-lg" VALUE="<?php echo  $this->session->userdata('end_one');?>"  />
                        <span class="input-group-addon" style="border-left: 0; border-right: 0;">To</span>
                        <input type="text" name ="end_two" class="form-control input-lg" VALUE="<?php echo  $this->session->userdata('end_two');?>" />
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

                          <?php $rslt = $this->session->userdata('date_r'); ?>
                          <input type="text" class="btn btn-default" name="date_ranges" id="r_date_range" value="<?php echo $rslt; ?>" />




                            </div>
                      <div class="checkbox" style="color:red;font-size: 12px;">
                            <label>
                                <input type="checkbox" value = "5" name="Skip" <?php if(isset($_POST['Skip'])) echo "checked='checked'"; ?>  >
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
                      
                    <select name="item_con" class="form-control"  >
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


         
<!-- 
  ***********************************************
  **************Start Summary Cards**************
 -->
 <!-- Main content -->
    <section class="content-header">
      <!-- Small boxes (Stat box) -->
      <?php if(!empty(@$data)):?> 
      <div class="row">
      <?php foreach ($data as $value):
  $total_Records = $value['TOAL_RECORDS'];
  $Total_Merchants = $value['TOTAL_MERCHANTS'];
  $Total_sale_value = $value['TOTAL_SALE_VALUE'];
  $AVERAGE_PRICE = $value['AVERAGE_PRICE'];
  $verified = $value['VERIFIED'];
  $no_items = $value['NO_ITEMS'];
   
  ?>
  <?php endforeach;?> 
        <div class="col-lg-2 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
            
      <p style="font-size:18px;"><?php echo $total_Records ?></p>

              <p>Total Records</p>
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
          <div class="small-box bg-green">
            <div class="inner">
              <p style="font-size:18px;"><?php echo $Total_Merchants ?></p>

              <p>Total Merchants</p>
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
          <div class="small-box bg-yellow">
            <div class="inner">

              <p style="font-size:18px;">$ <?php echo number_format((float)@$AVERAGE_PRICE,2,'.',',');?></p>

              <p>Average Price</p>
            </div>
            <div class="icon">
              <i class="fa fa-money fa-1x" aria-hidden="true"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-2 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <p style="font-size:18px;">$ <?php echo number_format((float)@$Total_sale_value,2,'.',',');?></p>

              <p>Total Sale Value</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-orange">
            <div class="inner">
              <p style="font-size:18px;"><?php echo $no_items ?></p>

              <p >No OF Items</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-orange">
            <div class="inner">
                

  <p style="font-size:18px;"><?php echo $verified?></p>
              <p>Total Verified </p>
            
            </div>
            <div class="icon">
              <i class="fa fa-check"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        

     
      </div>
       
      </section>


<!--*************End Summry Cards****************
  ***********************************************
 -->
<!--  *****************OVERVIEW START**************
 *********************************************
 -->
 <section class="content">
<div class="row">
  <div class="col-sm-6">
  
  <div class="box box-success" >
  <div class="box" >
            <div class="box-header">
              <h3 class="box-title">Top Ten Sellers</h3>

              <!-- <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div> -->
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding" style="height:250px;">
              <!-- <table class="table table-hover">
                -->

                 <table  class="table table-responsive table-striped table-bordered table-hover" >
                    <thead>
                       
                        <th><div class="text-left">Seller Name</div></th>
                        <th><div class="text-center">Items Sold</div></th>
                        <th><div class="text-center">Total Sale value</div></th>
                        
                        
                                                
                    </thead>
                     <tbody>
                <?php foreach ($top as $value):?>
              
                    <tr>
                        
                    <td><div style="font-size: 16px;"><?php echo $value['SELLER_ID']; ?></div></td>
                    <td><div  class="pull-right" style="font-size: 18px;"><?php echo $value['ITEMS_SOLD'];  ?></div></td>
                    <td><div class="pull-right" style="font-size: 18px;">$ <?php echo number_format((float)@$value['SALE'],2,'.',',');  ?></div></td>
                    
                      
                                                   
                    </tr>
                <?php endforeach;?>        
                   </tbody> 
                  </table> 
            </div>
            <!-- /.box-body -->
          </div>
    </div>  


  </div>
  <div class="col-sm-6">
  

<div class="box box-danger">

 <div class="box" >
            <div class="box-header">
              <h3 class="box-title">Days Of Week</h3>

              <!-- <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div> -->
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding" style="height:250px;">
              <!-- <table class="table table-hover">
                -->

                 <table  class="table table-responsive table-striped table-bordered table-hover" >
                    <thead>
                       
                        <th><div class="text-center">Days Of Weeks</div></th>
                        <th><div class="text-center">Total Sales</div></th>
                          <th><div class="text-center">Average Price</div></th>
                      
                        
                                                
                    </thead>
                     <tbody>
                <?php foreach ($total_sales as $value):?>
              
                        <tr>
                        
                           <td><div style="font-size: 16px;"><?php echo $value['DAY_OF_WEEK']; ?></div></td>
                           
                        <td><div class="pull-right" style="font-size: 18px;">$ <?php echo number_format((float)@$value['TOT_SALE'],2,'.',',');  ?></div></td>
                          <td><div class="pull-right" style="font-size: 18px;">$ <?php echo number_format((float)@$value['AVERAGE_SALES'],2,'.',',');  ?></div></td>
                          
                           
                           
                        </tr>
                <?php endforeach;?>             
                   </tbody> 
                  </table> 
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

              <h3 class="box-title">Day Wise Graph </h3>

                          </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <!-- <table class="table table-hover">
                -->
<canvas id="mycanvas"></canvas>
            </div>
            <!-- /.box-body -->
          </div>
    </div>  


  </div>
  <div class="col-sm-6">
  
  <div class="box box-success">
 <div class="box">
            <div class="box-header">
              <h3 class="box-title">General Stats</h3>

                          </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <!-- <table class="table table-hover">
                -->

                 <table  class="table table-responsive table-striped table-bordered table-hover" >
                    <thead>
                     <th><div class="text-center">Listing Types </div></th>
                          <th><div class="text-center">Sale Value</div></th>
                       
                                                
                    </thead>
                     <tbody>
                <?php foreach ($List_type as $value):?>
              
                        <tr>
                        
                       
                           <td><div style="font-size: 16px;"><?php echo $value['LISTING_TYPE']; ?></div></td>
                           <td><div class="pull-right" style="font-size: 18px;">$ <?php echo number_format((float)@$value['TOTAL_SALE_VALUE'],2,'.',',');  ?></div></td>
                                                   
                        </tr>
                <?php endforeach;?>        
                   </tbody> 
                  </table> 
            </div>
            <!-- /.box-body -->
          </div>
    </div>  


  </div>
  
</div>
</section>

<section class="content">
<div class="row">
  
  
</div>
</section>

 <?php endif; ?> 



 
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
     
        url: 'graph_week_days',
        method: "GET",
         dataType: "json",
          success: function(data) {
 //var data = jQuery.parseJSON(data);
 //alert(data[0].LABLES);
      var player = [];
      var score = [];

      for(var i in data) {
        player.push(data[i].LABLES);
        score.push(data[i].SALES);
      }

      var chartdata = {
        labels: player,
        datasets : [
          {
            label: 'Days of Weeks $',
            backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#3e95cd","#3cba9f",],

                         
             borderWidth: 1,
            
            data: score
          }
        ]
      };

      var ctx = $("#mycanvas");

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


<script >

  $(function() {
      //Date range as a button
      $('#r_date_range').daterangepicker(
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
