<?php $this->load->view('template/header');
ini_set('memory_limit', '-1');
?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Pictures
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add Pictures</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
		
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
                    <div class="col-sm-12">
                      <label>Picture Notes:</label>
                      <div class="form-group">
                      
                        <textarea name="pic_notes" id="pic_notes" value="" cols="30" rows="4" class="form-control"></textarea>
                      </div>
                    </div>        
                    <div class="col-sm-2">
                      <input type="button" name="saveTextArea" id="saveTextArea" class="btn btn-sm btn-primary" value="Save Notes" />
                    </div>
                      
                  </div>
                

                <div class="col-sm-12">


           <!-- <div class="col-sm-12 p-b">
                      <label for="">Master Pictures:</label>

                        <div id="" class="col-sm-12 b-full">
                                         
                          <div id="" class="col-sm-12 p-t"> 
                           <ul id="" style="height: 140px !important; list-style: none; white-space: nowrap; position: relative; padding: 0; margin: 0; vertical-align: top; left: 0; width: 100%;"> 
         
                                                
                          </div>                    
                            </span> -->


                          <!-- </ul>
                            <div class="col-sm-12">
                              <div class="form-group">
                                <input class="btn btn-sm btn-primary save_pics" title="Save" type="button" id="save_pics_master" name="save_pics_master" value="Save">
                              </div>
                              <div id="pics_insertion_msg">
                                
                              </div> -->
                              <!--</form>-->
                          <!--   </div>

                          </div>
                        </div>
                      </div> 
 -->                      <!-- Master Picture section Live_folder end--> 

                    <!-- <div class="col-sm-12 ">  -->
                    

                    <div id="drop-img-area" class="col-sm-12 p-b">
                      <label for="">Upload Pictures:</label>
                      <div id="" class="col-sm-12 b-full">
                      <div class="col-sm-2">                   
                        <div  class="commoncss">
                          <h4>Drag / Upload image!</h4>
                            <div class="uploadimg">
                             <form id="frmupload" enctype="multipart/form-data">
                                <input type="file" multiple="multiple" name="dekit_image[]" id="dekit_image" style="display:none"/>
                                <!-- <input type="hidden" style="display:none;" class="form-control" id="upc~mpn" name="upc~mpn" value=""> -->
                             <!--    <input type="hidden" style="display:none;" class="form-control" id="it_condition" name="it_condition" value=""> -->
                                <span id="btnupload_img" style=" font-size: 2.5em; margin-top: 0.7em; cursor: pointer;" class="fa fa-cloud-upload"></span>

                                </form>
                                </div>
                            </div>
                        </div>
                <div id="" class="col-sm-10 p-t"> 
                 <ul id="sortable" style="height: 140px !important;">
                  <?php 
                      $query = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 2");
                      $master_qry = $query->result_array();
                      $master_path = $master_qry[0]['MASTER_PATH'];
                      // var_dump($master_path);

                      $master_barcode =  $this->uri->segment(4); 
                      $child_barcode =  $this->uri->segment(5); 
                      $it_condition =  $this->uri->segment(6); 
                  ?>


                  <?php
                  if(is_numeric(@$it_condition)){
                      if(@$it_condition == 3000){
                        @$it_condition = 'Used';
                      }elseif(@$it_condition == 1000){
                        @$it_condition = 'New'; 
                      }elseif(@$it_condition == 1500){
                        @$it_condition = 'New Other'; 
                      }elseif(@$it_condition == 2000){
                          @$it_condition = 'Manufacturer refurbished';
                      }elseif(@$it_condition == 2500){
                        @$it_condition = 'Seller refurbished'; 
                      }elseif(@$it_condition == 7000){
                        @$it_condition = 'For parts or not working'; 
                      }else{
                          @$it_condition = 'Used'; 
                      }
                  }else{// end main if
                    $it_condition  = ucfirst(@$it_condition);
                  }
                  // var_dump($it_condition);
                  // // $mpn = str_replace('/', '_', @$row['MFG_PART_NO']);
                  // // $dir = "D:/item_pictures/master_pictures/".@$row['UPC']."~".@$mpn."/".@$it_condition;
                  // // $master_path = $data['path_query'][0]['MASTER_PATH'];
                  $dir = $master_path.$child_barcode.'/'.$it_condition;
                  // var_dump($dir);
                  // var_dump(is_dir($dir));exit;
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
                ?>
                                
                      <?php
                       // $master_path = $data['path_query'][0]['MASTER_PATH']; 
                       $url = $master_path.$child_barcode.'/'.@$it_condition.'/'.$parts['0'].'.'.$extension;
                       // var_dump($url);
                       $url = preg_replace("/[\r\n]*/","",$url); 
                      ?>
                      <li id="<?php echo $parts['0'].'.'.$extension;?>">
                        <span class="tg-li">
                          <div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);">
                                                          
                      <?php
                       // $url = '\\\\WIZMEN-PC\\item_pictures\\master_pictures\\'.@$row['UPC'].'~'.$mpn.'\\'.@$it_condition.'\\'.$parts['0'].'.'.$extension;
                        // array_push($url_arr, $url);
                        // $master_path = $data['path_query'][0]['MASTER_PATH']; 
                        // $del_master_all =  $master_path.@$row['UPC'].'~'.$mpn;

                        $img = file_get_contents($url);
                        $img =base64_encode($img);

                        echo '<img class="sort_img up-img zoom_01" id="'.$url.'" name="" src="data:image;base64,'.$img.'"/>';?>
                                <input type="hidden" name="img_<?php echo $i ?>" value="<?php echo $url; ?>">
<!--                                          <div class="img_overlay">
                                <span><i class="fa fa-trash delete_master"></i></span> 
                              </div> -->
                            <div class="text-center" style="width: 100px;">
                              <span class="thumb_delete" style="float: left;"><i title="Move Picture Order" style="padding: 3px;" class="fa fa-arrows" aria-hidden="true"></i></span>
                              <span class="d_spn"><i title="Delete Picture" style="padding: 3px;" class="fa fa-trash delete_specific"></i></span> 
                            </div>                                          
                            
                          </div>                    
                        </span>                        
                      </li>

                              <?php
                          }
                        }

                      }?>

                         <?php closedir($dh);

                    }
                  }//else{
                  //   var_dump('from else');
                  //}


                ?>
                       
                      

                        <div id="" class="col-sm-10 p-t"> 
                          <!-- <ul id="sortable" style="height: 140px !important;">
                          </ul> -->
                        </div>

                        <div class="col-sm-12 " style="padding-left:0px !important;padding-right:0px !important;">

                          <div class="col-sm-8">
                              <div class="alert success pull-right" style="font-size:16px;color:green;font-weight:600;"></div>
                            </div>
                            <div class="col-sm-4">
                              <div class="form-group pull-right">
                                <input id="master_reorder_dekit" class="btn btn-sm btn-primary" title="Sort or Re-arrange Picture Order" type="button" name="update_order" value="Update Order">
                                <span><i id="<?php if(@$del_master_all){echo $del_master_all;}?>" title="Delete All Pictures" class="btn btn-sm btn-danger del_master_all_dekit">Delete All</i></span>
                              </div>
                              
                            <!--</form>-->
                          </div>
                        </div>

                      </div>
                  
                  

                     </ul>
                    </div> 
                    <!-- </div> -->

               <!--    <div class="col-sm-12">
                  <div class="form-group">
                    <a title="Update Specific Pictures" class="btn btn-sm btn-primary" href="<?php// echo base_url('item_pictures/c_item_pictures/item_pic_spec/'.@$data['search_query'][0]['IT_BARCODE']);?>" target="_blank">Update Specific Pictures</a>
                  </div>
                </div>  -->
                </div>

              </div>

            </div>            
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
      <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="ajax loader" style="width: 100px; height: 100px;">
    </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
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

        var cond = '';
        if(data[0].CONDITION_ID == 1000){
          cond = 'New';
        }
        if(data[0].CONDITION_ID == 3000){
          cond = 'Used';
        }
        if(data[0].CONDITION_ID == 1500){
          cond = 'New Other';
        }
        if(data[0].CONDITION_ID == 2000){
          cond = 'Manufacturer refurbished';
        }
        if(data[0].CONDITION_ID == 2500){
          cond = 'Seller refurbished';
        }
        if(data[0].CONDITION_ID == 7000){
          cond = 'For parts or not working';
        }
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