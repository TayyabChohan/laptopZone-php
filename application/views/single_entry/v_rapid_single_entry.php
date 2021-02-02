<?php $this->load->view("template/header.php"); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Short Single Entry
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Short Single Entry</li>
      </ol>
    </section> 
    
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Short Single Entry</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <div class="col-sm-10">
              
            </div>
           <!--  <div class="col-sm-2">
              <div class="form-group pull-right">
                <a style="text-decoration: underline;" href="<?php //echo base_url('tolist/c_tolist/lister_view'); ?>" title="Go to Item Listing" target="_blank">Item Listing</a>
              </div>
            </div> -->

          <?php echo form_open('single_entry/c_single_entry/add_two', 'role="form"'); ?>

          <div class="row">
          
               <div class="col-sm-12">
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="Job No" class="control-label">Upc:</label>
                      <input type="number" placeholder = "Scan Upc" class="form-control" id="ent_upc" name="ent_upc" >
                  </div>
                </div>
                
                 <div class="col-sm-3">
                  <div class="form-group">
                    <label for="MPN" class="control-label">MPN:</label>
                    
                      <input type="text"  placeholder = "Enter Mpn" class="form-control" id="ent_mpn" name="ent_mpn" >
                  </div>
                </div>

                <div class="col-sm-1">
                  <div class="form-group">
                  <label for="Lot Ref" class="control-label">Qty:</label>
                  
                    <input type="number" class="form-control" placeholder ="Enter Qty" id="ent_qty" value ="1" name="ent_qty" required>
                  </div>
                </div>
                <div class="col-sm-2">
                <div class="form-group">
                  <label for="Cost Price" class="control-label">Cost $:</label>         
                    <input type="number" step="0.01" min="0" placeholder = "Enter Cost" class="form-control" id="ent_cost" name="ent_cost" required>
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">      
                    <label for="Conditions" class="control-label">Conditions:</label>
                    <select class="form-control selectpicker" id="ent_con" name="ent_con" value="<?php echo @$row['CONDITIONS_SEG5']; ?>" required>
                    <option value="">---Select Condition---</option>

                    <?php
                    foreach ($cond as $val) { ?>
                    <?php if($val['ID'] == 1000){
                    	$selc = 'selected';
                    }else{
                    	$selc = '';
                    } ?>
                      <option value="<?php echo $val['ID']; ?>"<?php echo $selc;?>><?php echo $val['COND_NAME']; ?></option>
                    <?php } ?>

                  </select>
                </div>
              </div>
              
                
              </div>            

                      
               
                <div class="col-sm-12 buttn_submit">
                  <div class="form-group">
                    <input type="submit" title="Save and Post Record" name="save" id="save" class="btn btn-success" value="Save">
                    <!-- <button type="button" title="Back" onclick="location.href='<?php //echo base_url('single_entry/c_single_entry/filter_data') ?>'" class="btn btn-primary">Back</button> -->
                </div>
              </div>
          
          <?php echo form_close(); ?>

            <!-- /.box-body -->
          </div>

        
          <!-- /.box -->
        </div>

        <!-- /.col -->
      </div>
          <div class ="row">
      <div class ="col-sm-12">
        <div class="box">
          

            <div class="box-body form-scroll">
              <div class="col-sm-12">

                <table id="singl_ent_two" class="table table-responsive table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                          <th>Action</th>
                          <th>Upc</th>
                          <th>Mpn</th>
                          <th>Qty</th>
                          <th>Cost</th>
                          <th>Condition</th> 
                      
                    </tr>
                  </thead>
                  <tbody>
                        
                      <tr>
                        <?php foreach($get_data['query'] as $sing_two) :?>

                	<td><div style="float:left;margin-right:8px;">
                      <a href="<?php echo base_url(); ?>single_entry/c_single_entry/sing_entr_copy/<?php echo $sing_two['SINGLE_PK']; ?>" title="edit merchant" class="btn btn-primary btn-sm" target="_blank">
                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                      </a>                              
                    </div> </td>                                           
                      <td><?php echo $sing_two['UPC']?></td>                                           
                      <td><?php echo $sing_two['MPN']?></td>                                           
                      <td><?php echo $sing_two['QTY']?></td>                                           
                      <td><?php echo $sing_two['COST']?></td>                                           
                      <td><?php echo $sing_two['COND_NAME']?></td>    
                     
                      </tr>
                        <?php endforeach; ?>
                       
                        
                        
                      </tbody>
                </table>              
                            
              </div>
              
            </div>
        </div>
        
      </div>
      
    </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>  


<?php $this->load->view("template/footer.php"); ?>

<script >

	$(document).ready(function()
  {
     $('#singl_ent_two').DataTable({
    "oLanguage": {
    "sInfo": "Total Records: _TOTAL_"
  },
  "iDisplayLength": 50,
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    //"order": [[ 0, "DESC" ]],
    "info": true,
    "autoWidth": true,
    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
  });
          
});


</script>