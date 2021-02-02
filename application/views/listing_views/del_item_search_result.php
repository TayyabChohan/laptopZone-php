<?php $this->load->view('template/header'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Search Item
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Search Item</li>
      </ol>
    </section>
       
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Search Item</h3>
            </div>
            <!-- /.box-header -->

              <div class="box-body">
                  <form action="<?php echo base_url(); ?>listing/listing_search" method="post" accept-charset="utf-8">
                      <div class="col-sm-8">
                          <!-- <h4><strong>Search Item</strong></h4> -->
                          <div class="form-group">
                              <input class="form-control" type="text" name="search" value="" placeholder="Search Item">
                          </div>                                     
                      </div>
                      <div class="col-sm-4">
                          <div class="form-group">
                              <input type="submit" class="btn btn-primary" name="Submit" value="Search">
                          </div>
                      </div>                                 
                  </form>

              </div>
              <div class="alert alert-danger">
                <strong>Item!</strong> has been deleted from the system.
              </div>
          </div>


                    <div class="box">    
                    <div class="box-body form-scroll">

                        <table id="DelItemSearchResult" class="table table-bordered table-striped " >
                            <thead>
                              <tr>
                                <th>BARCODE</th>
                                <th>TITLE</th>
                                <th>CONDITION</th>
                                <th>REMARKS</th>
                                <th>DATED</th>
                                <th>DELETED BY</th>
                              </tr>
                            </thead>
                            <tbody>

                        <?php foreach ($data['query'] as $row): ?>
                              <tr > 

                              <td><?php echo @$row['BARCODE'];?></td>
                              <td>
                              <div style="width:200px;">
                              <?php echo @$row['ITEM_MT_DESC'];?>
                              </div></td>
                                              
                              <td>
                              <?php 
                                if(@$row['ITEM_CONDITION'] == 3000 ){echo "USED";}
                                elseif(@$row['ITEM_CONDITION'] == 1000 ){echo "NEW";}
                                elseif(@$row['ITEM_CONDITION'] == 1500 ){echo "NEW OTHER";}
                                elseif(@$row['ITEM_CONDITION'] == 2000 ){echo "MANUFACTURER REFURBISHED";}
                                elseif(@$row['ITEM_CONDITION'] == 2500 ){echo "SELLER REFURBISHED";}
                                elseif(@$row['ITEM_CONDITION'] == 7000 ){echo "FOR PARTS OR NOT WORKING";}
                                elseif(@$row['ITEM_CONDITION'] == 4000 ){echo "VERY GOOD";}
                                elseif(@$row['ITEM_CONDITION'] == 5000 ){echo "GOOD";}
                                elseif(@$row['ITEM_CONDITION'] == 6000 ){echo "ACCEPTABLE";}
                                else{echo @$row['ITEM_CONDITION'];}
                              ?>
                                
                              </td>
                              <td><?php echo @$row['REMARKS']; ?></td>
                              <td><?php echo @$row['DEL_DATE'];?></td>
                              <td><?php echo @$row['USER_NAME'];?></td>
                                 
                            </tr>
                    <?php endforeach; ?>
                                     
                            </tbody>
                        </table><br>

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