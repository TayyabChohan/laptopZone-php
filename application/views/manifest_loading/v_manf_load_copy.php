<?php $this->load->view('template/header'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Manifest Uploading

        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Manifest Uploading</li>
      </ol>
    </section>
        
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">

        <?php if ($data['list'] == true): ?> 
          <div class="box">
          

            <div class="box-header with-border">
              <h3 class="box-title">Manifest Upload</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          

            <div class="box-body">

              <form action="<?php echo base_url();?>manifest_loading/c_manf_load/uploadCSV" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
                    
                    <div class="col-sm-12">
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="">Browse File</label>
                          <input type="file" class="form-control" name="file_name" id="file_name" >
                        </div>  
                      </div>

                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="">Manifest Name:</label>
                          <input type="text" class="form-control" name="manifest_name" id="manifest_name" >
                        </div>  
                      </div>                      

                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="">Loading Batch:</label>
                          <input type="text" class="form-control" name="loading_batch" id="loading_batch" >
                        </div>  
                      </div>

                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="">Purchase Ref:</label>
                          <input type="text" class="form-control" maxlength="15" name="purch_ref" id="purch_ref" >
                        </div>  
                      </div>

                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="">Loading Date:</label>
                          <input class="datepicker form-control" name="loading_date" data-date-format="mm/dd/yyyy">
                        </div>  
                      </div>

                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="">Purchase Date:</label>
                          <input class="datepicker_purch form-control" name="purchase_date" data-date-format="mm/dd/yyyy">
                        </div>  
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="">Remarks:</label>
                          <input type="text" class="form-control" maxlength="50" name="remarks" id="remarks" >
                        </div>  
                      </div>

                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="">Supplier:</label>
                          <select name="supplier" class="form-control" id="supplier">
                            <option value="2">Vender for Goods</option>
                          </select>
                        </div>  
                      </div>

                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="">Item Condition:</label>
                          <select name="item_condition" class="form-control" id="item_condition">
                            <option value="3000">Used</option>
                            <option value="1000">New</option>
                          </select>
                        </div>  
                      </div>

                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="">Manifest Status:</label>
                          <select name="manifest_status" class="form-control" id="manifest_status">
                            <option value="active" selected>Active</option>
                            <option value="sold">Sold</option>
                            <option value="won">Won</option>
                          </select>
                        </div>  
                      </div>
                                                                                                                                                                                                                                                        
                      <div class="col-sm-12">
                        <div class="form-group">
                        <button type="submit" name="upload" class="btn btn-primary ">Upload</button>
                        <input type="reset" class="btn btn-warning m-l-5" name="reset" value="Reset">
                        <a href="<?php echo base_url();?>manifest_loading/c_manf_load" title="Back" class="btn btn-success m-l-5">Back</a>

                        </div>
                      </div> 
                    </div>

                </form>                

                </div>
              
            </div>
            <?php endif;?>

        <!-- Auction Section start-->
        <?php if ($data['list'] == false): ?>
            <div class="box">
           
            <div class="box-header with-border">

              <h3 class="box-title">Manifest Auction Detail</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>  

            <div class="box-body">
              <form action="<?php echo base_url();?>manifest_loading/c_manf_load/auc_detail" method="post" name="auc_form" id="auc_form">
              <div class="col-sm-12">

                <div class="col-sm-4">

                  <div class="form-group">
                    <label for="">Manifest Status:</label>
                    <select name="manifest_status" class="form-control" id="manifest_status">
                    <?php $status = @$data['manf_data']['auction_qry'][0]['MANIFEST_STATUS'];
                     ?>
                      <option value="active" <?php if(empty($status)){ echo "selected";}elseif($status =='active'){echo "selected";}?>>Active</option>
                      <option value="sold" <?php if($status =='sold'){echo "selected";}?>>Sold</option>
                      <option value="won" <?php if($status =='won'){echo "selected";}?>>Won</option>
                    </select>
                  </div>  
                </div>

                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="">Sold Price:</label>
                    <input type="text" class="form-control" name="sold_price" id="sold_price" value="<?php echo @$data['manf_data']['auction_qry'][0]['SOLD_PRICE']; ?>">
                  </div>  
                </div>

                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="">End Date:</label>
                      <div class='input-group date' id='manifestendate' >
                          <input type='text' class="form-control" name="manifestendate" value="<?php echo @$data['manf_data']['auction_qry'][0]['END_DATE']; ?>" />
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                      </div>
                  </div>  
                </div>
              </div>
              <div class="col-sm-12">
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="">LZ Offer:</label>
                    <input type="text" class="form-control" name="lz_offer" id="lz_offer" value="<?php echo @$data['manf_data']['auction_qry'][0]['LZ_OFFER']; ?>">
                  </div>  
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <input type="hidden" name="lz_manifest_id" class="btn btn-primary " value="<?php echo @$data['manf_data']['detail'][0]['LZ_MANIFEST_ID']; ?>">
                    <input type="submit" name="submit_auc" class="btn btn-primary " value="Save">
                  </div>
                </div>                
              </div>   


                

              
              </form>
            </div>
        
            <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <?php endif; ?>
        <!-- Auction Section End-->

        <!-- Sumarry Section start-->
          
          <div class="box ">
          <?php if ($data['list'] == false): ?>
            <div class="box-header with-border">
              <h3 class="box-title" style="margin-bottom: 22px;">Manifest Uploading Report</h3>

              <div class="col-sm-12">
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="">Name:</label>
                    <span><?php echo @$data['manf_data']['total_entries'][0]['MANIFEST_NAME'];?></span>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="">Manifest No:</label>
                    <span><?php echo @$data['manf_data']['detail'][0]['PO_MT_AUCTION_NO'];?></span>
                  </div>
                </div>    
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="">Loading No:</label>
                    <span><?php echo @$data['manf_data']['total_entries'][0]['LOADING_NO'];?></span>
                  </div>
                </div>  
              </div>


              <table class="tg table table-bordered table-striped">
                <tr>
                 <!--  <th colspan="1" class="m-blue t-b-r" ><h4 class="text-center"><strong>Entries</strong></h4></th> -->
                  <th colspan="3" class="m-green t-b-r" ><h4 class="text-center"><strong>Analysis</strong></h4></th>
                  <th colspan="5" class="m-orange " ><h4 class="text-center"><strong>Price</strong></h4></th>
                </tr>
                <tr>
                  <!-- <td class="m-blue t-b-r"><strong class="text-center">Total Row</strong></td> -->
                  <!-- <td class="m-blue"><strong class="text-center">Inserted</strong></td> -->
                  
                  <!-- <td class="m-blue t-b-r"><strong class="text-center">Not Inserted</strong></td> -->
                  <!-- <td class="m-green"><strong class="text-center">Inserted</strong></td> -->
                  <td class="m-green text-center"><strong class="text-center">Total Item</strong></td>
                  <td class="m-green text-center"><strong class="text-center">Unique Item</strong></td>
                  <td class="m-green t-b-r text-center"><strong class="text-center">Existing Seed</strong></td>
                  <!-- <td  class="text-center m-orange"><strong>Inserted(A)</strong></td> -->
                  <td  class="text-center m-orange"><strong title="Not Inserted (A)">Not Ins (A)</strong></td>
                  <!-- <td class="text-center m-orange"><strong>Ins(S)</strong></td> -->
                  <td  class="text-center m-orange"><strong title="Not Inserted (S)">Not Ins (S)</strong></td>
                  <td class="m-orange text-center"><strong class="text-center">Active Data</strong></td>
                  <td class="m-orange text-center"><strong class="text-center">Sold Data</strong></td>
                  <td class="m-orange text-center"><div style="width: 120px !important;"><strong class="text-center">Mannual Data</strong></div></td>
                </tr>
                
                <tr>
                  <!-- <td class="m-blue t-b-r"><?php //echo @$data['manf_data']['total_entries'][0]['TOTAL_EXCEL_ROWS']; ?></td> -->
                  <!-- <td class="m-blue"><?php //echo @$data['manf_data']['entries_qry'][0]['INSERTED_ROWS']; ?></td> -->
                  
                  <!-- <td class="m-blue t-b-r"><?php //echo @$data['manf_data']['total_entries'][0]['TOTAL_EXCEL_ROWS'] - @$data['manf_data']['entries_qry'][0]['INSERTED_ROWS']; ?></td> -->
                  <!-- <td class="m-green"><?php //echo @$data['manf_data']['cat_inserted'][0]['INS_CAT']; ?></td> -->
                  <td class="m-green text-center"><?php echo @$data['manf_data']['total_entries'][0]['TOTAL_EXCEL_ROWS']; ?></td> 
                  <td class="m-green text-center"><?php echo @$data['manf_data']['unique_entries'][0]['UNQ_COUNT']; ?></td>
                  <td class="m-green t-b-r text-center"><?php 
                   $unq_count = @$data['manf_data']['unique_entries'][0]['UNQ_COUNT'];
                  $seed_qty = @$data['manf_data']['seed_qty'][0]['SEED_QTY'];
                  if($unq_count !== '0'){
                    $seed_perc = ($seed_qty/$unq_count)*100;
                  }elseif($unq_count == '0'){
                    $total_rows = @$data['manf_data']['total_entries'][0]['TOTAL_EXCEL_ROWS'];
                    $seed_perc = ($seed_qty/$total_rows)*100;
                  }else{
                    $seed_perc = 0;
                  }
                  
                  echo number_format((float)@$seed_perc,2,'.',',')." % (".$seed_qty.")";?></td>
                  <td class="m-orange text-center"><?php echo @$data['manf_data']['a_not_ins_price'][0]['A_NOT_INS_PRICE']; ?></td>
                  <!-- <td class="m-orange"><?php //echo @$data['manf_data']['s_ins_price'][0]['S_INS_PRICE']; ?></td> -->
                  <td class="m-orange text-center"><?php echo @$data['manf_data']['s_not_ins_price'][0]['S_NOT_INS_PRICE']; ?></td>
                  
                  <?php foreach($data['manf_data']['manf_value'] as $manf_value): ?>
                    <td class="m-orange text-center" width="100px"><?php echo '$ '.number_format((float)@$manf_value['ACTIVE_VAL'],2,'.',','); ?></td>
                  <td class="m-orange text-center" width="100px"><?php echo '$ '.number_format((float)@$manf_value['SOLD_VAL'],2,'.',',') ; ?></td>
                  <td class="m-orange text-center" width="100px"><?php echo '$ '.number_format((float)@$manf_value['MAN_VAL'],2,'.',',') ; ?></td>
                  
                </tr>
                <?php endforeach; ?>
              </table>

            </div>
          <?php endif; ?>

              <?php if ($data['list']): ?>
                <div class="box-body form-scroll">

                        <table id="manifestView" class="table table-bordered table-striped">
                            <thead>
                            <tr>

                              <th>MANIFEST ID</th>
                              <th>MANIFEST STATUS</th>
                              <th>END DATE</th>
                              <th>SOLD PRICE</th>
                              <th>LZ OFFER</th>                                
                              <th>System Offer</th>
                              <th>SHOW DETAILS</th>
                              <th>POST</th>
                              <th>FILE NAME (Rows)</th>
                              <th>LOADING NO</th>
                              <th>LOADING DATE</th>
                              <th>PURCH REF NO</th>                                
                              <th>SUPPLIER ID</th>
                              
                            </tr>
                            </thead>
                            <tbody>
                            <?php 
                            //var_dump($data['list_manf']['man_price']);exit;
                            $j=0;
                            foreach($data['list_manf']['list'] as $manf): ?>
                              <tr>
                                <td><?php echo $manf['LZ_MANIFEST_ID']; ?> </td>
                                <td>
                                <?php echo @$data['list_manf']['auc_det'][$j]['MANIFEST_STATUS']; ?> </td> 
                                <td>
                                <div class="text-center" style="width: 120px !important;">
                                <?php echo @$data['list_manf']['auc_det'][$j]['END_DATE']; ?>
                                </div>
                                </td>
                                <td>
                                <?php echo '$ '.number_format((float)@$data['list_manf']['auc_det'][$j]['SOLD_PRICE'],2,'.',','); ?>
                                </td> 
                                <td>
                                <?php echo '$ '.number_format((float)@$data['list_manf']['auc_det'][$j]['LZ_OFFER'],2,'.',','); ?>
                                </td>
                                
                                <td class="m-red">
                                  <div class="text-center" style="width: 100px !important;">
                                  <?php echo '$ '.number_format((float)@$data['list_manf']['man_price'][$j]['MAN_PRICE'],2,'.',','); ?>
                                  </div>
                                </td>
                                <td><a class="btn btn-xs btn-primary" href="<?php echo base_url(); ?>manifest_loading/c_manf_load/manf_detail/<?php echo $manf['LZ_MANIFEST_ID'] ?>">Detail</a></td>
                                <!-- href="<?php //echo base_url(); ?>manifest_loading/c_manf_load/manf_post/<?php //echo $manf['LZ_MANIFEST_ID'] ?>" -->
                                <td>
                                <?php if($manf['POSTED'] !== 'Posted') { ?>
                                     <a id="<?php echo $manf['LZ_MANIFEST_ID']; ?>" class="post_btn btn btn-primary btn-xs " ><?php echo $manf['POSTED']; ?> </a>
                                 <?php }else{ ?>
                                      <a id="<?php echo $manf['LZ_MANIFEST_ID']; ?>" class="btn btn-success btn-xs" >Posted </a>
                                  <?php  } ?>
                                </td>
                                <td><?php echo $manf['LOADING_NO']; ?></td>
                                <td><?php echo $manf['LOADING_DATE']; ?></td> 
                                <td><?php echo $manf['PURCH_REF_NO']; ?></td>                            
                                <td><?php echo $manf['SUPPLIER_ID']; ?></td>

                               
                                <td>
                                  <div style="width: 200px !important;">
                                <?php echo $manf['EXCEL_FILE_NAME']." (".$manf['TOTAL_EXCEL_ROWS'].")"; ?>
                                </div>
                                </td>

                              </tr>
                          <?php $j++; endforeach; ?>
                            </tbody>
                        </table><br>
                        
                </div>
              <?php endif; ?>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        <!-- Sumarry Section End-->


        <!-- Tab Section with Table View start-->
             <?php if ($data['detail']): ?>
            <div class="box">
           
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
          <?php if(@$this->session->userdata('active')){?>
              <li class=""><a href="#tab_1" data-toggle="tab">All</a></li>
              <li  class="active"><a href="#tab_2" data-toggle="tab">Unique</a></li>

            <?php 
            }else{?>
              <li class="active"><a href="#tab_1" data-toggle="tab">All</a></li>
              <li ><a href="#tab_2" data-toggle="tab">Unique</a></li>

              <?php } ?>
<!--               <li class="active"><a href="#tab_1" data-toggle="tab">All</a></li>
              <li><a href="#tab_2" data-toggle="tab">Unique</a></li> -->
              <!-- <li><a href="#tab_3" data-toggle="tab">Tab 3</a></li> -->
            </ul>
            <div class="tab-content">
            <?php if(@$this->session->userdata('active')){?>
              <div class="tab-pane" id="tab_1">

            <?php 
            }else{?>
              <div class="tab-pane active" id="tab_1">

              <?php } ?>
             
                <div class="box-body form-scroll">

                        <table id="manfDetail" class="table table-bordered table-striped">
                            <thead>
                            <tr>                               
                                <th>LOT REF</th>
                                <th>DESC</th>
                                <th>MANUFACTURE</th>                                
                                <th>MPN</th>
                                <th>UPC</th>
                                <!-- <th>SKU</th> -->
                                <th>RETAIL PRICE</th>
                                <th>ACTIVE PRICE</th>
                                <th>SOLD PRICE</th>
                                <th>MANNUAL PRICE</th>                                 
                                <th>CAT ID</th>
                                <th>CAT NAME</th>
                               
                                                              

                            </tr>
                            </thead>
                            <tbody>
                              <?php foreach($data['manf_data']['detail'] as $detail): ?>
                                <tr>
                                <td><?php echo @$detail['PO_DETAIL_LOT_REF'] ;?></td>
                                <td><div style="width: 220px !important;"><?php echo @$detail['ITEM_MT_DESC'] ;?></div></td>
                                <td><?php echo @$detail['ITEM_MT_MANUFACTURE'] ;?></td>
                                <td><?php echo @$detail['ITEM_MT_MFG_PART_NO'] ;?></td>
                                <td><?php echo @$detail['ITEM_MT_UPC'] ;?></td>
                                <!-- <td><?php //echo @$detail['ITEM_MT_BBY_SKU'] ;?></td> -->
                                <td><?php echo '$ '.number_format((float)@$detail['PO_DETAIL_RETIAL_PRICE'],2,'.',','); ?></td>
                                <td class="text-center m-orange"><?php echo '$ '.number_format((float)@$detail['PRICE'],2,'.',',');?></td>
                                <td class="text-center m-green"><?php echo '$ '.number_format((float)@$detail['S_PRICE'],2,'.',',');?></td>
                                <td class="text-center m-red"><?php echo '$ '.number_format((float)@$detail['V_PRICE'],2,'.',',');?></td>                                
                                <td><?php echo @$detail['E_BAY_CATA_ID_SEG6'];?></td>
                                <td><?php echo @$detail['CATEGORY_NAME_SEG7'];?></td>
                                 
                                                             

                                </tr>
                              <?php endforeach; ?>
                            </tbody>
                        </table><br>
                        
                </div>
              
              </div>
              <!-- /.tab-pane -->
              
            <?php if(@$this->session->userdata('active')){?>
              <div class="tab-pane active" id="tab_2">


            <?php 
            $this->session->unset_userdata('active');
            }else{?>
              <div class="tab-pane" id="tab_2">

              <?php } ?>
              
              <div id="msg" class="supdated" style="font-size:16px;color:green;font-weight:600;"></div>
              <?php if ($data['detail']): ?> 
                <div class="box-body form-scroll">
                  <?php echo form_open('manifest_loading/c_manf_load/mannual_price','name="update_price"','id="update_price"','role="form"'); ?>
                        <table id="manfDetailUnique" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>RETAIL PRICE</th>
                                <th>ACTIVE PRICE</th>
                                <th>SOLD PRICE</th>
                                <th>MANNUAL PRICE</th>
                                <th>MANNUAL</th>
                                <th>
                                  <div style="margin-left: 17px;" class="text-center">
                                    <input class="text-center" name="btSelectAll" type="checkbox" onClick="toggle(this)" />
                                  </div>
                                </th> 
                                <th>QTY</th>                                                      
                                <!-- <th>LOT REF</th> -->
                                <th>DESC</th>
                                <th>MANUFACTURE</th>                                
                                <th>MPN</th>
                                <th>UPC</th>
                                <!-- <th>SKU</th> -->
                                
                                <th>CAT ID</th>
                                <th>CAT NAME</th>  
                                                            

                            </tr>
                            </thead>
                            <tbody>
                              <?php 
                             $i=0;
                              foreach($data['manf_data']['unique_item'] as $unique): 
                                //LAPTOP_ZONE_ID
                               ?>
                                <tr>
                                <td><?php echo '$ '.number_format((float)@$unique['V_PRICE'],2,'.',','); ?></td>
                                <td class="text-center m-orange"><?php echo '$ '.number_format((float)@$unique['PRICE'],2,'.',',');?></td>
                                <td class="text-center m-green"><?php echo '$ '.number_format((float)@$unique['S_PRICE'],2,'.',',');?></td>
                                <td class="text-center m-red"><?php echo '$ '.number_format((float)@$unique['PO_DETAIL_RETIAL_PRICE'],2,'.',',');?></td>
                                <td class="m-blue">
                                <!-- <form name="myform" id="myform"> -->
                                <div class="text-center">
                                  <?php $MPN = str_replace(" ", '', @$unique['ITEM_MT_MFG_PART_NO']); 
                                       // $MPN = str_replace("/", '-', @$MPN);
                                  ?>
                                  <input type="text" style="width: 80px!important;" class="form-control"  name="<?php echo @$unique['ITEM_MT_UPC']."_".$MPN."_".@$detail['LZ_MANIFEST_ID']; ?>" id="<?php echo @$unique['ITEM_MT_UPC']."_".$MPN ; ?>" value="<?php echo number_format((float)@$unique['PO_DETAIL_RETIAL_PRICE'],2,'.',',');?>">

                                </div>  

                                </td>
                                <td>
                                <input type="checkbox" class="crsr-pntr btn btn-sm btn-success" style="margin-left:5px; margin-top: 10px; width: 40px!important;float: left;" name="selected_item[]" id="<?php echo @$detail['LZ_MANIFEST_ID'] ?>" value="<?php echo @$unique['ITEM_MT_UPC']."_".$MPN."_".@$detail['LZ_MANIFEST_ID']; ?>">
                                </td>
                                <td><?php echo @$data['manf_data']['sum_qty'][$i]['SUM_QTY'];?></td>
                                                              
                                <!-- <td id="lot_refff"><?php //echo @$unique['PO_DETAIL_LOT_REF'] ;?></td> -->

                                <td><div style="width: 220px !important;"><?php echo @$unique['ITEM_MT_DESC'] ;?></div></td>
                                <td><?php echo @$unique['ITEM_MT_MANUFACTURE'] ;?></td>
                                <td><?php echo @$unique['ITEM_MT_MFG_PART_NO'] ;?></td>
                                <td><?php echo @$unique['ITEM_MT_UPC'] ;?></td>
                                <!-- <td><?php //echo @$unique['ITEM_MT_BBY_SKU'] ;?></td> -->

                                <td><?php echo @$unique['E_BAY_CATA_ID_SEG6'] ;?></td>
                                <td><?php echo @$unique['CATEGORY_NAME_SEG7'] ;?></td>                                                                 

                               </tr>
                               <?php $i++; endforeach; ?>
                            </tbody>
                        </table><br>

                <div class="col-sm-12">
                  <div class="form-group">
                  <input type="submit" onClick="return checkboxVal();" class="btn btn-sm btn-success" id="man_prc"  name="submit" value="Update Price">
                
                  </div>
                </div>                         
              <?php echo form_close(); ?>         
            </div>
 

            <?php endif; ?>

           

              </div>

            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        <!-- Tab Section with Table View start-->
               
            <!-- /.box-body -->
            </div>
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