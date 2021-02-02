<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        kit Components
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">kit Components</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content"> 
      <div class="row">
        <div class="box"><br>  
          <div class="box-body form-scroll">  
          <?php if($this->session->flashdata('success')){ ?>
            <div class="alert alert-success">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
            </div>
            <?php }else if($this->session->flashdata('error')){  ?>
            <div class="alert alert-danger">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
              <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
            </div>
            <?php }else if($this->session->flashdata('warning')){  ?>
            <div class="alert alert-warning">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
              <strong>Error!</strong> <?php echo $this->session->flashdata('warning'); ?>
            </div>
            <?php }else if($this->session->flashdata('compo')){  ?>
            <div class="alert alert-danger">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
              <strong>Error!</strong> <?php echo $this->session->flashdata('compo'); ?>
            </div>
            <?php }
               $cat_id  = $this->uri->segment(4);
               $mpn_id  = $this->uri->segment(5);
               $cata_id = $this->uri->segment(6);
            ?>    
            <div class="col-md-12">
            <input type="hidden" name="ct_category_id" value="<?php echo $cat_id; ?>" id="ct_category_id">
            <input type="hidden" name="ct_catlogue_mt_id" value="<?php echo $mpn_id; ?>" id="ct_catlogue_mt_id">
            <input type="hidden" name="ct_cata_id" value="<?php echo $cata_id; ?>" id="ct_cata_id">
            <div class="row">
              <div class="col-sm-4">
                  <div class="form-group" style="font-size: 15px;">
                    <label for="ebay id">EBAY ID:</label>
                    <input class="form-control" type="text" value="<?php echo @$data['detail'][0]['EBAY_ID']; ?>" readonly> 
                </div>
              </div>
              <div class="col-sm-4">
                  <div class="form-group" style="font-size: 15px;">
                    <label for="ITEM DESCRIPTION">ITEM DESCRIPTION:</label>
                    <input class="form-control" type="text" value="<?php echo htmlentities(@$data['detail'][0]['TITLE']); ?>" readonly> 
                </div>
              </div>
              <div class="col-sm-4">
                  <div class="form-group" style="font-size: 15px;">
                    <label for="MPN">MPN:</label>
                    <input class="form-control" type="text" name="kitmpn" id="kitmpn" value="<?php echo @$data['detail'][0]['MPN']; ?>" readonly> 
                </div>
              </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <div class="form-group" style="font-size: 15px;">
                    <label for="ebay id">CONDITION:</label>
                    <input class="form-control" type="text" value="<?php echo @$data['detail'][0]['CONDITION_NAME']; ?>" readonly> 
                    <?php $cond_id  = $data['detail'][0]['CONDITION_ID'];?>
                </div>
              </div>
                <div class="col-sm-4">
                  <div class="form-group" style="font-size: 15px;">
                    <label for="ebay id">LIST PRICE:</label>
                    <input class="form-control" type="text" value="<?php  echo '$ '.number_format((float)@$data['detail'][0]['SALE_PRICE'],2,'.',','); ?>" readonly> 
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group" style="font-size: 15px;">
                    <label for="ebay id">SOLD AVG:</label>
                    <input class="form-control" type="text" value="<?php echo '$ '.number_format((float)@$data['detail'][0]['AVERAGE_PRICE'],2,'.',','); ?>" readonly> 
                  </div>
                </div>
            </div>
              <!-- Custom Tabs -->
              <table id="kit-components-table" class="table table-responsive table-striped table-bordered table-hover">
                <thead>
                  <th>ACTION</th>
                  <th>COMPONENTS</th>
                  <th>MPN</th>
                  <th>MPN DESCRIPTION</th>
                  <th>CONDITIONS</th>
                  <th>SELECT</th>
                  <th>QTY</th>
                  <th style="color: green;">SOLD PRICE</th>
                  <th>ESTIMATED PRICE</th>
                  <th>AMOUNT</th>
                  <th>EBAY FEE</th>
                  <th>PAYPAL FEE</th>
                  <th>SHIP FEE</th>
                  <th>TOTAL</th>
                </thead>
                <tbody id="reloa_id">

                <!-- Object Button list -->

                <div class="col-sm-12">
                  <?php foreach ($data['object_list'] as $value): ?>
                  <div class="col-sm-2">
                    <button type="button" id="myInput" title="<?php echo $value['OBJECT_NAME']; ?>" value="<?php echo $value['OBJECT_NAME']; ?>" class="btn btn-md btn-primary btn-block myInput" style="width: 140px;margin-left: 15px;"><?php echo $value['OBJECT_NAME']; ?> &nbsp; <?php  echo "(".$value['OBJECT_COUNT'].")"; ?></button>
                  </div>
                <?php endforeach; ?>

                </div>

                <!-- end of ojbect button list -->

                  <?php
                  $total_avg_prices = 0;
                  $totals = 0;
                  $i=1;
                  // echo "<pre>";
                  // print_r($data['results']->result_array());
                  // echo "</pre>";
                  // exit;
                  if($data['results']->num_rows() > 0)
                  {
                    foreach ($data['results']->result_array() as $result) {
                  ?>
                    <tr>
                      <td>
                        <a title="Delete Component" href="<?php echo base_url().'catalogueToCash/c_purchasing/cp_delete_component/'.$cat_id.'/'.$mpn_id.'/'.$cata_id.'/'.@$result['MPN_KIT_MT_ID']; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                        </a>
                      </td>
                      <td>
                        <?php echo @$result['OBJECT_NAME']; ?>
                        <input type="hidden" name="ct_kit_mpn_id_<?php echo $i; ?>" class="kit_componets" id="ct_kit_mpn_id_<?php echo $i; ?>" value="<?php echo @$result['MPN_KIT_MT_ID']; ?>">
                      </td>
                      <td>
                        <?php echo @$result['MPN']; ?>
                      </td>
                      <td>
                        <?php echo @$result['MPN_DESCRIPTION']; ?>
                      </td>
                      <td>
                        <input type="hidden" class="part_catlg_mt_id" name="part_catlg_mt_id" id="part_catlg_mt_id" value="<?php echo @$result['PART_CATLG_MT_ID']; ?>">
                            <div class="form-group" style="width: 200px;">
                                <select class="form-control selectpicker estimate_condition" name="estimate_condition" id="estimate_condition" ctmt_id="<?php echo @$result['PART_CATLG_MT_ID']; ?>" rd = "<?php echo $i; ?>" data-live-search="true" style="width: 150px;">
                                  <option value="">All</option>
                                  <?php                                 
                                    foreach(@$data['conditions'] as $type) { 
                                    if ($cond_id == $type['ID']){
                                          $selected = "selected";
                                        }else {
                                            $selected = "";
                                        }                
                                        ?>
                                         <option value="<?php echo $type['ID']; ?>"<?php echo $selected; ?>><?php echo $type['COND_NAME']; ?></option>
                                        <?php
                                         /*$this->session->unset_userdata('ctListing_condition');*/
                                        } 
                                     ?>                     
                                </select> 
                            </div>
                      </td>
                      <td>
                        <div style="width: 70px;">
                           <input type="checkbox" name="cata_component" id="component_check_<?php echo $i; ?>" value="<?php echo $i; ?>" class="checkboxes" style="width: 60px;">
                        </div>
                        
                      </td>
                      <td>
                        <?php 
                        $quantity = @$result['QTY']; ?>
                        
                        <div class="form-group" style="width:70px;">
                          <input type="hidden" name="part_catalogue_mt_id" value="<?php echo @$result['PART_CATLG_MT_ID']; ?>">
                          <input type="number" name="cata_component_qty_<?php echo $i; ?>" id="cata_component_qty_<?php echo $i; ?>" rowid="<?php echo $i; ?>" class="form-control input-sm component_qty" value="<?php if(!empty($quantity)) {echo $quantity; }else{ echo 1;}?>" style="width:60px;">
                        </div>
                      </td>
                      <td>
                        <?php 
                        $avg_price = @$result['AVG_PRICE'];
                        $total_avg_prices += $avg_price;
                         ?>
                        <div class="form-group">
                          <input type="text" name="cata_avg_price_<?php echo $i; ?>" id="cata_avg_price_<?php echo $i; ?>" class="form-control input-sm cata_avg_price" value="<?php echo '$ '.number_format((float)@$avg_price,2,'.',','); ?>" style="width:80px;" readonly>
                        </div>
                      </td> 
                    <td>
                      <?php $est_price_name="cata_est_price_".$i; 
                      ?>
                      <div class="form-group" style="width:80px;">
                        <input type="number" name="<?php echo $est_price_name; ?>" id="cata_est_price_<?php echo $i; ?>" class="form-control input-sm cata_est_price" value="<?php if(isset($_POST['$est_price_name'])){ echo $estimate_price= $_POST['$est_price_name']; }else { echo $estimate_price= number_format((float)@$avg_price,2,'.',','); } ?>" style="width:80px;">
                      </div>
                    </td>
                    <td>
                       <div class="form-group" style="width:80px;">
                       <input type="text" name="cata_amount_<?php echo $i; ?>" id="cata_amount_<?php echo $i; ?>" class="form-control input-sm cata_amount" value="$ 0.00" style="width:80px;" readonly>
                      </div>
                    </td>
                    <td>
                      <?php
                      if (!empty($avg_price)) {
                            $ebay_fee= ($avg_price  * (8 / 100));
                          }else {
                            $ebay_fee= ($estimate_price  * (8 / 100));
                          }

                        ?>
                      <div class="form-group" style="width:80px;">
                       <input type="text" name="cata_ebay_fee_<?php echo $i; ?>" id="cata_ebay_fee_<?php echo $i; ?>" class="form-control input-sm cata_ebay_fee" value="<?php echo '$ '.number_format((float)@$ebay_fee,2,'.',','); ?>" style="width:80px;" readonly>
                      </div>
                    </td>
                    <td>
                      <?php 
                      $paypal_fee= ($avg_price  * (2.5 / 100));
                        if (!empty($avg_price)) {
                          $paypal_fee= ($avg_price  * (2.5 / 100));
                          }else {
                            $paypal_fee= ($estimate_price  * (2.5 / 100));
                          }
                       ?>
                      <div class="form-group" style="width:80px;">
                        <input type="text" name="cata_paypal_fee_<?php echo $i; ?>" id="cata_paypal_fee_<?php echo $i; ?>" class="form-control input-sm cata_paypal_fee" value="<?php echo '$ '.number_format((float)@$paypal_fee,2,'.',','); ?>" style="width:80px;" readonly>
                      </div>
                    </td>
                    <td>
                      <div class="form-group">
                        <input type="text" name="cata_ship_fee_1" id="cata_ship_fee_<?php echo $i; ?>" class="form-control input-sm cata_ship_fee" value="$ 3.25" style="width:80px;" readonly>
                      </div>
                    </td>
                    <td class="rowDataSd">
                    <?php 
                      $cahrges  = $ebay_fee + $paypal_fee + 3.25;
                      $total    = $avg_price + $cahrges;
                      $totals += $total;
                      ?>
                      <p id="cata_total_<?php echo $i; ?>" class="totalRow"><?php echo "$ ".$total; ?></p>
                    </td>
                    <?php
                      $i++;
                      // echo "</tr>"; 
                      } ///end foreach 
                    ?>
                    </tr>
                  
                  </tbody> 
                  </table>
                  <?php
                  }else { //end main if
                  ?>
                </tbody> 
              </table>              
              <?php
              } ?>
            <!-- nav-tabs-custom -->
            </div>
            <!-- /.col-sm-12--> 
            <div class="col-sm-12" style="margin-top: 15px;">
              <input type="hidden" name="countrows" value="<?php echo $i-1; ?>" id="countrows">
              <div class="form-group col-sm-2 pull-left">
                <button type="button" title="Add Component"  class="btn btn-primary" id="add_kit_component">Add Component</button>
              </div>
              <div class="form-group col-sm-1 pull-left">
                <button type="button" title="Copy Catalogues"  class="btn btn-primary" id="copy_catalogues">Copy</button>
              </div>
              <div class="col-sm-3">
              <div class="form-group" style="font-size: 18px;">
               <!--  <b class="col-sm-offset-4 pull-left">Sold Price = 
                <?php
                  //echo '$ '.number_format((float)@$total_avg_prices,2,'.',',');
               ?>
               </b> -->
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-group" style="font-size: 18px;">
                <!-- <b class="col-sm-offset-2 pull-left" id="grand_total">Grand Total = 
                <?php
                  //echo '$ '.number_format((float)@$totals,2,'.',',');
               ?>
               </b> -->
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-group pull-left">
                <button type="button" title="Save Components"  class="btn btn-success col-sm-offset-1" id="save_components">Save</button>
              </div>
            </div>

            <div class="col-sm-2">
              <div class="form-group pull-right">
                <input class="form-control" type="text" name="kitmpnauto" id="kitmpnauto" value="<?php echo @$data['detail'][0]['MPN']; ?>">
              </div>
            </div>             
 
            <div class="col-sm-1">
              <div class="form-group pull-right">
                <button type="button" title="Create Auto Kit"  class="btn btn-primary" name="createAutoKit" id="createAutoKit">Create Auto Kit</button>
              </div>
            </div>                  
            </div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
         <!-- second block  Catalogue Detail start -->   
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Catalogue Detail</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
            <div class="box-body">
              <div class='col-sm-12' id="component-toggle">
              <div class='col-sm-3'>
                <div class="form-group" id="bdObject">
                  <label>Object:</label>
                  <select name="bd_object" id="bd_object" class="form-control selectpicker" data-live-search="true" required> 
                      <option value="0">---</option>
                    <?php                                
                       if(!empty($getAllObjects)){
                        foreach ($getAllObjects as $object){
                          ?>
                          <option value="<?php echo $object['OBJECT_ID']; ?>" <?php if($this->input->post('bd_object') == $object['OBJECT_ID']){echo "selected";}?>> <?php echo $object['OBJECT_NAME']; ?>
                          </option>
                          <?php
                          } 
                        }   
                    ?>                      
                  </select> 
                </div>
              </div>
              <div class='col-sm-3'>
                <div class="form-group" id="brands">   
                </div>
              </div>
              <div class='col-sm-3'>
                <div class="form-group" id="bdMPN">   
                </div>
              </div>
              <div class='col-sm-1'>
                <div class='form-group'>
                  <label>Quantity:</label>
                  <input class='form-control' type='text' name='kit_qty' id='kit_qty' value='1' placeholder='Enter Quantity'/>
                </div>
              </div>                                                
              <div class="col-sm-1">
                <div class="form-group p-t-24">
                  <input type="button" class="btn btn-success btn-sm" name="save_mpn_kit" id="save_mpn_kit" value="Save">
                </div>
              </div>
              <div class="form-group col-sm-1 p-t-24">
                 <!-- <input type="button" class="btn btn-info btn-sm" name="go_to_catalogue" id="go_to_catalogue" value="Add PMN"> -->
                 <a type="button" class="btn btn-info btn-sm" href="<?php echo base_url().'catalogue/c_itemCatalogue/getCategorySpecifics/'.$cat_id.'/'.$mpn_id; ?>"  target="_blank" >Add MPN</a>
              </div>
              <!-- MPN Block end -->
            </div>
           </div>
          </div>  
          <!-- second block  Catalogue Detail end -->  
          <!-- Copy Estimate start --> 
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Copy Estimate</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
            <div class="box-body">             
            <!-- /.col-sm-12-->   
               <div class="col-sm-12">
                <div class="col-sm-6">
                  <h4>MPN : <?php 
                  if(!empty($data['mpn'])){
                    echo $data['mpn'][0]['MPN'];
                  }?></h4>
                </div>
                <div class="col-sm-6">
                  <h4>Total Count : <?php 
                  if(!empty($data['mpn'])){
                    echo $data['mpn'][0]['CAT_COUNT'];
                  }?></h4>
                </div>     
            </div>
               <div class="col-sm-12">
                 
               <form action="<?php echo base_url().'catalogueToCash/c_purchasing/getCatalogueSearch/'.$cat_id.'/'.$mpn_id.'/'.$cata_id; ?>" method="post" accept-charset="utf-8">
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="Search Webhook">Listing Type:</label>
                      <select class="form-control selectpicker" name="catalogue_List_type" id="catalogue_List_type" data-live-search="true">
                        <option value="">All</option>
                        <?php 
                        $this->session->unset_userdata('catalogue_List_type');
                        $ctcatalogue_List_type = $this->session->userdata("catalogue_List_type");                              
                          foreach(@$data['list_types'] as $type) { 
                            if ($ctcatalogue_List_type == strtoupper($type['LISTING_TYPE'])){
                                $selected = "selected";
                              }else {
                                  $selected = "";
                              }                 
                              ?>
                              <option value="<?php echo $type['LISTING_TYPE']; ?>"<?php echo $selected; ?>><?php echo $type['LISTING_TYPE']; ?></option>
                              <?php
                           
                              } 
                           ?>                     
                      </select>                       
                  </div>
                </div>  
                 <div class="col-sm-4">
                  <div class="form-group">
                    <label for="Search Webhook">Condition:</label>
                      <select class="form-control selectpicker" name="catalogue_condition" id="catalogue_condition" data-live-search="true">
                        <option value="">All</option>
                        <?php 
                        $this->session->unset_userdata('catalogue_condition');
                        $catalogue_condition = $this->session->userdata("catalogue_condition");                                
                          foreach(@$data['conditions'] as $type) { 
                          if ($catalogue_condition == $type['ID']){
                                $selected = "selected";
                              }else {
                                  $selected = "";
                              }                
                              ?>
                               <option value="<?php echo $type['ID']; ?>"<?php echo $selected; ?>><?php echo $type['COND_NAME']; ?></option>
                              <?php
                               /*$this->session->unset_userdata('ctListing_condition');*/
                              } 
                           ?>                     
                      </select> 
                  </div>
                </div>                 
                <div class="col-sm-2">
                  <div class="form-group p-t-24">
                    <input type="submit" class="btn btn-primary btn-sm" name="search_webhook" id="search_webhook" value="Search">
                  </div>
                </div>
              </form>                                            
            </div> <!-- end of form -->
            <!-- start of catalogue detail part -->
            <div class="col-md-12">
              <input type="hidden" name="ct_category" value="<?php echo $cat_id; ?>" id="ct_category">
              <!-- Custom Tabs -->
              <table id="catalogue-detail-table" class="table table-responsive table-striped table-bordered table-hover">
               <thead>
                 <tr>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th colspan="4" class="text text-center" style="background: green; color: white;">PRICE</th>
                  <th colspan="4" class="text text-center" style="background: red; color: white;">CHARGES</th>
                  <th colspan="2" class="text text-center" style="background: brown; color: white;">PROFIT</th>
                          
                </tr>
                 <tr>
                  <th>ACTION</th>
                  <th>EBAY ID</th>
                  <th>CATLOGUES</th>
                  <th>ITEM DESCRIPTION</th>
                  <th>SELLER ID</th>
                  <th>FEEDBACK SCORE</th>
                  <th>LISTING TYPE</th>
                  <th>REMAINING TIME</th>
                  <th>MPN</th>
                  <th>CONDITION</th>
                  <th>ACTIVE PRICE</th>
                  <th>SOLD AVG</th>
                  <th>LIST SOLD</th>
                  <th>%</th>
                </tr>
              </thead>
            </table>
          </div><!-- /.col --> 
          <div class="col-sm-12">
            <div class="form-group col-sm-2 pull-left">
            <button type="button" title="Copy Specific"  class="btn btn-primary" id="copy_specific_catalogue">Copy Specific</button>
          </div>
          <div class="form-group col-sm-2 pull-left">
            <button type="button" title="Copy All"  class="btn btn-primary" id="copy_all_catalogues">Copy All</button>
          </div>
          </div>
            <!-- end of catalogue detail part -->
              <!-- end of box body -->
          </div> 
          <!-- end second block start --> 
          <!-- Copy Estimate start -->
      </div>
      <!-- /.row -->
    </section>
    <div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
      <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="ajax loader" style="width: 100px; height: 100px;">
    </div>
    <!-- /.content -->
  </div>    
<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>
<script>
$(document).ready(function()
  {
    var table = $('#kit-components-table').DataTable({
      "oLanguage": {
      "sInfo": "Total Records: _TOTAL_"
    },
    "iDisplayLength": 500,
        "aLengthMenu": [[25, 50, 100, 200,500, -1], [25, 50, 100, 200,500, "All"]],
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      // "order": [[ 16, "ASC" ]],
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
    });
    $('.myInput').on( 'click', function () {
        table.search( this.value ).draw();
    } );

  // $('#kit-components-table tr').each(function(){
  //   $(this).closest('tr').find('input.component_qty, input.cata_avg_price,input.cata_est_price,input.cata_ebay_fee,input.cata_paypal_fee,input.cata_ship_fee,.totalRow').prop('disabled', true);
  // });
// function disableRow(){
//   $(this).closest('tr').find('input.component_qty, input.cata_avg_price,input.cata_est_price,input.cata_ebay_fee,input.cata_paypal_fee,input.cata_ship_fee,.totalRow').prop('disabled', true);
// }
  /*==================================================
  =            FOR SHOWING CATALOGUE DETAIL          =
  ===================================================*/
  $("#copy_catalogues").on('click', function(event) {
    event.preventDefault();
     var dataTable = $('#catalogue-detail-table').DataTable({  
      "oLanguage": {
      "sInfo": "Total Records: _TOTAL_",
      //"sPaginationType": "full_numbers",
      
    },
    // For stop ordering on a specific column
    // "columnDefs": [ { "orderable": false, "targets": [0] }],
    // "pageLength": 5,
       "iDisplayLength": 500,
      "aLengthMenu": [[25, 50, 100, 200,500, -1], [25, 50, 100, 200,500, "All"]],
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
      // "bAutoWidth": false,
      "ajax":{
        url :"<?php echo base_url().'catalogueToCash/c_purchasing/loadCatalogues/'.$cat_id.'/'.$mpn_id.'/'.$cata_id; ?>", // json datasource
        type: "post"  // method  , by default get
        // data: {},
        
        },
        "columnDefs":[{
            "target":[0],
            "orderable":false
          }
        ]

      });
  });
 
 $('#kit-components-table').append('<tr> <td></td> <td ></td> <td ></td><td></td><td></td><td><label>Checked: </label><p class="totalChecks"></p></td> <td> <label>Total Qty : </label> <div class="form-group"> <input type="text" name="total_component_qty" id="total_component_qty_1" class="form-control input-sm total_qty" value="0.00" style="width:80px;" readonly> </div> </td> <td><label>Total Sold Price:</label><div class="form-group"> <input type="text" name="total_sold_price" id="total_sold_price" class="form-control input-sm total_sold" value="0.00" style="width:100px;" readonly> </div></td> <td><label>Total Estimate: </label><div class="form-group"> <input type="text" name="total_estimate_price" id="total_estimate_price" class="form-control input-sm total_estimate" value="$0.00" style="width:100px;" readonly> </div></td><td><label>Total Amount: </label><div class="form-group"> <input type="text" name="total_amount" id="total_amount" class="form-control input-sm amounts" value="$0.00" style="width:100px;" readonly> </div></td><td><label>Total Ebay Fee: </label><div class="form-group"> <input type="text" name="total_ebay_fee" id="total_ebay_fee" class="form-control input-sm total_ebay" value="0.00" style="width:100px;" readonly> </div></td> <td><label>Total Paypal:</label><div class="form-group"> <input type="text" name="total_paypal_fee" id="total_paypal_fee" class="form-control input-sm total_paypal" value="0.00" style="width:100px;" readonly> </div></td> <td><label>Total Shipping:</label><div class="form-group"> <input type="text" name="total_ship_fee" id="total_ship_fee" class="form-control input-sm total_shipping" value="0.00" style="width:100px;" readonly> </div></td> <td><label>Sub Total:</label><p class="totalClass"/></p></td> </tr>');
  /*==================================================
  =            FOR ADDING KIT COMPONENTS             =
  ===================================================*/
  $("#save_components").click(function(){

    var fields = $("input[name='cata_component']").serializeArray(); 
      if (fields.length === 0) 
      { 
          alert('Please Select at least one Component'); 
          // cancel submit
          return false;
      }  

    var arr=[];
    var cat_id= '<?php echo $this->uri->segment(4); ?>';
    var mpn_id= '<?php echo $this->uri->segment(5); ?>';
    var dynamic_cata_id= '<?php echo $this->uri->segment(6); ?>';
    var url='<?php echo base_url() ?>catalogueToCash/c_purchasing/savekitComponents';
    var partsCatalgid = [];
    var compName=[];
    var compQty=[];
    var compAvgPrice=[];
    var compAmount=[];
    var ebayFee=[];
    var payPalFee=[];
    var shipFee=[];
    var tech_condition=[];


      var tableId="kit-components-table";
      var tdbk = document.getElementById(tableId);
      $.each($("#"+tableId+" input[name='cata_component']:checked"), function()
      {            
        arr.push($(this).val());
      });
    //alert(arr);
    //console.log(arr); return false;
    //category_id.push($(tdbk.rows[1].cells[2]).text());
       for (var i = 0; i < arr.length; i++)
          {
            //compName.push($(tdbk.rows[arr[i]].("#ct_kit_mpn_id_"+(i+1))).val());
            $(tdbk.rows[arr[i]]).find(".part_catlg_mt_id").each(function() {
              partsCatalgid.push($(this).val());
            });
            $(tdbk.rows[arr[i]]).find(".estimate_condition").each(function() {
              tech_condition.push($(this).val());
            });
            $(tdbk.rows[arr[i]]).find(".kit_componets").each(function() {
                    compName.push($(this).val());
                  }); 

             $(tdbk.rows[arr[i]]).find(".component_qty").each(function() {
                    compQty.push($(this).val());
                  }); 

              $(tdbk.rows[arr[i]]).find('.cata_avg_price').each(function() {
                compAvgPrice.push($(this).val());
              }); 

              $(tdbk.rows[arr[i]]).find('.cata_est_price').each(function(){
                compAmount.push($(this).val());
              });

              $(tdbk.rows[arr[i]]).find('.cata_ebay_fee').each(function(){
                ebayFee.push($(this).val());
              });

              $(tdbk.rows[arr[i]]).find('.cata_paypal_fee').each(function(){
                payPalFee.push($(this).val());
              });

              $(tdbk.rows[arr[i]]).find('.cata_ship_fee').each(function(){
                shipFee.push($(this).val());
              });           
          }

          tech_condition = tech_condition.filter(v=>v!='');
      //console.log(tech_condition); return false;
      //console.log(compName); return false;
      $(".loader").show();
        $.ajax({
          type: 'POST',
          url:url,
          data: {
            'cat_id': cat_id,
            'dynamic_cata_id': dynamic_cata_id,
            'mpn_id': mpn_id,
            'compName': compName,
            'compQty': compQty,
            'compAvgPrice': compAvgPrice,
            'compAmount': compAmount,
            'ebayFee': ebayFee,
            'payPalFee': payPalFee,
            'shipFee': shipFee,
            'partsCatalgid':partsCatalgid,
            'tech_condition':tech_condition
          },
          dataType: 'json',
          success: function (data){
               if(data == 0){
                  alert('Warning: Data is already inserted against this catalogue!');
                  window.location.href = '<?php echo base_url(); ?>catalogueToCash/c_purchasing/searchPurchaseDetail';
               }else if(data == 1){
                  alert("Success: Estimate is created!"); 
                  window.location.href = '<?php echo base_url(); ?>catalogueToCash/c_purchasing/searchPurchaseDetail';  
               }else if(data == 2){
                 alert('Error: Fail to create estimate!');
               }
             },
          complete: function(data){
            $(".loader").hide();
          }
    });
  
  });
  /*=========================================================
  =         CHARGES CALCULATION FROM ESTIMATE PRICE         =
  ===========================================================*/ 
   /*=========================================================
  =         CHARGES CALCULATION FROM ESTIMATE PRICE         =
  ===========================================================*/ 
  $(".cata_est_price").on('blur', function(){
    var est_id = this.id.match(/\d+/);

    var est_comp_check = $("#component_check_"+est_id).attr( "checked", true );


    var est_price = $(this).val().replace(/\$/g, '').replace(/\ /g, '');
    var qty = $("#cata_component_qty_"+est_id).val();
    var amount = parseFloat(parseFloat(est_price) * parseFloat(qty)).toFixed(2);
   
    var ebay_price = (amount * (8 / 100)).toFixed(2); 
    var paypal_price = (amount  * (2.5 / 100)).toFixed(2);
    var ship_fee = $("#cata_ship_fee_"+est_id).val().replace(/\$/g, '').replace(/\ /g, '');
     //console.log(est_price, qty, ebay_price, paypal_price, ship_fee); return false;
    $("#cata_amount_"+est_id).val('$ '+amount);
    //console.log(ebay_price, paypal_price); return false;
    $("#cata_ebay_fee_"+est_id).val('$ '+ebay_price);
    $("#cata_paypal_fee_"+est_id).val('$ '+paypal_price);
    var total = parseFloat(parseFloat(amount) + parseFloat(ebay_price) + parseFloat(paypal_price) + parseFloat(ship_fee)).toFixed(2);
    $("#cata_total_"+est_id).html('$ '+total);
/////////////////////////////////////
    var tableId="kit-components-table";
    var tdbk = document.getElementById(tableId);
    //console.log(tdbk); return false;
      var total= 0;
     var grand_total= 0;
      var row_count = $('#'+tableId+' tr').length;
     // console.log(row_count); return false;
      for(var i = 1; i <= row_count -1; i++)
          {
           total = $(tdbk.rows[i].cells[11]).text().replace(/\$/g, '').replace(/\ /g, ''); 
            grand_total = parseFloat(parseFloat(grand_total)+parseFloat(total)).toFixed(2);         
          }
          $("#grand_total").html('Grand Total = $ '+grand_total);
      //console.log(grand_total); grand_total
      $('#component_check_'+est_id).is(":checked");
      // $('#cata_component_qty'+est_id)
      var sum = 0;
      $("input[class *= 'component_qty']").each(function(){
          var id = this.id.match(/\d+/);
          if($('#component_check_'+id).is(":checked")){
            sum += +$(this).val();
          }
          
      });
      $(".total_qty").val(sum);
      ///////////////////////////////////
      var total_amounts = 0;
      $("input[class *= 'cata_amount']").each(function(){
          var id = this.id.match(/\d+/);
          if($('#component_check_'+id).is(":checked")){
            yourAmount = $(this).val().replace ( /[^\d.]/g, '' );
            total_amounts += +yourAmount;
          }      
      });

      $(".amounts").val('$'+total_amounts.toFixed(2));
      ////////////////////////////////////
      var sum_sold = 0;
      $("input[class *= 'cata_avg_price']").each(function(){
          var id = this.id.match(/\d+/);
          if($('#component_check_'+id).is(":checked")){
            yourString = $(this).val().replace ( /[^\d.]/g, '' );
            sum_sold += +yourString;
          }
          
      });
      $(".total_sold").val('$'+sum_sold.toFixed(2));

      var sum_est = 0;
      $("input[class *= 'cata_est_price']").each(function(){

          sum_est += +$(this).val();
      });
      $(".total_estimate").val('$'+sum_est.toFixed(2));

      var sum_ebay = 0;
      $("input[class *= 'cata_ebay_fee']").each(function(){
          var id = this.id.match(/\d+/);
          if($('#component_check_'+id).is(":checked")){
            yourString = $(this).val().replace ( /[^\d.]/g, '' );
            sum_ebay += +yourString;
          }
          
      });
      $(".total_ebay").val('$'+sum_ebay.toFixed(2));

      var sum_paypal = 0;
      $("input[class *= 'cata_paypal_fee']").each(function(){
          var id = this.id.match(/\d+/);
          if($('#component_check_'+id).is(":checked")){
            yourString = $(this).val().replace ( /[^\d.]/g, '' );
            sum_paypal += +yourString;
          }
          
      });
      $(".total_paypal").val('$'+sum_paypal.toFixed(2));


      var sum_ship = 0;
      $("input[class *= 'cata_ship_fee']").each(function(){
          var id = this.id.match(/\d+/);
          if($('#component_check_'+id).is(":checked")){
            yourString = $(this).val().replace ( /[^\d.]/g, '' );
            sum_ship += +yourString;
          }
          
      });
      $(".total_shipping").val('$'+sum_ship.toFixed(2));


      // var sum_row = 0;
      // $("input[class *= 'totalRow']").each(function(){
      //     yourString = $(this).val().replace ( /[^\d.]/g, '' );
      //     sum_row += +yourString;
      // });
      // $(".totalClass").val(sum_row.toFixed(2));

      var sum_row = 0;
      $('.totalRow').each(function(){
          var id = this.id.match(/\d+/);
          if($('#component_check_'+id).is(":checked")){
            sum_row += parseFloat($(this).text().replace ( /[^\d.]/g, '' ));
          }
            // Or this.innerHTML, this.innerText
      });
      $(".totalClass").text('$'+sum_row.toFixed(2));

     var checker = 0;
     checker = $('input.checkboxes:checked').length;
     $(".totalChecks").text(checker);
  });
  /*==============================================================
  =                 GET RELATED MPNS ON CHANGE OBJECTS           =
  ================================================================*/
    /*=========================================================
  =         CHARGES CALCULATION FROM ESTIMATE PRICE         =
  ===========================================================*/ 
    $(".component_qty").on('blur', function(){
    var qty_id = $(this).attr("rowid");
    var est_comp_check = $("#component_check_"+qty_id).attr( "checked", true );
    var qty = $("#cata_component_qty_"+qty_id).val();
    var est_price = $("#cata_est_price_"+qty_id).val().replace(/\$/g, '').replace(/\ /g, '');
    var amount = (est_price * qty).toFixed(2); 
    //console.log(qty, est_price, amount); return false;
    //alert(est_price); return false;
    var ebay_price = (amount * (8 / 100)).toFixed(2); 
    var paypal_price = (amount  * (2.5 / 100)).toFixed(2);
    var ship_fee = $("#cata_ship_fee_"+qty_id).val().replace(/\$/g, '').replace(/\ /g, '');
    $("#cata_amount_"+qty_id).val('$ '+amount);
    //console.log(qty, est_price, ebay_price, paypal_price); return false;
    $("#cata_ebay_fee_"+qty_id).val('$ '+ebay_price);
    $("#cata_paypal_fee_"+qty_id).val('$ '+paypal_price);
    var total = parseFloat(parseFloat(est_price) + parseFloat(ebay_price) + parseFloat(paypal_price) + parseFloat(ship_fee)).toFixed(2);
    $("#cata_total_"+qty_id).html('$ '+total);
    /////////////////////////////////////
    var tableId="kit-components-table";
    var tdbk = document.getElementById(tableId);
    //console.log(tdbk); return false;
     var total= 0;
     var grand_total= 0;
     var row_count = $('#'+tableId+' tr').length;
     // console.log(row_count); return false;
      for(var i = 1; i <= row_count -1; i++)
          {
           total = $(tdbk.rows[i].cells[11]).text().replace(/\$/g, '').replace(/\ /g, ''); 
            grand_total = parseFloat(parseFloat(grand_total)+parseFloat(total)).toFixed(2);         
          }
          $("#grand_total").html('Grand Total = $ '+grand_total);
      //console.log(grand_total); grand_total
      $('#component_check_'+qty_id).is(":checked");
      // $('#cata_component_qty'+qty_id)
      var sum = 0;
      $("input[class *= 'component_qty']").each(function(){
          var id = this.id.match(/\d+/);
          if($('#component_check_'+id).is(":checked")){
            sum += +$(this).val();
          }
          
      });
      $(".total_qty").val(sum);
      ///////////////////////////////////
      var total_amounts = 0;
      $("input[class *= 'cata_amount']").each(function(){
          var id = this.id.match(/\d+/);
          if($('#component_check_'+id).is(":checked")){
            yourAmount = $(this).val().replace ( /[^\d.]/g, '' );
            total_amounts += +yourAmount;
          }      
      });

      $(".amounts").val('$'+total_amounts.toFixed(2));
      ////////////////////////////////////
      var sum_sold = 0;
      $("input[class *= 'cata_avg_price']").each(function(){
          var id = this.id.match(/\d+/);
          if($('#component_check_'+id).is(":checked")){
            yourString = $(this).val().replace ( /[^\d.]/g, '' );
            sum_sold += +yourString;
          }
          
      });
      $(".total_sold").val('$'+sum_sold.toFixed(2));

      var sum_est = 0;
      $("input[class *= 'cata_est_price']").each(function(){

          sum_est += +$(this).val();
      });
      $(".total_estimate").val('$'+sum_est.toFixed(2));

      var sum_ebay = 0;
      $("input[class *= 'cata_ebay_fee']").each(function(){
          var id = this.id.match(/\d+/);
          if($('#component_check_'+id).is(":checked")){
            yourString = $(this).val().replace ( /[^\d.]/g, '' );
            sum_ebay += +yourString;
          }
          
      });
      $(".total_ebay").val('$'+sum_ebay.toFixed(2));

      var sum_paypal = 0;
      $("input[class *= 'cata_paypal_fee']").each(function(){
          var id = this.id.match(/\d+/);
          if($('#component_check_'+id).is(":checked")){
            yourString = $(this).val().replace ( /[^\d.]/g, '' );
            sum_paypal += +yourString;
          }
          
      });
      $(".total_paypal").val('$'+sum_paypal.toFixed(2));


      var sum_ship = 0;
      $("input[class *= 'cata_ship_fee']").each(function(){
          var id = this.id.match(/\d+/);
          if($('#component_check_'+id).is(":checked")){
            yourString = $(this).val().replace ( /[^\d.]/g, '' );
            sum_ship += +yourString;
          }
          
      });
      $(".total_shipping").val('$'+sum_ship.toFixed(2));

      var sum_row = 0;
      $('.totalRow').each(function(){
          var id = this.id.match(/\d+/);
          if($('#component_check_'+id).is(":checked")){
            sum_row += parseFloat($(this).text().replace ( /[^\d.]/g, '' ));
          }
      });
      $(".totalClass").text('$'+sum_row.toFixed(2));

     var checker = 0;
     checker = $('input.checkboxes:checked').length;
     $(".totalChecks").text(checker);

  });
/*==============================================================
  =                 GET RELATED BRANDS ON CHANGE OBJECTS           =
  ================================================================*/
  $('#bd_object').on('change',function(){

  var object_id = $('#bd_object').val();
  // alert(object_id);
  $(".loader").show();
  $.ajax({
    url:'<?php echo base_url(); ?>catalogueToCash/c_purchasing/get_brands',
    type:'post',
    dataType:'json',
    data:{'object_id':object_id},
    success:function(data){
      var brands = [];
       // alert(data.length);return false;
      for(var i = 0;i<data.length;i++){
        brands.push('<option value="'+data[i].SPECIFIC_VALUE+'">'+data[i].SPECIFIC_VALUE+'</option>')
      }
      $('#brands').html("");
      $('#brands').append('<label>Brands:</label><select name="bd_brands" id="bd_brands" class="form-control bd_brands" data-live-search="true" required>'+brands.join("")+'</select>');
      $('.brands').selectpicker();
    },
     complete: function(data){
      $(".loader").hide();
    }
  });
});

    /*==============================================================
  =                 GET RELATED MPNS ON CHANGE OBJECTS           =
  ================================================================*/
  $(document).on('change', '.bd_brands', function(){

  var brand_name = $(this).val();
  $(".loader").show();
  $.ajax({
    url:'<?php echo base_url(); ?>catalogueToCash/c_purchasing/get_mpns',
    type:'post',
    dataType:'json',
    data:{'brand_name':brand_name},
    success:function(data){
      var mpns = [];
       // alert(data.length);return false;
      for(var i = 0;i<data.length;i++){
        mpns.push('<option value="'+data[i].CATALOGUE_MT_ID+'">'+data[i].MPN+'</option>')
      }
      $('#bdMPN').html("");
      $('#bdMPN').append('<label>Component MPN:</label><select name="bd_mpn" id="bd_mpn" class="form-control bdMPNS" data-live-search="true" required>'+mpns.join("")+'</select>');
      $('.bdMPNS').selectpicker();
    },
     complete: function(data){
      $(".loader").hide();
    }
  });
});
  /*==============================================================
  =   END FUNCTION FOR CHARGES CALCULATION FROM ESTIMATE PRICE   =
  ================================================================*/
/*--- Onchange Mpn get its Objects start---*/
$("#bd_mpn" ).change(function(){
  var bd_mpn = $("#bd_mpn").val();
  $(".loader").show();
  $.ajax({
    dataType: 'json',
    type: 'POST',
    url:'<?php echo base_url(); ?>bigData/c_recog_title_mpn_kits/getMpnObjects',
    data: {'bd_mpn' : bd_mpn},
    success: function (data) {
    //console.log(data);
    $("#bd_object").val(data[0].OBJECT_NAME);
    },
    complete: function(data){
      $(".loader").hide();
    }

  });
});
  /*==============================================================
  =               FOR SAVING KIT PARTS   go_to_catalogue                        =
  ================================================================*/
$("#save_mpn_kit").on('click', function(){

    var url='<?php echo base_url() ?>bigData/c_recog_title_mpn_kits/addKitComponent';
    // var bd_alt_object = $("#bd_alt_object").val();
    var ct_category_id              = $("#ct_category_id").val();
    var catalogue_mpn_id            = $("#ct_catlogue_mt_id").val();
    var ct_cata_id                  = $("#ct_cata_id").val();

    var bd_mpn                      = $("#bd_mpn").val();
    var kit_qty                     = $("#kit_qty").val();

    //console.log(catalogue_mpn_id, bd_mpn, kit_qty, ct_category_id); return false;
    // alert(bd_mpn);return false;
    $(".loader").show();
    $.ajax({
    url:url,
    type: 'POST',
    data: {
      'catalogue_mpn_id': catalogue_mpn_id,
      'bd_mpn': bd_mpn,
      'kit_qty' : kit_qty
    },
    dataType: 'json',
    success: function (data){
      if(data == 1){
        alert("Success: Component is created!");
        window.location.reload();
      }else{
        alert("Error: Fail to create component! Try Again");
      }    
    },
    complete: function(data){
      $(".loader").hide();
    }
  });
});
/*==============================================================
  =               FOR GOING CATALOGUE PAGE                           =
  ================================================================*/

$(document).on('change','.checkboxes',function(){
  
  
   var checker = 0;
   checker = $('input.checkboxes:checked').length;
   $(".totalChecks").text(checker);

   var sum = 0;
      $("input[class *= 'component_qty']").each(function(){
          var id = this.id.match(/\d+/);
          if($('#component_check_'+id).is(":checked")){
            sum += +$(this).val();
          }
          
      });
      $(".total_qty").val(sum);
      ///////////////////////////////////
      var total_amounts = 0;
      $("input[class *= 'cata_amount']").each(function(){
          var id = this.id.match(/\d+/);
          if($('#component_check_'+id).is(":checked")){
            yourAmount = $(this).val().replace ( /[^\d.]/g, '' );
            total_amounts += +yourAmount;
          }      
      });

      $(".amounts").val('$'+total_amounts.toFixed(2));
      ////////////////////////////////////

      var sum_sold = 0;
      $("input[class *= 'cata_avg_price']").each(function(){
          var id = this.id.match(/\d+/);
          if($('#component_check_'+id).is(":checked")){
            yourString = $(this).val().replace ( /[^\d.]/g, '' );
            sum_sold += +yourString;
          }
          
      });
      $(".total_sold").val('$'+sum_sold.toFixed(2));

      var sum_est = 0;
      $("input[class *= 'cata_est_price']").each(function(){
          var id = this.id.match(/\d+/);
          if($('#component_check_'+id).is(":checked")){
            sum_est += +$(this).val();
          }
      });
      $(".total_estimate").val('$'+sum_est.toFixed(2));

      var sum_ebay = 0;
      $("input[class *= 'cata_ebay_fee']").each(function(){
          var id = this.id.match(/\d+/);
          if($('#component_check_'+id).is(":checked")){
            yourString = $(this).val().replace ( /[^\d.]/g, '' );
            sum_ebay += +yourString;
          }
          
      });
      $(".total_ebay").val('$'+sum_ebay.toFixed(2));

      var sum_paypal = 0;
      $("input[class *= 'cata_paypal_fee']").each(function(){
          var id = this.id.match(/\d+/);
          if($('#component_check_'+id).is(":checked")){
            yourString = $(this).val().replace ( /[^\d.]/g, '' );
            sum_paypal += +yourString;
          }
          
      });
      $(".total_paypal").val('$'+sum_paypal.toFixed(2));


      var sum_ship = 0;
      $("input[class *= 'cata_ship_fee']").each(function(){
          var id = this.id.match(/\d+/);
          if($('#component_check_'+id).is(":checked")){
            yourString = $(this).val().replace ( /[^\d.]/g, '' );
            sum_ship += +yourString;
          }
          
      });
      $(".total_shipping").val('$'+sum_ship.toFixed(2));

      var sum_row = 0;
      $('.totalRow').each(function(){
          var id = this.id.match(/\d+/);
          if($('#component_check_'+id).is(":checked")){
            sum_row += parseFloat($(this).text().replace ( /[^\d.]/g, '' ));
          }
            // Or this.innerHTML, this.innerText
      });
      $(".totalClass").text('$'+sum_row.toFixed(2));

});
// $('.checkboxes').on('click',function(){
   
// });
  /*==============================================================
  =               FOR SAVING KIT PARTS                           =
  ================================================================*/
$("#copy_specific_catalogue").on('click', function(){
    var fields = $("input[name='ctc_catalogue']").serializeArray(); 
      if (fields.length === 0) 
      { 
        alert('Please Select at least one Catalogue'); 
        // cancel submit
        return false;
      }  

      var to_cata_id=[];
      var cat_id              = '<?php echo $this->uri->segment(4); ?>';
      var mpn_id= '<?php echo $this->uri->segment(5); ?>';
      var from_cata_id =  '<?php echo $this->uri->segment(6); ?>';
      var url='<?php echo base_url() ?>catalogueToCash/c_purchasing/assignCataloguesToKit';

      var tableId="catalogue-detail-table";
      var tdbk = document.getElementById(tableId);
      $.each($("#"+tableId+" input[name='ctc_catalogue']:checked"), function()
      {            
        to_cata_id.push($(this).val());
      });
      //console.log(to_cata_id); return false;
      $(".loader").show();
      $.ajax({
        type: 'POST',
        url:url,
        data: {
          'cat_id': cat_id,
          'mpn_id': mpn_id,
          'from_cata_id': from_cata_id,
          'to_cata_id': to_cata_id
        },
        dataType: 'json',
        success: function (data){
         if(data== true){
          alert("Success: Catalogues are assigned!"); 
          window.location.reload(); 
           var dataTable = $('#catalogue-detail-table').DataTable({  
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
                // "bAutoWidth": false,
                "ajax":{
                  url :"<?php echo base_url().'catalogueToCash/c_purchasing/loadCatalogues/'.$cat_id.'/'.$mpn_id.'/'.$cata_id; ?>", // json datasource
                  type: "post"  // method  , by default get
                  // data: {},
                  
                  },
                  "columnDefs":[{
                      "target":[0],
                      "orderable":false
                    }
                  ]
                }); // end data tables
         }else if(data== false){
          alert('Error: Failed to assign catalogues!');
         }
       },
       complete: function(data){
      $(".loader").hide();
    }
  });
});
  /*==============================================================
  =            FOR TOGGLING ADD COMPONENT FIELDS                 =
  ================================================================*/
    /*==============================================================
  =               FOR SAVING KIT PARTS                           =
  ================================================================*/
$("#copy_all_catalogues").on('click', function(){
      var list_type             = $("#catalogue_List_type").val();
      var cata_condition        = $("#catalogue_condition").val();

      var cat_id                = '<?php echo $this->uri->segment(4); ?>';
      var mpn_id                = '<?php echo $this->uri->segment(5); ?>';
      var from_cata_id          =  '<?php echo $this->uri->segment(6); ?>';
      var url                   ='<?php echo base_url() ?>catalogueToCash/c_purchasing/assignAllCataloguesToKit';
      //console.log(to_cata_id); return false;
      $(".loader").show();
      $.ajax({
        type: 'POST',
        url:url,
        data: {
          'list_type': list_type,
          'cata_condition': cata_condition,
          'cat_id': cat_id,
          'mpn_id': mpn_id,
          'from_cata_id': from_cata_id
        },
        dataType: 'json',
        success: function (data){
         if(data== true){
           alert("Success: Catalogues are assigned!"); 
          window.location.reload(); 
           var dataTable = $('#catalogue-detail-table').DataTable({  
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
                // "bAutoWidth": false,
                "ajax":{
                  url :"<?php echo base_url().'catalogueToCash/c_purchasing/loadCatalogues/'.$cat_id.'/'.$mpn_id.'/'.$cata_id; ?>", // json datasource
                  type: "post"  // method  , by default get
                  // data: {},
                  
                  },
                  "columnDefs":[{
                      "target":[0],
                      "orderable":false
                    }
                  ]
                }); // end data tables
         }else if(data== false){
          alert('Error: Failed to assign catalogues!');
         }
       },
       complete: function(data){
      $(".loader").hide();
    }
  });
});
  /*==============================================================
  =            FOR TOGGLING ADD COMPONENT FIELDS                 =
  ================================================================*/
  $("#add_kit_component").click(function(){
  $("#component-toggle").toggle();
});

  /*==============================================================
  =            FOR TOGGLING ADD COMPONENT FIELDS                 =
  ================================================================*/
  $("#createAutoKit").click(function(){
    var ct_catlogue_mt_id = $("#ct_catlogue_mt_id").val();
    var kitmpnauto = $("#kitmpnauto").val();
    var url='<?php echo base_url() ?>catalogueToCash/c_purchasing/createAutoKit';
    $(".loader").show();
    $.ajax({
    url:url,
    type: 'POST',
    data: {'kitmpnauto': kitmpnauto, 'ct_catlogue_mt_id': ct_catlogue_mt_id},
    dataType: 'json',
    success: function (data){
      if(data == 1){
        alert("Success: Kit Created successfully.");
        window.location.reload();
      }else if(data == 0){
        alert("Error: Kit not created.");
      }    
    },
    complete: function(data){
      $(".loader").hide();
    }
  });    
    //alert(mpn);return false;
  });


});

/*==============================================================
=                ON CHANGE ESTIMATE CONDITION                  =
================================================================*/
  $('.estimate_condition').on('change',function(){
  var condition_id         = $(this).val();
  var qty_id               = $(this).attr("rd");
  var kitmpn_id            = $(this).attr("ctmt_id");
  //alert(qty_id); return false;
  $(".loader").show();
  $.ajax({
    url:'<?php echo base_url(); ?>catalogueToCash/c_purchasing/get_cond_base_price',
    type:'post',
    dataType:'json',
    data:{'condition_id':condition_id, 'kitmpn_id':kitmpn_id},
    success:function(data){
       $(".loader").hide();
      if(data.length == 1){
        $("#cata_avg_price_"+ qty_id).val('$'+parseFloat(data[0].AVG_PRICE).toFixed(2));
        $("#cata_est_price_"+ qty_id).val(parseFloat(data[0].AVG_PRICE).toFixed(2));
        ///////////////////////////////////
        var qty = $("#cata_component_qty_"+qty_id).val();
        var est_price = $("#cata_est_price_"+qty_id).val().replace(/\$/g, '').replace(/\ /g, '');
        var amount = (est_price * qty).toFixed(2); 
        //console.log(qty, est_price, amount); return false;
        //alert(est_price); return false;
        var ebay_price = (amount * (8 / 100)).toFixed(2); 
        var paypal_price = (amount  * (2.5 / 100)).toFixed(2);
        var ship_fee = $("#cata_ship_fee_"+qty_id).val().replace(/\$/g, '').replace(/\ /g, '');
        $("#cata_amount_"+qty_id).val('$ '+amount);
        //console.log(qty, est_price, ebay_price, paypal_price); return false;
        $("#cata_ebay_fee_"+qty_id).val('$ '+ebay_price);
        $("#cata_paypal_fee_"+qty_id).val('$ '+paypal_price);
        var total = parseFloat(parseFloat(est_price) + parseFloat(ebay_price) + parseFloat(paypal_price) + parseFloat(ship_fee)).toFixed(2);
        $("#cata_total_"+qty_id).html('$ '+total);
        /////////////////////////////////////
        var tableId="kit-components-table";
        var tdbk = document.getElementById(tableId);
        //console.log(tdbk); return false;
         var total= 0;
         var grand_total= 0;
         var row_count = $('#'+tableId+' tr').length;
         // console.log(row_count); return false;
          for(var i = 1; i <= row_count -1; i++)
              {
               total = $(tdbk.rows[i].cells[11]).text().replace(/\$/g, '').replace(/\ /g, ''); 
                grand_total = parseFloat(parseFloat(grand_total)+parseFloat(total)).toFixed(2);         
              }
            $("#grand_total").html('Grand Total = $ '+grand_total);
            //console.log(grand_total); grand_total
            $('#component_check_'+qty_id).is(":checked");
            // $('#cata_component_qty'+qty_id)
            var sum = 0;
            $("input[class *= 'component_qty']").each(function(){
                var id = this.id.match(/\d+/);
                if($('#component_check_'+id).is(":checked")){
                  sum += +$(this).val();
                }
                
            });
            $(".total_qty").val(sum);
            ///////////////////////////////////
            var total_amounts = 0;
            $("input[class *= 'cata_amount']").each(function(){
                var id = this.id.match(/\d+/);
                if($('#component_check_'+id).is(":checked")){
                  yourAmount = $(this).val().replace ( /[^\d.]/g, '' );
                  total_amounts += +yourAmount;
                }      
            });

            $(".amounts").val('$'+total_amounts.toFixed(2));
            ////////////////////////////////////
            var sum_sold = 0;
            $("input[class *= 'cata_avg_price']").each(function(){
                var id = this.id.match(/\d+/);
                if($('#component_check_'+id).is(":checked")){
                  yourString = $(this).val().replace ( /[^\d.]/g, '' );
                  sum_sold += +yourString;
                }
                
            });
            $(".total_sold").val('$'+sum_sold.toFixed(2));

            var sum_est = 0;
            $("input[class *= 'cata_est_price']").each(function(){

                sum_est += +$(this).val();
            });
            $(".total_estimate").val('$'+sum_est.toFixed(2));

            var sum_ebay = 0;
            $("input[class *= 'cata_ebay_fee']").each(function(){
                var id = this.id.match(/\d+/);
                if($('#component_check_'+id).is(":checked")){
                  yourString = $(this).val().replace ( /[^\d.]/g, '' );
                  sum_ebay += +yourString;
                }
                
            });
            $(".total_ebay").val('$'+sum_ebay.toFixed(2));

            var sum_paypal = 0;
            $("input[class *= 'cata_paypal_fee']").each(function(){
                var id = this.id.match(/\d+/);
                if($('#component_check_'+id).is(":checked")){
                  yourString = $(this).val().replace ( /[^\d.]/g, '' );
                  sum_paypal += +yourString;
                }
                
            });
            $(".total_paypal").val('$'+sum_paypal.toFixed(2));


            var sum_ship = 0;
            $("input[class *= 'cata_ship_fee']").each(function(){
                var id = this.id.match(/\d+/);
                if($('#component_check_'+id).is(":checked")){
                  yourString = $(this).val().replace ( /[^\d.]/g, '' );
                  sum_ship += +yourString;
                }
                
            });
            $(".total_shipping").val('$'+sum_ship.toFixed(2));

            var sum_row = 0;
            $('.totalRow').each(function(){
                var id = this.id.match(/\d+/);
                if($('#component_check_'+id).is(":checked")){
                  sum_row += parseFloat($(this).text().replace ( /[^\d.]/g, '' ));
                }
            });
            $(".totalClass").text('$'+sum_row.toFixed(2));

           var checker = 0;
           checker = $('input.checkboxes:checked').length;
           $(".totalChecks").text(checker);

            }else if(data.length == 0){
              $("#cata_avg_price_"+ qty_id).val('$0.00');
              $("#cata_est_price_"+ qty_id).val('0.00');

              ///////////////////////////////////
        var qty = $("#cata_component_qty_"+qty_id).val();
        var est_price = $("#cata_est_price_"+qty_id).val().replace(/\$/g, '').replace(/\ /g, '');
        var amount = (est_price * qty).toFixed(2); 
        //console.log(qty, est_price, amount); return false;
        //alert(est_price); return false;
        var ebay_price = (amount * (8 / 100)).toFixed(2); 
        var paypal_price = (amount  * (2.5 / 100)).toFixed(2);
        var ship_fee = $("#cata_ship_fee_"+qty_id).val().replace(/\$/g, '').replace(/\ /g, '');
        $("#cata_amount_"+qty_id).val('$ '+amount);
        //console.log(qty, est_price, ebay_price, paypal_price); return false;
        $("#cata_ebay_fee_"+qty_id).val('$ '+ebay_price);
        $("#cata_paypal_fee_"+qty_id).val('$ '+paypal_price);
        var total = parseFloat(parseFloat(est_price) + parseFloat(ebay_price) + parseFloat(paypal_price) + parseFloat(ship_fee)).toFixed(2);
        $("#cata_total_"+qty_id).html('$ '+total);
        /////////////////////////////////////
        var tableId="kit-components-table";
        var tdbk = document.getElementById(tableId);
        //console.log(tdbk); return false;
         var total= 0;
         var grand_total= 0;
         var row_count = $('#'+tableId+' tr').length;
         // console.log(row_count); return false;
          for(var i = 1; i <= row_count -1; i++)
              {
               total = $(tdbk.rows[i].cells[11]).text().replace(/\$/g, '').replace(/\ /g, ''); 
                grand_total = parseFloat(parseFloat(grand_total)+parseFloat(total)).toFixed(2);         
              }
            $("#grand_total").html('Grand Total = $ '+grand_total);
            //console.log(grand_total); grand_total
            $('#component_check_'+qty_id).is(":checked");
            // $('#cata_component_qty'+qty_id)
            var sum = 0;
            $("input[class *= 'component_qty']").each(function(){
                var id = this.id.match(/\d+/);
                if($('#component_check_'+id).is(":checked")){
                  sum += +$(this).val();
                }
                
            });
            $(".total_qty").val(sum);
            ///////////////////////////////////
            var total_amounts = 0;
            $("input[class *= 'cata_amount']").each(function(){
                var id = this.id.match(/\d+/);
                if($('#component_check_'+id).is(":checked")){
                  yourAmount = $(this).val().replace ( /[^\d.]/g, '' );
                  total_amounts += +yourAmount;
                }      
            });

            $(".amounts").val('$'+total_amounts.toFixed(2));
            ////////////////////////////////////
            var sum_sold = 0;
            $("input[class *= 'cata_avg_price']").each(function(){
                var id = this.id.match(/\d+/);
                if($('#component_check_'+id).is(":checked")){
                  yourString = $(this).val().replace ( /[^\d.]/g, '' );
                  sum_sold += +yourString;
                }
                
            });
            $(".total_sold").val('$'+sum_sold.toFixed(2));

            var sum_est = 0;
            $("input[class *= 'cata_est_price']").each(function(){

                sum_est += +$(this).val();
            });
            $(".total_estimate").val('$'+sum_est.toFixed(2));

            var sum_ebay = 0;
            $("input[class *= 'cata_ebay_fee']").each(function(){
                var id = this.id.match(/\d+/);
                if($('#component_check_'+id).is(":checked")){
                  yourString = $(this).val().replace ( /[^\d.]/g, '' );
                  sum_ebay += +yourString;
                }
                
            });
            $(".total_ebay").val('$'+sum_ebay.toFixed(2));

            var sum_paypal = 0;
            $("input[class *= 'cata_paypal_fee']").each(function(){
                var id = this.id.match(/\d+/);
                if($('#component_check_'+id).is(":checked")){
                  yourString = $(this).val().replace ( /[^\d.]/g, '' );
                  sum_paypal += +yourString;
                }
                
            });
            $(".total_paypal").val('$'+sum_paypal.toFixed(2));


            var sum_ship = 0;
            $("input[class *= 'cata_ship_fee']").each(function(){
                var id = this.id.match(/\d+/);
                if($('#component_check_'+id).is(":checked")){
                  yourString = $(this).val().replace ( /[^\d.]/g, '' );
                  sum_ship += +yourString;
                }
                
            });
            $(".total_shipping").val('$'+sum_ship.toFixed(2));

            var sum_row = 0;
            $('.totalRow').each(function(){
                var id = this.id.match(/\d+/);
                if($('#component_check_'+id).is(":checked")){
                  sum_row += parseFloat($(this).text().replace ( /[^\d.]/g, '' ));
                }
            });
            $(".totalClass").text('$'+sum_row.toFixed(2));

           var checker = 0;
           checker = $('input.checkboxes:checked').length;
           $(".totalChecks").text(checker);

            }
        
        
      
    },
     complete: function(data){
      $(".loader").hide();
    }
  });
});

/*==============================================================
  =                ON CHANGE ESTIMATE CONDITION               =
================================================================*/
</script>