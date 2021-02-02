<?php $this->load->view("template/header.php"); ?>
  
     <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Part Issue Detail
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Part Issue Detail</li>
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
              <h3 class="box-title">Parts Issuance Detail View</h3>
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
                  <th>SERVICE RECEIPT BARCODE</th>
                  <th>ISSUANCE NO</th>
                  <th>ISSUANCE DATE</th>
                  <th>ENTERED BY</th>
                  
                  <!-- <th>ENTERED BY</th> -->
                  <!-- <th>DISC PERC %</th> -->
                 
                  

                </thead>
                <tbody>
                  <?php foreach(@$data as $row): ?>
                      <tr>

                        <td>
                              <div style="width:100px;">
                                  <div style="float:left;margin-right:8px;">
                                    
                                    <a title="Edit Record" href="<?php echo base_url(); ?>service/c_partsIssue/editPartsIssue/<?php echo $row['LZ_PART_ISSUE_MT_ID']; ?>" class="btn btn-warning btn-xs" target="_blank"><span class="glyphicon glyphicon-pencil p-b-5" aria-hidden="true"></span>
                                    </a>

                                    <a style="margin-left:4px;" title="Delete Record" href="<?php echo base_url(); ?>service/c_partsIssue/deletePartIssue/<?php echo $row['LZ_PART_ISSUE_MT_ID']; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                    </a>

                                   </div>
                                 

                              </div>
                        </td>
                        <td><?php echo $row['DOC_NO']; ?></td>
                        <td><?php echo $row['ISSUE_NO']; ?></td>
                        <td><?php echo $row['DOC_DATE']; ?></td>
                        <td>
                          <?php 
                            foreach($users as $user){
                              $u_name = ucfirst($user['USER_NAME']);
                              $employee_id = $user['EMPLOYEE_ID']; 
                              if($employee_id ==  $row['ENTERED_BY']){
                                echo $u_name;
                              }
                           
                            } 
                          ?>                        
                        </td>


                      </tr>
                <!-- foreach -->
                
                  <?php endforeach;?>
                  
                </tbody>
               </table><br />

            </div>
        </div>
      </div>  

    </section>

  </div>

<?php $this->load->view("template/footer.php"); ?>
<script>
  
   $('#serviceReceiptView').DataTable({
    "oLanguage": {
    "sInfo": "Total Records: _TOTAL_"
  },
  "iDisplayLength": 50,
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
     "order": [[ 1, "DESC" ]],
    "info": true,
    "autoWidth": true,
    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
  }); 
    /*===== Success message auto hide ====*/
        setTimeout(function() {
          $('#delSuccess').fadeOut('slow');
        }, 3000); // <-- time in milliseconds

        setTimeout(function() {
          $('#delError').fadeOut('slow');
        },3000); // <-- time in milliseconds        

    /*===== Success message auto hide ====*/    
    

</script>