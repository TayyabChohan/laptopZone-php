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
 
 label.btn span {
  font-size: 1.5em ;
}

label input[type="radio"] ~ i.fa.fa-circle-o{
    color: #c8c8c8;    display: inline;
}
label input[type="radio"] ~ i.fa.fa-dot-circle-o{
    display: none;
}
label input[type="radio"]:checked ~ i.fa.fa-circle-o{
    display: none;
}
label input[type="radio"]:checked ~ i.fa.fa-dot-circle-o{
    color: #7AA3CC;    display: inline;
}
label:hover input[type="radio"] ~ i.fa {
color: #7AA3CC;
}

label input[type="checkbox"] ~ i.fa.fa-square-o{
    color: #c8c8c8;    display: inline;
}
label input[type="checkbox"] ~ i.fa.fa-check-square-o{
    display: none;
}
label input[type="checkbox"]:checked ~ i.fa.fa-square-o{
    display: none;
}
label input[type="checkbox"]:checked ~ i.fa.fa-check-square-o{
    color: #7AA3CC;    display: inline;
}
label:hover input[type="checkbox"] ~ i.fa {
color: #7AA3CC;
}

div[data-toggle="buttons"] label.active{
    color: #7AA3CC;
}

div[data-toggle="buttons"] label {
display: inline-block;
padding: 6px 12px;
margin-bottom: 0;
font-size: 14px;
font-weight: normal;
line-height: 2em;
text-align: left;
white-space: nowrap;
vertical-align: top;
cursor: pointer;
background-color: none;
border: 0px solid 
#c8c8c8;
border-radius: 3px;
color: #c8c8c8;
-webkit-user-select: none;
-moz-user-select: none;
-ms-user-select: none;
-o-user-select: none;
user-select: none;
}

div[data-toggle="buttons"] label:hover {
color: #7AA3CC;
}

div[data-toggle="buttons"] label:active, div[data-toggle="buttons"] label.active {
-webkit-box-shadow: none;
box-shadow: none;
}
#contentSec{
  display: none;
}
#objectSection{
  display: none;
} 

</style> 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Lot Items To Estimate
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard/dashboard"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Lot Items To Estimate</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content"> 

      <!-- Find LOT Item or single item -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Find Item</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
            <div class="box-body">
              <div class="col-sm-12">
                <div class="col-sm-4">
                  <div class="form-group p-t-24" id="findItemMessage">
                    
                  </div>
                </div>
                 <div class="col-sm-8">
                  <div class="form-group">
                    <a target="_blank" href="<?php echo base_url('itemsToEstimate/c_itemsToEstimate/lotsReprt');?>" class="pull-right">Lot Estimate Report</a>
                  </div>
                </div>
              </div>
             
              <div class="col-sm-12">
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="Market Place" class="control-label">Market Place:</label>
                    <select class="selectpicker form-control market_place" data-live-search ="true" id="market_place"  name="market_place">
                      <?php 
                      foreach ($markets as $market) {
                        if ($market['PORTAL_ID'] == 1) {
                          $selected = "selected";
                        }else{
                          $selected = "";
                        }
                      ?>
                      <option value="<?php echo $market['PORTAL_ID']; ?>" <?php echo $selected; ?> ><?php echo $market['PORTAL_DESC']; ?></option>
                      <?php 
                        }
                      ?>
                    </select>
                  </div>
                </div>
                <div id="market_ebay" style="display: none;">
                <div class="col-sm-3">
                  <div class="form-group">
                    <label>eBay ID:</label>
                    <input type="number" class="form-control" name="ebay_id" id="ebay_id" value="" placeholder="Enter eBay ID">
                  </div>
                </div>

                 <div class="col-sm-1">
                  <div class="form-group p-t-24">
                    <input type="button" class="btn btn-sm btn-primary" name="find_item" id="find_item"  value="Find Item">
                  </div>
                </div>
              </div>
                <div class="col-sm-1">
                  <div class="form-group p-t-24">
                    <input type="button" class="btn btn-sm btn-info pull-right" name="add_market_place" id="add_market_place"  value="Add Market">
                  </div>
                </div>
                <div id="add_new_market" style="display: none;">
                <div class="col-sm-3">
                  <div class="form-group">
                    <label>Market Name:</label>
                    <input type="text" class="form-control" name="market_name" id="market_name" value="<?php if(isset($_POST['market_name'])){ echo $_POST['market_name']; }?>" placeholder="Enter Market Name">
                  </div>
                </div>
                <div class="col-sm-1">
                  <div class="form-group p-t-24">
                    <input type="button" class="btn btn-sm btn-success pull-right" name="save_market" id="save_market"  value="Save Market">
                  </div>
                </div>
              </div>
               

              </div>
              <div id="except_ebay" style="display: none;">
                <div class="col-sm-12">
                  <div class="col-sm-6">
                  <div class="form-group p-t-24" id="item_message">
                    
                  </div>
              </div>
              </div>
              
              <div class="col-md-12"><!-- Custom Tabs -->
                 
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="Ref. No" class="control-label">Ref. No:</label>
                    <input type="number" name="ref_no" id="ref_no" placeholder="Enter Ref No" class="form-control ref_no" value="<?php if(isset($_POST['ref_no'])){ echo $_POST['ref_no']; }?>">
                  </div>
                </div>

                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="Item Description" class="control-label">Item Description:</label>
                    <input type="text" name="item_description" id="item_description"  class="form-control item_description" value="">
                  </div>
                </div>

                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="Start Date" class="control-label">Start Date:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                        <input type="text" class="form-control" id="start_date" name="start_date" value="<?php echo date('m/d/Y');?>" data-date-format="mm/dd/yyyy" required>
                    </div>
                  </div>              
                </div>

                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="End Date" class="control-label">End Date:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                        <input type="text" class="form-control" id="end_date" name="end_date" value="<?php echo date('m/d/Y');?>" data-date-format="mm/dd/yyyy" required>
                    </div>
                  </div>              
                </div> 
              </div>

              <div class="col-sm-12">
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="List Price" class="control-label">List Price:</label>
                    <input type="text" name="list_price" id="list_price" placeholder="List Price" class="form-control list_price" value="">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                  <label for="Item URl" class="control-label">Item Url</label>
                  <input type="text" name="item_url" id="item_url" class="form-control item_url" placeholder="Enter Item URL" value="<?php if(isset($_POST['item_url'])){ echo $_POST['item_url']; }?>">
                </div>
                </div>
                 <div class="col-sm-2">
                  <div class="form-group p-t-24">
                    <input type="button" class="btn btn-sm btn-primary" name="save_items" id="save_items"  value="save">
                  </div>
                </div>
              </div>
            </div>
              <!-- Brand, MPN, and button section start -->
              <div class="col-sm-12">
                 <div class="col-sm-3">
                  <div class="form-group" id="get_brands">
                  </div>
                </div>

                <div class="col-sm-3">
                  <div class="form-group" id="appendMpnlist">

                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group p-t-24" id="verifyButton">
                    
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group p-t-24" id="fetchObjects">
                    
                  </div>
                </div>                
                <div class="col-sm-2">
                  <div class="form-group p-t-24" id="addMpnbutton">
                    
                  </div>
                </div>                

                 
              </div>
              <!-- Brand, MPN, and button section end -->

              <!-- Objects block start -->
                <div class="col-sm-12" id="objectSection">
                  <div class="col-sm-2">
                    <div class="form-group" id="objDropdown">  
                        
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group" id="inpBrand">

                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group" id="inpKeyword">

                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group p-t-24" id="findMpn">
                    </div>
                  </div>                                     

                  <div class="col-sm-2">
                    <div class="form-group" id="objMpns">
                    </div>
                  </div>

                  <div class="col-sm-12">
                    <div class="form-group p-t-26">
                      <input type="button" id="saveMPN" name="saveMPN" value="Verify" class="btn btn-success">
                    </div>
                  </div>
                </div>                

              <!-- Objects block end -->  
              <!-- add mpn block start -->
                <div class="col-sm-12" id="contentSec">
                  <div class="col-sm-2">
                    <div class="form-group" id="cataObject">
                      <label for="Conditions" class="control-label">OBJECT:</label>
                      <input class="form-control" type="text" name="mpn_object" id="mpn_object" value="" required>  
                        
                    </div>
                  </div>

                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="MPN BRAND">BRAND:</label>
                      <input class="form-control" type="text" name="mpn_brand" id="mpn_brand" value="" required>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="MPN">MPN:</label>
                      <input class="form-control" type="text" name="mpn_input" id="mpn_input" value="" required>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <span>
                        <label for="MPN">MPN DESCRIPTION : </label>Maximum of 80 characters - 
                        <input class="c-count" type="text" id='titlelengths' name="titlelengths" size="3" maxlength="3" value="80" readonly style=""> characters left</span><br/>
                        <input type="text" name="mpn_description" id="mpn_description" class="form-control mpn_description" onKeyDown="textCounter(this,80);" maxlength="80" onKeyUp="textCounter(this,'titlelengths' ,80)"  value="" style="width: 540px;">
                    </div>
                  </div>

                  <div class="col-sm-12">
                    <div class="form-group p-t-26">
                      <input type="button" id="save_mpn" name="save_mpn" value="Save" class="btn btn-success">
                    </div>
                  </div>
                </div>
              <!-- add mpn block end -->  
              <div class="col-sm-12">
                <div id="resultTable">
                </div>
              </div>  
              <!-- Verified title option end -->
              <div class="col-sm-12">  
              </div>
            </div>
          </div>   
        <!-- Find LOT Item and single item end -->

        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Search Ebay Id</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
            <div class="box-body"> 
              <form action="<?php echo base_url().'itemsToEstimate/c_itemsToEstimate'; ?>" method="post" accept-charset="utf-8">   
              
             <div class="col-sm-3">
                  <div class="form-group">
                    <label>Search eBay ID:</label>
                    <input type="number" class="form-control" name="serch_ebay_id" id="serch_ebay_id" VALUE="<?php echo  $this->session->userdata('get_ebay_id');?>"" placeholder="Enter eBay ID Or Barcode No">
                  </div>
                </div> 

                 <div class="col-sm-1">
                  <div class="form-group p-t-24">
                    <input type="submit" class="btn btn-sm btn-primary" name="search_itm" id="search_itm"  value="Search Ebay Id ">
                  </div>
                </div>
             </form>
                <!-- /.col --> 

                </div>
              <!-- /.box-body -->
             
            </div>


        <!-- Add Title Expression Start  -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Lot Items to Estimate</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
            <div class="box-body"> 
              <!-- <div class="col-sm-12">
                <div class="col-sm-4">
                  <div class="form-group" id="assignItemMessage">
                  </div>                  
                </div>
              </div> -->
              <div class="col-md-12 form-scroll"><!-- Custom Tabs -->
                <table id="lotItems" class="table table-responsive table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>ACTION</th>
                      <th>EBAY ID</th>
                      <th>TITLE</th>
                      <th>CATEGORY ID</th>
                      <?php 
                        $user_id = @$this->session->userdata('user_id');
                        if($user_id == 2 || $user_id == 17 || $user_id == 5 || $user_id == 21){ 
                      ?>
                      <th>ASSIGN ITEMS</th>
                      <?php } ?>
                      <th>LOT/KIT</th>
                      <th>CONDITION</th>
                      <th>SALE PRICE</th>
                     
                      <th>TIME LEFT</th>
                      <th>ESTIMATE STATUS</th>
                      
                      <th>ESTIMATE PRICE</th>
                      <th>INSERTED DATE</th>
                      
                      <th>PLACE BID/OFFER</th>
                      <th>STATUS</th>
                      <?php if($user_id == 2 || $user_id == 17 || $user_id == 5 || $user_id == 21){ ?>
                      <th>ESTIMATE TIME</th>
                      <th>SELLER ID</th>
                      <?php } ?>
                    </tr>
                  </thead>
                </table>              
                    <!-- nav-tabs-custom -->
                  </div>
                   <input type="hidden" name="countData" id="countData" value="<?php //echo $i-1; ?>">
                <!-- /.col --> 

                </div>
              <!-- /.box-body -->
              <div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
                <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="ajax loader" style="width: 100px; height: 100px;">
            </div>
            </div>
        <!-- /.col -->
      </section>
      <!-- /.row -->
  <!-- Trigger the modal with a button -->
  <!-- Modal --> 
    <!-- /.content -->
  </div>    

    <!-- /.row -->

  <!-- Place Bid/Offer section start -->
<!-- Modal -->
<div id="makeOffer" class="modal modal-info fade" role="dialog" style="width: 100%;">
    <div class="modal-dialog" style="width: 70%;">
        <!-- Modal content-->
        <div class="modal-content" style="width: 100%;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Place Bid/Offer</h4>
            </div>
            <div class="modal-body">
                <section class="content"> 
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="col-sm-2">
                        <div class="form-group">
                          <label for="Estimate Offer">Estimate Offer</label>
                          <input type="text" name="estimate_offer" id="estimate_offer" class="form-control" value="" readonly>
                        </div>
                      </div>
                    </div>                    
                    <div class="col-sm-12">
                      <div class="col-sm-2">
                        <div class="form-group">
                          <label for="Offer Amount">Offer Amount:</label>
                          <input type="number" class="form-control" name="offer_amount" id="offer_amount" value="">
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="Remarks">Remarks:</label>
                          <input type="text" class="form-control" name="remarks" id="remarks" value="">
                        </div>
                      </div>                      
                      <div class="col-sm-1">
                        <div class="form-group p-t-24">
                          <input type="hidden" name="lz_cat_id" id="lz_cat_id" value=""> 
                          <input type="hidden" name="lz_bd_catag_id" id="lz_bd_catag_id" value="">                          
                          <input type="button" class="btn btn-sm btn-success save_offer" name="save_offer" id="save_offer" value="Save">
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group text-center emptyDiv">
                          <div id="printMessage">
                          </div>
                        </div>                        
                      </div>                      
                    </div>
                    <div class="col-sm-12" id="after_bidoffer">
                      <div class="col-sm-2">
                        <input type="hidden" name="offer_id_save" id="offer_id_save" value="">
                        <div class="form-group" id="statusDropdownSave">
                           
<!--                           <label for="Bid/Offer Status">Bid/Offer Status</label>
                          <select name="bid_status" id="bid_status" class="form-control bid_status">
                            <option value="default">-SELECT-</option>
                            <option value="1">WON</option>
                            <option value="0">LOST</option>
                          </select> -->
                        </div>
                      </div>

                      <div class="col-sm-2">
                        <div class="form-group" id="trackingNumberSave">
                          
                        </div>
                        
                      </div>                       

                      <div class="col-sm-2">
                        <div class="form-group" id="saleAmountSave">

                        </div>
                      </div>
                     
                      <div class="col-sm-2">
                        <div class="form-group p-t-26" id="saveStatusSave">

                        </div>
                      </div>

                      <div class="col-sm-3">
                        <div class="form-group" id="bidingStatusMessageSave">
                          
                        </div>
                      </div>

                    </div>                    
                  </div>
                </section>
            </div>
            <div class="modal-footer">
              <button type="button" id="closeModal" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- detail modal end -->
<!-- Place Bid/Offer section end -->

  <!-- Update Bid/Offer section start -->
<!-- Modal -->
<div id="updateOffer" class="modal modal-info fade" role="dialog" style="width: 100%;">
    <div class="modal-dialog" style="width: 70%;">
        <!-- Modal content-->
        <div class="modal-content" style="width: 100%;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Bid/Offer</h4>
            </div>
            <div class="modal-body">
                <section class="content"> 
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="col-sm-2">
                        <div class="form-group">
                          <label for="Estimate Offer">Estimate Offer</label>
                          <input type="text" name="update_estimate_offer" id="update_estimate_offer" class="form-control" value="" readonly>
                        </div>
                      </div>
                    </div>                    
                    <div class="col-sm-12">
                      <div class="col-sm-2">
                        <div class="form-group">
                          <label for="Offer Amount">Offer Amount:</label>
                          <input type="hidden" name="update_offer_id" id="update_offer_id" value="">
                          <input type="hidden" name="update_lz_cat_id" id="update_lz_cat_id" value=""> 
                          <input type="hidden" name="update_lz_bd_catag_id" id="update_lz_bd_catag_id" value="">                           
                          <input type="number" class="form-control" name="update_offer_amount" id="update_offer_amount" value="">
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="Remarks">Remarks:</label>
                          <input type="text" class="form-control" name="update_remarks" id="update_remarks" value="">
                        </div>
                      </div>                      
                      <div class="col-sm-1">
                        <div class="form-group p-t-24">
                          <input type="hidden" name="offer_id" id="offer_id" value="">                          
                          <input type="button" class="btn btn-sm btn-success update_offer" name="update_offer" id="update_offer" value="Update">
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group text-center emptyDiv">
                          <div id="updatePrintMessage">
                          </div>
                        </div>                        
                      </div>                      
                    </div>
                    <div class="col-sm-12">
                      <div class="col-sm-2">
                        <div class="form-group" id="statusDropdown">
                          <label for="Bid/Offer Status">Bid/Offer Status</label>
                          <select name="bid_status" id="bid_status" class="form-control bid_status">
                            <option value="default">----SELECT----</option>
                            <option value="1">WON</option>
                            <option value="0">LOST</option>
                          </select>
                        </div>
                      </div>

                      <div class="col-sm-2">
                        <div class="form-group" id="trackingNumber">
                          
                        </div>
                        
                      </div>                       

                      <div class="col-sm-2">
                        <div class="form-group" id="saleAmount">

                        </div>
                      </div>
                     
                      <div class="col-sm-2">
                        <div class="form-group p-t-26" id="saveStatus">

                        </div>
                      </div>

                      <div class="col-sm-3">
                        <div class="form-group" id="bidingStatusMessage">
                          
                        </div>
                      </div>

                    </div>
                  </div>
                </section>
            </div>
            <div class="modal-footer">
              <button type="button" id="closeModal" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- detail modal end -->
<!-- Update Bid/Offer section end -->

<!-- Deletion or Rejection Remarks start -->

<div id="discard_item" class="modal " role="dialog" style="width: 100%;">
  <div class="modal-dialog" style="width: 50%;">
    <!-- Modal content-->
    <div class="modal-content" style="width: 100%;">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Deletion or Rejection Item Remarks</h4>
      </div>
      <div class="modal-body">
        <section class="content">
          <div class="col-sm-12">
            <div class="form-group">
              <label for="seller_desc">Remarks: </label>
              <textarea rows="4" cols="50" name="rejection_remarks" class="form-control" id="rejection_remarks" value=""></textarea>
            </div>            
          </div>
           <div class="col-sm-12">
          <div class='col-sm-4 hide_component'>
                <label style="color: red" >Select Discard Remarks:</label>
                <div class="form-group" id="dis_remarks">   
                </div>
              </div>
          <div class="col-sm-2">
            <div class="form-group">
              <input type="hidden" name="del_lz_bd_cata_id" id="del_lz_bd_cata_id" value="">
              <input type="button" class="btn btn-primary btn-sm discardItem" name="discardItem" id="discardItem" value="Save">
            </div>
          </div> 
         </div>

        </section>                  
      </div>
      <div class="modal-footer">
        <button type="button" id="closeModal" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>         
        <!-- <button type="button" id="saveModal" class="btn btn-outline" data-dismiss="modal">Save</button> -->
      </div>
            
    </div>
  </div>

</div>

<!-- Deletion or Rejection Remarks end -->


  <!-- Trigger the modal with a button -->
    <div id="myModal" class="modal modal-info fade" role="dialog" style="width: 100%;">
      <div class="modal-dialog" style="width: 50%;">
        <!-- Modal content-->
        <div class="modal-content" style="width: 100%;">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Seller Notes</h4>
          </div>
          <div class="modal-body">
            <section class="content"> 
              <label for="seller_desc">Seller Desc :</label>
              <span>Maximum of 3800 characters - 
                <input class="c-count" type="text" id='titlelength' name="titlelength" size="3" maxlength="3" value="3800" readonly style=""> characters left</span><br/>
              <textarea rows="4" cols="50" name="seller_description" class="form-control" id="textarea" value="<?php echo htmlentities(''); ?>" onKeyDown="textCounter(this,3800);" maxlength="3800" onKeyUp="textCounter(this,'titlelength' ,3800)"></textarea>         

            </section>                  
          </div>
          <div class="modal-footer">
              <button type="button" id="closeModal" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>         
              <button type="button" id="saveModal" class="btn btn-outline" data-dismiss="modal">Save</button>
          </div>
                
        </div>
      </div>
    
    </div>


    <div id="success-modal" class="modal modal-success fade" role="dialog" style="width: 100%;">
      <div class="modal-dialog" style="width: 50%;height: 50%;">
        <!-- Modal content-->
        <div class="modal-content" style="width: 100%; ">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Seller Notes</h4>
          </div>
          <div class="modal-body" style="height: 80px !important;">
            <section class="" > 
              <p> Seller description updated successfully</p>         

            </section>                  
          </div>
          <div class="modal-footer">
              <button type="button" id="closeSuccess" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>         

          </div>
                
        </div>
      </div>
    
    </div> 
<!-- End Listing Form Data -->
<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>
<script>
var dataTable = '';
$(document).ready(function(){
  $("#market_ebay").show();
    dataTable = $('#lotItems').DataTable( { 
      "oLanguage": {
      "sInfo": "Total Records: _TOTAL_",
      //"sPaginationType": "full_numbers",
      
    },
    // For stop ordering on a specific column
    // "columnDefs": [ { "orderable": false, "targets": [0] }],
    // "pageLength": 5,
     "iDisplayLength": 25,
      "aLengthMenu": [[25, 50, 100, 200,500, -1], [25, 50, 100, 200,500, "All"]],
       
       "paging": true,
      "lengthChange": true,
      "searching": true,

      "ordering": true,
      "Filter":true,
      // "iTotalDisplayRecords":10,
      //"order": [[ 8, "desc" ]],
      // "order": [[ 16, "ASC" ]],
      "info": true,
      // "autoWidth": true,
      //"dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
      "bProcessing": true,
      "bRetrieve":true,
      "bDestroy":true,
      "bServerSide": true,
      ///////////////////////////
      "autoWidth": true,
      "sScrollY": "600px",
      "sScrollX": "100%",
      "sScrollXInner": "150%",
      "bScrollCollapse": true,
      "bPaginate": true, 
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
      "fixedHeader": true,
    ///////////////////////////////
      // "bAutoWidth": false,
      "ajax":{
        url :"<?php echo base_url().'itemsToEstimate/c_itemsToEstimate/lotsData' ?>", // json datasource
        type: "post"  // method  , by default get
        // data: {},
        
        },
        "columnDefs":[{
            "target":[0],
            "orderable":false
          }
        ],
        "createdRow": function( row, data, dataIndex){
            if(data){
                $(row).find(".updateEst").closest( "tr" ).addClass('rowBg');
                }
              }

      });
   // new $.fn.dataTable.FixedHeader(dataTable);

/*====Estimate Report Table Start ======*/

/*=====END OF ESTIMATE REPORT TABLE ======*/
$(document).on('change', "#market_place", function(){
var market_place = this.value;
if (market_place == 1) {
  $("#except_ebay").hide();
  $("#market_ebay").show();
}else{
  $("#except_ebay").show();
  $("#market_ebay").hide();
}
});
$(document).on('click', '#add_market_place', function(){
  $("#add_new_market").toggle();
});

  /*==================================================
  =            FOR ADDING KIT COMPONENTS             =
  ===================================================*/
  $('body').on('click', '#save_items', function(){
    var ref_no              = $("#ref_no").val(); 
    var item_description    = $("#item_description").val(); 
    var start_date          = $("#start_date").val(); 
    var end_date            = $("#end_date").val(); 
    var list_price          = $("#list_price").val(); 
    var item_url            = $("#item_url").val(); 
    //console.log(ref_no, item_description, start_date, end_date, list_price, item_url); return false;
    if (ref_no === '' || ref_no === null) 
    { 
         $("#item_message").html("");
          $("#item_message").html("<div style='font-size: 16px; font-weight: bold; color: #9F6000; background-color: #FEEFB3; padding: 10px; border-radius: 5px;'>Warning: Refrerence No is required.</div>"); 
          setTimeout(function(){ $("#item_message").html('');}, 3000);
            return false; 
    }  
    if (item_description === '' || item_description === null) 
    { 
         $("#item_message").html("");
          $("#item_message").html("<div style='font-size: 16px; font-weight: bold; color: #9F6000; background-color: #FEEFB3; padding: 10px; border-radius: 5px;'>Warning: Item description is required.</div>"); 
          setTimeout(function(){ $("#item_message").html('');}, 3000);
            return false; 
    } 
    if (start_date === '' || start_date === null) 
    { 
         $("#item_message").html("");
          $("#item_message").html("<div style='font-size: 16px; font-weight: bold; color: #9F6000; background-color: #FEEFB3; padding: 10px; border-radius: 5px;'>Warning: Start date is required.</div>"); 
          setTimeout(function(){ $("#item_message").html('');}, 3000);
            return false; 
    }
     if (end_date === '' || end_date === null) 
    { 
         $("#item_message").html("");
          $("#item_message").html("<div style='font-size: 16px; font-weight: bold; color: #9F6000; background-color: #FEEFB3; padding: 10px; border-radius: 5px;'>Warning: End date is required.</div>"); 
          setTimeout(function(){ $("#item_message").html('');}, 3000);
            return false; 
    }

  //console.log(ct_tracking_no, ct_cost_price, lz_bd_catag_id, lz_cat_id); return false;
  $(".loader").show();
  $.ajax({

    type: 'POST',
    url: '<?php echo base_url() ?>itemsToEstimate/c_itemsToEstimate/saveItems',
    data: {
      'ref_no': ref_no,
      'item_description': item_description,
      'start_date': start_date,
      'end_date': end_date,
      'list_price': list_price,
      'item_url': item_url

    },
    dataType: 'json',
    success: function (data) {
      $(".loader").hide();
         if(data == 1){
          $("#item_message").html("");
          $("#item_message").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Success:Item is saved.</div>");
            setTimeout(function(){ $("#item_message").fadeOut(2000); }, 3000);
            /*window.open(
                      '<?php //echo base_url() ?>itemsToEstimate/c_itemsToEstimate/lotEstimate/'+ref_no+'/1/'+111222333444,
                      '_blank' // <- This is what makes it open in a new window.
                    );*/
            window.location.reload();
         }else if(data == 2){
          $(".loader").hide();

          $("#item_message").html("");
          $("#item_message").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Error: Item is not saved.</div>");
            setTimeout(function(){ $("#item_message").fadeOut(2000);}, 3000);            
         }else if(data == 3){
          $(".loader").hide();
          $("#item_message").html("");
          $("#item_message").html("<div style='font-size: 16px; font-weight: bold; color: #00529B; background-color: #BDE5F8; padding: 10px; border-radius: 5px;'>Item is already exist with this Ref no.</div>"); 
          setTimeout(function(){ $("#item_message").fadeOut(2000);}, 3000);
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

});
 /*==================================================
  =            FOR ADDING KIT COMPONENTS             =
  ===================================================*/
  $('body').on('click', '#save_market', function(){

    var market_name = $("#market_name").val(); 
    if (market_name === '' || market_name === null){ 
        alert('Market name is required'); 
        // cancel submit
        return false;
    }  

  //console.log(ct_tracking_no, ct_cost_price, lz_bd_catag_id, lz_cat_id); return false;
  $(".loader").show();
  $.ajax({

    type: 'POST',
    url: '<?php echo base_url() ?>itemsToEstimate/c_itemsToEstimate/saveMarket',
    data: {
      'market_name': market_name
    },
    dataType: 'json',
    success: function (data) {
      $(".loader").hide();
         if(data == 1){
            alert("Success: Market is inserted!");   
         }else if(data == 2){
           alert('Error: Fail to insert Market!');
         }else if(data == 3){
            alert("Warning: Market already exist");
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
  /*==================================================
  =           FOR UPDATING KIT COMPONENTS             =
  ===================================================*/
  /*==================================================
  =            FOR ADDING KIT COMPONENTS             =
  ===================================================*/
  $('body').on('click', '.save_tracking_no', function(){
    //this.disabled = true;
    var rowId=$(this).attr('id');
    //alert(rowId); return false;

    var ct_tracking_no = $("#ct_tracking_no_"+rowId).val(); 
    var ct_cost_price = $("#ct_cost_price_"+rowId).val(); 
    var lz_bd_catag_id = $("#lz_bd_catag_id_"+rowId).val(); 
    var lz_cat_id = $("#lz_cat_id_"+rowId).val(); 
    if (ct_tracking_no.length === 0 || ct_cost_price.length === 0) 
    { 
        alert('Tracking no and cost price are required'); 
        // cancel submit
        return false;
    }  

  //console.log(ct_tracking_no, ct_cost_price, lz_bd_catag_id, lz_cat_id); return false;
  $(".loader").show();
  $.ajax({

    type: 'POST',
    url: '<?php echo base_url() ?>itemsToEstimate/c_itemsToEstimate/saveTrackingNo',
    data: {
      'ct_tracking_no': ct_tracking_no,
      'ct_cost_price': ct_cost_price,
      'lz_bd_catag_id': lz_bd_catag_id,
      'lz_cat_id': lz_cat_id
    },
    dataType: 'json',
    success: function (data) {
      $(".loader").hide();
         if(data ==true){
           //window.location.href = '<?php //echo base_url(); ?>BundleKit/c_bkProfiles';
               alert("Success: Tracking no. is inserted!");   
               //window.location.reload(); 
         }else if(data == false){
           alert('Error: Fail to insert Tracking No!');
           //window.location.reload();
         }else if(data == "exist"){
            alert("Warning: Tracking No already exist.");   
               //window.location.reload();
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
  /*==================================================
  =           FOR UPDATING KIT COMPONENTS             =
  ===================================================*/
    $("body").on('click', '.update_mpn_data', function(){
    //this.disabled = true;
    var rowId=$(this).attr('id');
    var trackingId=$(this).attr('tId');
    //alert(trackingId); return false;
    var ct_tracking_no = $("#ct_tracking_no_"+rowId).val(); 
    var ct_cost_price = $("#ct_cost_price_"+rowId).val(); 
    var lz_bd_catag_id = $("#lz_bd_catag_id_"+rowId).val(); 
    var lz_cat_id = $("#lz_cat_id_"+rowId).val(); 
    if (ct_tracking_no.length === 0 || ct_cost_price.length === 0) 
    { 
        alert('Tracking no and cost price are required'); 
        // cancel submit
        return false;
    }  
//console.log(ct_tracking_no, ct_cost_price, lz_bd_catag_id, lz_cat_id); return false;
  $(".loader").show();
  $.ajax({

    type: 'POST',
    url: '<?php echo base_url() ?>itemsToEstimate/c_itemsToEstimate/updateTrackingNo',
    data: {
      'trackingId': trackingId,
      'ct_tracking_no': ct_tracking_no,
      'ct_cost_price': ct_cost_price,
      'lz_bd_catag_id': lz_bd_catag_id,
      'lz_cat_id': lz_cat_id
    },
    dataType: 'json',
    success: function (data) {
      $(".loader").hide();
         if(data == 1){
           //window.location.href = '<?php //echo base_url(); ?>BundleKit/c_bkProfiles';
               alert("Success: Tracking number is updated!");  
               //window.location.reload(); 
         }else if(data == 0){
            alert('Error: Failed to update Tracking number!');
           //window.location.reload();
         }else if(data == 2){
            alert('Warning: Sorry! This tracking no has been posted.');
           //window.location.reload();
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
   /*==================================================
  =           FOR UPDATING KIT COMPONENTS             =
  ===================================================*/

  $(document).on('click', '.discard_item', function(){
  //var es_status = $('#es_status').val();  

      
      $('.hide_component').show();
      $('.hide_component1').show();
      $.ajax({
      url:'<?php echo base_url(); ?>catalogueToCash/c_purchasing/get_status_remarks',
      type:'post',
      dataType:'json',
      
      success:function(data){
        console.log(data);
       // return false;
        var flag = [];
         // alert(data.length);return false;
        for(var i = 0;i<data.get_flag.length;i++){
          flag.push('<option value="'+data.get_flag[i].FLAG_ID+'">'+data.get_flag[i].FLAG_NAME+'</option>')
        }
        $('#dis_remarks').html("");
        $('#dis_remarks').append('<select name="discard_remarks" id="discard_remarks" class="form-control discard_remarks selectpicker" data-live-search="true" required><option value="">---select---</option>'+flag.join("")+'</select>');
        $('.discard_remarks').selectpicker();
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


$(document).on('click','.discard_item',function(){
  $('#discard_item').modal('show');
  var rowId = $(this).attr('id');
  //console.log(rowId); return false;
  var lz_bd_catag_id = $("#del_lz_bd_cata_id").val(rowId);
  var remarks = $("#rejection_remarks").val();

});

// $("body").on('click','.flag-trash', function() {
$(document).on('click','#discardItem',function(){  

  var lz_bd_cata_id = $("#del_lz_bd_cata_id").val();
  var remarks = $("#rejection_remarks").val();
  var discard_remarks = $("#discard_remarks").val();
  //console.log(lz_bd_catag_id, remarks); return false;


    $(".loader").show();
    $.ajax({
        url: '<?php echo base_url(); ?>itemsToEstimate/c_itemsToEstimate/trashResultRow', //maintains the (controller/function/argument) logic in the MVC pattern
        type: 'post',
        dataType: 'json',
         data : {'lz_bd_cata_id':lz_bd_cata_id, 'remarks': remarks, 'discard_remarks': discard_remarks},
        success: function(data){
          $(".loader").hide();
            if(data == true){
              $(".loader").hide();
              $('#discard_item').modal('hide');
              var row=$("#"+lz_bd_cata_id);
              //debugger;     
              row.closest('tr').fadeOut(1000, function() {
              row.closest('tr').remove();
              });

              //window.location.reload();
             //$('#'+id).remove();
            }else if(data == false){
              alert("Error! Result not deleted.")
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


/*=====================================================
=            pop-up for seller description            =
=====================================================*/
 var ebayLink = '';
 var track_no = '';
 $(document).on('click','.seller',function(){
  var num_id = this.id.match(/\d+/);
  $('#textarea').val('');
  ebayLink = $('#link'+num_id+'').attr('href');
  track_no = $('#ct_tracking_no_'+num_id+'').val();
  $('#titlelength').val(3800);
  $('#myModal').modal('show');
  // $('#success-modal').modal('show');

    $.ajax({
      dataType: 'json',
      type: 'POST',
      url:'<?php echo base_url(); ?>itemsToEstimate/c_itemsToEstimate/getSellerDescription',  
      data:{'track_no':track_no},
      success : function(data){
        // console.log(data);
        var abc = data[0].SELLER_DESCRIPTION;
        var num = abc.indexOf('\n')-8;
        var string = abc.substr(8, num); 
        // console.log(string);
        $('#textarea').val(string);
      }
    });
 });

$('#saveModal').on('click',function(){
  var value = $('#textarea').val();
  // alert(track_no);return false;
  // alert(ebayLink);
  var part2 = ebayLink.split('/');
  var lastSegment = part2.pop() || part2.pop();
  // alert(lastSegment);
  var seller_notes = 'Notes : '+value+'  \n Click : <a href='+ebayLink+'>here</a> to open original Listing';
  // alert(seller_notes);return false;

  $.ajax({
    dataType: 'json',
    type: 'POST',
    url:'<?php echo base_url(); ?>itemsToEstimate/c_itemsToEstimate/updateSellerDescription',  
    data:{'seller_notes':seller_notes,'track_no':track_no},
    success : function(data){
      $(".loader").hide();
      if(data == 1){
        $('#myModal').modal('hide');
        $('#success-modal').modal('show');
      }
      // alert('seller description updated');
    },
      error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
    }  
  });

  
});
 
$('#closeModal').on('click',function(){
  $('#myModal').modal('hide');
});   

$('#closeSuccess').on('click',function(){
   $('#success-modal').modal('hide');
});
/*=====  End of pop-up for seller description  ======*/ 

/*=======================================
=        Place Bid/Offer start          =
=======================================*/
$('#closeModal').on('click',function(){
  $('#makeOffer').modal('hide');
  $('#updateOffer').modal('hide');
  $('#discard_item').modal('hide');
}); 

/*================================================
=            Save Bidding Offer            =
================================================*/
$(document).on('click','.makeOffer',function(){
  $('#makeOffer').modal('show');
  var rowId = $(this).attr('value');
  var cat_id = $("#lz_cat_id_"+rowId).val();
  $("#lz_cat_id").val(cat_id);
  var lz_bd_catag_id = $("#lz_bd_catag_id_"+rowId).val();
  $("#lz_bd_catag_id").val(lz_bd_catag_id);  
  var lot_offer_amount = $("#lot_offer_amount_"+rowId).text();
  //alert(lot_offer_amount);
  $("#estimate_offer").val('');
  $("#remarks").val('');
  $("#estimate_offer").val(lot_offer_amount);
  $("#offer_amount").val('');
  $("#after_bidoffer").hide();
  //console.log($("#estimate_offer").val(lot_offer_amount));
});

$(document).on('click','.save_offer',function(){

    var rowId = $(this).attr('value');
    var bidding_offer = $("#offer_amount").val();
    var lz_bd_catag_id = $("#lz_bd_catag_id").val(); 
    var cat_id = $("#lz_cat_id").val();
    var remarks = $("#remarks").val();
    
    // console.log(bidding_offer+" - " + lz_bd_catag_id +" - "+cat_id);
    //  return false; 
    if (bidding_offer.length === 0) 
    { 
      alert('Bidding Offer is required'); 
      return false;
    }  

  $(".loader").show();
  $.ajax({

    type: 'POST',
    url: '<?php echo base_url() ?>itemsToEstimate/c_itemsToEstimate/saveBiddingOffer',
    data: {
      'bidding_offer': bidding_offer,
      'lz_bd_catag_id': lz_bd_catag_id,
      'cat_id': cat_id,
      'remarks': remarks
    },
    dataType: 'json',
    success: function (data) {
      $("#after_bidoffer").show();
      //console.log(data); return false;
      $(".loader").hide();

         if(data == "" || data != null){
            $("#printMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Success: Bidding Offer is saved.</div>");
            setTimeout(function(){ $("#printMessage").html('');}, 3000);

            /*====== Add tracking No and Cost option after saving Bidd offer start =======*/            
            $("#statusDropdownSave").html("");
            $("#offer_id_save").val(data);
            $("#statusDropdownSave").append('<label for="Bid/Offer Status">Bid/Offer Status</label> <select name="bid_status" id="bid_status" class="form-control bid_status instant_change"> <option value="default">----SELECT----</option> <option value="1" selected>WON</option> <option value="0">LOST</option> </select>');

            $("#saleAmountSave").html("");
            $("#saveStatusSave").html("");
            $("#trackingNumberSave").html("");
            $("#trackingNumberSave").append('<label for="Tracking Number">Tracking Number:</label> <input type="text" class="form-control" name="tracking_number" id="tracking_number" value="">');
            $("#saleAmountSave").append('<label for="Cost">Cost:</label> <input type="number" class="form-control" name="sale_amount" id="sale_amount"  value="" placeholder="$ Enter Amount in Number">');
            $("#saveStatusSave").append('<input type="button" class="btn btn-sm btn-success" name="instant_save" id="instant_save" value="Save Status">');
            /*====== Add tracking No and Cost option after saving Bidd offer end =======*/
           // alert("Success: Bidding Offer is saved.");   
           // window.location.reload(); 
         }else if(data == 2){
           $(".loader").hide();
            $("#printMessage").html("<div style='font-size: 16px; font-weight: bold; color: #dd4b39; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Error: Bidding Offer is not saved.</div>");
            setTimeout(function(){ $("#printMessage").html('');}, 3000);           
           //alert('Error: Bidding Offer is not saved.');

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

/*=====  End of Save Bidding Offer  ======*/

/*================================================
=  Get Bidding Offer and Update Bidding Offer Start  =
================================================*/
$(document).on('click','.updateOffer',function(){
  //$('#updatOffer').modal('show');
  var rowId = $(this).attr('value');
  var offer_id = $("#offer_id_"+rowId).attr('value');
  var cat_id = $("#lz_cat_id_"+rowId).val();
  $("#update_lz_cat_id").val(cat_id);
  var lz_bd_catag_id = $("#lz_bd_catag_id_"+rowId).val();
  $("#update_lz_bd_catag_id").val(lz_bd_catag_id);
  var tracking_id = $("#tracking_id_"+rowId).val();
  var lot_offer_amount = $("#lot_offer_amount_"+rowId).text();
  //alert(lot_offer_amount);
  $("#update_estimate_offer").val(lot_offer_amount);  

  //console.log(tracking_id);return false;
  //alert(offer_id);return false;
  
  $(".loader").show();
  $.ajax({

    type: 'POST',
    url: '<?php echo base_url() ?>itemsToEstimate/c_itemsToEstimate/getBiddingOffer',
    data: {
      'offer_id': offer_id,
      'tracking_id': tracking_id
    },
    dataType: 'json',
    success: function (data) {
      //console.log(data); 
      //console.log(data.offer_data[0].OFFER_ID); return false;
      console.log(data.tracking_data);
      if(data.tracking_data != 0){
        var tracking_no = data.tracking_data[0].TRACKING_NO;
        
        if(tracking_no == "" || tracking_no == null || tracking_no == undefined){
          tracking_no = "";
        }
        var cost_price = data.tracking_data[0].COST_PRICE;
        if(cost_price == "" || cost_price == null){
          cost_price = "";
        }
      }
      console.log(tracking_no);
      if(data.offer_data != 0){
        var bid_status = data.offer_data[0].WIN_STATUS;
        var sold_amount = data.offer_data[0].SOLD_AMOUNT;
        if(sold_amount == "" || sold_amount == null){
          sold_amount = "";
        }
      }
      $(".loader").hide();
      if(data){
        $('#updateOffer').modal('show');
        $('#update_offer_id').val(data.offer_data[0].OFFER_ID);
        $('#update_offer_amount').val(data.offer_data[0].OFFER_AMOUNT);
        $('#update_remarks').val(data.offer_data[0].REMARKS);

        
        $("#statusDropdown").html("");
        var selected = "";
        if(bid_status == 0){
          selected = "selected";
          $("#statusDropdown").append('<label for="Bid/Offer Status">Bid/Offer Status</label> <select name="bid_status" id="bid_status" class="form-control bid_status"> <option value="default">----SELECT----</option> <option value="1" >WON</option> <option value="0" '+selected+'>LOST</option> </select>');          
        }else if(bid_status == 1){
          selected = "selected";
          $("#statusDropdown").append('<label for="Bid/Offer Status">Bid/Offer Status</label> <select name="bid_status" id="bid_status" class="form-control bid_status"> <option value="default">----SELECT----</option> <option value="1" '+selected+' >WON</option> <option value="0">LOST</option> </select>');          
        }else{
          selected = "";
        }
              

        if(bid_status == 0){
          $("#saleAmount").html("");
          $("#saveStatus").html("");
          $("#trackingNumber").html("");
          $("#saleAmount").append('<label for="Sale Amount">Sale Amount:</label> <input type="number" class="form-control" name="sale_amount" id="sale_amount" value="'+sold_amount+'" placeholder="$ Enter Amount in Number">');
          $("#saveStatus").append('<input type="button" class="btn btn-sm btn-success" name="save_status" id="save_status" value="Update Status">');
        }else if(bid_status == 1){
          $("#saleAmount").html("");
          $("#saveStatus").html("");
          $("#trackingNumber").html("");
          $("#trackingNumber").append('<label for="Tracking Number">Tracking Number:</label> <input type="text" class="form-control" name="tracking_number" id="tracking_number" value="'+tracking_no+'">');

          $("#saleAmount").append('<label for="Cost">Cost:</label> <input type="number" class="form-control" name="sale_amount" id="sale_amount"  value="'+cost_price+'" placeholder="$ Enter Amount in Number">');
          $("#saveStatus").append('<input type="button" class="btn btn-sm btn-success" name="save_status" id="save_status" value="Update Status">');
        }else if(bid_status == 2){
          $("#saleAmount").html("");
          $("#trackingNumber").html("");
        }else{
          $("#statusDropdown").html("");
          $("#saleAmount").html("");
          $("#saveStatus").html("");
          $("#trackingNumber").html("");
          $("#saleAmount").append('<label for="Sale Amount">Sale Amount:</label> <input type="number" class="form-control" name="sale_amount" id="sale_amount" value="" placeholder="$ Enter Amount in Number">');
          $("#saveStatus").append('<input type="button" class="btn btn-sm btn-primary" name="save_status" id="save_status" value="Save Status">');
          $("#statusDropdown").append('<label for="Bid/Offer Status">Bid/Offer Status</label> <select name="bid_status" id="bid_status" class="form-control bid_status"> <option value="default">----SELECT----</option> <option value="1" >WON</option> <option value="0">LOST</option> </select>');           
        }      

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

$(document).on('click','.update_offer',function(){

    var update_offer_id = $('#update_offer_id').val();
    var update_offer_amount = $("#update_offer_amount").val();
    var update_remarks = $("#update_remarks").val(); 
    var bid_status = $("#bid_status").val(); 
    // console.log(update_offer_id+" - " + update_offer_amount +" - "+update_remarks); return false; 
    if (update_offer_amount.length === 0) { 
      alert('Bidding Offer is required'); 
      return false;
    }  

  $(".loader").show();
  $.ajax({

    type: 'POST',
    url: '<?php echo base_url() ?>itemsToEstimate/c_itemsToEstimate/reviseBiddingOffer',
    data: {
      'update_offer_id': update_offer_id,
      'update_offer_amount': update_offer_amount,
      'update_remarks': update_remarks,
      'bid_status': bid_status,

    },
    dataType: 'json',
    success: function (data) {
      //console.log(data); return false;
      $(".loader").hide();
         if(data == 1){
            $("#updatePrintMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Success: Bidding Offer is Updated.</div>");
            setTimeout(function(){ $("#updatePrintMessage").html('');}, 3000);

               // alert("Success: Bidding Offer is saved.");   
               // window.location.reload(); 
         }else if(data == 2){
           $(".loader").hide();
            $("#updatePrintMessage").html("<div style='font-size: 16px; font-weight: bold; color: #dd4b39; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Error: Bidding Offer is not Updated.</div>");
            setTimeout(function(){ $("#updatePrintMessage").html('');}, 3000);           
           //alert('Error: Bidding Offer is not saved.');

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

/*=====  End of Get Bidding Offer and Update Bidding Offer Start  ======*/

/*=====  Start of TextCounter for title 80 characters limit ======*/ 
function textCounter(field,cnt, maxlimit) {         
  var cntfield = document.getElementById(cnt) 
     if (field.value.length > maxlimit) // if too long...trim it!
    field.value = field.value.substring(0, maxlimit);
    // otherwise, update 'characters left' counter
    else
    cntfield.value = maxlimit - field.value.length;
}

/*=====  End of TextCounter for title 80 characters limit ======*/ 

/*============================================
=            Find LOT Items             =
============================================*/

  $('body').on('click', '#find_item', function(){

    var ebay_id = $("#ebay_id").val();
    //var lotItemCheck = $("input[name='lotItemCheck']:checked").val(); 
    //console.log(lotItemCheck);return false;
    //console.log(ebay_id.length);return false;
    if(ebay_id.length === 0){
      alert('Please Input eBay Id.'); 
      return false;      
    }else if(ebay_id.length != 12){
      alert('Please Input correct eBay Id.');
      return false;
    }  
    //console.log(offer_id +" - "+bidding_offer);return false;
  $(".loader").show();
  $.ajax({

    type: 'POST',
    url: '<?php echo base_url() ?>itemsToEstimate/c_itemsToEstimate/lotItemDownload',
    data: {'ebay_id': ebay_id}, //'lotItemCheck':lotItemCheck
    dataType: 'json',
    success: function (data) {
      //console.log(data); return false;
      $(".loader").hide();
      //console.log(data);return false;
         if(data == 1){
          $("#findItemMessage").html("");
          $("#findItemMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Item is saved as a Lot Item.</div>");
            setTimeout(function(){ $("#findItemMessage").html('');}, 3000);            
          //console.log("Title is moved.");
          location.reload();
         }else if(data == 2){
           $(".loader").hide();

          $("#findItemMessage").html("");
          $("#findItemMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Error: Item is not saved.</div>");
            setTimeout(function(){ $("#findItemMessage").html('');}, 3000);            
           //console.log("Title is not moved.");

         }else if(data == 3){
           $(".loader").hide();

          $("#findItemMessage").html("");
          $("#findItemMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Item date time is updated.</div>");
            setTimeout(function(){ $("#findItemMessage").html('');}, 3000);            
           //console.log("Title is not moved.");

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

/*=====  End of Find LOT item  ======*/

/*=======================================================================
=            On change of Brand show MPN            =
=======================================================================*/
$('body').on('change', '#brand', function(){
  var category_id = $("#category_id").val();
  var brand_name = $("#brand option:selected").text();
      $(".loader").show();
    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>biddingItems/c_biddingItems/get_mastermpn',
      data: { 'category_id' : category_id, 'brand_name':brand_name},
     success: function (data) {
      $(".loader").hide();
        if(data){
            var mpn = [];
            for(var i = 0;i<data.length;i++){
              mpn.push('<option value="'+data[i].CATALOGUE_MT_ID+'">'+data[i].MPN+'</option>');
            }
            $("#appendMpnlist").html("");
            $("#verifyButton").html("");
            $("#fetchObjects").html("");
            $("#addMpnbutton").html("");

            $("#appendMpnlist").append('<label>Select MPN:</label> <select name="verifiedmpn" id="verifiedmpn" class="form-control selectpicker" data-live-search="true">' + mpn.join("") + '</select>'); 
            $('.selectpicker').selectpicker();
            $("#verifyButton").append('<input type="button" class="btn btn-success btn-md btn-block" name="verifyTitle" id="verifyTitle" value="Verify">');
            $("#fetchObjects").append('<input type="button" class="btn btn-warning btn-md btn-block" name="objects" id="objects" value="Fetch Objects">');
            $("#addMpnbutton").append('<input type="button" class="btn btn-primary btn-md btn-block" id="mpnContent" value="Add MPN">');

        }else{
          console.log('Error! No Data Found.');
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

//toggle MPN Section
 
$('body').on('click', '#mpnContent', function(){  
  $('#contentSec').toggle();
});  
/*=====  End of On change of Brand show MPN  ======*/

// $('body').on('click', '#objects', function(){  
//   $('#objectSection').toggle();
// }); 
/*=======================================================================
=            On click on fetch object button fetch object list            =
=======================================================================*/
$('body').on('click', '#objects', function(){
  $('#get_brands').hide();
  $('#appendMpnlist').hide();
  $('#verifyButton').hide();
  $('#objectSection').show();
  
  var category_id = $("#category_id").val();
  //alert(category_id); return false;

      $(".loader").show();
    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>biddingItems/c_biddingItems/get_Objects',
      data: { 'category_id' : category_id},
     success: function (data) {
      $(".loader").hide();
        if(data){
            var objects = [];
            for(var i = 0;i<data.length;i++){
              objects.push('<option value="'+data[i].OBJECT_ID+'">'+data[i].OBJECT_NAME+'</option>');
            }
            $("#objDropdown").html("");
            $("#objDropdown").append('<label>Select Object:</label> <select name="objlist" id="objlist" class="form-control selectpicker" data-live-search="true">' + objects.join("") + '</select>'); 
            $('.selectpicker').selectpicker();
            // add inputs and button for search mpn
            $("#inpBrand").append('<label>Type Brand:</label> <input type="text" name="type_brand" id="type_brand" class="form-control" >'); 
            $("#inpKeyword").append('<label>Type Keyword:</label> <input type="text" name="type_keyword" id="type_keyword" class="form-control" >'); 
            $("#findMpn").append('<input type="button" name="search_mpn" id="search_mpn" class="btn btn-block btn-sm btn-primary" value="Find MPN">');

        }else{
          console.log('Error! No Data Found.');
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
 
/*=====  End of On click on fetch object button fetch object list  ======*/

/*=======================================================================
=             on change object dropdown fetch MPN list            =
=======================================================================*/
$('body').on('click', '#search_mpn', function(){
  
  var category_id = $("#category_id").val();
  var type_brand = $("#type_brand").val();
  var type_keyword = $("#type_keyword").val();
  var object_id = $("#objlist option:selected").val();

  $(".loader").show();
  $.ajax({
    dataType: 'json',
    type: 'POST',        
    url:'<?php echo base_url(); ?>biddingItems/c_biddingItems/get_objectWiseMpn',
    data: { 'category_id' : category_id, 'object_id':object_id, 'type_brand':type_brand, 'type_keyword':type_keyword},
   success: function (data) {
    $(".loader").hide();
      if(data){
          var mpn = [];
          for(var i = 0;i<data.length;i++){
            mpn.push('<option value="'+data[i].CATALOGUE_MT_ID+'">'+data[i].MPN+'</option>');
          }

          $("#objMpns").html("");

          $("#objMpns").append('<label>Select MPN:</label> <select name="mpnlist" id="mpnlist" class="form-control selectpicker" data-live-search="true">' + mpn.join("") + '</select>'); 
          $('.selectpicker').selectpicker();

      }else{
        console.log('Error! No Data Found.');
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
 
/*=====  End of  on change object dropdown fetch MPN list  ======*/

/*=======================================================================
=            onclick save mpn            =
=======================================================================*/

$('body').on('click', '#saveMPN', function(){
  var category_id = $("#category_id").val();
  var mpn = $("#mpnlist option:selected").val();
  var ebay_id = $("#verify_ebay_id").val();
    if(ebay_id.trim() == ''){
    alert('Please add ebay id');
    return false;
  }
  //var lz_bd_cata_id = $("#lz_bd_cata_id").val();
  //console.log(category_id +" - "+verifiedmpn+" - "+verify_ebay_id); return false;
      $(".loader").show();
    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>biddingItems/c_biddingItems/saveAndVerifyMpn',
      data: { 'category_id' : category_id, 'mpn':mpn, 'ebay_id': ebay_id              
    },
     success: function (data) {
      $(".loader").hide();
        if(data){
          alert('Sucess! Title is verified.');
          location.reload();
        }else{
          alert('Error! Title is not verified.');
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

/*=====  End of Onload show mpn cateogires wise  ======*/

/*=======================================================================
=            Onload show mpn cateogires wise            =
=======================================================================*/

$('body').on('click', '#verifyTitle', function(){
  var category_id = $("#category_id").val();
  var verifiedmpn = $("#verifiedmpn").val();
  var verify_ebay_id = $("#verify_ebay_id").val();
    if(verify_ebay_id.trim() == ''){
    alert('Please add ebay id');
    return false;
  }
  //var lz_bd_cata_id = $("#lz_bd_cata_id").val();
  //console.log(category_id +" - "+verifiedmpn+" - "+verify_ebay_id); return false;
      $(".loader").show();
    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>biddingItems/c_biddingItems/verifyMPN',
      data: { 'category_id' : category_id, 'verifiedmpn':verifiedmpn, 'verify_ebay_id': verify_ebay_id              
    },
     success: function (data) {
      $(".loader").hide();
        if(data){
          alert('Sucess! Title is verified.');
          location.reload();
        }else{
          alert('Error! Title is not verified.');
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

/*=====  End of Onload show mpn cateogires wise  ======*/

/*=========================================
=            save mpn function            =
=========================================*/
$(document).on('click', '#save_mpn', function(event) {
  event.preventDefault();
  var category_id =   $("#category_id").val();
  var mpn_object = $("#mpn_object").val();
  var mpn_brand = $("#mpn_brand").val();
  var mpn_input = $("#mpn_input").val();
  var mpn_description = $("#mpn_description").val();
  var verify_ebay_id = $("#verify_ebay_id").val();
      
  if(category_id.trim() == ''){
    alert('Please select category id');
    return false;
  }else if(mpn_object.trim() == ''){
    alert('Please add object');
    $("#mpn_object").focus();
    return false;
  }else if(mpn_brand.trim() == ''){
    alert('Please add brand');
    $("#mpn_brand").focus();
    return false;
  }else if(mpn_input.trim() == ''){
    alert('Please add MPN');
    $("#mpn_input").focus();
    return false;
  }else if(mpn_description.trim() == ''){
    alert('Please add MPN Description');
    $("#mpn_description").focus();
    return false;
  }
 var url = '<?php echo base_url();?>biddingItems/c_biddingItems/saveMpn';
 $(".loader").show();
 $.ajax({
   url: url,
   type: 'POST',
   dataType: 'json',
   data: {'category_id': category_id ,  'mpn_object': mpn_object, 'mpn_brand':mpn_brand, 'mpn_input':mpn_input, 'mpn_description':mpn_description, 'verify_ebay_id':verify_ebay_id},
    success:function(data){
        if (data == 2) {
          $(".loader").hide();
          alert("MPN is already exist");
          //location.reload();
        }else if(data == 1){
          $(".loader").hide();
          alert("MPN is added and verified");
          location.reload();          
        }else if(data == 0){
          $(".loader").hide();
          alert("Error! MPN is not verified");          
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
 })
   });


/*=====  End of save mpn function  ======*/

/*============================================
=            Assign Lot Items to Users             =
============================================*/

  $('body').on('click', '.assignToUser', function(){

    var index = $(this).attr("value"); 
    var user_id = $("#user_name_"+index).val();
    var lz_bd_cata_id = $("#lz_bd_cata_id_"+index).val();
    
    if(user_id.length === 0){
      alert('Please Select user for Assign.'); 
      return false;      
    }else{

      $(".loader").show();
      $.ajax({

        type: 'POST',
        url: '<?php echo base_url() ?>itemsToEstimate/c_itemsToEstimate/AssignItems',
        data: {'user_id': user_id, 'lz_bd_cata_id':lz_bd_cata_id},
        dataType: 'json',
        success: function (data) {
          //console.log(data); return false;
          $(".loader").hide();
             if(data == 1){
              // $("#assignItemMessage").html("");
              // $("#assignItemMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Item is assigned to selected user.</div>");
              //   setTimeout(function(){ $("#assignItemMessage").html('');}, 3000);   
              alert('Success - Item is assigned to selected user.');         

             }else if(data == 2){
               $(".loader").hide();

              // $("#assignItemMessage").html("");
              // $("#assignItemMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Error: Item is not assigned.</div>");
              //   setTimeout(function(){ $("#assignItemMessage").html('');}, 3000);  
              alert('Error - Item is NOT assigned to selected user.');           
               //console.log("Title is not moved.");

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
    }//else closing  


  
  }); 

/*=====  End of Assign Lot Items to Users  ======*/

/*============================================
=            Assign Lot Items to Users             =
============================================*/

  $('body').on('click', '.UnassignToUser', function(){

    var index = $(this).attr("value"); 
    var user_id = $("#user_name_"+index).val();
    var lz_bd_cata_id = $("#lz_bd_cata_id_"+index).val();
    
    if(user_id.length === 0){
      alert('Please Select user for Assign.'); 
      return false;      
    }else{

      $(".loader").show();
      $.ajax({

        type: 'POST',
        url: '<?php echo base_url() ?>itemsToEstimate/c_itemsToEstimate/UnAssignItems',
        data: {'user_id': user_id, 'lz_bd_cata_id':lz_bd_cata_id},
        dataType: 'json',
        success: function (data) {
          //console.log(data); return false;
          $(".loader").hide();
             if(data == 1){
              // $("#assignItemMessage").html("");
              // $("#assignItemMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Item is Un-Assigned to selected user.</div>");
              //   setTimeout(function(){ $("#assignItemMessage").html('');}, 3000);            
                alert('Success - Item is Un-Assigned to selected user.'); 
             }else if(data == 2){
               $(".loader").hide();

              // $("#assignItemMessage").html("");
              // $("#assignItemMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Error: Item is not Un-Assigned.</div>");
              //   setTimeout(function(){ $("#assignItemMessage").html('');}, 3000);   
                alert('Error - Item is Not Un-Assigned to selected user.');         
               //console.log("Title is not moved.");

             }else if(data == 3){
              
              $(".loader").hide();
              alert("Warning: Item can't be Un-Assigned. Estimate is exist against this item.");

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
    }//else closing  


  
  }); 

/*=====  End of Assign Lot Items to Users  ======*/
/*================================================
=   Start Onchange append input number fields    =
================================================*/
$(document).on('change','.bid_status',function(){
  var bid_status = $("#bid_status").val();
  var offer_id =  $("#update_offer_id").val();
  var lz_bd_catag_id =  $("#update_lz_bd_catag_id").val();

  //console.log(offer_id);
  if(bid_status == 0){

 /*======Incase of Lost on change status start ======*/

    $.ajax({

      type: 'POST',
      url: '<?php echo base_url() ?>itemsToEstimate/c_itemsToEstimate/getSoldAmount',
      data: {
        'offer_id': offer_id
      },
      dataType: 'json',
      success: function (data) {
        //console.log(data); 
        //console.log(data.offer_data[0].OFFER_ID); return false;
        
        if(data.sold_data != 0){
          var sold_amount = data.sold_data[0].SOLD_AMOUNT;
          if(sold_amount == "" || sold_amount == null || sold_amount == undefined){
            sold_amount = "";
          }

          $("#statusDropdown").html("");
          var selected = "";
          if(bid_status == 0){
            selected = "selected";
            $("#statusDropdown").append('<label for="Bid/Offer Status">Bid/Offer Status</label> <select name="bid_status" id="bid_status" class="form-control bid_status"> <option value="default">----SELECT----</option> <option value="1" >WON</option> <option value="0" '+selected+'>LOST</option> </select>');          
          }else if(bid_status == 1){
            selected = "selected";
            $("#statusDropdown").append('<label for="Bid/Offer Status">Bid/Offer Status</label> <select name="bid_status" id="bid_status" class="form-control bid_status"> <option value="default">----SELECT----</option> <option value="1" '+selected+' >WON</option> <option value="0">LOST</option> </select>');          
          }else{
            selected = "";
          }
                  
          $("#saleAmount").html("");
          $("#saveStatus").html("");
          $("#trackingNumber").html("");
          $("#saleAmount").append('<label for="Sale Amount">Sale Amount:</label> <input type="number" class="form-control" name="sale_amount" id="sale_amount" value="'+sold_amount+'" placeholder="$ Enter Amount in Number">');
          $("#saveStatus").append('<input type="button" class="btn btn-sm btn-success" name="save_status" id="save_status" value="Update Status">');      

        }else{
          $("#saleAmount").html("");
          $("#saveStatus").html("");
          $("#trackingNumber").html("");
          $("#saleAmount").append('<label for="Sale Amount">Sale Amount:</label> <input type="number" class="form-control" name="sale_amount" id="sale_amount" value="" placeholder="$ Enter Amount in Number">');
          $("#saveStatus").append('<input type="button" class="btn btn-sm btn-primary" name="save_status" id="save_status" value="Save Status">');         
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
/*======Incase of Lost on change status end ======*/    


  }else if(bid_status == 1){ //bid_status 1 start

    /*======Tracking Info on change status start ======*/

    $.ajax({

      type: 'POST',
      url: '<?php echo base_url() ?>itemsToEstimate/c_itemsToEstimate/getTrackingInfo',
      data: {
        'lz_bd_catag_id': lz_bd_catag_id
      },
      dataType: 'json',
      success: function (data) {
        //console.log(data); 
        //console.log(data.offer_data[0].OFFER_ID); return false;
        
        if(data.tracking_data != 0){
          var tracking_no = data.tracking_data[0].TRACKING_NO;
          if(tracking_no == "" || tracking_no == null || tracking_no == undefined){
            tracking_no = "";
          }
          var cost_price = data.tracking_data[0].COST_PRICE;
          if(cost_price == "" || cost_price == null){
            cost_price = "";
          }

          $("#statusDropdown").html("");
          var selected = "";
          if(bid_status == 0){
            selected = "selected";
            $("#statusDropdown").append('<label for="Bid/Offer Status">Bid/Offer Status</label> <select name="bid_status" id="bid_status" class="form-control bid_status"> <option value="default">----SELECT----</option> <option value="1" >WON</option> <option value="0" '+selected+'>LOST</option> </select>');          
          }else if(bid_status == 1){
            selected = "selected";
            $("#statusDropdown").append('<label for="Bid/Offer Status">Bid/Offer Status</label> <select name="bid_status" id="bid_status" class="form-control bid_status"> <option value="default">----SELECT----</option> <option value="1" '+selected+' >WON</option> <option value="0">LOST</option> </select>');          
          }else{
            selected = "";
          }
                  
          $("#saleAmount").html("");
          $("#saveStatus").html("");
          $("#trackingNumber").html("");
          $("#trackingNumber").append('<label for="Tracking Number">Tracking Number:</label> <input type="text" class="form-control" name="tracking_number" id="tracking_number" value="'+tracking_no+'">');
          $("#saleAmount").append('<label for="Cost">Cost:</label> <input type="number" class="form-control" name="sale_amount" id="sale_amount"  value="'+cost_price+'" placeholder="$ Enter Amount in Number">');
          $("#saveStatus").append('<input type="button" class="btn btn-sm btn-success" name="save_status" id="save_status" value="Update Status">');     

        }else{
          $("#saleAmount").html("");
          $("#saveStatus").html("");
          $("#trackingNumber").html("");
          $("#trackingNumber").append('<label for="Tracking Number">Tracking Number:</label> <input type="text" class="form-control" name="tracking_number" id="tracking_number" value="">');
          $("#saleAmount").append('<label for="Cost">Cost:</label> <input type="number" class="form-control" name="sale_amount" id="sale_amount"  value="" placeholder="$ Enter Amount in Number">');
          $("#saveStatus").append('<input type="button" class="btn btn-sm btn-primary" name="save_status" id="save_status" value="Save Status">');          
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
/*======Tracking Info on change status end ======*/

  } //bid_status 1 close
                          
});
/*=======End Onchange append input number fields ==========*/

/*================================================
=            Save WIN and LOSS Status            =
================================================*/

$(document).on('click','#save_status',function(){

  var bid_status = $("#bid_status").val();
  var tracking_number = $("#tracking_number").val();
  var sale_amount = $("#sale_amount").val();
  var update_offer_id = $("#update_offer_id").val();
  var lz_cat_id = $("#update_lz_cat_id").val();
  var lz_bd_cata_id = $("#update_lz_bd_catag_id").val();  
  //console.log(bid_status, tracking_number, sale_amount, update_offer_id);return false;

  $(".loader").show();
  $.ajax({

    type: 'POST',
    url: '<?php echo base_url() ?>itemsToEstimate/c_itemsToEstimate/saveBiddingStatus',
    data: {
      'bid_status': bid_status,
      'tracking_number':tracking_number,
      'sale_amount': sale_amount,
      'update_offer_id':update_offer_id,
      'lz_cat_id':lz_cat_id,
      'lz_bd_cata_id':lz_bd_cata_id
    },
    dataType: 'json',
    success: function (data) {
      //console.log(data); return false;
      $(".loader").hide();
         if(data == 1){
            $("#bidingStatusMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Success: Bidding Status is saved.</div>");
            setTimeout(function(){ $("#bidingStatusMessage").html('');}, 3000); 
           // alert("Success: Bidding Status is saved.");   
           // window.location.reload(); 
         }else if(data == 2){
           $(".loader").hide();
            $("#bidingStatusMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Error: Bidding Status is not Saved.</div>");
            setTimeout(function(){ $("#bidingStatusMessage").html('');}, 3000);            
           // alert('Error: Bidding Status is not Saved.');

         }else if(data == "exist"){
            alert("Tracking Number is already exist");
         }else if(data == 3){
            $("#bidingStatusMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Success: Bidding and Tracking data is saved.</div>");
            setTimeout(function(){ $("#bidingStatusMessage").html('');}, 3000);          
         }else if(data == 4){
            $("#bidingStatusMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Error: Bidding and Tracking data is not saved.</div>");
            setTimeout(function(){ $("#bidingStatusMessage").html('');}, 3000);          
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

// Instant saving of Tracking Number and Cost with Status

$(document).on('click','#instant_save',function(){

  var bid_status = $("#bid_status").val();
  var tracking_number = $("#tracking_number").val();
  var sale_amount = $("#sale_amount").val();
  var offer_id_save = $("#offer_id_save").val();
  var lz_cat_id = $("#lz_cat_id").val();
  var lz_bd_cata_id = $("#lz_bd_catag_id").val(); 
  //console.log(lz_cat_id, lz_bd_cata_id); return false;
  //console.log(bid_status, tracking_number, sale_amount, offer_id_save);return false;

  $(".loader").show();
  $.ajax({

    type: 'POST',
    url: '<?php echo base_url() ?>itemsToEstimate/c_itemsToEstimate/instantSaveBiddingStatus',
    data: {
      'bid_status': bid_status,
      'tracking_number':tracking_number,
      'sale_amount': sale_amount,
      'offer_id_save':offer_id_save,
      'lz_cat_id':lz_cat_id,
      'lz_bd_cata_id':lz_bd_cata_id
    },
    dataType: 'json',
    success: function (data) {
      //console.log(data); return false;

      $(".loader").hide();
         if(data == 1){
            $("#bidingStatusMessageSave").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Success: Bidding Status is saved.</div>");
            setTimeout(function(){ $("#bidingStatusMessageSave").html('');}, 3000); 
           // alert("Success: Bidding Status is saved.");   
           // window.location.reload(); 
         }else if(data == 2){
           $(".loader").hide();
            $("#bidingStatusMessageSave").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Error: Bidding Status is not Saved.</div>");
            setTimeout(function(){ $("#bidingStatusMessageSave").html('');}, 3000);            
           // alert('Error: Bidding Status is not Saved.');

         }else if(data == "exist"){
            alert("Tracking Number is already exist");
         }else if(data == 3){
            $("#bidingStatusMessageSave").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Success: Bidding and Tracking data is saved.</div>");
            setTimeout(function(){ $("#bidingStatusMessageSave").html('');}, 3000);          
         }else if(data == 4){
            $("#bidingStatusMessageSave").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Error: Bidding and Tracking data is not saved.</div>");
            setTimeout(function(){ $("#bidingStatusMessageSave").html('');}, 3000);          
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
/*=====  End of Save WIN and LOSS Status  ======*/

/*=====  Instant Change status on dropdown change start  ======*/

$(document).on('change','.instant_change',function(){
  var bid_status = $("#bid_status").val();

  if(bid_status == 0){

    $("#statusDropdownSave").html("");
    $("#saleAmountSave").html("");
    $("#saveStatusSave").html("");
    $("#trackingNumberSave").html("");

    $("#statusDropdownSave").append('<label for="Bid/Offer Status">Bid/Offer Status</label> <select name="bid_status" id="bid_status" class="form-control bid_status instant_change"> <option value="default">----SELECT----</option> <option value="1" >WON</option> <option value="0" >LOST</option> </select>');          

    $("#saleAmountSave").append('<label for="Sale Amount">Sale Amount:</label> <input type="number" class="form-control" name="sale_amount" id="sale_amount" value="" placeholder="$ Enter Amount in Number">');
    $("#saveStatusSave").append('<input type="button" class="btn btn-sm btn-primary" name="instant_save" id="instant_save" value="Save Status">');         


  }else if(bid_status == 1){ //bid_status 1 start

    $("#statusDropdownSave").html("");
    $("#saleAmountSave").html("");
    $("#saveStatusSave").html("");
    $("#trackingNumberSave").html("");
    $("#statusDropdownSave").append('<label for="Bid/Offer Status">Bid/Offer Status</label> <select name="bid_status" id="bid_status" class="form-control bid_status instant_change"> <option value="default">----SELECT----</option> <option value="1" selected>WON</option> <option value="0">LOST</option> </select>');

    $("#trackingNumberSave").append('<label for="Tracking Number">Tracking Number:</label> <input type="text" class="form-control" name="tracking_number" id="tracking_number" value="">');
    $("#saleAmountSave").append('<label for="Cost">Cost:</label> <input type="number" class="form-control" name="sale_amount" id="sale_amount"  value="" placeholder="$ Enter Amount in Number">');
    $("#saveStatusSave").append('<input type="button" class="btn btn-sm btn-success" name="instant_save" id="instant_save" value="Save Status">');

  } //bid_status 1 close
                          
});

/*=====  Instant Change status on dropdown change end  ======*/
</script>
