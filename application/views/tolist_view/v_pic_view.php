<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1');   // add for picture loading issue
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Seed &amp; Listing
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Pic &amp; Approval</li>
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
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>              
            </div>
           

            <div class="box-body">
              <form action="<?php echo base_url(); ?>tolist/c_tolist/pic_view" method="post" accept-charset="utf-8">

                <div class="col-sm-7">
                    <div class="form-group">
                     <?php //$purchase_no = $this->session->userdata('purchase_no'); ?>
                        <input class="form-control" type="text" name="purchase_no" id="purchase_no" value="<?php //if(isset($purchase_no)){echo $purchase_no; $this->session->unset_userdata('purchase_no');}  ?>" placeholder="Enter Purchase Ref No / Manifest Id">
                    </div>                                     
                </div> 
                  <div class="col-sm-2">
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" name="Submit" value="Search">
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="form-group">
                    <a style="text-decoration: underline;" href="<?php echo base_url();?>tolist/c_tolist/lister_view" target="_blank">Item Listing</a>
                        &nbsp;&nbsp;&nbsp;&nbsp;   |&nbsp;&nbsp;&nbsp;&nbsp;  
                    <a style="text-decoration: underline;" href="<?php echo base_url();?>tolist/c_tolist/listedItemsAudit" target="_blank">Listed Items Audit</a>    
                    </div>

                  </div>  
                  <div class="col-sm-3">
                        <!-- <h4><strong>Search Item</strong></h4> -->
                        <div class="form-group">
                            <label for="scan_bin" class="control-label">Scan Bin No:</label>
                            <input class="form-control" type="text" name="scan_bin" id="scan_bin" value="" placeholder="Scan Bin">
                        </div>                                     
                    </div>                                                      
              </form>
            </div>
        </div>  


        <div class="box">
           
        <div class="box-body form-scroll">      
        <div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Pic Approval</a></li>
              <li ><a href="#tab_2" data-toggle="tab">Without Pictures</a></li>
            </ul>
            <div class="tab-content">
              <!-- pic approval tab start-->
              <div class="tab-pane active" id="tab_1">
                <table id="picApproval" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>

                          <div style="width: 80px!important;">
                           
                            <input class="" name="btSelectAll" type="checkbox" onclick="toggleApproval(this)">&nbsp;Select All
                          </div>
                        </th>                      
                        <th>ACTION</th>
                        <th>CONDITION</th>
                        <th>BARCODE</th>
                        <th>TITLE</th>
                        <th>AVAILABLE QTY</th>
                        <th>PURCH REF NO</th>
                        <th>UPC</th>
                        <th>MPN</th>
                        <th>MANUFACTURE</th>
                        <th>DAYS ON SHELF</th>
                        
                    </tr>
                    </thead>

                    <tbody>
                      <?php 
                      // var_dump($data);exit;
                      foreach (@$data['listing_without_pic_qry'] as $row):
                      if(empty($row['APPROVED_BY']) && empty($row['APPROVED_DATE']))://Approved pic only 
                      $it_condition  = @$row['ITEM_CONDITION'];
                    if(is_numeric(@$it_condition)){
                        if(@$it_condition == 3000){
                          @$it_condition = 'Used';
                        }elseif(@$it_condition == 1000){
                          @$it_condition = 'New'; 
                        }elseif(@$it_condition == 1500){
                          @$it_condition = 'New other'; 
                        }elseif(@$it_condition == 2000){
                            @$it_condition = 'Manufacturer refurbished';
                        }elseif(@$it_condition == 2500){
                          @$it_condition = 'Seller refurbished'; 
                        }elseif(@$it_condition == 7000){
                          @$it_condition = 'For parts or not working'; 
                        }
                      }
                        $mpn = str_replace('/', '_', @$row['MFG_PART_NO']);
                        $master_path = $data['path_query'][0]['MASTER_PATH'];
                        $m_dir =  $master_path.@$row['UPC']."~".@$mpn."/".@$it_condition."/";
                        $m_dir = preg_replace("/[\r\n]*/","",$m_dir);
                        $specific_path = $data['path_query'][0]['SPECIFIC_PATH'];

                        $s_dir = $specific_path.@$row['UPC']."~".$mpn."/".@$it_condition."/".@$row['LZ_MANIFEST_ID'];
                        $s_dir = preg_replace("/[\r\n]*/","",$s_dir);

                        if(is_dir(@$m_dir)){
                                    $iterator = new \FilesystemIterator(@$m_dir);
                                    if (@$iterator->valid()){    
                                      $m_flag = true;
                                  }else{
                                    $m_flag = false;
                                  }
                              }elseif(is_dir(@$s_dir)){
                                $iterator = new \FilesystemIterator(@$s_dir);
                                    if (@$iterator->valid()){    
                                      $m_flag = true;
                                  }else{
                                    $m_flag = false;
                                  }
                              }else{
                                $m_flag = false;
                              }
                          if($m_flag):   
                        ?>


                      <tr>

                        <td>
                          <div style="width: 80px!important;">

                            <div style="float:left;margin-right:8px;">
                              <input title="Check to Assign Listing to users" type="checkbox" name="approval[]" id="approval" value="<?php echo $row['SEED_ID']; ?>">
                            </div>                     

                          </div>
                        </td>                                         
                        <td>
                          <div style="width:100px;">
                            <div style="float:left;margin-right:8px;">
                             <a href="<?php echo base_url(); ?>tolist/c_tolist/seed_view/<?php echo $row['SEED_ID'] ?>" title="Create/Edit Seed" class="btn btn-primary btn-sm" target="_blank"><span class="glyphicon glyphicon-leaf" aria-hidden="true"></span></a>
                             </div>                         

                          </div>
                        </td>
                 
                      <td>
                      <?php 
                        if(@$row['ITEM_CONDITION'] == 3000 ){echo "USED";}
                        elseif(@$row['ITEM_CONDITION'] == 1000 ){echo "NEW";}
                        elseif(@$row['ITEM_CONDITION'] == 1500 ){echo "NEW OTHER";}
                        elseif(@$row['ITEM_CONDITION'] == 2000 ){echo "MANUFACTURER REFURBISHED";}
                        elseif(@$row['ITEM_CONDITION'] == 2500 ){echo "SELLER REFURBISHED";}
                        elseif(@$row['ITEM_CONDITION'] == 7000 ){echo "FOR PARTS OR NOT WORKING";}
                        elseif(@$row['ITEM_CONDITION'] == 4000 ){echo "VERY GOOD";}
                        elseif(@$row['ITEM_CONDITION'] == 5000 ){echo "GOOD";}
                        elseif(@$row['ITEM_CONDITION'] == 6000 ){echo "ACCEPTABLE";}
                        else{echo @$row['ITEM_CONDITION'];}
                      ?>
                        
                      </td>
                      <td>                      
                         <div style="width:150px;">
                          <?php 
                          $get_barcod = '';
                            foreach (@$data['not_listed_barcode'] as $barcode) {
                              if(@$barcode['ITEM_ID'] == @$row['ITEM_ID'] && @$barcode['LZ_MANIFEST_ID'] == @$row['LZ_MANIFEST_ID'] && @$barcode['CONDITION_ID'] == @$row['ITEM_CONDITION'] ){
                              $get_barcod .= @$barcode['BARCODE_NO']." - ";

                              }
                            }                            
                          ?>
                        <?php echo $get_barcod ?>
                        </div>

                      </td>              
                      <td><?php echo @$row['ITEM_MT_DESC'];?></td>
                      <td><?php echo @$row['QUANTITY']; ?></td>
                      <!-- <td></td> -->
                      <td><?php echo @$row['PURCH_REF_NO'];?></td>
                      <td><?php echo @$row['UPC'];?></td>
                      <td><?php echo @$row['MFG_PART_NO'];?></td>
                      <td><?php echo @$row['MANUFACTURER'];?></td>                  
                      <td>
                      <?php 
                           
                        $current_timestamp = date('m/d/Y');
                        $purchase_date = @$row['LOADING_DATE'];
                        
                        $date1=date_create($current_timestamp);
                        $date2=date_create($purchase_date);
                        $diff=date_diff($date1,$date2);
                        $date_rslt = $diff->format("%R%a days");
                        echo abs($date_rslt)." Days"; 

                      ?>
                      </td>
                        
                    </tr>
                    <?php
                    endif; // flag if
                    endif;//Approved pic only 
                    endforeach;

                    ?>
                             
                    </tbody>
                </table><br>

                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <button class="btn btn-success" name="approval_btn" id="approval_btn" >Approve</button>

                    </div>
                  </div>
                </div>

              </div>
              <!-- /.tab-pane -->
<!-- pic approval tab end--> 


<!-- Without Pictures start-->
              <div class="tab-pane" id="tab_2">
                <table id="withoutPictures" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>ACTION</th>
                        <th>CONDITION</th>
                        <th>BARCODE</th>
                        <th>TITLE</th>
                        <th>AVAILABLE QTY</th>
                        <th>PURCH REF NO</th>
                        <th>UPC</th>
                        <th>MPN</th>
                        <th>MANUFACTURE</th>
                        <th>DAYS ON SHELF</th>
                        
                    </tr>
                    </thead>

                    <tbody>
                      <?php 
                      // var_dump($data);exit;
                      foreach (@$data['listing_without_pic_qry'] as $row): 
                      $it_condition  = @$row['ITEM_CONDITION'];
                    if(is_numeric(@$it_condition)){
                        if(@$it_condition == 3000){
                          @$it_condition = 'Used';
                        }elseif(@$it_condition == 1000){
                          @$it_condition = 'New'; 
                        }elseif(@$it_condition == 1500){
                          @$it_condition = 'New other'; 
                        }elseif(@$it_condition == 2000){
                            @$it_condition = 'Manufacturer refurbished';
                        }elseif(@$it_condition == 2500){
                          @$it_condition = 'Seller refurbished'; 
                        }elseif(@$it_condition == 7000){
                          @$it_condition = 'For parts or not working'; 
                        }
                      }
                        $mpn = str_replace('/', '_', @$row['MFG_PART_NO']);
                        $master_path = $data['path_query'][0]['MASTER_PATH'];
                        $m_dir =  $master_path.@$row['UPC']."~".@$mpn."/".@$it_condition."/";
                        $m_dir = preg_replace("/[\r\n]*/","",$m_dir);

                        $specific_path = $data['path_query'][0]['SPECIFIC_PATH'];

                        $s_dir = $specific_path.@$row['UPC']."~".$mpn."/".@$it_condition."/".@$row['LZ_MANIFEST_ID'];
                        $s_dir = preg_replace("/[\r\n]*/","",$s_dir);
                            //var_dump($m_dir,$s_dir);
                        if(is_dir(@$m_dir)){
                                    $iterator = new \FilesystemIterator(@$m_dir);
                                    if (@$iterator->valid()){    
                                      $m_flag = false;
                                  }else{
                                    $m_flag = true;
                                  }
                              }elseif(is_dir(@$s_dir)){
                                $iterator = new \FilesystemIterator(@$s_dir);
                                    if (@$iterator->valid()){    
                                      $m_flag = false;
                                  }else{
                                    $m_flag = true;
                                  }
                              }else{
                                $m_flag = true;
                              }
                          if($m_flag):
                        ?>


                      <tr>                   
                        <td>
                          <div style="width:100px;">

                            <div style="float:left;margin-right:8px;">
                             <a href="<?php echo base_url(); ?>tolist/c_tolist/seed_view/<?php echo $row['SEED_ID'] ?>" title="Create/Edit Seed" class="btn btn-primary btn-sm" target="_blank"><span class="glyphicon glyphicon-leaf" aria-hidden="true"></span></a>
                             </div>                         

                          </div>
                        </td>
                   
                      <td>
                      <?php 
                        if(@$row['ITEM_CONDITION'] == 3000 ){echo "USED";}
                        elseif(@$row['ITEM_CONDITION'] == 1000 ){echo "NEW";}
                        elseif(@$row['ITEM_CONDITION'] == 1500 ){echo "NEW OTHER";}
                        elseif(@$row['ITEM_CONDITION'] == 2000 ){echo "MANUFACTURER REFURBISHED";}
                        elseif(@$row['ITEM_CONDITION'] == 2500 ){echo "SELLER REFURBISHED";}
                        elseif(@$row['ITEM_CONDITION'] == 7000 ){echo "FOR PARTS OR NOT WORKING";}
                        elseif(@$row['ITEM_CONDITION'] == 4000 ){echo "VERY GOOD";}
                        elseif(@$row['ITEM_CONDITION'] == 5000 ){echo "GOOD";}
                        elseif(@$row['ITEM_CONDITION'] == 6000 ){echo "ACCEPTABLE";}
                        else{echo @$row['ITEM_CONDITION'];}
                      ?>
                        
                      </td>
                      <td>
                         <div style="width:150px;">
                          <?php 
                            foreach (@$data['not_listed_barcode'] as $barcode) {
                              if(@$barcode['ITEM_ID'] == @$row['ITEM_ID'] && @$barcode['LZ_MANIFEST_ID'] == @$row['LZ_MANIFEST_ID'] && @$barcode['CONDITION_ID'] == @$row['ITEM_CONDITION'] ){
                              echo @$barcode['BARCODE_NO']." - ";

                              }
                            }
                          ?>
                        </div>
                          
                        </td>              
                      <td><?php echo @$row['ITEM_MT_DESC'];?></td>
                      <td><?php echo @$row['QUANTITY']; ?></td>
                      <td><?php echo @$row['PURCH_REF_NO'];?></td>
                      <td><?php echo @$row['UPC'];?></td>
                      <td><?php echo @$row['MFG_PART_NO'];?></td>
                      <td><?php echo @$row['MANUFACTURER'];?></td>                  
                      <td>
                      <?php 
                           
                        $current_timestamp = date('m/d/Y');
                        $purchase_date = @$row['LOADING_DATE'];
                        
                        $date1=date_create($current_timestamp);
                        $date2=date_create($purchase_date);
                        $diff=date_diff($date1,$date2);
                        $date_rslt = $diff->format("%R%a days");
                        echo abs($date_rslt)." Days"; 

                      ?>
                      </td>
                        
                    </tr>
                    <?php
                    endif;  
                    endforeach;
                    ?>
                             
                    </tbody>
                </table><br>
              </div>
              <!-- /.tab-pane -->
<!-- Without pictures end-->      

                     
            </div>



            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
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
    =            Approval for Listing            =
================================================*/

$("#approval_btn").click(function () {
  var approval = [];
  //var get_bar = [];
  var scan_bin  =   $("#scan_bin").val();

  $.each($("input[name='approval[]']:checked"), function(){  
  //get_bar.push($.trim($(this).closest('tr').find('td').eq(3).text()));          
   approval.push($(this).val());
  });    
    //console.log(get_bar, approval); 
    //return false;
  if(approval.length == 0)
  {
    alert('Please select atleast one.');return false;
  }
  // console.log(get_bar);
  // return false;

    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>tolist/c_tolist/approvalForListing',
      data: { 'approval':approval,'scan_bin':scan_bin           
    },
     success: function (data) {
      //alert(data);return false;
        if(data == true)
        {
          alert('Selected items Approved for Listing.');
          window.location.reload();
          
        }
        else if(data == false)
        {
          alert('Error - Selected items Approved for Listing.');
          //window.location.reload();
        }else if(data == 2)
        {
          alert('Warning - Please insert valid Bin No.');
          $("#scan_bin").focus();
        }
      }
      });  

});

/*=====  End of Approval for Listing  ======*/   
 </script>