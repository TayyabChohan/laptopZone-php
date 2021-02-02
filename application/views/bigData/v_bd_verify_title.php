<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo (isset($pageTitle)) ? $pageTitle : 'Dashboard'; ?> 
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo (isset($pageTitle)) ? $pageTitle : 'Dashboard'; ?> </li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
         

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
            <!-- </div> --> 

          <?php echo form_open('bigData/c_bd_recognize_data/verifyDataConfirm', 'id = "myform"'); ?>
          <?php if(!empty(@$getSpecifics)):?> 

        
    
        <div class="row">
          <div class="col-sm-12">
            <div class="box">
              <div class="box-header with-border">
                <div class="col-sm-8">
                  <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlentities($varifiedData['mpn_qry'][0]['TITLE']); ?>">
                  </div>
                </div>
              </div>
            </div>
          <div class="box">
              <div class="box-header with-border">
               <h3 class="box-title">Add Item Specifics</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                </div> 
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div class="col-sm-12">
                  <input type="hidden" class="form-control" id="array_count" name="array_count" value="<?php echo count(@$getSpecifics['spec_name']);  ?>">
                  <input type="hidden" name="bd_search" id="bd_search" class="form-control" value="<?php echo $this->session->userdata('search_key'); ?>">
                  <input type="hidden" class="form-control" id="cat_id" name="cat_id" value="<?php echo $this->uri->segment(5);  ?>">
                  <input type="hidden" class="form-control" id="title_id" name="title_id" value="<?php echo $varifiedData['mpn_qry'][0]['LZ_BD_CATA_ID']; ?>">
                  <input type="hidden" class="form-control" id="mpn_mt_id" name="mpn_mt_id" value="<?php echo $varifiedData['mpn_qry'][0]['MPN_MT_ID']; ?>">
                  <input type="hidden" class="form-control" id="object_id" name="object_id" value="<?php echo $varifiedData['mpn_qry'][0]['OBJECT_ID']; ?>">
                  
                  
                    <?php
                      //$array_count = count(@$data['mt_id']);

                      //var_dump($varifiedData[$i-1]['SPEC_DET_ID']);
                    //exit;
                      $i=1;
                      //var_dump($varifiedData['spec_qry']);
                      foreach(@$getSpecifics['spec_name'] as $name):
                    ?>
                      <div class="col-sm-3">
                        <div class="form-group">

                          <label for="" value="<?php echo @$name['SPECIFIC_NAME']; ?>" id="<?php echo 'specific_name_'.@$i;?>"><?php echo @$name['SPECIFIC_NAME']; ?></label>
                          <input type="hidden" name="<?php echo 'specific_name_'.@$i;?>" class="<?php echo 'specific_name_'.@$i;?>" id="<?php echo @$name['MT_ID']; ?>" value="<?php echo @$name['MT_ID'].'_'.@$name['SPECIFIC_NAME']; ?>">
                          
                         <?php if(@$name['MAX_VALUE'] > 1){ 
                          // echo '<br><select name="specific_'.@$i.'" id="specific_'.@$i.'" class="selectpicker" multiple><option value="select_select">------------Select------------</option>';

                          echo '<select class="form-control" name="specific_'.@$i.'" id="specific_'.@$i.'" ><option value="select_select">------------Select------------</option>';
                        }else{
                           echo '<select class="form-control" name="specific_'.@$i.'" id="specific_'.@$i.'" ><option value="select_select">------------Select------------</option>';
                        }
                          ?>
                          <?php foreach(@$getSpecifics['spec_value'] as $specifics): ?>
                                                     
                            <?php
                              if($specifics['MT_ID'] == @$name['MT_ID']): 
                                foreach ($varifiedData['spec_qry'] as $spec) {
                                  if($spec['SPEC_DET_ID'] == @$specifics['DET_ID']){
                                    $selected = 'selected';
                                    break;
                                   }else{
                                    $selected = '';
                                   }
                                }
                                   
                                    echo '<option value="'.htmlentities(@$specifics['DET_ID'].'_'.@$specifics['SPECIFIC_VALUE']).'" '.$selected.'>'.@$specifics['SPECIFIC_VALUE'].'</option>';
                      
                                  //}
                                 endif;
                              ?>
                              <?php
                              endforeach;
                            ?>
                           </select>
                          
                          </div>                                     
                        </div>
                        

                      <?php $i++; endforeach; ?>
                  </div>
                </div><!-- /.boxbody -->
            </div><!-- /.box -->
            <div class="box">
              <div class="box-header with-border">
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="object_bd" class="control-label">Object</label>
                    <input type="text" name="object_bd" id="object_bd" class="form-control" value="<?php echo $varifiedData['mpn_qry'][0]['OBJECT_NAME']; ?>">

                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="mpn_bd" class="control-label">MPN</label>
                    <input type="text" name="mpn_bd" id="mpn_bd" class="form-control" value="<?php echo $varifiedData['mpn_qry'][0]['MPN']; ?>">
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="model_bd" class="control-label">Model</label>
                    <input type="text" name="model_bd" id="model_bd" class="form-control" value="<?php echo $varifiedData['mpn_qry'][0]['MODEL']; ?>">
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="model_bd" class="control-label">Manufacturer</label>
                    <input type="text" name="manufacturer_bd" id="manufacturer_bd" class="form-control" value="<?php echo $varifiedData['mpn_qry'][0]['MANUFACTURER']; ?>">
                  </div>
                </div>
                <div class="col-sm-1 p-t-24">
                  <div class="form-group">
                    <input type="submit" class="btn btn-primary" name="verify" value="Verify"> 
                  </div>
                </div>

                <div class="col-sm-1 p-t-24">
                  <div class="form-group">
                    <input type="button" class="btn btn-success" name="verify_all"  id="verify_all" value="Verify All"> 
                  </div>
                </div>
              </div>
            </div>
            

          
      </div><!-- /.col-sm-12 -->
    </div><!-- /.row -->    

        <?php endif;
echo form_close();
         ?> 

      </div>
        <!-- /.col -->
    </div>
      <!-- /.row -->
  </section>

  <?php 
      $this->session->unset_userdata('search_key');
      $this->session->unset_userdata('category_id');
   ?>
    <!-- /.content -->
</div>

<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>
<script type="text/javascript">
   $(document).ready(function(){
  //   var lz_bd_cata_id = $('#title_id').val();
  //   $.ajax({
  //     dataType: 'json',
  //     type: 'POST',
  //     url:'<?php //echo base_url(); ?>bigData/c_bd_recognize_data/autoFill',
  //     data: {
  //             'lz_bd_cata_id' : lz_bd_cata_id
  //           },
  //    success: function (response) {
  //     $("#myform")[0].reset();
      
  //     //$('select option:selected').removeAttr('selected');
  //     for(var i = 0; i<response.spec_qry.length; i++){
  //       var t = response.spec_qry[i].MT_ID;
  //       var label_name = $('#'+t).attr("name");
  //       var dropdown_id = label_name.replace("_name", "");
  //       $('#'+dropdown_id).val(response.spec_qry[i].SPECIFIC_VALUE);
  //     }

  //     for(var i = 0; i<response.mpn_qry.length; i++){
  //       if(response.mpn_qry[i].DATA_TYPE == 'MPN'){
  //         $('#mpn_bd').val(response.mpn_qry[i].DATA_DESC);
  //       }
  //     }

      
  //    }
  // });
});
 </script>
 