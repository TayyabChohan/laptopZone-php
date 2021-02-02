<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $pageTitle; ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo $pageTitle; ?></li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content"> 
      <div class="row">
        <div class="box"><br>  
               
          <div class="box-body ">  
               <div class="col-sm-12">
                
                <form action="<?php echo base_url('Analysis/c_Analysis/getData') ?>" method="post" accept-charset="utf-8" target="_blank">
                  <div class="col-sm-3 form-group ">
                    <label>Date Range:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>

                        <?php 
                          $rslt = $this->session->userdata('date_range'); 
                          $price_filter = $this->session->userdata('price_filter');
                          if(empty($price_filter)){
                            $price_filter = 50;
                          }
                        ?>
                        <input type="text" class="btn btn-default" name="date_range" id="daterange-btn" value="<?php echo $rslt; ?>" required>
                    </div>
                  </div>

                  <div class="col-sm-2 "> 
                    <label>Min Price:</label>
                    <div class="input-group">
                      <span class="input-group-addon">US $</span>
                      <input type="number" step="0.01" min="0" class="form-control" name="price" id="price" value="<?php echo $price_filter; ?>" required/>
                      <!--<input id="price" type="text" class="money form-control" data-mask="000,000,000,000,000.00" data-mask-clearifnotmatch="true" name="price" value="<?php //echo @$data_get['result'][0]->EBAY_PRICE; ?>"/>-->
                    </div>
                  </div>
                  <div class="col-sm-2 p-t-24">
                  <div class="form-group">
                    <input type="button" title = "Filter Downloaded Data" class="btn btn-primary" name="serach_data" id="serach_data" value="Search">
                  </div>
                </div>  
                  <div class="col-sm-2 p-t-24 pull-right">
                    <div class="form-group">
                      <input type="submit" class="btn btn-primary" name="Submit" title = "Get Data from eBay" value="Get Data">
                    </div>
                  </div>                                 
                </form>
                 
              </div>
            <div class="col-md-12 form-scroll">
              <!-- Custom Tabs -->
              
                    <table id="purchasing-table" class="table table-responsive table-striped table-bordered table-hover">
                      <thead>
                        <th style ="text-align:center;">Action</th>
                        <th style =" text-align:center; ">eBay Id</th>
                        <th style =" text-align:center; ">Item Desc</th>
                        <th style =" text-align:center; ">List Date</th>
                        <th style =" text-align:center; ">List by</th>
                        <th style =" text-align:center; ">Condition</th>
                        <th style =" text-align:center; ">Brand</th>
                        <th style =" text-align:center; ">MPN</th>
                        <th style =" text-align:center; ">UPC</th>
                        <th style =" text-align:center; ">List Price</th>
                        <th style =" text-align:center; ">List Qty</th>
                        <th style =" text-align:center; ">Max Price Sold</th>
                        <th style =" text-align:center; ">Min Price Sold</th>
                        <th style =" text-align:center; ">Avg Price Sold</th>
                        <th style =" text-align:center; ">Qty Sold</th>
                        <th style =" text-align:center; ">Active Qty</th>
                        <th style =" text-align:center; ">Rank</th>
                        <th style =" text-align:center; ">Sold Keyword</th>
                        <th style =" text-align:center; ">Active Keyword</th>
                        <th style =" text-align:center; ">Updated By</th>
                        
                         
                      </thead>
                      <tbody>
                      
                        <?php foreach($data['get_list'] as $row) :
                        $clr_tr = "";
                        if($row['LISTER_ID'] == 49){
                          $clr_tr = "class = 'bg-ltgrn'";
                        }

                        ?>
                          <tr <?php echo $clr_tr ?>>
                          
                      <td>

                        <a style=" margin-right: 3px;" href="<?php echo base_url(); ?>tolist/c_tolist/seed_view/<?php echo @$row['SEED_ID'].'/'.$row['EBAY_ITEM_ID']; ?>" title="Print Sticker" class="btn btn-primary btn-sm" target="_blank">
                          <span class="glyphicon glyphicon-leaf" aria-hidden="true"></span>
                         </a>
                         <!-- <a style=" margin-right: 3px;" href="<?php //echo base_url(); ?>locations/c_create_lot/my_lot_items_dettail/<?php //echo @$row['LIST_ID']; ?>" title="Details" class="btn btn-info btn-sm" target="_blank">
                          <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                         </a> -->
                      </td>
                    
                      <?php

                       $url1 = 'https://www.ebay.com/sch/';
                       //$cat_name = str_replace(array(" ","&","/"), '-', @$category_name);
                       //$cat_id = @$data['masterInfo'][0]['CATEGORY_ID'];
                       $url2 = @$row['CATEGORY_ID'].'/';
                       //var_dump($url2);exit;
                       //$url3 = 'i.html?LH_BIN=1&_from=R40&_sop=10&LH_ItemCondition='.@$row['CONDITION_ID']; // sop=10 Newly listed
                       $url3 = 'i.html?LH_BIN=1&_from=R40&_sop=12&LH_ItemCondition='.@$row['CONDITION_ID']; // sop=12 Best match
                       $url4 = '&_nkw='.@$row['ACTIVE_KEY'];
                       
                      
                       $url5 = '&LH_Complete=1&LH_Sold=1'; // for sold data
                       $final_url_active = $url1.$url2.$url3.$url4;
                       $final_url_sold = $final_url_active.$url5;
                       //var_dump($final_url);exit;
                        //echo $final_url; 
                        ?>

                      <td> <a href="https://www.ebay.com/itm/<?php echo @$row['EBAY_ITEM_ID'];?>" title="eBay Link" target="_blank">
                          <?php echo @$row['EBAY_ITEM_ID'];?>
                         </a> </td>
                      <td><?php echo @$row['EBAY_ITEM_DESC'];?></td>
                      <td><?php echo @$row['LIST_DATE'];?></td>
                      <td><?php echo @$row['LISTED_BY'];?></td>
                      <td><?php echo @$row['CONDITION_ID'];?></td>
                      <td><?php echo @$row['BRAND'];?></td>
                      <td><?php echo @$row['MPN'];?></td>
                      <td><?php echo @$row['UPC'];?></td>
                      <td><?php echo @$row['LIST_PRICE'];?></td>
                      <td><?php echo @$row['LIST_QTY'];?></td>
                      <td><?php echo @$row['MAX_PRICE'];?></td>
                      <td><?php echo @$row['MIN_PRICE'];?></td>
                      <td><?php echo @$row['AVG_PRICE'];?></td>
                      <td><?php echo @$row['QTY_SOLD'];?></td>
                      <td><?php echo @$row['ACTIVE_QTY'];?></td>
                      <td><?php echo @$row['ITEM_RANK'];?></td>
                      
                      <td>
                          <a style="" href="<?php echo @$final_url_sold; ?>" target= "_blank" ><?php echo @$row['SOLD_KEY']; ?> </a>
                      </td>
                      <td>
                        <a style="" href="<?php echo @$final_url_active; ?>" target= "_blank" ><?php echo @$row['ACTIVE_KEY']; ?> </a>
                      </td>
                      <td><?php echo @$row['STATUS'];?></td>
                      </tr>
                        <?php endforeach; ?>
                        
                        
                      </tbody> 
                     
                    </table>
                    <!-- nav-tabs-custom -->
                  </div>
                <!-- /.col --> 
                </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
        <!-- /.col -->
        </div>
      <!-- /.row -->
    </section>
    <div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
      <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="ajax loader" style="width: 100px; height: 100px;">
    </div>
    <!-- /.content -->
  </div>    
<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>
 <script>
$(document).ready(function()
  {
     $('#purchasing-table').DataTable({
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
          
});

 $("#serach_data").click(function(){

    var date_range     = $("#daterange-btn").val();
    var price_filter     = $("#price").val();
    // console.log(date_range,price);
    // return false;
    if (date_range == '' || date_range == null)
    {
      alert("Warning: Date Range is required");
      $("#daterange-btn").focus();
      return false;
    }
    $('.loader').show();
    $.ajax({
      url: '<?php echo base_url() ?>Analysis/c_Analysis/filterData',
      type: 'POST',
      datatype : "json",
      data: {'date_range':date_range,'price_filter':price_filter},
      complete: function (data){
          $(".loader").hide();
            window.location.reload();
      
            //var new_url = '<?php //echo base_url() ?>itemsToEstimate/C_itemsToEstimate/showData'; 
            //window.open(new_url, '_blank');
      },
      error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
    } 
      });
    });  
</script>