<?php $this->load->view('template/header'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Lister View
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Lister View</li>
      </ol>
    </section>    
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Search Lister</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>              
            </div>
                <div class="box-body">
                    <form action="<?php echo base_url(); ?>lister/lister_screen/search_lister" method="post">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <select name="user_id" id="user_id" class="form-control">
                                  <option value=''>Select User</option>
                                <?php foreach($lister as $row):?>
                                  
                                <?php $u_name = ucfirst($row['USER_NAME']);;
                                  $employee_id = $row['EMPLOYEE_ID'];
                                ?>
                                    <option value="<?php echo $employee_id;?>" <?php if($this->session->userdata('u_id') == $employee_id){echo "selected";} ?>><?php echo $u_name;?></option>
                            <?php endforeach; ?>
                                    <option value="PK" <?php if($this->session->userdata('u_id') == "PK"){echo "selected";} ?>><?php echo "Pak Lister";?></option> 
                                    <option value="US" <?php if($this->session->userdata('u_id') == "US"){echo "selected";} ?>><?php echo "US Lister";?></option> 
                                    <option value="All" <?php if($this->session->userdata('u_id') == "All"){echo "selected";} ?>><?php echo "All Lister";?></option>  
                                </select>
                            </div>                                     
                        </div>
                        <div class="col-sm-3">
                          <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <?php $rslt = $this->session->userdata('date_range'); ?>
                              <input type="text" class="btn btn-default" name="date_range" id="daterange-btn" value="<?php echo $rslt; ?>">

                            </div>
                          </div>
                        </div>
                   
                        <div class="col-sm-3">

                        <?php $lister_radio = $this->session->userdata('lister');
                            if($lister_radio == 2){
                              echo "<input type='radio' name='lister' value='2' checked>&nbsp;Dfwonline&nbsp;
                                <input type='radio' name='lister' value='1'>&nbsp;Techbargain&nbsp;
                                <input type='radio' name='lister' value='Both'>&nbsp;Both";
                                $this->session->unset_userdata('lister');
                            }elseif($lister_radio == 1){
                              echo "<input type='radio' name='lister' value='2' >&nbsp;Dfwonline&nbsp;
                                <input type='radio' name='lister' value='1' checked>&nbsp;Techbargain&nbsp;
                                <input type='radio' name='lister' value='Both' >&nbsp;Both";
                                $this->session->unset_userdata('lister');

                            }elseif($lister_radio == 'Both'){
                              echo "<input type='radio' name='lister' value='2' >&nbsp;Dfwonline&nbsp;
                                <input type='radio' name='lister' value='1'>&nbsp;Techbargain&nbsp;
                                <input type='radio' name='lister' value='Both' checked>&nbsp;Both";
                                $this->session->unset_userdata('lister');

                            }else{
                              echo "<input type='radio' name='lister' value='2' >&nbsp;Dfwonline&nbsp;
                                <input type='radio' name='lister' value='1'>&nbsp;Techbargain&nbsp;
                                <input type='radio' name='lister' value='Both' checked>&nbsp;Both";
                            }?>                        
                           <!--  <input type='radio' name='lister' value='Dfwonline' checked>&nbsp;Dfwonline&nbsp;
                            <input type='radio' name='lister' value='Techbargain'>&nbsp;Techbargain&nbsp;
                            <input type='radio' name='lister' value='Both'>&nbsp;Both   -->                          
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="submit" title="Search Listers" class="btn btn-primary" name="Submit" value="Search">
                            </div>
                        </div>                                 
                    </form>
                    <?php 
                      $form_submit = '';
                      $form_submit = $searching_data['submit'];
                    //[$submit, $lister_radio, $user_id,$from,$to]; ?>
                    <input type="hidden" name="lister_radio_button" id="lister_radio_button" value="<?php echo $searching_data['lister_radio']; ?>">
                    <input type="hidden" name="lz_user_id" id="lz_user_id" value="<?php echo $searching_data['user_id']; ?>">
                    <input type="hidden" name="from_val" id="from_val" value="<?php echo $searching_data['from']; ?>">
                    <input type="hidden" name="to_val" id="to_val" value="<?php echo $searching_data['to']; ?>">
                </div>
            </div> 
            <div class="box">    
                <div class="box-body form-scroll">
              <?php 
              //$login_id = $this->session->userdata('user_id');  
              //if($login_id == 2 || $login_id == 17 ){?>

              <table style="width: 25%;" class="table table-bordered">
    
                <thead>
                  <tr style="background-color:#f9f9f9;">
                    <th>Total Listing(Unique)</th>
                    <th>Total Price</th>
                  </tr>  
                </thead>
                <tbody>
                <tr>

                  <td>
                    <?php 
                    foreach (@$total_listing as $tk): 
                       @$total = $tk['TOTAL_LISTING']; 

                        echo number_format((float)@$total,0,'',',');
                        //echo @$total;
                    ?>
                    
                  </td>
                   <td>
                    <?php 
                    
                       @$total_price = $tk['TOTAL_PRICE']; 
                       echo '$ '.number_format((float)@$total_price,2,'.',',');
                    ?>
                    <?php endforeach ?> 
                  </td>
              <?php //} ?>
                </tr>
              </tbody>
              </table><br><br> 
              <table id="listerView" class="table table-bordered table-striped">
                  <thead>
                  <tr>

                      <th>TITLE</th>                                
                      <th>LISTER NAME</th>
                      <th>LIST DATE</th>
                      <th>EBAY ITEM ID</th>                                
                      <th>LIST PRICE</th>
                      <th>LIST QTY</th>
                      <th>AGING</th>
                      <th>ACCOUNT NAME</th>
                  </tr>
                  </thead>
                  <tbody>

         
                </tbody>
              </table><br>
                        
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
     var lister_radio_button      = '';
     var lz_user_id               = '';
     var from_val                 = '';
     var to_val                   = '';
     var form_data                = '';
   $(document).ready(function(){
    var form_data = '<?php echo $form_submit; ?>';
    //console.log(form_data); return false;
     var lister_radio_button      = $("#lister_radio_button").val();
     var lz_user_id               = $("#lz_user_id").val();
     var from_val                 = $("#from_val").val();
     var to_val                   = $("#to_val").val();
if (form_data === '' || form_data === null || form_data === undefined) {
  $("#listerView").dataTable().fnDestroy();
    $("#listerView").DataTable({
    "oLanguage": {
    "sInfo": "Total Items: _TOTAL_"
    },
    //"aaSorting": [[11,'desc'],[10,'desc']],
    //"order": [[ 10, "desc" ]],
    "fixedHeader": true,
    "paging": true,
    "iDisplayLength": 25,
    "aLengthMenu": [[25, 50, 100, 200,20000], [25, 50, 100, 200,20000]],
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
      url :"<?php echo base_url().'lister/lister_screen/loadListerData'?>", // json datasource
      type: "post" , // method  , by default get
      dataType: 'json',
      data: {
        'lister_radio_button':lister_radio_button,
        'lz_user_id':lz_user_id,
        'from_val':from_val,
        'to_val':to_val
      },
      },
      "columnDefs":[{
          "target":[0],
          "orderable":false
        }
      ]      
  });
  }else{
    $("#listerView").dataTable().fnDestroy();
    $("#listerView").DataTable({
    "oLanguage": {
    "sInfo": "Total Items: _TOTAL_"
    },
    //"aaSorting": [[11,'desc'],[10,'desc']],
    //"order": [[ 10, "desc" ]],
    "fixedHeader": true,
    "paging": true,
    "iDisplayLength": 25,
    "aLengthMenu": [[25, 50, 100, 200,20000], [25, 50, 100, 200,20000]],
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
      url :"<?php echo base_url().'lister/lister_screen/loadSearchListerData'?>", // json datasource
      type: "post" , // method  , by default get
      dataType: 'json',
      data: {
        'lister_radio_button':lister_radio_button,
        'lz_user_id':lz_user_id,
        'from_val':from_val,
        'to_val':to_val
      },
      },
      "columnDefs":[{
          "target":[0],
          "orderable":false
        }
      ]      
  });
  }
    
  /*==============================================================
  =   END FUNCTION FOR CHARGES CALCULATION FROM ESTIMATE PRICE   =
  ================================================================*/
   });
 </script>