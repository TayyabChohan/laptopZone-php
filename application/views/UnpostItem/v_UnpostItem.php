<?php $this->load->view('template/header'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Unpost Item
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Unpost Item</li>
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
            </div>
            <!-- /.box-header -->
               <div class="box-body">
                  <form action="<?php echo base_url(); ?>Unpostitem/c_Unpostitem" method="post" accept-charset="utf-8">
                      <div class="col-sm-8">
                          <!-- <h4><strong>Search Item</strong></h4> -->
                          <div class="form-group">
                              <input class="form-control" type="text" name="search" value="" placeholder="Enter a Valid Barcode">
                          </div>                                     
                      </div><div class="col-sm-2">
                          <!-- <h4><strong>Search Item</strong></h4> -->
                          <div class="form-group">
                             <input type='checkbox' name='show_all' value='All'>&nbsp; Show All
                          </div>                                     
                      </div>
                      <div class="col-sm-2">
                          <div class="form-group">
                              <input type="submit" class="btn btn-primary" name="Submit" value="Search">
                          </div>
                      </div>                                 
                  </form>
                    <div class="col-sm-12">
                  <?php if(@$data == 'deleted'){
                    echo '<div class="alert alert-success alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            Item <strong>Succsessfully</strong> deleted.
                          </div>';
                  }elseif(!empty(@$data['item_alloc'])){
                    echo '<div class="alert alert-warning alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            Item is <strong>Allocated.</strong> Please un-allocate item first.
                          </div>';                            
                  }elseif(!empty(@$data['item_holded'])){
                    echo '<div class="alert alert-warning alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            Item is <strong>Holded</strong> against this '.@$data["item_holded"].' Please un-hold item first.
                          </div>';                            
                  }
                  ?>
                  </div>
                </div>
                </div>  
                  <?php if(!empty($data) && $data != 'deleted' && empty(@$data['item_holded']) && empty(@$data['item_alloc'])): ?>
                  <!-- <table id="searchResults" class="table table-bordered table-striped"> -->
                    <div class="box">    
                    <div class="box-body form-scroll">
                    <form action="<?php echo base_url(); ?>UnpostItem/c_UnpostItem/UnpostItem" method="post">
                        <table id="ItemSearchResults" class="table table-bordered table-striped " >
                            <thead>
                            <tr>        
                        <th>
                          <div>
                           
                            <input class="" name="btSelectAll" type="checkbox" onclick="toggleUnpostItem(this)">&nbsp;Select All
                          </div>                        

                        </th>
                        <!-- <th>PICTURE</th> -->
                        <th>BARCODE</th>
                        <!-- <th>EBAY ID</th> -->
                        <!-- <th>IITEM ID</th>
                        <th>MANIFEST ID</th> -->
                        
                        <th>CONDITION</th>
                        <!-- <th>BARCODE</th> -->
                        <th>TITLE</th>
                        <th>AVAILABLE QTY</th>
                        
                        <!-- <th>HOLD QTY</th> -->
                        <th>PURCH REF NO</th>
                        <th>UPC</th>
                        <th>MPN</th>
                        <th>SKU</th>
                        <th>MANUFACTURE</th>
                        <!-- <th>COST</th>
                        <th>LINE TOTAL</th>   -->                         
                        <!-- <th>PURCHASE DATE</th> -->
                        <th>DAYS ON SHELF</th>

                            </tr>
                            </thead>

                            <tbody>
                            <?php 
                            //var_dump($data['query']);exit;
                            $i = 0;
                            foreach ($data['not_listed_barcode'] as $row): 
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
                        $specific_path = $data['path_query'][0]['SPECIFIC_PATH'];

                        $s_dir = $specific_path.@$row['UPC']."~".$mpn."/".@$it_condition."/".@$row['LZ_MANIFEST_ID']."/";
                            //var_dump($m_dir);exit;
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
                          
                        ?>

                      
                      <tr>                   
                        <td>
                          <div>
                            <div style="float:left;margin-right:8px;">
                              <input title="Check to Delete Item" type="checkbox" name="unpost_item[]" id="unpost_item" value="<?php echo @$row['BARCODE_NO']; ?>">
                            </div>                      

                          </div>
                        </td>
                      <!-- <td>
                        <?php
                  // if (is_dir($m_dir)){

                  //   $images = scandir($m_dir);
                  //   // Image selection and display:
                  //   //display first image
                  //   if (count($images) > 0) { // make sure at least one image exists
                  //       $url = $images[2]; // first image
                  //       $img = @file_get_contents($m_dir.$url);
                  //       if(@file_get_contents($m_dir.$url)){
                  //           $img = @base64_encode($img); ?>
                             <div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);cursor: pointer!important;">
                             <?php

                  //           echo '<img class="sort_img up-img" id="" name="" src="data:image;base64,'.$img.'"/>';
                  //           ?>
                             </div>
                         <?php
                  //   }else{
                  //       echo "Not Found";
                        
                  //   }
                  //   }
                    
                  // }elseif(is_dir($s_dir)){

                  //   $images = scandir($s_dir);
                  //   // Image selection and display:
                  //   //display first image
                  //   if (count($images) > 0) { // make sure at least one image exists
                  //       $url = $images[2]; // first image
                  //       $img = file_get_contents($s_dir.$url);
                  //       $img =base64_encode($img); ?>
                         <div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);cursor: pointer!important;">
                         <?php

                  //       echo '<img class="sort_img up-img" id="" name="" src="data:image;base64,'.$img.'"/>';
                  //       ?>
                         </div>
                         <?php
                      
                  //   }
                  // }else{
                  //   echo "Not Found";
                  // }


                ?>                                

                        </td> -->
                        <td><?php 
                        echo @$row['BARCODE_NO'];
                        //var_dump(@$data['barcode_qry']);exit;

                        // if(!empty(@$data['barcode_qry'])){
                        //   $it_barcode = @$data['barcode_qry'][$i];
                        //   echo $it_barcode; 
                        // }

                          ?></td>
                      <?php //$img = @$row['ITEM_PIC'];?>
                      <?php //if(!empty($img)):?>
                                                              
                      <?php //$img = @$row['ITEM_PIC']->load();?>
                      <?php //$pic=base64_encode(@$img);?>
                      <!-- <td><?php //echo "<img width='50px' height='50px' src='data:image/jpeg;base64,".@$pic."'/>";?></td> -->
                      <?php //else:?>
                     <!--  <td><?php// echo "Not found.";?></td> -->
                      <?php //endif;?> 

                        <!-- <td><?php //echo @$row['EBAY_ITEM_ID'];?></td>  -->               
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
                      <!-- <td><?php //echo @$row['IT_BARCODE'];?></td>  -->               
                      <td><?php echo @$row['ITEM_MT_DESC'];?></td>
                      <td>1<?php //echo @$row['QUANTITY']; ?></td>
                      <!-- <td></td> -->
                      <td><?php echo @$row['PURCH_REF_NO'];?></td>
                      <td><?php echo @$row['UPC'];?></td>
                      <td><?php echo @$row['MFG_PART_NO'];?></td>
                      <td><?php echo @$row['SKU_NO'];?></td>                  
                      <td><?php echo @$row['MANUFACTURER'];?></td>                  
                      <!-- <td>
                        <?php 
                            // $cost_us = @$row['COST_US'];
                            // echo '$ '.number_format((float)@$cost_us,2,'.',',');
                        ?>
                      </td> -->
                      <!-- <td>
                      <?php 
                        // $line_total = @$cost_us * @$row['NOT_LIST_QTY'];
                        // echo '$ '.number_format((float)@$line_total,2,'.',',');
                      ?>    
                      </td> -->
                      <!-- <td><?php //echo @$row['LOADING_DATE'];?></td> -->
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
                     $i++;
                      // endif;        
                      endforeach;
                      ?>                                     
                      </tbody>
                    </table><br>
                       <div class="col-sm-12">                 
                          <div class="form-group col-sm-3">
                            <label for="user_remark" >Select Remarks</label>
                              <select name="user_remark" class="form-control" id="user_remark">
                                <option value="">Select Remark------------</option>
                                <option value="1">System Error</option>
                                <option value="2">Missing UPC</option>
                                <option value="3">Missing MPN</option>
                                <option value="4">Wrong MPN</option>
                                <option value="5">Wrong UPC</option>
                                <option value="6">Wrong Description</option>
                                <option value="7">Packaging vs Content Wrong</option>
                                <option value="8">Not Worth Selling Online</option>
                              </select>
                          </div>                                     
                        </div>
                      <div class="col-sm-12">
                          <label for="Remarks">Remarks: </label>
                          <div class="form-group">
                            <textarea class="form-control" name="remarks" id="remarks" rows="4" cols=50 required></textarea>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="form-group">
                          <input type="submit" onclick="return confirm('Are you sure?');" class="btn btn-primary btn-sm" name="del_item" id="del_item" value="Delete Item">
                        </div>
                      </div>
                    </form>
                        <!--<div class="col-sm-12">

                          <input type="submit" name="submit" value="Upload" class="btn btn-primary">
                        <div id="errorMsg" class="text-danger">
                        <?php 
                            // To disable invalid argument supplied for foreach()
                            // if (is_array(@$errorMsg) || is_object(@$errorMsg))
                            // {
                            //     foreach (@$errorMsg as $msg) {
                            //         # code...
                            //         echo @$msg;
                            //     } 
                            // } ?>
                        </div>
                        <div id="successMsg" class="text-success">
                        <?php 
                            // To disable invalid argument supplied for foreach()
                            // if (is_array(@$successMsg) || is_object(@$successMsg))
                            // {
                            //     foreach (@$successMsg as $msg) {
                            //         # code...
                            //         echo @$msg;
                            //     } 
                            // } ?>
                        </div>
                        </div>                        
                
                    </form>-->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        <?php endif; ?>
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
$(document).ready(function()
  {
     $('#ItemSearchResults').DataTable({
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
  /*////////////////////////*/ 
  $("#user_remark").change(function(){
    var user_remark = $("#user_remark").val();
      if (user_remark==1) {document.getElementById("remarks").value = "System Error";}
      else if(user_remark ==2){document.getElementById("remarks").value = "Missing UPC";}
      else if(user_remark ==3){document.getElementById("remarks").value = "Missing MPN";}
      else if(user_remark ==4){document.getElementById("remarks").value = "Wrong MPN";}
      else if(user_remark ==5){document.getElementById("remarks").value = "Wrong UPC";}
      else if(user_remark ==6){document.getElementById("remarks").value = "Wrong Description";}
      else if(user_remark ==7){document.getElementById("remarks").value = "Packaging vs Content Wrong";}
      else if(user_remark ==8){document.getElementById("remarks").value = "Not Worth Selling Online";}
      else{document.getElementById("remarks").value = "";}
    });      
    
});
</script>