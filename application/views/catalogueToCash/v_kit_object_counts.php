<?php $this->load->view('template/header'); ?> 

 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Kits Count
      <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Kits Count</li>
    </ol>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <!-- Start Category Mpn Object Save -->
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Filters</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
          </div>          
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
              <?php } ?> 
              <div class="col-sm-12">
              	<div class="col-sm-3">
             	  <div class="form-group">
                    <label for="Conditions" class="control-label">Category:</label>
                    <select name="bd_category" id="bd_category" class="form-control selectpicker" data-live-search="true" required>
                      <option value="0">---</option>
                      <?php                                
                         if(!empty($getCategories)){

                          foreach ($getCategories as $cat){

                              ?>
                              <option value="<?php echo $cat['CATEGORY_ID']; ?>" <?php if($this->session->userdata('bd_category') == $cat['CATEGORY_ID']){echo "selected";}?>> <?php echo $cat['CATEGORY_NAME'].'-'.$cat['CATEGORY_ID']; ?> </option>
                              <?php
                              } 
                          }
                          $this->session->unset_userdata('bd_category');
                          
                      ?>  
                                          
                    </select> 
                  </div>
              </div>

              <div class="col-sm-3 p-t-26">
                <div class="form-group">
                  <input type="button" value="search" id="search" class="btn btn-sm btn-success">
                </div>
              </div>

          	</div>
            

          </div>
        </div>
      </div>


      <div class="col-sm-12">
        <!-- Start Category Mpn Object Save -->
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Summary</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="box-body">
            <div class="col-sm-12">
              <div class="col-lg-2 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                  <div class="inner">
                    <p class="summarycardcss" id="kits_created"><?php //if (!empty($results['total_record'])) { echo $results['total_record'][0]['TOTAL_RECORD']; }else {
                      //echo "0";
                    //}
                    ?></p>
                    <p>Kits Created</p>
                  </div>
                  <div class="icon">
                    <i class="fa fa-database fa-1x"  aria-hidden="true"></i>
                  </div>
                  <a  class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>

              <div class="col-lg-2 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-green">
                    <div class="inner">
                      <p class="summarycardcss" id="not_created"><?php //if (!empty($results['total_record'])) { echo $results['total_record'][0]['TOTAL_RECORD']; }else {
                        //echo "0";
                      //}
                      ?></p>
                      <p>Kits Not Created</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-database fa-1x"  aria-hidden="true"></i>
                    </div>
                    <a  class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
              </div>
            </div>

          </div>
        </div>

      </div>

      <div class="col-sm-12">
        <!-- Start Category Mpn Object Save -->
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Kits</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="box-body">
      	 	<table id="kitsTable" class="table table-responsive table-striped table-bordered table-hover" >
          		<thead>
          			<th>MPN</th>
          			<th>KIT_COUNT</th>
          			<th>OBJECT_COUNT</th>
          		</thead>

          	</table>
          </div>

        </div>
      </div>
    </div>
  </section>
</div>

<?php $this->load->view('template/footer'); ?>
<script>
var dataTable='';
// $(document).ready(function(){
	
// 	if(dataTable !=''){
//       dataTable.destroy();
//     }
// 	dataTable = $('#kitsTable').DataTable( {
      
//       "oLanguage": {
//       "sInfo": "Total Records: _TOTAL_",
//       //"sPaginationType": "full_numbers",
//     },
//     // For stop ordering on a specific column
//     // "columnDefs": [ { "orderable": false, "targets": [0] }],
//     // "pageLength": 5,
//        "aLengthMenu": [25, 50, 100, 200],
//        "paging": true,
//       // "lengthChange": true,
//       "searching": true,
//       // "ordering": true,
//       "Filter":true,
//       // "iTotalDisplayRecords":10,
//       //"order": [[ 8, "desc" ]],
//       // "order": [[ 16, "ASC" ]],
//       "info": true,
//       // "autoWidth": true,
//       "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
//       "bProcessing": true,
//       "bRetrieve":true,
//       "bDestroy":true,
//       "bServerSide": true,
//       "bAutoWidth": false,
//       "ajax":{
//         // data:{'category':category},
//         url :"<?php //echo base_url() ?>catalogueToCash/c_kitsCount/loadData", // json datasource
//         type: "post"  // method  , by default get
//         // data: {},
        
//         },
//         "columnDefs":[{
//             "target":[0],
//             "orderable":false
//           }
//         ]

//       });
// });
    
$('#search').on('click',function(){

	var category = $('#bd_category').val();

  $.ajax({

        data:{'category':category},
        url :"<?php echo base_url() ?>catalogueToCash/c_kitsCount/summary", // json datasource
        type: "post" ,
        dataType: 'json',

        success : function(data){
          // alert(data.kitsCreated[0].KITS);return false;
          $('#kits_created').text(data.kitsCreated[0].KITS);

          $('#not_created').text(data.notCreated[0].NOT_CREATED);

        }

  });

	if(dataTable !=''){
      dataTable.destroy();
    }
	dataTable = $('#kitsTable').DataTable( {
      
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
      "ajax":{
        data:{'category':category},
        url :"<?php echo base_url() ?>catalogueToCash/c_kitsCount/loadData", // json datasource
        type: "post"  // method  , by default get
        // data: {},
        
        },
        "columnDefs":[{
            "target":[0],
            "orderable":false
          }
        ]

    });

});

</script>