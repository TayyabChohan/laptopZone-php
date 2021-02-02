<?php $this->load->view('template/header'); 
      
?>
 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Creatre Object
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Create Object</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12"> 
<!-- 
  warehouse mt form insertion  start-->
       <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"> Create ObjectDetail</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
          <div class="box-body">
            <form action="<?php echo base_url().'catalogueToCash/c_card_lots/add_lot_special_object'; ?>" method="post" accept-charset="utf-8">   
            

                <div class="col-sm-3">
                        <label >Category Id</label>
                        <div class="form-group">
                        <input type="number" name="category_id" id="category_id" class="form-control"  required>
                      </div>
                </div>
                <div class="col-sm-2">
                        <label >Object Name</label>
                        <div class="form-group">
                        <input type="text" name="obj_name" id="obj_name" class="form-control"  required>
                      </div>
                </div>
                <div class="col-sm-2">
                        <label >Service</label>
                        <div class="form-group">
                        
                        <select class="form-control" id="ship_serv" name="ship_serv"  required value="<?php //echo @$data_get['result'][0]->SHIPPING_SERVICE; ?>" required>
                    <option value="USPSParcel" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSParcel' ){echo "selected='selected'";} ?>>USPSParcel</option>
                    <option value="USPSFirstClass" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSFirstClass' ){echo "selected='selected'";} ?>>USPS First Class</option>
                    <option value="USPSPriority" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriority' ){echo "selected='selected'";} ?>>USPS Priority Mail</option>
                    <option value="FedExHomeDelivery" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'FedExHomeDelivery' ){echo "selected='selected'";} ?>>FedEx Ground or FedEx Home Delivery</option> 
                    <option value="USPSPriorityFlatRateEnvelope" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityFlatRateEnvelope' ){echo "selected='selected'";} ?>>USPS Priority Flat Rate Envelope</option>
                    <option value="USPSPriorityMailSmallFlatRateBox" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityMailSmallFlatRateBox' ){echo "selected='selected'";} ?>>USPS Priority Mail Small Flat Rate Box</option> 
                    <option value="USPSPriorityFlatRateBox <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityFlatRateBox' ){echo "selected='selected'";} ?>">USPS Priority Mail Medium Flat Rate Box</option>
                    <option value="USPSPriorityMailLargeFlatRateBox" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityMailLargeFlatRateBox' ){echo "selected='selected'";} ?>>USPS Priority Mail Large Flat Rate Box</option> 
                    <option value="USPSPriorityMailPaddedFlatRateEnvelope"<?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityMailPaddedFlatRateEnvelope' ){echo "selected='selected'";} ?>>USPS Priority Mail Padded Flat Rate Envelope</option>
                    <option value="USPSPriorityMailLegalFlatRateEnvelope" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityMailLegalFlatRateEnvelope' ){echo "selected='selected'";} ?>>USPS Priority Mail Legal Flat Rate Envelope</option>
                     
                  </select> 

                      </div>
                </div>
                <div class="col-sm-2">
                        <label >Cost</label>
                        <div class="form-group">
                        <input type="number" name="obj_cost" id="obj_cost" class="form-control"  required>
                      </div>
                </div>
                <div class="col-sm-2">
                        <label >Weight (oz)</label>
                        <div class="form-group">
                        <input type="number" name="obj_weig" id="obj_weig" class="form-control"  required>
                      </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">      
                    <label for="">Keyword:</label>
                    <input type='text' class="form-control" name="title" id="title" />
                    <a class="crsr-pntr" title="Click here for category suggestion" id="Suggest_Categories_for_title">Suggest Category Against Keyword</a>
                  </div>
                </div>
                <div class="col-sm-12">
                </div>
                <!-- Category Result -->
            <div id="Categories_result">
            </div>            
            <!-- Category Result --> 
              <div class="col-sm-2 ">
                    <div class="form-group">
                      <label  class="control-label"></label>                  
                       <input type="submit" title="Save Object" id="save_obj" name = "save_obj" class="btn btn-success form-control" value ="Save Object">     
                     
                    </div>
              </div>                                                      
                                    
          
            </form>                                              
             
          </div>
         </div>

         <div class ="row">
      <div class ="col-sm-12">
        <div class="box">
          <div class="box-header with-border">
              
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>

            </div>

            <div class="box-body form-scroll">
              <div class="col-sm-12">

                <table id="merch_table" class="table table-responsive table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                          <th>Object Name</th>
                          <th>Category</th>
                          <th>Shippin Service</th>
                          <th>Weight</th>
                          <th>Cost</th>
                                            
                      
                    </tr>
                  </thead>
                  <tbody>
                        <?php //echo "<pre>" ;
                        //print_r($get_stat['get_merchants']);?>
                      <tr>
                        <?php foreach($data['obj'] as $get_obj) :?>
                     
                      
                      <td><?php echo @$get_obj['OBJECT_NAME'];?></td>
                      <td><?php echo @$get_obj['CATEGORY_ID'];?></td>                      
                      <td><?php echo @$get_obj['SHIP_SERV'];?></td>                      
                      <td><?php echo @$get_obj['WEIGHT'];?></td>                      
                      <td><?php echo @$get_obj['ITEM_COST'];?></td>                      
                      
                      
                     
                      </tr>
                        <?php endforeach; ?>
                       
                        
                        
                      </tbody>
                </table>              
                            
              </div>
              
            </div>
        </div>
        
      </div>
      
    </div>

        </div>
      </div>


    </section>
 
    <!-- /.content -->
  </div>  


 <?php $this->load->view('template/footer'); ?>

 
  <script>
$(document).ready(function()
  {
     $('#merch_table').DataTable({
    "oLanguage": {
    "sInfo": "Total Records: _TOTAL_"
  },
  "iDisplayLength": 50,
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
     //"order": [[ 0, "ASC" ]],
    "info": true,
    "autoWidth": true,
    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
  });
          
});

 	$('#purch_date').datepicker();
 	$('#merch_act_to').datepicker();
 	
 </script>