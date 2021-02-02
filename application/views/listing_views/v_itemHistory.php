<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Item History
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Item History</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
          <div class="box">      
            <div class="box-body"> 
              <div class="col-sm-12">
                <form action="<?php echo base_url(); ?>listing/c_itemHistory/search_history" method="post" accept-charset="utf-8">
                  <div class="col-sm-6">
                    <div class="form-group">
                        <label for="Search Webhook">Search:</label>
                        <input type="text" name="bd_item_search" class="form-control" value="<?php echo $item_barcode; ?>">                      
                    </div>
                  </div>  
                  <div class="col-sm-2">
                    <div class="form-group p-t-24">
                      <input type="submit" class="btn btn-primary btn-sm" name="bd_submit" id="bd_submit" value="Search">
                    </div>
                  </div>
                </form>                                            
              </div>
          </div><!-- /.box-body -->       
        </div>
        <?php 
            // echo "<pre>";
            // print_r($items['loc_his']);
            // exit;

            $condition=@$items['condition_id']; 
            ?> 
           <h4 >ITEM HISTORY</h4>
        <div class="box">
          <div class="box-body form-scroll">   
            <div class="col-sm-12">
              <table id="" class="table table-responsive table-striped table-bordered table-hover" >
              <thead>
                  <tr>                    
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th colspan="3" class="text text-center" style="background: #1BC8C8; color: black;">Item Audit</th>
                    <th colspan="2" class="text text-center" style=" background :red; color:white;">Item Pulling</th>                    
                    <th colspan="2" class="text text-center" style=" background :green; color:white;">Item Testing</th>
                    <th colspan="1" class="text text-center" style=" background :yellow; color:black;">Item Source</th>                    
                    
                  </tr>
                  <tr>
                    <th>MANIFEST NO</th>
                    <th>BARCODE NO</th>
                    <th>EBAY ID</th>
                    <th>Condition</th>
                    <th>EBAY STICKER</th>
                    <th>Item Audit</th>
                    <th>Audit BY</th>
                    <th>Audit DateTime</th>
                    <th>Pulling Status</th>
                    <th>Pulled By</th>                    
                    <th>Test By</th>
                    <th>Test Date</th>
                    <th>Item Source</th>
                  </tr>       
              </thead>
               <tbody>
                <?php 
                if(@$items['manifests']->num_rows() > 0)
                {
                  foreach (@$items['manifests']->result_array() as $manifest):?>
                    <tr>
                       <td><?php echo  @$manifest['LZ_MANIFEST_ID']; ?></td>                                           
                       <td><?php echo  @$manifest['BARCODE_NO']; ?></td>                                           
                       <td><?php echo  @$manifest['EBAY_ITEM_ID']; ?></td>                                           
                       <td><?php echo  @$manifest['COND_NAME']; ?></td>                                           
                       <td><?php echo  @$manifest['PRINT_STATUS']; ?></td> 
                       <td><?php echo  @$manifest['AUDIT_ITEM']; ?></td> 
                       <td><?php echo  @$manifest['USER_NAME']; ?></td> 
                       <td><?php echo  @$manifest['AUDIT_DATETIME']; ?></td> 
                       <td><?php echo  @$manifest['PULL_STAT']; ?></td> 
                       <td><?php echo  @$manifest['PULLER_NAME']; ?></td>                         
                       <td><?php echo  @$manifest['TEST_BY']; ?></td> 
                       <td><?php echo  @$manifest['TEST_TIMESTAMP']; ?></td> 
                       <td><?php echo  @$manifest['ITEM_SOURCE']; ?></td>
                    </tr>
                    <?php endforeach;
                    }
                    ?>        
               </tbody> 
              </table>                             
            </div><!-- /.col -->          
          </div>
        </div> 


         <h4 >BUYER HISTORY</h4>
        <div class="box">
          <div class="box-body form-scroll">   
            <div class="col-sm-12">
              <table id="" class="table table-responsive table-striped table-bordered table-hover" >
              <thead>
                  
                  <tr>
                    <th>Ebay Id</th>
                    <th>Item Title</th>
                    <th>Tracking #</th>
                    <th>Buyer Name</th>
                    <th>Sale Date</th>
                    <th>Shipped On Date</th>
                    <th>Account</th>
                  </tr>      
              </thead>
               <tbody>
                <?php 
                
                  foreach (@$items['buyer_his'] as $buyer):?>
                    <tr>
                       <td><?php echo  @$buyer['EBAY_ITEM_ID']; ?></td>                                           
                       <td><?php echo  @$buyer['ITEM_TITLE']; ?></td>                                           
                       <td><?php echo  @$buyer['TRACKING_NUMBER']; ?></td>                                           
                       <td><?php echo  @$buyer['BUYER_FULLNAME']; ?></td>                                           
                       <td><?php echo  @$buyer['SALE_DATE']; ?></td> 
                       <td><?php echo  @$buyer['SHIPPED_ON_DATE']; ?></td> 
                       <td><?php echo  @$buyer['ACOUNT']; ?></td>
                    </tr>
                    <?php endforeach;
                    
                    ?>        
               </tbody> 
              </table>                             
            </div><!-- /.col -->          
          </div>
        </div> 

         

       
       
         <!--    ////////////// for picture approval ////////////////////////////////  -->
                <?php 
                if(@$items['approved_date']!=''){ 
                  ?>
                    <h4 >PICTURE APPROVAL</h4>
                    <div class="box">
                      <div class="box-body form-scroll">   
                        <div class="col-sm-12">
                          <?php 

                                $it_condition  = @$items['condition_id'];
                                if(is_numeric(@$it_condition)){
                                    if(@$it_condition == 3000){
                                      $it_condition = 'Used';
                                    }elseif(@$it_condition == 1000){
                                      $it_condition = 'New'; 
                                    }elseif(@$it_condition == 1500){
                                      $it_condition = 'New other'; 
                                    }elseif(@$it_condition == 2000){
                                        $it_condition = 'Manufacturer refurbished';
                                    }elseif(@$it_condition == 2500){
                                      $it_condition = 'Seller refurbished'; 
                                    }elseif(@$it_condition == 7000){
                                      $it_condition = 'For parts or not working'; 
                                    }else{
                                        $it_condition = 'Used'; 
                                    }
                                }else{// end main if
                                  $it_condition  = ucfirst(@$it_condition);
                                }
                                $mpn = str_replace('/', '_', @$items['item_mpn']);
                                $master_path = @$items['master_path'];
                                $dir =  @$master_path.@$items['item_upc']."~".@$mpn."/".@$it_condition."/";
                                $dir = preg_replace("/[\r\n]*/","",@$dir);
                                 //var_dump(@$dir);exit;
                                 //@$dir = "/WIZMEN-PC/item_pictures/master_pictures/".@$data_get['result'][0]->UPC."~".@$mpn."/".@$it_condition;
                                 // Open a directory, and read its contents

                            if(is_dir(@$dir)){
                                        $iterator = new \FilesystemIterator(@$dir);
                                        if (@$iterator->valid()){    
                                          $m_flag = true;
                                      }else{
                                        $m_flag = false;
                                      }
                                  }else{
                                    $m_flag = false;
                                  }
                              //if(is_dir(@$dir)){
                              // @$iterator = new \FilesystemIterator(@$dir);
                              //@$isDirEmpty = @$iterator->valid();
                              //var_dump(@$isDirEmpty);exit();
                              // if (@$m_flag){
                              //var_dump(@$dir);exit;
                            
                           ?>
                                <table id="" class="table table-responsive table-striped table-bordered table-hover" >
                                <thead>
                                    <tr>
                                      <th>APPROVE BY</th>
                                      <th>APPROVE DATE</th>
                                      <th>PICTURE FOUND</th>
                                    </tr>       
                                </thead>
                                 <tbody>
                                    <?php  
                                    /* echo "<pre>";
                                    print_r(@$items['pic_approvals']->result_array());
                                    exit;*/
                                    if(@$items['pic_approvals']->num_rows() > 0)
                                    {
                                      foreach (@$items['pic_approvals']->result_array() as $approve):?>
                                           <tr>
                                           <td><?php if(!empty(@$approve['USER_NAME'])){ echo  ucfirst(@$approve['USER_NAME']); }?></td>
                                            <td><?php if(!empty(@$items['approved_date'])){  echo  @$items['approved_date']; }?></td> 
                                            <?php
                                            if (@$m_flag==true) { ?>
                                               <td style="background:green; color: white;"><?php echo "YES"; ?></td>
                                             <?php }else { ?>
                                               <td style="background:red; color: white; "><?php echo "NO"; ?></td>
                                             <?php } ?>                      
                                                                   
                                          </tr>
                                    <?php endforeach;
                                        }
                                    ?>        
                               </tbody> 
                              </table>                            
                        </div>         
                      </div>
                    </div>
                    <?php } ?> 
                     <!--  ////////////// for Item Assign //////////////////////////////// -->
                    
                     <!--  ////////////// for Item Assign //////////////////////////////// -->
                      <!-- ////////////// for Item List //////////////////////////////// -->
                    <?php
                      if(@$items['listers']->num_rows() > 0){
                      ?>
                    <h4>ITEM LIST</h4>
                    <div class="box">
                      <div class="box-body form-scroll">   
                        <div class="col-sm-12">
                                <table id="" class="table table-responsive table-striped table-bordered table-hover" >
                                <thead>
                                  <tr>
                                    <th>EBAY ID</th>
                                    <th>LISTER NAME</th>
                                    <th>LIST PRICE</th>
                                    <th>LITED DATE</th>
                                  </tr>       
                                </thead>
                                 <tbody>
                                  <?php 
                                  foreach (@$items['listers']->result_array() as $lister):
                                    ?>
                                    <tr>
                                     <td><?php echo $lister['EBAY_ITEM_ID']; ?></td>                      
                                     <td><?php echo ucfirst($items['listerId']); ?></td>                      
                                     <td><?php echo '$'.number_format((float)@$lister['LIST_PRICE'],2,'.',','); ?></td>                      
                                     <td><?php echo $lister['LIST_DATE']; ?></td>                      
                                    </tr>
                                  <?php 
                                  endforeach;
                                  ?>        
                               </tbody> 
                              </table>                             
                        </div><!-- /.col -->          
                      </div>
                    </div> 
                    <?php } ?>

                    <!-- item location start -->

                    <?php
                      if(@count($items['loc_his']) > 0){
                      ?>
                    <h4>ITEM LOCATION HISTORY</h4>
                    <div class="box">
                      <div class="box-body form-scroll">
                <table id="loc_table" class="table table-responsive table-striped table-bordered table-hover">
                      <thead>
                        <th >Barcode</th>
                        <th >Item Desc</th>
                        <th >Old Location</th>
                        <th >New Location</th>
                        <th >Transfer Date</th>
                        <th >Transfer By</th>
                        
                         
                      </thead>
                      <tbody>
                      <tr>

                      <?php 
                      $i=1;
                      foreach($items['loc_his'] as $row) :?>

                      <td ><?php echo @$row['BARCODE_NO'];?></td>
                      <td ><?php echo @$row['TITLE'];?></td>
                      
                      <td ><?php echo @$row['OLD_LOCATION'].'<p style ="color:red;">--- '.$i.'</p>';  $i =$i+1;?></td>
                      <td ><?php echo @$row['NEW_LOCATION'].'<p style ="color:red;">--- '.$i.'</p>'; ?></td>
                      <td ><?php echo @$row['TRAN_DA'];?></td>
                      <td ><?php echo @$row['TRANSFER_BY'];?></td>
                     

                       
                      </tr>
                      <?php $i++;endforeach; ?>
                        
                        
                        
                        
                      </tbody> 
                     
                    </table>
                 
                
                  
                         
                        </div>                      
                    </div> 
                    <?php } ?>

                    <!-- item location end -->


               <!-- ////////////// for Item Placement //////////////////////////////// -->
                     <!--  ////////////// for Item Assign //////////////////////////////// -->

                  <?php 
                    if(@$items['assigned_to']!=''){  ?>
                   <h4 >ITEM ASSIGN</h4>
                    <div class="box">
                      <div class="box-body form-scroll">   
                        <div class="col-sm-12">
                          <table id="" class="table table-responsive table-striped table-bordered table-hover" >
                            <thead>
                              <tr>
                                <th>LISTER NAME</th>
                                <th>DATE STAMP</th>
                                <th>ASSIGN BY</th>
                              </tr>       
                            </thead>
                          <tbody>
                          <?php 
                            foreach (@$items['item_assigns']->result_array() as $assign):?>
                               <tr>
                                  <td><?php if(!empty(@$items['assigned_to'])){  echo  @$items['assigned_to']; } ?></td> 
                                  <td><?php if(!empty(@$assign['ALLOC_DATE'])){  echo  @$assign['ALLOC_DATE']; } ?></td>
                                  <td><?php if(!empty(@$items['assigned_by'])){  echo  @$items['assigned_by']; } ?></td>
                                </tr>
                          <?php endforeach; ?>        
                           </tbody> 
                          </table>                             
                        </div>          
                      </div>
                    </div> 
                    <!-- ////////////// for Audit //////////////////////////////// -->
                       <h4 style="display: none;">AUDIT</h4>
                    <div class="box" style="display: none;">
                      <div class="box-body form-scroll">   
                        <div class="col-sm-12">
                          <table id="" class="table table-responsive table-striped table-bordered table-hover" >
                            <thead>
                              <tr>
                                <th>DATE STAMP</th>
                                <th>USER ID</th>
                              </tr>       
                            </thead>
                             <tbody>
                              <?php //foreach (@$data as @$value):?>
                                <!-- <tr>
                                   <td></td>                      
                                   <td></td>                      
                                   <td></td>                      
                                   <td></td>                      
                                   <td></td>                      
                                </tr> -->
                            <?php //endforeach;?>        
                           </tbody> 
                          </table>                             
                        </div><!-- /.col -->          
                      </div>
                    </div>
                   
                <!-- ////////////// for Item List //////////////////////////////// -->
                
                    <!-- ////////////// for Item Placement //////////////////////////////// -->
                  <h4 style="display: none;">ITEM PLACEMENT</h4>
                    <div class="box" style="display: none;">
                      <div class="box-body form-scroll">   
                        <div class="col-sm-12">
                          <table id="" class="table table-responsive table-striped table-bordered table-hover" >
                            <thead>
                                <tr>
                                  <th>LOCATION ID</th>
                                  <th>PLACE ID</th>
                                  <th>DATE STAMP</th>
                                  <th>USER ID</th>
                                </tr>       
                            </thead>
                            <tbody>
                            <?php //foreach (@$data as $value):?>
                          
                                    <!-- <tr>
                                       <td></td>                      
                                       <td></td>                      
                                       <td></td>                      
                                       <td></td>                      
                                       <td></td>                      
                                    </tr> -->
                            <?php //endforeach;?>        
                            </tbody> 
                            </table>                                
                        </div>       
                      </div>
                    </div>
                    <?php 
                      }else{
                        echo "<div id='errorMessage' class='alert alert-error alert-dismissable'>
                                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                 <b style='font-size:18px;'>  Item has no further information.</b>
                              </div>";
                      }
                    ?>
              </div>
              <!-- /.col -->
          </div>
      <!-- /.row -->
  </section><!-- /.content -->
</div>

<!-- End Listing Form Data -->
 <?php @$this->load->view('template/footer'); ?>
 <script type="text/javascript">
   $(document).ready(function(){
      $('#recognizeData').DataTable({
        "oLanguage": {
        "sInfo": "Total Records: _TOTAL_"
      },
      "iDisplayLength": 50,
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        //"order": [[ 8, "desc" ]],
        // "order": [[ 16, "ASC" ]],
        "info": true,
        "autoWidth": true,
        "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
      });
  });
 </script>