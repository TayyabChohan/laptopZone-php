<?php $this->load->view('template/header'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $pageTitle; ?>
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo $pageTitle; ?></li>
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
              <h3 class="box-title">Search Item</h3>
            </div>
            <!-- /.box-header -->
               <div class="box-body">
                  <form action="<?php echo base_url(); ?>Unpostitem/c_Unpostitem/unpostBarcode" method="post" accept-charset="utf-8">
                      <div class="col-sm-8">
                        <div class="form-group">
                            <input class="form-control" type="text" name="search" value="<?php echo @$barcode; ?>" placeholder="Enter a Valid Barcode">
                        </div>                                     
                      </div>
                      <div class="col-sm-2">
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" name="Submit" value="Search">
                        </div>
                      </div>                                 
                  </form>
                    <div class="col-sm-12">
                  <?php if(@$data == 'deleted'){
                    echo '<div class="alert alert-success alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            Item <strong>Succsessfully</strong> deleted.
                          </div>';
                  }elseif(@$data['deleted'] == '1'){
                    echo '<div class="alert alert-success alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            Item <strong>Succsessfully</strong> deleted.
                          </div>';                                
                  }elseif(!empty(@$data['item_alloc'])){
                    echo '<div class="alert alert-danger alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            Barcode not <strong>Available</strong>.
                          </div>';                                
                  }elseif(!empty(@$data['item_holded'])){
                    echo '<div class="alert alert-warning alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            Item is <strong>Holded</strong> against this '.@$data["item_holded"].' Please un-hold item first.
                          </div>';                            
                  }
                  ?>
                  </div>
                <?php if(!empty(@$data['response'])): ?>
                <div class="col-sm-12">
                  <div class="col-sm-8 form-group">
                    <label>Item Description:</label>
                    <input type="text" class="form-control" name="itemDescription" value="<?php echo $data['response'][0]['ITEM_DESC']; ?>" readonly="">      
                  </div>
                  <div class="col-sm-3 form-group">
                    <label>Condition:</label>
                    <input type="text" class="form-control" name="itemCondition" value="<?php echo $data['response'][0]['COND_NAME']; ?>" readonly="">      
                  </div>
                  <!-- <div class="col-sm-3 form-group">
                    <label>eBay Id:</label>
                    <input type="text" class="form-control" name="ebayId" value="<?php //echo $data['response'][0]['EBAY_ITEM_ID']; ?>" readonly="">      
                  </div> -->
                </div>
                <form action="<?php echo base_url(); ?>Unpostitem/c_Unpostitem/UnpostItem" method="post" accept-charset="utf-8">
               <div class="col-sm-12">  
                  <input type="hidden" class="form-control" name="unpost_item[]" value="<?php echo @$barcode; ?>">               
                  <div class="form-group col-sm-3">
                    <label for="user_remark" >Select Remarks</label>
                      <select name="user_remark" class="form-control" id="user_remark">
                        <option value="">Select Remark------------</option>
                        <option value="1">System Error</option>
                        <option value="2">Missing UPC</option>
                        <option value="3">Missing MPN</option>
                        <option value="4">Wrong MPN</option>
                        <option value="5">Wrong UPC</option>
                        <option value="6">Wrong Description</option>
                        <option value="7">Packaging vs Content Wrong</option>
                        <option value="8">Not Worth Selling Online</option>
                      </select>
                  </div>                                     
                </div>
              <div class="col-sm-12">
                  <label for="Remarks">Remarks: </label>
                  <div class="form-group">
                    <textarea class="form-control" name="remarks" id="remarks" rows="4" cols=50 required></textarea>
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group">
                  <input type="submit" onclick="return confirm('Are you sure?');" class="btn btn-primary btn-sm" name="del_item" id="del_item" value="Delete Item">
                </div>
              </div>
              </form>
            <?php endif; ?>
                </div> <!-- box body -->
                
          </div> <!-- box close  -->
                   
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>    
<!-- End Listing Form Data -->
<?php $this->load->view('template/footer'); ?>
<script>
$(document).ready(function()
  {
     $('#ItemSearchResults').DataTable({
    "oLanguage": {
    "sInfo": "Total Records: _TOTAL_"
  },
  "iDisplayLength": 50,
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    // "order": [[ 16, "ASC" ]],
    "info": true,
    "autoWidth": true,
    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
  });
  /*////////////////////////*/ 
  $("#user_remark").change(function(){
    var user_remark = $("#user_remark").val();
      if (user_remark==1) {document.getElementById("remarks").value = "System Error";}
      else if(user_remark ==2){document.getElementById("remarks").value = "Missing UPC";}
      else if(user_remark ==3){document.getElementById("remarks").value = "Missing MPN";}
      else if(user_remark ==4){document.getElementById("remarks").value = "Wrong MPN";}
      else if(user_remark ==5){document.getElementById("remarks").value = "Wrong UPC";}
      else if(user_remark ==6){document.getElementById("remarks").value = "Wrong Description";}
      else if(user_remark ==7){document.getElementById("remarks").value = "Packaging vs Content Wrong";}
      else if(user_remark ==8){document.getElementById("remarks").value = "Not Worth Selling Online";}
      else{document.getElementById("remarks").value = "";}
    });      
    
});
</script>