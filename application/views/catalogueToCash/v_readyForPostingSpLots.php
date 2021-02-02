<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Special Lots Detail
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Special Lots Detail</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">  
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Search Item</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>              
            </div>
            <div class="box-body">
              <div class="col-sm-6 col-sm-offset-3">
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
              </div>
              <div class="col-sm-12">
              <div class="col-sm-2">
                <label>Search Filter:</label>
              </div>
              <form action="#" method="post">
                <div class="col-sm-3">
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <?php $searchedData = $this->session->userdata('searchLots'); ?>
                      <input type="text" class="btn btn-default" name="lot_date" id="lot_date" value="<?php echo $searchedData['lotDateRange']; ?>">
                    </div>
                  </div>
                </div>
                <?php $checked = $searchedData['session_posting']; ?>
                <div class="col-sm-3">
                  <input type="radio" name="lot_posting" value="1" <?php if($checked == 1){ echo 'checked'; } ?>>&nbsp;Posted
                  <input type="radio" name="lot_posting" value="2" <?php if($checked == 2){ echo 'checked'; } ?>>&nbsp;Un Posted
                  <input type="radio" name="lot_posting" value="0" <?php if($checked == 0){ echo 'checked'; } ?>>&nbsp;All   
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-sm" name="search_lister" id="search_lister" value="Search">
                  </div>
                </div>
               
              </form>                 
            </div>
          </div>
        </div>
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Special Lots</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>              
          </div>              
          <div class="box-body form-scroll">   
            <div class="col-md-12">
              <table id="special_lot_table" class="table table-bordered table-striped" >
                <thead>
                    <th>ACTION</th>
                    <th>PICTURE</th>
                    <th>BARCODE</th>
                    <th>UPC</th>
                    <th>MPN</th>
                    <th>MPN DESCRIPTION</th>
                    <th>CONDITION</th>
                    <th>BRAND</th>
                    <th>BIN/RACK</th>
                    <th>BIN NAME</th>
                    <th>LOT REMARKS</th>
                    <th>PIC NOTES</th>
                    <th>CREATED AT</th>
                    <th>CREATED BY</th>
                    <th>UPDATED AT</th>
                    <th>UPDATED BY</th>
                </thead>
                <tbody>             
              </tbody>
            </table>
          </div>
          <!-- /.col --> 
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
<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>
 <script>
/*================================================
=            Approval for Listing                =
==================================================*/
var lot_posting = '';
var lot_date = '';
$(document).ready(function(){
  $("#special_lot_table").dataTable().fnDestroy();
    
    lot_posting = $("input[name='lot_posting']:checked").val();
    lot_date     = $("#lot_date").val();
    $("#special_lot_table").DataTable({
    "oLanguage": {
    "sInfo": "Total Items: _TOTAL_"
    },
    "fixedHeader": true,
    "paging": true,
    "iDisplayLength": 25,
    "aLengthMenu": [[25, 50, 100, 200], [25, 50, 100, 200]],
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    "info": true,
    //"autoWidth": true,
    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
      "bProcessing": true,
      "bRetrieve":true,
      "bDestroy":true,
      "bServerSide": true,
      "bAutoWidth": true,
      "ajax":{
      url :"<?php echo base_url().'catalogueToCash/c_card_lots/load_mpns_lots'?>", // json datasource
      type: "post" , // method  , by default get
      dataType: 'json',
      data: {
         "lot_posting":lot_posting,
         "lot_date":lot_date
        },
      },
      "columnDefs":[{
          "target":[0],
          "orderable":false
        }
      ]      
  });

});

$("#approval_btn").click(function () {
    
  var approval = [];
  $.each($("input[name='approval[]']:checked"), function(){            
   approval.push($(this).val());
  });    
    
  if(approval.length == 0){
    alert('Please select atleast one.');return false;
  }

    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>tolist/c_tolist/approvalForListing',
      data: { 'approval':approval           
    },
     success: function (data) {
      //alert(data);return false;
        if(data == true){
          alert('Selected items Approved for Listing.');
          window.location.reload();
          
        }else if(data == false){
          alert('Error - Selected items Approved for Listing.');
          //window.location.reload();
        }
      }
      });  

});

/*=====  End of Approval for Listing  ======*/   
 </script>