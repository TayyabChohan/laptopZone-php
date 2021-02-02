<?php $this->load->view('template/header'); ?>

 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Total Unverified Data
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">  Total Unverified Data</li>
      </ol>
    </section>


    <section class="content">
      <div class="row">
        <div class="col-sm-12">
        <!-- Start Category Mpn Object Save -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Unverified Data</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div> 
            <div class="box-body">
            	<div class="col-md-12">
                <input type="hidden" name="bd_category" value="<?php echo $cat_id; ?>" id="bd_category">
	              <!-- Custom Tabs -->
	              <table id="unverifiedList" class="table table-responsive table-striped table-bordered table-hover categoryList">
	                <thead>
	                  <th>ACTION
	                  </th>
	                  <th>EBAY ID
	                  </th>
	                  <th>TITLE
	                  </th>
	                  <th>CONDITION
	                  </th>
	                  <th>SELLER
	                  </th>
	                  <th>BIN/AUCTION
	                  </th>
	                  <th>PRICE
	                  </th>
	                  <th>START DATE
	                  </th>
	                  <th>END DATE
	                  </th>
	                  <th>SELLER FEEDBACK
	                  </th>
	                </thead>
	              </table>
	            </div>
            </div>
          </div>
        </div>
       </div>
    </section>     
  </div>


<?php $this->load->view('template/footer'); ?>
<script type="text/javascript">
var dataTable='';
$(document).ready(function(){
	
	 dataTable = $('#unverifiedList').DataTable( {
      
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
      "bAutoWidth": false,
      rowId: 'staffId',
      "ajax":{
        url :"<?php echo base_url().'bigData/c_recog_title_mpn_kits/unVerifiedLoadData/'.$cat_id; ?>", // json datasource
        type: "post"  // method  , by default get
        // data: {},
        
        },
        "columnDefs":[{
            "target":[0],
            "orderable":false
          }
        ]

      });

 $("#unverifiedList").on('click','.delResultRow', function() {
    //alert(this.id);//return false;
    var id = this.id;
    var bd_category = $("#bd_category").val();
    $.ajax({
        url: '<?php echo base_url() ?>bigData/c_recog_title_mpn_kits/deleteResultRow/'+id, //maintains the (controller/function/argument) logic in the MVC pattern
        type: 'post',
        dataType: 'json',
        data : {'bd_category':bd_category},
        success: function(data){
            if(data == true){
              var row=$("#"+id);
              //var whichtr = $(this).closest("tr");
              //debugger;     
              row.fadeOut(1000, function() {
              row.closest("tr").remove();
              });
             //$('#'+id).remove();
            }
        },
        error: function(data){
           alert('Not Deleted');
        }
    });    
 });



});	

</script>