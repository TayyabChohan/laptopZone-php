<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        To-List Views
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">To-List View</li>
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
              <h3 class="box-title">Search Item</h3>
            </div>
            <div class="box-body">
              <form action="<?php echo base_url(); ?>tolist/c_tolist/search_record" method="post" accept-charset="utf-8">
                <div class="col-sm-4">
                  <div class="form-group">
              <?php $search_record = $this->session->userdata('search_record');
                if($search_record == "Manifest"){
                  echo "<input type='radio' name='search_record' value='Manifest' checked>&nbsp;Manifest Records&nbsp;&nbsp;
                      <input type='radio' name='search_record' value='Single_Entry'>&nbsp;Single Entry&nbsp;&nbsp;
                      <input type='radio' name='search_record' value='All'>&nbsp;All&nbsp;";
                    $this->session->unset_userdata('search_record');
                }elseif($search_record == "Single_Entry"){
                  echo "<input type='radio' name='search_record' value='Manifest'>&nbsp;Manifest Records&nbsp;&nbsp;
                      <input type='radio' name='search_record' value='Single_Entry' checked>&nbsp;Single Entry&nbsp;&nbsp;
                      <input type='radio' name='search_record' value='All'>&nbsp;All&nbsp;";
                    $this->session->unset_userdata('search_record');

                }elseif($search_record == 'All'){
                  echo "<input type='radio' name='search_record' value='Manifest'>&nbsp;Manifest Records&nbsp;&nbsp;
                      <input type='radio' name='search_record' value='Single_Entry'>&nbsp;Single Entry&nbsp;&nbsp;
                      <input type='radio' name='search_record' value='All' checked>&nbsp;All&nbsp;";
                    $this->session->unset_userdata('search_record');

                }else{
                  echo "<input type='radio' name='search_record' value='Manifest'>&nbsp;Manifest Records&nbsp;&nbsp;
                      <input type='radio' name='search_record' value='Single_Entry'>&nbsp;Single Entry&nbsp;&nbsp;
                      <input type='radio' name='search_record' value='All'>&nbsp;All&nbsp;";
                }?>

                  </div>                                     
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <?php $rslt = $this->session->userdata('date_range'); ?>
                      <input type="text" class="btn btn-default" name="date_range" id="date_range" value="<?php echo $rslt; ?>">

                    </div>
                  </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                     <?php $purchase_no = $this->session->userdata('purchase_no'); ?>
                        <input class="form-control" type="text" name="purchase_no" id="purchase_no" value="<?php if(isset($purchase_no)){echo $purchase_no; $this->session->unset_userdata('purchase_no');}  ?>" placeholder="Purchase Ref No">
                    </div>                                     
                </div> 
                  <div class="col-sm-3">
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" name="Submit" value="Search">
                    </div>
                  </div>                                 
              </form>
            </div>
        </div>  


        <div class="box">    
        <div class="box-body form-scroll">      
          <table style="width: 30%;" class="table table-bordered table-striped ">
            <thead>
              <tr>
                <th>Not Listed Quantity</th>
                <th>Total Amount</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><?php echo  $data['summary_qry'][0]['SUM_QTY'];?></td>
                <td><?php echo '$ '.number_format((float)@$data['summary_qry'][0]['TOTAL_COST'],2,'.',',');
                ?></td>
              </tr>
            </tbody>
          </table>
            <table id="to_listresult" class="table table-bordered table-striped " >
                <thead>
                  <tr>
                      <th>ACTION</th>
                      <th>PICTURE</th>
                      <th>PURCH REF NO</th>
                      <th>TITLE</th>
                      <th>MANUFACTURE</th>
                      <th>MANIFEST QTY</th>
                      <th>COST</th>
                      <th>LINE TOTAL</th>                           
                      <th>CONDITION</th>
                      <th>UPC</th>
                      <th>MPN</th>
                      <th>SKU</th>
                      <th>PURCHASE DATE</th>
                      <th>DAYS ON SHELF</th>
                      <th>BARCODE</th>
                  </tr>
                </thead>
                <tbody>           
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
<script>
 var dataTable = '';
 $(document).ready(function(){
 if(dataTable != ''){
        dataTable = dataTable.destroy();
       }
       var search_val = $("input[name='search_record']:checked").val();
       var date_range = $("#date_range").val();
       var purchase_no = $("#purchase_no").val();
       //console.log(search_val, date_range, purchase_no); return false;
     dataTable = $('#to_listresult').DataTable({
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
        url: '<?php echo base_url();?>tolist/c_tolist/loadtolistresult', 
        type: 'post',
        dataType: 'json',
        data:{ 'search_val':search_val,'date_range':date_range,'purchase_no':purchase_no}
      },
      "columnDefs":[{
          "target":[0],
          "orderable":false
        }]
      });

   });
</script>