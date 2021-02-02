<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Feasibility Index
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Feasibility Index</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content"> 
      <div class="row">
        <div class="box"><br>  
               
          <div class="box-body form-scroll">  
            <?php if($this->session->flashdata('success')){ ?>
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php }else if($this->session->flashdata('error')){  ?>
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php }else if($this->session->flashdata('warning')){  ?>
                <div class="alert alert-warning">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>Error!</strong> <?php echo $this->session->flashdata('warning'); ?>
                </div>
            <?php }else if($this->session->flashdata('compo')){  ?>
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>Error!</strong> <?php echo $this->session->flashdata('compo'); ?>
                </div>
            <?php } ?>   
            <div class="col-md-12">
              <!-- Custom Tabs -->
              
                    <table class="table table-responsive  table-bordered table-hover">
                      <thead >
                         
                          <!-- <th style =" text-align:center; ">EBAY ID</th> -->
                          <th class="danger" style =" text-align:center; ">MPN</th>
                          <th class="danger" style =" text-align:center; ">CONDITION NAME</th>
                          <th class="danger" style =" text-align:center; ">SALE PRICE</th>
                          <th class="danger" style =" text-align:center; ">AVERAGE PRICE</th>
                          <th class="danger" style =" text-align:center; ">SOLD QTY PER_DAY</th>
                          <th class="danger" style =" text-align:center; ">ACTIVE QTY PER_DAY</th>
                          <th class="danger" style =" text-align:center; ">GOOD AVG SALE QTY</th>
                          <th class="danger" style =" text-align:center; ">GOOD AVG SALE VALUE</th>
                         
                      </thead>
                      <tbody>
                      <tr class="danger">
                        <?php foreach($data['fesi_sumary'] as $row) :?>
                     <!--  <td style = " font-size:17px; font-weight:500;"><?php //echo $row['EBAY_ID'];?></td> -->
                      <td style = " font-size:17px; font-weight:500;"><?php echo @$row['MPN'];?></td>
                      <td style = " font-size:17px; font-weight:500;"><?php echo @$row['CONDITION_NAME'];?></td>
                      <td style = " font-size:17px; font-weight:500;"><div class="pull-right" >$ <?php echo number_format((float)@$row['SALE_PRICE'],2,'.',',');?></div></td>
                      <td style = " font-size:17px; font-weight:500;"><div class="pull-right" >$ <?php echo number_format((float)@$row['AVERAGE_PRICE'],2,'.',',');?></div></td>
                      <td style = " font-size:17px; font-weight:500;"><div class="pull-right" ><?php echo number_format((float)@$row['PER_DAY_SOLD_QTY'],2,'.',',');?></div></td>
                      <td style = " font-size:17px; font-weight:500;"><div class="pull-right" ><?php echo number_format((float)@$row['PER_DAY_ACTIV_QTY'],2,'.',',');?></div></td>
                      <td style = " font-size:17px; font-weight:500;"><div class="pull-right" ><?php echo number_format((float)@$row['GOOD_AVG_SALE_QTY'],2,'.',',');?></div></td>
                      <td style = " font-size:17px; font-weight:500;"><div class="pull-right" ><?php echo number_format((float)@$row['GOOD_AVG_SALE_VAL'],2,'.',',');?></div></td>
                     
                      </tr>
                        <?php endforeach; ?>
                       
                        
                        
                      </tbody> 
                     
                    </table>
                    <!-- nav-tabs-custom -->
                  </div>




            <div class="col-md-12">
              <!-- Custom Tabs -->
              
                    <table id="purchasing-table" class="table table-responsive table-striped table-bordered table-hover">
                      <thead>
                         
                          <th style =" text-align:center; ">FACTOR NAME</th>
                          <th style =" text-align:center; ">VALUE</th>
                          <th style =" text-align:center; ">FACTOR %</th>
                          <th style =" text-align:center; ">RANK WEIGHTAGE</th>
                          <th style =" text-align:center; ">RANK %</th>
                         
                      </thead>
                      <tbody>
                      <tr>
                        <?php foreach($data['query'] as $row) :?>
                      <td style = " font-size:17px; font-weight:500;"><?php echo $row['FACTOR_NAME'];?></td>
                      <td style = " font-size:17px; font-weight:500;"><div class="pull-right" ><?php echo number_format((float)@$row['VALUE'],2,'.',',');?></div></td>
                      <td style = " font-size:17px; font-weight:500;"><div class="pull-right" ><?php echo number_format((float)@$row['FACTOR_PERCENT'],2,'.',',').' %';?></div></td>
                      <td style = " font-size:17px; font-weight:500;"><div class="pull-right" ><?php echo number_format((float)@$row['RANK_WEIGHTAGE'],2,'.',',').' %';?></div></td>
                      <td style = " font-size:17px; font-weight:500;"><div class="pull-right" ><?php echo number_format((float)@$row['RANK_PERCENTAGE'],2,'.',',').' %';?></div></td>
                     
                      </tr>
                        <?php endforeach; ?>
                         <thead>
                          <th></th>
                          <th></th>
                          <th ></th>
                          <th ></th>
                          <th ></th>
                          
                        </thead>
                        <tr class="info">
                          <td></td>
                          <td></td>
                          <td></td>
                         
                          <td  style = " font-size:17px; color : red; font-weight:700;"><div class="pull-right" >Feasibility Index %</div></td>
                       
                       <?php 
                       $sum = 0;
                       foreach($data['query'] as $row) :
                     
                      $sum = $sum + $row['RANK_PERCENTAGE']; 
                       endforeach; ?>

                          <td style = " font-size:17px; color : red; font-weight:700;"> <div class="pull-right" ><?php echo number_format((float)@($sum),2,'.',',').' %';?></div></td>
                        </tr>
                        
                      </tbody> 
                     
                    </table>
                    <!-- nav-tabs-custom -->
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
$(document).ready(function()
  {
     $('#purchasing-table').DataTable({
    "oLanguage": {
    "sInfo": "Total Records: _TOTAL_"
  },
  "iDisplayLength": 50,
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    // "order": [[ 16, "ASC" ]],
    "info": true,
    "autoWidth": true,
    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
  });
          
});
</script>