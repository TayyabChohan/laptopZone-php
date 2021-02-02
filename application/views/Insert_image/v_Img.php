<?php $this->load->view('template/header');?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Seed Form
      <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Seed Form</li>
    </ol>
  </section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-sm-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Seed Form</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

         <?php //var_dump($data_get);exit;
          if ($data_get == NULL) {
          ?>
          <div class="alert alert-info" role="alert">There is no record found.</div>
          <?php
          } else {
          foreach ($data_get as $row) {
          ?>

            <div class="col-sm-4">
              <div class="form-group">
                  <label>ERP Code:</label>
                  <input type='text' class="form-control" name="erp_code" value="<?php echo @$row->LAPTOP_ITEM_CODE; ?>" readonly >      
              </div>
            </div>
            <div class="col-sm-4 m-erp" >
                <div class="form-group">
                  <label for="">ERP Inventory Description:</label>
                  <input type='text' class="form-control" name="inven_desc" value="<?php echo htmlentities(@$row->ITEM_MT_DESC); ?>" readonly>
                </div>
            </div>

            <div class="col-sm-4">    
              <div class="form-group">      
                  <label for="">UPC:</label>
                  <input type="text" class="form-control" id="upc" name="upc" value="<?php echo @$row->UPC; ?>" readonly/>
                </div>
              </div>

            <div class="col-sm-4">  
                <div class="form-group">      
                  <label for="">SKU:</label>
                  <input type='text' class="form-control" id="sku" name="sku" value='<?php echo @$row->SKU_NO; ?>' readonly>
                </div>
              </div>  

            <div class="col-sm-4">
                <div class="form-group">      
                  <label for="">Manufacturer:</label>
                  <input type='text' class="form-control" name="manufacturer" value='<?php echo htmlentities(@$row->MANUFACTURER); ?>' readonly>
                </div>
              </div>

            <div class="col-sm-4">        
                <div class="form-group">      
                  <label for="">Part No:</label>
                  <input type='text' class="form-control" id="part_no" name="part_no" value='<?php echo htmlentities(@$row->MFG_PART_NO); ?>' readonly>
                </div>
              </div>
          <!-- Picture section start-->     
            <div class="col-sm-12 p-b">
              <div class="form-group">      
                  <label for="">Picture:</label>

                  <span class="text-danger">
                   <?php 
                      $error_msg = $this->session->userdata('size_error');
                      if(!empty($error_msg)){echo @$error_msg." size is too large.";}
                      //var_dump($error_msg);
                      //echo $error_msg;
                      $this->session->unset_userdata('size_error');
                   ?> 
                  </span>  

              </div>               
              <div id="drop-area" class="col-sm-12 b-full"> 
                <div class="col-sm-2">                   
                  <div  class="commoncss">
                    <h4>Drag / Upload image!</h4>
                      <div class="uploadimg">
      <?php
            $seed_history = $this->session->userdata('seed_history');
      if($seed_history){
        $manifest_id=$this->session->userdata('manifest_id');
        $this->session->unset_userdata('manifest_id');
      }
            ?>
                       <form id="frmupload" enctype="multipart/form-data">
                          <input type="file" multiple="multiple" name="image[]" id="image" style="display:none"/>
                          <input type="hidden" style="display:none;" class="form-control" id="pic_item_id" name="pic_item_id" value="<?php echo @$row->ITEM_ID; ?>">
                          <input type="hidden" style="display:none;" class="form-control" id="pic_manifest_id" name="pic_manifest_id" value="<?php if (@$manifest_id){echo $manifest_id;}else{echo @$row->LZ_MANIFEST_ID;} ?>">
                          <span id="btnupload" class="fa fa-cloud-upload"></span>

                        </form>
                      </div>
                  </div>
              </div>



              <div class="col-sm-10 p-t" style="padding-left:0px !important;padding-right:0px !important;"> 

                  <?php if(empty($img_data)):?>
                    <div class="col-sm-2 imgCls">                          
                        <?php echo 'No Image to Display';?>
                    </div>
                  <?php endif; ?>

              <ul id="sortable" class="">

                  <?php if(!empty($img_data)):?>
                    <?php foreach($img_data as $im):?>
                  <?php $img = $im->ITEM_PIC->load();?>
                  <?php $pic= base64_encode($img);?>

                <li id="<?php echo $im->ITEM_PICTURE_ID;?>">
                  <span class="tg-li">
                    <div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);">
                    <!--<div class="col-sm-2 imgCls">-->                          
                      <?php echo '<img class="sort_img up-img" id="'.$im->ITEM_PICTURE_ID.'" name="'.$im->ITEM_PICT_DESC.'" src="data:image;base64,'.$pic.' "/>';?>

                      <div class="img_overlay">
                        <span><i class="fa fa-trash"></i></span>
                      </div>

                    </div>                    
                  </span>                        
                </li>



                <?php endforeach;
                      endif;?>
              </ul>
                                
            </div>

              <div class="col-sm-12 " style="padding-left:0px !important;padding-right:0px !important;">

                    <div class="col-sm-8">
                      <div class="alert success pull-right" style="font-size:16px;color:green;font-weight:600;"></div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group pull-right">
                        <input id="update_order" class="btn btn-sm btn-primary" type="button" name="update_order" value="Update Order">
                        <span><i id="del_all" onclick="return confirm('are you sure?')" class="btn btn-sm btn-danger">Delete All</i></span>
                      </div>
                      
                    <!--</form>-->
                  </div>
              </div> 

            </div>
          </div>
          <!-- Picture section end--> 
           <?php
              // foreach and else close
              }
          

        }
           ?>

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


