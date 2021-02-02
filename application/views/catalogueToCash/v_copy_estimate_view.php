<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue

       /*=============================================
        =  Section lz_bigData db connection block  =
        =============================================*/
        $CI = &get_instance();
        //setting the second parameter to TRUE (Boolean) the function will return the database object.
        $this->db2 = $CI->load->database('bigData', TRUE);
        // $qry = $this->db2->query("SELECT * FROM lz_bd_category");
        // print_r($qry->result());exit;

        /*=====  End of Section lz_bigData db connection block  ======*/  
?>
<style>
 .m-3{
    margin: 3px;
  } 
  .show-flag{
    border: 2px solid red;
    padding: 1px;
  }
 
</style> 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Purchasing
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Purchasing</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content">  
    <div class="box"><br>  
          <div class="box-body form-scroll">  
            <?php
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
          </div>
        </div>
      </div>
      <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Copy Estimate</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
          </div>          
            <div class="box-body form-scroll"> 
            <div class="col-sm-12">
              <!-- Custom Tabs -->
              <table id="kit-components-table" class="table table-responsive table-striped table-bordered table-hover">
                <thead>
                  <th>COMPONENTS</th>
                  <th>MPN</th>
                  <th>MPN DESCRIPTION</th>
                  <th>CONDITIONS</th>
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
                 <?php
                  $total_avg_prices = 0;
                  $totals = 0;
                  $i=1;
                  // echo "<pre>";
                  // print_r($data['components']->result_array());
                  // echo "</pre>";
                  // exit;
                  if($data['components']->num_rows() > 0)
                  {
                    foreach ($data['components']->result_array() as $result) {
                      $part_catlg_mt_id = $result['PART_CATLG_MT_ID'];
                       $condition_id  = $result['TECH_COND_ID'];
                  ?>
                    <tr>
                      <td>
                        <?php echo @$result['OBJECT_NAME']; ?>
                        <input type="hidden" name="ct_kit_mpn_id_<?php echo $i; ?>" class="kit_componets" id="ct_kit_mpn_id_<?php echo $i; ?>" value="<?php echo @$result['MPN_KIT_MT_ID']; ?>">
                      </td>
                      <td>
                        <?php echo @$result['MPN']; ?>
                      </td>
                      <td>
                        <div style="width: 250px;"><?php echo @$result['MPN_DESCRIPTION']; ?></div>
                      </td>
                      <td>
                        <input type="hidden" class="part_catlg_mt_id" name="part_catlg_mt_id" id="part_catlg_mt_id" value="<?php echo @$result['PART_CATLG_MT_ID']; ?>">
                            <div class="form-group" style="width: 200px;">
                                <select class="form-control selectpicker estimate_condition" name="estimate_condition" id="estimate_condition_<?php echo $i;?>" ctmt_id="<?php echo @$result['PART_CATLG_MT_ID']; ?>" rd = "<?php echo $i; ?>" data-live-search="true" style="width: 150px;" disabled>
                                  <?php                                 
                                    foreach(@$data['conditions'] as $type) { 
                                    if ($condition_id == $type['ID']){
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
                        <?php 
                        $quantity = @$result['QTY']; ?>
                        
                        <div class="form-group" style="width:70px;">
                          <input type="hidden" name="part_catalogue_mt_id" value="<?php echo @$result['PART_CATLG_MT_ID']; ?>">
                          <input type="text" name="cata_component_qty_<?php echo $i; ?>" id="cata_component_qty_<?php echo $i; ?>" rowid="<?php echo $i; ?>" class="form-control input-sm component_qty" value="<?php if(!empty($quantity)) {echo $quantity; }else{ echo 1;}?>" style="width:60px;" readonly>
                        </div>
                      </td>
                      <td>
                      
                       <?php 
                  // $mpn_id =$part_catlg_mt_id;
                  // $con = $cond_id;
                  // if(!empty$mpn_id )
                      
                      $avg_query = $this->db2->query("SELECT T.AVG_PRICE MPN_AVG FROM MPN_AVG_PRICE T WHERE T.CONDITION_ID=$cond_id AND T.CATALOGUE_MT_ID =$part_catlg_mt_id  ");

// $barcode_no = $single_barcodeNo->result_array();
//                             $bar_code = $barcode_no[0]['BCD'];


                           if($avg_query->num_rows() > 0){
                            $mpn_avg_price = $avg_query->result_array();
                            $mpn_avg_price = $mpn_avg_price[0]['MPN_AVG'];}
                            else{

                              $mpn_avg_price = '0';
                              } ?>
                        <?php 
                        $avg_price = @$result['AVG_PRIC']; 
                        $total_avg_prices += $avg_price;
                         ?>
                        <div class="form-group">
                          <input type="text" name="cata_avg_price_<?php echo $i; ?>" id="cata_avg_price_<?php echo $i; ?>" class="form-control input-sm cata_avg_price" value="<?php echo '$ '.number_format((float)@$mpn_avg_price,2,'.',','); ?>" style="width:80px;" readonly>
                        </div>
                      </td> 
                    <td>
                      <?php $est_price_name="cata_est_price_".$i; 
                      ?>
                      <div class="form-group" style="width:80px;">
                        <input type="text" name="<?php echo $est_price_name; ?>" id="cata_est_price_<?php echo $i; ?>" class="form-control input-sm cata_est_price" value="<?php echo '$'.$estimate_price= number_format((float)@$result['EST_SELL_PRICE'],2,'.',','); ?>" style="width:80px;" readonly>
                      </div>
                    </td>
                    <td>
                      <?php $amount_est = ($result['EST_SELL_PRICE'] * $result['QTY']);  ?>
                       <div class="form-group" style="width:80px;">
                       <input type="text" name="cata_amount_<?php echo $i; ?>" id="cata_amount_<?php echo $i; ?>" class="form-control input-sm cata_amount" value="<?php echo '$ '.number_format((float)@$amount_est,2,'.',','); ?>" style="width:80px;" readonly>
                      </div>
                    </td>
                    <td>
                      <div class="form-group" style="width:80px;">
                       <input type="text" name="cata_ebay_fee_<?php echo $i; ?>" id="cata_ebay_fee_<?php echo $i; ?>" class="form-control input-sm cata_ebay_fee" value="<?php echo '$ '.number_format((float)@$result['EBAY_FEE'],2,'.',','); ?>" style="width:80px;" readonly>
                      </div>
                    </td>
                    <td>
                     
                      <div class="form-group" style="width:80px;">
                        <input type="text" name="cata_paypal_fee_<?php echo $i; ?>" id="cata_paypal_fee_<?php echo $i; ?>" class="form-control input-sm cata_paypal_fee" value="<?php echo '$ '.number_format((float)@$result['PAYPAL_FEE'],2,'.',','); ?>" style="width:80px;" readonly>
                      </div>
                    </td>
                    <td>
                      <div class="form-group">
                        <input type="text" name="cata_ship_fee_1" id="cata_ship_fee_<?php echo $i; ?>" class="form-control input-sm cata_ship_fee" value="$ 3.25" style="width:80px;" readonly>
                      </div>
                    </td>
                    <td class="rowDataSd">
                    <?php 
                      $cahrges  = ($result['EBAY_FEE'] + $result['PAYPAL_FEE'] + 3.25);
                      $total    = $amount_est + $cahrges;
                      $totals += $total;
                      ?>
                      <p id="cata_total_<?php echo $i; ?>" class="totalRow" style="width:80px;"><?php  echo '$ '.number_format((float)@$total,2,'.',','); ?></p>
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
          </div>
        </div>
          <!-- second block  Catalogue Detail end -->  
          <!-- /.box -->
         <!-- second block  Catalogue Detail start -->   
           
          <!-- second block  Catalogue Detail end -->  
          <!-- Copy Estimate start --> 
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
                 
               <form action="<?php echo base_url().'catalogueToCash/c_purchasing_copy/getCatalogueSearch/'.$cat_id.'/'.$mpn_id.'/'.$cata_id; ?>" method="post" accept-charset="utf-8">
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
            <div class="col-sm-12">
            <div class="form-group col-sm-2 pull-left">
            <button type="button" title="Copy Specific"  class="btn btn-primary copy_specific_catalogue" id="copy_specific_catalogue">Copy Specific</button>
          </div>
          <div class="form-group col-sm-2 pull-left">
            <button type="button" title="Copy All"  class="btn btn-primary copy_all_catalogues" id="copy_all_catalogues">Copy All</button>
          </div>
          </div>
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
            <button type="button" title="Copy Specific"  class="btn btn-primary copy_specific_catalogue" id="copy_specific_catalogue">Copy Specific</button>
          </div>
          <div class="form-group col-sm-2 pull-left">
            <button type="button" title="Copy All"  class="btn btn-primary copy_all_catalogues" id="copy_all_catalogues">Copy All</button>
          </div>
          </div>
          </div> 
        </div>

        <!-- /.col -->
      </section>
      <!-- /.row -->
    <!-- /.content -->
  </div>    
<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>
<script>
$(document).ready(function()
  {
    /*var table = $('#kit-components-table').DataTable({
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
    });*/
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
  /*==================================================
  =            FOR ADDING KIT COMPONENTS             =
  ===================================================*/


  /*==============================================================
  =               FOR SAVING KIT PARTS                           =
  ================================================================*/
$(".copy_specific_catalogue").on('click', function(){
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
      var url='<?php echo base_url() ?>catalogueToCash/c_purchasing_copy/assignCataloguesToKit';

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
                  url :"<?php echo base_url().'catalogueToCash/c_purchasing_copy/loadCatalogues/'.$cat_id.'/'.$mpn_id.'/'.$cata_id; ?>", // json datasource
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
  =               FOR GOING CATALOGUE PAGE                           =
  ================================================================*/

    /*==============================================================
  =               FOR SAVING KIT PARTS                           =
  ================================================================*/
$(".copy_all_catalogues").on('click', function(){
      var list_type             = $("#catalogue_List_type").val();
      var cata_condition        = $("#catalogue_condition").val();

      var cat_id                = '<?php echo $this->uri->segment(4); ?>';
      var mpn_id                = '<?php echo $this->uri->segment(5); ?>';
      var from_cata_id          =  '<?php echo $this->uri->segment(6); ?>';
      var url                   ='<?php echo base_url() ?>catalogueToCash/c_purchasing_copy/assignAllCataloguesToKit';
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
                  url :"<?php echo base_url().'catalogueToCash/c_purchasing_copy/loadCatalogues/'.$cat_id.'/'.$mpn_id.'/'.$cata_id; ?>", // json datasource
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

  /*==============================================================
  =            FOR TOGGLING ADD COMPONENT FIELDS                 =
  ================================================================*/
  $("#createAutoKit").click(function(){
    var ct_catlogue_mt_id = $("#ct_catlogue_mt_id").val();
    var kitmpnauto = $("#kitmpnauto").val();
    var url='<?php echo base_url() ?>catalogueToCash/c_purchasing_copy/createAutoKit';
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
    },
      error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
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
    url:'<?php echo base_url(); ?>catalogueToCash/c_purchasing_copy/get_cond_base_price',
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
  =                ON CHANGE ESTIMATE CONDITION               =
================================================================*/
</script>

 