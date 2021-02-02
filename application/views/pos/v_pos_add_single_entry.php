<?php $this->load->view('template/header');
ini_set('memory_limit', '-1');
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        POS Single Entry Form
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">POS Single Entry Form</li>
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
            <div class="box-header">
              <h3 class="box-title">POS Single Entry Form</h3>
            </div>
            <!-- /.box-header -->
            <div class="col-sm-12">
                <div class="col-sm-2">
                  <a href="<?php echo base_url('pos/c_pos_single_entry/add_record'); ?>" title="Add New Record" class="btn btn-primary btn-sm" target="_blank">Add New</a>
                </div>
                <div class="col-sm-8"></div>
                <div class="col-sm-2">
                  <div class="form-group pull-right">
                    <a style="text-decoration: underline;" href="<?php echo base_url('tolist/c_tolist/lister_view'); ?>" title="Go to Item Listing" target="_blank">Item Listing</a>
                  </div>
                </div>                
<form action="<?php echo base_url('pos/c_pos_single_entry/filter_data'); ?>" method = "post">
                    <div class="col-sm-4">
                       <?php 
                    $se_radio = $this->session->userdata('se_radio');
                         if($se_radio == 'Listed'){
                           echo "<input type='radio' name='se_radio' value='Listed' checked>&nbsp;Listed&nbsp;
                         <input type='radio' name='se_radio' value='Not_Listed' >&nbsp;Not Listed&nbsp;
                         <input type='radio' name='se_radio' value='All'>&nbsp;All";
                             $this->session->unset_userdata('se_radio');
                         }elseif($se_radio == 'Not_Listed'){
                           echo "<input type='radio' name='se_radio' value='Listed'>&nbsp;Listed&nbsp;
                         <input type='radio' name='se_radio' value='Not_Listed' checked>&nbsp;Not Listed&nbsp;
                         <input type='radio' name='se_radio' value='All'>&nbsp;All";
                             $this->session->unset_userdata('se_radio');

                         }elseif($se_radio == 'All'){
                           echo "<input type='radio' name='se_radio' value='Listed'>&nbsp;Listed&nbsp;
                         <input type='radio' name='se_radio' value='Not_Listed' >&nbsp;Not Listed&nbsp;
                         <input type='radio' name='se_radio' value='All' checked>&nbsp;All";
                             $this->session->unset_userdata('se_radio');

                         }else{
                           echo "<input type='radio' name='se_radio' value='Listed' checked>&nbsp;Listed&nbsp;
                         <input type='radio' name='se_radio' value='Not_Listed' >&nbsp;Not Listed&nbsp;
                         <input type='radio' name='se_radio' value='All'>&nbsp;All";
                        }
                        ?>
                 
                    </div>
                    <div class="col-sm-2">
                        <input type="submit" class="btn btn-primary btn-sm" name="search" value="Search">
                    </div>
                </form>
            </div>
            <div class="box-body form-scroll">

             <table id="SingleEntryTable" class="table table-bordered table-striped">
                <!-- <h2>Templates</h2><br> -->
     
                <thead>
                  <tr>

                    <th>ACTION</th>
                    <th>BARCODE</th>
                    <th>OLD BARCODE</th>
                    <th>REF NO</th>
                    <th>PURCHASE DATE</th>
                    <th>MANUFACTURE</th>
                    <th>LIST QTY</th>
                    <th>AVAILABLE QTY</th>
                    <th>MPN</th>
                    <th>UPC</th>
                    <th>SKU</th>
                    <th>PRICE</th>
                    <th>DESC</th>
                    <th>CATEGORY</th>
                    <th>CONDITION</th>
                    <th>USER</th>
<!--                     <th>REMARKS</th>  
                    <th>ID</th> -->
                    <th>BARCODE</th> 
                                         

                  </tr>
                </thead>
                <tbody>
                <?php
            if ($singlentry_all['query'] == NULL) {
            ?>
            <div class="alert alert-info" role="alert">There is no record found.</div>
            <?php
            } else {
              $i = 0;
            foreach ($singlentry_all['query'] as $row) {
                    @$it_condition = '';
                    if(is_numeric(@$row['CONDITIONS_SEG5'])){
                      @$condition_id = @$row['CONDITIONS_SEG5'];
                      if(@$row['CONDITIONS_SEG5'] == 3000){ 
                       @$it_condition = 'Used';}
                      else if(@$row['CONDITIONS_SEG5']  == 1000){ 
                       @$it_condition = 'New' ;}
                      else if(@$row['CONDITIONS_SEG5'] == 1500){ 
                       @$it_condition = 'New other';}
                      else if(@$row['CONDITIONS_SEG5'] == 2000){ 
                       @$it_condition = 'Manufacturer Refurbished';}
                      else if(@$row['CONDITIONS_SEG5'] == 2500){ 
                       @$it_condition = 'Seller Refurbished';}
                      else if(@$row['CONDITIONS_SEG5'] == 7000){ 
                       @$it_condition = 'For Parts or Not Working';}

                    }else{
                        @$it_condition = @$row['CONDITIONS_SEG5'];

                      if(@$row['CONDITIONS_SEG5'] == 'USED'){ 
                       @$condition_id = 3000;}
                      else if(@$row['CONDITIONS_SEG5']  =='NEW' ){ 
                       @$condition_id = 1000 ;}
                      else if(@$row['CONDITIONS_SEG5'] == 'NEW OTHER'){ 
                       @$condition_id = 1500;}
                      else if(@$row['CONDITIONS_SEG5'] =='MANUFACTURER REFURBISHED'){ 
                       @$condition_id = 2000;}
                      else if(@$row['CONDITIONS_SEG5'] == 'SELLER REFURBISHED'){ 
                       @$condition_id = 2500 ;}
                      else if(@$row['CONDITIONS_SEG5'] == 'FOR PARTS OR NOT WORKING'){
                       @$condition_id = 7000;}
                      }
            ?>
                  <tr>
                    <td>                  
                      <div class="edit_btun" style="width: 220px !important;">
                        <a onclick="return confirm('Are you sure?');" style="font-size: 17px !important; margin-right: 3px;" title="Delete Record" href="<?php echo base_url('pos/c_pos_single_entry/deleteComplete').'/'.@$row['LZ_MANIFEST_ID']; ?>" class="btn btn-danger btn-xs">
                          <i class="fa fa-trash-o p-b-5" aria-hidden="true"></i>
                        </a>                                             
                        <a style="font-size: 17px !important; margin-right: 3px;" title="Delete &amp; Create New" href="<?php echo base_url('pos/c_pos_single_entry/deleteCreateNew').'/'.@$row['ID']; ?>" class="btn btn-warning btn-xs">
                          <span class="glyphicon glyphicon-pencil p-b-5 " aria-hidden="true"></span>
                        </a>
                        <a style="font-size: 17px !important; margin-right: 3px;" title="Update Single Entry" href="<?php echo base_url('pos/c_pos_single_entry/updateRecordView').'/'.@$row['ID']; ?>" class="btn btn-info btn-xs">
                          <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </a>                         
                        <?php if(!empty($singlentry_all['seed_id_qry'][$i])): ?>
                         <a style="font-size: 12px !important; margin-right: 3px;" href="<?php echo base_url(); ?>tolist/c_tolist/seed_view/<?php echo $singlentry_all['seed_id_qry'][$i]; ?>" title="Create/Edit Seed" class="btn btn-success btn-sm" target="_blank">
                          <span class="glyphicon glyphicon-leaf" aria-hidden="true"></span>
                         </a>
                       <?php endif; ?>
                         <a style=" margin-right: 3px;" href="<?php echo base_url(); ?>pos/c_pos_single_entry/manifest_print/<?php echo @$row['ID']; ?>" title="Print Sticker" class="btn btn-primary btn-sm" target="_blank">
                          <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                         </a>
                         <?php if(!empty(@$singlentry_all['barcode_qry'])){
                            $it_barcode = $singlentry_all['barcode_qry'][$i];
                          }
                        ?>
                        
                         <a  title="Update Master Pictures" class="btn btn-sm btn-primary" href="<?php echo base_url('item_pictures/c_item_pictures/item_search').'/'.@$it_barcode;?>" target="_blank">
                          <i class="fa fa-camera" aria-hidden="true"></i>
                         </a>                       
                        
                        <?php //if(empty($row['GRN_ID'])) { ?>
                          <!-- <a title="Post Manifest" id="<?php //echo $row['LZ_MANIFEST_ID']."-post";?>" class="post_btn btn btn-success btn-xs" ><i class="fa fa-arrow-circle-o-up ft-sz-24" aria-hidden="true"></i></a> -->
                        <?php //}else{ ?>
                          <!-- <a title="Un-Post Manifest" id="<?php //echo $row['LZ_MANIFEST_ID']."-unpost"; ?>" class="post_btn btn  btn-primary btn-xs" ><i class="fa fa-arrow-circle-o-down ft-sz-24" aria-hidden="true"></i></a>  -->
                        <?php  //} ?>
                     </div>
                   </td>
                   <td>
                   <?php 
                     //var_dump(@$singlentry_all['barcode_qry']);exit;
                     if(!empty(@$singlentry_all['barcode_qry'])){
                        echo $singlentry_all['barcode_qry'][$i];
                     }else{
                      echo "Not Found";
                     }
                   ?>
                     
                   </td>
                   <td><?php 
                   if(!empty(@$row['OLD_BARCODE'])){
                    //$arr = unserialize(urldecode(@$row['OLD_BARCODE']));
                      //foreach ($arr as $barcode) {
                        echo @$row['OLD_BARCODE'];
                      //}
                   }
                      
                   ?></td>
                    <td><?php echo @$row['PURCHASE_REF_NO'];?></td>
                    <td><?php echo @$row['PURCHASE_DATE'];?></td>
                    <td><?php echo @$row['ITEM_MT_MANUFACTURE'];?></td>
                    <td><?php echo @$row['LIST_QTY'];?></td>
                    <td><?php echo @$row['AVAILABLE_QTY'];?></td>
                    <td><?php echo @$row['ITEM_MT_MFG_PART_NO'];?></td>
                    <td><?php echo @$row['ITEM_MT_UPC'];?></td>
                    <td><?php echo @$row['ITEM_MT_BBY_SKU'];?></td>
                    <?php  ?>
                    <td><?php echo '$ '.number_format((float)@$row['PO_DETAIL_RETIAL_PRICE'],2,'.',',');?></td>
                    <td>
                      <div style="width:200px !important;">
                        <?php echo @$row['ITEM_MT_DESC'];?>
                      </div>  
                    </td>
                    <td><?php echo @$row['BRAND_SEG3'];?></td>

                    <td><?php echo @$it_condition;?> </td>                    
                    <td><?php echo @$row['LISTER'];?></td>
                    <!-- <td><?php //echo @$row['REMARKS'];?></td>   -->                      
                    <!-- <td><?php //echo @$row['ID'];?></td> -->
                    <td><?php echo @$row['IT_BARCODE'];?></td>
                    
                <?php
                $i++;
                }
            }
                ?>
                  </tr>
                </tbody>
             </table>
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

<?php $this->load->view('template/footer');?>