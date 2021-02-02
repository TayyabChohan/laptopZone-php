<?php $this->load->view('template/header');?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
	<section class="content-header">
	  <h1>
	   Big Data
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	    <li class="active">verify data </li>
	  </ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="row">
    <div class="col-sm-12">
      <div class="box">
        <div class="box-body">
          <div class="col-sm-12">
              <form action="<?php echo base_url(); ?>bigData/c_bd_recognize_data/queryData" method="post" accept-charset="utf-8">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="Search Webhook">Search:</label>
                      <input type="text" name="bd_search" class="form-control" value="<?php echo $this->session->userdata('bd_search_data'); ?>">                      
                  </div>
                </div> 
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="Conditions" class="control-label">Category:</label>
                    <select name="bd_category" class="form-control selectpicker" required="required" data-live-search="true">
                      <option value="">---</option>
                      <?php                                
                         if(!empty($getCategories)){
                          foreach ($getCategories as $cat){
                              ?>
                              <option value="<?php echo $cat['CATEGORY_ID']; ?>" <?php if($this->session->userdata('bd_categoryId') == $cat['CATEGORY_ID']){echo "selected";}?>> <?php echo $cat['CATEGORY_NAME'].'-'.$cat['CATEGORY_ID']; ?>
                              </option>
                              <?php
                              } 
                          }
                      ?>  
                                          
                    </select>  
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group p-t-24">
                    <input type="submit" class="btn btn-primary btn-sm" name="bd_submit" id="bd_submit" value="Search">
                  </div>
                </div>

              </form>                                            
          </div>
        </div>
      </div> <!-- box -->


       <div class="box">

          <div class="box-body form-scroll">
             
            <div class="col-sm-12">

                    <table id="recognizeData" class="table table-responsive table-striped table-bordered table-hover" >
                    <thead>
                        <th>CATA ID</th>
                        <th>CATEGORY ID</th>
                        <th>CATEGORY NAME</th>
                        <th>EBAY ID</th>
                        <th>TITLE</th>
                        <th>CONDITION</th>
                        <th>SALE PRICE</th>
                        <th>LISTING TYPE</th>
                        <th>START TIME </th>
                        <th>SALE TIME </th>
                        <th>SELLER ID</th>
                        <th>FEEDBACK SCORE</th>
                        <th>CURRENCY ID</th>
                        
                    </thead>
                     <tbody>
                <?php foreach ($varifies as $verify):?>
              
                        <tr>

                           <td><a target="_blank" href="<?php echo base_url(); ?>bigData/c_bd_recognize_data/verifyDataDetail/<?php echo $verify['LZ_BD_CATA_ID'].'/'.$verify['CATEGORY_ID']; ?>" id="" class="btn btn-primary btn-xs" title="Show Detail">
                                 <i style=" cursor: pointer;" class="fa fa-external-link" aria-hidden="true"></i>
                                </a></td>
                           <td><?php echo $verify['CATEGORY_ID']; ?></td>
                           <td><?php echo $verify['CATEGORY_NAME']; ?></td>
                           <td><a target='_blank' href='<?php echo $verify['ITEM_URL'];?>'><?php echo $verify['EBAY_ID']?></a>
                           </td>
                           <td><?php echo $verify['TITLE']; ?></td>
                           <td><?php echo $verify['CONDITION_NAME']; ?></td>
                           <td><?php echo '$ '.number_format((float)@$verify['SALE_PRICE'],2,'.',','); ?>
                           </td> 
                           <td><?php echo $verify['LISTING_TYPE']; ?></td>
                           <td><?php echo $verify['START_TIME']; ?></td>
                           <td><?php echo $verify['SALE_TIME']; ?></td>
                           <td><?php echo $verify['SELLER_ID']; ?></td>                            
                           <td class="text text-center"><?php echo $verify['FEEDBACK_SCORE']; ?></td>
                           <td><?php echo $verify['CURRENCY_ID']; ?></td>
                        </tr>
                <?php endforeach;?>        
                   </tbody> 
                  </table>          

              <!-- <input type="hidden" name="countRows" id="countRows" verify="<?php //echo $i; ?>"> -->
              <!-- <div class="col-sm-1">
                                    <div class="form-group">
                                      <button class="btn btn-success saveWebhookData">Recognize All</button> 
                                    </div>
                                  </div> -->                    
            </div><!-- /.col -->
                     
          </div>
        </div>

    </div><!--  col-sm-12 -->
    </div><!--  row -->
 
	</section>
	<!-- </form> -->
</div>  <!-- Content Header (Page header) -->

<!-- ==============================
= FOR SHOWING ONLY PREVIOUS DATA
=================================== --> 
<?php $this->load->view('template/footer');?>
 <script type="text/javascript">
   $(document).ready(function(){

       
    /*=====  End of server side script for datatable  ======*/
    
    $('#recognizeData').DataTable({
      "oLanguage": {
      "sInfo": "Total Records: _TOTAL_"
    },
    "iDisplayLength": 50,
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      //"order": [[ 8, "desc" ]],
      // "order": [[ 16, "ASC" ]],
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
    });
     
   });
function toggleRecord(source) {
    checkboxes = document.getElementsByName('select_recognize[]');
    for(var i=0, n=checkboxes.length;i<n;i++) {
      checkboxes[i].checked = source.checked;
    }
  }
 </script>
