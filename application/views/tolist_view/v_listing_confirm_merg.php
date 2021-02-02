<?php $this->load->view('template/header'); 

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Listing Confirmation
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Listing Confirmation</li>
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
            <div class="box-header with-border">
              <h3 class="box-title">Listing Confirmation</h3>
            </div>
            <!-- /.box-header -->
                      <div class="box-body">

                          <form action="<?php echo base_url('tolist/c_tolist/list_item_confirm_merg'); ?>" method="post" accept-charset="utf-8">
                          <table class="table table-bordered table-hover table-responsive">
                            <tr>
                              <th>Select</th>
                              <th>eBay ID</th>
                              <th>Title</th>
                              <th>Condition ID</th>
                              <th>Condition Name</th>
                            </tr>
                          <?php 
                          $j=0;

                          foreach ($ebay_id as $ebay_item_id) { 
                            if($j===0){
                              $checked = 'checked';
                            }else{
                              $checked = '';
                            }
                            ?>

                            <tr>
                            <td><input type="radio" name="selected_ebay_id" value="<?php echo $ebay_item_id; ?>" <?php echo $checked;?>></td>
                              <td><a style="text-decoration: underline;" title="ebay URL" target="_blank" href="<?php echo $item_url[$j]; ?>"><?php echo $ebay_item_id; ?></a></td>
                              <td><?php echo $title[$j]; ?></td>
                              <td><?php echo $condition_id[$j]; ?></td>
                              <td><?php echo $condition_Name[$j]; ?></td>
                            </tr>
                         <?php $j++;
                          }// end foreach
                            ?>
                          </table>
                          <div class="col-sm-12">
                          
                            <input type="hidden" name="list_barcode" id="list_barcode" value="<?php echo @$list_barcode; ?>">
                            <input type="hidden" name="seed_id" id="seed_id" value="<?php echo @$seed_id; ?>">
                            <input type="hidden" name="check_btn" id="check_btn" value="<?php echo @$check_btn;?>">
                            <input type="hidden" name="account_name" id="account_name" value="<?php echo @$acct_name[0];?>">
                            <input type="hidden" name="acct_id" id="acct_id" value="<?php echo @$acct_id;?>">
                            <input type="hidden" name="shopifyCheckbox" id="shopifyCheckbox" value="<?php echo @$shopifyCheckbox;?>">
                            <input type="hidden" name="bestOfferCheckbox" id="bestOfferCheckbox" value="<?php echo @$bestOfferCheckbox;?>">
                            <input type="hidden" name="addQtyOnly" id="addQtyOnly" value="<?php echo @$addQtyOnly;?>">
                            <div class="form-group pull-left m-r-5">
                                <input type="submit"  title="Revise Item" class="btn btn-success" name="revise_item" value="Revise Item" onclick="return confirm('Are you sure?');">
                            </div>
                            <?php 
                            if(@$check_btn != 'revise'){ ?>
                              <div class="form-group pull-left m-r-5">
                                <input type="submit" title="Add Item" class="btn btn-primary" name="add_item" value="Add Item" onclick="return confirm('Are you sure?');">
                              </div> 
                            <?php
                            }
                            ?>
                                                     
                            <div class="form-group pull-left m-r-5">
                                <a title="Back to Item Listing" href="<?php echo base_url('dekitting_pk_us/c_to_list_pk/lister_view'); ?>" class="btn btn-warning">Cancel</a>
                            </div>
                          </div>
                          </form>
                        </div> <!-- box div close -->
                         
            </div>  


        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>    
<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>