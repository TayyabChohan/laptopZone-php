<?php $this->load->view('template/header');?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $pageTitle ; ?>
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo $pageTitle ; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      <div class="col-sm-12">  
      <div class="box " >
            <div class="box form-scroll" >
              <div class="box-header">
                <h3 class="box-title"><?php echo $pageTitle ; ?></h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body ">
              <div class="col-sm-12">
                <div class="col-sm-1"> 
                <label for="Auction ID" class="control-label">Auction Id:</label> 
                  <div class="form-group">  
                    <input style = "color:blue;" type="text" name="auction_id" id="auction_id" class="form-control" link = "<?php echo $data['mast_det'][0]['AUCTION_URL'];?>" value = "<?php echo $data['mast_det'][0]['VENDOR_AUCTION_ID'];?>" readonly >
                            
                  </div>
                </div>
                <div class="col-sm-4">
                  <label for="Auc desc" class="control-label">Auction Description:</label> 
                  <div class="form-group">  
                    <input type="text" name="auction_id" id="auction_id" class="form-control" value = "<?php echo $data['mast_det'][0]['AUCTION_DESCRIPTION'];?>" readonly >
                            
                  </div>
                </div>
                <div class="col-sm-2">
                  <label for="Ebay ID" class="control-label">Condition:</label> 
                  <div class="form-group">  
                    <input type="text" name="auction_id" id="auction_id" class="form-control" value = "<?php echo $data['mast_det'][0]['CONDITION'];?>" readonly >
                            
                  </div>
                </div>
                <div class="col-sm-2">
                  <label for="Ebay ID" class="control-label">Time left:</label> 
                  <div class="form-group">  
                    <input type="text" name="auction_id" id="auction_id" class="form-control" value = "<?php echo $data['mast_det'][0]['TIME_LEFT'];?>" readonly >
                            
                  </div>
                </div>
                <div class="col-sm-2">
                  <label for="Ebay ID" class="control-label">Current Bid:</label> 
                  <div class="form-group">  
                    <input type="text" name="auction_id" id="auction_id" class="form-control" value = "$ <?php echo number_format((float)@$data['mast_det'][0]['CURRENT_BID'],2,'.',',');?>" readonly >
                            
                  </div>
                </div>
                <div class="col-sm-1">
                  <label for="Ebay ID" class="control-label">No of Item:</label> 
                  <div class="form-group">  
                    <input type="text" name="auction_id" id="auction_id" class="form-control" value = "<?php echo $data['mast_det'][0]['NO_OF_ITEM'];?>" readonly >
                            
                  </div>
                </div>
                  
              </div>
                <table  id= "" class="table table-bordered table-striped">
                    <thead>
                      <tr>                                       
                        <!-- <th >Vendor Auction Id</th>                   
                        <th>Acution Description</th>
                        <th>Conition</th>
                        <th>Time Left</th>
                        <th style =" text-align:center; ">Current Bid</th>
                        <th style =" text-align:center; ">No Of Items</th> -->
                        <th style =" text-align:center; ">Est Sale</th>
                        <th style =" text-align:center; ">Ebay Fee</th>
                        <th style =" text-align:center; ">Paypal Fee</th>
                        <th style =" text-align:center; ">Ship Fee</th>
                        <th style =" text-align:center; ">Net Amount</th>
                        <th style =" text-align:center; ">Offer On Net Amount</th>
                        <th style =" text-align:center; ">Qty Sold</th>
                        <th style =" text-align:center; ">Sell Through</th>
                        <th style =" text-align:center; ">Watch Count Avg</th>
                        <th style =" text-align:center; ">Orignal Weight</th>
                        <th style =" text-align:center; ">Manifest Weight</th>
                        <th style =" text-align:center; ">Package Type</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                         <?php 
                         foreach($data['mast_det'] as $row) :?>
                        <!-- <td><a href="<?php //echo $row['AUCTION_URL'];?>" target="_blank"><?php //echo $row['VENDOR_AUCTION_ID'];?></a></td>
                        <td><?php //echo $row['AUCTION_DESCRIPTION'];?></td>
                        <td><?php //echo $row['CONDITION'];?></td>
                        <td><?php //echo $row['TIME_LEFT'];?></td>
                        <td><div >$ <?php //echo number_format((float)@$row['CURRENT_BID'],2,'.',',');?></div></td>  
                        <td><div ><?php //echo $row['NO_OF_ITEM'];?></div></td>   -->         
                                      
                        <td><div >$ <?php echo number_format((float)@$row['EST_SALE'],2,'.',',');?></div></td>                
                        <td><div >$ <?php echo number_format((float)@$row['EBAY'],2,'.',',');?></div></td>                
                        <td><div >$ <?php echo number_format((float)@$row['PAYPAL'],2,'.',',');?></div></td>                
                        <td><div >$ <?php echo number_format((float)@$row['SHIP_FEE'],2,'.',',');?></div></td>                   
                        <td><div >$ <?php echo number_format((float)@$row['NET_AMOUNT'],2,'.',',');?></div></td>                   
                        <td style ="text-align:center;color: #f5f5f5;background-color: #f32c14;"><div>$ <?php echo number_format((float)@$row['OFFER_ON_NET_AMOUNT'],2,'.',',');?></div></td> 
                        <td><div><?php echo $row['QTY_SOLD'];?></div></td>             
                        <td><div><?php echo $row['SELL_THROU'];?></div></td>     
                        <td><div><?php echo $row['WATCH_COUNT_AVG'];?></div></td>  
                        <td><div ><?php echo number_format((float)@$row['TOTAL_WEIGHT'],2,'.',',');?> lb</div></td>     
                        <td><div ><?php echo number_format((float)@$row['SHIPPING_WEIGHT'],2,'.',',');?> lb</div></td>     
                        <td><div ><?php echo @$row['PACKAGE_COUNT'];?></div></td>     

                      </tr>
                      <?php 
                        endforeach; ?>
                    </tbody> 
                    </table> 
              </div>
              <!-- /.box-body -->
            </div>
      </div> 
    </div>   


    </div>
<div class="row">
  <div class="col-sm-6">
    <div class="box box-success" >
            <div class="box-header with-border">
              <h3 class="box-title">Search Criteria</h3>
            </div>
              <div class="box-body table-responsive no-padding" style="height:200px;">
                 <?php $lz_auction_id = $this->uri->segment(4);?>
               <form action="<?php echo base_url();?>catalogueToCash/c_tl_auction/load_auction_detail_data/<?php echo $lz_auction_id?>" method="post" accept-charset="utf-8">
              
              <div class="col-sm-6">
                <?php $get_keywod = $this->session->userdata('auc_key'); ?>
                  <label for="Search Keywordr" class="control-label">Search Keyword:</label>
                  <div class="form-group">
                    <input type="text" name="auc_key" id="auc_key" value="<?php echo $get_keywod?>" class="form-control" >
                  </div>
              </div>
              <div class="col-sm-3">
              <label for="Search Keywordr" class="control-label">Search in:</label>
                <?php $searchRadio = $this->session->userdata('searchRadio'); 
                if(!empty($searchRadio)){
                  if($searchRadio == "Brand"){
                    $brandFilter = "checked=\"checked\"";
                    $bothFilter = "";
                    $descFilter = "";
                  }else if($searchRadio == "Desc"){
                    $descFilter = "checked=\"checked\"";
                    $bothFilter = "";
                    $brandFilter = "";
                  }else{
                    $bothFilter = "checked=\"checked\"";
                    $brandFilter = "";
                    $descFilter = "";
                  }
                }else{
                  $bothFilter = "checked=\"checked\"";
                  $brandFilter = "";
                  $descFilter = "";
                }
                ?>
                  <div class="form-group">
                    <input type="radio" name="searchRadio" id="searchRadio" title="Brand Only" value="Brand" <?php echo $brandFilter; ?>> Brand
                    <input type="radio" name="searchRadio" id="searchRadio" title="Description Only" value="Desc" <?php echo $descFilter; ?>> Desc
                    <input type="radio" name="searchRadio" id="searchRadio" title="Both" value="Both" <?php echo $bothFilter; ?>> Both
                  </div>
                </div> 
              <div class="col-sm-2">
                <?php $prof_perc = $this->session->userdata('prof_perc'); 
                if(!empty($prof_perc)){

                }else{
                  $prof_perc = 30;
                }
                ?>
                  <label for="Search Keywordr" class="control-label">PL %:</label>
                  <div class="form-group">
                    <input type="number" name="prof_perc" id="prof_perc" value="<?php echo $prof_perc; ?>" class="form-control" Placeholder = "30" >
                  </div>
              </div>
              <div class="col-sm-1 p-t-24 ">
                <div class="form-group ">
<!--                 <input type="submit" name="serc_key" id="serc_key" value="search" class="btn btn-primary form-control ">    -->
                <button name="serc_key" id="serc_key" value="search" class="btn btn-primary form-control " type="submit"><i class="glyphicon glyphicon-search"></i></button>              
                </div>
              </div>
              </form>
              <div class="col-sm-4"><!-- total amount -->
                <?php $get_keywod = $this->session->userdata('auc_key'); ?>
                  <label for="Search Keywordr" class="control-label">Total Amount:</label>
                  <div class="form-group">
                    <input type="text"  value="<?php echo '$ '. $data['auc_sumr'][0]['TOTAL_AMOUNT'];?>" class="form-control" readonly >
                  </div>
              </div>
              <div class="col-sm-4"><!-- total qty -->
                <?php $get_keywod = $this->session->userdata('auc_key'); ?>
                  <label for="Search Keywordr" class="control-label">Total Qty:</label>
                  <div class="form-group">
                    <input type="number"  value="<?php echo $data['auc_sumr'][0]['QTY'];?>" class="form-control" readonly >
                  </div>
              </div> 
              <div class="col-sm-4"><!-- total qty -->
                <?php $get_keywod = $this->session->userdata('auc_key'); ?>
                  <label for="Search Keywordr" class="control-label">Sell Through:</label>
                  <div class="form-group">
                    <input type="number"  value="<?php echo $data['auc_sumr'][0]['SELL_THROU'];?>" class="form-control" readonly >
                  </div>
              </div>                
              </div>
            <!-- /.box-header -->
            
            <!-- /.box-body -->
    </div> 
  </div>

  <div class="col-sm-6">  
    <div class="box box-success" >
            <div class="box-header">
              <h3 class="box-title">Top Brands</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body form-scroll" style="height:200px;">

                <table  id= "top_brand" class="table table-responsive table-striped table-bordered table-hover" >

                      <thead>
                        <th>Action</th>                   
                        <th>Brands</th>                   
                        <th>Qty</th>
                        <th>Avg Sold Price</th>
                        <th>Total Price</th>
                        <th>Type</th>
                      </thead>
                    <tbody>
                    
                      <?php
                      $j=1;
                      foreach($data['top_brand'] as $row) :?>
                      <tr>
                      <!-- 1 for cash and 2 for salvage -->
                      <td><div><button name="brnd_cash" title="Cash" id="<?php echo $j?>" value="1" class="btn btn-sm btn-success brnd_cash"><span class="glyphicon glyphicon-ok " aria-hidden="true"></span></button> <button name="brand_salvage" value="2" id="<?php echo $j?>" title="Salvage" class=" btn btn-sm btn-danger brand_salvage"><span class="glyphicon glyphicon-remove " aria-hidden="true"></span></button></div><input type="hidden" name="get_b_name" id="get_b_name_<?php echo $j; ?>" value= "<?php echo $row['BRAND']; ?>" ><input type="hidden" name="get_uri" id ="get_uri" value="<?php echo $lz_auction_id; ?>">
                        
                      </td>
                      <td><?php echo $row['BRAND'];?></td>
                      <td><?php echo $row['BRND_QTY'];?></td>
                      <td><?php echo $row['AVG_SOLG'];?></td>
                      <td><?php echo $row['TOTAL'];?></td>
                      <td><?php echo $row['BRAND_TYPE'];?></td>
                    </tr>
                    <?php $j++;
                      endforeach; ?>
                  </tbody> 
                </table> 

            <!-- /.box-body -->
            </div>

    </div>
  </div>
</div><!-- /.row div close -->
<div class="row">
  <div class="col-sm-6">  
      <div class="box box-success " >
            <div class="box" >
              <div class="box-header">
                <h3 class="box-title">Cash</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body " style="height:150px;">
              <div class="form-scroll">
                <table  id= "" class="table table-bordered table-striped">
                      <thead>
                        <tr>                                     
                          <th style =" text-align:center; " title="No of Item" >Qty</th>
                          <th style =" text-align:center; " title="Estimate Sale Value">Est Sale</th>
                          <th style =" text-align:center; " title="eBay Fee">Ebay</th>
                          <th style =" text-align:center; " title="Paypal fee">Paypal</th>
                          <th style =" text-align:center; " title="Ship Fee">Ship</th>
                          <th style =" text-align:center; " title="Net Amount">Net Amt</th>
                          <th style =" text-align:center; " title="Offer Amount">Offer</th>
                          <th style =" text-align:center; " title="Qty Sold">Qty Sold</th>
                          <th style =" text-align:center; " title="Sell Trou">Sell Throu</th>
                          <th style =" text-align:center; " title="Watch Count Avg">Watch Count</th>
                          <th style =" text-align:center; " title="Orignal Weight">Weight</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                           <?php 
                           foreach($data['master_serch_key'] as $auc_item) :?>
                         
                          <td><div style =" text-align:center;"><?php echo @$auc_item['NO_OF_ITEM'];?></div></td>                
                          <td><div style =" text-align:center; width: 100px;">$ <?php echo number_format((float)@$auc_item['EST_SALE'],2,'.',',');?></div></td>                
                          <td><div style =" text-align:center; width: 100px;">$ <?php echo number_format((float)@$auc_item['EBAY'],2,'.',',');?></div></td>                
                          <td><div style =" text-align:center; width: 100px;">$ <?php echo number_format((float)@$auc_item['PAYPAL'],2,'.',',');?></div></td>                
                          <td><div style =" text-align:center; width: 100px;">$ <?php echo number_format((float)@$auc_item['SHIP_FEE'],2,'.',',');?></div></td>                   
                          <td><div style =" text-align:center; width: 100px;">$ <?php echo number_format((float)@$auc_item['NET_AMOUNT'],2,'.',',');?></div></td>                   
                          <td style ="text-align:center;color: #f5f5f5;background-color: #f32c14;"><div style =" text-align:center; width: 100px;">$ <?php echo number_format((float)@$auc_item['OFFER_ON_NET_AMOUNT'],2,'.',',');?></div></td> 
                          <td><div style =" text-align:center;"><?php echo $auc_item['QTY_SOLD'];?></div></td>             
                          <td><div style =" text-align:center;"><?php echo $auc_item['SELL_THROU'];?></div></td>             
                           <td><div style =" text-align:center;"><?php echo $auc_item['WATCH_COUNT_AVG'];?></div></td>
                           <td><div style =" text-align:center;"><?php echo number_format((float)@$auc_item['TOTAL_WEIGHT'],2,'.',',');?> lb</div></td>               

                        </tr>
                        <?php 
                          endforeach; ?>
                      </tbody> 
                    </table> 
                  </div> <!-- end form scroll -->
              </div>
              <!-- /.box-body -->
            </div>
      </div> 
    </div>

    <div class="col-sm-6">  
      <div class="box box-success " >
            <div class="box" >
              <div class="box-header">
                <h3 class="box-title">Salvage</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body " style="height:150px;">
              <div class="form-scroll">
                <table  id= "" class="table table-bordered table-striped">
                      <thead>
                        <tr>                                     
                          <th style =" text-align:center; " title="No of Item" >Qty</th>
                          <th style =" text-align:center; " title="Estimate Sale Value">Est Sale</th>
                          <th style =" text-align:center; " title="eBay Fee">Ebay</th>
                          <th style =" text-align:center; " title="Paypal fee">Paypal</th>
                          <th style =" text-align:center; " title="Ship Fee">Ship</th>
                          <th style =" text-align:center; " title="Net Amount">Net Amt</th>
                          <th style =" text-align:center; " title="Offer Amount">Offer</th>
                          <th style =" text-align:center; " title="Qty Sold">Qty Sold</th>
                          <th style =" text-align:center; " title="Sell Trou">Sell Throu</th>
                          <th style =" text-align:center; " title="Watch Count Avg">Watch Count</th>
                          <th style =" text-align:center; " title="Orignal Weight">Weight</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                           <?php 
                           foreach($data['master_serch_key_sal'] as $auc_item_sal) :?>
                          
                          <td><div style =" text-align:center;"><?php echo @$auc_item_sal['NO_OF_ITEM'];?></div></td>                
                          <td><div style =" text-align:center; width: 100px;">$ <?php echo number_format((float)@$auc_item_sal['EST_SALE'],2,'.',',');?></div></td>                
                          <td><div style =" text-align:center; width: 100px;">$ <?php echo number_format((float)@$auc_item_sal['EBAY'],2,'.',',');?></div></td>                
                          <td><div style =" text-align:center; width: 100px;">$ <?php echo number_format((float)@$auc_item_sal['PAYPAL'],2,'.',',');?></div></td>                
                          <td><div style =" text-align:center; width: 100px;">$ <?php echo number_format((float)@$auc_item_sal['SHIP_FEE'],2,'.',',');?></div></td>                   
                          <td><div style =" text-align:center; width: 100px;">$ <?php echo number_format((float)@$auc_item_sal['NET_AMOUNT'],2,'.',',');?></div></td>                   
                          <td style ="text-align:center;color: #f5f5f5;background-color: #f32c14;"><div style =" text-align:center; width: 100px;">$ <?php echo number_format((float)@$auc_item_sal['OFFER_ON_NET_AMOUNT'],2,'.',',');?></div></td> 
                          <td><div style =" text-align:center;"><?php echo $auc_item_sal['QTY_SOLD'];?></div></td>             
                          <td><div style =" text-align:center;"><?php echo $auc_item_sal['SELL_THROU'];?></div></td>             
                           <td><div style =" text-align:center;"><?php echo $auc_item_sal['WATCH_COUNT_AVG'];?></div></td>  
                           <td><div style =" text-align:center;"><?php echo number_format((float)@$auc_item_sal['TOTAL_WEIGHT'],2,'.',',');?> lb</div></td>            

                        </tr>
                        <?php 
                          endforeach; ?>
                      </tbody> 
                    </table> 
                  </div> <!-- end form scroll -->
              </div>
              <!-- /.box-body -->
            </div>
      </div> 
    </div>
    
</div> 

    <div class="row">
      <div class="col-sm-12">  
        <div class="box box-success" >

              <div class="box-header">
                <h3 class="box-title">(Cash + Other) - Salvage</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
              <div class="form-scroll">
                <table  id= "auction_detailst" class="table table-bordered table-striped">
                    <thead>
                      <tr>                                       
                                                            
                        <th style =" text-align:center; " title="No of Item" >Qty</th>
                        <th style =" text-align:center; " title="Estimate Sale Value">Est Sale</th>
                        <th style =" text-align:center; " title="eBay Fee">Ebay</th>
                        <th style =" text-align:center; " title="Paypal fee">Paypal</th>
                        <th style =" text-align:center; " title="Ship Fee">Ship</th>
                        <th style =" text-align:center; " title="Net Amount">Net Amt</th>
                        <th style =" text-align:center; " title="Offer Amount">Offer</th>
                        <th style =" text-align:center; " title="Qty Sold">Qty Sold</th>
                        <th style =" text-align:center; " title="Sell Trou">Sell Throu</th>
                        <th style =" text-align:center; " title="Watch Count Avg">Watch Count</th>
                        <th style =" text-align:center; " title="Orignal Weight">Weight</th>
                        
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                         <?php 
                         foreach($data['mast_det'] as $row) :?>
 
                        <td><div class="pull-right" ><?php echo $row['NO_OF_ITEM'] - @$data['master_serch_key_sal'][0]['NO_OF_ITEM'];?></div></td>                      
                                      
                        <td><div class="pull-right" >$ <?php echo number_format((float)@$row['EST_SALE'] - @$data['master_serch_key_sal'][0]['EST_SALE'],2,'.',',');?></div></td>                
                        <td><div class="pull-right" >$ <?php echo number_format((float)@$row['EBAY'] - @$data['master_serch_key_sal'][0]['EBAY'],2,'.',',');?></div></td>                
                        <td><div class="pull-right" >$ <?php echo number_format((float)@$row['PAYPAL'] - @$data['master_serch_key_sal'][0]['PAYPAL'],2,'.',',');?></div></td>                
                        <td><div class="pull-right" >$ <?php echo number_format((float)@$row['SHIP_FEE'] - @$data['master_serch_key_sal'][0]['SHIP_FEE'],2,'.',',');?></div></td>                   
                        <td><div class="pull-right" >$ <?php echo number_format((float)@$row['NET_AMOUNT'] - @$data['master_serch_key_sal'][0]['NET_AMOUNT'],2,'.',',');?></div></td>                   
                        <td><div class="pull-right" >$ <?php echo number_format((float)@$row['OFFER_ON_NET_AMOUNT'] - @$data['master_serch_key_sal'][0]['OFFER_ON_NET_AMOUNT'],2,'.',',');?></div></td> 
                        <td><div class="pull-right" ><?php echo $row['QTY_SOLD'] - @$data['master_serch_key_sal'][0]['QTY_SOLD'];?></div></td>             
                        <td><div class="pull-right" ><?php echo $row['SELL_THROU'] - @$data['master_serch_key_sal'][0]['SELL_THROU'];?></div></td>             
                        <td><div class="pull-right" ><?php echo $row['WATCH_COUNT_AVG'] - @$data['master_serch_key_sal'][0]['WATCH_COUNT_AVG'];?></div></td> 
                        <td><div style =" text-align:center;"><?php echo number_format((float)@$auc_item['TOTAL_WEIGHT'] - @$data['master_serch_key_sal'][0]['TOTAL_WEIGHT'] ,2,'.',',');?> lb</div></td>

                      </tr>
                      <?php 
                        endforeach; ?>
                    </tbody> 
                    </table> 
                  </div><!-- /.form scroll div -->
              </div><!-- /.box-body -->
            </div> <!-- /.box -->
        </div>   <!-- /.col-sm-12 -->
    </div><!-- /.row -->


      <div class="row">
        <div class="col-sm-12">

          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Auction Items Details</h3>
            </div>


            <!-- /.box-header -->
            <div class="box-body">
            <div class="col-sm-12">
              <div class="form-group pull-right">
                <button id="get_cat_all" class="btn btn-primary" >Get Categories</button>
                <button id="move_data" class="btn btn-danger " >Move Data</button>
              </div>

            </div>
            <br><br><br>

            <!-- auction table start -->
            <div class="form-scroll">
            <table id="auction_det_details" class="table table-bordered table-striped">
    
                <thead>
                  <tr>
                    <!-- <th >Action</th> -->
                    <th>Action</th>                   
                    <th >Item Desciption</th>                   
                    <th>Mpn</th>
                    <th>Qty</th>
                    <th>Avg Sold Price</th>
                    <th>Qty Sold</th>                    
                    <th>Object Name</th>
                    <th>Average Sold</th>
                    <th>Category Id</th>
                    <!-- <th>Upc</th>
                    <th>Sku</th> -->
                    <th>BestBuy Upc</th>
                    <th>BestBuy Mpn</th>
                    <th>SKU </th>
                    <th>BRAND</th>
                    <th>Weight</th>
                    <th>sort_obj</th>
                    <th>sort_category</th>
                    

                  </tr>
                </thead>
                <tbody>
  
                    <?php 
                    // $get_auc = $data['auc_detail'][0]['LZ_AUCTION_ID'];
                    // var_dump($get_auc);
                    $j = 1;
                    foreach($data['auc_detail'] as $row) :
                      if(!empty($row['ITEM_TYPE'])){
                        if($row['ITEM_TYPE'] == 1){
                          $tr_clr = "style = \"background-color:#b3e48d;\"";
                        }elseif($row['ITEM_TYPE'] == 2){
                          $tr_clr = "style = \"background-color:#ffc6c6;\"";
                        }else{
                          $tr_clr = "";
                        }

                      }else{
                        $tr_clr = "";
                      }
                    $i= $row['LZ_AUCTION_DET_ID'];
                    echo "<tr ".$tr_clr.">";
                    ?>
                    
                    <td><div><button name="det_brnd_cash" title="Cash" id="<?php echo $i?>" value="1" class="btn btn-sm btn-success det_brnd_cash"><span class="glyphicon glyphicon-ok " aria-hidden="true"></span></button> <button name="det_brand_salvage" value="2" id="<?php echo $i?>" title="Salvage" class=" btn btn-sm btn-danger det_brand_salvage"><span class="glyphicon glyphicon-remove " aria-hidden="true"></span></button></div><input type="hidden" name="get_check_det_id" id="get_check_det_id_<?php echo $i; ?>" value= "<?php echo $row['BRAND']; ?>" ><input type="hidden" name="get_uri" id ="get_uri" value="<?php echo $lz_auction_id; ?>"></td>
                    <!-- <td>View</td> -->
                    <td><?php echo $row['ITEM_DESCRIPTION'];?>
                      <input type="hidden" name="get_auc_uri_id" id= "get_auc_uri_id" value="<?php echo $data['auc_detail'][0]['LZ_AUCTION_ID'];?>">
                    </td>
                    <?php if(!empty($row['API_URL'])){?>                  
                    <td><a href="<?php echo $row['API_URL'];?>" target ="_blank"><?php echo $row['MPN'];?></a></td>
                    <?php }else {?>
                    <td><?php echo $row['MPN'];?></td>
                    <?php }?>
                    <td><?php echo $row['QUANTITY'];?></td>
                    <td ><?php echo '$ '.number_format((float)@$row['AVG_SOLD_PRICE'],2,'.',',') ;?></td>
                    <td style="color: white; background-color: #4fbb4f; "><?php echo $row['QTY_SOLD'];?></td>

                    <?php if(!empty($row['OBJECT_NAME'])){?>
                    <td ><div><input type="text" class="form-control obj_name" value ="<?php echo $row['OBJECT_NAME'];?>"  name="obj_name_<?php echo $i; ?>" id="obj_name_<?php echo $i; ?>" placeholder="Enter Object Name">
                    <button style="margin-top:5px;" type="button" title="Get Category Object" class="btn btn-success btn-xs get_object" id="<?php echo $i; ?>" rowIndex = "<?php echo $j; ?>" style="height: 28px; margin-bottom: auto;">Get Object</button></div>
                    <div id="object_dd_<?php echo $j; ?>" style="margin-top:5px;"></div></td>
                    <?php }else{?>
                     <td><div><input type="text" class="form-control obj_name" value ="" name="obj_name_<?php echo $i; ?>" id="obj_name_<?php echo $i; ?>"  placeholder="Enter Object Name">
                     <button style="margin-top:5px;" type="button" title="Get Category Object" class="btn btn-success btn-xs get_object" id="<?php echo $i; ?>" rowIndex = "<?php echo $j; ?>" style="height: 28px; margin-bottom: auto;">Get Object</button>
                     </div>
                     <div id="object_dd_<?php echo $j; ?>" style="margin-top:5px;"></div> </td>
                     <?php }?>
                     <!-- avergae sold -->
                    <?php if(!empty($row['AVG_SOLD_PRICE'])){?>
                    <td><div style="width: 80px;">  <input style="width: 80px;" type="number" name="get_avg_pric<?php echo $i; ?>" id="get_avg_pric<?php echo $i; ?>" class="form-control input-sm obj_cat_id" value="<?php echo $row['AVG_SOLD_PRICE']?>" style="width:110px;" placeholder="Enter Cost"></div></td>
                    <?php }else{?>
                     <td><div style="width: 80px;">  <input style="width: 80px;" type="number" name="get_avg_pric<?php echo $i; ?>" id="get_avg_pric<?php echo $i; ?>" class="form-control input-sm obj_cat_id" value="0.00" style="width:110px;" placeholder= "Enter Cost"></div></td>
                     <?php }?>
                     <!-- avergae sold -->

                     <?php if(!empty($row['CATEGORY_ID'])){?>
                    <td><div style="width: 160px;">  <input type="number" name="obj_cat_id_<?php echo $i; ?>" id="obj_cat_id_<?php echo $i; ?>" class="form-control input-sm obj_cat_id" value="<?php echo $row['CATEGORY_ID']?>" style="width:110px;" placeholder="Enter Category Id"> <div class="pull-right"> <button type="button" title="Save Category Id" class="btn btn-success btn-xs Save_obj" id="<?php echo $i; ?>" style="height: 28px; margin-bottom: auto;">Save</button> </div></div></td>
                    <?php }else{?>
                     <td><div style="width: 160px;">  <input type="number" name="obj_cat_id_<?php echo $i; ?>" id="obj_cat_id_<?php echo $i; ?>" class="form-control input-sm obj_cat_id" value="" style="width:110px;" placeholder= "Enter Category Id"> <div class="pull-right"> <button type="button" title="Save Category Id" class="btn btn-success btn-xs Save_obj" id="<?php echo $i; ?>" style="height: 28px; margin-bottom: auto;">Save</button> </div></div></td>
                     <?php }?>

                    <!-- <td><?php //echo $row['UPC'];?></td>
                    <td><?php //echo $row['SKU'];?></td> -->
                    
                    <td><?php echo $row['BEST_BUY_UPC'];?></td>
                    <td><?php echo $row['BEST_BUY_MPN'];?></td>
                    <td><?php echo $row['SKU'];?></td>
                    <td><?php echo $row['BRAND'];?></td>
                    <td><?php echo $row['WEIGHT'];?></td>
                    <td><?php echo $row['OBJECT_NAME'];?></td>
                    <td><?php echo $row['CATEGORY_ID'];?></td>
                    
                    
                  </tr>
                  
                    <?php 
                    $j++;
                    endforeach; ?>
                </tbody>
             </table>
            </div><!-- form scroll div end -->
            <!-- auction table end -->

            </div>
          </div>
     </div>                    

    </div>
              <div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
      <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="ajax loader" style="width: 100px; height: 100px;">
    </div>

</div>
    </section>
    <!-- /.content -->
  


<?php $this->load->view('template/footer');?>

<script >

$(document).ready(function()
  {
    $('#auction_detailst').DataTable({
    "oLanguage": {
    "sInfo": "Total Records: _TOTAL_"
  },
  "iDisplayLength": 100,
    "paging": false,
    "lengthChange": false,
    "searching": false,

    "ordering": false,
     "order": [[ 1, "asc" ]],
    "info": false,
    "autoWidth": true,
    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
  });

  $('#auction_det_details').DataTable({
    "oLanguage": {
    "sInfo": "Total Records: _TOTAL_"
  },
    //"iDisplayLength": 15,
  //"aLengthMenu": [[15, 50, 100, 200,500, -1], [15, 50, 100, 200,500, "All"]],
    "paging": false,
    "lengthChange": false,
    "searching": true,
    "ordering": true,
    "order": [[ 0, "DESC" ]],
    "info": true,
    "autoWidth": true,
    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
  });
  $('#item_cal').DataTable({
    "oLanguage": {
    "sInfo": "Total Records: _TOTAL_"
  },
  "iDisplayLength": 100,
    "paging": false,
    "lengthChange": false,
    "searching": false,
    "ordering": false,
     "order": [[ 1, "asc" ]],
    "info": false,
    "autoWidth": true,
    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
  });
  $('#get_sal').DataTable({
    "oLanguage": {
    "sInfo": "Total Records: _TOTAL_"
  },
  "iDisplayLength": 100,
    "paging": false,
    "lengthChange": false,
    "searching": false,
    "ordering": false,
     "order": [[ 1, "asc" ]],
    "info": false,
    "autoWidth": true,
    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
  });
    $('#top_brand').DataTable({
    "oLanguage": {
    "sInfo": "Total Records: _TOTAL_"
  },
  "iDisplayLength": 100,
    "paging": false,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
     "order": [[ 1, "asc" ]],
    "info": false,
    "autoWidth": true,
    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
  });
          
});



$(document).on('click','#move_data', function(){

  var get_auc_uri_id =$('#'+'get_auc_uri_id').val()
  
  $.ajax({
        url:'<?php echo base_url(); ?>catalogueToCash/c_tl_auction/move_data',
        
        type:'post',
        dataType:'json',
        data:{'get_auc_uri_id':get_auc_uri_id},

        success:function(data){

        if(data == true){
          alert('record save');
          return false;
        }else{
          alert('Item is alredy posted Or save all object and categories !');
          return false;

        }
      }
    }); 
});

$(document).on('click','.brnd_cash', function(){
 $(".loader").show();
 var brnd_cash_id = $(this).attr('id');
 var type = $(this).val();
 var get_b_nam  =$("#get_b_name_"+brnd_cash_id).val();
 var get_uri  =$("#get_uri").val();

 $.ajax({
        url:'<?php echo base_url(); ?>catalogueToCash/c_tl_auction/cash_item_brand',
        
        type:'post',
        dataType:'json',
        data:{'get_b_nam':get_b_nam,'get_uri':get_uri,'type':type},
        success:function(data){

        $(".loader").hide();

         if(data == true){
            alert('Brand Added To Cash');
            return false;    

         }else if (data == false){
            alert('record Updated');
            return false;
         }
      }
  });
});

 $(document).on('click','.brand_salvage', function(){
 $(".loader").show();
 var brnd_cash_id = $(this).attr('id');
 var type = $(this).val();
 var get_b_nam  =$("#get_b_name_"+brnd_cash_id).val();
 var get_uri  =$("#get_uri").val();

 $.ajax({
        url:'<?php echo base_url(); ?>catalogueToCash/c_tl_auction/cash_item_brand',
        
        type:'post',
        dataType:'json',
        data:{'get_b_nam':get_b_nam,'get_uri':get_uri,'type':type},
        success:function(data){

        $(".loader").hide();

         if(data == true){
            alert('Brand Added To Salvage');
            return false;    

         }else if (data == false){
            alert('record Updated');
            return false;
         }
      }
  });
}); 

$(document).on('click','.det_brnd_cash', function(){
//$(this).css('color','blue');
$(this).removeClass('btn-success')
        $(this).addClass('btn-primary');
 $(".loader").show();
 var det_brnd_cash_id = $(this).attr('id');
 var type = $(this).val();
 var get_uri   = $("#get_uri").val();

 $.ajax({
        url:'<?php echo base_url(); ?>catalogueToCash/c_tl_auction/cash_item',
        
        type:'post',
        dataType:'json',
        data:{'det_brnd_cash_id':det_brnd_cash_id,'get_uri':get_uri,'type':type},
        success:function(data){

        $(".loader").hide();

         if(data == true){
            alert('Item Added To Cash');

            return false;    

         }else if (data == false){
            alert('record Updated');
            return false;
         }
         else if (data == error){
            alert('error');
            return false;
         }
      }
  });
});

$(document).on('click','.det_brand_salvage', function(){
$(this).removeClass('btn-danger')
        $(this).addClass('btn-warning');
 $(".loader").show();
 var det_brnd_cash_id = $(this).attr('id');
 var type = $(this).val();
 var get_uri   = $("#get_uri").val();

 $.ajax({
        url:'<?php echo base_url(); ?>catalogueToCash/c_tl_auction/cash_item',
        
        type:'post',
        dataType:'json',
        data:{'det_brnd_cash_id':det_brnd_cash_id,'get_uri':get_uri,'type':type},
        success:function(data){

        $(".loader").hide(); 

         if(data == true){
            alert('Item Added To Salvage');
            return false;    

         }else if (data == false){
            alert('record Updated');
            return false;
         }
         else if (data == error){
            alert('error');
            return false;
         }
      }
  });
});



$(document).on('click','#get_cat_all', function(){
  var auction_id=$('#get_auc_uri_id').val();
  //console.log(auction_id); return false;
  $.ajax({
        url:'<?php echo base_url(); ?>catalogueToCash/c_tl_auction/getCategory',
        
        type:'post',
        dataType:'json',
        data:{'auction_id':auction_id},

        success:function(data){

        if(data == true){
          alert('record save');
          return false;
        }else{
          alert('Please save all object and categories !');
          return false;

        }
      }
    }); 
});
$(document).on('click','.get_object', function(){
  var rowIndex = $(this).attr('rowIndex');
  //var auction_id=$('#get_auc_uri_id').val();
  var cat_id = $('#auction_det_details tr').eq(rowIndex).find('td').eq(8).find('input').val();
 // console.log(rowIndex,auction_id,cat_id); return false;
  $.ajax({
        url:'<?php echo base_url(); ?>catalogueToCash/c_tl_auction/getCatObj',
        
        type:'post',
        dataType:'json',
        data:{'cat_id':cat_id},

        success:function(data){
//console.log(data[0].OBJECT_ID); //return false;
        if(data.length > 0){
          var html = '<select class="selectpicker form-control obj_dd " data-live-search="true" name="obj_dd" id = "obj_dd_'+rowIndex+'" idx = "'+rowIndex+'" ><option value="0">select</option>';

            for(var i=0; i <data.length; i++) {
              html += '<option value="'+data[i].OBJECT_ID+'">'+data[i].OBJECT_NAME+'</option>';

                // $('<option />', {value: data[0].OBJECT_ID, text:  data[0].OBJECT_NAME}).appendTo(dd);

            }
            html += "</select>";
            //console.log(html);
            $('#object_dd_'+rowIndex).html("");
            $('#object_dd_'+rowIndex).append(html);
            $('#obj_dd_'+rowIndex).selectpicker();
            //html.appendTo('object_dd');
        }else{
          alert('Please save all object and categories !');
          return false;

        }
      }
    }); 
});
$(document).on('click','.Save_obj', function(){
$(".loader").show();
var auc_id=$(this).attr('id');
var obj_cat_id = $("#obj_cat_id_"+auc_id).val();
var obj_name = $("#obj_name_"+auc_id).val();
var get_avg_pric = $("#get_avg_pric"+auc_id).val();
 $.ajax({
        url:'<?php echo base_url(); ?>catalogueToCash/c_tl_auction/save_auc_obj',
        type:'post',
        dataType:'json',
        data:{'auc_id':auc_id,'obj_cat_id':obj_cat_id,'obj_name':obj_name,'get_avg_pric':get_avg_pric},
        success:function(data){

        if(data){
          $(".loader").hide();
          
        }
      }
    }); 
});
$("#auction_id").on('click', function(){
var link = $("#auction_id").attr("link");

window.open(link);

});
$(document).on('change','.obj_dd', function(){
  var indx = $(this).attr('idx');
  dd_id = '#obj_dd_'+indx;
  var t=$( dd_id+" option:selected" ).text();
  $('#auction_det_details tr').eq(indx).find('td').eq(6).find('input').val(t.trim());
  //console.log(t);
  //alert($(this).attr('idx'));

  });

</script>