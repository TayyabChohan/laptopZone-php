<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); 
?>
<style>
 .m-3{
    margin: 3px;
  } 
  .show-flag{
    border: 2px solid red;
    padding: 1px;
  }
  #contentSec{
    display: none;
  }
/*div#printMessage {
    font-size: 16px;
    font-weight: bold;
    color: #ffffff;
    background-color: #00a65a;
    padding: 10px;
    border-radius: 5px;
} */
</style> 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Bidding &amp; Select for Purchase Items
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Bidding &amp; Select for Purchase Items</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content"> 
       <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Search</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
                <div class="box-body"> 
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
            <?php } ?>    
                  <div class="col-sm-12">
             
                <!-- <form action="<?php //echo base_url().'catalogueToCash/c_purchasing/searchByListType/'.$cat_id.'/'.$catalogue_mt_id; ?>" method="post" accept-charset="utf-8"> -->
                <form action="<?php echo base_url().'biddingItems/c_biddingItems/searchPurchDetail'; ?>" method="post" accept-charset="utf-8">
           
                <div class="col-sm-3">
                  <div class="form-group" id="appCat">
                    <label for="Condition">Category Id:</label>
                    <?php //var_dump($this->session->userdata('Search_category'));
                     //$this->session->unset_userdata('Search_category'); 
                     $listCategory = $this->session->userdata('Search_category'); ?> 
                      <select  name="category[]" id="category" class="selectpicker form-control" multiple data-actions-box="true" data-live-search="true">
                       <!--  <option value="all">All</option> -->
                        <?php
                        /////$this->session->unset_userdata('unverify_condition'); 
                          foreach(@$dataa['cattegory'] as $type):                    
                            $selected = "";
                            foreach(@$listCategory as $selectedcat){ 

                              if ($selectedcat == $type['CATEGORY_ID']){
                                  $selected = "selected";

                                } 
                              } //end foreach
                                            
                              ?>
                             <option value="<?php echo $type['CATEGORY_ID']; ?>"<?php echo $selected; ?>><?php echo $type['CATEGORY_NAME']; ?></option>
                              <?php
                            endforeach;
                         
                           ?>                     
                      </select> 

                  </div>
                </div> 


                 <div class="col-sm-3">
                  <div class="form-group" id ="listDropDown">
                    <label for="Search Webhook">Listing Type:</label>
                    <?php //$this->session->unset_userdata('Search_List_type'); ?>
                      <?php $ctListingType = $this->session->userdata('Search_List_type'); ?>
                      <select  name="serc_listing_Type[]" id="listingType" class="selectpicker form-control" multiple data-actions-box="true" data-live-search="true">
                       <!--  <option value="all">All</option> -->
                        <?php  
                           
                          foreach(@$dataa['list_types'] as $type):                    
                            $selected = "";
                            foreach(@$ctListingType as $selectedVal){ 

                              if ($selectedVal == $type['LISTING_TYPE']){
                                  $selected = "selected";

                                } 
                              } //end foreach
                                            
                              ?>
                              <option value="<?php echo $type['LISTING_TYPE']; ?>"<?php echo $selected; ?>><?php echo $type['LISTING_TYPE']; ?></option>
                              <?php
                            endforeach;
                            
                               
                           ?>                     
                      </select>                       
                  </div>
                </div>  

                 <div class="col-sm-3">
                  <div class="form-group" id="conditionDropdown">
                    <label for="Condition">Condition:</label>
                    <?php //$this->session->unset_userdata('Search_condition'); ?>
                    <?php //var_dump($this->session->userdata('Search_condition'));
                      $listCondition = $this->session->userdata('Search_condition'); ?>
                      <select  name="condition[]" id="condition" class="selectpicker form-control" multiple data-actions-box="true" data-live-search="true">
                       <!--  <option value="all">All</option> -->
                        <?php
                        /////$this->session->unset_userdata('unverify_condition'); 
                          foreach(@$dataa['conditions'] as $type):                    
                            $selected = "";
                            foreach(@$listCondition as $selectedcon){ 

                              if ($selectedcon == $type['ID']){
                                  $selected = "selected";

                                } 
                              } //end foreach
                                            
                              ?>
                             <option value="<?php echo $type['ID']; ?>"<?php echo $selected; ?>><?php echo $type['COND_NAME']; ?></option>
                              <?php
                            endforeach;
                         
                           ?>                     
                      </select> 

                  </div>
                </div>

                <div class="col-sm-3">
                <?php //$this->session->unset_userdata('purch_mpn'); ?>  
                  <div class="form-group">
                    <label for="Search Webhook">Search Mpn:</label>
                      <input type="text" name="purch_mpn" class="form-control clear" placeholder="Search Mpn" value="<?php echo htmlentities($this->session->userdata('purch_mpn')); ?>" >    

                  </div>
              
                </div>        

                <div class="col-sm-12">

                

              <div class="col-sm-3">
                <div class="form-group" id="sortDropdown">
                  <?php //var_dump($this->session->userdata('title_sort'));?>
                  <label for="Search Webhook">Title Sort:</label>
              <?php //$this->session->unset_userdata('title_sort'); ?>
              <?php
              $arrstate = array ('1' => 'Shortest To Longest','2' => 'Longest To Shortest'); ?>
              <select class="form-control selectpicker sortDropdown" name="title_sort" id="title_sort" data-live-search="true">
              <option value="">All ....</option>
              <?php
              foreach($arrstate as $key => $value) {
              ?>
              <option value="<?php echo $key; ?>"  <?php if($this->session->userdata('title_sort') == $key){echo "selected";}?>><?php echo $value; ?></option>
              <?php
              }
              ?>
              </select>

           

                </div>
              </div>


            <div class="col-sm-3">
              <div class="form-group ">
                <label>Date Range:</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <?php $rslt = $this->session->userdata('date_range'); ?>
                  <input type="text" class="btn btn-default clear" name="date_range" id="date_range" value="<?php echo $rslt; ?>">

                </div>
              </div>
            </div>

             <div class="col-sm-3 ">
                <?php //$this->session->unset_userdata('serchkeyword'); ?>  
                <div class="form-group">
                  <label for="Search Webhook">Search Title:</label>
                  <input type="text" name="search_title" class="form-control clear" placeholder="Search Title" value="<?php echo htmlentities($this->session->userdata('serchkeyword')); ?>" >    
                </div>
              
              </div>

            </div>
             <div class="col-sm-12"> <!-- new added code -->
              <div class="col-sm-1">
                <div class="form-group">
                  <input type="submit" class="btn btn-primary btn-sm pull-left" name="search_webhook" id="search_webhook" value="Search">
                </div>
              </div>
              <div class="col-sm-1">
                <div class="form-group">
                  <button type ="button" class="btn btn-sm btn-warning" id="reset">Reset Filters</button>
                </div>                
              </div>  
              <div class="col-sm-1">
                <div class="form-group">
                  <a class="btn btn-sm btn-info" title="Show All" id="show_all" href="<?php echo base_url('biddingItems/c_biddingItems/purchasing_detail');?>">Show All</a>
                </div>                
              </div>

            </div>
          </form>                     
                                                       
            </div> 
          </div>
         </div>
       <!-- Title filtering section End -->

<!-- Verified title option start -->
          <div class="box collapsed-box">
            <div class="box-header with-border">
              <h3 class="box-title">Find Item and Verify</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
            </div>          
            <div class="box-body">
              <div class="col-sm-12">

                <div class="col-sm-3">
                  <div class="form-group" id="appCat">
                    <label for="Condition">Category Id:</label>

                      <select  name="category[]" id="category_id" class="selectpicker form-control" data-live-search="true">
                        <?php
                          $category_id = $this->session->userdata('category_id');
                          foreach(@$dataa['cattegory'] as $type):                    
                        ?>
                            <option value="<?php echo $type['CATEGORY_ID']; ?>" <?php if($type['CATEGORY_ID'] == $category_id){echo "selected";} ?> ><?php echo $type['CATEGORY_NAME']; ?></option>
                        <?php
                          endforeach;
                        ?>                     
                      </select> 

                  </div>
                </div>                 
                <div class="col-sm-3">
                  <div class="form-group">
                    <label>eBay ID:</label>
                    <input type="number" class="form-control" name="ebay_id" id="ebay_id" value="">
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group p-t-24">
                    <input type="button" class="btn btn-sm btn-primary" name="find_item" id="find_item"  value="Search">
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group p-t-24" id="findItemMessage">
                    
                  </div>
                </div>

              </div>

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
                  <div class="form-group p-t-24" id="addMpnbutton">
                    
                  </div>
                </div>                

                 
              </div>

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
            </div>
          </div>   

<!-- Verified title option end -->


          <!-- summary Block start -->   
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Bidding and Purchase Item Summary</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
            <div class="box-body">
              <div class="col-lg-2 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                  <div class="inner">
                    <!-- <p class="summarycardcss" id="total_record"><?php //echo @$bidding_counts[0]['TOTAL_BIDS']; ?></p> -->
                    <p class="summarycardcss" style="font-size: 16px!important;">Total Biddings &nbsp;(<?php echo @$bidding_counts[0]['TOTAL_BIDS']; ?>)</p>
                    <p class="summarycardcss" id="total_record" style="font-size: 16px!important;">Active Biddings &nbsp;(<?php echo @$bidding_counts[0]['TOTAL_OFFER_COUNT']; ?>)</p>
                    <!-- <p>ACTIVE BIDDINGS</p> -->                    
                  </div>
                  <div class="icon">
                    <i class="fa fa-gavel fa-bidding fa-1x"  aria-hidden="true"></i>
                  </div>
                  <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>

              <div class="col-lg-2 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-teal-gradient">
                  <div class="inner">
                     <p class="summarycardcss" id="total_record" style="font-size: 16px!important;">Total Offers &nbsp;
                    <?php 
                      echo '$ '.number_format((float)@$bidding_counts[0]['TOTAL_OFFER'],2,'.',','); 
                    ?>
                      </p>
                    <!-- <p>TOTAL OFFERS</p> -->

                     <p class="summarycardcss" id="total_record" style="font-size: 16px!important;">Active Offers &nbsp; 
                    <?php 
                      echo '$ '.number_format((float)@$bidding_counts[0]['TOTAL_PEND_OFFER'],2,'.',','); 
                    ?>
                      </p>
                    <!-- <p>ACTIVE OFFERS</p> -->                    
                  </div>
                  <div class="icon">
                    <i class="fa fa-usd fa-1x"  aria-hidden="true"></i>
                  </div>
                  <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>

            <div class="col-lg-2 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <p class="summarycardcss" id="total_verified"><?php echo @$bidding_counts[0]['WON']; ?></p>

                  <p>Total WON </p>
                </div>
                <div class="icon">
                  <i class="fa fa-check-circle-o fa-1x" aria-hidden="true"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-2 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">

                  <p class="summarycardcss" id="total_unverified"><?php echo @$bidding_counts[0]['LOST']; ?></p>

                  <p>Total LOST </p>
                </div>
                <div class="icon">
                  <i class="fa fa-ban fa-1x" aria-hidden="true"></i>
                </div>
                <div class="text text-center">
                  <button type="button" class="btn btn-warning btn-xs" id="unverified-info" align="center">More info <i class="fa fa-arrow-circle-right"></i></button>
                </div>
                
              </div>
            </div>
            <div class="col-lg-2 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <p class="summarycardcss" id="total_exp_record">
                    <?php 
                      echo '$ '.number_format((float)@$bidding_counts[0]['TOTAL_PURCHASE'],2,'.',','); 
                    ?>
                  </p>

                  <p>Total Sold Amount </p>
                </div>
                <div class="icon">
                  <i class="fa fa-usd" aria-hidden="true"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            </div><!-- div box-body end -->
          </div>
          <!-- summary Block end --> 

        <!-- Add Title Expression Start  -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Items Details</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
            <div class="box-body">
              <!-- Print Message -->
              <div class="col-sm-12">
                <div class="col-sm-4">
                </div>
                <div class="col-sm-4">
                  <div class="form-group text-center emptyDiv">
                    <div id="printMessage">
                    </div>
                  </div>
                </div>
                <div class="col-sm-4">
                </div>                
              </div>
              <!-- End Print Message -->
              <div class="box-body form-scroll"> 
              <div class="col-md-12"><!-- Custom Tabs -->
                <table id="biddingTable" class="table table-responsive table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>ACTION</th>
                      <th>EBAY ID</th>
                      <th>TITLE</th>
                      <th>MPN</th>
                      <th>SELLER ID</th>
                      <th>CATEGORY ID</th>
                      <th>LISTING TYPE</th>
                      <th>REMAINING TIME</th>
                      <th>CONDITION</th>                    
                      <th>STATUS</th>
                      <th>BID STATUS</th>
                      <th><div style="width:170px;">BID/OFFER</div></th>
                      <th>SOLD AMOUNT</th>
                      <th>KIT VIEW</th>
                      <th style="width:200px;">TRACKING</th>
                      <th>COST PRICE</th>
                      </tr>
                  </thead>
                  <tbody>
                  <tr class="danger">

                    <?php  $i = 1;
                     foreach($bid_data['sql'] as $row) :?>
                     <td>
                       <div style="width:80px;"> <button title="Discard" class="btn btn-danger btn-xs flag-trash" style="width: 25px;" 
                       id="<?php echo $row['LZ_BD_CATA_ID'];?>"><i class="fa fa-trash-o" aria-hidden="true"></i> </button> </div>
                     </td>
                     <td><a href="<?php echo $row['ITEM_URL']; ?>" target='_blank' id='link<?php echo $i; ?>'><?php echo $row['EBAY_ID']; ?></a></td>
                     <td><div class="pull-right" style="width:250px;"><?php echo $row['TITLE'];?></div></td>
                     <td><div class="text-center" style="width:100px;"><?php echo $row['MPN']; ?></div></td>
                     <td><?php echo $row['SELLER_ID']; ?></td>
                     <?php $lz_cat_id = $row['CATEGORY_ID'];?>
                     <td><?php echo $row['CATEGORY_ID']; ?></td>
                     <td><?php echo $row['LISTING_TYPE']; ?></td>
                     <td><div class="text-center" style="width:130px;"><?php echo $row['TIME_DIFF'];?></div></td>
                     <td><?php echo $row['CONDITION_NAME']; ?></td>
                     <?php $offer_amount = @$row['OFFER_AMOUNT']; 
                    if(empty($offer_amount)){?>
                    <td><div class="pull-right" style="width:120px;"> <input type="hidden" name="cat_id" id="cat_id" value="<?php echo $lz_cat_id;?>"></div></td>
                    <?php }else {?>
                    <td><div class="pull-right" style="width:120px;"> <input type="hidden" name="cat_id" id="cat_id" value="<?php echo $lz_cat_id;?>"><select style="width:100px;" name="winLoss" id="status_<?php echo $row['LZ_BD_CATA_ID'];?>" class="form-control winLoss"><option value="none">Select...</option><option value="1">WON</option><option value="0">LOST</option> </select> </div></td>

                    <?php } ?>
                    <?php $status = @$row['WIN_STATUS'];?>
                    <td><div class="pull-right" style="width:70px;"><?php echo $status; ?></div></td>

                    <?php $offer_id = $row['OFFER_ID'];?>

                    <?php if(empty($offer_amount)){ ?>
                    <td><div class="pull-right" style="width:170px;"> <input style="width:100px;margin-right:10px;" class="form-control" type="number" name="bidding_offer_<?php echo $i;?>" id="bidding_offer_<?php echo $i; ?>" value="<?php echo $offer_amount; ?>" placeholder="Offer"> <input type="button" class="btn btn-sm btn-primary save_offer" name="save_offer" id="<?php echo $i; ?>" value="Save"> </div></td>
                    <?php }else{ ?>
                    <td><div class="pull-right" style="width:170px;"> <input style="width:100px;margin-right:10px;" class="form-control" type="number" name="bid_offer_<?php echo $offer_id; ?>" id="bid_offer_<?php echo $offer_id; ?>" value="<?php echo $offer_amount; ?>" placeholder="Offer"> <input type="button" class="btn btn-sm btn-success revise_offer" name="revise_offer" id="<?php echo $offer_id; ?>" value="Revise"> </div></td>         
                    <?php } 
                     
                    $sold_amount = $row['SOLD_AMOUNT'];
                    if(empty($sold_amount)){?>
                    <td><div class="pull-right" style="width:190px;"> <input style="width:115px;margin-right:10px;" class="form-control" type="number" name="sold_amount_<?php echo $i; ?>" id="sold_amount_<?php echo $i; ?>" value="<?php echo $sold_amount; ?>" placeholder="Sold Amount"> <input type="button" class="btn btn-sm btn-primary sold_amount" name="sold_amount" id="<?php echo $i ;?>" value="Save"> </div></td> 
                    <?php }else{ ?>
                    <td><div class="pull-right" style="width:190px;"> <input style="width:115px;margin-right:10px;" class="form-control" type="number" name="amount_sold_<?php echo $offer_id; ?>" id="amount_sold_<?php echo $offer_id; ?>" value="<?php echo $sold_amount; ?>" placeholder="Sold Amount"> <input type="button" class="btn btn-sm btn-success update_sold_amount" name="update_sold_amount" id="<?php echo $offer_id; ?>" value="Update"> </div></td>
                    <?php } ?>   
                    <?php 
                    $lz_estimate_id =   $row['LZ_ESTIMATE_ID'];
                    $lz_bd_cata_id  =   $row['LZ_BD_CATA_ID'];
                    $category_id  =     $row['CATEGORY_ID'];
                    $catalogue_mt_id  = $row['CATALOGUE_MT_ID'];
                    
                    if(empty($lz_estimate_id)){?>
                    <td><div class="form-group"> <input type="hidden" name="lz_bd_catag_id_<?php echo $i; ?>" id="lz_bd_catag_id_<?php echo $i; ?>" value="<?php echo $lz_bd_cata_id; ?>"> <input type="hidden" name="lz_cat_id_<?php echo $i; ?>" id="lz_cat_id_<?php echo $i; ?>" value="<?php echo $category_id ; ?>"> <a class="btn btn-primary btn-sm" href="<?php echo base_url();?>catalogueToCash/c_purchasing/kitComponents/<?php echo $category_id?>/<?php echo $catalogue_mt_id; ?>/<?php echo $lz_bd_cata_id; ?>/<?php echo '1111'; ?>" id="" class="" title="Kit View">KIT VIEW</a> </div></td>
                    <?php }else { ?>
                    <td><div class="form-group"> <input type="hidden" name="lz_bd_catag_id_<?php echo $i; ?>" id="lz_bd_catag_id_<?php echo $i; ?>" value="<?php echo $lz_bd_cata_id; ?>"> <input type="hidden" name="lz_cat_id_<?php echo $i; ?>" id="lz_cat_id_<?php echo $i; ?>" value="<?php echo $category_id ; ?>"> <a class="btn btn-success btn-sm updateEst" href="<?php echo base_url();?>catalogueToCash/c_purchasing/updateEstimate/<?php echo $category_id ;?>/<?php echo $catalogue_mt_id; ?>/<?php echo $lz_bd_cata_id; ?>/<?php echo '1111';?>" id=""  title="Update Kit">UPDATE KIT</a> </div></td>
                    <?php } ?>
                    <?php $ct_tracking_no = $row['TRACKING_NO']; ?>
                    <td><div class="form-group"> <input type="text" name="ct_tracking_no_<?php echo $i; ?>" id="ct_tracking_no_<?php echo $i; ?>" class="form-control input-sm ct_tracking_no" value="<?php echo $ct_tracking_no; ?>" style="width:200px;"> </div></td>
                    <?php $cost_price = $row['COST_PRICE']; ?>

                    <?php if(empty($row['TRACKING_NO'])){ ?>
                    <td><div style="width: 160px;">  <input type="text" name="ct_cost_price_<?php echo $i; ?>" id="ct_cost_price_<?php echo $i; ?>" class="form-control input-sm ct_cost_price" value="<?php echo $cost_price; ?>" style="width:100px;"> <div class="pull-right"> <button type="button" title="Save Tracking No"  class="btn btn-primary btn-xs save_tracking_no" id="<?php echo $i; ?>" style="height: 28px; margin-bottom: auto;">Save</button> </div></div></td>
                    <?php }else if(!empty($row['TRACKING_NO']) && empty($row['SELLER_DESCRIPTION'])) { ?>
                    <td><div style="width: 260px;"><input type="text" name="ct_cost_price_<?php echo $i; ?>" id="ct_cost_price_<?php echo $i; ?>" class="form-control input-sm ct_cost_price pull-left" value="<?php echo $cost_price; ?>"  style="width:100px;"> <div class="pull-left" style="margin-left:10px;"> <button type="button" title="Update Tracking No"  class="btn btn-success btn-xs update_mpn_data" id="<?php echo $i; ?>" tId="<?php echo $row['TRACKING_ID']; ?>" style="height: 28px; margin-bottom: auto;">Update</button> </div> <div class="form-group pull-left" style="margin-left:12px;"> <button type="button" title="eBay Seller Description" class="btn btn-link btn-xs seller " id="seller_desc'.$i.'" style="font-weight: 700; font-size: 14px;" >Seller Desc</button></div> </div></td>
                    <?php }else if(!empty($row['TRACKING_NO']) && !empty($row['SELLER_DESCRIPTION'])) { ?>
                    <td><div style="width: 260px;"><input type="text" name="ct_cost_price_<?php echo $i; ?>" id="ct_cost_price_<?php echo $i; ?>" class="form-control input-sm ct_cost_price pull-left" value="<?php echo $cost_price; ?>"  style="width:100px;"> <div class="pull-left" style="margin-left:10px;"> <button type="button" title="Update Tracking No"  class="btn btn-success btn-xs update_mpn_data" id="<?php echo $i; ?>" tId="<?php echo $row['TRACKING_ID']; ?>" style="height: 28px; margin-bottom: auto;">Update</button> </div> <div class="form-group pull-left" style="margin-left:12px;"> <button type="button" title="eBay Seller Description" class="btn btn-link btn-xs seller " id="seller_desc'.$i.'" style="font-weight: 700; font-size: 14px;color: green;" >Seller Desc</button></div> </div></td>
                    <?php } ?> 



                  </tr>

                  <?php $i++;
                   endforeach; ?> 
                   <!-- //// end main foreach -->
                    
                  </tbody>
                </table>              
                    <!-- nav-tabs-custom -->
                  </div>
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
 <?php $this->load->view('template/footer'); ?>
  <script>
$(document).ready(function()
  {
     $('#biddingTable').DataTable({
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
    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
    "createdRow": function( row, data, dataIndex){
            if(data){
                $(row).find(".updateEst").closest( "tr" ).addClass('rowBg');
                }
              }
  });
          
});


  /*==============================================================
  =               FOR RESET FILTERS                     =
  ================================================================*/


$("#reset").on('click',function() {
    
   $(".clear").val("");

    $('#sortDropdown').html("");
   $('#sortDropdown').append('<label for="Search Webhook">Title Sort:</label><select class="form-control selectpicker" name="title_sort" id="title_sort" data-live-search="true"><option value="0">All ....</option><option value="1">Shortest To Longest</option><option value="2">Longest To Shortest</option></select>');

   $('#timeDropdown').html("");
   $('#timeDropdown').append('<label for="Search Webhook">Title Sort:</label><select class="form-control selectpicker" name="time_sort" id="time_sort" data-live-search="true"><option value="0">All ....</option><option value="1">Last 24 Hours</option><option value="2">Last 48 Hours</option><option value="3">Last 72 Hours</option></select>');

   var cat_id = '<?php echo $this->uri->segment(4);?>';
   // alert(cat_id);return false;
   var catalogue_id = '<?php echo $this->uri->segment(5);?>';
   $.ajax({
      type: 'POST',
      url: '<?php echo base_url() ?>catalogueToCash/c_purchasing/resetUnVerifyDropdown',
      data:{'cat_id':cat_id,'catalogue_id':catalogue_id},
      dataType: 'json',
      success: function (data) {
        $(".loader").hide();
        //---Category dropdown starts----//
        var catData = [];
       // console.log(data);
        catData.push('<option value="all">All</option>');
        for (var i = 0; i < data.cattegory.length; i++) {
          catData.push('<option value="'+data.cattegory[i].CATEGORY_ID+'">'+data.cattegory[i].CATEGORY_NAME+'</option>');
        }

        $("#appCat").html("");
        $("#appCat").append('<label for="Category">Category Id:</label><select  name="category[]" id="category" class="selectpicker form-control" multiple data-live-search="true">'+catData.join("")+'</select>');
        
        $('.selectpicker').selectpicker();
        //---Category dropdown ends----//


           //---Flag dropdown starts----//
        var flag = [];
       // console.log(data);
        flag.push('<option value="all">All</option>');
        for (var i = 0; i < data.flag_id.length; i++) {
          flag.push('<option value="'+data.flag_id[i].FLAG_ID+'">'+data.flag_id[i].FLAG_NAME+'</option>');
        }

        $("#flag_dropdown").html("");
        $("#flag_dropdown").append('<label for="Flag">Flag Name:</label><select  name="flag[]" id="flag" class="selectpicker form-control" multiple data-live-search="true">'+flag.join("")+'</select>');
        
        $('.selectpicker').selectpicker();
        //---flag dropdown ends----//

        //---LISTING_TYPE dropdown starts----//
        var listData = [];
        listData.push('<option value="all">All</option>');
        for (var i = 0; i < data.list_types.length; i++) {
          listData.push('<option value="'+data.list_types[i].LISTING_TYPE+'">'+data.list_types[i].LISTING_TYPE+'</option>');
        }

        $("#listDropDown").html("");
        $("#listDropDown").append('<label for="Search Webhook">Listing Type:</label><select  name="serc_listing_Type[]" id="listingType" class="selectpicker form-control" multiple data-live-search="true">'+listData.join("")+'</select>');
        $('.selectpicker').selectpicker();
        //---LISTING_TYPE dropdown ends----//


        //---conditon dropdown starts----//
        var conditon = [];
        conditon.push('<option value="all">All</option>');
        for (var i = 0; i < data.conditions.length; i++) {
          conditon.push('<option value="'+data.conditions[i].ID+'">'+data.conditions[i].COND_NAME+'</option>');
        }

        $("#conditionDropdown").html("");
        $("#conditionDropdown").append('<label for="Condition">Condition:</label><select  name="condition[]" id="condition" class="selectpicker form-control" multiple data-live-search="true">'+conditon.join("")+'</select>');
        $('.selectpicker').selectpicker();
        //---conditon dropdown ends----//


      }

   });

   // $('#appCat').append(slect);
   // '<?php //$this->session->unset_userdata('Search_category'); ?>'
});
 /*==================================================
  =            FOR SAVING TRACKING NO          =
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
    url: '<?php echo base_url() ?>catalogueToCash/c_purchasing/saveTrackingNo',
    data: {
      'ct_tracking_no': ct_tracking_no,
      'ct_cost_price': ct_cost_price,
      'lz_bd_catag_id': lz_bd_catag_id,
      'lz_cat_id': lz_cat_id
    },
    dataType: 'json',
    success: function (data) {
      //console.log(data); return false;
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
      }
  });
  
  }); 

    /*==================================================
  =           FOR UPDATING TRACKING NUMBER            =
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
    url: '<?php echo base_url() ?>catalogueToCash/c_purchasing/updateTrackingNo',
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
      }
  });
  
  });

/*================================================
=            Save Bidding Offer            =
================================================*/

  $('body').on('click', '.save_offer', function(){
    //this.disabled = true;
    var rowId = $(this).attr('id');
    //alert(rowId); return false;

    var bidding_offer = $("#bidding_offer_"+rowId).val(); 
    var lz_bd_catag_id = $("#lz_bd_catag_id_"+rowId).val(); 
    var cat_id = $("#lz_cat_id_"+rowId).val();
    // console.log(bidding_offer+" - " + lz_bd_catag_id +" - "+cat_id);
    // return false; 
    if (bidding_offer.length === 0) 
    { 
      alert('Bidding Offer is required'); 
      return false;
    }  

  $(".loader").show();
  $.ajax({

    type: 'POST',
    url: '<?php echo base_url() ?>biddingItems/c_biddingItems/saveBiddingOffer',
    data: {
      'bidding_offer': bidding_offer,
      'lz_bd_catag_id': lz_bd_catag_id,
      'cat_id': cat_id
    },
    dataType: 'json',
    success: function (data) {
      //console.log(data); return false;
      $(".loader").hide();
         if(data == 1){
            $("#printMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Success: Bidding Offer is saved.</div>");
            setTimeout(function(){ $("#printMessage").text('');}, 2000);

               // alert("Success: Bidding Offer is saved.");   
               // window.location.reload(); 
         }else if(data == 2){
           $(".loader").hide();
            $("#printMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Error: Bidding Offer is not saved.</div>");
            setTimeout(function(){ $("#printMessage").text('');}, 2000);           
           //alert('Error: Bidding Offer is not saved.');

         }
       },
       complete: function(data){
        $(".loader").hide();
      }
  });
  
  }); 

/*=====  End of Save Bidding Offer  ======*/

/*================================================
=            Revise Bidding Offer            =
================================================*/

  $('body').on('click', '.revise_offer', function(){
    var offer_id = $(this).attr('id');
    var bidding_offer = $("#bid_offer_"+offer_id).val(); 
    
    if (bidding_offer.length === 0) 
    { 
      alert('Bidding Offer is required'); 
      return false;
    }  
    //console.log(offer_id +" - "+bidding_offer);return false;
  $(".loader").show();
  $.ajax({

    type: 'POST',
    url: '<?php echo base_url() ?>biddingItems/c_biddingItems/reviseBiddingOffer',
    data: {
      'offer_id': offer_id,
      'bidding_offer': bidding_offer
    },
    dataType: 'json',
    success: function (data) {
      //console.log(data); return false;
      $(".loader").hide();
         if(data == 1){
            $("#printMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Success: Bidding Offer is Revised.</div>");
            setTimeout(function(){ $("#printMessage").text('');}, 2000);

               // alert("Success: Bidding Offer is Revised.");   
               // window.location.reload(); 
         }else if(data == 2){
           $(".loader").hide();
            $("#printMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Error: Bidding Offer is not Revised.</div>");
            setTimeout(function(){ $("#printMessage").text('');}, 2000);           
           // alert('Error: Bidding Offer is not Revised.');

         }
       },
       complete: function(data){
        $(".loader").hide();
      }
  });
  
  }); 

/*=====  End of Revise Bidding Offer  ======*/

/*================================================
=            Save WIN and LOSS Status            =
================================================*/

$("body").on('change', '.winLoss', function(){

  var lz_bd_cata_id = this.id;
  var cat_id = $("#cat_id").val();
  var status = $("#"+lz_bd_cata_id).val();
  lz_bd_cata_id = lz_bd_cata_id.substr(7);
  //console.log(status);return false;
  //console.log(lz_bd_cata_id +" - "+cat_id+" - "+status);return false;
  $(".loader").show();
  $.ajax({

    type: 'POST',
    url: '<?php echo base_url() ?>biddingItems/c_biddingItems/changeBiddingStatus',
    data: {
      'lz_bd_cata_id': lz_bd_cata_id,
      'cat_id': cat_id,
      'status':status
    },
    dataType: 'json',
    success: function (data) {
      //console.log(data); return false;
      $(".loader").hide();
         if(data == 1){
            $("#printMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Success: Bidding Status is saved.</div>");
            setTimeout(function(){ $("#printMessage").text('');}, 2000); 
           // alert("Success: Bidding Status is saved.");   
           // window.location.reload(); 
         }else if(data == 2){
           $(".loader").hide();
            $("#printMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Error: Bidding Status is not Saved.</div>");
            setTimeout(function(){ $("#printMessage").text('');}, 2000);            
           // alert('Error: Bidding Status is not Saved.');

         }
       },
       complete: function(data){
        $(".loader").hide();
      }
  });  
  
});

/*=====  End of Save WIN and LOSS Status  ======*/

/*================================================
=            Save Sold Amount            =
================================================*/

  $('body').on('click', '.sold_amount', function(){
    //this.disabled = true;
    var rowId = $(this).attr('id');
    //alert(rowId); return false;

    var sold_amount = $("#sold_amount_"+rowId).val(); 
    var lz_bd_catag_id = $("#lz_bd_catag_id_"+rowId).val(); 
    var cat_id = $("#lz_cat_id_"+rowId).val();
    //console.log(sold_amount+" - " + lz_bd_catag_id +" - "+cat_id);
    // return false; 
    if (sold_amount.length === 0) 
    { 
      alert('Sold Amount is required'); 
      return false;
    }  

  $(".loader").show();
  $.ajax({

    type: 'POST',
    url: '<?php echo base_url() ?>biddingItems/c_biddingItems/saveSoldAmount',
    data: {
      'sold_amount': sold_amount,
      'lz_bd_catag_id': lz_bd_catag_id,
      'cat_id': cat_id
    },
    dataType: 'json',
    success: function (data) {
      //console.log(data); return false;
      $(".loader").hide();
         if(data == 1){
            $("#printMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Success: Sold Amount is saved.</div>");
            setTimeout(function(){ $("#printMessage").text('');}, 2000);                     
           // alert("Success: Sold Amount is saved.");   
           // window.location.reload(); 
         }else if(data == 2){
           $(".loader").hide();
            $("#printMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Error: Sold Amount is not saved.</div>");
            setTimeout(function(){ $("#printMessage").text('');}, 2000);             
           // alert('Error: Sold Amount is not saved.');

         }
       },
       complete: function(data){
        $(".loader").hide();
      }
  });
  
  }); 

/*=====  End of Save Sold Amount  ======*/

/*================================================
=            Update Sold Amount            =
================================================*/

  $('body').on('click', '.update_sold_amount', function(){
    var offer_id = $(this).attr('id');
    var sold_amount = $("#amount_sold_"+offer_id).val(); 
    
    if (sold_amount.length === 0) 
    { 
      alert('Bidding Offer is required'); 
      return false;
    }  
    //console.log(offer_id +" - "+bidding_offer);return false;
  $(".loader").show();
  $.ajax({

    type: 'POST',
    url: '<?php echo base_url() ?>biddingItems/c_biddingItems/updateSoldAmount',
    data: {
      'offer_id': offer_id,
      'sold_amount': sold_amount
    },
    dataType: 'json',
    success: function (data) {
      //console.log(data); return false;
      $(".loader").hide();
         if(data == 1){
           //window.location.href = '<?php //echo base_url(); ?>BundleKit/c_bkProfiles';
          //$("#printMessage").html("");
          $("#printMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Success: Sold Amount is updated.</div>"); 
            setTimeout(function(){ $("#printMessage").text('');}, 2000);
          // alert("Success: Sold Amount is updated.");   
          // window.location.reload(); 
         }else if(data == 2){
           $(".loader").hide();
          $("#printMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Error: Sold Amount is not updated.</div>");
            setTimeout(function(){ $("#printMessage").text('');}, 2000);           
           // alert('Error: Sold Amount is not updated.');

         }
       },
       complete: function(data){
        $(".loader").hide();
      }
  });
  
  }); 

/*=====  End of Update Sold Amount  ======*/

/*==================================================
=            Delete record is_deleted 1            =
==================================================*/
$("body").on('click','.flag-trash', function() {
   var lz_bd_cata_id = $(this).attr("id");
   var cat_id = $("#cat_id").val();
   //console.log(lz_bd_cata_id+" - "+ cat_id); return false;
    $(".loader").show();
    $.ajax({
        url: '<?php echo base_url(); ?>biddingItems/c_biddingItems/trashResultRow', //maintains the (controller/function/argument) logic in the MVC pattern
        type: 'post',
        dataType: 'json',
         data : {'lz_bd_cata_id':lz_bd_cata_id, 'cat_id':cat_id},
        success: function(data){
          $(".loader").hide();
            if(data == 1){
              $(".loader").hide();
              var row=$("#"+lz_bd_cata_id);
              //debugger;     
              row.closest('tr').fadeOut(1000, function() {
              row.closest('tr').remove();
              });
              //window.location.reload();
             //$('#'+id).remove();
            }else if(data == 2){
              alert("Not Deleted.");
            }
        },
        error: function(data){
          $(".loader").hide();
           alert('Not Deleted');
        }
    });    
 });

/*=====  End of Delete record is_deleted 1  ======*/

/*============================================
=            Find item for Verify            =
============================================*/

  $('body').on('click', '#find_item', function(){
    var category_id = $("#category_id").val();
    var ebay_id = $("#ebay_id").val(); 
    //console.log(category_id +" - "+ebay_id);return false;
    //console.log(ebay_id.length);return false;
    if (category_id.length === 0) 
    { 
      alert('Please select Category Id.'); 
      return false;
    }else if(ebay_id.length === 0){
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
    url: '<?php echo base_url() ?>biddingItems/c_biddingItems/findItem',
    data: {
      'category_id': category_id,
      'ebay_id': ebay_id
    },
    dataType: 'json',
    success: function (data) {
      //console.log(data); return false;
      $(".loader").hide();
         if(data == 1){
          $("#findItemMessage").html("");
          $("#findItemMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Title is moved to Active Data.</div>");
            setTimeout(function(){ $("#findItemMessage").text('');}, 3000);            
          //console.log("Title is moved.");
         }else if(data == 2){
           $(".loader").hide();

          $("#findItemMessage").html("");
          $("#findItemMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Error: Title is not moved.</div>");
            setTimeout(function(){ $("#findItemMessage").text('');}, 3000);            
           //console.log("Title is not moved.");


         }else if(data.get_brands != ""){
          //console.log("Unverify");
          $("#get_brands").html("");
            var appendText = []; 
            for (var i = 0; i < data.get_brands.length; i++) {
                appendText.push('<option value="'+data.get_brands[i].DET_ID+'">'+data.get_brands[i].SPECIFIC_VALUE+'</option>'); //This adds each thing we want to append to the array in order.
            }

            //Since we defined our variable as an array up there we join it here into a string
            appendText.join(" ");
            $("#get_brands").html("");
            $("#get_brands").append('<label>Select Brand:</label><select name="brand" id="brand" class="form-control selectpicker" data-live-search="true"><option value="0">Select......</option>'+appendText+'</select>');
            $('.selectpicker').selectpicker();
                   

          $("#resultTable" ).html("");
           //var tr='';
           $( "#resultTable" ).html("<table class='table table-bordered table-striped' border='1' id='findItemResult'><thead><th>EBAY ID</th> <th>ITEM DESCRIPTION</th> <th>SELLER ID</th> <th>FEEDBACK SCORE</th> <th>LISTING TYPE</th> <th>CONDITION</th> <th>ACTIVE PRICE</th><th>START TIME</th><th>SALE TIME</th></thead>"); //  for ( var i = 1; i < data.itemCount+1; i++ ) {

          var ebay_id = data.active_result[0].EBAY_ID;
          var lz_bd_cata_id = data.active_result[0].LZ_BD_CATA_ID;
          var title = data.active_result[0].TITLE;
          var item_url = data.active_result[0].ITEM_URL;
          var condition_name = data.active_result[0].CONDITION_NAME; 
          var seller_id = data.active_result[0].SELLER_ID;
          var listing_type = data.active_result[0].LISTING_TYPE;
          var sale_price = data.active_result[0].SALE_PRICE;
          var start_time = data.active_result[0].START_TIME;
          var sale_time = data.active_result[0].SALE_TIME;
          var feedback_score = data.active_result[0].FEEDBACK_SCORE;
          var verified = data.active_result[0].VERIFIED;
          
          $('<tr>').html("<td><input type='hidden' name='lz_bd_cata_id' id='lz_bd_cata_id' value='"+ lz_bd_cata_id +"'> <input type='hidden' name='verify_ebay_id' id='verify_ebay_id' value='"+ ebay_id +"'><a href='"+ item_url +"' target = '_blank'>" + ebay_id + "</a></td><td>" + title + "</td><td>" + seller_id + "</td><td>" + feedback_score + "</td><td>" + listing_type + "</td><td>" + condition_name + "</td><td>" + sale_price + "</td><td>" + start_time + "</td><td>" + sale_time + "</td></tr></table>").appendTo('#findItemResult');
         }else if(data.get_brands == ""){
          $("#findItemMessage").html("");
          $("#findItemMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Item is already verified.</div>");
            setTimeout(function(){ $("#findItemMessage").text('');}, 3000);  
         }
       },
       complete: function(data){
        $(".loader").hide();
      }
  });
  
  }); 

/*=====  End of Find item for Verify  ======*/

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
            $("#addMpnbutton").html("");

            $("#appendMpnlist").append('<label>Select MPN:</label> <select name="verifiedmpn" id="verifiedmpn" class="form-control selectpicker" data-live-search="true">' + mpn.join("") + '</select>'); 
            $('.selectpicker').selectpicker();
            $("#verifyButton").append('<input type="button" class="btn btn-success btn-md btn-block" name="verifyTitle" id="verifyTitle" value="Verify">');
            $("#addMpnbutton").append('<input type="button" class="btn btn-primary btn-md btn-block" id="mpnContent" value="Add MPN">');

        }else{
          console.log('Error! No Data Found.');
        }          
     },
       complete: function(data){
      $(".loader").hide();
    }
    }); 
});

/*=====  End of On change of Brand show MPN  ======*/

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
    }
    }); 
});

//toggle MPN Section
 
$('body').on('click', '#mpnContent', function(){  
  $('#contentSec').toggle();
});  

/*=====  End of Onload show mpn cateogires wise  ======*/
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
      url:'<?php echo base_url(); ?>catalogueToCash/c_purchasing/getSellerDescription',  
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
    url:'<?php echo base_url(); ?>catalogueToCash/c_purchasing/updateSellerDescription',  
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


function textCounter(field,cnt, maxlimit) {         
  var cntfield = document.getElementById(cnt) 
     if (field.value.length > maxlimit) // if too long...trim it!
    field.value = field.value.substring(0, maxlimit);
    // otherwise, update 'characters left' counter
    else
    cntfield.value = maxlimit - field.value.length;
}
/*=====  End of pop-up for seller description  ======*/ 

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
</script>
