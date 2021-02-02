<?php $this->load->view('template/header');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Paid &amp; Shipped
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Paid &amp; Shipped</li>
      </ol>
    </section>
   
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Search by Date</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <!-- <form action=""> -->
            <div class="col-sm-2">
              <label>Search Filter:</label>
            </div>
            <form action="<?php echo base_url(); ?>shiped/paid_shiped/paid_search" method="post">
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
            <div class="col-sm-4">
              <?php $paid_btn_radio = $this->session->userdata('paid');
                if($paid_btn_radio == 2){
                  echo "<input type='radio' name='paid' value='2' checked>&nbsp;Dfwonline&nbsp;
                    <input type='radio' name='paid' value='1'>&nbsp;Techbargain&nbsp;
                    <input type='radio' name='paid' value='Both'>&nbsp;Both";
                    $this->session->unset_userdata('paid');
                }elseif($paid_btn_radio == 1){
                  echo "<input type='radio' name='paid' value='2' >&nbsp;Dfwonline&nbsp;
                    <input type='radio' name='paid' value='1' checked>&nbsp;Techbargain&nbsp;
                    <input type='radio' name='paid' value='Both' >&nbsp;Both";
                    $this->session->unset_userdata('paid');

                }elseif($paid_btn_radio == 'Both'){
                  echo "<input type='radio' name='paid' value='2' >&nbsp;Dfwonline&nbsp;
                    <input type='radio' name='paid' value='1'>&nbsp;Techbargain&nbsp;
                    <input type='radio' name='paid' value='Both' checked>&nbsp;Both";
                    $this->session->unset_userdata('paid');

                }else{
                  echo "<input type='radio' name='paid' value='2' >&nbsp;Dfwonline&nbsp;
                    <input type='radio' name='paid' value='1'>&nbsp;Techbargain&nbsp;
                    <input type='radio' name='paid' value='Both' checked>&nbsp;Both";
                }?>
             
            </div>
            <div class="col-sm-2">
              <input class="btn btn-primary" title="Search Paid & Shipped Details" type="submit" name="Submit" value="Search">
            </div>
             </form>
            </div>
          </div>        

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Paid &amp; Shipped</h3>
              <?php 
              $login_id = $this->session->userdata('user_id');  
              if($login_id == 2 || $login_id == 17):?>
              <br><br>              
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Total Ebay Fee</th>
                    <th>Total PayPal Fee</th>
                    <th>Total Shipping Charges</th>
                    <th>Total Sale Amount</th>
                  </tr>  
                </thead>
                <tbody>
                <tr>
                                
                <?php 
                foreach ($sum_total_ebay as $t):?>
                <td> 
                <?php 
                   $total_ebay_fee = $t['TOTAL'];
                  echo '$ '.number_format((float)@$total_ebay_fee,2,'.',',');
                   
                ?> 
              </td>
              <td>
                <?php 
                
                   $total_paypal_fee = $t['PAYPAL_FEE']; 
                    echo '$ '.number_format((float)@$total_paypal_fee,2,'.',',');
                  
                ?> 
              </td>

              <td>
                
                <?php 
                
                   $total_shipping = $t['TOTAL_SHIPPING_FEE']; 
                    echo '$ '.number_format((float)@$total_shipping,2,'.',',');
                  
                ?> 
              </td>
              <td> 
                <?php 
                
                   $total_sale = $t['TOTAL_SALE_PRICE']; 
                    echo '$ '.number_format((float)@$total_sale,2,'.',',');
                  
                ?> 
              </td>              

              <?php endforeach ?>
              <?php //}
              endif; ?>

              </tr>
              </tbody>
              </table>

            </div>
            <!-- /.box-header -->
            <div class="box-body form-scroll">

             <table id="paidShiped" class="table table-bordered table-striped">
    
                <thead>
                  <tr>
                    <th>Record No#</th>
                    <!-- <th>Photo</th> -->
                    <th>Item Title</th>
                    <th>Ebay Item ID</th>                    
                    <th>Buyer Username / Email</th>
                    <th>Qty</th>
                    <th>Sold For</th>
                    <th>Total</th>
                    <th>Ebay Fee</th>
                    <th>Paypal Fee</th>
                    <th>Date Sold</th>
                    <th>Date Paid</th>
                    <th>Buyer Msg</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
             </table>
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

<?php $this->load->view('template/footer');?>
<script type="text/javascript">
  $(document).ready(function(){
     $("#paidShiped").dataTable().fnDestroy();
     $("#paidShiped").DataTable({
      "oLanguage": {
      "sInfo": "Total Items: _TOTAL_"
    },
      //"aaSorting": [[11,'desc'],[10,'desc']],
      //"order": [[ 10, "desc" ]],
      "fixedHeader": true,
      "paging": true,
      "iDisplayLength": 25,
      "aLengthMenu": [[25, 50, 100, 200], [25, 50, 100, 200]],
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      //"autoWidth": true,
      "dom":'<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
        "bProcessing": true,
        "bRetrieve":true,
        "bDestroy":true,
        "bServerSide": true,
        "bAutoWidth": true,
        "ajax":{
        url :"<?php echo base_url().'shiped/paid_shiped/loadPaidShipped' ?>", 
        // json datasource
        type: "post" , // method by default get
        dataType: 'json',
        //data: {},
        },
        "columnDefs":[{
            "target":[0],
            "orderable":false
          }
        ]      
    });
     //////////////////////////////////
     //                              //
     //////////////////////////////////
     $(document).on('click', '');
  });
  
</script>