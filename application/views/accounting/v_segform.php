<?php $this->load->view('template/header');?>

<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
        
      <input id ="root_click" type="button" name="add_root" class="btn btn-info btn-lg" value ="Add Root">
    <!-- 4 -->
    <?php  $struc_id = $this->session->userdata('struc_id');?> 
    <input id ="struc_id" type="text" name="struc_id" value="<?php echo $struc_id; ?>">
    <!-- 5 -->
    <?php  $segment_no = $this->session->userdata('segment_no');?>
    <input id ="segment_no" type="text" name="segment_no" value="<?php echo $segment_no; ?>">
    <!-- 6 -->
    <?php  $dependent_on = $this->session->userdata('dependent_on');?>
    <input id ="dependent_on" type="text" name="dependent_on" value="<?php echo $dependent_on; ?>">
    <!-- 7 -->
    <?php  $qualifier_id = $this->session->userdata('qualifier_id');?>
    <input id ="qualifier_id" type="text" name="qualifier_id" value="<?php echo $qualifier_id; ?>">
    <!-- 8 -->
    <?php  $has_dep_val = $this->session->userdata('has_dep_val');?>
    <input id ="has_dep_val" type="text" name="has_dep_val" value="<?php echo $has_dep_val; ?>">

          <?php 

          
          $segment_id = $this->uri->segment(4);
          // $parent_structuree_id = $this->uri->segment(10);
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
      
      <?php if(isset($segment_id)){?>
      <h1>
        Add Child
        <small>Form</small>
      </h1>

      <?php } else{?>
       <h1>
        Add Root
        <small>Form</small>
      </h1>
      <?php } ?>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Segment Form</li>
      </ol>
    </section>
    
                     

                       
   <section class="content">
      <div class="row">
        <div class="col-sm-12">
          <div class="box">
            

            
            <!-- /.box-header -->
            <form method="post" action="<?php echo base_url().'accounting/c_tree/seg_add/'.$segment_id ?>">

            
            <div class="box-body">

                <div class="row">
                <div class="col-sm-12">

                 <div class="col-sm-6">
                <div class="form-group">
                  <!-- <label for="structure_id" class=" control-label">structure_id:</label> -->
                    <label for="structure_id" class=" control-label">structure id</label>
                    <input name="structure_id" placeholder="structure_id" class="form-control" type="text" value="<?php echo $struc_id; ?>">
                  </div>
                </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <!-- <label for="structure_id" class=" control-label">dep_on_struc_id:</label> -->
                  <label for="dep_on_struc_id" class=" control-label">dep_on_struc_id</label>
                    <input name="dep_on_struc_id" placeholder="dep_on_struc_id" class="form-control" type="text" value="<?php echo $struc_id; ?>">
                  </div>
                </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="Acc Code" class=" control-label">Acc Code:</label>
                
                    <input name="segment_value" placeholder="Enter Acc Code" class="form-control" type="text" >
                  </div>
                </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="Acc Description" class=" control-label">Acc Description:</label>
                
                    <input name="segment_value_desc" placeholder="Enter Acc Description" class="form-control" type="text" >
                  </div>
                </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="Acc Short Description" class=" control-label">Acc Short Desc:</label>
                
                    <input name="segment_value_short_desc" placeholder="Enter Acc Short Description" class="form-control" type="text" >
                  </div>
                </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="Family / Nature" class=" control-label">Family / Nature:</label>
                
                    <select name="segment_nature_id" class="form-control" >
                    <?php 
                    foreach ($nature['nature_id'] as $row) { ?>

                     <option value="<?php echo $row['SEGMENT_VAL_NATURE_ID']; ?>"><?php echo $row['SEGMENT_NATURE_DESC']; ?></option>

                     <?php } ?>
                     </select>
                  </div>
                </div>

             <!--  parent discription to add value in add child form v_segform -->
            <?php if(!empty($segment_id)){?>
              <div class="col-sm-6">
                <div class="form-group">
                 <label for="parent_desc" class=" control-label">parent_desc:</label>
                
                <input name="parent_desc"  class="form-control" type="text" value="<?php echo $test ?>" >
                  </div>
                </div>
                <?php } ?>
              
              

              <div class="col-sm-6">
                <div class="form-group">
                 <!--  <label for="parent_structuere_id" class=" control-label">parent_structuere_id:</label> -->
                
                <input name="parent_structuere_id" placeholder="parent_structuere_id" class="form-control" type="text" value="<?php //echo $parent_structuree_id; ?>" >
                  </div>
                </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <!-- <label for="parent_segment_id" class=" control-label">parent_segment_id:</label> -->
                
                <input name="parent_structuere_id" placeholder="parent_structuere_id" class="form-control" type="text" value="<?php echo $segment_id; ?>" >
                  </div>
                </div>


                <div class="col-sm-6">
                <div class="form-group">
                  <label for="Parent_yn" class=" control-label">Parent yn:</label>
                
                    <input name="Parent_yn"   class="checkbox" type="checkbox" >
                  </div>
                </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="Parent_yn" class=" control-label">Contains_subsidiary:</label>
                
                    <input name="Contains_subsidiary"  class="checkbox" type="checkbox" >
                  </div>
                </div>
    
                <div class="form-group">
                  <div class="col-sm-12 buttn_submit">

                      <?php if(isset($segment_id)){?>
                      <input  type="submit" name="insert" value="Add Child" class="btn btn-info" />
                      <!-- <input  type="submit" name="update" value="update Child" class="btn btn-warning" />
                      <input  type="submit" name="delete" value="delete Child" class="btn btn-danger" /> -->
  
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
    var has_dep_val = $('#has_dep_val').val();
    var segment_id = $('#segment_id').val();
    //var parent_structuree_id = $('#parent_structuree_id').val();
    var has_dep_val = $('#has_dep_val').val();
    // alert(struc_id); return false;
    window.location.href ='<?php echo base_url();?>accounting/c_tree/tree_list/'+struc_id+'/'+segment_no+'/'+dependent_on+'/'+qualifier_id+'/'+has_dep_val;
  });

$("#update_click").click(function(){
   
   
    var segment_id = $('#segment_id').val();
    
    // alert(struc_id); return false;
    window.location.href ='<?php echo base_url();?>accounting/c_tree/seg_update/'+segment_id;
  });
</script>


