<?php $this->load->view("template/header.php"); ?>
  
     <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Service Receipt View
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Service Receipt View</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-sm-12">
          
          <!-- Deletion Message start-->
          <?php if($this->session->flashdata('deleted')){ ?>
            <div id="delSuccess" class="alert alert-success alert-dismissable">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Success!</strong> <?php echo $this->session->flashdata('deleted'); ?>
            </div>
          <?php }elseif($this->session->flashdata('del_error')){  ?>

          <div id="delError" class="alert alert-danger alert-dismissable">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Error!</strong> <?php echo $this->session->flashdata('del_error'); ?>
          </div>

          <?php } ?>
          <!-- Deletion Message end-->

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Search By</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div> 
            </div>
            <!-- box header-->
            <div class="box-body">
                <div class="row">
                  <div class="col-sm-12">
                    <form action="<?php echo base_url(); ?>service/c_serviceReceipt/receiptSearch" method="post" accept-charset="utf-8">

                      <div class="col-sm-8">
                          <div class="form-group">
                           
                              <input class="form-control" type="text" name="receipt_search" id="receipt_search" value="<?php echo @$perameter;  ?>" placeholder="Search">
                          </div>                                     
                      </div> 
                        <div class="col-sm-3">
                          <div class="form-group">
                              <input type="submit" class="btn btn-primary" name="search_btn" value="Search">
                              <input type="hidden" name="check" id="check" value>
                          </div>
                        </div>                                 
                    </form>                   
                       
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
              <h3 class="box-title">ServiceReceipt View</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div> 
            </div>
            <div class="box-body form-scroll">
            <?php $i=1;?>
               <table id="serviceReceiptView" class="table table-bordered table-striped">
                <thead>
                  <th>ACTION</th>
                  <th>RECEIPT NO</th>
                  <th>RECEIPT DATE</th>
                  <th>PHONE</th>
                  <th>EMAIL</th>
                  <th>ADDRESS</th>
                  <th>PRICE</th>
                  <!-- <th>DISC PERC %</th> -->
                  <th>DISC AMOUNT</th>
                  <th>SALES TAX</th>
                  <th>SERVICE CHARGES</th>
                  <th>GRAND TOTAL</th>
                  <th>ENTERED BY</th>
                  <th>Expected Date</th>
                  <th>Status</th>
                  

                </thead>
                <tbody>
                
                  
                </tbody>
               </table><br />

            </div>
        </div>
      </div>  

    </section>

  </div>

<?php $this->load->view("template/footer.php"); ?>