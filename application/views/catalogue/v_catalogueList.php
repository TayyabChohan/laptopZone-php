<?php $this->load->view('template/header'); 
ini_set('memory_limit', '-1'); // add for picture loading issue
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Catalogue List
    </h1>
    <ol class="breadcrumb">
      <li>
        <a href="<?php echo base_url();?>dashboard/dashboard">
          <i class="fa fa-dashboard">
          </i> Home
        </a>
      </li>
      <li class="active">Catalogue List
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
                <a title="Add Category Data" class="btn btn-primary btn-sm" href="<?php echo base_url(); ?>catalogue/c_itemCatalogue" target="_blank">Add Catalogue
                </a>
              </div>
            </div>
          </div> 
          <div class="col-sm-12">
            <!-- <form   accept-charset="utf-8"> -->

                <div class="col-sm-4">
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
               

                <div class="col-sm-1">
                  <div class="form-group p-t-24">
                    <input type="submit" class="btn btn-primary btn-sm" name="search_list" id="search_list" value="Search">
                  </div>
                </div>

            <!-- </form> -->
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
              <table id="categoryList" class="table table-responsive table-striped table-bordered table-hover categoryList">
                <thead>
                  <th>ACTIONS
                  </th>
                  <th>MPN
                  </th>
                  <th>INSERTED DATE
                  </th>
                  <th>INSERTED BY
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
  var dataTable='';
  $(document).on('click','#search_list',function(){
    if(dataTable !=''){
      dataTable.destroy();
    }
    
    var category = $('#bd_category').val();
    // alert(category);return false;
    // var category = parseInt(category);
    /*///////////////////////////////*/
    // $('#categoryList').empty();
    // dataTable.destroy();
    dataTable = $('#categoryList').DataTable( {
      
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
        url :"<?php echo base_url() ?>catalogue/c_itemCatalogue/loadData", // json datasource
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

  // ====== on click Delete Row ======//
$(document).on('click', ".del_mpn_data", function(){
   //alert('clicked');
   if(confirm('Are you sure you want to delete?')){


    var deleteID = this.id.match(/\d+/);
    deleteID = parseInt(deleteID);
    $.ajax({
      dataType: "json",
      data:{'deleteID':deleteID},
      url : "<?php echo base_url()?>catalogue/c_itemCatalogue/deleteCatalogue",
      type: "POST",
      success : function(data){
        if(data == 1){
          alert('Record Deleted Successfully!');
        }
        else{
          alert('Record not Deleted! Try Again');
        }
        if(dataTable !=''){
      dataTable.destroy();
    }
    
    var category = $('#bd_category').val();
    // alert(category);return false;
    // var category = parseInt(category);
    /*///////////////////////////////*/
    // $('#categoryList').empty();
    // dataTable.destroy();
    dataTable = $('#categoryList').DataTable( {
      
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
        url :"<?php echo base_url() ?>catalogue/c_itemCatalogue/loadData", // json datasource
        type: "post"  // method  , by default get
        // data: {},
        
        },
        "columnDefs":[{
            "target":[0],
            "orderable":false
          }
        ]

      });
      }
    });
  }// confirm if close
 });

  
  //======   ======//
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

  $(document).on('click', "a.catalogues_detail", function(){
       
    var $id = this.id;
    // alert($id);
    $.ajax({
        dataType: 'json',
        type: 'POST',
        url:'<?php echo base_url(); ?>catalogue/c_itemCatalogue/showCatalogueDetail',
        data: { '$id' : $id},
        success: function(data){
          

            var myWindow = window.open("", "MsgWindow", "width=800,height=600");

            myWindow.document.write('<html><head><title>Laptopzone | Catalogue Details</title><link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css');?>"><link rel="stylesheet" href="<?php echo base_url('assets/dist/css/AdminLTE.min.css');?>"><link rel="stylesheet" href="<?php echo base_url('assets/dist/css/skins/_all-skins.min.css');?>"></head><body> <div class="col-sm-12" id="tableData"></div>');
      
            
            // var table = '<table class="table table-bordered table-striped table-responsive table-hover" id="catalogue_data"></table>';
          //   var label = '<div class="box"><div class="box-header w-border" style="background-color: #3c8dbc !important;color:#fff !important;"><h4 class="box-title">Catalogue Details</h4></div></div><div class="col-xs-6"><div class="form-group"><label for="">Specific Value:</label><span class="text"> &nbsp;&nbsp;'+data.original[0].SPECIFIC_VALUE+'</span></div></div></div><div class="col-xs-6"><div class="form-group"><label for=""></label><span class="text"> &nbsp;&nbsp;</span></div></div><br><div class="row"><div class="col-sm-12" ><div class="form-group" style="border: 1px solid #ccc !important; padding: 3px 10 !important;"><label for="">Alternate Specific Value:</label>'; myWindow.document.write(label);

          //   for(i = 0;i<data.alt.length;i++){
          
          //     myWindow.document.write('<li class="text"> &nbsp;&nbsp;'+data.alt[i].SPEC_ALT_VALUE+'</li>');           

          //   }
        // var data = $('#tableData').append('<div class="col-sm-4"><h4 style="font-weight: bold;">MPN: '+data.catalogue_data[0].MPN+'</h4></div><div class="col-sm-4"><h4 style="font-weight: bold;">INSERTED DATE: '+data.catalogue_data[0].INSERT_DATE+'</h4></div>');
        var catalogue_data = []; // to save Specific_Name and Specific_Value
        var groupedCatalogue = [];// to add rowspan according to group value
        var catalogueJoin = [];// for combined value of catalogue_data and groupedCatalogue
        
        for(var j= 0;j<data.groupCount.length; j++){

          groupedCatalogue.push('<tr><td rowspan="'+data.groupCount[j].ROW_SPAN+'">'+data.groupCount[j].CATALOGUE_GROUP_VALUE+'</td>');
            for (var i = 0; i < data.catalogue_data.length; i++) {
                if(data.catalogue_data[i].CATALOGUE_GROUP_ID == data.groupCount[j].CATALOGUE_GROUP_ID){
                  // if group_id is same then all value in same row
                  catalogue_data.push('<td>'+data.catalogue_data[i].SPECIFIC_NAME+'</td><td>'+data.catalogue_data[i].SPECIFIC_VALUE+'</td></tr>'); 
                  //This adds each thing we want to append to the array in order.
                  if(i<data.catalogue_data.length-1){
                    //to check if next index value is same as previous
                    if(data.catalogue_data[i+1].CATALOGUE_GROUP_ID != data.groupCount[j].CATALOGUE_GROUP_ID){
                      //if the next group_id is not same then the row is completed
                      catalogueJoin.push(groupedCatalogue.join("")+catalogue_data.join(""));
                      groupedCatalogue = [];

                      catalogue_data = [];
                    }

                  }else{
                    //if loop is reached to last index then their value must be same so its a complete row
                    if(data.catalogue_data[i].CATALOGUE_GROUP_ID == data.groupCount[j].CATALOGUE_GROUP_ID){
                      catalogueJoin.push(groupedCatalogue.join("")+catalogue_data.join(""));
                      groupedCatalogue = [];

                      catalogue_data = [];
                    }
                  }
                  
                }
            }
            
        }
        //console.log()
        //Since we defined our variable as an array up there we join it here into a string
         // $("#catalogue_data").html("");
       

       myWindow.document.write('<div class="col-sm-12" id="tableData"><div class="col-sm-4"><h4 style="font-weight: bold;">MPN: '+data.catalogue_data[0].MPN+'</h4></div><div class="col-sm-4"><h4 style="font-weight: bold;">INSERTED DATE: '+data.catalogue_data[0].INSERT_DATE+'</h4></div></div><table class="table table-bordered table-striped table-responsive table-hover" id="catalogue_data"><thead> <th> Group Value</th> <th>Specific Name</th> <th>Specific Value</th></thead><tbody>'+catalogueJoin.join("")+'</tbody></table>'); 

       
        myWindow.document.write('</div></div></div><div class="row"><div class="col-sm-12"><div class="box"><div class="box-header with-border" style="background-color: #3c8dbc !important;color:#fff !important;"><strong style="margin-left:12px;">Copyright &copy; <?php //echo date('Y'); ?> <a href="#" style="color:#fff !important;">Laptop Zone</a>.</strong> All rights reserved.</div></div></div></div></body></html>');
          
        }
      });
  });

  // <-- time in milliseconds        
  /*===== Success message auto hide ====*/    
</script>