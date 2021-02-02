<?php $this->load->view('template/header'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Customer Profile
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Customer Profile</li>
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
            <div class="box-header with-border">
              <h3 class="box-title">Search Customer Profile</h3>
            </div>
            <?php $ser  =$this->uri->segment(4);
            $ser  =trim(str_replace("%20",' ', $ser));
             //var_dump($ser);?>
            <!-- /.box-header -->

                        <div class="box-body">

                            <form action="<?php echo base_url(); ?>CustomerProfile/c_CustomerProfile/CustomerProfile" method="post" accept-charset="utf-8">
                                <div class="col-sm-8">
                                    <!-- <h4><strong>Search Item</strong></h4> -->
                                    <div class="form-group">
                                       <?php $rslt = $this->session->userdata('search'); ?>
                                        <input class="form-control" type="text" name="search" id="cust" value="<?php if(isset($rslt)){echo $rslt; $this->session->unset_userdata('search');}else{echo $ser;}  ?>" placeholder="Search Customer Profile">
                                    </div>                                     
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <input type="submit" id="submit" class="btn btn-primary" name="submit" value="Search">
                                        <a style="margin-left:8px;"class="btn btn-success" href="<?php echo base_url();?>CustomerProfile/c_CustomerProfile">Back</a>
                                    </div>
                                </div>                                  
                            </form>
                        </div>
                        </div>  
                    <?php 
                      //var_dump($data);exit;
                    if(!empty($data)): ?>
                        <!-- <table id="searchResults" class="table table-bordered table-striped"> -->
                    <div class="box">    
                    <div class="box-body form-scroll">
       
                      <table id="to_customerresult" class="table table-bordered table-striped " >
                        <thead>
                          <tr>
                            <th>ORDER ID</th>
                            <th>EBAY ID</th>                          
                            <th>USER ID</th>
                            <th>FULL NAME</th>
                            <th>PHONE NO</th>
                            <th>EMAIL</th>
                            <th>ADDRESS1</th>
                            <th>ADDRESS2</th>
                            <th>CITY</th>
                            <th>BUYER ZIP</th>
                            <th>STATE</th>
                            <th>SHIPPING FEE</th>
                            <th>TRACKING NO</th>
    

                          </tr>
                        </thead>

                             <tbody>         
                            </tbody>
                        </table><br>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        <?php endif; ?>
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
 //var dataTable = '';
 $(document).ready(function(){
 // if(dataTable != ''){
 //        dataTable = dataTable.destroy();
 //       }
  var getsearch = $("#cust").val();
  //console.log(search);
     dataTable = $('#to_customerresult').DataTable({
      "oLanguage": {
        "sInfo": "Total Records: _TOTAL_", 
      },
      "aLengthMenu": [25, 50, 100, 200],
      "paging": true,
      // "lengthChange": true,
      "searching": true,
      // "ordering": true,
      "Filter":true,
      "info": true,
      // "autoWidth": true,
      "fixedHeader": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
      "bProcessing": true,
      "bRetrieve":true,
      "bDestroy":true,
      "bServerSide": true,
      "bAutoWidth": false,
      "ajax":{
        url: '<?php echo base_url();?>CustomerProfile/c_CustomerProfile/to_customerresult', 
        type: 'post',
        dataType: 'json',
        data:{ 'getsearch':getsearch}
      },
      "columnDefs":[{
          "target":[0],
          "orderable":false
        }]

      });
   });
</script> 