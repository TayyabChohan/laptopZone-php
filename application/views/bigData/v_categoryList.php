<?php $this->load->view('template/header'); 
ini_set('memory_limit', '-1'); // add for picture loading issue
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Category List
    </h1>
    <ol class="breadcrumb">
      <li>
        <a href="<?php echo base_url();?>dashboard/dashboard">
          <i class="fa fa-dashboard">
          </i> Home
        </a>
      </li>
      <li class="active">Category List
      </li>
    </ol>
  </section>  
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="box">
          <br>
          <div class="col-sm-12">
            <div class="col-sm-2">
              <div class="form-group pull-left">
                <a title="Add Category Data" class="btn btn-primary btn-sm" href="<?php echo base_url(); ?>bigData/c_bigData/addCategoryData" target="_blank">Add Category Data
                </a>
              </div>
            </div>
          </div>     
          <div class="box-body form-scroll">  
            <?php if($this->session->flashdata('success')){ ?>
            <div id="successMsg" class="alert alert-success">
              <a href="#" class="close" data-dismiss="alert">&times;
              </a>
              <strong>Success!
              </strong> 
              <?php echo $this->session->flashdata('success'); ?>
            </div>
            <?php }else if($this->session->flashdata('error')){  ?>
            <div id="errorMsg" class="alert alert-danger">
              <a href="#" class="close" data-dismiss="alert">&times;
              </a>
              <strong>Error!
              </strong> 
              <?php echo $this->session->flashdata('error'); ?>
            </div>
            <?php } ?>    
            <div class="col-md-12">
              <!-- Custom Tabs -->
              <table id="categoryList" class="table table-responsive table-striped table-bordered table-hover">
                <thead>
                  <th>ACTIONS
                  </th>
                  <th>CATEGORY ID
                  </th>
                  <th>CATEGORY NAME
                  </th>
                  <th>CONDITION
                  </th>
                  <th>SELLER ID
                  </th>
                   <th>GLOBAL ID
                  </th>
                  <th>KEYWORD
                  </th> 
                    <th>LISTING FILTER
                  </th>
                  <th>LISTING TYPE
                  </th>                    
                  <th>INSERTED DATE
                  </th> 
                  <th>TOTAL RECORDS
                  </th> 
                </thead>
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
<script type="text/javascript">
  $(document).ready(function(){
   /* var dataTable = $('#categoryList').DataTable({
      "oLanguage":{
        "sInfo": "Total Records: _TOTAL_"
      }
      ,
      // For stop ordering on a specific column
      columnDefs: [{
        orderable: false, targets: [0] }
                  ],
      "iDisplayLength": 100,
      "aLengthMenu": [[5, 10, 25, 50, 100, 200], [5, 10, 25, 50, 100, 200]],
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      //"order": [[ 8, "desc" ]],
      //"order": [[ 16, "ASC" ]],
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
      "processing": true,
      "serverSide": true,     
      "ajax":{
        url :"<?php //echo base_url() ?>bigData/c_bigData_1/loadData", // json datasource
        type: "post",  // method  , by default get
        error: function()
        {
          // error handling
          $(".categoryData-error").html("");
          $("#categoryData").append('<tbody class="categoryData-error"><tr><th colspan="12">No data found in the server</th></tr></tbody>');
          $("#categoryData_processing").css("display","none");
        }
      }
      //dataTable.destory();
    });*/
    /*///////////////////////////////*/
    var dataTable = $('#categoryList').DataTable( {
      
      "oLanguage": {
      "sInfo": "Total Records: _TOTAL_",
      //"sPaginationType": "full_numbers",
      
    },
    // For stop ordering on a specific column
    // "columnDefs": [ { "orderable": false, "targets": [0] }],
    // "pageLength": 5,
       "aLengthMenu": [25, 50, 100, 200],
       "paging": true,
      // "lengthChange": true,
      "searching": true,
      // "ordering": true,
      "Filter":true,
      // "iTotalDisplayRecords":10,
      //"order": [[ 8, "desc" ]],
      // "order": [[ 16, "ASC" ]],
      "info": true,
      // "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
      "bProcessing": true,
      "bRetrieve":true,
      "bDestroy":true,
      "bServerSide": true,
      // "bAutoWidth": false,
      "ajax":{
        url :"<?php echo base_url() ?>bigData/c_bigData/loadData", // json datasource
        type: "post"  // method  , by default get
        // data: {},
        
        },
        "columnDefs":[{
            "target":[0],
            "orderable":false
          }
        ]

      });
    /*///////////////////////////////*/
  });
  /*===== Success message auto hide ====*/
  setTimeout(function(){
    $('#successMsg').fadeOut('slow');
  }
             , 5000);
  // <-- time in milliseconds
  setTimeout(function(){
    $('#errorMsg').fadeOut('slow');
  }
             , 5000);
  // <-- time in milliseconds        
  /*===== Success message auto hide ====*/    
</script>