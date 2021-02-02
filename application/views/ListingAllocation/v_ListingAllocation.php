<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Listing Allocation View
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Listing Allocation View</li>
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
              <form action="<?php echo base_url(); ?>ListingAllocation/c_ListingAllocation/CatFilter" method="post" accept-charset="utf-8">

                <div class="col-sm-4">
                    <div class="form-group">
                      <select class="form-control" name="assign_cat_id" id="assign_cat_id">
                      <?php foreach (@$data['cat_id_qry'] as $row): ?>
                        <option value="<?php echo @$row['CATEGORY_ID'];?>"><?php echo @$row['CATEGORY_NAME'];?></option>
                      <?php endforeach;?>
                      </select>
                     <?php //$purchase_no = $this->session->userdata('purchase_no'); ?>
                        <!-- <input class="form-control" type="text" name="purchase_no" id="purchase_no" value="<?php //if(isset($purchase_no)){echo $purchase_no; $this->session->unset_userdata('purchase_no');}  ?>" placeholder="Enter Purchase Ref No / Manifest Id"> -->
                    </div>                                     
                </div> 
                <div class="col-sm-2">
                  <div class="form-group">
                      <input type="submit" class="btn btn-primary" name="Submit" value="Search">
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
              <li class="active"><a href="#tab_1" data-toggle="tab">Un-Assigned</a></li>
              <li><a href="#tab_2" data-toggle="tab">Assigned</a></li>

            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
              <div class="row">
              <!-- <form action="<?php //echo base_url(); ?>ListingAllocation/c_ListingAllocation/AssignListing" method="post"> -->
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="Listing User">User Name:</label>
                    <select class="form-control" name="user_name" id="user_name">
                    <?php foreach($users as $row): 
                      $u_name = ucfirst($row['USER_NAME']);
                      $employee_id = $row['EMPLOYEE_ID'];
                    ?>
                        <option value="<?php echo $employee_id;?>"><?php echo $u_name;?></option>
                    <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div> 
              <br>
                <table id="unAssignListing" class="table table-bordered table-striped">

                    <thead>
                    <tr>

                        <th>

                          <div style="width: 80px!important;">
                           
                            <input class="" name="btSelectAll" type="checkbox" onclick="toggle(this)">&nbsp;Select All
                          </div>
                        </th>
                        <th>BARCODE</th>
                        <th>CONDITION</th>
                        <th>TITLE</th>
                        <th>AVAILABLE QTY</th>
                        <th>MANUFACTURE</th>    
                        <th>UPC</th>
                        <th>MPN</th>
                        <th>CATEGORY NAME</th>
                        <th>APPROVED DATA</th>
                        <th>APPROVED BY</th>
                        <th>PURCH REF NO</th>
                        <th>DAYS ON SHELF</th>
                        
                    </tr>
                    </thead>

                    <tbody>
                      <?php 
                      // var_dump($data);exit;
                      //$i = 0;
                      foreach (@$data['un_assign_qry'] as $row): 
                      $it_condition  = @$row['ITEM_CONDITION'];
                      $list_id=@$row['LIST_ID'];
                      if (!empty(@$list_id)){

                      $ebay_qtys=$this->db->query("SELECT LIST_QTY FROM EBAY_LIST_MT WHERE LIST_ID = $list_id");
                      $ebay_qtys=$ebay_qtys->result_array();
                        }
                      if(@$ebay_qtys[0]['LIST_QTY'] != @$row['QUANTITY'] || @$ebay_qtys[0]['LIST_QTY'] =='' ){
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
                          }// condition if end 
                            $mpn = str_replace('/', '_', @$row['MFG_PART_NO']);
                            $master_path = $data['path_query'][0]['MASTER_PATH'];
                            $m_dir =  $master_path.@$row['UPC']."~".@$mpn."/".@$it_condition."/";
                            $m_dir = preg_replace("/[\r\n]*/","",$m_dir);
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
                              if($m_flag):
                            ?>


                          <tr>                   
                            <td>
                              <div style="width: 80px!important;">

                                <div style="float:left;margin-right:8px;">
                                  <input title="Check to Assign Listing to users" type="checkbox" name="assign_listing[]" id="assign_listing" value="<?php echo $row['SEED_ID']; ?>">
                                </div>                      

                              </div>
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
                          <td><?php echo @$row['ITEM_MT_DESC'];?></td>
                          <td><?php echo @$row['QUANTITY']; ?></td>
                          <td><?php echo @$row['MANUFACTURER'];?></td> 

                          <td><?php echo @$row['UPC'];?></td>
                          <td><?php echo @$row['MFG_PART_NO'];?></td>
                          <td><?php echo @$row['CATEGORY_NAME'];?></td>
                          <td><?php echo @$row['APPROVED_DATE'];?></td>
                          <td>
                          <?php 
                            foreach($users as $user){
                              $u_name = ucfirst($user['USER_NAME']);
                              $employee_id = $user['EMPLOYEE_ID']; 
                              if($employee_id ==  @$row['APPROVED_BY']){
                                echo $u_name;
                              }
                            } 
                            //echo @$row['APPROVED_BY'];
                          ?>
                          </td>
                          <td><?php echo @$row['PURCH_REF_NO'];?></td>                  
                                           
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
                        // $i++;
                        endif; 
                    } //list qty check end if
                    endforeach;
                    ?>
                             
                    </tbody>
                </table><br>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="Remarks">Remarks:</label>
                      <textarea class="form-control" name="remarks" id="remarks" rows="4"></textarea>
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="form-group">
                      <button class="btn btn-primary" name="assign_list" id="assign_list" >Assign Listing</button>

                    </div>
                  </div>
                </div>
                
              </div>
              <!-- </form> -->
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
<!--               <div class="row">
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="Listing User">User Name:</label>
                    <select class="form-control" name="un_assign_user" id="un_assign_user">
                    <?php //foreach($users as $row): 
                      //$u_name = ucfirst($row['USER_NAME']);;
                      //$employee_id = $row['EMPLOYEE_ID'];
                    ?>
                        <option value="<?php //echo $employee_id;?>"><?php //echo $u_name;?></option>
                    <?php //endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>  
              <br>-->
              <div class="col-sm-12">
                <div class="col-sm-10"></div>
                <div class="col-sm-2">
                  <div class="form-group pull-right">
                    <a style="text-decoration: underline;" href="<?php echo base_url();?>UnpostItem/C_UnpostItem" title="Unpost or Delete Item" target="_blank">Unpost Item</a>                    
                  </div>
                </div>
              </div><br><br>

                <table id="AssignedListing" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>

                          <div style="width: 80px!important;">
                           
                            <input class="" name="btSelectAll" type="checkbox" onclick="toggleUnAssign(this)">&nbsp;Select All
                          </div> 
                        </th>

                        <!-- <th>PICTURE</th> -->
                        <th>BARCODE</th>
                        <!-- <th>IITEM ID</th>
                        <th>MANIFEST ID</th> -->
                        
                        <th>CONDITION</th>
                        <!-- <th>BARCODE</th> -->
                        <th>TITLE</th>
                        <th>AVAILABLE QTY</th>
                        
                        <!-- <th>HOLD QTY</th> -->
                        <th>MANUFACTURE</th>
                        
                        <th>UPC</th>
                        <th>MPN</th>
                        <th>CATEGORY NAME</th>
                        <th>SKU</th>
                        <th>PURCH REF NO</th>
                        <th>LISTER NAME</th>
                        <th>ASSIGNED BY</th>
                        <th>ASSIGNED DATE</th>
                        <th>REMARKS</th>

                    </tr>
                    </thead>

                    <tbody>
                      <?php 
                      // var_dump($data);exit;
                      //$i = 0;
                      foreach (@$data['assigned_qry'] as $row): 
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
                          if($m_flag):
                        ?>


                      <tr>                   
                        <td>
                          <div style="width:80px;">
                          <?php //
                          //var_dump(@$data['alloc_id_qry']);//exit; ?>

                            <div style="float:left;margin-right:8px;">
                              <input title="Check to Assign Listing to users" type="checkbox" name="un_assigning_list[]" id="un_assigning_list" value="<?php echo $row['ALLOC_ID']; ?>">
                            </div> 
<!--                             <div style="float:left;margin-right:8px;">
                             <a href="<?php //echo base_url(); ?>tolist/c_tolist/seed_view/<?php //echo $row['SEED_ID'] ?>" title="Create/Edit Seed" class="btn btn-primary btn-sm" target="_blank"><span class="glyphicon glyphicon-leaf" aria-hidden="true"></span></a>
                             </div>  -->                        

                          </div>
                        </td>
<!--                         <td>
                        <?php
                  // if (is_dir($m_dir)){

                  //   $images = scandir($m_dir);
                  //   // Image selection and display:
                  //   //display first image
                  //   if (count($images) > 0) { // make sure at least one image exists
                  //       $url = $images[2]; // first image
                  //       $img = file_get_contents($m_dir.$url);
                  //       $img =base64_encode($img); ?>
                  //       <div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);cursor: pointer!important;">
                  //       <?php

                  //       echo '<img class="sort_img up-img" id="" name="" src="data:image;base64,'.$img.'"/>';
                  //       ?>
                  //       </div>
                  //       <?php
                        
                  //   }
                  // }else{

                  //   $images = scandir($s_dir);
                  //   // Image selection and display:
                  //   //display first image
                  //   if (count($images) > 0) { // make sure at least one image exists
                  //       $url = $images[2]; // first image
                  //       $img = file_get_contents($s_dir.$url);
                  //       $img =base64_encode($img); ?>
                  //       <div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);cursor: pointer!important;">
                  //       <?php

                  //       echo '<img class="sort_img up-img" id="" name="" src="data:image;base64,'.$img.'"/>';
                  //       ?>
                  //       </div>
                  //       <?php
                        
                  //   }
                  // }


                ?>                                

                        </td> -->
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
                        <!-- <td>
                          <?php //echo @$row['ITEM_ID'];?>
                        </td>
                        <td>
                          <?php //echo @$row['LZ_MANIFEST_ID'];?>
                        </td>    -->                 
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
                      <td><?php echo @$row['QUANTITY']; ?></td>
                      <!-- <td></td> -->
                      <td><?php echo @$row['MANUFACTURER'];?></td>
                      
                      <td><?php echo @$row['UPC'];?></td>
                      <td><?php echo @$row['MFG_PART_NO'];?></td>
                      <td><?php echo @$row['CATEGORY_NAME'];?></td>
                      <td><?php echo @$row['SKU_NO'];?></td>                  
                      <td><?php echo @$row['PURCH_REF_NO'];?></td>
                      <td>
                      <?php 
                      foreach($users as $user): 
                        $u_name = ucfirst($user['USER_NAME']);;
                        $employee_id = $user['EMPLOYEE_ID'];
                        if($employee_id == @$row['LISTER_ID']){
                          echo $u_name;
                        }
                      endforeach;
                      //echo @$row['LISTER_ID'];
                      ?>
                        
                      </td>
                      <td>
                      <?php 
                      foreach($users as $user): 
                        $u_name = ucfirst($user['USER_NAME']);;
                        $employee_id = $user['EMPLOYEE_ID'];
                        if($employee_id == @$row['ALLOCATED_BY']){
                          echo $u_name;
                        }
                      endforeach;
                      //echo @$row['ALLOCATED_BY'];
                      ?>                      
                          
                        </td>
                      <td><?php echo @$row['ALLOC_DATE'];?></td>
                      <td><?php echo @$row['REMARKS'];?></td>                  

                    </tr>
                    <?php
                    // $i++;
                    endif; 

                    endforeach;
                    ?>
                             
                    </tbody>
                </table><br>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <!-- <input class="btn btn-primary" type="submit" name="un_assign_list" id="un_assign_list" value="Un-Assign Listing"> -->
                      <button class="btn btn-primary" name="un_assign_list" id="un_assign_list">Un-Assign Listing</button>                      
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.tab-pane -->
             
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
 
 $('#unAssignListing').DataTable({
      "oLanguage": {
      "sInfo": "Total Orders: _TOTAL_"
    },
      "paging": true,
      "lengthChange": true,
      "iDisplayLength": 200,
      "aLengthMenu": [[25, 50, 100, 200,500, -1], [25, 50, 100, 200,500, "All"]],
      "columnDefs": [{ "width": "10%", "targets": [5, 6] }],
      "order": [[ 0, "desc" ]],
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
    });
  $('#AssignedListing').DataTable({
      "oLanguage": {
      "sInfo": "Total Orders: _TOTAL_"
    },
      "paging": true,
      "lengthChange": true,
      "iDisplayLength": 200,
      "aLengthMenu": [[25, 50, 100, 200,500, -1], [25, 50, 100, 200,500, "All"]],
      "columnDefs": [{ "width": "10%", "targets": [5, 6] }],
      "order": [[ 0, "desc" ]],
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
    });
  //    function toggle(source) {
  //   checkboxes = document.getElementsByName('un_assigning_list[]');
  //   for(var i=0, n=checkboxes.length;i<n;i++) {
  //     checkboxes[i].checked = source.checked;
  //   }
  // } 

 </script>