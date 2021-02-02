<?php $this->load->view('template/header'); ?>

<style>
  #specific_fields{display:none;}
  .specific_attribute{display: none;}
</style>   
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Category Name
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add Category Name</li>
      </ol>
    </section>
        
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
        <!-- Search Start -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Search Item</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
                <div class="box-body">
                    <form action="<?php echo base_url(); ?>specifics/c_item_specifics/specific_barcode" method="post" accept-charset="utf-8">
                        <div class="col-sm-8">
                            <div class="form-group">
                            <label for="">Search Item:</label>
                                <input class="form-control" type="text" id="specific_barcode" name="specific_barcode" value="<?php if( $this->session->userdata('spec_barcode')){echo $this->session->userdata('spec_barcode');}else {echo $this->uri->segment(4);}?>" placeholder="Search Item">
                            </div>                                     
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group p-t-24">
                                <input type="submit" class="btn btn-primary" name="submit" value="Search">
                            </div>
                        </div> 
                        <div class="col-sm-2">
                            <div class="form-group">
                                
                            </div>
                        </div>                                
                    </form>
                     <?php if(!empty($data)): ?>
                    <div class="col-sm-8">
                        <div class="form-group">
                        <label for="">Description:</label>
                            <input type="text" class="form-control" name="item_mt_desc" value="<?php echo @$data['item_det'][0]['ITEM_MT_DESC']; ?>" readonly>
                        </div>
                    </div> 
                    <div class="col-sm-4">
                        <div class="form-group">
                        <label for="">Manufacture:</label>
                            <input type="text" class="form-control" name="manufacturer" value="<?php echo @$data['item_det'][0]['MANUFACTURER']; ?>" readonly>
                        </div>
                    </div> 
                   
                    <div class="col-sm-2">
                    <label for="">MPN:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="item_mpn" name="item_mpn" value="<?php echo @$data['item_det'][0]['MFG_PART_NO']; ?>" readonly>
                        </div>
                    </div> 
                    <div class="col-sm-2">
                    <label for="">UPC:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="item_upc" name="item_upc" value="<?php echo @$data['item_det'][0]['UPC']; ?>" readonly>
                        </div>
                    </div> 
                    <div class="col-sm-2">
                    <label for="">Quantity:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="Quantity" value="<?php echo @$data['item_det'][0]['AVAIL_QTY']; ?>" readonly>
                        </div>
                    </div>
                    <div class="col-sm-2">
                    <label for="">Item ID:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="item_id" id="item_id" value="<?php echo @$data['item_det'][0]['ITEM_ID']; ?>" readonly>
                        </div>
                    </div>
                    <div class="col-sm-2">
                    <label for="">Manifest ID:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="manifest_id" value="<?php echo @$data['item_det'][0]['LZ_MANIFEST_ID']; ?>" readonly>
                        </div>
                    </div>
                    <div class="col-sm-2">
                    <label for="">Purchase Ref No:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="purch_ref_no" value="<?php echo @$data['item_det'][0]['PURCH_REF_NO']; ?>" readonly>
                        </div>
                    </div>
                    <div class="col-sm-2">
                    <label for="">Category Name:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="spec_cat_name" id="spec_cat_name" value="<?php echo @$data['cat_id'][0]['BRAND_SEG3']; ?>" readonly>
                        </div>
                    </div>
                    <div class="col-sm-2">
                    <label for="">Category ID:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="spec_cat_id" id="spec_cat_id" value="<?php echo @$data['cat_id'][0]['E_BAY_CATA_ID_SEG6']; ?>" readonly>
                        </div>
                    </div>
                                                           
                    <?php endif; ?> 
                </div>
            </div>
        <!-- Search Start --> 




        <!-- Item Specific Start -->
            <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Add Category Name</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>

                <div class="box-body">

                    <div class="col-sm-12">
                    <form action="<?php echo base_url('specifics/c_item_specifics/update_cat_id'); ?>" method="post">
              <?php //if(@$data['error_msg'] == true ):?>
                    <input class="form-control" type="hidden" id="it_barcode" name="it_barcode" value="<?php if( $this->session->userdata('spec_barcode')){echo $this->session->userdata('spec_barcode');}else {echo $this->uri->segment(4);}?>">

                    <div class="col-sm-12">

                      <div class="col-sm-6">
                          <div class="form-group">
                              <label for="">Query:</label>
                              <input class="form-control" id="title" name="title" placeholder="Enter UPC/MPN/Description">
                          </div>
                      </div>
                      <div class="col-sm-2">
                        <div class="form-group p-t-24">
                          <a class="crsr-pntr btn btn-primary btn-small" title="Click here for category suggestion" id="Suggest_Categories">Suggest Category</a>
                        </div>
                      </div>
                    </div> 
                     
                      <div class="col-sm-12">  
                        <div class="col-sm-2">
                          <div class="form-group">
                            <label for="">Category ID:</label>
                              <input type="number" class="form-control" id="category_id" name="category_id" value="<?php //echo @$row->CATEGORY_ID; ?>" required readonly>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="form-group">
                            <label for="Main Category" class="control-label">Main Category:</label>
                          
                            <input type="text" class="form-control" id="main_category" name="main_category" readonly>
                            
                          </div>
                        </div>

                        <div class="col-sm-3">
                          <div class="form-group">
                            <label for="Sub Category" class="control-label">Sub Category:</label>
                          
                            <input type="text" class="form-control" id="sub_cat" name="sub_cat" readonly>

                          </div>
                        </div>

                        <div class="col-sm-3">
                          <div class="form-group">
                            <label for="Category" class="control-label">Category Name:</label>
                            <input type="text" class="form-control" id="category_name" name="category_name" readonly>
                          </div>
                        </div>
                      </div>
 
                     
                    <!-- Category Result -->
                    <div id="Categories_result">
                    </div>            
                    <!-- Category Result -->     

                      <div class="col-sm-12"> 
                        <div class="col-sm-2">
                          <div class="form-group">
                            <input type="submit" class="btn btn-success" id="submit" name="submit" value="Save">
                          </div>
                        </div>
                      </div> 

                   </div>
               
                  <?php //endif; ?>                  

                    </form>
                </div>
            </div>
        <!-- Item Specific end -->                         


        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>    
<!-- End Listing Form Data -->


 <?php $this->load->view('template/footer'); ?>