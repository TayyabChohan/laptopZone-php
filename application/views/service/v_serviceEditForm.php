<?php $this->load->view("template/header.php"); ?>

<form action="<?php echo base_url(); ?>service/c_serviceForm/updateServiceInvoice" method="post"   accept-charset="utf-8" >
   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Service
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Service Form</li>
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
                     <input type="number" class="form-control" id="doc_no" name="doc_no" value="<?php echo $data[0]['DOC_NO'];?>" readonly>
                     <input type="hidden" name="lz_serv_mt_id" id="lz_serv_mt_id" value="<?php echo @$data[0]['LZ_SERV_MT_ID'];?>">
                  </div>
                  </div>

                <div class="col-sm-2 ">
                  <div class="form-group">
                   <label for="Date" class="control-label">Date:</label>
                     <input type="text" class="form-control" id="date" name="doc_date" value="<?php echo $data[0]['DOC_DATE'];?>" data-date-format="mm/dd/yyyy" readonly>

                  </div>
                </div>

                <div class="col-sm-2 ">
                  <div class="form-group">
                   <label for="expectedDate" class="control-label">Expected Return Date:</label>
                   <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                    <input type="text" class="form-control" id="return_date" name="return_date" value="<?php echo $data[0]['EXPECTED_RETURN'];?>" data-date-format="mm/dd/yyyy" readonly>
                  </div>
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                   <label for="Phone" class="control-label">Phone :</label>
                     <input type="text" class="form-control" id="phone_no" name="phone_no" value="<?php echo $data[0]['BUYER_PHONE_ID'];?>" >
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                   <label for="Email" class="control-label">Email :</label>
                     <input type="text" class="form-control" id="buyer_email" name="buyer_email" value="<?php echo $data[0]['BUYER_EMAIL'];?>" >
                  </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                      <label for="Buyer Name" class="control-label">Buyer Name:</label>
                        <input type="text" class="form-control" id="buyer_name" name="buyer_name" value="<?php echo $data[0]['BUYER_NAME'];?>" >
                    </div>
                  </div>

                </div>

                <div class="col-sm-12">
                  
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="Address" class="control-label">Address:</label>
                        <input type="text" class="form-control" id="address" name="buyer_address" value="<?php echo $data[0]['BUYER_ADDRESS'];?>" >
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="City" class="control-label">City:</label>
                       <?php 
                       //var_dump(@$data['BUYER_CITY_ID']);exit; 
                        foreach(@$cityState['city_query']  as $city_name):
                          if(@$city_name['CITY_ID'] == @$data[0]['BUYER_CITY_ID']){ ?>
                          <!-- <option value="<?php //echo $city_name['CITY_ID'];?>"><?php //echo strtoupper($city_name['CITY_DESC']);?></option> -->
                          <input type="text" class="form-control" name="<?php echo strtoupper(@$city_name['CITY_DESC']);?>" id="buyer_city" value="<?php echo strtoupper(@$city_name['CITY_DESC']);?>" readonly>
                          <input type="hidden" name="buyer_city" id="buyer_city" value="<?php echo @$city_name['CITY_ID']; ?>">
                        <?php 
                          }
                        endforeach; ?>                       
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="State" class="control-label">State:</label>
                       <?php
                        foreach(@$cityState['state_query']  as $state_name):  
                          if(@$state_name['STATE_ID'] == @$data[0]['BUYER_STATE_ID']){
                          //foreach(@$data['state_query']  as $state_name):?>
                           <!--  <option value="<?php //echo $state_name['STATE_ID'];?>"><?php //echo $state_name['STATE_DESC'];?></option> -->

                            <input type="text" class="form-control" name="<?php echo strtoupper(@$state_name['STATE_DESC']);?>" id="buyer_state" value="<?php echo @$state_name['STATE_DESC'];?>" readonly>
                            <input type="hidden" name="buyer_state" id="buyer_state" value="<?php echo @$state_name['STATE_ID']; ?>">

                          <?php 
                          }
                        endforeach; ?>                        
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="Zip" class="control-label">Zip:</label>
                        <input type="text" class="form-control" id="buyer_zip" name="buyer_zip" value="<?php echo $data[0]['BUYER_ZIP'];?>" >
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

                        <?php 
                       //var_dump(@$data['BUYER_CITY_ID']);exit; 
                        foreach(@$equipment['equipQry']  as $equip):
                          if(@$equip['EQUIP_ID'] == @$data[0]['EQUIP_ID']){ ?>
                          <!-- <option value="<?php //echo $city_name['CITY_ID'];?>"><?php //echo strtoupper($city_name['CITY_DESC']);?></option> -->
                          <input type="text" class="form-control" name="<?php echo strtoupper(@$equip['EQUIP_TYPE_DESC']);?>" id="equip" value="<?php echo strtoupper(@$equip['EQUIP_TYPE_DESC']);?>" readonly>
                          <input type="hidden" name="equip_id" id="equip_id" value="<?php echo @$equip['EQUIP_ID']; ?>">
                        <?php 
                          }
                        endforeach; ?>
                      </div>
                      
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="Item Desc" class="control-label">Equipment Desc:</label>
                        <input type="text" class="form-control" id="equip_desc" name="equip_desc" value="<?php echo  @$data[0]['EQUIP_TYPE_DESC']; ?>" required>
                      </div>
                      
                    </div>
                     <div class="col-sm-4">
                      <div class="form-group">
                        <label for="SrNO/IMei" class="control-label">Sr.NO/IMEI:</label>
                        <input type="" class="form-control" id="imei" name="equip_imei" value="<?php echo @$data[0]['SR_NO']; ?>" >
                      </div>
                      
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="col-sm-7">
                        <div class="form-group">
                          <label for="Job Detail" class="control-label">Job Detail :</label>
                          <textarea name="job_det" class="form-control"  required><?php echo  @$data[0]['JOB_DETAIL']; ?></textarea>
                        </div>
                        
                    </div>
                    <div class="col-sm-2">
                    </div>
                  <!--   <div class="col-sm-1 ">
                        <div class="form-group " style="padding-top:28px;">
                          <a href="<?php //echo base_url();?>service/c_serviceForm/showEquipment" class="btn btn-primary" >Add Equipment</a>
                        </div>
                        
                    </div> -->
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
                </div> 
                <div class="col-sm-12">
                  <div class="col-sm-2">
                    
                    <div class="form-group">
                            <label for="Sales Tax %" id="" class="control-label">Sales Tax %:</label>
                            <input type="number" class="form-control" id="s_tax" name="s_tax" value="8.25" readonly="">
                    </div>
                  
                  </div>
                  <div class="col-sm-2">
                    
                    <div class="form-group">
                            <label for="Sales Tax" id="" class="control-label">Sales Tax Amt $:</label>
                            <input type="number" class="form-control" id="s_tax_amt" name="s_tax_amt" value="0" readonly="">
                    </div>
                  
                  </div>                  

                  <div class="col-sm-1">

                    <div class="form-group">
                            <label for="Exemption Tax" id="" class="control-label">Exempt:</label>
                            <input type="checkbox"  id="exempt" name="exempt" value="<?php echo @$data[0]['TAX_EXEMPT'];?>">
                    </div>
                  
                  </div>

                   <!-- <div class="col-sm-1" >

                    <div class="form-group">
                            <label for="advanceCheck" id="" class="control-label">Advance:</label>
                            <input type="checkbox"  id="advance" name="advance" value="">
                    </div>
                  
                  </div> -->
                  <div class="col-sm-2" id="advanceAmount">
                    
                    <div class="form-group">
                            <label for="Advance Amount" id="" class="control-label">Advance Amount $:</label>
                            <input type="number" class="form-control" id="advAmount" name="advAmount" value="<?php echo @$data[0]['ADVANCE_AMT'];?>" >
                    </div>
                  
                  </div>


                  <div class="col-sm-4">
                    <div class="col-sm-6 ">
                      <b style="float:right; font-size:16px !important;color:#00a65a;margin-top: 22px;">Total Amount $:</b>
                    </div>

                    <div class="form-group col-sm-6">
                            <!-- <label for="totalAmount" id="" class="control-label">Total Amount $:</label> -->
                            <input type="text" class="form-control" step="0.01" id="serv_total_amount" name="t_amount" value="" readonly="" style="margin-top: 22px;font-size: 22px;color:#00a65a;">
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
                            <input type="number" class="form-control" step="0.01" id="td_amount" name="td_amount" value="">
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
                      <input type="submit" name="saveService" id="save" class="btn  btn-primary" value="Update">
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
  <?php $this->load->view("template/footer.php"); ?>

  <script text="javascript">
    $(document).ready(function(){

    // $('#save').prop('disabled',true);
      
   /*====================================================
      =            Item Details by Barcode            =
      ====================================================*/
      var i = 1;
      var slect = '<select name="component[]" class="form-control"> <?php  foreach(@$component['selectQry'] as $comp):?> <option value="<?php echo $comp['LZ_COMPONENT_ID'];?>"><?php echo $comp['LZ_COMPONENT_DESC'];?></option> <?php endforeach; ?> </select>';
      /*=====  End of Item Details by Barcode  ======*/  

      var data = '<?php $i = 1;foreach(@$data as $row): ?><tr ><td style="width:50px;"><div style="width:50px;"><input type="number" class="form-control dynamic" id="sr_no<?php echo $i?>" name="sr_no[]" value="<?php echo $i?>"  readonly></div></td><td style="width:340px;"><div style="width:100%;"><?php  foreach(@$component['selectQry']  as $comp):if(@$comp['LZ_COMPONENT_ID'] == @$row['COMPONENT_ID']){ ?><input type="text" class="form-control" name="<?php echo strtoupper(@$comp['LZ_COMPONENT_DESC']);?>" id="equip" value="<?php echo strtoupper(@$comp['LZ_COMPONENT_DESC']);?>" readonly><input type="hidden" name="component[]" id="component<?php echo $i?>" value="<?php echo @$comp['LZ_COMPONENT_ID']; ?>"><?php 
                          }
                        endforeach; ?></div></td><<td style="width:50px;"><div style="width:100%;"><input type="number" class="form-control quantity" id="quantity<?php echo $i?>"  name="quantity[]" value="<?php echo @$row['QTY'] ;?>" ></div></td><td style="width:85px;"><div style="width:100%;"><input type="number" class="form-control price" id="price<?php echo $i?>" step="0.01" name="price[]" value="" required></div></td><td style="width:85px;"><div style="width:100%;"><input type="number" class="form-control net" id="serv_net_price<?php echo $i?>"  name="net_price[]" value="<?php echo @$row['PRICE'] ;?>"  readonly ></div></td><td style="width:23px;"><div style="width:100%;"><button type="button" name="remove" id="button<?php echo $i?>" class="btn btn-sm btn-danger btn_remove fa fa-trash-o"></button></div></td></tr><?php 
                          $i++;
                          endforeach;  ?>';
    /*====================================================
    =            Item/Items by Barcode  Input Block          =
    ====================================================*/
      
     $('#dynamic_field').append(data);
      
      

      /*====================================================
        =  Add Button Click To Insert New Row In Item Detail Block =
        ====================================================*/
      $('#add').click(function(){

        i++;

         $('#dynamic_field').append('<tr ><td style="width:50px;"><div style="width:50px;"><input type="number" class="form-control dynamic" id="sr_no'+i+'" name="sr_no[]" value="1"  readonly></div></td><td style="width:340px;"><div style="width:100%;">'+slect+'</div></td><<td style="width:50px;"><div style="width:100%;"><input type="number" class="form-control quantity" id="quantity'+i+'"  name="quantity[]" value="" ></div></td><td style="width:85px;"><div style="width:100%;"><input type="number" class="form-control price" id="price'+i+'" step="0.01" name="price[]" required></div></td><td style="width:85px;"><div style="width:100%;"><input type="number" class="form-control net" id="serv_net_price'+i+'"  name="net_price[]" readonly ></div></td><td style="width:23px;"><div style="width:100%;"><button type="button" name="remove" id="button'+i+'" class="btn btn-sm btn-danger btn_remove fa fa-trash-o"></button></div></td></tr>');

          
        /*====================================================
        =  Item Detail Block Calculations From Second Row Onward  =
        ====================================================*/
        $('.dynamic').each(function(idx, elem){
          $(elem).val(idx+1);
          // console.log($(elem).val(idx+1));
        });

      
        $('.price').on('blur',function(){
            var num = this.id.match(/\d+/);
            var price_i = $('#price'+num+'').val();
            var qty_i = $('#quantity'+num+'').val();
            var serv_net_price = parseFloat(price_i*qty_i);
            $('#serv_net_price'+num+'').val(serv_net_price.toFixed(2));
            var sum = 0;
            sum = parseFloat(sum);
            $("input[class *= 'net']").each(function(){
            sum += parseFloat($(this).val());
            });
            $(".totalNet").val(sum.toFixed(2));

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
              $(".totalNet").val(sum.toFixed(2));

              var servCharges = parseFloat($('#serveCharges').val());
              
              var nTotal = parseFloat($('#netTotal').val());
              var servePlusNet = parseFloat(servCharges+nTotal);
              $('#servePlusNet').val(servePlusNet.toFixed(2));

              var servNet  = parseFloat($('#servePlusNet').val());
              var discServNet = parseFloat($('#discPerc').val());
              var disc_amt = parseFloat((servNet/100)*discServNet);
              $('#discAmt').val(disc_amt.toFixed(2));


              var disAmt = parseFloat($('#discAmt').val());
              var afterDisc = parseFloat(servNet-disAmt);
              $('#afterDisc').val(afterDisc.toFixed(2));

              var afterDiscAmt = parseFloat($('#afterDisc').val());
              var tax_amt = parseFloat((afterDiscAmt/100)*8.25);
              $('#taxAmt').val(tax_amt.toFixed(2));

              var grand = parseFloat(afterDiscAmt + tax_amt);
              $('#grand').val(grand.toFixed(2));
              $('#serv_total_amount').val(grand.toFixed(2));
              // var adv = parseFloat($('#advAmount').val());
              // var payableAmt =  parseFloat(grand) - parseFloat(adv);
              // parseFloat($('#serv_total_amount').val(payableAmt.toFixed(2)));
          });



    /*=====  End Of Item Detail Block Calculations For Second Row & Onward   ======*/
        
  });

     /*====================================================
        =  Row Insert To Show Total Values Of Item Detail Block =
      ====================================================*/
      $('#newField').append('<tr ><td style="width:125px;"><div style="width:100%;"><b style="float:right; font-size:16px !important;color:#00a65a;margin-top: 7px;">Service Charges $:</b></div></td><td style="width:120px;"><div style="width:100%;"><input type="number" class="form-control " id="serveCharges"  name="serveCharges" value="<?php echo @$data[0]['SERVICE_CHARGES'] ;?>" required></div></td><td style="width:40px;"><div style="width:100%;"></div></td><td style="width:20px;"><div style="width:100%;"></div></td><td style="width:105px;"><div style="width:100%;padding-right:10px;"></div></td><td style="width:95px;"><div style="width:100%;"><b style="float:right; font-size:16px !important;color:#00a65a;margin-top: 7px;">Net Total $:</b></div></td><td style="width:105px;"><div style="width:100%;"><input type="number" class="form-control totalNet" id="netTotal"  name="netTotal" value="0" readonly ></div></td><td style="width:23px;"><div style="width:100%;"></div></td></tr><tr ><td style="width:50px;"><div style="width:100%;"></div></td><td style="width:80px;"><div style="width:100%;"></div></td><td style="width:135px;"><div style="width:100%;"></div></td><td style="width:105px;"><div style="width:100%;padding-right:30px;"></div></td><td style="width:50px;"><div style="width:100%;"></div></td><td style="width:105px;"><div style="width:100%;"><b style="float:right; font-size:16px !important;color:#00a65a;margin-top: 7px;">Service + Net Total $:</b></div></td><td style="width:105px;"><div style="width:100%;"><input type="number" class="form-control " id="servePlusNet"  name="servePlusNet" readonly ></div></td><td style="width:23px;"><div style="width:100%;"></div></td></tr><tr ><td style="width:50px;"><div style="width:100%;"></div></td><td style="width:40px;"><div style="width:100%;"></div></td><td style="width:50px;"><div style="width:100%;"></div></td><td style="width:135px;"><div style="width:100%;"><b style="float:right; font-size:16px !important;color:#00a65a;margin-top: 7px;">Discount %:</b></div></td><td style="width:105px;"><div style="width:100%;"><input type="number" class="form-control " id="discPerc"  name="discPerc" step="0.01" value="<?php echo @$data[0]['DISC_PERC'];?>"></div></td><td style="width:135px;"><div style="width:100%;"><b style="float:right; font-size:16px !important;color:#00a65a;margin-top: 7px;">Disount Amount $:</b></div></td><td style="width:105px;"><div style="width:100%;"><input type="number" class="form-control " id="discAmt"  name="discAmt" step="0.01" value="<?php echo @$data[0]['DISC_AMOUNT'];?>"></div></td><td style="width:23px;"><div style="width:100%;"></div></td></tr><tr ><td style="width:50px;"><div style="width:100%;"></div></td><td style="width:80px;"><div style="width:100%;"></div></td><td style="width:50px;"><div style="width:100%;"></div></td><td style="width:135px;"><div style="width:100%;"></div></td><td style="width:105px;"><div style="width:100%;padding-right:30px;"></div></td><td style="width:135px;"><div style="width:100%;"><b style="float:right; font-size:16px !important;color:#00a65a;margin-top: 7px;">Total Amount $:</b></div></td><td style="width:105px;"><div style="width:100%;"><input type="number" class="form-control" id="afterDisc"  name="afterDisc" readonly ></div></td><td style="width:23px;"><div style="width:100%;"></div></td></tr><tr ><td style="width:50px;"><div style="width:100%;"></div></td><td style="width:40px;"><div style="width:100%;"></div></td><td style="width:50px;"><div style="width:100%;"></div></td><td style="width:135px;"><div style="width:100%;"><b style="float:right; font-size:16px !important;color:#00a65a;margin-top: 7px;">Tax %:</b></div></td><td style="width:105px;"><div style="width:100%;"><input type="number" class="form-control " id="taxPerc"  name="taxPerc" value="8.25" readonly ></div></td><td style="width:135px;"><div style="width:100%;"><b style="float:right; font-size:16px !important;color:#00a65a;margin-top: 7px;">Tax Amount $:</b></div></td><td style="width:105px;"><div style="width:100%;"><input type="number" class="form-control" id="taxAmt"  name="taxAmt" readonly></div></td><td style="width:23px;"><div style="width:100%;"></div></td></tr><tr ><td style="width:50px;"><div style="width:100%;"></div></td><td style="width:80px;"><div style="width:100%;"></div></td><td style="width:50px;"><div style="width:100%;"></div></td><td style="width:135px;"><div style="width:100%;"></div></td><td style="width:105px;"><div style="width:100%;padding-right:30px;"></div></td><td style="width:135px;"><div style="width:100%;"><b style="float:right; font-size:16px !important;color:#00a65a;margin-top: 7px;">Grand Total $:</b></div></td><td style="width:105px;"><div style="width:100%;"><input type="number" class="form-control" id="grand"  name="grand" readonly ></div></td><td style="width:23px;"><div style="width:100%;"></div></td></tr>');

    /*=====  End Row Insert To Show Total Values Of Item Detail Block  ======*/

    

   


    $('.price').on('blur',function(){
        var num = this.id.match(/\d+/);
        var price_i = parseFloat($('#price'+num+'').val());
        var qty_i = parseFloat($('#quantity'+num+'').val());
        var serv_net_price = parseFloat(price_i*qty_i);
        $('#serv_net_price'+num+'').val(serv_net_price.toFixed(2));
        var sum = 0;
        sum = parseFloat(sum);
          $("input[class *= 'net']").each(function(){
          sum += parseFloat($(this).val());
        });
        $(".totalNet").val(sum.toFixed(2));


    });

    //=== Calculated Values Before Edit ====//
    $('.price').each(function(){
      var num = this.id.match(/\d+/);
      var qty = parseFloat($('#quantity'+num+'').val());
      var net_price = $('#serv_net_price'+num+'').val();
      var price = parseFloat(net_price)/parseFloat(qty);
      
      $('#price'+num+'').val(price);
     });

    var netTotal = 0;
    $("input[class *= 'net']").each(function(){
        netTotal += parseFloat($(this).val());// Sum Net Total Amount
      });
    $("#netTotal").val(netTotal.toFixed(2));// net total amount


    var servicePlusNet= 0 ;
    var service = parseFloat($('#serveCharges').val());
    var netTotal = parseFloat($("#netTotal").val());
    servicePlusNet = parseFloat(service) + parseFloat(netTotal);
    $('#servePlusNet').val(servicePlusNet.toFixed(2));

    var discAmt = parseFloat($('#discAmt').val());
    var totalAmount = parseFloat(servicePlusNet) - parseFloat(discAmt);
    parseFloat($('#afterDisc').val(totalAmount.toFixed(2)));

    parseFloat($('#taxPerc').val());

    var taxAmt = parseFloat((parseFloat(totalAmount)/100)*8.25);
    parseFloat($('#taxAmt').val(taxAmt.toFixed(2)));

    var grandTotal = parseFloat(totalAmount) + parseFloat(taxAmt);
    parseFloat($('#grand').val(grandTotal.toFixed(2)));

    var adv = parseFloat($('#advAmount').val());
    var grande = parseFloat(grandTotal) - parseFloat(adv);
   

    parseFloat($('#s_tax_amt').val(taxAmt.toFixed(2)));

    if($('#serv_total_amount').val() == ''){
      parseFloat($('#serv_total_amount').val(grandTotal.toFixed(2)));
    }

    //==== End Calculated Values Before Edit ======//


    $('#serveCharges').on('blur',function(){
      var servCharge = parseFloat($('#serveCharges').val());
      
      var total_Net =  parseFloat($(".totalNet").val());
      var servePlusNet = parseFloat(servCharge+total_Net);
      $('#servePlusNet').val(servePlusNet.toFixed(2));
    });

    $('#discPerc').on('blur',function(){
      
      var discPerc = parseFloat($('#discPerc').val());
      var servePlusNet = parseFloat($('#servePlusNet').val());
      var discountedPer = parseFloat((servePlusNet/100)*discPerc);
      $('#discAmt').val(discountedPer.toFixed(2));

    });

    $('#discAmt').on('blur',function(){
      var discAmt = parseFloat($('#discAmt').val());
      var servePlusNet = parseFloat($('#servePlusNet').val());
      var discountedPer = parseFloat((discAmt/servePlusNet)*100);
      $('#discPerc').val(discountedPer.toFixed(2));
      var afterDisc = parseFloat(servePlusNet-discAmt);
      $('#afterDisc').val(afterDisc.toFixed(2));
      var valAfterDisc = $('#afterDisc').val();
      var taxAmount = parseFloat(valAfterDisc/100)*8.25;
      $('#taxAmt').val(taxAmount.toFixed(2));
      var grandTotal = parseFloat(afterDisc+taxAmount);
      $('#grand').val(grandTotal.toFixed(2));
      $('#serv_total_amount').val(grandTotal.toFixed(2));
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
      $(".totalNet").val(sum.toFixed(2));

      var servCharges = parseFloat($('#serveCharges').val());
      
      var nTotal = parseFloat($('#netTotal').val());
      var servePlusNet = parseFloat(servCharges+nTotal);
      $('#servePlusNet').val(servePlusNet.toFixed(2));

      var servNet  = parseFloat($('#servePlusNet').val());
      var discServNet = parseFloat($('#discPerc').val());
      var disc_amt = parseFloat((servNet/100)*discServNet);
      $('#discAmt').val(disc_amt.toFixed(2));


      var disAmt = parseFloat($('#discAmt').val());
      var afterDisc = parseFloat(servNet-disAmt);
      $('#afterDisc').val(afterDisc.toFixed(2));

      var afterDiscAmt = parseFloat($('#afterDisc').val());
      var tax_amt = parseFloat((afterDiscAmt/100)*8.25);
      $('#taxAmt').val(tax_amt.toFixed(2));

      var grand = parseFloat(afterDiscAmt + tax_amt);
      $('#grand').val(grand.toFixed(2));
      $('#serv_total_amount').val(grand.toFixed(2));
      // var adv = parseFloat($('#advAmount').val());
      // var payableAmt =  parseFloat(grand) - parseFloat(adv);
      // parseFloat($('#serv_total_amount').val(payableAmt.toFixed(2)));
    });

    /*====================================================
    =   Ajax Call to Serialize Array Data in Item Detail       =
     ====================================================*/
     
      

      $('#card_no').hide();
      $('#tenderInput').hide();
      $('#refundInput').hide();

    $('#option1').on('click',function(){
       $('#card_no').hide();
       
       $('#tenderInput').show();
       $('#refundInput').show();
       $('#td_amount').prop('required',true);
       $('#opt1').val('C');
       $('#opt2').val('');
       $('#pos_card_number').prop('required',false);
       
       // $('#save').prop('disabled',true);

       $('#pos_card_number').val('');
       
       var total_Amount = parseFloat($('#afterDisc').val());
       var s_tax_amount = parseFloat($('#s_tax_amt').val());
       var advAmount = parseFloat($('#advAmount').val());
       var toPay = parseFloat(total_Amount)+parseFloat(s_tax_amount)-parseFloat(advAmount);
       parseFloat($('#serv_total_amount').val(toPay.toFixed(2)));


    });

     $('#option2').on('click',function(){
       $('#card_no').show();
       $('#pos_card_number').prop('required',true);
       $('#tenderInput').hide();
       $('#refundInput').hide();
       $('#td_amount').prop('required',false);

       $('#opt1').val('');
       $('#opt2').val('R');
       $('#td_amount').val('');
       // $('#save').prop('disabled',true);

        $('#pos_card_number').on('input',function(){
          $(':input[type="submit"]').prop('disabled',false);
       });
       
       var total_Amount = parseFloat($('#afterDisc').val());
       var s_tax_amount = parseFloat($('#s_tax_amt').val());
       var advAmount = parseFloat($('#advAmount').val());
       var toPay = parseFloat(total_Amount)+parseFloat(s_tax_amount)-parseFloat(advAmount);
       parseFloat($('#serv_total_amount').val(toPay.toFixed(2)));
       
    });


        $('#advAmount').on('input',function(){
      // if(isNaN($('#serv_total_amount').val())){
      //    $('#serv_total_amount').val(0);
      //  }
      // if($('#advAmount').val()=='undefined'){
      //    $('#advAmount').val(0);
      //  }
      if($('#opt1').val() =='' && $('#opt2').val()== '' ){
         $('#tenderInput').show();
         $('#refundInput').show();
         $('#td_amount').prop('required',true);
         $('#opt1').val('C');
         $('#opt2').val('');
         $('#pos_card_number').prop('required',false);

         $('#pos_card_number').val('');
      }
      if($('#opt1').val() =='C' && $('#opt2').val()== '' ){
         $('#tenderInput').show();
         $('#refundInput').show();
         $('#td_amount').prop('required',true);
         $('#opt1').val('C');
         $('#opt2').val('');
         $('#pos_card_number').prop('required',false);

         $('#pos_card_number').val('');
      }
      if($('#opt1').val() =='' && $('#opt2').val()== 'R' ){
         $('#tenderInput').hide();
         $('#refundInput').hide();
         $('#td_amount').prop('required',false);
         $('#opt1').val('');
         $('#opt2').val('R');
         $('#pos_card_number').prop('required',true);

         $('#td_amount').val('');
      }


    });

    if($('#exempt').val() == 1){
      $('#exempt').prop('checked',true);
      // var exempted = parseFloat(grande - taxAmt);
      // $('#serv_total_amount').val(exempted.toFixed(2));
      var x = 0;
      x = parseFloat(x);
      $('#s_tax_amt').val(x.toFixed(2));
      $('#exempt').val(1);
      $('#s_tax').val(x.toFixed(2));
    }

    if($('#exempt').val() == 0){
      $('#exempt').prop('checked',false);

      var x = 8.25;
      x = parseFloat(x);
      $('#s_tax').val(x.toFixed(2));
      $('#s_tax_amt').val(taxAmt.toFixed(2));
      // $('#serv_total_amount').val(grande.toFixed(2));
      $('#exempt').val(0);
    }

    $('#exempt').on('click',function(){
      var checkbox = $('#exempt').prop('checked');
      if(checkbox == true){
            var exempted = parseFloat(grande - taxAmt);
            $('#serv_total_amount').val(exempted.toFixed(2));
            var x = 0;
            x = parseFloat(x);
            $('#s_tax_amt').val(x.toFixed(2));
            $('#exempt').val(1);
            $('#s_tax').val(x.toFixed(2));
            if(isNaN($('#s_tax').val())){
               parseFloat($(this).val(0));
            }
            if(isNaN($('#s_tax_amt').val())){
               parseFloat($(this).val(0));
            }
      }
      if(checkbox == false){
            var x = 8.25;
            x = parseFloat(x);
            $('#s_tax').val(x.toFixed(2));
            $('#s_tax_amt').val(taxAmt.toFixed(2));
            $('#serv_total_amount').val(grande.toFixed(2));
            $('#exempt').val(0);
            // if(isNaN($('#s_tax').val())){
            //    parseFloat($(this).val(0));
            // }
            // if(isNaN($('#s_tax_amt').val())){
            //    parseFloat($(this).val(0));
            // }
      }
    });

    // $('#advanceAmount').hide();

    // $('#advance').on('click',function(){
    //   var checkbox = $('#advance').prop('checked');
    //   if(checkbox == false){
    //     $('#advanceAmount').hide();
    //   }
    //   if(checkbox == true){
    //     $('#advanceAmount').show();
    //   }
    // });

    $('#td_amount').on('blur',function(){
      var tender = parseFloat($('#td_amount').val());
      var net = parseFloat($('#serv_total_amount').val());
      var adv = parseFloat($('#advAmount').val());
      var refunded = parseFloat(tender)-parseFloat(adv);
      $('#serv_refund').val(refunded.toFixed(2));
      if(parseFloat(tender) < parseFloat(adv)){
        alert('Tender amount should be greater than Advance amount !!!');
        $(':input[type="submit"]').prop('disabled',true);
      }else{
        $(':input[type="submit"]').prop('disabled',false);
      }
      
    });


    var phones = [{ "mask": "(###) ###-####"}, { "mask": "(###) ###-##############"}];
    $('#phone_no').inputmask({ 
        mask: phones, 
        greedy: false, 
        definitions: { '#': { validator: "[0-9]", cardinality: 1}} 
    });

    $('#return_date').datepicker();
    

});
      

  </script>
  </form>


 





