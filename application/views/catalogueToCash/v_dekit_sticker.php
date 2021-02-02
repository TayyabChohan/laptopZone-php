<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Print Sticker
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Print Sticker</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
        
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">


        <div class="box">      

        <div class="box-body form-scroll">  
        <h4 class="box-title">Master Barcode</h4>    
        <div class="col-md-12">
             <div class="tab-content">
           

               <table class="table table-bordered table-striped " >
                    <thead>
                    <tr>
                        
                        <th>BARCODE</th>
                        <th>ITEM DESC</th>
                        <th>MPN</th>
                        <th>UPC</th>
                        <th>CONDITON</th>
                        <th>COST PRICE</th>
                        <th>AVAILABLE QTY</th>
                        <th>RECEIVED ON</th>
                       
                        
                        
                      
                        <!-- <th>List Price</th>  -->
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    foreach ($data['master_barcode'] as $row):?>
                    <tr>
                    <td><?php echo $row['BARCODE_NO'];?></td>
                    <td><?php echo $row['ITEM_MT_DESC'];?></td>
                    <td><?php echo $row['ITEM_MT_MFG_PART_NO'];?></td>
                    <td><?php echo $row['ITEM_MT_UPC'];?></td>
                    <td><?php echo $row['CONDITIONS_SEG5'];?></td>
                    <td><?php echo $row['PO_DETAIL_RETIAL_PRICE'];?></td>
                    <td><?php echo $row['AVAILABLE_QTY'];?></td>
                    <td><?php echo $row['PURCHASE_DATE'];?></td>
                    
                             


          <?php endforeach; ?>
                    </tr>
                    </tbody>
                </table><br>

              


                     
            </div>



            <!-- /.tab-content -->
       

        </div>
        <div class = col-sm-12>
        <div>
          <a href="<?php echo base_url(); ?>single_entry/c_single_entry/dekit_print_all/" title="Print All"  class= "pull-right btn btn-success btn-sm" target="_blank">Print All</a>
        </div>
          
        </div>
        <!-- /.col --> 


            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          



        <div class="box">      
        <div class="box-body form-scroll">      
        <div class="col-md-12">
             <div class="tab-content">
           




               <table id="dekit_prints" class="table table-bordered table-striped " >
                    <thead>
                    <tr>
                        <th>ACTION</th>
                        <th style="width: 120px;">BARCODE</th>
                        <!-- <th>BARCODE</th> -->
                        <th style="width: 170px;">TITLE</th>
                        <th>MPN</th>
                        <th>CONDITION</th>
                        <th>QTY</th>
                       <th>MANUFACTURE</th>
                        <!-- <th>HOLD QTY</th> -->
                        
                        
                      
                        <!-- <th>List Price</th>  -->
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    foreach ($data['listing_qry'] as $row):?>
                    <tr>
                    <td>
                      <a href="<?php echo base_url(); ?>catalogueToCash/c_dekit_sticker/dekitPrintSingle/<?php echo $row['LAPTOP_ITEM_CODE']; ?>/<?php echo $row['LZ_MANIFEST_ID']; ?>/<?php echo $row['BARCODE_NO'] ?>" title="Print Sticker" class="btn btn-primary btn-sm" target="_blank">
                        <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                      </a> 
                    </td>
                    <td><?php echo $row['BARCODE_NO'];?></td>
                    <td><?php echo $row['ITEM_DESC'];?></td>
                    <td><?php echo $row['MFG_PART_NO'];?></td>
                    <td><?php echo $row['ITEM_CONDITION'];?></td>
                    <td><?php echo '1';?></td>
                    <td><?php echo $row['ITEM_MT_MANUFACTURE'];?></td>

                    
          <?php endforeach; ?>
                    </tr>
                    </tbody>
                </table><br>

              


                     
            </div>



            <!-- /.tab-content -->
       

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
    <!-- /.content -->
  </div>    
<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>
 <script>


  $('#dekit_prints').DataTable({
      "oLanguage": {
      "sInfo": "Total Records: _TOTAL_"
    },
    "iDisplayLength": 50,
      "paging": true,
      "lengthChange": true,
      "searching": true,
      //"ordering": true,
      // "order": [[ 16, "ASC" ]],
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
  });



// $('#CatToCash_listedItems').DataTable({
//     "oLanguage": {
//     "sInfo": "Total Records: _TOTAL_"
//   },
//   "iDisplayLength": 50,
//     "paging": true,
//     "lengthChange": true,
//     "searching": true,
//     "ordering": true,
//      // "order": [[ 14, "DESC" ]],
//     "info": true,
//     "autoWidth": true,
//     "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
//   });







 </script>
