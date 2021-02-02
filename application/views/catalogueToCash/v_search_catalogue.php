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
                    <input class="form-control" type="text" value="<?php echo $data['detail'][0]['EBAY_ID']; ?>" readonly> 
                </div>
              </div>
              <div class="col-sm-4">
                  <div class="form-group" style="font-size: 15px;">
                    <label for="ebay id">ITEM DESCRIPTION:</label>
                    <input class="form-control" type="text" value="<?php echo htmlentities($data['detail'][0]['TITLE']); ?>" readonly> 
                </div>
              </div>
              <div class="col-sm-4">
                  <div class="form-group" style="font-size: 15px;">
                    <label for="ebay id">MPN:</label>
                    <input class="form-control" type="text" value="<?php echo $data['detail'][0]['MPN']; ?>" readonly> 
                </div>
              </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <div class="form-group" style="font-size: 15px;">
                    <label for="ebay id">CONDITION:</label>
                    <input class="form-control" type="text" value="<?php echo $data['detail'][0]['CONDITION_NAME']; ?>" readonly> 
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
                  <th>SELECT COMPONENTS</th>
                  <th>QTY</th>
                  <th style="color: green;">SOLD PRICE</th>
                  <th>ESTIMATED PRICE</th>
                  <th>EBAY FEE</th>
                  <th>PAYPAL FEE</th>
                  <th>SHIP FEE</th>
                  <th>TOTAL</th>
                </thead>
                <tbody id="reloa_id">
                  <?php
                  $total_avg_prices = 0;
                  $totals = 0;
                  $i=1;
                  if($data['results']->num_rows() > 0){
                    foreach ($data['results']->result_array() as $result) {
                  ?>
                    <tr>
                      <td>
                        <a title="Delete Component" href="<?php echo base_url().'catalogueToCash/c_purchasing/cp_delete_component/'.$cat_id.'/'.$mpn_id.'/'.$cata_id.'/'.$result['MPN_KIT_MT_ID']; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                      </td>
                       <td><?php echo $result['OBJECT_NAME']; ?>
                        <input type="hidden" name="ct_kit_mpn_id" id="ct_kit_mpn_id_<?php echo $i; ?>" value="<?php echo $result['MPN_KIT_MT_ID']; ?>">
                      </td>
                      <td>
                        <input type="checkbox" name="cata_component" id="1" value="1">
                      </td>
                      <td>
                        <?php $quantity = $result['QTY']; ?>
                        <input type="hidden" name="part_catalogue_mt_id" value="<?php echo $result['PART_CATLG_MT_ID']; ?>">
                        <div class="form-group">
                          <input type="text" name="cata_component_qty_1" id="cata_component_qty_1" class="form-control input-sm component_qty" value="<?php echo $quantity; ?>" style="width:100px;">
                        </div>
                      </td>
                      <td>
                        <?php 
                        $avg_price = $result['AVG_PRICE'];
                        $total_avg_prices += $avg_price;
                         ?>
                        <div class="form-group">
                          <input type="text" name="cata_avg_price_1" id="cata_avg_price_1" class="form-control input-sm cata_avg_price" value="<?php echo '$ '.number_format((float)@$avg_price,2,'.',','); ?>" style="width:100px;" readonly>
                        </div>
                      </td> 
                    <td>
                      <?php $est_price_name="cata_est_price_".$i; 
                      ?>
                      <div class="form-group">
                        <input type="text" name="<?php echo $est_price_name; ?>" id="<?php echo $i; ?>" class="form-control input-sm cata_est_price" value="<?php if(isset($_POST['$est_price_name'])){ echo $estimate_price= $_POST['$est_price_name']; }else { echo $estimate_price='$ '.number_format((float)@$avg_price,2,'.',','); } ?>" style="width:100px;">
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
                      <div class="form-group">
                       <input type="text" name="cata_ebay_fee_1" id="cata_ebay_fee_<?php echo $i; ?>" class="form-control input-sm cata_ebay_fee" value="<?php echo '$ '.number_format((float)@$ebay_fee,2,'.',','); ?>" style="width:100px;" readonly>
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
                      <div class="form-group">
                        <input type="text" name="cata_paypal_fee_1" id="cata_paypal_fee_<?php echo $i; ?>" class="form-control input-sm cata_paypal_fee" value="<?php echo '$ '.number_format((float)@$paypal_fee,2,'.',','); ?>" style="width:100px;" readonly>
                      </div>
                    </td>
                    <td>
                      <div class="form-group">
                        <input type="text" name="cata_ship_fee_1" id="cata_ship_fee_<?php echo $i; ?>" class="form-control input-sm cata_ship_fee" value="$ 3.25" style="width:100px;" readonly>
                      </div>
                    </td>
                    <td>
                    <?php 
                      $cahrges = $ebay_fee + $paypal_fee + 3.25;
                      $total = $avg_price + $cahrges;
                      $totals += $total;
                      ?>
                      <p id="cata_total_<?php echo $i; ?>"><?php echo "$ ".$total; ?></p>
                    </td>
                    <?php
                      $i++;
                      echo "</tr>"; 
                  } ///end foreach 
                  ?>
                  </tbody> 
                  </table>
                  <?php
                  }else { ////end main if
                  ?>
                </tbody> 
              </table>              
              <?php
              } ?>
            <!-- nav-tabs-custom -->
            </div>
            <!-- /.col-sm-12--> 
            <div class="col-sm-12">
              <input type="hidden" name="countrows" value="<?php //echo $i-1; ?>" id="countrows">
              <div class="form-group col-sm-2 pull-left">
                <button type="button" title="Add Component"  class="btn btn-primary" id="add_kit_component">Add Component</button>
              </div>
              <!-- <div class="form-group col-sm-1 pull-left">
                <button type="button" title="Copy Catalogues"  class="btn btn-primary" id="copy_catalogues">Copy</button>
              </div> -->
              <div class="col-sm-3">
              <div class="form-group" style="font-size: 18px;">
                <b class="col-sm-offset-4 pull-left">Sold Price = 
                <?php
                  echo '$ '.number_format((float)@$total_avg_prices,2,'.',',');
               ?>
               </b>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group" style="font-size: 18px;">
                <b class="col-sm-offset-2 pull-left" id="grand_total">Grand Total = 
                <?php
                  echo '$ '.number_format((float)@$totals,2,'.',',');
               ?>
               </b>
              </div>
            </div>
              <div class="form-group col-sm-3  pull-left">
                <button type="button" title="Save Components"  class="btn btn-primary col-sm-offset-1" id="save_components">Save</button>
              </div>  
            </div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
         <!-- second block start -->   
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Catalogue Detail</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
            </div>          
            <div class="box-body">
              <div class='col-sm-12' id="component-toggle" style="display: none;">
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
                <div class="form-group" id="bdMPN">   
                </div>
              </div>
              <div class='col-sm-3'>
                <div class='form-group'>
                  <label>Quantity:</label>
                  <input class='form-control' type='text' name='kit_qty' id='kit_qty' value='1' placeholder='Enter Quantity'/>
                </div>
              </div>                                                
              <div class="col-sm-3">
                <div class="form-group p-t-24">
                  <input type="button" class="btn btn-success btn-sm" name="save_mpn_kit" id="save_mpn_kit" value="Save">
                </div>
              </div>
              <!-- MPN Block end -->
            </div>   
            <!-- /.col-sm-12-->   
               <div class="col-sm-12">
                <div class="col-sm-6">
                  <h4>MPN : <?php 
                  $catalogue_List = $data['catalogue_List_type'];
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
                              /* $this->session->unset_userdata('ctListing_condition');*/
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
              <table id="catalogue-search-table" class="table table-responsive table-striped table-bordered table-hover">
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
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>        
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
                  <th>KIT</th>
                  <th>EBAY</th>
                  <th>PAYPAL</th>
                  <th>SHIP</th>
                  <th>TOTAL</th>
                  <th>AMOUNT</th>
                  <th>STATUS</th>
                  <th>BID STATUS</th>
                  <th>BID/OFFER</th>
                  <th>KIT VIEW</th>
                  <th style="width:200px;">TRACKING</th>
                  <th>COST PRICE</th>
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
     $('#kit-components-table').DataTable({
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
  /*==================================================
  =            FOR SHOWING CATALOGUE DETAIL          =
  ===================================================*/
 // $("#copy_catalogues").on('click', function(event) {
   // event.preventDefault();

      var dataTable = $('#catalogue-search-table').DataTable( {  
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
        url :"<?php echo base_url().'catalogueToCash/c_purchasing/searchCatalogue/'.$cat_id.'/'.$mpn_id.'/'.$catalogue_List.'/'.$catalogue_condition; ?>", // json datasource
        type: "post"  // method  , by default get
        // data: {},
        
        },
        "columnDefs":[{
            "target":[0],
            "orderable":false
          }
        ]

      });
 // });
 
  /*==================================================
  =            FOR ADDING KIT COMPONENTS             =
  ===================================================*/
  $("#save_components").click(function(){
    //this.disabled = true;
  var fields = $("input[name='cata_component']").serializeArray(); 
    if (fields.length === 0) 
    { 
        alert('Please Select at least one Component'); 
        // cancel submit
        return false;
    }  

  var arr=[];
  var cat_id= '<?php echo $this->uri->segment(4); ?>';
  var catalogue_mt_id= $("#ct_kit_mpn_id").val();
  var dynamic_cata_id= '<?php echo $this->uri->segment(6); ?>';
  var url='<?php echo base_url() ?>catalogueToCash/c_purchasing/savekitComponents/'+cat_id+'/'+catalogue_mt_id+'/'+dynamic_cata_id;
  //var count=$("#countJs").val();
  //alert(count); return false;
  //alert(dynamic_cata_id); return false;
  var compName=[];
  var compQty=[];
  var compAvgPrice=[];
  var compEstPrice=[];
  var ebayFee=[];
  var payPalFee=[];
  var shipFee=[];
  //var category_id=[];
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
            compName.push($("#ct_kit_mpn_id_"+(i+1)).val());

             $(tdbk.rows[arr[i]]).find(".component_qty").each(function() {
                    compQty.push($(this).val());
                  }); 

              $(tdbk.rows[arr[i]]).find('.cata_avg_price').each(function() {
                compAvgPrice.push($(this).val());
              }); 

              $(tdbk.rows[arr[i]]).find('.cata_est_price').each(function() {
                compEstPrice.push($(this).val());
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
          //console.log(arr); return false;
          arr=[];

//console.log(compName, compQty, compAvgPrice, compEstPrice, ebayFee, payPalFee, shipFee); return false;
  $.ajax({

    type: 'POST',
    url:url,
    data: {
      'dynamic_cata_id': dynamic_cata_id,
      'compName': compName,
      'compQty': compQty,
      'compAvgPrice': compAvgPrice,
      'compEstPrice': compEstPrice,
      'ebayFee': ebayFee,
      'payPalFee': payPalFee,
      'shipFee': shipFee
    },
    dataType: 'json',
    success: function (data){
         if(data != ''){
           //window.location.href = '<?php //echo base_url(); ?>BundleKit/c_bkProfiles';
               alert("data is inserted");    
         }else{
           alert('Error: Fail to insert data');
         }
       },
      error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
    }
  });
  
  });
  /*=========================================================
  =         CHARGES CALCULATION FROM ESTIMATE PRICE         =
  ===========================================================*/ 
  $(".cata_est_price").on('blur', function(){

    var est_id=$(this).attr('id');
    var est_price=$(this).val().replace(/\$/g, '').replace(/\ /g, '');
    //alert(est_price); return false;
    var ebay_price = (est_price * (8 / 100)).toFixed(2); 
    var paypal_price = (est_price  * (2.5 / 100)).toFixed(2);
    var ship_fee = $("#cata_ship_fee_"+est_id).val().replace(/\$/g, '').replace(/\ /g, '');
    //console.log(ebay_price, paypal_price); return false;
    $("#cata_ebay_fee_"+est_id).val('$ '+ebay_price);
    $("#cata_paypal_fee_"+est_id).val('$ '+paypal_price);
    var total = parseFloat(parseFloat(est_price) + parseFloat(ebay_price) + parseFloat(paypal_price) + parseFloat(ship_fee)).toFixed(2);
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
           total = $(tdbk.rows[i].cells[9]).text().replace(/\$/g, '').replace(/\ /g, ''); 
            grand_total = parseFloat(parseFloat(grand_total)+parseFloat(total)).toFixed(2);         
          }
          $("#grand_total").html('Grand Total = $ '+grand_total);
    //console.log(grand_total); grand_total
  });
  /*==============================================================
  =                 GET RELATED MPNS ON CHANGE OBJECTS           =
  ================================================================*/
  $('#bd_object').on('change',function(){

  var object_id = $('#bd_object').val();
  // alert(object_id);
  $.ajax({
    url:'<?php echo base_url(); ?>bigdata/c_recog_title_mpn_kits/loadBdMpn',
    type:'post',
    dataType:'json',
    data:{'object_id':object_id},
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
      error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
    }
  });
});
  /*==============================================================
  =   END FUNCTION FOR CHARGES CALCULATION FROM ESTIMATE PRICE   =
  ================================================================*/
/*--- Onchange Mpn get its Objects start---*/
$("#bd_mpn" ).change(function(){
  var bd_mpn = $("#bd_mpn").val();
  $.ajax({
    dataType: 'json',
    type: 'POST',
    url:'<?php echo base_url(); ?>bigData/c_recog_title_mpn_kits/getMpnObjects',
    data: {'bd_mpn' : bd_mpn},
    success: function (data) {
    //console.log(data);
    $("#bd_object").val(data[0].OBJECT_NAME);
    },
      error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
    }

  });
});
  /*==============================================================
  =               FOR SAVING KIT PARTS                           =
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
        alert("data is inserted");
        window.location.reload();
      }else{
        alert("data is not inserted! Try Again");
      }    
    },
      error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
    }
  });
});

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

      var tableId="catalogue-search-table";
      var tdbk = document.getElementById(tableId);
      //console.log(tdbk); return false;
      $.each($("#"+tableId+" input[name='ctc_catalogue']:checked"), function()
      {            
        to_cata_id.push($(this).val());
      });
      //console.log(to_cata_id); return false;
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
          alert("data is inserted"); 
           window.location.reload();  
         }else if(data== false){
          alert('Error: Fail to insert data');
         }
       },
      error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
    }
  });
});
  /*==============================================================
  =            FOR TOGGLING ADD COMPONENT FIELDS                 =
  ================================================================*/
$("#add_kit_component").click(function(){
  $("#component-toggle").toggle();
});

});
</script>