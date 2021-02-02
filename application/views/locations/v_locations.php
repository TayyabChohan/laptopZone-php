<?php $this->load->view('template/header'); 
      
?>
 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Locations
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Locations</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12"> 
<!-- 
  warehouse mt form insertion  start-->
       <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Warehouse</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
          <div class="box-body">
            <form action="<?php echo base_url().'locations/c_locations/add_warhouse'; ?>" method="post" accept-charset="utf-8">            
              <div class="col-sm-2">
                    <div class="form-group">
                      <label for="warehouse No" class="control-label">Warehouse No:</label>
                        <input type="number" class="form-control" id="ware_no" name="ware_no" placeholder="Enter Warehouse No" required>
                    </div>
              </div>

              <div class="col-sm-4">
                    <div class="form-group">
                      <label for="warehouse desc" class="control-label">Warehouse Description:</label>
                        <input type="text" class="form-control" id="ware_desc" name="ware_desc" placeholder="Enter Warehouse Description" required>
                    </div>
              </div>
              <div class="col-sm-4">
                    <div class="form-group">
                      <label for="warehouse Location" class="control-label">Warehouse Location:</label>
                        <input type="text" class="form-control" id="ware_loc" name="ware_loc" placeholder="Enter Warehouse Location" required>
                    </div>
              </div> 

              <div class="col-sm-2">
                    <div class="form-group">
                      <label for="warehouse desc" class="control-label"></label>                       
                      <button type="submit" title="Save Warehouse" id="save_ware" name ="save_ware" class="btn btn-primary form-control">Save</button>
                    </div>
              </div>                                          
                                    
          
            </form>                                              
             
          </div>
         </div>

         <!-- 
  warehouse mt form insertion  end-->
       
        </div>
      </div>

<!--       warehouse mt table data start
 -->
    <div class ="row">
      <div class ="col-sm-12">
        <div class="box">
          <div class="box-header with-border">
              <h3 class="box-title">Warehouse data</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>

            <div class="box-body form-scroll">
              <div class="col-sm-12">

                <table id="ware_house_table" class="table table-responsive table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>WAREHOUSE NO</th>
                      <th>WAREHOUSE DESCRIPTION</th>
                      <th>WAREHOUSE LOCATION</th>
                      
                    </tr>
                  </thead>
                  <tbody >
                  <tr>
                      <?php  
     //                  echo '<pre>';
     // print_r($detail['det_query']);
     // echo '</pre>';
     // exit; 
                        foreach($war_data['qry'] as $row) :?>
     
                     <!--  <td style = " font-size:17px; font-weight:500;"><?php //echo $row['EBAY_ID'];?></td> -->
                     
                      <td><?php echo @$row['WAREHOUSE_NO'];?></td>
                      <td><?php echo @$row['WAREHOUSE_DESC'];?></td>
                      <td><?php echo @$row['LOCATION'];?></td>
                      
                      
                     
                      </tr>
                        <?php endforeach; ?>
                  </tbody>
                </table>              
                            
              </div>
              
            </div>
        </div>
        
      </div>
      
    </div>
     <!--  warehouse mt data end  -->
    </section>
 
    <!-- /.content -->
  </div>  


 <?php $this->load->view('template/footer'); ?>
<script>
  $(document).ready(function()
  {
     $('#ware_house_table').DataTable({
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
          
});
//  $('#ware_house_table').DataTable({
//    "oLanguage": {
//    "sInfo": "Total Records: _TOTAL_"
//  },
//  "iDisplayLength": 50,
//  "paging": true,
//  "lengthChange": true,
//  "searching": true,
// "ordering": true,
//  "order": [[ 16, "ASC" ]],
//    "info": true,
//    "autoWidth": true,
//       "ajax": {
//             "url": "<?php //echo base_url(); ?>locations/c_locations/load_ware_data",
//             "type": "POST",
//             "dataType":"json"
//            //  success:function(data){  
//            //    // loop start        
//            //     var arr = [];
//            //        for(var i=0;i<data.qry.length;i++){ 

//            //        arr.push('<tr><td>'+data.qry[i].WAREHOUSE_ID+'</td><td>'+data.qry[i].WAREHOUSE_DESC+'</td></tr>');                 

//            //        } // loop end
//            //         $('#table_body ').html("");
                  
//            //       $('#table_body ').append(arr.join(""));
//            // }
//         },
//         "columns": [
//             { "data": "WAREHOUSE_ID" },
//             { "data": "WAREHOUSE_DESC" }
//         ],
      
 // });

// $(document).ready(function() {
//     $('#ware_house_table').DataTable( {
//         "processing": true,
//         "serverSide": true,
//         "ajax": {
//             "url": "<?php //echo base_url(); ?>locations/c_locations/load_ware_data",
//             "type": "POST"
//         },
//         "columns": [
//             { "data.qry": "WAREHOUSE_ID" },
//             { "data.qry": "WAREHOUSE_DESC" }
//         ]
//     } );
// } );
//   $(document).ready(function(){
    
        
//          $.ajax({
//             url:'<?php //echo base_url(); ?>locations/c_locations/load_ware_data',
//             type:'post',
//             dataType:'json',
//             data:{},
//             success:function(data){  
//               // loop start        
//                var arr = [];
//                   for(var i=0;i<data.qry.length;i++){ 

//                   arr.push('<tr><td>'+data.qry[i].WAREHOUSE_ID+'</td><td>'+data.qry[i].WAREHOUSE_DESC+'</td></tr>');                 

//                   } // loop end
//                    $('#table_body ').html("");
                  
//                  $('#table_body ').append(arr.join(""));
//            }
//           });
        
             
    
// });

//   $('#save_ware').on('click',function(){
//    var ware_no = $('#ware_no').val();
//    var ware_desc = $('#ware_desc').val();
//    if(ware_no == ''){
//     alert('ware hosue no is null');
//    }else if (ware_desc == ''){
//     alert('warehose Description is null')
//    }else{
//      $.ajax({
//         url:'<?php //echo base_url(); ?>locations/c_locations/add_warhouse',
//         type:'post',
//         dataType:'json',
//         data:{'ware_no':ware_no ,'ware_desc':ware_desc},
//         success:function(data){
      
//             console.log('saved success');
//             $('#ware_no').val('');
//             $('#ware_desc').val('');           
       
//       }
//       });
//      } 
         
// });
 

</script>
