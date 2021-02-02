
  <!-- Content Wrapper. Contains page content -->
 
    <!-- Content Header (Page header) -->
    <!-- <section class="content-header">
      <h1>
        Listing Confirmation
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php //echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Listing Confirmation</li>
      </ol>
    </section> -->

    <!-- Main content -->
    
      <!-- Small boxes (Stat box) -->
        
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Listing Confirmation</h3>
            </div>
            <!-- /.box-header -->
                      <div class="box-body">

                          <!-- <form action="<?php //echo base_url('tolist/c_tolist/list_item_confirm_merg'); ?>" method="post" accept-charset="utf-8"> -->
                          <table class="table table-bordered table-hover table-responsive">
                            <tr>
                              <th>Select</th>
                              <th>eBay ID</th>
                              <th>Title</th>
                              <th>Condition ID</th>
                              <th>Condition Name</th>
                            </tr>
                          <?php 
                          $j=0;

                          foreach ($ebay_id as $ebay_item_id) { 

                            if($j===0){
                              $checked = 'checked';
                            }else{
                              $checked = '';
                            }
                            ?>

                            <tr>
                            <td><input type="radio" name="selected_ebay_id" value="<?php echo $ebay_item_id; ?>" <?php echo $checked;?>></td>
                              <td><a style="text-decoration: underline;" title="ebay URL" target="_blank" href="<?php echo $item_url[$j]; ?>"><?php echo $ebay_item_id; ?></a></td>
                              <td><?php echo $title[$j]; ?></td>
                              <td><?php echo $condition_id[$j]; ?></td>
                              <td><?php echo $condition_Name[$j]; ?></td>
                            </tr>
                         <?php $j++;
                          }// end foreach
                            ?>
                          </table>
                          <div class="col-sm-12">
                          
                            <input type="hidden" name="list_barcode" id="list_barcode" value="<?php echo @$list_barcode; ?>">
                            <input type="hidden" name="seed_id" id="seed_id" value="<?php echo @$seed_id; ?>">
                            <input type="hidden" name="check_btn" id="check_btn" value="<?php echo @$check_btn;?>">
                            <input type="hidden" name="account_name" id="account_name" value="<?php echo @$account_name[0];?>">
                            <input type="hidden" name="shopifyCheckbox" id="shopifyCheckbox" value="<?php echo @$shopifyCheckbox;?>">
                            <input type="hidden" name="bestOfferCheckbox" id="bestOfferCheckbox" value="<?php echo @$bestOfferCheckbox;?>">
                            <input type="hidden" name="user_id" id="user_id" value="<?php echo @$user_id;?>">
                            <input type="hidden" name="userName" id="userName" value="<?php echo @$userName;?>">
                            <div class="form-group pull-left m-r-5">
                                <input type="button"  id = "revise_item" title="Revise Item" class="btn btn-dark" name="revise_item" value="Revise Item" >
                            </div>
                            <?php 
                            if(@$check_btn != 'revise'){ ?>
                              <div class="form-group pull-left m-r-5">
                                <input type="button" title="Add Item" class="btn btn-primary" id = "add_item" name="add_item" value="Add Item" >
                              </div> 
                            <?php
                            }
                            ?>
                                                     
                            <!-- <div class="form-group pull-left m-r-5">
                                <a title="Back to Item Listing" href="<?php //echo base_url('dekitting_pk_us/c_to_list_pk/lister_view'); ?>" class="btn btn-warning">Cancel</a>
                            </div> -->
                          </div>
                          <!-- </form> -->
                        </div> <!-- box div close -->
                         
            </div>  


        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
     

<script >
  
  $("#revise_item").click(function(){
    //$.LoadingOverlay('show')
    //$.LoadingOverlay("show");
    $("#revise_item").prop("disabled", true);
    var getUrl = window.location;
      var finalurl = getUrl.protocol + "//" + getUrl.hostname;
    //   alert(finalurl);
    // return false;

    var insertUrl =finalurl+"/laptopzone/reactcontroller/c_react/list_item_confirm_merg";
    var check_btn  = $("#check_btn").val();
    var shopifyCheckbox  = $("#shopifyCheckbox").val();
    var bestOfferCheckbox  = $("#bestOfferCheckbox").val();
    var seed_id  = $("#seed_id").val();
    var list_barcode  = $("#list_barcode").val();
    var selected_ebay_id  =  $("input[name='selected_ebay_id']:checked").val();
     //= $("#selected_ebay_id").val();
    // alert(selected_ebay_id);
    // return false;
    var revise_item  = $("#revise_item").val();
    
    var account_id = $("#account_name").val();//2;//$this->session->userdata('account_type');
    var user_id = $("#user_id").val();//2;//$this->session->userdata('account_type');
    var userName = $("#userName").val();//2;//$this->session->userdata('account_type');
    

      new Promise(function (resolve, reject) {
          $.ajax({
            url: insertUrl ,
            dataType: 'text',
            
            type: 'POST',


            data: {revise_item:revise_item,check_btn:check_btn,shopifyCheckbox:shopifyCheckbox,bestOfferCheckbox:bestOfferCheckbox,seed_id:seed_id,list_barcode:list_barcode,selected_ebay_id:selected_ebay_id,user_id:user_id,userName:userName
            }
          }).then(
            function (data) {
              resolve(data)
            },
            function (err) {
              reject(err)
            }
          )
        })
          .then(result => {
            console.log(result);
           // $.LoadingOverlay('hide')
            //$.LoadingOverlay("hide");
            $("#revise_item").prop("disabled", false);
           // alert('Success');
            $('#showData').html('');
            $('#showData').append("'"+result+"'");
           //if(result);{
            return false;

           //}
          
        })
        .catch(err => {
          //$.LoadingOverlay('hide')
          alert('error. Contact Administrator!');
          console.log(err)
          return false;
        })            
            

      // }else{
      //   alert('Error! Item Cannot be listed | List Price < (Cost + Selling Expenses)');
      //   //$('body').scrollTo('#target');//.css({'border':'3px solid #ac2925', 'padding':'5px'})
      //   $('html,body').animate({
      //     scrollTop: $("#target").offset().top},
      //     'slow');
      //   $("#target").css({'border':'3px solid #ac292585', 'padding':'12px 5px 0px 5px'});
      //   //<i class="glyphicon glyphicon-eye-close form-control-feedback"></i>
      //   $("#authenticate_pass").append('<div class="col-sm-4"><div id="wrapper"> <div class="form-group has-feedback"> <input type="password" class="form-control" id="auth_password" placeholder="Password"> </div> </div></div> <div class="col-sm-2"><div class="form-group"> <button class="btn btn-danger btn-block" id="forceList" call="list">Force to List</button> </div></div>'); 

      //   return false;

      // }



     });

  $("#add_item").click(function(){
    //$.LoadingOverlay('show')
    //$.LoadingOverlay("show");
    $("#add_item").prop("disabled", true);
    var getUrl = window.location;
      var finalurl = getUrl.protocol + "//" + getUrl.hostname;
    //   alert(finalurl);
    // return false;

    var insertUrl =finalurl+"/laptopzone/reactcontroller/c_react/list_item_confirm_merg_add_item";
    var check_btn  = 'add_item';//$("#check_btn").val();
    var shopifyCheckbox  = $("#shopifyCheckbox").val();
    var bestOfferCheckbox  = $("#bestOfferCheckbox").val();
    var seed_id  = $("#seed_id").val();
    var list_barcode  = $("#list_barcode").val();
    var selected_ebay_id  =  $("input[name='selected_ebay_id']:checked").val();
     //= $("#selected_ebay_id").val();
    // alert(selected_ebay_id);
    // return false;
    var revise_item  = $("#revise_item").val();
    
    var accountId = $("#account_name").val();//2;//$this->session->userdata('account_type');
    var user_id = $("#user_id").val();//2;//$this->session->userdata('account_type');
    var userName = $("#userName").val();//2;//$this->session->userdata('account_type');
    

      new Promise(function (resolve, reject) {
          $.ajax({
            url: insertUrl ,
            dataType: 'text',
            
            type: 'POST',


            data: {revise_item:revise_item,check_btn:check_btn,accountId:accountId,shopifyCheckbox:shopifyCheckbox,bestOfferCheckbox:bestOfferCheckbox,seed_id:seed_id,list_barcode:list_barcode,selected_ebay_id:selected_ebay_id,user_id:user_id,userName:userName
            }
          }).then(
            function (data) {
              resolve(data)
            },
            function (err) {
              reject(err)
            }
          )
        })
          .then(result => {
            console.log(result);
           // $.LoadingOverlay('hide')
            //$.LoadingOverlay("hide");
            $("#add_item").prop("disabled", false);
           // alert('Success');
            $('#showData').html('');
            $('#showData').append("'"+result+"'");
           //if(result);{
            return false;

           //}
          
        })
        .catch(err => {
          //$.LoadingOverlay('hide')
          alert('error. Contact Administrator!');
          console.log(err)
          return false;
        })            
            

      // }else{
      //   alert('Error! Item Cannot be listed | List Price < (Cost + Selling Expenses)');
      //   //$('body').scrollTo('#target');//.css({'border':'3px solid #ac2925', 'padding':'5px'})
      //   $('html,body').animate({
      //     scrollTop: $("#target").offset().top},
      //     'slow');
      //   $("#target").css({'border':'3px solid #ac292585', 'padding':'12px 5px 0px 5px'});
      //   //<i class="glyphicon glyphicon-eye-close form-control-feedback"></i>
      //   $("#authenticate_pass").append('<div class="col-sm-4"><div id="wrapper"> <div class="form-group has-feedback"> <input type="password" class="form-control" id="auth_password" placeholder="Password"> </div> </div></div> <div class="col-sm-2"><div class="form-group"> <button class="btn btn-danger btn-block" id="forceList" call="list">Force to List</button> </div></div>'); 

      //   return false;

      // }



     });

  

</script>