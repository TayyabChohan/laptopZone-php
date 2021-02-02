<?php $this->load->view('template/header'); 
      
?>
 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Bin
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Bin</li>
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
              <h3 class="box-title">Add Bin</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
          <div class="box-body">
            <form action="<?php echo base_url().'locations/c_locations/add_bin'; ?>" method="post" accept-charset="utf-8">   
            <div class="col-sm-2">
                  <div class="form-group" >
                    <?php //var_dump($this->session->userdata('title_sort'));?>
                    <label for="bin_type">Bin Type:</label>
                    <?php ///$this->session->unset_userdata('title_sort'); ?>
                    <?php
                    $arrstate = array ('TC' => 'Technician Bin','PB' => 'Picture Bin','AB' => 'Audit Bin','WB' => 'Warehouse Bin','NA' => 'Fixed Bin','UB' => 'Puller Bin'); ?>
                    <select class="form-control selectpicker bin_type" name="bin_type" id="bin_type" data-live-search="true" required>
                    <option value="1">All</option>
                    <?php
                    foreach($arrstate as $key => $value) {
                    ?>
                    <option value="<?php echo $key; ?>"  <?php if($this->session->userdata('bin_type_search') == $key){echo "selected";}?>><?php echo $value; ?></option>
                    <?php
                    }
                    ?>
                    </select>

             

                  </div>
                </div>

                <div class="col-sm-2">
                        <label for="no_bin">No Of Bins</label>
                        <div class="form-group">
                        <input type="number" name="no_bin" id="no_bin" class="form-control" value = "1" placeholder="Enter No Of Bins" required>
                      </div>
                    </div>
              

              <div class="col-sm-1">
                    <div class="form-group">
                      <label for="warehouse desc" class="control-label"></label>                  
                       <input type="submit" title="Save Warehouse" id="save_bin" name = "save_bin" class="btn btn-primary form-control" value ="Add bin">     
                     
                    </div>
              </div>

              <div class="col-sm-2">
                  <div class="form-group" >
                    <?php //var_dump($this->session->userdata('title_sort'));?>
                    <label for="bin_stat">Print Status:</label>
                    <?php ///$this->session->unset_userdata('title_sort'); ?>
                    <?php
                    $bin_stat = array ('1' => 'Not Printed' , '2' => 'Printed'); ?>
                    <select class="form-control selectpicker print_sta" name="print_sta" id="print_sta" data-live-search="true" >
                    <option value="">Select Status</option>
                    <?php
                    foreach($bin_stat as $key => $value) {
                    ?>
                    <option value="<?php echo $key; ?>"  <?php if($this->session->userdata('print_sta') == $key){echo "selected";}?>><?php echo $value; ?></option>
                    <?php
                    }
                    ?>
                    </select>

             

                  </div>
                </div>

              <div class="col-sm-1">
                    <div class="form-group">
                      <label for="Search Bin" class="control-label"></label>                  
                       <input type="submit" title="Save Warehouse" id="search_bin" name = "search_bin" class="btn btn-success form-control" value ="Search Bin">     
                     
                    </div>
              </div>
              <div class="col-sm-1 pull-right">
                    <div class="form-group">
                      <label for="print_all" class="control-label"></label>                  
                       <input  title="Save Warehouse" id="print_all" name = "print_all" class="btn btn-danger form-control " value ="Print All">     
                     
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
              
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>

            </div>

            <div class="box-body form-scroll">
              <div class="col-sm-12">

                <table id="bin_table" class="table table-responsive table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>STICKER</th>
                      <th>BIN NO</th>
                     
                     
                      <th>Print Status</th>
                     
                      
                    </tr>
                  </thead>
                  <tbody >
                  <tr>
                      <?php  
     //                  echo '<pre>';
     // print_r($detail['det_query']);
     // echo '</pre>';
     // exit; 
                        foreach($war_data['binqry'] as $row) :
                      $print_status = $row['PRINT_STATUS']; ?>
                     <!--  <td style = " font-size:17px; font-weight:500;"><?php //echo $row['EBAY_ID'];?></td> -->
                     <td>
                      <div style="float:left;margin-right:8px;">
                              <a href="<?php echo base_url(); ?>locations/c_locations/print_single_bin/<?php echo $row['BIN_ID']; ?>" title="Print Sticker" class="btn btn-primary btn-sm" target="_blank">
                                <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                              </a>                              
                            </div>
                      </td> 
                      <td ><?php echo @$row['BIN_NO'];?></td>
                      

                      <?php if ($print_status == 1) { ?>
                       <td><span class="fa fa-close" aria-hidden="true" style="color:red; font-size:30px;"></span></td>
                      <?php } else { ?>

                      <td><span  class="fa fa-check" aria-hidden="true" style="color:green; font-size:30px;"></span></td>

                      <?php } ?>
                   <!--     -->
                      
                      
                      
                     
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
     $('#bin_table').DataTable({
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


  $('#print_all').on('click',function(){
    var bin_type = $('#bin_type').val();
    var print_sta = $('#print_sta').val();

if (bin_type == 1){
  alert("Select Bin Type and click search ");
  return false;

}else if(print_sta == ''){

  alert("Select Print Status and click search");

  return false;
}

else{
  window.open('<?php echo base_url(); ?>locations/c_locations/print_all_bin/'+bin_type+'/'+print_sta ,'_blank');

}

console.log(bin_type,print_sta);

    // alert("hid");
    // return false;

  });

</script>
