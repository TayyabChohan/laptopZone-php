<?php $this->load->view('template/header');
ini_set('memory_limit', '-1');
?>


<style >
  
  .north {
transform:rotate(0deg);
-ms-transform:rotate(0deg); /* IE 9 */
-webkit-transform:rotate(0deg); /* Safari and Chrome */
}
.west {
transform:rotate(90deg);
-ms-transform:rotate(90deg); /* IE 9 */
-webkit-transform:rotate(90deg); /* Safari and Chrome */
}
.south {
transform:rotate(180deg);
-ms-transform:rotate(180deg); /* IE 9 */
-webkit-transform:rotate(180deg); /* Safari and Chrome */
    
}
.east {
transform:rotate(270deg);
-ms-transform:rotate(270deg); /* IE 9 */
-webkit-transform:rotate(270deg); /* Safari and Chrome */
}

</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Show All  Pictures
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add Pictures</li>
      </ol>
    </section>
      <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Add Pictures</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <div class="row">
              <div class="col-sm-12">
                <div class="col-sm-12">
                    <div class="col-sm-4">
                      <div class="form-group">
                      <label>ItemBarcode:</label>
                        <input type="text" class="form-control" name="child_barcode" id="child_barcode" value="" readonly>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                      <label>Condition:</label>
                        <input type="text" class="form-control" name="condition" id="condition" value="" readonly>
                      </div>
                    </div>
                  </div>
                <div class="col-sm-12">
                  <div id="drop-img-area" class="col-sm-12 p-b">
                    <div id="" class="col-sm-12 b-full">
                      <div id="" class="col-sm-12 docs-galley" > 
                        <ul id="sortable" class="docs-pictures clearfix" style="height: auto !important; width: 100% !important;" >
                          <?php 
                              $query = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 2");
                              $master_qry = $query->result_array();
                              $master_path = $master_qry[0]['MASTER_PATH'];
                              // var_dump($master_path);

                              $master_barcode =  $this->uri->segment(4); 
                              $child_barcode =  $this->uri->segment(5); 
                              $qry = $this->db->query("SELECT FOLDER_NAME FROM LZ_DEKIT_US_DT WHERE BARCODE_PRV_NO = $child_barcode");
                              $qry = $qry->result_array();    

                              $child_barcode = $qry[0]["FOLDER_NAME"];
                              
                              $it_condition =  $this->uri->segment(6); 
                              $dir = $master_path.$child_barcode;
                                //var_dump($dir); exit
                                //var_dump(is_dir($dir));exit;
                                //$dir = "D:\wamp\www\laptopzone\assets\item_pic";
                                // Open a directory, and read its contents
                                $dir = preg_replace("/[\r\n]*/","",$dir);
                                if (is_dir($dir)){
                                  if ($dh = opendir($dir)){
                                    $i=1;
                                    // $url_arr = [];
                                      while (($file = readdir($dh)) !== false){
                                        $parts = explode(".", $file);
                                        if (is_array($parts) && count($parts) > 1){
                                          $extension = end($parts);
                                          if(!empty($extension)){
                                            //var_dump($parts['0']); exit;
                                            // $master_path = $data['path_query'][0]['MASTER_PATH']; 
                                            $url = $master_path.$child_barcode.'/'.$parts['0'].'.'.$extension;
                                            // var_dump($url);
                                          $url = preg_replace("/[\r\n]*/","",$url); 
                                        ?>
                                        <li id="<?php echo $parts['0'].'.'.$extension;?>" <?php if ($i==1 || $i==5 || $i==10) { ?> style="width: 225px; height: 220px; margin-left: 10px; margin-bottom: 10px;"> <?php }?> 
                                          <span class="tg-li">
                                            <div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198); width: 215px; height: 180px;     margin-left: 1px; margin-top: 4px;">
                                                                            
                                              <?php
                                               // $url = '\\\\WIZMEN-PC\\item_pictures\\master_pictures\\'.@$row['UPC'].'~'.$mpn.'\\'.@$it_condition.'\\'.$parts['0'].'.'.$extension;
                                                // array_push($url_arr, $url);
                                                // $master_path = $data['path_query'][0]['MASTER_PATH']; 
                                                // $del_master_all =  $master_path.@$row['UPC'].'~'.$mpn;
                                                $img = file_get_contents($url);
                                                $img =base64_encode($img);
                                                echo '<img  class="sort_img up-img zoom_01 north" id="'.$url.'" name="" src="data:image;base64,'.$img.'"/>';?>
                                                    <input type="hidden"  name="img_<?php echo $i ?>" id="" value="<?php echo $url; ?>">
                                                    <div  style="width: auto;">
                                                      <span class="thumb_delete" style="float: left;"><i title="Move Picture Order"  class="fa fa-arrows" aria-hidden="true"></i></span>
                                                      <span class="d_spn" style="float: left;"><i title="Delete Picture"  class="fa fa-trash delete_specific"></i></span> 
                                                      <span class="d_spn" style="float: left;"><i title="Delete Picture"  class="fa fa-repeat rot_my_pic"></i></span> 
                                                      <span class="d_spn" style="float: left;"><i title="Save Image"  class="fa fa-check save_img"></i></span> 
                                                      
                                                    </div>
                                              </div>                    
                                            </span>                        
                                        </li>
                                      <?php
                                      }
                                    }
                                  }
                                   closedir($dh);
                                }
                              }
                            ?>  
                      </div>
                    </ul>
                  </div> 
                </div>
              </div>
            </div>  <!-- /.box-body -->
          </div> <!-- /.box -->
        </div><!-- /.col -->
      </div>
      <div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
      <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="ajax loader" style="width: 100px; height: 100px;">
    </div><!-- /.row -->
    </section><!-- /.content -->
  </div>	
<!-- End Listing Form Data -->
<?php $this->load->view('template/footer');?>
<script>
/*=============================================
=            Section comment block            =
=============================================*/
$(document).ready(function(){
  var master_barcode = '<?php echo $this->uri->segment(4); ?>';
  var child_barcode = '<?php echo $this->uri->segment(5); ?>';
  $('#child_barcode').val(child_barcode);

  $("#dekit_image").prop('disabled',true);

  $.ajax({
      url: '<?php echo base_url();?>dekitting_pk_us/c_pic_shoot_us/getPrvDetails', 
      type: 'post',
      dataType: 'json',
      data : {'child_barcode':child_barcode},
      success:function(data){ 

        var cond = data[0].COND_NAME;
        // if(data[0].CONDITION_ID == 1000){
        //   cond = 'New';
        // }
        // if(data[0].CONDITION_ID == 3000){
        //   cond = 'Used';
        // }
        // if(data[0].CONDITION_ID == 1500){
        //   cond = 'New Other';
        // }
        // if(data[0].CONDITION_ID == 2000){
        //   cond = 'Manufacturer refurbished';
        // }
        // if(data[0].CONDITION_ID == 2500){
        //   cond = 'Seller refurbished';
        // }
        // if(data[0].CONDITION_ID == 7000){
        //   cond = 'For parts or not working';
        // }
        $('#condition').val(cond);
        $("#dekit_image").prop('disabled',false);
      }  
  });

  // console.log(master_barcode,child_barcode);
    $.ajax({
      url: '<?php echo base_url();?>dekitting_pk_us/c_pic_shoot_us/getPicNote', 
      type: 'post',
      dataType: 'json',
      data : {'child_barcode':child_barcode},
      success:function(data){
        $('#pic_notes').val(data[0].PIC_NOTES);
      }
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
});

/*=====  End of Section comment block  ======*/

/*====================================
=            upload image            =
====================================*/
// $('#dekit_image').on('click',function(){
//   var files = [];

//   files.push($('#dekit_image').val());
//   console.log($('#dekit_image').val());

// });


/*=====  End of upload image  ======*/

/*===================================
=            dele master            =
===================================*/

  $(".del_master_all_dekit").click(function(){
    //var master_reorder = $('#sortable').sortable('toArray');
    if(confirm('Are you sure?')){
    var child_barcode = '<?php echo $this->uri->segment(5); ?>';
    var it_condition = '<?php echo $this->uri->segment(6); ?>';
      // var it_condition = $('#it_condition').val();
        //alert(master_all);
        //return false;
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
            alert('Master Pictures has been deleted.');
            window.location.reload();
          }else if(data == false){
            alert('Error -  Pictures not deleted.');
            //window.location.reload();
          }
        }
        });  
    }else{
      return false;
    }
   

  });

/*=====  End of dele master  ======*/



/*===============================
=            Reorder            =
===============================*/
$("#master_reorder_dekit").click(function () {
    var master_reorder = $('#sortable').sortable('toArray');

    // var master_barcode = '<?php //echo $this->uri->segment(4); ?>';
    var child_barcode = '<?php echo $this->uri->segment(5); ?>';
    var condition = '<?php echo $this->uri->segment(6); ?>';
    //alert(upc+"_"+part_no+"_"+it_condition);return false;
    //alert(sortID);return false;

    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>dekitting_pk_us/c_pic_shoot_us/master_sorting_order',
      data: { 'master_reorder' : master_reorder,
              'child_barcode':child_barcode,
              'condition':condition             
    },
     success: function (data) {
      //alert(data);return false;
        if(data == true){
          alert('Pictures Order is updated.');
          window.location.reload();
        }else if(data == false){
          alert('Error - Pictures Order is not updated.');
          //window.location.reload();
        }
      }
      });  

});


/*=====  End of Reorder  ======*/






/*==================================
=            Image zoom            =
Doc Url: http://www.elevateweb.co.uk/image-zoom/examples
https://github.com/igorlino/elevatezoom-plus.git
==================================*/
  $('.zoom_01').elevateZoom({
    //zoomType: "inner",
    cursor: "crosshair",
    zoomWindowFadeIn: 600,
    zoomWindowFadeOut: 600,
    easing : true,
    scrollZoom : true
   });

/*=====  End of Image zoom  ======*/


 function uploadDekitFormData(formData) {

    // var postData = new FormData();
    // var barcode = $('#child_barcode').val();
    // // alert(barcode);return false;
    // var condition = $('#condition').val();
    var barcode = document.getElementById("child_barcode").value;
    var condition = document.getElementById("condition").value;
    // alert(child_barcode);
    // var lz_item_id = document.getElementById("item_id").value;
    // var lz_manifest_id = document.getElementById("manifest_id").value;
    // var item_id = null;
    // var manifest_id = null;


        // var upc_mpn = document.getElementById("upc~mpn").value;
        // var it_condition = document.getElementById("it_cond").value;
        // //alert(it_condition);return false; 
        formData.append('barcode',barcode);
        formData.append('condition',condition);
        // formData.append('lz_item_id',lz_item_id);
        // formData.append('lz_manifest_id',lz_manifest_id);
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
            $('.loader').hide();
              alert('Success: Item Pictures inserted');
              window.location.reload();
          }
        });
    //   formData.append('pic_item_id',item_id);
    // formData.append('pic_manifest_id',manifest_id);
    // $.ajax({
    //   url: '<?php// echo base_url(); ?>image_upload/image_upload/do_upload',
    //   data: formData,
    //   type: 'POST',
    //   datatype : "json",
    //   processData: false,
    //   contentType: false,
    //   cache: false,
    //   success: function(data) {
    //     window.location.reload();
    //   }
    // });
     }






  /*=================================================================
  =            save and move images on click save button            =
  =================================================================*/
   $("#save_pics_master").click(function(){
    var upc = $('#upc').val();
    var part_no = $('#part_no').val();
    var it_condition = $('#it_cond').val();
    var item_id = $("#item_id").val();
    var manifest_id = $("#manifest_id").val();
   // var n = $("#sortable li").length;
    //var pic_name = $('#sortable li').attr('id');
    // alert(n);
    // alert(pic);return false;
    // var pic_name = [];

    // var i = 1;
    // for(var i=1; i<=n; i++){
    //   pic_name.push($('#sortable li').attr('id'));
      
    // }    
    
    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>item_pictures/c_item_pictures/save_pics_master',
      data: { 
              'upc':upc,
              'part_no':part_no,
              'it_condition':it_condition,
              'item_id': item_id,
              'manifest_id' : manifest_id         
    },
     success: function (data) {
      //alert(data);return false;
        if(data == true){
          $('#pics_insertion_msg').append('<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Master Pictures has been added.</div>').delay(3000).queue(function() { $(this).remove(); });
            setTimeout(function(){location.reload();},3000);          
          // alert('Master Pictures has been added.');
          // window.location.reload();
        }else if(data == false){
          $('#pics_insertion_msg').append('<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Error!</strong> Pictures not added.</div>').delay(3000).queue(function() { $(this).remove(); });
            setTimeout(function(){location.reload();},3000);          
          //alert('Error -  Pictures not added.');
          //window.location.reload();
        }
      }
      });      
  });
  
  
  /*=====  End of save and move images on click save button  ======*/  

$('#saveTextArea').on('click',function(){
  $('.loader').show();
    var notes = $('#pic_notes').val();
    var child_barcode = '<?php echo $this->uri->segment(5); ?>';
    var condition = '<?php echo $this->uri->segment(6); ?>';

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
          console.log(data);
          
          if(data == true){
            alert('Picture note saved !!');
             window.location.reload();
          }else{
            alert('Picture note not Saved !');
          }
        }

      });
});
</script>