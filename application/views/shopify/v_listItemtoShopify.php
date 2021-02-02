<?php $this->load->view('template/header'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Import Item to Shopify from eBay
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Import Item to Shopify from eBay</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-sm-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Import Item from eBay Id</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="col-sm-12">
                  <div class="col-sm-2">
                      <label>Import Item:</label>
                      <div class="form-group">
                          <input class="form-control" type="number" name="ebay_id" id="ebay_id" value="" placeholder="Enter eBay Id">
                      </div>                                     
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group p-t-26">
                        <input type="button" id="import_item" title="Import Item to Shopify" class="btn btn-md btn-success" name="Submit" value="Import Item">
                    </div>
                  </div>                    
                </div>
                <div class="col-sm-12">
                    <div id="successMsg" class="alert alert-success" style="display:none"></div>
                    <div id="errorMsg" class="alert alert-error" style="display:none"></div>
                    <div id="duplicateMsg" class="alert alert-warning" style="display:none"></div>
                </div>
                                
            </div>
          </div>  
        </div>
        <!-- /.col -->
        <div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
            <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="Please Wait" style="width: 100px; height: 100px;">
        </div>        
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>    
<!-- End Listing Form Data -->
<?php $this->load->view('template/footer'); ?>
<script type="text/javascript">

    $('#import_item').click(function() {
        $(".loader").show();
        var ebay_id = $("#ebay_id").val();
        if(ebay_id == null || ebay_id == ''){
            alert("Please Insert eBay Id"); return false;
        }
        $.ajax({
            url: '<?php echo base_url('shopify/c_listItemtoShopify/ImportItemShopify'); ?>',
            type: 'POST',
            data: {
                ebay_id: ebay_id
            },
            dataType: 'json',
            success: function(data) {
                //console.log(data.products);
                //console.log(data);
                // return false;
                if(data == "Success"){
                    $("#successMsg").html("Item is successfully imported to Shopify.").fadeIn(800);
                    $('#successMsg').delay(5000).fadeOut('slow');
                }else if(data == "Error"){
                    $("#errorMsg").html("Error! There is something missing, Contact your Administrator.").fadeIn(800);
                    $('#errorMsg').delay(5000).fadeOut('slow');
                }else if(data === "Duplicate"){
                    $("#duplicateMsg").html("Warning! Item is already exist.").fadeIn(800);
                    $('#duplicateMsg').delay(5000).fadeOut('slow');                    
                }                

            },
            complete: function(data){
                $(".loader").hide();
            }
        });
    });

</script>