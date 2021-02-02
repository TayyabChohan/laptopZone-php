<?php $this->load->view("template/header.php"); ?>

<form action="<?php echo base_url(); ?>service/c_serviceForm/returnAddService" method="post"   accept-charset="utf-8" onsubmit="setTimeout(function(){ location.reload(); }, 1000);"  target="_blank" >
   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Service Return
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Service Return Form</li>
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
              <h3 class="box-title">Customer Info</h3>
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
                     <input type="number" class="form-control return_doc_no" id="doc_no" name="doc_no" value="" required>
                     <input type="hidden" name="lz_serv_mt_id" id="lz_serv_mt_id" value="">
                  </div>
                  </div>

                <div class="col-sm-2 ">
                  <div class="form-group">
                   <label for="Date" class="control-label">Date:</label>
                     <input type="text" class="form-control" id="doc_date" name="doc_date" value="<?php echo date('m/d/Y');?>" data-date-format="mm/dd/yyyy" readonly>
                  </div>
                </div>

                <div class="col-sm-2 ">
                  <div class="form-group">
                   <label for="Date" class="control-label">Return Date:</label>
                     <input type="text" class="form-control" id="return_date" name="return_date" value="<?php echo date('m/d/Y');?>" data-date-format="mm/dd/yyyy" readonly>
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                   <label for="Phone" class="control-label">Phone :</label>
                     <input type="text" class="form-control" id="phone_no" name="phone_no" value="" readonly>
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                   <label for="Email" class="control-label">Email :</label>
                     <input type="text" class="form-control" id="buyer_email" name="buyer_email" value="" readonly>
                  </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                      <label for="Buyer Name" class="control-label">Buyer Name:</label>
                      <input type="text" class="form-control" id="buyer_name" name="buyer_name" value="" readonly>
                    </div>
                  </div>

                </div>

                <div class="col-sm-12">
                  
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="Address" class="control-label">Address:</label>
                        <input type="text" class="form-control" id="address" name="buyer_address" value="" readonly>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="City" class="control-label">City:</label>
                        <input type="text" class="form-control" id="buyer_city" name="buyer_city" value="" readonly>
                                              
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="State" class="control-label">State:</label>
                        <input type="text" class="form-control" id="buyer_state" name="buyer_state" value="" readonly>                        
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="Zip" class="control-label">Zip:</label>
                      <input type="text" class="form-control" id="buyer_zip" name="buyer_zip" value="" readonly>
                    </div>
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
              <h3 class="box-title">Advance Payment</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div> 
            </div>
            <div class="box-body">
              <div class="row">
               <!--  <div class="col-sm-12">
                  <div class="col-sm-2">
                    <div class="form-group p-b">
                        <div class="col-sm-9">
                          <button type="button" id="option1" class="form-control btn btn-primary btn-sm" required>Cash</button>
                        </div>
                        <input type="hidden" class="form-control btn btn-primary btn-sm" id="opt1" name="opt1" value="" >
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
                </div> --> 
                <div class="col-sm-12">
                  <!-- <div class="col-sm-2">
                    
                    <div class="form-group">
                            <label for="Sales Tax %" id="" class="control-label">Sales Tax %:</label>
                            <input type="number" class="form-control" id="s_tax" name="s_tax" value="8.25" readonly="">
                    </div>
                  
                  </div> -->
                  <div class="col-sm-2">
                    
                    <div class="form-group">
                          <label for="advance given" id="" class="control-label">Advance received $:</label>
                          <input type="number" class="form-control" id="adv_before" name="adv_before"  readonly="">
                    </div>
                  
                  </div>

                  <div class="col-sm-2">
                    
                    <div class="form-group">
                          <label for="Total Amount" id="" class="control-label">Total Amount $:</label>
                          <input type="number" class="form-control" id="total_receiveable" name="total_receiveable"  readonly>
                    </div>
                    <input type="hidden" class="form-control" id="s_tax_amt" name="s_tax_amt"  readonly>
                    <input type="hidden" class="form-control" id="discAmount" name="discAmount"  readonly>
                  </div>
                 <!--  <div class="col-sm-2">
                    
                    <div class="form-group">
                            <label for="Sales Tax" id="" class="control-label">Sales Tax Amt $:</label>
                            
                    </div>
                  
                  </div>  -->                 

<!--                   <div class="col-sm-1">

                    <div class="form-group">
                            <label for="Exemption Tax" id="" class="control-label">Exempt:</label>
                            <input type="checkbox"  id="exempt" name="exempt" value="">
                    </div>
                  
                  </div> -->

                 <!--   <div class="col-sm-1" >

                    <div class="form-group">
                            <label for="advanceCheck" id="" class="control-label">Advance:</label>
                            <input type="checkbox"  id="advance" name="advance" value="">
                    </div>
                  
                  </div> -->
                 <!--  <div class="col-sm-2" id="advanceAmount">
                    
                    <div class="form-group">
                            <label for="Advance Amount" id="" class="control-label">Advance Amount$:</label>
                            <input type="number" class="form-control" id="advAmount" name="advAmount" value="" >
                    </div>
                  
                  </div> -->
                 

                  <div class="col-sm-5">
                    <div class="col-sm-6 ">
                      <b style="float:right; font-size:20px !important;color:#00a65a;margin-top: 17px;">Payable Amount $:</b>
                    </div>

                    <div class="form-group col-sm-5">
                            <!-- <label for="totalAmount" id="" class="control-label">Total Amount $:</label> -->
                            <input type="text" class="form-control" step="0.01" id="serv_total_amount" name="t_amount" value="0" readonly="" style="margin-top: 22px;font-size: 22px;color:#00a65a;">
                    </div>
                  
                  </div>
                  
                </div>
                <!-- <div class="col-sm-12">
                  <div class="col-sm-4">
                    <div class="form-group" id="card_no1">
                        <label for="Card Number1" id="ccn1" class="control-label">Credit Card No:</label>
                        <input type="number" class="form-control" id="return_card_number" name="return_card_number" value="" >
                    </div>
                  
                  </div>
                </div> -->
              <!--   <div class="col-sm-12">

                  <div class="col-sm-2">
                    <div class="form-group" id="tenderInput1">
                      <label for="Tender Amount1" class="control-label">Tender Amount $:</label>
                            <input type="number" class="form-control" step="0.01" id="return_td_amount" name="return_td_amount" value="" >
                    </div>
                  
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group" id="refundInput1">
                      <label for="Refund1" class="control-label">Refund $:</label>
                      <input type="number" class="form-control" step="0.01" id="return_serv_refund" name="return_serv_refund" value="" readonly>
                    </div>
                  
                  </div>
                </div> -->
               
                
                
              </div>
            </div>
          </div>  
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">Equipment</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-sm-12 form-group">
                    <div class="col-sm-3">
                      <div class="form-group ">
                        <label for="Equipment Type" class="control-label">Equipment Type:</label>
                       <input type="number" class="form-control" id="equip_type" name="equip_type" readonly>
                      </div>
                      
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="Item Desc" class="control-label">Equipment Desc:</label>
                        <input type="text" class="form-control" id="equip_desc" name="equip_desc" readonly>
                      </div>
                      
                    </div>
                     <div class="col-sm-4">
                      <div class="form-group">
                        <label for="SrNO/IMei" class="control-label">Sr.NO/IMEI:</label>
                        <input type="" class="form-control" id="imei" name="equip_imei" readonly>
                      </div>
                      
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="col-sm-7">
                        <div class="form-group">
                          <label for="Job Detail" class="control-label">Job Detail :</label>
                          <textarea id="job_det" name="job_det" class="form-control" readonly></textarea>
                        </div>
                        
                    </div>
                    <div class="col-sm-2">
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
            <h3 class="box-title">Component</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div> 
          </div>
          <div class="box-body">
            <div class="row">
              
              <div class="col-sm-12 form-group">
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
                        </th>
                       
                        
                        <th>
                           <label for="Component" class="control-label">Component:</label>
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
                      </tr>
                    </thead> 
                </table>
                <div class="col-sm-1">
                  <div class="form-group">
                    <!-- <button  type="button" class="btn btn-primary" id="add" name="add">+Add Row</button> -->
                    <!-- <button type="submit" class="btn btn-primary" id="submit">Submit</button> -->
                  </div>
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
                        <input type="hidden" class="form-control btn btn-primary btn-sm" id="opt1" name="opt1" value="C" >
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

                    <div class="col-sm-2 ">
                      <b style="float:right; font-size:17px !important;color:#00a65a;margin-top: 22px;">Payable Amount $:</b>
                    </div>

                    <div class="form-group col-sm-2">
                        <!-- <label for="totalAmount" id="" class="control-label">Total Amount $:</label> -->
                        <input type="number" class="form-control" step="0.01" id="payable_amount" name="tendr_amount" value="" readonly="" style="margin-top: 22px;font-size: 22px;color:#00a65a;">
                    </div>
                  
                  
                  <!-- <div class="col-sm-2">
                    
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

                  <div class="col-sm-2">
                    
                    <div class="form-group">
                            <label for="Advance" id="" class="control-label">Advance $:</label>
                            <input type="number" class="form-control" id="advance" name="advance" value="" readonly="">
                    </div>
                  
                  </div> --> 
                  
                </div>
                <div class="col-sm-12">
                  <div class="col-sm-4">
                    <div class="form-group" id="card_no">
                            <label for="Card Number" id="ccn" class="control-label">Credit Card No:</label>
                            <input type="text" class="form-control" id="serv_card_number" name="card_number" value="" >
                    </div>
                  
                  </div>
                </div>
                <div class="col-sm-12">

                  <div class="col-sm-2">
                    <div class="form-group" id="tenderInput">
                      <label for="Tender Amount" class="control-label">Tender Amount $:</label>
                            <input type="number" class="form-control" step="0.01" id="td_amount" name="td_amount" value="" required>
                    </div>
                  
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group" id="refundInput">
                      <label for="Refund" class="control-label">Refund $:</label>
                            <input type="number" class="form-control" step="0.01" id="serv_refund" name="refund" value="" readonly>
                    </div>
                  
                  </div>
                </div>
               
                <div class="col-sm-12">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <input type="submit" name="saveService" id="save" class="btn  btn-primary" value="Save &amp; Print">
                      <a href="<?php echo base_url();?>service/c_serviceReceipt/serviceReceiptView" class="btn btn-primary" >Back</a>
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
  </form>
  <?php $this->load->view("template/footer.php"); ?>

<script text="javascript">
  $(document).ready(function(){

    $('#save').prop('disabled',true);
    
  /*==  Data Fetch From DB by ajax call ==*/
    $("#doc_no").blur(function(){
      var docNo = $('#doc_no').val();

      $.ajax({
          dataType: 'json',
          type: 'POST',        
          url:'<?php echo base_url(); ?>service/c_serviceForm/returnFilledData',
          data: { 'docNo' : docNo 
        },
        success: function (data) {
          
            if(data!='error'){
              $('#doc_date').val(data[0].DOC_DATE);
              $('#lz_serv_mt_id').val(data[0].MT_ID);
              $('#phone_no').val(data[0].BUYER_PHONE_ID);
              $('#buyer_email').val(data[0].BUYER_EMAIL);
              $('#buyer_name').val(data[0].BUYER_NAME);
              $('#address').val(data[0].BUYER_ADDRESS);
              $('#buyer_city').val(data[0].BUYER_CITY_ID);
              $('#buyer_state').val(data[0].BUYER_STATE_ID);
              $('#buyer_zip').val(data[0].BUYER_ZIP);
              $('#adv_before').val(data[0].ADVANCE_AMT);
              if($('#adv_before').val()==''){
                 $('#adv_before').val(0);
              }

              $('#equip_type').val(data[0].EQUIP_ID);
              $('#equip_desc').val(data[0].EQUIP_TYPE_DESC);
              $('#imei').val(data[0].SR_NO);
              $('#job_det').val(data[0].JOB_DETAIL);
              var a =1;
              var netPrice = 0;
              var len = data.length;
              for(var i=0;i<len;i++){
                $('#dynamic_field').append('<tr ><td style="width:50px;"><div style="width:100%;"><input type="number" class="form-control dynamic" id="sr_no'+a+'" name="sr_no[]" value="'+a+'"  readonly></div></td><td style="width:120px;"><div style="width:100%;"><input class="form-control" type="text" id="component'+a+'" name="component[]"  readonly></div></td><td style="width:50px;"><div style="width:100%;"><input type="number" class="form-control quantity" id="quantity'+a+'"  name="quantity[]" value="" readonly></div></td><td style="width:50px;"><div style="width:100%;"><input type="number" class="form-control price" id="price'+a+'" step="0.01" name="price[]" readonly></div></td></tr>');
                $('#component'+a+'').val(data[i].LZ_COMPONENT_DESC);
                $('#quantity'+a+'').val(data[i].QTY);
                $('#price'+a+'').val(data[i].PRICE);
                netPrice = netPrice + parseFloat($('#price'+a+'').val());
                // alert(netPrice);
                a++;
               }
              if(data[0].SERVICE_CHARGES == ''){
                var servPlusNet = 0.00;
              }else{
                var servPlusNet = parseFloat(netPrice)+parseFloat(data[0].SERVICE_CHARGES);
              }
              
              var discAmt = parseFloat(data[0].DISC_AMOUNT);
              var totalAmt = parseFloat(servPlusNet) -parseFloat(discAmt);
              var taxPerc = parseFloat(data[0].STAX_PERC);
              var taxAmt = (parseFloat(totalAmt/100)*parseFloat(taxPerc)).toFixed(2);
              var grand = parseFloat(totalAmt)+parseFloat(taxAmt);
              var adv = parseFloat($('#adv_before').val());
              var grandTotal = parseFloat(grand)-parseFloat(adv);
              // alert(grandTotal);
              $('#s_tax_amt').val(taxAmt);
              $('#discAmount').val(discAmt);
              $('#total_receiveable').val(grand.toFixed(2));
              $('#serv_total_amount').val(grandTotal.toFixed(2));
              $('#payable_amount').val(grandTotal.toFixed(2));
                             
            }
            if(data == 'error'){
                  alert('The Item has Returned OR Receipt No not found !');
            }
         }
      });
    });//End On blur
  /*== End Data Fetch From DB by ajax call ==*/

  /*=========== Payment Mode==========*/


    $('#card_no').hide();
    // $('#tenderInput').prop('required',true);
    // $('#tenderInput').hide();
    // $('#refundInput').hide();


    $('#option1').on('click',function(){
       $('#card_no').hide();
       $('#tenderInput').show();
       $('#refundInput').show();
       $('#td_amount').prop('required',true);
       $('#opt1').val('C');
       $('#opt2').val('');
       $('#serv_card_number').prop('required',false);
       $(':input[type="submit"]').prop('disabled',true);
       $('#serv_card_number').val('');
    });

    $('#option2').on('click',function(){
       $('#card_no').show();
       $('#serv_card_number').prop('required',true);
       $('#tenderInput').hide();
       $('#refundInput').hide();
       $('#td_amount').prop('required',false);
       $(':input[type="submit"]').prop('disabled',true);
       $('#serv_card_number').on('input',function(){
          $(':input[type="submit"]').prop('disabled',false);
       });
       $('#td_amount').val('');
       $('#serv_refund').val('');
       $('#opt1').val('');
       $('#opt2').val('R');
    });
  /*=========== End Payment Mode==========*/

    $('#td_amount').on('blur',function(){
      var tender = $('#td_amount').val();
      var net = $('#payable_amount').val();
      if(parseFloat(tender) < parseFloat(net)){
        alert('Tender amount should be greater than Payable amount !!!');
        $(':input[type="submit"]').prop('disabled',true);
      }else{
        var refunded = (tender - net).toFixed(2);
        $('#serv_refund').val(refunded);
        $(':input[type="submit"]').prop('disabled',false);
      }
    });
  });
</script>
