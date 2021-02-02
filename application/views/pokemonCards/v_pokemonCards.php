<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Pokemon Cards
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Pokemon Cards</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content"> 

      <!-- for box collapsed-box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Pokemon Cards Details</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
            <div class="box-body">

              <div class="col-sm-12">
                <table id="pokemonCards" class="table table-responsive table-striped table-bordered table-hover">
                  <thead>

                    <tr>
                      <th>IMAGEURL</th>
                      <th>CARD_NAME</th>
                      <th>CARD_ID</th>
                      <th>NATIONALPOKEDEXNUMBER</th>
                      <th>CARD_TYPES</th>
                      <th>CARD_SUBTYPE</th>
                      <th>SUPERTYPE</th>
                      <th>HP</th>
                      <th>CARD_NUMBER</th>
                      <th>ARTIST</th>
                      <th>RARITY</th>
                      <th>CARD_SERIES</th>
                      <th>CARD_SET</th>
                      <th>SETCODE</th>
                      <th>RETREATCOST</th>
                      <th>CONVERTEDRETREATCOST</th>
                      <th>CARD_TEXT</th>
                      <th>ATTACKDAMAGE</th>
                      <th>ATTACKCOST</th>
                      <th>ATTACKNAME</th>
                      <th>ATTACKTEXT</th>
                      <th>WEAKNESSES</th>
                      <th>RESISTANCES</th>
                      <th>ANCIENTTRAIT</th>
                      <th>ABILITYNAME</th>
                      <th>ABILITYTEXT</th>
                      <th>ABILITYTYPE</th>
                      <th>CONTAINS</th>
                      
                      <!-- <th>IMAGEURLHIRES</th> -->
                      <th>ABILITY</th>
                      <th>ATTACKS</th>

                    </tr>
                  </thead>

                </table>  
              </div>
            </div>
          </div>   

        <!-- /.col -->
      </section>
      <!-- /.row -->

    <!-- /.content -->
  </div>    

    <!-- /.row -->

<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>
<script>
var dataTable = '';
$(document).ready(function(){
    dataTable = $('#pokemonCards').DataTable( { 
      "oLanguage": {
      "sInfo": "Total Records: _TOTAL_",
      //"sPaginationType": "full_numbers",
      
    },
    // For stop ordering on a specific column
    // "columnDefs": [ { "orderable": false, "targets": [0] }],
    // "pageLength": 5,
     "iDisplayLength": 25,
      "aLengthMenu": [[25, 50, 100, 200,500], [25, 50, 100, 200,500]],
       
       "paging": true,
      "lengthChange": true,
      "searching": true,

      "ordering": true,
      "Filter":true,
      // "iTotalDisplayRecords":10,
      //"order": [[ 8, "desc" ]],
      // "order": [[ 16, "ASC" ]],
      "info": true,
      // "autoWidth": true,
      //"dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
      "bProcessing": true,
      "bRetrieve":true,
      "bDestroy":true,
      "bServerSide": true,
      ///////////////////////////
      "autoWidth": true,
      "sScrollY": "600px",
      "sScrollX": "100%",
      "sScrollXInner": "150%",
      "bScrollCollapse": true,
      "bPaginate": true, 
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
      "fixedHeader": true,
    ///////////////////////////////
      // "bAutoWidth": false,
      "ajax":{
        url :"<?php echo base_url().'pokemonCards/c_pokemonCards/pokemonCardsData' ?>", // json datasource
        type: "post"  // method  , by default get
        // data: {},
        
        },
        "columnDefs":[{
            "target":[0],
            "orderable":false
          }
        ],
        "createdRow": function( row, data, dataIndex){
            // if(data){
            //     $(row).find(".updateEst").closest( "tr" ).addClass('rowBg');
            //     }
              }

      });
   // new $.fn.dataTable.FixedHeader(dataTable);

                          
});


</script>
