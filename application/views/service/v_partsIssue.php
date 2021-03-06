<?php $this->load->view("template/header.php"); ?>

<form action="<?php echo base_url(); ?>service/c_partsIssue/issueParts" method="post"   accept-charset="utf-8" >
   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Parts Issuance Form
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Parts Issuance Form</li>
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
              <h3 class="box-title">Parts Issuance</h3>
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
                   <label for="Receipt Barcode" class="control-label">Receipt Barcode:</label>
                     <input type="number" class="form-control" id="receipt_barcode" name="receipt_barcode" value="<?php 
                     //var_dump($doc_no[0]['DOC_NO']);exit;
                     //echo $doc_no[0]['DOC_NO'];?>">
                  </div>
                  </div>

                <div class="col-sm-2">
                  <div class="form-group">
                   <label for="Issuance No" class="control-label">Issuance No:</label>
                     <input type="text" class="form-control" id="issuance_no" name="issuance_no" value="<?php echo $doc_no[0]['DOC_NO'];?>" readonly>
                     <input type="hidden" name="lz_mt_id" id="servId">
                  </div>
                </div>                  

                <div class="col-sm-2 ">
                  <div class="form-group">
                   <label for="Issuance Date" class="control-label">Issuance Date:</label>
                     <input type="text" class="form-control" id="date" name="doc_date" value="<?php echo date('m/d/Y');?>" data-date-format="mm/dd/yyyy" readonly>
                  </div>
                </div>




                <div class="col-sm-6">
                  <div class="form-group">
                   <label for="Remarks" class="control-label">Remarks:</label>
                    <input class="form-control" name="remarks" id="remarks" >
                     
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
            <h3 class="box-title">Parts Detail</h3>
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
                           <label for="Component" class="control-label">Barcode:</label>
                          <!-- <input type="number" class="form-control" id="quantity" name="quantity[]" value="" > -->
                        </th>
                        <th>
                          <label for="Price" class="control-label">Description:</label>
                          <!-- <input type="text" class="form-control" id="price" name="price[]" value="" > -->
                        </th>
                        <th>
                          <label for="Remarks" class="control-label">Remarks:</label>
                          <!-- <input type="text" class="form-control" id="price" name="price[]" value="" > -->
                        </th>
                       
                      </tr>
                      </thead> 
                      <tbody>
                     <!--  <tr>
                        <td> <input type="number" class="form-control" name="sr_no[]" id="sr_no" value=""> </td>
                        <td><input type="number" class="form-control" name="barcode[]" id="barcode" value=""></td>
                        <td><input type="text" class="form-control" name="description[]" id="description" value=""></td>
                        <td><input type="number" class="form-control" name="qty[]" id="qty" value=""></td>
                        <td><input type="number" class="form-control" name="price[]" id="price" value=""></td>
                      </tr> -->
                      </tbody>
                </table>
                <div class="col-sm-1">
                  <div class="form-group">
                    <button  type="button" class="btn btn-primary" id="add" name="add">+Add Row</button>
                    <!-- <button type="submit" class="btn btn-primary" id="submit">Submit</button> -->
                  </div>
                </div>

              
                 <div class="box-header col-sm-12">
                
                  <h3 class="box-title">Item Detail</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class=""></i>
                    </button>
                  </div> 
                </div>
                <div class="row">
                <div class="col-sm-12">
                 
                  <div class="col-sm-3">
                    <div class="form-group">
                      <label for="PART_UPC" class="control-label" style="color:green;">UPC:</label>
                      <input type="number" id="part_upc" name="part_upc" class="form-control" style="background-color: #E6E6FA;border: 1px solid lightblue;color:green;font-weight: bold; " readonly>
                    </div>
                  </div>

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label for="POS_MPN" class="control-label" style="color:green;">MPN:</label>
                      <input type="text" id="part_mpn" name="part_mpn" class="form-control" style="background-color: #E6E6FA;border: 1px solid lightblue;color:green;font-weight: bold; " readonly>
                    </div>
                  </div>

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label for="Manufacture" class="control-label" style="color:green;">Manufacture:</label>
                      <input type="text" id="part_manufacture" name="part_manufacture" class="form-control" style="background-color: #E6E6FA;border: 1px solid lightblue;color:green;font-weight: bold; " readonly>
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="form-group">
                      <label for="Condition" class="control-label" style="color:green;">Condition:</label>
                      <input type="text" id="part_condition" name="part_condition" class="form-control" style="background-color: #E6E6FA;border: 1px solid lightblue;color:green;font-weight: bold; " readonly>
                    </div>
                  </div>
                  
                </div>

                
              </div>
                <div class="col-sm-12">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <input type="submit" name="save" id="save" class="btn  btn-primary" value="Save">
                      <a href="<?php echo base_url(); ?>service/c_partsIssue/partsIssueDetailView" class="btn btn-primary" >Back</a>
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
         <div class="row">
          <div class="col-sm-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Service Info</h3>
              <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
              </div> 
            </div>
            <div class="box-body">
                <div class="col-sm-12">
                   <div class="col-sm-3">
                      <div class="form-group">
                        <label for="Item Desc" class="control-label">Equipment Desc:</label>
                        <input type="text" class="form-control" id="equip_desc" name="equip_desc" readonly>
                      </div>
                      
                   </div>
                   <div class="col-sm-3">
                      <div class="form-group">
                        <label for="Service Doc Date" class="control-label">Service Doc Date:</label>
                        <input type="text" class="form-control" id="serv_docDate" name="serv_docDate" readonly>
                      </div>
                      
                   </div>
                </div>

                
                <div class="col-sm-12">
                  <div class="col-sm-12">
                    
                  
                  <div class="form-group">
                    <label for="Job Detail" class="control-label">Job Detail:</label>
                      <textarea class="form-control" name="job_detail" id="job_detail" rows="5" readonly></textarea>
                    
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
                <table class="table table-bordered " id="newField">
                    <thead>
                      <tr>
                        <th> 
                            <label for="Sr." class="control-label">Sr No:</label>
                            
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
               
              
            </div>
            
          </div>
          </div>
          
          </div>
          </div>
        

        </div>
        
        </section>
        </div>
        </form>
    <!-- </section>

      
  </div> -->
  <?php $this->load->view("template/footer.php"); ?>

  <script text="javascript">
  $(document).ready(function(){

    var i = 1;


    /*====================================================
      =            Fetch Data From Service            =
      ====================================================*/


    $("#receipt_barcode").blur(function(){
      var barcode = $('#receipt_barcode').val();

      $.ajax({
          dataType: 'json',
          type: 'POST',        
          url:'<?php echo base_url(); ?>service/c_partsIssue/returnFilledData',
          data: { 'barcode' : barcode 
        },
        success: function (data) {
          
            if(data!='error'){
             
              $('#servId').val(data[0].MT_ID);
              $('#serv_docDate').val(data[0].SERV_DATE);
              $('#job_detail').val(data[0].JOB_DETAIL);

              $('#equip_desc').val(data[0].EQUIP_TYPE_DESC);
              var a =1;
              var netPrice = 0;
              var len = data.length;
              for(var i=0;i<len;i++){
                $('#newField').append('<tr ><td style="width:50px;"><div style="width:100%;"><input type="number" class="form-control " id="sr'+a+'" name="sr_no[]" value="'+a+'"  readonly></div></td><td style="width:120px;"><div style="width:100%;"><input class="form-control" type="text" id="component'+a+'" name="component[]"  readonly></div></td><td style="width:50px;"><div style="width:100%;"><input type="number" class="form-control quantity" id="quantities'+a+'"  name="quantities[]" value="" readonly></div></td><td style="width:50px;"><div style="width:100%;"><input type="number" class="form-control price" id="prices'+a+'" step="0.01" name="prices[]" readonly></div></td></tr>');
                $('#component'+a+'').val(data[i].LZ_COMPONENT_DESC);
                $('#quantities'+a+'').val(data[i].QTY);
                $('#prices'+a+'').val(data[i].PRICE);
                netPrice = netPrice + parseFloat($('#price'+a+'').val());
                // alert(netPrice);
                a++;
               }
              
                             
            }
            if(data == 'error'){
                  alert('Parts have already assigned OR | The Item has Returned !');
            }
         }
      });
    });
      
    $('#job_detail').click(function(){
      alert($('#dynamic_field tr').length);
    });
     
    

    /*====================================================
    =            Item/Items by Barcode  Input Block          =
    ====================================================*/
      
      $('#dynamic_field').append('<tr><td style="width:80px;"><div style="width:100%;"> <input type="number" class="form-control dynamic" name="sr_no" id="sr_no" value="1" readonly></div> </td><td style="width:130px;"><div style="width:100%;"><input type="number" class="form-control part_barcode" name="barcode[]" id="barcode'+i+'" value="" required></div></td><td style="250px;"><div style="width:100%;"><input type="text" class="form-control" name="description[]" id="description'+i+'" readonly></div></td><td style="width:190px;"><div stye="width:100%;"><input type="text" class="form-control" name="line_remark[]" id="line_remark'+i+'"></div></td><td style="width:25px;"><button type="button" name="remove" id="button'+i+'" class="btn btn-sm btn-danger btn_remove fa fa-trash-o"></button></td></tr>');
      
      
         $('.btn_remove').on('click',function(){

           var row = $(this).closest('tr');
              var dynamicValue = $(row).find('.dynamic').val();
              dynamicValue = parseInt(dynamicValue);
              row.remove();

              $('.dynamic').each(function(idx, elem){
                $(elem).val(idx+1);
              });
        });
      /*====================================================
        =  Add Button Click To Insert New Row In Item Detail Block =
        ====================================================*/
      $('#add').click(function(){

        i++;

        $('#dynamic_field').append('<tr><td style="width:80px;"><div style="width:100%;"> <input type="number" class="form-control dynamic" name="sr_no" id="sr_no" value="1" readonly></div> </td><td style="width:130px;"><div style="width:100%;"><input type="number" class="form-control part_barcode" name="barcode[]" id="barcode'+i+'" value=""></div></td><td style="250px;"><div style="width:100%;"><input type="text" class="form-control" name="description[]" id="description'+i+'" readonly></div></td><td style="width:190px;"><div stye="width:100%;"><input type="text" class="form-control" name="line_remark[]" id="line_remark'+i+'"></div></td><td style="width:25px;"><button type="button" name="remove" id="button'+i+'" class="btn btn-sm btn-danger btn_remove fa fa-trash-o"></button></td></tr>');

       
        /*====================================================
        =  Item Detail Block Calculations From Second Row Onward  =
        ====================================================*/
        $('.dynamic').each(function(idx, elem){
          $(elem).val(idx+1);
          // console.log($(elem).val(idx+1));
        });

        $('.btn_remove').on('click',function(){

           var row = $(this).closest('tr');
            var dynamicValue = $(row).find('.dynamic').val();
            dynamicValue = parseInt(dynamicValue);
            row.remove();

            $('.dynamic').each(function(idx, elem){
              $(elem).val(idx+1);
            });

            if(($('#dynamic_field tr').length) <2){
              $('#save').prop('disabled',true);
            }

        });

          $('#save').prop('disabled',false);
            

      });
       


    /*====================================================
      =            Item Details by Barcode            =
      ====================================================*/
      $("#dynamic_field").on('blur','.part_barcode',function(){
          var num = this.id.match(/\d+/);
          var part_barcode = $('#barcode'+num+'').val();

          $.ajax({
            dataType: 'json',
            type: 'POST',        
            url:'<?php echo base_url(); ?>service/c_partsIssue/partDetails',
            data: { 'part_barcode' : part_barcode              
          },

          success: function (data) {
              
              if(data!='error' ){
                $('#price'+num+'').val(data[0].COST_PRICE);
                $('#description'+num+'').val(data[0].ITEM_MT_DESC);

                $('#part_purchase_ref').val(data[0].PURCH_REF_NO);
                $('#part_upc').val(data[0].UPC);
                $('#part_mpn').val(data[0].MFG_PART_NO);
                $('#part_manufacture').val(data[0].MANUFACTURER);
                var condition = data[0].ITEM_CONDITION;
                if(!isNaN(condition)){
                  if(condition == 3000){condition = 'Used';}
                  else if(condition == 1000){condition = 'New';}
                  else if(condition == 1500){condition = 'New other';}
                  else if(condition == 2000){condition = 'Manufacturer Refurbished';}
                  else if(condition == 2500){condition = 'Seller Refurbished';}
                  else if(condition == 7000){condition = 'For Parts or Not Working';}
                  else{condition = 'Used';}
                  $('#part_condition').val(condition);
                } 
                
                              
              }
              if(data == 'error'){
                alert('The barcode has already used !');
              }
            }
        });
      });


    $('#return_date').datepicker();
    

  
});

  </script>
  <!-- </form> -->


 





