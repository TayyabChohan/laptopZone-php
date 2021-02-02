<?php $this->load->view('template/header');
 ini_set('memory_limit', '-1');
 ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Ledger Report
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Ledger Report</li>
      </ol>
    </section>  
    <section class="content">
      <div class="row">

        <div class="box"><br>   
          <div class="box-body form-scroll">
            <div class="col-sm-12">
            <?php 
                /*echo "<pre>";
                print_r($ledgers['reports']->result_array());
                exit;*/
            $reports=$ledgers['reports']->result_array();?>
            <div class="col-sm-2">
              <b>From Date:</b> <?php echo $ledgers['from']; ?>
            </div>
            <div class="col-sm-2">
              <b>To Date:</b> <?php echo $ledgers['to']; ?>
            </div>
            <div class="col-sm-2">
              <b>Sub Inventory:</b> <?php echo $ledgers['sub_inventory']; ?>
            </div>
            <div class="col-sm-2">
              <b>Locators:</b> <?php echo $ledgers['locator']; ?>
            </div>
            <div class="col-sm-2">
              <b>Item Types:</b> <?php echo $ledgers['item_type']; ?>
            </div>
            <div class="col-sm-3">
              <b>Item Codes:</b> <?php echo $ledgers['item_code_from'].'-'.$ledgers['item_code_to']; ?>
            </div>
            <div class="col-sm-2">
              <b>Item ID:</b> <?php echo $reports[0]['ITEM_ID'];?>
            </div>
             <div class="col-sm-4">
              <b>Item Description:</b> <?php echo $reports[0]['DESCRIPTION']; ?>
            </div>
            <div class="col-sm-2">
              <b>Brand:</b> <?php echo 'Apple';?>
            </div>
            <div class="col-sm-4">
              <b>Category:</b> <?php echo "";?>
            </div>
          </div>   
            <div class="col-md-12">
                   <table id="ledger_table_report" class="table table-responsive table-striped table-bordered table-hover">
                      <thead>
                       <tr>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th colspan="3" class="text text-center" style="background: green; color: white;">IN</th>
                          <th colspan="3" class="text text-center" style="background: red; color: white;">OUT</th>
                          <th colspan="3" class="text text-center" style="background: brown; color: white;">BALANCE</th>
                      </tr>
                       <tr>
                          <th>DATE</th>
                          <th>TYPE</th>
                          <th>DESCRIPTION</th>

                          <th>QTY</th>
                          <th>RATE</th>
                          <th>AMOUNT</th>
                          

                          <th>QTY</th>
                          <th>RATE</th>
                          <th>AMOUNT</th>

                          <th>QTY</th>
                          <th>RATE</th>
                          <th>AMOUNT</th>
                       </tr>   
                      </thead>
                      </table>
                  </div> 
                </div>
            </div>
          </div>
        </div>
    </section>
  </div>
  <?php $this->load->view('template/footer');?> 
  <script type="text/javascript">
   $(document).ready(function(){
    /*/////////////////////////////*/
    var dataTable = $('#ledger_table_report').DataTable( {
      
      "oLanguage": {
      "sInfo": "Total Records: _TOTAL_",
      //"sPaginationType": "full_numbers",
      },
    // For stop ordering on a specific column
    // "columnDefs": [ { "orderable": false, "targets": [0] }],
    // "pageLength": 5,
       "aLengthMenu": [25, 50, 100, 200],
       "paging": true,
      // "lengthChange": true,
      "searching": true,
      // "ordering": true,
      "Filter":true,
      // "iTotalDisplayRecords":10,
      //"order": [[ 8, "desc" ]],
      // "order": [[ 16, "ASC" ]],
      "info": true,
      // "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
      "bProcessing": true,
      "bRetrieve":true,
      "bDestroy":true,
      "bServerSide": true,
      // "bAutoWidth": false,
      "ajax":{
        url :"<?php echo base_url() ?>reports/c_ledgerReport/loadReport", // json datasource
        type: "post"  // method  , by default get
        // data: {},
        },
        "columnDefs":[{
            "target":[0],
            "orderable":false
          }
        ]

      });
    /*/////////////////////////////*/
   });
 </script>   