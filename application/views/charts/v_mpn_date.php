<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         MPN Date Wise Summary
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Search &amp; Recognize Data</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content">
         
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
              <form action="<?php echo base_url(); ?>charts/c_mpn_date/mpn_date_data" method="post" accept-charset="utf-8">
               <!--  <div class="col-sm-5">
                  <div class="form-group">
                    <label for="Search Webhook">Search:</label>
                      <input type="text" name="bd_mpn_search" class="form-control" placeholder="Search Product" value="<?php //echo htmlentities($this->session->userdata('keyword')); ?>" >    

                  </div>
                </div>  --> 
                 <div class="col-sm-4">
                  <div class="form-group">
                    <label for="Search Webhook">Search by MPN:</label>
                      <input type="text" name="seller_mpn_date_id" class="form-control" placeholder="Search by MPN" value="<?php echo htmlentities($this->session->userdata('seller_mpn_date_id')); ?>" >    
                                        
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="Conditions" class="control-label">Category:</label>
                    <select name="bd_mpn_date_category" class="form-control selectpicker" required="required" data-live-search="true">
                      <!-- <option value="0">All Categories  ...</option> -->
                      <?php                                
                         if(!empty($getCategories)){

                          foreach ($getCategories as $cat){

                              ?>
                              <option value="<?php echo $cat['CATEGORY_ID']; ?>" <?php if($this->session->userdata('bd_mpn_date_category') == $cat['CATEGORY_ID']){echo "selected";}?>> <?php echo $cat['CATEGORY_NAME'].'-'.$cat['CATEGORY_ID']; ?> </option>
                              <?php
                              } 
                          }
                      ?>  
                                          
                    </select>  
                  </div>
                </div>
  
                <div class="col-sm-2">
                  <div class="form-group p-t-24">
                    <input type="submit" class="btn btn-primary btn-lg" name="bd_mpn_date_submit" id="bd_submit" value="Search">
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
 
  

<div class ="row">
<div class="col-sm-12">
 <div class="box">
  <div class="box-body">
   


  
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
                            
                                <input type="checkbox" name="mpn_date_store" value="1" <?php if(isset($_POST['mpn_date_store'])) echo "checked='checked'"; ?> >
                                <span >Store Inventory</span>
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox"  value= "2" name="mpn_date_Auction" <?php if(isset($_POST['mpn_date_Auction'])) echo "checked='checked'"; ?> >
                                <span >Auction</span>
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value = "3" name="mpb_date_Fixed" <?php if(isset($_POST['mpb_date_Fixed'])) echo "checked='checked'"; ?> >
                                <span >Fixed Price</span>
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value = "4" name="mpn_date_BIN" <?php if(isset($_POST['mpn_date_BIN'])) echo "checked='checked'"; ?>  >
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
                    
                        <input type="text" name ="mpn_date_start" class="form-control input-lg" VALUE="<?php echo  $this->session->userdata('mpn_date_start');?>"  />
                        <span class="input-group-addon" style="border-left: 0; border-right: 0;">To</span>
                        <input type="text" name ="mpn_date_end" class="form-control input-lg" VALUE="<?php echo  $this->session->userdata('mpn_date_end');?>" />
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
                  <!-- date set last 3month s -->
                          <?php $rslt = $this->session->userdata('date3_r'); ?>
                          <input type="text" class="btn btn-default" name="mpn_date_sum" id="mpn_date_sum" value="<?php echo $rslt; ?>" />




                            </div>
                      <div class="checkbox" style="color:red;font-size: 12px;">
                            <label>
                                <input type="checkbox" value = "5" name="mpn_date_Skip" <?php if(isset($_POST['mpn_date_Skip'])) echo "checked='checked'"; ?>  >
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

                    
                    <!-- <select name="mpn_date_itssem_con" class="form-control"  >
                      <option value="" selected="selected">Null</option>
                      <option value="For parts or not working" selected="selected">For parts or not working</option>
                      <option value="Used" selected="selected">Used</option>
                      <option value="Manufacturer refurbished">Manufacturer refurbished</option>
                      <option value="New">New</option>
                      <option value="Seller refurbished">Seller refurbished</option>
                                          
                    </select> -->  

<select name="mpn_date_item_con" class="form-control">
<option value="">All Conditions  ...</option>
        <?php
            $options = array("For parts or not working", "Used", "Manufacturer refurbished","New","Seller refurbished");
            foreach($options as $option){
                if($_POST['mpn_date_item_con'] == $option){
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
</div>
</section>
  



<!--  **********************************
      *********end Filer Criteria*******-->

<?php if(!empty(@$get_date_cards_data)){
  ?>

<?php foreach ($get_date_last_month as $value):
  $AVERAGE_PRICE = $value['AVERAGE_PRICE'];
  
  // var_dump($AVERAGE_PRICE);
  // exit;
   
  ?>
  <?php endforeach;?> 
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

      <?php foreach ($get_date_cards_data as $value):
  $TOTAL_SALE_VALUE = $value['TOTAL_SALE_VALUE'];
  $SELLER = $value['SELLER'];
  $SALE_UNIT = $value['SALE_UNIT'];
  
  $MIN_SALE_VALUE = $value['MIN_SALE_VALUE'];
  $MAX_SALE_VALUE = $value['MAX_SALE_VALUE'];
   
  ?>
  <?php endforeach;?> 
        <div class="col-lg-2">
          <!-- small box -->
          <div class="small-box bg-maroon">
            <div class="inner">
            
     
      <p style="font-size:18px;">$ <?php echo number_format((float)@$AVERAGE_PRICE,2,'.',',');?></p>

              <p>Average Price.(Last 31 Days)</p>
              
            </div>
            <div class="icon">
              <i class="fa fa-money fa-1x" aria-hidden="true"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
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
              <p style="font-size:18px;"><?php echo $SELLER; ?></p>

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


<!--*************End Summry Cards****************
  ***********************************************
 -->
<!--********Average Price Month wise***** Start*** -->
        <section class="content-header">
          <div class="row">
              <div class="col-sm-6">
                <div class="box">
                  <div class="box-body">
                    <canvas id="mpn_date_sale"></canvas>
                  </div>
                </div>
              </div>
              <!-- Average price year wise -->
              <div class="col-sm-6">
                <div class="box">
                  <div class="box-body">
                    <canvas id="mpn_date_unit"></canvas>
                  </div>
                </div>
              </div>
          </div>
        </section>
<!--********Average Price Month wise***** End*** -->

<!--********Average Price week wise***** Start*** -->
        <section class="content-header">
          <div class="row">
              <div class="col-sm-6">
                <div class="box">
                  <div class="box-body">
                    <canvas id="mpn_date_avg"></canvas>
                  </div>
                </div>
              </div>
              <!-- average wise top merchant -->
              <div class="col-sm-6">
                <div class="box">
                  <div class="box-body">
                    <canvas id="mpn_date_top_seller"></canvas>
                  </div>
                </div>
              </div>
          </div>
        </section>
<!--********Average Price week wise***** End*** -->

<!--********Total Sale Conditoin Wise***** Start*** -->
        <section class="content-header">
          <div class="row">
              <div class="col-sm-6">
                <div class="box">
                  <div class="box-body">
                    <canvas id="mpn_date_cond_sale_value"></canvas>
                  </div>
                </div>
              </div>
              <!-- Cond Wise Sale Unit -->
              <div class="col-sm-6">
                <div class="box">
                  <div class="box-body">
                    <canvas id="mpn_date_cond_sale_unit"></canvas>
                  </div>
                </div>
              </div>
          </div>
        </section>
<!--********Total Sale Conditoin Wise***** End*** -->

<!--********Total Sale day Wise***** Start*** -->
        <section class="content-header">
          <div class="row">
              <div class="col-sm-6">
                <div class="box">
                  <div class="box-body">
                    <canvas id="mpn_date_day_sale_value"></canvas>
                  </div>
                </div>
              </div>
              <!-- day Wise Sale Unit -->
              <div class="col-sm-6">
                <div class="box">
                  <div class="box-body">
                    <canvas id="mpn_date_day_saleunit"></canvas>
                  </div>
                </div>
              </div>
          </div>
        </section>
<!--********Total Sale day Wise***** End*** -->
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
        
       

        url: '<?php echo base_url(); ?>charts/c_mpn_date/mpn_date_sale_value',
        method: "GET",
         dataType: "json",
          success: function(data) {
 //var data = jQuery.parseJSON(data);
 //alert(data[0].MPN);
      var mp = [];
      var sa = [];

      for(var i in data) {
        mp.push(data[i].WEK);
        sa.push(data[i].SALE_VALUE);
      }

      var chartdata = {
        labels: mp,
        datasets : [
          {
            label: 'Average Price $',
            // backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#3e95cd","#3cba9f",],
           
             borderColor: "#107898",
            fill: false,

            
            data: sa
          }
        ]
      };

      var ctx = $("#mpn_date_sale");
      console.log(Chart.defaults.global);
      var barGraph = new Chart(ctx, {
         type: 'line',
        data: chartdata,

         options: 
        {
            title: {
              display: true,
              //position:'left',
              text: 'Average Price (Month Wise)',
              fontColor: '#107898',
              fontSize:18
            },

            scales: {
              yAxes: [{
              stacked: true
              }]
            },
            
            legend: {
              display: true,

              labels: {
              
              fontSize:14,
              }
            }
            


            //showLines: false,

        }
      });
    },
   
  });
});


</script>
 

<script>
$(document).ready(function(){
    $.ajax({
        //dataType: 'json',
     
        url: '<?php echo base_url(); ?>charts/c_mpn_date/mpn_date_sale_unit',
        method: "GET",
         dataType: "json",
          success: function(data) {
 // var data = jQuery.parseJSON(data);
 // alert(data[0].MPN);
      var mp = [];
      var sa = [];

      for(var i in data) {
        mp.push(data[i].WEK);
        sa.push(data[i].SALE_VALUE);
      }

      var chartdata = {
        labels: mp,
        datasets : [
          {
            label: 'Average Price $',
             backgroundColor: ["#5C6BC0", "#607D8B","#D81B60","#e8c3b9","#c45850","#3e95cd","#3cba9f",],

                         
             borderWidth: 2,
            
        
            
            data: sa
          }
        ]
      };

      var ctx = $("#mpn_date_unit");

      var barGraph = new Chart(ctx, {
        type: 'bar',
        data: chartdata,
         options: 
        {
            title: {
              display: true,
              //position:'left',
              text: 'Average Price (Year Wise)',
              fontColor: '#5C6BC0',
              fontSize:18
            },

            scales: {
              yAxes: [{
              stacked: true
              }]
            },
            
            legend: {
              display: true,

              labels: {
              
              fontSize:14,
              }
            }
            


            //showLines: false,

        }
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
     
        url: '<?php echo base_url(); ?>charts/c_mpn_date/mpn_date_avg_sale',
        method: "GET",
         dataType: "json",
          success: function(data) {
 // var data = jQuery.parseJSON(data);
 // alert(data[0].MPN);
      var mp = [];
      var sa = [];

      for(var i in data) {
        mp.push(data[i].WEK);
        sa.push(data[i].SALE_VALUE);
      }

      var chartdata = {
        labels: mp,
        datasets : [
          {
            label: 'Avg Sale Price',
           
             borderColor: "#3cba9f",
             fill: false,
            
            data: sa
          }
        ]
      };

      var ctx = $("#mpn_date_avg");

      var barGraph = new Chart(ctx, {
        type: 'line',
        data: chartdata,

         options: 
        {
            title: {
              display: true,
              //position:'left',
              text: 'Average Price (Week Wise)',
              fontColor: '#3cba9f',
              fontSize:18
            },

            scales: {
              yAxes: [{
              stacked: true
              }]
            },
            
            legend: {
              display: true,

              labels: {
              
              fontSize:14,
              }
            }
            


            //showLines: false,

        }
      });
    },
  
  });
    
});



</script>


<script>
$(document).ready(function(){
    $.ajax({
        //dataType: 'json',
     
        url: '<?php echo base_url(); ?>charts/c_mpn_date/mpn_date_top_seller',
        method: "GET",
         dataType: "json",
          success: function(data) {
 // var data = jQuery.parseJSON(data);
 // alert(data[0].MPN);
      var mp = [];
      var sa = [];

      for(var i in data) {
        mp.push(data[i].SELLER);
        sa.push(data[i].AVG_SALE_VALUE);
      }

      var chartdata = {
        labels: mp,
        datasets : [
          {
            label: 'Avg Sale Price',
           backgroundColor: ["#5C6BC0", "#607D8B","#D81B60","#e8c3b9","#c45850","#3e95cd","#3cba9f","#e8c3b9","#c45850"],

                         
             borderWidth: 2,
            fill: false, 
            data: sa
          }
        ]
      };

      var ctx = $("#mpn_date_top_seller");

      var barGraph = new Chart(ctx, {
        type: 'bar',
        data: chartdata,
         options: 
        {
            title: {
              display: true,
              //position:'left',
              text: 'Average Price (Top Merchants)',
              fontColor: '#00ACC1',
              fontSize:18
            },

            scales: {
              yAxes: [{
              stacked: true
              }]
            },
            
            legend: {
              display: true,

              labels: {
              
              fontSize:14,
              }
            }
            


            //showLines: false,

        }
      });
    },
 
  });
});


</script>

<script>
$(document).ready(function(){
    $.ajax({
        //dataType: 'json',
     
        url: '<?php echo base_url(); ?>charts/c_mpn_date/mpn_con_wise_salevalue',
        method: "GET",
         dataType: "json",
          success: function(data) {
 // var data = jQuery.parseJSON(data);
 // alert(data[0].MPN);
      var mp = [];
      var sa = [];

      for(var i in data) {
        mp.push(data[i].NAME);
        sa.push(data[i].TOTAL_SALE_VALUE);
      }

      var chartdata = {
        labels: mp,
        datasets : [
          {
            label: 'Sale Price',
           backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#3e95cd","#3cba9f"],

                         
             borderWidth: 1,
            fill: false, 
            data: sa
          }
        ]
      };

      var ctx = $("#mpn_date_cond_sale_value");

      var barGraph = new Chart(ctx, {
        type: 'bar',
        data: chartdata,
         options: 
        {
            title: {
              display: true,
              //position:'left',
              text: 'Total Sale Price (Conditoin Wise)',
              fontColor: '#607D8B',
              fontSize:18
            },

            scales: {
              yAxes: [{
              stacked: true
              }]
            },
            
            legend: {
              display: true,

              labels: {
              
              fontSize:14,
              }
            }
            


            //showLines: false,

        }
      });
    },
 
  });
});


</script>

<script>
$(document).ready(function(){
    $.ajax({
        //dataType: 'json',
     
        url: '<?php echo base_url(); ?>charts/c_mpn_date/mpn_con_wise_saleunit',
        method: "GET",
         dataType: "json",
          success: function(data) {
 // var data = jQuery.parseJSON(data);
 // alert(data[0].MPN);
      var mp = [];
      var sa = [];

      for(var i in data) {
        mp.push(data[i].NAME);
        sa.push(data[i].SALE_UNIT);
      }

      var chartdata = {
        labels: mp,
        datasets : [
          {
            label: 'Sale Unit',
            backgroundColor: ["#3cba9f", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#3e95cd","#3cba9f"],

                         
             borderWidth: 1,
            
             
            fill: false, 
            data: sa
          }
        ]
      };

      var ctx = $("#mpn_date_cond_sale_unit");

      var barGraph = new Chart(ctx, {
        type: 'bar',
        data: chartdata,
         options: 
        {
            title: {
              display: true,
              //position:'left',
              text: 'Total Sale Unit (Conditoin Wise)',
              fontColor: '#42A5F5',
              fontSize:18
            },

            scales: {
              yAxes: [{
              stacked: true
              }]
            },
            
            legend: {
              display: true,

              labels: {
              
              fontSize:14,
              }
            }
            


            //showLines: false,

        }
      });
    },
 
  });
});


</script>

<script>
$(document).ready(function(){
    $.ajax({
        //dataType: 'json',
     
        url: '<?php echo base_url(); ?>charts/c_mpn_date/mpn_day_wise_salevalue',
        method: "GET",
         dataType: "json",
          success: function(data) {
 // var data = jQuery.parseJSON(data);
 // alert(data[0].MPN);
      var mp = [];
      var sa = [];

      for(var i in data) {
        mp.push(data[i].DAY);
        sa.push(data[i].SALE_VALUE);
      }

      var chartdata = {
        labels: mp,
        datasets : [
          {
            label: 'Sale Price',
            backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#3e95cd","#3cba9f"],

                         
             borderWidth: 1,
            
             
            fill: false, 
            data: sa
          }
        ]
      };

      var ctx = $("#mpn_date_day_sale_value");

      var barGraph = new Chart(ctx, {
        type: 'bar',
        data: chartdata,
         options: 
        {
            title: {
              display: true,
              //position:'left',
              text: 'Total Sale Price (Day Wise)',
              fontColor: '#42A5F5',
              fontSize:18
            },

            scales: {
              yAxes: [{
              stacked: true
              }]
            },
            
            legend: {
              display: true,

              labels: {
              
              fontSize:14,
              }
            }
            


            //showLines: false,

        }
      });
    },
 
  });
});


</script>

<script>
$(document).ready(function(){
    $.ajax({
        //dataType: 'json',
     
        url: '<?php echo base_url(); ?>charts/c_mpn_date/mpn_day_wise_saleunit',
        method: "GET",
         dataType: "json",
          success: function(data) {
 // var data = jQuery.parseJSON(data);
 // alert(data[0].MPN);
      var mp = [];
      var sa = [];

      for(var i in data) {
        mp.push(data[i].DAY);
        sa.push(data[i].SALE_UNIT);
      }

      var chartdata = {
        labels: mp,
        datasets : [
          {
            label: 'Sale Unit',
            backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#3e95cd","#3cba9f"],

                         
             borderWidth: 1,
            
             
            fill: false, 
            data: sa
          }
        ]
      };

      var ctx = $("#mpn_date_day_saleunit");

      var barGraph = new Chart(ctx, {
        type: 'bar',
        data: chartdata,
         options: 
        {
            title: {
              display: true,
              //position:'left',
              text: 'Total Sale Unit (Day Wise)',
              fontColor: '#42A5F5',
              fontSize:18
            },

            scales: {
              yAxes: [{
              stacked: true
              }]
            },
            
            legend: {
              display: true,

              labels: {
              
              fontSize:14,
              }
            }
            


            //showLines: false,

        }
      });
    },
 
  });
});


</script>

<script >

  $(function() {
      //Date range as a button
      $('#mpn_date_sum').daterangepicker(
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