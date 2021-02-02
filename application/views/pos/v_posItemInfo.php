<?php $this->load->view('template/header');
ini_set('memory_limit', '-1');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    AD Posting
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">AD Posting</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-sm-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Item Details</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

<!--             <div class="col-sm-3">    
              <div class="form-group">      
                  <label for="">Barcode:</label>
                  <input type="text" class="form-control" id="item_barcode" name="item_barcode" value="<?php //echo @$data[0]->IT_BARCODE; ?>" readonly/>
                </div>
              </div> -->

            <div class="col-sm-8 m-erp" >

                <div class="form-group">
                  <label for="">Title:</label>
                  <input type='text' class="form-control" name="inven_desc" value="<?php echo htmlentities(@$data['item_detail'][0]['ITEM_TITLE']); ?>" readonly>
                  
                </div>
            </div>


                      
            <div class="col-sm-2">    
              <div class="form-group">      
                  <label for="">UPC:</label>
                  <input type="text" class="form-control" id="upc_seed" name="upc_seed" value="<?php echo @$data['item_detail'][0]['ITEM_MT_UPC']; ?>" readonly/>
                </div>
              </div>


            <div class="col-sm-2">
                <div class="form-group">      
                  <label for="">Manufacturer:</label>
                  <input type='text' class="form-control" name="manufacturer" value='<?php echo htmlentities(@$data['item_detail'][0]['ITEM_MT_MANUFACTURE']); ?>' readonly>
                </div>
              </div>

            <div class="col-sm-2">        
                <div class="form-group">      
                  <label for="">Part No:</label>
                  <input type='text' class="form-control" id="part_no_seed" name="part_no_seed" value='<?php echo htmlentities(@$data['item_detail'][0]['ITEM_MT_MFG_PART_NO']); ?>' readonly>
                </div>
            </div>
            <div class="col-sm-2" >
                <div class="form-group">
                  <label for="">Condition:</label>
                  <input type='text' class="form-control" name="inven_desc" value="<?php echo htmlentities(@$data['item_detail'][0]['CONDITION_ID']); ?>" readonly>
                </div>
            </div>
            <div class="col-sm-2" >
                <div class="form-group">
                  <label for="">Quantity:</label>
                  <input type='text' class="form-control" name="inven_desc" value="<?php echo htmlentities(@$data['item_detail'][0]['QTY']); ?>" readonly>
                </div>
            </div>                


          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->

      <div class="box">
        <div class="box-header">
          <h3 class="box-title">AD Posting Form</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          
          <form action="<?php echo base_url();?>pos/c_pos_list/posAddPost" method="post" name="addPostForm">
            <div class="col-sm-3">    
              <div class="form-group">      
                  <label for="">Craig AD ID:</label>
                  <input type="text" class="form-control" id="craig_ad_id" name="craig_ad_id" value="<?php echo htmlentities(@$data['craig_id'][0]['CRAIG_AD_ID']); ?>" readonly/>
                  <input type='hidden' class="form-control" name="seed_id" value="<?php echo @$data['item_detail'][0]['SEED_ID']; ?>" readonly>
                </div>
              </div>

            <div class="col-sm-3 m-erp" >
                <div class="form-group">
                  <label for="">Qunatity:</label>
                  <input type='number' class="form-control" id="ad_qty" name="ad_qty" value="" >
                </div>
            </div>

            <div class="col-sm-3 m-erp" >
                <div class="form-group">
                  <label for="">Rate:</label>
                  <input type='number' step="0.01" class="form-control" id="ad_rate" name="ad_rate" value="" required="">
                </div>
            </div>
                      
            <!-- <div class="col-sm-3">    
              <div class="form-group">      
                  <label for="">Valid Till:</label>
                  <input type="text" class="form-control" id="valid_till" name="valid_till" value="" />
                </div>
              </div> -->

               <div class="col-sm-3">
                  <div class="form-group">
                    <label for="">Valid Till:</label>
                    <div class="input-group">
                    
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      
                      
                      <input type="text" class="btn btn-default" name="valid_till" id="list_date" value="">

                    </div>
                  </div>
                </div>

            <div class="col-sm-12">
              <div class="form-group">
                <input type="submit" class="btn btn-primary" name="post" id="post" value="Post">
              </div>
            </div>
          </form>              


          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->

      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>  

<?php $this->load->view('template/footer');?>

<script>
/*==================================
=            Image zoom            =
Doc Url: http://www.elevateweb.co.uk/image-zoom/examples
==================================*/
  $('.zoom_01').elevateZoom({
    //zoomType: "inner",
    cursor: "crosshair",
    zoomWindowFadeIn: 600,
    zoomWindowFadeOut: 600,
    easing : true,
    scrollZoom : true
   });


/*=====  End of Image zoom  ======*/

</script>
