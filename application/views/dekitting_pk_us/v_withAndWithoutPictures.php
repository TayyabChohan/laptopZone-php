<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); 
?>
<html>
<head>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          Picture Shooting - De-Kitting - U.S.
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> Picture Shooting - De-Kitting - U.S.</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content"> 
    <!-- Master Barcode Search Box section Start -->
      <div class="row">
      <div class="col-sm-12">

        <!-- Barcode Detail Table Start  -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Picture-Shooting Details</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
            <div class="box-body">
              <!-- Print Message -->
              <div class="col-sm-12">
                <div class="col-sm-4">
                </div>
                <div class="col-sm-4">
                  <div class="form-group text-center emptyDiv">
                    <div id="printMessage">
                    </div>
                  </div>
                </div>
                <div class="col-sm-4">
                </div>                
              </div>
              <!-- End Print Message -->
              <div class="box-body form-scroll">
                <div class="col-sm-12">
                  <div class="col-sm-10"></div>
                  <div class="col-sm-2">
                  <div class="form-group pull-right">
                    <a style="font-weight: 600;font-size: 16px !important;text-decoration: underline;" href="<?php echo base_url(); ?>dekitting_pk_us/c_pic_shoot_us" title="Back to add Pictures Screen">Back to Add Pictures Screen</a>
                  </div>
                  </div>   
                </div>

              <div class="col-md-12"><!-- Custom Tabs -->

              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                <!-- <?php //if(@$activeTab == 'Listed'){ ?> -->
                  <li class="active"><a href="#tab_2" data-toggle="tab" id="secondTab">Barcode Without Pictures</a></li>
                  <li><a href="#tab_1" id="firstTab" data-toggle="tab">Barcode with Pictures</a></li>
                  

                </ul>
                <div class="tab-content">
                  <div class="tab-pane <?php //if(@$activeTab == 'Not Listed'){echo 'active';}?>" id="tab_1">
                    <table id="dekit_pk_us" class="table table-responsive table-striped table-bordered table-hover">
                  <thead>

                    <tr>

                      <th>Barcode</th>
                      <th>Object</th>
                      <th>Condition</th>

                      <th>Weight</th>
                      <th style="width:80px !important;">BIN/Rack</th>
                      <th>Dekitting Remarks</th>

                      <th>Status</th>  
                    </tr>
                  </thead>
                  <tbody id="table_body">
                  
                  </tbody>
                </table>              
                  </div>
              </div>
                
               <div class="tab-content">
                  <div class="tab-pane <?php //if(@$activeTab == 'Not Listed'){echo 'active';}?>" id="tab_2">
                    <table id="non_picture" class="table table-responsive table-striped table-bordered table-hover">
                  <thead>

                    <tr>
                      <th>Barcode</th>
                      <th>Object</th>
                      <th>Condition</th>
                      <th>Weight</th>
                      <th style="width:80px !important;">BIN/Rack</th>
                      <th>Dekitting Remarks</th>
                  </thead>
                  <tbody id="table_body1">
                  
                  </tbody>
                </table>              
                  </div>
              </div>
                    <!-- nav-tabs-custom -->
              </div>
              </div>
                  
                <!-- /.col --> 

                </div>
              
            </div>
          <!-- Barcode Detail Table End  -->
        <!-- /.col -->
         <div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
      <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="ajax loader" style="width: 100px; height: 100px;">
    </div>
    </div>
    </div>
  </section>
</div>

   
          
<!-- End Listing Form Data -->
<?php $this->load->view('template/footer'); ?>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Base64/1.0.1/base64.js"></script> -->
<!-- <script  src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script  src="https://cdn.rawgit.com/igorlino/elevatezoom-plus/1.1.6/src/jquery.ez-plus.js"></script> -->

<script>
var dataTable = '';
var tableData = '';


function loadRecords(){

      $.ajax({
      url: '<?php echo base_url();?>dekitting_pk_us/c_pic_shoot_us/checkPictures', 
      type: 'post',
      dataType: 'json',
      success:function(data){

        var arr = [];
        for(var i=0;i<data.nonPics.length;i++){

           var dekit = data.nonPics[i][0].DEKIT_REMARKS;
            if( typeof dekit == 'object'){
              dekit = JSON.stringify(dekit);
              dekit = '';
              // alert(dekit);
            }else if(dekit === 'udefined'){
              dekit = '';
            }
            arr.push('<tr><td style="width:100px">'+data.nonPics[i][0].BARCODE_PRV_NO+'<!--<input type="text" id="barcode_no'+i+'" class="form-control barcode_no" value="'+data.nonPics[i][0].BARCODE_PRV_NO+'" readonly style="width:100px !important;">--></td><td style="width:240px !important;">'+data.nonPics[i][0].OBJECT_NAME+'<!--<input type="text" id="obj_name'+i+'" class="form-control obj_name" value="'+data.nonPics[i][0].OBJECT_NAME+'" readonly style="width:240px !important;">--></td><td style="width:240px !important;">'+data.nonPics[i][0].COND_NAME+'<!--<input type="text" id="condition'+i+'" class="form-control condition" value="'+data.nonPics[i][0].COND_NAME+'" readonly style="width:200px !important;">--></td><td style="width:70px !important;"><!--<input type="text" id="weight'+i+'" class="form-control weight" value="'+data.nonPics[i][0].WEIGHT+'" readonly style="width:70px !important;">-->'+data.nonPics[i][0].WEIGHT+'</td><td style="width:70px !important;"><!--<input type="text" id="binRack_no'+i+'" class="form-control binRack_no" value="'+data.nonPics[i][0].BIN_NO+'" readonly style="width:70px !important;">-->'+data.nonPics[i][0].BIN_NO+'</td><td style="width:270px !important;"><!--<input type="text" id="det_ramarks'+i+'" class="form-control det_ramarks" value="'+dekit+'" readonly style="width:270px !important;">-->'+dekit+'</td></tr>');
        }

        $('#table_body1 ').html("");
        $('#table_body1 ').append(arr.join(""));

       if(dataTable != ''){
        dataTable = dataTable.destroy();
        // $('#non_picture').DataTable().fnDestroy();
        // $('#non_picture').ajax.reload();
       }


        dataTable = $('#non_picture').DataTable({
          "oLanguage": {
            "sInfo": "Total Records: _TOTAL_"
          },
          "iDisplayLength": 25,
            "aLengthMenu": [[25, 50, 100, 200,500, -1], [25, 50, 100, 200,500, "All"]],
            "paging": true,
            "destroy": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            // "order": [[ 16, "ASC" ]],
            "info": true,
            "autoWidth": true,
            "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
        }); 


        var pics = [];
        for(var i=0;i<data.pics.length;i++){

           var dekits = data.pics[i][0].DEKIT_REMARKS;
            if( typeof dekits == 'object'){
              dekits = JSON.stringify(dekit);
              dekits = '';
              // alert(dekit);
            }else if(dekits === 'udefined'){
              dekits = '';
            }
            var img = '<p style="font-weight:bold;width:140px;color:red;" class="sort_img up-img">Picture Not Found !</p>';

          if(data.flag[i] == true){
 
            var source = data.dir_path[i];

            img = '<img src="data:image;base64,'+source+'" id="thumbnail'+i+'"  class="sort_img up-img">';

          }
            pics.push('<tr><td style="width:100px !important;">'+data.pics[i][0].BARCODE_PRV_NO+'<!--<input type="text" id="barcode_no'+i+'" class="form-control barcode_no" value="'+data.pics[i][0].BARCODE_PRV_NO+'" readonly style="width:100px !important;">--></td><td style="width:240px !important;">'+data.pics[i][0].OBJECT_NAME+'<!--<input type="text" id="obj_name'+i+'" class="form-control obj_name" value="'+data.pics[i][0].OBJECT_NAME+'" readonly style="width:240px !important;">--></td><td style="width:200px !important;">'+data.pics[i][0].COND_NAME+'<!--<input type="text" id="condition'+i+'" class="form-control condition" value="'+data.pics[i][0].COND_NAME+'" readonly style="width:200px !important;">--></td><td style="width:70px !important;">'+data.pics[i][0].WEIGHT+'<!--<input type="text" id="weight'+i+'" class="form-control weight" value="'+data.pics[i][0].WEIGHT+'" readonly style="width:70px !important;">--></td><td style="width:70px !important;">'+data.pics[i][0].BIN_NO+'<!--<input type="text" id="binRack_no'+i+'" class="form-control binRack_no" value="'+data.pics[i][0].BIN_NO+'" readonly style="width:70px !important;">--></td><td >'+dekits+'<!--<input type="text" id="det_ramarks'+i+'" class="form-control det_ramarks" value="'+dekits+'" readonly style="width:270px !important;">--></td><td>'+img+'</td></tr>');
        }

        $('#table_body ').html("");
        $('#table_body ').append(pics.join(""));

       
        if(tableData != ''){
          tableData = tableData.destroy();
          // $('#dekit_pk_us').DataTable().fnDestroy();
          // $('#dekit_pk_us').ajax.reload();
        }
        // tableData.ajax.reload();
        
        tableData = $('#dekit_pk_us').DataTable({
          "oLanguage": {
            "sInfo": "Total Records: _TOTAL_"
          },
          "iDisplayLength": 25,
            "aLengthMenu": [[25, 50, 100, 200,500, -1], [25, 50, 100, 200,500, "All"]],
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            // "order": [[ 16, "ASC" ]],
            "destroy": true,
            "info": true,
            "autoWidth": true,
            "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
        });         
      }


  });



}



function reload(){

    if(tableData != ''){
      tableData = tableData.destroy();
    }

        tableData = $('#dekit_pk_us').DataTable({
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
        "bAutoWidth": false,

        "ajax":{
          url: '<?php echo base_url();?>dekitting_pk_us/c_pic_shoot_us/checkPicturess', 
          type: 'post',
          dataType: 'json',
          // success:function(data){}
        },
        "columnDefs":[{
            "target":[0],
            "orderable":false
          }
        ]

      });

      if(dataTable != ''){
        dataTable = dataTable.destroy();
        // $('#non_picture').DataTable().fnDestroy();
        // $('#non_picture').ajax.reload();
       }

    dataTable = $('#non_picture').DataTable({
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
        "bAutoWidth": false,

        "ajax":{
          url: '<?php echo base_url();?>dekitting_pk_us/c_pic_shoot_us/checkNonPicturess', 
          type: 'post',
          dataType: 'json',
          // success:function(data){}
        },
        "columnDefs":[{
            "target":[0],
            "orderable":false
          }
        ]

      });

}

$(document).ready(function(){
  $('#barcode_prv').focus();
  $('#addPicsBox').hide();
  $('#addbarcodePic').prop('disabled',true);
  $('#tab_1').hide();
  $('#tab_2').show();
  reload();

});
$("#drop-img-area").on('dragenter', function (e){
    e.preventDefault();
  });

  $("#drop-img-area").on('dragover', function (e){
    e.preventDefault();
  });

  $("#drop-img-area").on('drop', function (e){
    e.preventDefault();
    var dekit_image = e.originalEvent.dataTransfer.files;
    createFormData(dekit_image);
  });

  $("#btnupload_img").click(function(){
    $("#dekit_image").trigger("click");
  });

  $("#dekit_image").change(function(){
    var postData = new FormData($("#frmupload")[0]);
    uploadDekitFormData(postData);
  });



$('#firstTab').on('click',function(){
  $('#tab_1').show();
  $('#tab_2').hide();
});

$('#secondTab').on('click',function(){
  $('#tab_1').hide();
  $('#tab_2').show();
});



$('#barcode_prv').on('blur',function(){
  $('#addPicsBox').hide();
  var barcode = $('#barcode_prv').val();
  $('#addbarcodePic').prop('disabled',false);
  if(barcode != ''){
    $('.loader').show();
    $.ajax({
        url: '<?php echo base_url();?>dekitting_pk_us/c_pic_shoot_us/showChildDetails', 
        type: 'post',
        dataType: 'json',
        data : {'barcode':barcode},
        success:function(data){
          $('.loader').hide();

     
        $('#search_Remarks').val(data.child_bar[0].DEKIT_REMARKS);
        $('#condition_segs').val(data.child_bar[0].COND_NAME);
        $('#singleObj').val(data.child_bar[0].OBJECT_NAME);
        $('#search_weight').val(data.child_bar[0].WEIGHT);
        $('#search_bin').val(data.child_bar[0].BIN_ID);

          var barcode = $('#barcode_prv').val();
      var condition = $('#condition_segs').val();
      if(barcode != ''){


        $('#addPicsBox').show();
         $.ajax({
            url: '<?php echo base_url();?>dekitting_pk_us/c_pic_shoot_us/getLivePictures', 
            type: 'post',
            dataType: 'json',
            success:function(data){
              var livePics = [];
              //console.log(data.dir_path.length);
              //console.log(data.image_url);
              for(var i=0;i<data.dir_path.length;i++){

               var radio_btn = '<input type="radio" name="mpn_picture" id="mpn_picture" value="MPN_" pic_name="'+data.image_url[i]+'" title="MPN Picture">';
               //console.log(check_box); return false;

               var source = data.dir_path[i];
               var img = '<img class="sort_img up-img zoom_01" id="" name="save_thumbnail'+i+'" src="data:image;base64,'+source+'"/>'
                // img = '<img src="data:image;base64,'+source+'" id="thumbnail'+i+'"  class="sort_img up-img">';

                livePics.push('<li id="list'+i+'" style="width: 105px; height: 125px; background: #eee; float: left; overflow: hidden; text-align: center; position: relative; padding: 3px;"><span class="tg-li"> <div class="thumb imgCl" style="display: block; border: 1px solid rgb(55, 152, 198);">'+img+'</div>'+radio_btn+'</span></li>');
              }

              $('#live_pics').html("");
              $('#live_pics').append(livePics.join(""));
              
            }
          });

        
          $.ajax({
            url: '<?php echo base_url();?>dekitting_pk_us/c_pic_shoot_us/getHistoryPics', 
            type: 'post',
            dataType: 'json',
            data:{'barcode':barcode,'condition':condition},
            success:function(data){
              if(data != 0){

              
                var historyPics = [];
                // $('#sortable').html("");
                // console.log('length:'+data.dekitted_pics.length+'');
                //console.log(data);
                for(var i=0;i<data.dekitted_pics.length;i++){
                  values = data.uri[i].split("/");
               
                  one = values[5].substring(1);

                  //console.log(one);//return false;
                  var picture = data.dekitted_pics[i];
                  var radio_btn = '<input type="radio" name="mpn_picture_history" id="mpn_picture_history" value="MPN_" pic_name="'+data.image_url[i]+'" title="MPN Picture">';                  
                  //console.log(picture);
                  // var img = '<img class="sort_img up-img zoom_01" id="'+data.uri[i]+'" name="" src="data:image;base64,'+data.cloudUrl[i]+'"/>';
                  var img = '<img class="sort_img up-img zoom_01" id="'+data.uri[i]+'" name="" src="data:image;base64,'+picture+'"/>';
                  historyPics.push('<li id="list_'+i+'" style="width: 105px; height: 125px; background: #eee; float: left; overflow: hidden; text-align: center; position: relative; padding: 3px;"><span class="tg-li"> <div class="thumb imgCl" style="display: block; border: 1px solid rgb(55, 152, 198);">'+img+'</div>'+radio_btn+'</span></li> ');
                   
                }

                $('#history_pics').html("");
                $('#history_pics').append(historyPics.join(""));
              }else{

              }
            }
          });

          $.ajax({
            url: '<?php echo base_url();?>dekitting_pk_us/c_pic_shoot_us/getBarcodePics', 
            type: 'post',
            dataType: 'json',
            data:{'barcode':barcode,'condition':condition},
            success:function(data){
              var dirPics = [];
              // $('#sortable').html("");
              // console.log('length:'+data.dekitted_pics.length+'');
              console.log(data);
              for(var i=0;i<data.dekitted_pics.length;i++){
                values = data.uri[i].split("/");
             
                one = values[4].substring(1);

                //console.log(one);//return false;
                var picture = data.dekitted_pics[i]; 
                // var img = '<img class="sort_img up-img zoom_01" id="'+data.uri[i]+'" name="" src="data:image;base64,'+data.cloudUrl[i]+'"/>';
                var img = '<img style="width: 225px; height: 180px;" class="sort_img up-img zoom_01" id="'+data.uri[i]+'" name="dekit_image[]" src="data:image;base64,'+picture+'"/>';
                dirPics.push('<li style="width: 230px; height: 220px; background: #eee!important; float: left; overflow: hidden; text-align: center; position: relative; padding: 3px; margin:5px;" id="'+values[4]+'"> <span class="tg-li"> <div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);  width:100%; height:100%; background: #eee!important; margin:5px;">'+img+' <input type="hidden" name="" value=""> <div class="text-center" style="width: 100px;"> <span class="thumb_delete" style="float: left;"><i title="Move Picture Order" style="padding: 3px;" class="fa fa-arrows" aria-hidden="true"></i></span> <span class="d_spn"><i title="Delete Picture" style="padding: 3px;" class="fa fa-trash specific_delete"></i></span> </div> </div> </span> </li> ');
              }

              $('#sortable').html("");
              $('#sortable').append(dirPics.join(""));
              // $('.zoom_01').elevateZoom();
              $('.zoom_01').elevateZoom({
                //zoomType: "inner",
                cursor: "crosshair",
                zoomWindowFadeIn: 600,
                zoomWindowFadeOut: 600,
                easing : true,
                scrollZoom : true
               });            
              $('.loader').hide();

               
    }
          });
        }else{
          $('#addPicsBox').hide();
          $('#barcode_prv').focus();
        }

        },
        error: function(jqXHR, textStatus, errorThrown){
           $(".loader").hide();
           // alert('Please Enter a Valid barcode number');
         }

      });

      var child_barcode = $('#barcode_prv').val();
      $.ajax({
        url: '<?php echo base_url();?>dekitting_pk_us/c_pic_shoot_us/getPicNote', 
        type: 'post',
        dataType: 'json',
        data : {'child_barcode':child_barcode},
        success:function(data){
          $('#pic_notes').val(data[0].PIC_NOTES);
        }
      });  
    }
});

/*===================================
=            dele master            =
===================================*/

  $(".del_master_all_dekit").click(function(){
    //var master_reorder = $('#sortable').sortable('toArray');
    if(confirm('Are you sure?')){
    var child_barcode = $('#barcode_prv').val();
    var it_condition = $('#condition_segs').val();
      // var it_condition = $('#it_condition').val();
        //alert(master_all);
        //return false;
        $('.loader').show();
      $.ajax({
        dataType: 'json',
        type: 'POST',        
        url:'<?php echo base_url(); ?>dekitting_pk_us/c_pic_shoot_us/delete_all_master',
        data: { 
                'child_barcode':child_barcode,
                'it_condition':it_condition              
      },
       success: function (data) {
        //alert(data);return false;
          if(data == true){
            reload();
              $('#upload_message').append('<div class="alert alert-success alert-dismissable" id="message"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> All Pictures deleted Successfully !!</div>');
              
              setTimeout(function(){$('#upload_message').html("");},1000);
              setTimeout(function(){$('#addPicsBox').hide();},2000);
              setTimeout(function(){$('#barcode_prv').focus();},1000);

              
              $('.loader').hide();
              $('#barcode_prv').val('');
              $('#singleObj').val('');
              $('#condition_segs').val('');
              $('#search_weight').val('');
              $('#search_bin').val('');
              $('#search_Remarks').val('');
 
          }else if(data == false){
            $('#upload_message').append('<div class="alert alert-danger alert-dismissable" id="message"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong>  Pictures Not deleted  !!</div>');
              $('#barcode_prv').val('');
              setTimeout(function(){$('#upload_message').html("");},1000);
              setTimeout(function(){$('#addPicsBox').hide();},2000);
              setTimeout(function(){$('#barcode_prv').focus();},1000);
            // alert('Error -  Pictures not deleted.');
            //window.location.reload();
          }
        }
        });  
    }else{
      $('#addPicsBox').hide();
      $('#barcode_prv').focus();
    }
   

  });

/*=====  End of dele master  ======*/


/*===============================
=            Reorder            =
===============================*/


/*============================================
=            Delete Specific images            =
============================================*/

  $(document).on('click','.specific_delete',function(){
    // alert('clicked');
     var specific_url = $(this).parents('.imgCls').find('img').attr('id');
     // alert(id);
    //return false;
    if(confirm('Are you sure?')){
      $('.loader').show();
        $.ajax({
          dataType: 'json',
          type: 'POST',        
          // url:'<?php echo base_url(); ?>item_pictures/c_item_pictures/specific_img_delete',
          url:'<?php echo base_url(); ?>dekitting_pk_us/c_pic_shoot_us/specific_img_delete',
          data: { 'specific_url' : specific_url              
        },
         success: function (data) {
          // alert(data);return false;
         
            if(data == true){
              reload();
              
              $('#upload_message').append('<div class="alert alert-success alert-dismissable" id="message"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Pictures deleted Successfully !!</div>');
              
              setTimeout(function(){$('#upload_message').html("");},1000);
              setTimeout(function(){$('#addPicsBox').hide();},2000);
              setTimeout(function(){$('#barcode_prv').focus();},1000);
              // alert('Item Picture has been deleted.');//return false;
              // window.location.reload();
              // loadRecords();
              $('#barcode_prv').val('');

              $('#singleObj').val('');
              $('#condition_segs').val('');
              $('#search_weight').val('');
              $('#search_bin').val('');
              $('#search_Remarks').val('');
               $('.loader').hide();
            }else if(data == false){
              $('#upload_message').append('<div class="alert alert-danger alert-dismissable" id="message"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Pictures Not deleted  !!</div>');
              $('#barcode_prv').val('');
              setTimeout(function(){$('#upload_message').html("");},1000);
              setTimeout(function(){$('#addPicsBox').hide();},2000);
              setTimeout(function(){$('#barcode_prv').focus();},1000);
              // alert('Error - Item Picture has been not deleted.');
              // window.location.reload();
            }
            // $('#barcode_prv').focus();
          }
          });    
      } 

  });

/*=====  End of Delete Specific images  ======*/

/*================================================
=            Delete All Specific images            =
================================================*/
$(document).on('click','#master_reorder_dekit',function () {
    var master_reorder = $('#sortable').sortable('toArray');

    // var master_barcode = '<?php //echo $this->uri->segment(4); ?>';
    var child_barcode = $('#barcode_prv').val();
    var condition = $('#condition_segs').val();
    //alert(upc+"_"+part_no+"_"+it_condition);return false;
    //alert(sortID);return false;
    $('.loader').show();
    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>dekitting_pk_us/c_pic_shoot_us/master_sorting_order',
      data: { 'master_reorder' : master_reorder,
              'child_barcode':child_barcode,
              'condition':condition             
    },
     success: function (data) {

        if(data == true){
          $('.loader').hide();
          $('#upload_message').append('<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Pictures Order Updated Successfully !!</div>');
              $('#barcode_prv').val('');
              $('#singleObj').val('');
              $('#condition_segs').val('');
              $('#search_weight').val('');
              $('#search_bin').val('');
              $('#search_Remarks').val('');
              setTimeout(function(){$('#upload_message').html("");},1000);
              setTimeout(function(){$('#addPicsBox').hide();},2000);
              setTimeout(function(){$('#barcode_prv').focus();},1000);



        }else if(data == false){
          $('.loader').hide();
          $('#upload_message').append('<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Pictures Order Not Updated !!</div>');
              $('#barcode_prv').val('');
              $('#singleObj').val('');
              $('#condition_segs').val('');
              $('#search_weight').val('');
              $('#search_bin').val('');
              $('#search_Remarks').val('');
              setTimeout(function(){$('#upload_message').html("");},1000);
              setTimeout(function(){$('#addPicsBox').hide();},2000);
              setTimeout(function(){$('#barcode_prv').focus();},1000);

        }

      }
      });  

});


/*=====  End of Reorder  ======*/

 function uploadDekitFormData(formData) {


    var barcode = $('#barcode_prv').val();
    var condition = $('#condition_segs').val();

        formData.append('barcode',barcode);
        formData.append('condition',condition);

        $('.loader').show();
        $.ajax({
          url: '<?php echo base_url(); ?>dekitting_pk_us/c_pic_shoot_us/img_upload',
          data: formData,
          type: 'POST',
          datatype : "json",
          processData: false,
          contentType: false,
          cache: false,
          success: function(data) {
            reload();

            // $('.loader').hide();
              $('#upload_message').append('<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Pictures Uploaded Successfully !!</div>');
              $('#barcode_prv').val('');
              $('#singleObj').val('');
              $('#condition_segs').val('');
              $('#search_weight').val('');
              $('#search_bin').val('');
              $('#search_Remarks').val('');
              setTimeout(function(){$('#upload_message').html("");},1000);
              setTimeout(function(){$('#addPicsBox').hide();},2000);
              setTimeout(function(){$('#barcode_prv').focus();},1000);
              $('.loader').hide();
              
              
          }
        });
  
     }

       /*=================================================================
  =            save and move images on click save button            =
  =================================================================*/
   $("#save_pics_master").click(function(){
    // var upc = $('#upc').val();
    // var part_no = $('#part_no').val();
    // var it_condition = $('#it_cond').val();
    // var item_id = $("#item_id").val();
    // var manifest_id = $("#manifest_id").val();

    var barcode = $('#barcode_prv').val();
    var condition = $('#condition_segs').val();
    var radio_btn = $('input[name=mpn_picture]:checked').val();
    var pic_name = $('input[name=mpn_picture]:checked').attr('pic_name');
    // console.log(radio_btn);
    // console.log(pic_name);return false;
    $(".loader").show();

    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>dekitting_pk_us/c_pic_shoot_us/save_pics_master',
      data: { 
              'barcode':barcode,
              'condition':condition,
              'radio_btn':radio_btn,
              'pic_name':pic_name         
    },
     success: function (data) {
      //alert(data);return false;
      $(".loader").hide();
        if(data == true){
          $(".loader").hide();
          reload();
          $('#pics_insertion_msg').append('<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Master Pictures has been added.</div>').delay(3000).queue(function() { $(this).remove(); });
              $('#barcode_prv').val('');
              $('#singleObj').val('');
              $('#condition_segs').val('');
              $('#search_weight').val('');
              $('#search_bin').val('');
              $('#search_Remarks').val('');
        // $('#barcode_prv').focus();
            setTimeout(function(){$('#addPicsBox').hide();},1000);
            setTimeout(function(){$('#barcode_prv').focus();},1000);          
          // alert('Master Pictures has been added.');
          // window.location.reload();
        }else if(data == false){
          $('#pics_insertion_msg').append('<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Error!</strong> Pictures not added.</div>').delay(3000).queue(function() { $(this).remove(); });
              $('#barcode_prv').val('');
              $('#singleObj').val('');
              $('#condition_segs').val('');
              $('#search_weight').val('');
              $('#search_bin').val('');
              $('#search_Remarks').val('');        // $('#barcode_prv').focus();
            setTimeout(function(){$('#addPicsBox').hide();},1000);
            setTimeout(function(){$('#barcode_prv').focus();},1000);          
          //alert('Error -  Pictures not added.');
          //window.location.reload();
        }
        $('#barcode_prv').val('');
        $('#addPicsBox').hide();
        $('#barcode_prv').focus();
      }
      });      
  });
  
  
  /*=====  End of save and move images on click save button  ======*/  


  /*=========================================
  =            save history pics            =
  =========================================*/
  
  $("#save_history_master").click(function(){
    // var upc = $('#upc').val();
    // var part_no = $('#part_no').val();
    // var it_condition = $('#it_cond').val();
    // var item_id = $("#item_id").val();
    // var manifest_id = $("#manifest_id").val();

    var barcode = $('#barcode_prv').val();
    var condition = $('#condition_segs').val();
    var radio_btn = $('input[name=mpn_picture_history]:checked').val();
    var pic_name = $('input[name=mpn_picture_history]:checked').attr('pic_name');    
    $(".loader").show();

    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>dekitting_pk_us/c_pic_shoot_us/save_history_master',
      data: { 
              'barcode':barcode,
              'condition':condition,
              'radio_btn':radio_btn,
              'pic_name':pic_name         
    },
     success: function (data) {
      //alert(data);return false;
      $(".loader").hide();
        if(data == true){
          reload();
          $('#pics_history_msg').append('<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Master Pictures has been added.</div>').delay(3000).queue(function() { $(this).remove(); });
              $('#barcode_prv').val('');
              $('#singleObj').val('');
              $('#condition_segs').val('');
              $('#search_weight').val('');
              $('#search_bin').val('');
              $('#search_Remarks').val('');
        // $('#barcode_prv').focus();
            setTimeout(function(){$('#addPicsBox').hide();},2000);
            setTimeout(function(){$('#barcode_prv').focus();},2000);          
          // alert('Master Pictures has been added.');
          // window.location.reload();
        }else if(data == false){
          $('#pics_history_msg').append('<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Error!</strong> Pictures not added.</div>').delay(3000).queue(function() { $(this).remove(); });
              $('#barcode_prv').val('');
              $('#singleObj').val('');
              $('#condition_segs').val('');
              $('#search_weight').val('');
              $('#search_bin').val('');
              $('#search_Remarks').val('');        // $('#barcode_prv').focus();
            setTimeout(function(){$('#addPicsBox').hide();},1000);
            setTimeout(function(){$('#barcode_prv').focus();},1000);          
          //alert('Error -  Pictures not added.');
          //window.location.reload();
        }
        $('#barcode_prv').val('');
        $('#addPicsBox').hide();
        $('#barcode_prv').focus();
      }
      });      
  });

  /*=====  End of save history pics  ======*/
  

  /*=====================================
  =            textarea save            =
  =====================================*/
  
  $('#saveTextArea').on('click',function(){
  $('.loader').show();
    var notes = $('#pic_notes').val();
    var child_barcode = $('#barcode_prv').val();
    var condition = $('#condition_segs').val();

    $.ajax({
        dataType: 'json',
        type: 'POST',        
        url:'<?php echo base_url(); ?>dekitting_pk_us/c_pic_shoot_us/saveNotes',
        data: { 
                'notes':notes,
                'child_barcode':child_barcode,
                'condition':condition
              },
        success: function (data) {
          $('.loader').hide();
          // console.log(data);
          
          if(data == true){
            // $('#saveNoteMessage').append();
            $('#saveNoteMessage').append('<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Picture Notes Updated Successfully !!</div>').delay(2000).queue(function() { $(this).remove(); });
              $('#barcode_prv').val('');
              $('#singleObj').val('');
              $('#condition_segs').val('');
              $('#search_weight').val('');
              $('#search_bin').val('');
              $('#search_Remarks').val('');
            setTimeout(function(){$('#addPicsBox').hide();},1000);
              setTimeout(function(){$('#barcode_prv').focus();},1000);
            // alert('Picture note saved !!');
            // $('#barcode_prv').focus();
             // window.location.reload();
          }else{
            $('#saveNoteMessage').append('<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Error!</strong> Picture Notes Not Updated !!</div>').delay(2000).queue(function() { $(this).remove(); });
              $('#barcode_prv').val('');
              $('#singleObj').val('');
              $('#condition_segs').val('');
              $('#search_weight').val('');
              $('#search_bin').val('');
              $('#search_Remarks').val('');
            setTimeout(function(){$('#addPicsBox').hide();},1000);
            setTimeout(function(){$('#barcode_prv').focus();},1000);
            // $('#barcode_prv').focus();
          }
        }

      });
});
  
  /*=====  End of textarea save  ======*/
  
</script>
