<?php $this->load->view('template/header');?>

<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>

          <?php 

          $struc_id = $this->uri->segment(4);
          $segm_id = $this->uri->segment(5); 
          $dep_key = $this->uri->segment(6); 
          $qual_id = $this->uri->segment(7);
          $dep_key_id = $this->uri->segment(8);
          $segment_id = $this->uri->segment(9);
          $parent_structuree_id = $this->uri->segment(10);
          // $has_dep_val = $this->uri->segment(11);

          if(!empty($seg[1][0]['SEGMENT_VALUE_DESC']))
          {
            $test = $seg[1][0]['SEGMENT_VALUE_DESC'];
          }
          else
          {

          $test='';
          }

         
         
          ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    
      <h1>
        View Child
        <small>Form</small>
      </h1>

      

      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Segment Form</li>
      </ol>
    </section>
    
    <input  id="struc_id"     type="hidden" name="struc_id"     value="<?php echo $this->uri->segment(4); ?>">
    <input  id="segment_no"   type="hidden" name="segment_no"   value="<?php echo $this->uri->segment(5); ?>">
    <input  id="dependent_on" type="hidden" name="dependent_on" value="<?php echo $this->uri->segment(6); ?>">
    <input  id="qualifier_id" type="hidden" name="qualifier_id" value="<?php echo $this->uri->segment(7); ?>">
    <input  id="dep_key_id"   type="hidden" name="dep_key_id"   value="<?php echo $this->uri->segment(8); ?>">
    <input  id="segment_id"   type="hidden" name="segment_id"   value="<?php echo $this->uri->segment(9); ?>">
    <input  id="parent_structuree_id"  type="hidden" name="parent_structuree_id" value="<?php echo $this->uri->segment(10); ?>">
   <!--  <input  id="has_dep_val"   type="text" name="has_dep_val"   value="<?php //echo $this->uri->segment(11); ?>"> -->

                 

                  

                       
   <section class="content">
      <div class="row">
        <div class="col-sm-12">
          <div class="box">
            

            
            <!-- /.box-header -->
            <form method="post" action="<?php echo base_url().'accounting/c_tree/seg_add/'.$struc_id.'/'.$segm_id.'/'.$dep_key.'/'.$qual_id.'/'.$dep_key_id.'/'.$segment_id.'/'.$parent_structuree_id?>">

            
            <div class="box-body">

                <div class="row">
                <div class="col-sm-12">

                 <div class="col-sm-6">
                <div class="form-group">
                  <!-- <label for="structure_id" class=" control-label">structure_id:</label> -->
                
                    <input name="structure_id" placeholder="structure_id" class="form-control" type="hidden" value="<?php echo $struc_id; ?>">
                  </div>
                </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <!-- <label for="structure_id" class=" control-label">dep_on_struc_id:</label> -->
                
                    <input name="dep_on_struc_id" placeholder="dep_on_struc_id" class="form-control" type="hidden" value="<?php echo $struc_id; ?>">
                  </div>
                </div>

            
              <div class="col-sm-6">
                <div class="form-group">
                 <label for="parent_desc" class=" control-label">parent_desc:</label>
                
                <input name="parent_desc"  class="form-control" type="text" value="<?php echo $test ?>" >
                  </div>
                </div>
              
              

    
                <div class="form-group">
                  <div class="col-sm-12 buttn_submit">

                      <?php if(isset($segment_id)){?>
                      <!-- <input  type="submit" name="insert" value="Add Child" class="btn btn-info" /> -->
                      <input  type="submit" name="update" value="update Child" class="btn btn-warning" />
                      <input  type="submit" name="delete" value="delete Child" class="btn btn-danger" />
  
                      <?php } else{?>
                      <input  type="submit" name="insert" value="Add Root" class="btn btn-info" />

                      <?php } ?>
                    
                    <button id ="back_click" type="button" name="add root" class="btn btn-danger" >Back</button>
                    </div>
                  </div>
                </form>
                      

                      
          

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



<?php $this->load->view("template/footer.php"); ?>

<script>    
$("#back_click").click(function(){
   
    var struc_id = $('#struc_id').val();
    var segment_no = $('#segment_no').val();
    var dependent_on = $('#dependent_on').val();
    var qualifier_id = $('#qualifier_id').val();
    var dep_key_id = $('#dep_key_id').val();
    var segment_id = $('#segment_id').val();
    var parent_structuree_id = $('#parent_structuree_id').val();
    var has_dep_val = $('#has_dep_val').val();
    // alert(struc_id); return false;
    window.location.href ='<?php echo base_url();?>accounting/c_tree/tree_list/'+struc_id+'/'+segment_no+'/'+dependent_on+'/'+qualifier_id+'/'+dep_key_id;
  });

$("#update_click").click(function(){
   
   
    var segment_id = $('#segment_id').val();
    
    // alert(struc_id); return false;
    window.location.href ='<?php echo base_url();?>accounting/c_tree/seg_update/'+segment_id;
  });
</script>


