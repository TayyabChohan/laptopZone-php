<?php $this->load->view("template/header.php"); ?>

<form action="<?php echo base_url(); ?>pos/c_point_of_sale/pos_addRecord" method="post" name="add_posForm" id="add_posForm" onsubmit="setTimeout(function(){ location.reload(); }, 1000);" accept-charset="utf-8" target="_blank">
   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Point Of Sale
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">POS Form</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-sm-12">
        <?php if($this->session->flashdata('success')){ ?>
          <div id="successMessage" class="alert alert-success alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php }elseif($this->session->flashdata('error')){  ?>

        <div id="errorMessage" class="alert alert-danger alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
        </div>

    <?php } ?> 
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Buyer Info</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div> 
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
               <?php if(@$data == "inserted"){
                var_dump($data);
                  echo '<div class="col-sm-12"><div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Record inserted successfully. </div></div>'; 
                  } ?>
                <div class="col-sm-12">
                  <div class="col-sm-2">
                  <div class="form-group">
                   <label for="Doc No" class="control-label">DOC No:</label>
                     <input type="number" class="form-control" id="doc_no" name="doc_no" value="<?php 
                     //var_dump($doc_no[0]['DOC_NO']);exit;
                     echo $doc_no[0]['DOC_NO'];?>" readonly>
                  </div>
                  </div>

                <div class="col-sm-2 ">
                  <div class="form-group">
                   <label for="Date" class="control-label">Date:</label>
                     <input type="text" class="form-control" id="date" name="doc_date" value="<?php echo date('m/d/Y');?>" data-date-format="mm/dd/yyyy" readonly>
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                   <label for="Phone" class="control-label">Phone :</label>
                     <input type="text" class="form-control" id="phone_no" name="phone_no" value="" >
                  </div>
                </div>

                <div class="col-sm-3">
                  <div class="form-group">
                   <label for="Email" class="control-label">Email :</label>
                     <input type="text" class="form-control" id="buyer_email" name="buyer_email" value="" >
                  </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                      <label for="Buyer Name" class="control-label">Buyer Name:</label>
                        <input type="text" class="form-control" id="buyer_name" name="buyer_name" value="" >
                    </div>
                  </div>

                </div>

                <div class="col-sm-12">
                  
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="Address" class="control-label">Address:</label>
                        <input type="text" class="form-control" id="address" name="buyer_address" value="" >
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="City" class="control-label">City:</label>
                        <!-- <input type="text" class="form-control" id="buyer_city" name="buyer_city" value="" > -->
                        <select class="form-control" name="buyer_city" id="buyer_city">
                        <?php  foreach(@$data['city_query'] as $city_name):?>
                          <option value="<?php echo $city_name['CITY_ID'];?>"><?php echo strtoupper($city_name['CITY_DESC']);?></option>
                        <?php endforeach; ?>
                        </select>                        
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="State" class="control-label">State:</label>
                        <!-- <input type="text" class="form-control" id="buyer_state" name="buyer_state" value="" > -->
                        <select class="form-control" name="buyer_state" id="buyer_state">
                        <?php  foreach(@$data['state_query']  as $state_name):?>
                          <option value="<?php echo $state_name['STATE_ID'];?>"><?php echo $state_name['STATE_DESC'];?></option>
                        <?php endforeach; ?>
                        </select>                         
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="Zip" class="control-label">Zip:</label>
                        <input type="text" class="form-control" id="buyer_zip" name="buyer_zip" value="" >
                    </div>
                  </div>
                </div>

                <div class="col-sm-12">
                  
                      <div class="box-header">
                        <h3 class="box-title">Market </h3>
                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class=""></i>
                          </button>
                        </div> 
                      </div>
                      <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12">
                              <div class="col-sm-3">
                                <div class="form-group">
                                  <label for="Market" class="control-label">Ad Market:</label>
                                    <input type="text" class="form-control" id="ad_market" name="ad_market" value="Craiglist" readonly>
                                </div>
                                
                              </div>
                              <div class="col-sm-3">
                                <div class="form-group">
                                  <label for="Ad ID" class="control-label">Ad ID:</label>
                                    <input type="text" class="form-control" id="ad_id" name="ad_id" value="" >
                                </div>
                                
                              </div>
                            </div>
                          </div>
                      </div>
                  
                </div>

              </div>
            </div>

            </div>
          </div>
        </div>
        <div class="row">
        
        </div>
        <div class="row">
        <div class="col-sm-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Item</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div> 
          </div>
          <div class="box-body">
            <div class="row">
              
              <div class="col-sm-12 form-group">

                  <div class="box-body">
              <div class="row">
                <div class="box-header">
              
                  <h3 class="box-title">Item Detail</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class=""></i>
                    </button>
                  </div> 
                </div>
                <div class="col-sm-12">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="Purchase Ref" class="control-label">Purchase Ref:</label>
                      <input type="text" id="pos_purchase_ref" name="pos_purchase_ref" class="form-control" readonly>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="POS_UPC" class="control-label">UPC:</label>
                      <input type="number" id="pos_upc" name="pos_upc" class="form-control" readonly>
                    </div>
                  </div>

                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="POS_MPN" class="control-label">MPN:</label>
                      <input type="text" id="pos_mpn" name="pos_mpn" class="form-control" readonly>
                    </div>
                  </div>
                  
                </div>

                <div class="col-sm-12">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="Manufacture" class="control-label">Manufacture:</label>
                      <input type="text" id="pos_manufacture" name="pos_manufacture" class="form-control" readonly>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="Condition" class="control-label">Condition:</label>
                      <input type="text" id="pos_condition" name="pos_condition" class="form-control" readonly>
                    </div>
                  </div>                  
                  
                </div>
              </div>
              
            </div>
                  <!-- <form name="add_name" id="add_name"> -->
                    <div class="col-sm-12">
                      <div class="col-sm-11">
                        <input type="hidden" name="">
                      </div>
                      
                    
                      
                    </div>
                      <table class="table table-bordered " id="dynamic_field">
                          <thead>
                            <tr>
                              <th> 
                                  <label for="Sr." class="control-label">Sr No:</label>
                                  <!-- <input type="text" class="form-control" id="sr_no" name="sr_no[]" value="" > -->
                              </td>
                              <th>
                                <label for="LineType" class="control-label">Line Type:</label>
                              </th>
                              <th>
                                <label for="Bar Code" class="control-label">Bar Code:</label>
                                <!-- <input type="text" class="form-control" id="bar_code" name="bar_code[]" value="" > -->
                              </th>
                              <th>
                                 <label for="Quantity" class="control-label">Description:</label>
                                <!-- <input type="number" class="form-control" id="quantity" name="quantity[]" value="" > -->
                              </th>
                              <th>
                                <label for="Price" class="control-label">Quantity:</label>
                                <!-- <input type="text" class="form-control" id="price" name="price[]" value="" > -->
                              </th>
                              <th>
                                <label for="Description" class="control-label">Price $:</label>
                                <!-- <input type="text" class="form-control" id="desc_item" name="desc_item[]" value="" > -->
                              </th>
                              <th>
                                <label for="Description" class="control-label">Disc %:</label>
                                <!-- <input type="text" class="form-control" id="desc_item" name="desc_item[]" value="" > -->
                              </th>
                               <th>
                                <label for="Description" class="control-label">Disc Amt $:</label>
                                <!-- <input type="text" class="form-control" id="desc_item" name="desc_item[]" value="" > -->
                              </th>
                              <th>
                                <label for="Description" class="control-label">Net Price $:</label>
                                <!-- <input type="text" class="form-control" id="desc_item" name="desc_item[]" value="" > -->
                              </th>
                            </tr>
                          </thead> 
                      </table>
                      <div class="col-sm-1">
                        <div class="form-group">
                          <button  type="button" class="btn btn-primary" id="add" name="add">+Add Row</button>
                          <!-- <button type="submit" class="btn btn-primary" id="submit">Submit</button> -->
                        </div>
                      </div>
                  <!-- </form> -->
              </div>
              <div class="col-sm-12">
                  <div class="form-group ">
                        <table class="table" id="newField">

                      </table>
                  </div>
              </div>
              
            </div>
            
          </div>
          </div>
          
          </div>
          </div>
          <div class="row">
          <div class="col-sm-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Payment</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div> 
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-sm-12">
                  <div class="col-sm-2">
                    <div class="form-group p-b">
                        <div class="col-sm-9">
                          <button type="button" id="option1" class="form-control btn btn-primary btn-sm" required>Cash</button>
                        </div>
                        <input type="hidden" class="form-control btn btn-primary btn-sm" id="opt1" name="opt1" value="C" required>
                    </div>
                  
                  </div>
                  <div class="col-sm-2 p-b">
                    <div class="form-group">
                        <div class="col-sm-9">
                          <button type="button" id="option2" class="form-control btn btn-primary btn-sm" >Credit Card</button>
                        </div>
                        <input type="hidden" class="form-control btn btn-primary btn-sm" id="opt2" name="opt2" value="" >
                            
                    </div>
                  
                  </div>
                </div> 
                <div class="col-sm-12">
                  <div class="col-sm-2">
                    
                    <div class="form-group">
                            <label for="Sales Tax %" id="" class="control-label">Sales Tax %:</label>
                            <input type="text" class="form-control" id="s_tax" name="s_tax" value="8.25" readonly="">
                    </div>
                  
                  </div>
                  <div class="col-sm-2">
                    
                    <div class="form-group">
                            <label for="Sales Tax" id="" class="control-label">Sales Tax Amt $:</label>
                            <input type="text" class="form-control" id="s_tax_amt" name="s_tax_amt" value="" readonly="">
                    </div>
                  
                  </div>                  

                  <div class="col-sm-1">

                    <div class="form-group">
                            <label for="Exemption Tax" id="" class="control-label">Exempt:</label>
                            <input type="checkbox"  id="exempt" name="exempt" value="">
                    </div>
                  
                  </div>


                  <div class="col-sm-5">
                    <div class="col-sm-6 ">
                      <b style="float:right; font-size:20px !important;color:#00a65a;margin-top: 22px;">Total Amount $:</b>
                    </div>

                    <div class="form-group col-sm-5">
                            <!-- <label for="totalAmount" id="" class="control-label">Total Amount $:</label> -->
                            <input type="text" class="form-control" step="0.01" id="pos_total_amount" name="t_amount" value="" readonly="" style="margin-top: 22px;font-size: 22px;color:#00a65a;">
                    </div>
                  
                  </div>
                  
                </div>
                <div class="col-sm-12">
                  <div class="col-sm-4">
                    <div class="form-group" id="card_no">
                            <label for="Card Number" id="ccn" class="control-label">Credit Card No:</label>
                            <input type="text" class="form-control" id="pos_card_number" name="card_number" value="" >
                    </div>
                  
                  </div>
                </div>
                <div class="col-sm-12">

                  <div class="col-sm-2">
                    <div class="form-group" id="tenderInput">
                      <label for="Tender Amount" class="control-label">Tender Amount $:</label>
                            <input type="number" class="form-control" step="0.01" id="pos_td_amount" name="td_amount" value="" required>
                    </div>
                  
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group" id="refundInput">
                      <label for="Refund" class="control-label">Refund $:</label>
                            <input type="number" class="form-control" step="0.01" id="pos_refund" name="refund" value="" readonly>
                    </div>
                  
                  </div>
                </div>
               
                <div class="col-sm-12">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <input type="submit" name="addPos_Form" id="save" class="btn  btn-primary" value="Save &amp; Print">
                      <a href="<?php echo base_url();?>pos/c_pos_list/posReceiptView" class="btn btn-primary" >Back</a>
                      <!-- <button type="submit" id="save" class="btn  btn-primary">Save &amp; Print</button>
                      <button type="" class="btn  btn-danger">Cancel</button> -->
                    </div>
                  
                  </div>
                  
                </div>
                
              </div>
            </div>
          </div>  
          </div>
          </div>
        </div>
        

    </section>

      
  </div>
  <?php $this->load->view("template/footer.php"); ?>

  <script text="javascript">
    $(document).ready(function(){
      
   /*====================================================
      =            Item Details by Barcode            =
      ====================================================*/
      var i = 1;

       $("#dynamic_field").on('blur','.pos_barcode',function(){

          var num = this.id.match(/\d+/);
          var pos_barcode = $('#bar_code'+num+'').val();
          //alert(bar_code);return;
          
          $.ajax({
            dataType: 'json',
            type: 'POST',        
            url:'<?php echo base_url(); ?>pos/c_point_of_sale/itemDetails',
            data: { 'pos_barcode' : pos_barcode              
          },

           success: function (data) {
              // alert(data);return false;
              if(data!='error' ){
                //alert(data[0].COST_PRICE);return false;
                  // alert(data[0].COST_PRICE);return false;
                  $('#price'+num+'').val(data[0].COST_PRICE);
                  $('#desc_item'+num+'').val(data[0].ITEM_MT_DESC);
                  $('#pos_purchase_ref').val(data[0].PURCH_REF_NO);
                  $('#pos_upc').val(data[0].UPC);
                  $('#pos_mpn').val(data[0].MFG_PART_NO);
                  $('#pos_manufacture').val(data[0].MANUFACTURER);
                  var condition = data[0].ITEM_CONDITION;
                  if(!isNaN(condition)){
                    if(condition == 3000){condition = 'Used';}
                    else if(condition == 1000){condition = 'New';}
                    else if(condition == 1500){condition = 'New other';}
                    else if(condition == 2000){condition = 'Manufacturer Refurbished';}
                    else if(condition == 2500){condition = 'Seller Refurbished';}
                    else if(condition == 7000){condition = 'For Parts or Not Working';}
                    else{condition = 'Used';}
                    $('#pos_condition').val(condition);
                  } 
                
                              
                }
                if(data == 'error'){
                  alert('The barcode has already used !');
                }
           }
          
          
            });   


      });
      /*=====  End of Item Details by Barcode  ======*/  

      $('#save').prop('disabled',true);
    /*====================================================
    =            Item/Items by Barcode  Input Block          =
    ====================================================*/
      
     $('#dynamic_field').append('<tr ><td style="width:50px;"><div style="width:50px;"><input type="number" class="form-control dynamic" id="sr_no'+i+'" name="sr_no[]" value="1"  readonly></div></td><td style="width:90px;"><div style="width:100%;"><select class="form-control lType" id="line_type'+i+'" name="line_type[]"><option value="PT">Parts</option><option value="SR">Service</option><option value="SH">Shipping</option><option value="OT">Other</option></select></div></td><td style="width:100px;"><div style="width:100%;"><input type="number" class="form-control pos_barcode" id="bar_code'+i+'" name="bar_code[]" value="" required></div></td><td style="width:340px;"><div style="width:100%;"><input type="text" class="form-control" id="desc_item'+i+'" name="desc_item[]" value="" ></div></td><<td style="width:50px;"><div style="width:100%;"><input type="number" class="form-control quantity" id="quantity'+i+'"  name="quantity[]" value="'+1+'" readonly ></div></td><td style="width:85px;"><div style="width:100%;"><input type="number" class="form-control price" id="price'+i+'" step="0.01" name="price[]" required></div></td><td style="width:85px;"><div style="width:100%;"><input type="number" class="form-control perc" id="pos_discount_perc'+i+'"  step="0.01" name="dis_percent[]" value="0"></div></td><td style="width:85px;"><div style="width:100%;"><input type="number" class="form-control disc" step="0.01" id="pos_disc_amount'+i+'" name="disc_amount[]" value="0"></div></td><td style="width:85px;"><div style="width:100%;"><input type="number" class="form-control net" id="pos_net_price'+i+'"  name="net_price[]" value="0" readonly ></div></td><td style="width:23px;"><div style="width:100%;"><button type="button" name="remove" id="button'+i+'" class="btn btn-sm btn-danger btn_remove fa fa-trash-o"></button></div></td></tr>');
      
      

      /*====================================================
        =  Add Button Click To Insert New Row In Item Detail Block =
        ====================================================*/
      $('#add').click(function(){

        i++;

         $('#dynamic_field').append('<tr ><td style="width:50px;"><div style="width:50px;"><input type="number" class="form-control dynamic" id="sr_no'+i+'" name="sr_no[]" value=""  readonly></div></td><td style="width:90px;"><div style="width:100%;"><select class="form-control lType" id="line_type'+i+'" name="line_type[]"><option value="PT">Parts</option><option value="SR">Service</option><option value="SH">Shipping</option><option value="OT">Other</option></select></div></td><td style="width:100px;"><div style="width:100%;"><input type="number" class="form-control pos_barcode" id="bar_code'+i+'" name="bar_code[]" value="" required></div></td><td style="width:340px;"><div style="width:100%;"><input type="text" class="form-control" id="desc_item'+i+'" name="desc_item[]" value="" ></div></td><<td style="width:50px;"><div style="width:100%;"><input type="number" class="form-control quantity" id="quantity'+i+'"  name="quantity[]" value="'+1+'" readonly ></div></td><td style="width:85px;"><div style="width:100%;"><input type="number" class="form-control price" id="price'+i+'" step="0.01" name="price[]" required></div></td><td style="width:85px;"><div style="width:100%;"><input type="number" class="form-control perc" id="pos_discount_perc'+i+'"  step="0.01" value="0" name="dis_percent[]" ></div></td><td style="width:85px;"><div style="width:100%;"><input type="number" class="form-control disc" step="0.01" id="pos_disc_amount'+i+'" name="disc_amount[]" value="0"></div></td><td style="width:85px;"><div style="width:100%;"><input type="number" class="form-control net" id="pos_net_price'+i+'"  name="net_price[]" value="0" readonly ></div></td><td style="width:23px;"><div style="width:100%;"><button type="button" name="remove" id="button'+i+'" class="btn btn-sm btn-danger btn_remove fa fa-trash-o"></button></div></td></tr>');

         if(isNaN($('#pos_total_amount').val())){
            $('#pos_total_amount').val(0);
          }
        /*====================================================
        =  Item Detail Block Calculations From Second Row Onward  =
        ====================================================*/
        $('.dynamic').each(function(idx, elem){
          $(elem).val(idx+1);
          // console.log($(elem).val(idx+1));
        });
        $('.lType').on('change',function(){
           var num = this.id.match(/\d+/);
           if($(this).val() == 'PT'){
              $('#bar_code'+num+'').prop('required',true);
              $('#bar_code'+num+'').prop('readonly',false);
              $('#quantity'+num+'').val(parseFloat(1));
           }else{
              $('#bar_code'+num+'').prop('required',false);
              $('#bar_code'+num+'').prop('readonly',true);
              $('#quantity'+num+'').val(parseFloat(0));
           }
        });

        $('.quantity').on('blur',function(){     //For Quantity Field Sum/On BLur

          var sum = 0;
          sum = parseFloat(sum);
          var currQty;
          $("input[class *= 'quantity']").each(function(){
            currQty = $(this).val();
            if(currQty == ''){
              currQty = 0;
            }
            sum += parseFloat(currQty);
          });
          sum.toFixed(2);
          $(".totalQuantity").val(sum);
        });

        $('.price').on('blur',function(){    //For Prices Field Input and Sum  

          var sum = 0;
          sum = parseFloat(sum);
          var currPrice;
          $("input[class *= 'price']").each(function(){
            currPrice = $(this).val();
            if(currPrice == ''){
              currPrice = 0;
            }
            sum += parseFloat(currPrice);
              
          });
          sum.toFixed(2);
          $(".totalPrice").val(sum);

        });

         $('.perc').on('blur',function(){

          var num = this.id.match(/\d+/);
          var price_i = $('#price'+num+'').val();
          var discount_i = $('#pos_discount_perc'+num+'').val();
          var disc_A = parseFloat((discount_i*price_i)/100);
          $('#pos_disc_amount'+num+'').val(disc_A.toFixed(2));
          var disc_A_2 = $('#pos_disc_amount'+num+'').val();
          var net_p = price_i - disc_A_2;
          $('#pos_net_price'+num+'').val(net_p.toFixed(2));
      });

         

        $('.disc').on('blur',function(){//  For discountAmount on Price Fields Calculation
           var num = this.id.match(/\d+/);
           var price_i = $('#price'+num+'').val();
           var disc_A = $('#pos_disc_amount'+num+'').val();
           var disc_i = (disc_A/price_i)*100;
           disc_i = parseFloat(disc_i);
           $('#pos_discount_perc'+num+'').val(disc_i.toFixed(2));
           var net_p = price_i - disc_A;
           $('#pos_net_price'+num+'').val(net_p.toFixed(2));

           var sum = 0;
           sum = parseFloat(sum);
           var currDisc;
           $("input[class *= 'disc']").each(function(){
              currDisc = $(this).val();
              if(currDisc == ''){
                currDisc = 0;
              }
              sum += parseFloat(currDisc);
           });
           sum.toFixed(2);
           $(".totalDisc").val(sum);
        });

        $('.net').on('blur',function(){// For netPrice Field and including Tax calculations
              var sum = 0;
              sum = parseFloat(sum);
              var currNet ;
              $("input[class *= 'net']").each(function(){
                currNet = $(this).val();
                if(currNet == ''){
                  currNet = 0;
                }
                  sum += parseFloat(currNet);
              });
              sum.toFixed(2);
              $(".totalNetPrice").val(sum);
              if($('#s_tax').val()==8.25){
                var taxPrice = (sum/100)*8.25;
                taxPrice= parseFloat(taxPrice);
                $('#s_tax_amt').val(taxPrice.toFixed(2));
                if(isNaN($('#s_tax').val())){
                   parseFloat($(this).val(0));
                }
                if(isNaN($('#s_tax_amt').val())){
                   parseFloat($(this).val(0));
                }
                var inclTaxPrice = parseFloat(sum.toFixed(2)) + parseFloat(taxPrice.toFixed(2));
                parseFloat(inclTaxPrice);
                $('#pos_total_amount').val(inclTaxPrice.toFixed(2));
                if(isNaN($('#pos_total_amount').val())){
                  $('#pos_total_amount').val(0);
                }

              }
              else{
                $('#s_tax_amt').val(0);
                if(isNaN($('#s_tax').val())){
                   parseFloat($(this).val(0));
                }
                $('#pos_total_amount').val(sum.toFixed(2));
                if(isNaN($('#pos_total_amount').val())){
                  $('#pos_total_amount').val(0);
                }
                if(isNaN($('#s_tax_amt').val())){
                   parseFloat($(this).val(0));
                }

              }
              
              // alert($('#s_tax').val());

        });

        $('.btn_remove').on('click',function(){ 
          var row = $(this).closest('tr');
          var dynamicValue = $(row).find('.dynamic').val();
          dynamicValue = parseInt(dynamicValue);
          row.remove();

          $('.dynamic').each(function(idx, elem){
            $(elem).val(idx+1);
          });

          var sum = 0;
          sum = parseFloat(sum);
          $("input[class *= 'net']").each(function(){
              if(isNaN($(this).val())){
               parseFloat($(this).val(0));
              }
              sum += parseFloat($(this).val());
          });
          $(".totalNetPrice").val(sum);
          if($('#s_tax').val()==8.25){
            var calTax = parseFloat($(".totalNetPrice").val());
            calTax = parseFloat(calTax * 1.0825);
            $('#pos_total_amount').val(calTax.toFixed(2));
          }else{
            $('#pos_total_amount').val(sum);
          }

          var summ = 0;
          summ = parseFloat(summ);
          $("input[class *= 'price']").each(function(){
              summ += parseFloat($(this).val());
          });
          $(".totalPrice").val(summ.toFixed(2));

          var disSum = 0;
          disSum = parseFloat(sum);
          $("input[class *= 'disc']").each(function(){
              disSum += parseFloat($(this).val());
          });
          $(".totalDisc").val(disSum);

          var qtySum = 0;
          qtySum = parseFloat(sum);
          $("input[class *= 'quantity']").each(function(){
              qtySum += parseFloat($(this).val());
          });
          $(".totalQuantity").val(qtySum);   

          if(isNaN($('#pos_total_amount').val())){
            $('#pos_total_amount').val(0);
          }     
        });



    /*=====  End Of Item Detail Block Calculations For Second Row & Onward   ======*/
        
  });

     /*====================================================
        =  Row Insert To Show Total Values Of Item Detail Block =
      ====================================================*/
      $('#newField').append('<tr ><td ><div style="width:53px;"><!---<input type="number" class="form-control" id="sr_no name="sr_no[]" value=""  readonly>---></div></td><td><div style="width:73px;"><!----<select class="form-control"><option value="PT">Parts</option><option value="SR">Service</option><option value="SH">Shipping</option><option value="OT">Other</option></select>---></div></td><td><div style="width:100px;"><!---<input type="number" class="form-control pos_barcode" id="bar_code" name="bar_code[]" value="" >---></div></td><td ><div style="width:325px; "><b style="float:right; font-size:16px !important;color:#00a65a;margin-top: 7px;">TOTAL:</b></div></td><<td><div style = "width:53px"><input type="number" class="form-control totalQuantity" id="pos_total_quantity" name="pos_total_quantity"  readonly ></div></td><td><div style="width:85px;"><input type="number" class="form-control totalPrice" id="pos_total_price" name="pos_total_price"  readonly></div></td><td><div style="width:55px;"><!---<input type="number" class="form-control" id="pos_discount_perc" name="dis_percent[]" >---></div></td><td><div style="width:85px;"><input type="number" class="form-control totalDisc"  id="pos_disc_total_amount" name="disc_total_amount" readonly></div></td><td><div style="width:85px;"><input type="number" class="form-control totalNetPrice" id="pos_net_total_price" name="pos_net_total_price"  readonly></div></td><td><div style="width:10px;"><!---<button type="hidden" name="remove" id="button" class="btn btn-sm btn-danger fa fa-trash-o">---></div></button></td></tr>');

    /*=====  End Row Insert To Show Total Values Of Item Detail Block  ======*/

    /*====================================================
    =   Ajax Call to Serialize Array Data in Item Detail       =
     ====================================================*/
     

      // $('#save').click(function(){
      //     $.ajax({
      //       url: "<?php //echo base_url('pos/c_point_of_sale/pos_addRecord'); ?>",
      //       method: "POST",
      //       data: ('#add_name').serialize(),
      //       success:function(data){
      //         alert(data);
      //         $('#add_name')[0].reset();
      //       }
      //     });
      // });

     /*=====  End/ Ajax Call to Serialize Array Data in Item Detail   ======*/




    /*====================================================
    =    Payment Block Checks Require/Show/Hide Fields     =
    ====================================================*/




    $('#card_no').hide();
    // $('#tenderInput').prop('required',true);
    // $('#tenderInput').hide();
    // $('#refundInput').hide();


    $('#option1').on('click',function(){
       $('#card_no').hide();

       $('#tenderInput').show();
       $('#refundInput').show();
       $('#pos_td_amount').prop('required',true);
       $('#opt1').val('C');
       $('#opt2').val('');
       $('#pos_card_number').prop('required',false);
       $(':input[type="submit"]').prop('disabled',true);
       $('#pos_card_number').val('');
    });

     $('#option2').on('click',function(){
       $('#card_no').show();
       $('#pos_card_number').prop('required',true);
       $('#tenderInput').hide();
       $('#refundInput').hide();
       $('#pos_td_amount').prop('required',false);
       $('#pos_td_amount').val('');

       $('#opt1').val('');
       $('#opt2').val('R');
       $(':input[type="submit"]').prop('disabled',true);
       $('#pos_card_number').on('input',function(){
          $(':input[type="submit"]').prop('disabled',false);
       });
       $('#pos_refund').val('');
    });

      

   /*=====  End of Payment Block Checks  ======*/ 

    /*====================================================
    =   Item Detail Block Calculations  For First Row        =
    ====================================================*/

     $('.lType').on('change',function(){
         var num = this.id.match(/\d+/);
         if($(this).val() == 'PT'){
            $('#bar_code'+num+'').prop('required',true);
            $('#bar_code'+num+'').prop('readonly',false);
            $('#quantity'+num+'').val(parseFloat(1));
         }else{
            $('#bar_code'+num+'').prop('required',false);
            $('#bar_code'+num+'').prop('readonly',true);
            $('#quantity'+num+'').val(parseFloat(0));
         }
      });

     $('.quantity').on('blur',function(){     //For Quantity Field Sum/On BLur

          var sum = 0;
          sum = parseFloat(sum);
          var currQty;
          $("input[class *= 'quantity']").each(function(){
            currQty = $(this).val();
            if(currQty == ''){
              currQty = 0;
            }
            sum += parseFloat(currQty);
          });
          sum.toFixed(2);
          $(".totalQuantity").val(sum);
      });

    $('.price').on('blur',function(){

          var sum = 0;
          sum = parseFloat(sum);
           var currPrice;
          $("input[class *= 'price']").each(function(){
            currPrice = $(this).val();
            if(currPrice == ''){
              currPrice = 0;
            }
            sum += parseFloat(currPrice);
              
          });
          $(".totalPrice").val(sum.toFixed(2));

    });

    $('.perc').on('blur',function(){
        var num = this.id.match(/\d+/);

        var price_i = $('#price'+num+'').val();
        var discount_i = $('#pos_discount_perc'+num+'').val();
        var disc_A = (discount_i*price_i)/100;
        $('#pos_disc_amount'+num+'').val(disc_A.toFixed(2));
        var disc_A_2 = $('#pos_disc_amount'+num+'').val();
        var net_p = price_i - disc_A_2;
        $('#pos_net_price'+num+'').val(net_p.toFixed(2));
    });

    

    $('.disc').on('blur',function(){//  For discountAmount on Price Fields Calculation
         var num = this.id.match(/\d+/);
         var price_i = $('#price'+num+'').val();
         var disc_A = $('#pos_disc_amount'+num+'').val();
         var disc_i = (disc_A/price_i)*100;
         disc_i = parseFloat(disc_i);
         $('#pos_discount_perc'+num+'').val(disc_i.toFixed(2));
         var net_p = price_i - disc_A;
         $('#pos_net_price'+num+'').val(net_p.toFixed(2));

         var sum = 0;
         sum = parseFloat(sum);
         var currDisc;
         $("input[class *= 'disc']").each(function(){
            currDisc = $(this).val();
            if(currDisc == ''){
              currDisc = 0;
            }
            sum += parseFloat(currDisc);
         });
         sum.toFixed(2);
         $(".totalDisc").val(sum);
    });

        $('.net').on('blur',function(){// For netPrice Field and including Tax calculations
              var sum = 0;
              sum = parseFloat(sum);
              var currNet ;
              $("input[class *= 'net']").each(function(){
                currNet = $(this).val();
                if(currNet == ''){
                  currNet = 0;
                }
                  sum += parseFloat(currNet);
              });
              sum.toFixed(2);
              $(".totalNetPrice").val(sum);
              if($('#s_tax').val()==8.25){
                var taxPrice = (sum/100)*8.25;
                taxPrice= parseFloat(taxPrice);
                $('#s_tax_amt').val(taxPrice.toFixed(2));
                if(isNaN($('#s_tax').val())){
                   parseFloat($(this).val(0));
                }
                if(isNaN($('#s_tax_amt').val())){
                   parseFloat($(this).val(0));
                }
                var inclTaxPrice = parseFloat(sum.toFixed(2)) + parseFloat(taxPrice.toFixed(2));
                parseFloat(inclTaxPrice);
                $('#pos_total_amount').val(inclTaxPrice.toFixed(2));
                if(isNaN($('#pos_total_amount').val())){
                  $('#pos_total_amount').val(0);
                }

              }
              else{
                $('#s_tax_amt').val(0);
                if(isNaN($('#s_tax').val())){
                   parseFloat($(this).val(0));
                }
                $('#pos_total_amount').val(sum.toFixed(2));
                if(isNaN($('#pos_total_amount').val())){
                  $('#pos_total_amount').val(0);
                }
                if(isNaN($('#s_tax_amt').val())){
                   parseFloat($(this).val(0));
                }

              }
              
              // alert($('#s_tax').val());

        });


    /*=====  End Of Item Detail Block Calculations  First Row  ======*/



    /*====================================================
    =            For Removing First Row         =
    ====================================================*/
    $('.btn_remove').on('click',function(){ 
        var id = this.id.match(/\d+/);
        var row = $(this).closest('tr');
        var dynamicValue = $(row).find('.dynamic').val();
        dynamicValue = parseInt(dynamicValue);
        row.remove();

        $('.dynamic').each(function(idx, elem){
          $(elem).val(idx+1);
        });

        var sum = 0;
        sum = parseFloat(sum);
        $("input[class *= 'net']").each(function(){
            if(isNaN($(this).val())){
             parseFloat($(this).val(0));
            }
            sum += parseFloat($(this).val());
        });
        
        $(".totalNetPrice").val(sum);
        if($('#s_tax').val()==8.25){
          var calTax = parseFloat($(".totalNetPrice").val());
          calTax = parseFloat(calTax * 1.0825);
          $('#pos_total_amount').val(calTax.toFixed(2));
        }else{
          $('#pos_total_amount').val(sum);
        }
        var summ = 0;
        summ = parseFloat(summ);
        $("input[class *= 'price']").each(function(){
            summ += parseFloat($(this).val());
        });
        $(".totalPrice").val(summ.toFixed(2));

        var disSum = 0;
        disSum = parseFloat(disSum);
        $("input[class *= 'disc']").each(function(){
            disSum += parseFloat($(this).val());
        });
        $(".totalDisc").val(disSum);

        var qtySum = 0;
        qtySum = parseFloat(qtySum);
        $("input[class *= 'quantity']").each(function(){
            qtySum += parseFloat($(this).val());
        });
        $(".totalQuantity").val(qtySum);
        
      });

    /*=====  End/ Removing First Row   ======*/


    /*====================================================
    =            Payment Block Calculations           =
    ====================================================*/
    // var initialVal = 0;
    // initialVal = parseFloat(initialVal);
    // $('#s_tax_amt').val(initialVal);
    // $('#pos_total_amount').val(initialVal)

    $('#exempt').on('click',function(){
      var checkbox = $('#exempt').prop('checked');
      if(checkbox == true){
            var t_A = $('#pos_net_total_price').val();
            var minusTax = (t_A/100)*8.25; 
            minusTax.toFixed(2);
            var exemptedA = $('#pos_total_amount').val()- minusTax;
            $('#pos_total_amount').val(exemptedA.toFixed(2));
            
            $('#exempt').val(1);
            $('#s_tax').val(0);
            $('#s_tax_amt').val(0);
            if(isNaN($('#s_tax').val())){
               parseFloat($(this).val(0));
            }
            if(isNaN($('#s_tax_amt').val())){
               parseFloat($(this).val(0));
            }
      }
      if(checkbox == false){
            var t_A = $('#pos_net_total_price').val();
            var plusTax = (t_A/100)*8.25; 
            plusTax.toFixed(2);
            plusTax = parseFloat(plusTax);
            var notExemptedA = parseFloat($('#pos_total_amount').val()) + plusTax ;
            $('#pos_total_amount').val(notExemptedA.toFixed(2));
            $('#exempt').val(0);
            $('#s_tax').val(8.25);
            $('#s_tax_amt').val(plusTax.toFixed(2));
            if(isNaN($('#s_tax').val())){
               parseFloat($(this).val(0));
            }
            if(isNaN($('#s_tax_amt').val())){
               parseFloat($(this).val(0));
            }
      }
    });


    $('#pos_td_amount').on('blur',function(){
      var tender = $('#pos_td_amount').val();
      var net = $('#pos_total_amount').val();
      if(parseFloat(tender) < parseFloat(net)){
        alert('Tender amount should be greater than Total amount !!!');
        $(':input[type="submit"]').prop('readonly',true);
        var refunded = (tender - net).toFixed(2);
        $('#pos_refund').val(refunded);
      }else{
        var refunded = (tender - net).toFixed(2);
        $('#pos_refund').val(refunded);
        $(':input[type="submit"]').prop('disabled',false);
      }
      
    });


   /*=====  End of Payment Block Calculations  ======*/ 

   /*=== calcultions before editing ====*/
   


   /*===== End calculations ===*/
    
    /*===== Success message auto hide ====*/
        setTimeout(function() {
          $('#successMessage').fadeOut('slow');
        }, 5000); // <-- time in milliseconds

        setTimeout(function() {
          $('#errorMessage').fadeOut('slow');
        }, 5000); // <-- time in milliseconds        

    /*===== Success message auto hide ====*/        

   var phones = [{ "mask": "(###) ###-####"}, { "mask": "(###) ###-##############"}];
    $('#phone_no').inputmask({ 
        mask: phones, 
        greedy: false, 
        definitions: { '#': { validator: "[0-9]", cardinality: 1}} 
    });

    // $('#add_posForm').submit(function() {
    //     if (parseFloat($("#pos_td_amount").val()) < parseFloat($('#pos_refund').val())) {
    //         alert('Tender amount should be greater than Total amount !!!');
    //         return false;
    //     }
    // });

});
      

  </script>
  </form>


 





