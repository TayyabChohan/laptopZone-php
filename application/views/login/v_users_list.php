<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Users Listing
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Users</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="box"><br>  
           <div class="col-sm-12">
            <div class="col-sm-2">
              <div class="form-group pull-left">
                <?php $login_id = $this->session->userdata('user_id'); 
                if($login_id == 2 ||   $login_id == 17 || $login_id == 21){ ?>
                <button type="button" title="Go Back" onclick="location.href='<?php echo base_url('login/c_users/addNewUser') ?>'" class="btn btn-success ">Add User</button>
                <?php }?> 
              </div>
            </div>
            <!-- <div class="col-sm-2  col-sm-offset-8">
               <div class="form-group pull-right">
                  <button type="button" title="Go Back" onclick="location.href='<?php //echo base_url('BundleKit/c_bkProfiles/viewSavedData') ?>'" class="btn btn-success ">View Data</button> 
              </div>
            </div> -->
        </div>    
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
              
                    <table id="userTable" class="table table-responsive table-striped table-bordered table-hover">
                      <thead>
                          <th>ACTIONS</th>
                          <th>USER ID</th>
                          <th>FIRST NAME</th>
                          <th>LAST NAME</th>
                          <th>USER NAME</th>
                          <th>PASSWORD</th>
                          <th>EMAIL</th>
                          <th>LOCATION</th>
                      </thead>
                      <tbody>
                        <?php
                        $i=1;
                        if($users->num_rows() > 0)
                        {
                          // echo "<pre>";
                          // print_r($users->result_array());
                          // exit;
                         foreach ($users->result() as $user){
                           ?>
                           <tr>
                             <td>
                                <div class="edit_btun" style=" width: 90px; height: auto;">
                                   <a title="Edit User" href="<?php echo base_url().'login/c_users/updateUser/'.$user->EMPLOYEE_ID; ?>" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil p-b-5" aria-hidden="true"></span>
                                   </a> 
                                   <?php
                                   if ($user->STATUS == 1)  
                                    { ?>
                                    <button title="Disabled" id="<?php echo $user->EMPLOYEE_ID; ?>"  class="btn btn-danger btn-xs disable"><span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span> 
                                    </button>
                                  <?php }
                                  elseif($user->STATUS == 0)
                                  { ?>
                                    <button title="Enabled" id="<?php echo $user->EMPLOYEE_ID; ?>"  class="btn btn-success btn-xs enable"><span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span>
                                    </button>
                                  <?php
                                    }
                                   ?>
                                    
                                </div> 
                             </td>
                             <td><?php echo $user->EMPLOYEE_ID; ?></td>
                             <td><?php echo $user->FIRST_NAME; ?></td>
                             <td><?php echo $user->LAST_NAME; ?></td>
                             <td><?php echo $user->USER_NAME; ?></td>
                             <td>
                               <div class="password_encode_<?php echo  $i; ?>" class="pull-left"><?php echo md5($user->PASS_WORD, true); ?></div><button type="button" class="btn btn-default  btn-xs pull-right" onclick="showPassword(this.id); " id="hide_show_pass_<?php echo  $i; ?>" passId="password_encode_<?php echo  $i; ?>">Show/Hide</button>
                               <div class="password_encode_<?php echo  $i; ?>" style="display: none;"><?php echo $user->PASS_WORD; ?></div>
                             </td>
                             <td><?php echo $user->E_MAIL_ADDRESS; ?></td>
                             <td><?php echo $user->LOCATION; ?></td>                                           
                           <?php
                           $i++; ?>
                          </tr> 
                         <?php } 
                         ?>
                          </tbody> 
                        </table>
                       <?php
                      }else {
                        ?>
                        </tbody> 
                      </table>              
                      <?php
                      } ?>
                      <input type="hidden" name="user_count" id="user_count" value="<?php echo $i; ?>">
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
     <div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
      <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="ajax loader" style="width: 100px; height: 100px;">
    </div>
    <!-- /.content -->
  </div>    
<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>
 <script>
$(document).ready(function()
  {
     $('#userTable').DataTable({
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
  /////////////////////////////////  
  $(document).on('click', '.disable', function()
  {
    var user_id = $(this).attr("id");
    if (confirm('Are you sure to want Disable this User!'))
     {
      $(".loader").show();
      //console.log(user_id, status); return false;
      $.ajax({
        dataType: 'json',
        type: 'POST',
        url:'<?php echo base_url(); ?>login/c_users/disable_user',
        data: {'user_id' : user_id},
        success: function (data) 
        {
          if (data)
           {
            $(".loader").hide();
            $("#"+user_id).removeClass("disable btn-danger").addClass("enable btn-success");

            $("#"+user_id+" span").removeClass(" glyphicon-ban-circle").addClass("glyphicon-ok-circle");
           }
        },
        complete: function(data)
        {
          $(".loader").hide();
        },
        error: function(jqXHR, textStatus, errorThrown){
             $(".loader").hide();
            if (jqXHR.status)
            {
              alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
            }
        }
      });
    }
  });
  ////////////////////////////////  
  /////////////////////////////////  
  $(document).on('click', '.enable', function()
  {
    var user_id = $(this).attr("id");
    if (confirm('Are you sure to want Enable this User!'))
     {
      $(".loader").show();
      //console.log(user_id, status); return false;
      $.ajax({
        dataType: 'json',
        type: 'POST',
        url:'<?php echo base_url(); ?>login/c_users/enable_user',
        data: {'user_id' : user_id},
        success: function (data) 
        {
          if (data)
           {
            $(".loader").hide();
            $("#"+user_id).removeClass("enable btn-success").addClass("disable  btn-danger");

            $("#"+user_id+" span").removeClass("glyphicon-ok-circle").addClass(" glyphicon-ban-circle");
           }
        },
        complete: function(data)
        {
          $(".loader").hide();
        },
        error: function(jqXHR, textStatus, errorThrown){
             $(".loader").hide();
            if (jqXHR.status)
            {
              alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
            }
        }
      });
    }
  });
  ////////////////////////////////    
});
function showPassword(id)
{
   var hideTd=$("#"+id+"").attr('passId');
   $("."+hideTd+"").toggle();
}
</script>