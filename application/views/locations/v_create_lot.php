<?php $this->load->view("template/header.php"); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Create Lot
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Create Lot</li>
      </ol>
    </section>
    
    <!-- Main content -->
  <section class="content">
      <div class="row"><!-- row 1 <div> -->
        <div class="col-sm-12"> <!-- colsm 1 <div> -->
          <div class="box"> <!-- box 1 <div> -->
            <div class="box-header">
              <h3 class="box-title">Create Lot Form</h3>
            </div>
            <!-- /.box-header -->
          <div class="box-body">   <!-- box body 1 <div> -->        
            
              <div class="col-sm-2">
                <h4><span class="label label-default">Search Barcode:</span></h4>                 
                  <div class="input-group ">                      
                    <input type="text" class="form-control ser_barcode " id="ser_barcode" name="ser_barcode" placeholder="Search Barcode ">                     
                      <div class="input-group-btn">
                      <button class="btn btn-info " id="click_ser_barcode" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                      </div>
                  </div>                  
              </div>
              <div class="col-sm-4">
                <h4><span class="label label-default">Enter Title:</span></h4>                 
                  <div class="form-group ">                      
                    <input type="text" class="form-control  " id="ent_title" name="ent_title" placeholder="Enter Title">                     
                      <!-- <div class="form-group-btn">
                      <button class="btn btn-info " id="click_ser_barcode" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                      </div> -->
                  </div>                  
              </div>
              <!-- <div class="col-sm-2">
                <h4><span class="label label-default">Enter Mpn:</span></h4>                 
                  <div class="form-group ">                      
                    <input type="text" class="form-control  " id="ent_mpn" name="ent_mpn" placeholder="Enter Mpn">                     
                    
                  </div>                  
              </div> -->
              <!-- <div class="col-sm-2">
                <h4><span class="label label-default">Enter Upc:</span></h4>                 
                  <div class="form-group ">                      
                    <input type="number" class="form-control  " id="ent_upc" name="ent_upc" placeholder="Enter Upc">                     
                      
                  </div>                  
              </div> -->
              <div class="col-sm-2">
                <h4><span class="label label-default">Enter Category:</span></h4>                 
                  <div class="form-group ">                      
                    <input type="number" class="form-control  " id="ent_cat_id" name="ent_cat_id" placeholder="Enter Category Id">                     
                      <!-- <div class="form-group-btn">
                      <button class="btn btn-info " id="click_ser_barcode" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                      </div> -->
                  </div>                  
              </div>
              <!-- <div class="col-sm-3">
                <h4><span class="label label-default">Enter Brand:</span></h4>                 
                  <div class="form-group ">                      
                    <input type="Text" class="form-control  " id="ent_brnd" name="ent_brnd" placeholder="Enter Brand">                     
                      
                  </div>                  
              </div> -->
              <div class="col-sm-3">                                
                  <div class="form-group ">                      
                   <h4><span class="label label-default">Enter Condition:</span></h4> 
                    <select name="condi_id" id = "condi_id" class="form-control selectpicker" required="required" data-live-search="true">
                      <option value=''>Select Condition </option>
                      <?php      
                          foreach ($data['cond_id'] as $stat){
                              ?>
                              <option value="<?php echo $stat['COND_NAME']; ?>" <?php //if($this->session->userdata('category_id') == $cat['CATEGORY_ID']){echo "selected";}?>> <?php echo $stat['COND_NAME']; ?> </option>
                              <?php
                             } 
                      
                    ?>  
                                    
                    </select> 

                  </div>                  
              </div>
              
              <div class="col-sm-2">
                <h4><span class="label label-default">Enter Mpn:</span></h4>                 
                  <div class="form-group ">                      
                    <input type="text" class="form-control  " id="enter_mp" name="enter_mp" placeholder="Enter Mpn">                     
                      <!-- <div class="form-group-btn">
                      <button class="btn btn-info " id="click_ser_barcode" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                      </div> -->
                  </div>                  
              </div>

              <div class="col-sm-2">
                <h4><span class="label label-default">Enter Manufacture:</span></h4>                 
                  <div class="form-group ">                      
                    <input type="text" class="form-control  " id="enter_manu" name="enter_manu" placeholder="Enter Manufacture">                     
                      <!-- <div class="form-group-btn">
                      <button class="btn btn-info " id="click_ser_barcode" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                      </div> -->
                  </div>                  
              </div>
              <div class="col-sm-2">
                <h4><span class="label label-default">Enter Bin:</span></h4>                 
                  <div class="form-group ">                      
                    <input type="text" class="form-control  " id="ent_bin" name="ent_bin" placeholder="Enter Bin">                     
                      <!-- <div class="form-group-btn">
                      <button class="btn btn-info " id="click_ser_barcode" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                      </div> -->
                  </div>                  
              </div>
              <div class="col-sm-2 p-t-26">
                <h4><span class="label label-default"></span></h4>                 
                  <div class="form-group ">                      
                    <input type="button" class="form-control btn btn-primary  " id="save_lot" name="save_lot" value = "Save Lot" placeholder="Enter Bin">                     
                      <!-- <div class="form-group-btn">
                      <button class="btn btn-info " id="click_ser_barcode" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                      </div> -->
                  </div>                  
              </div> 
              <div class="col-sm-1 p-t-26 float-right">
                <h4><span class="label label-default"></span></h4>                 
                  <div class="form-group ">                      
                    <input type="button" class="form-control btn btn-success  " id="auto_fill" name="auto_fill" value = "Auto Fill">                     
                     
                  </div>                  
              </div>
            
          </div><!-- box body 1 </div> -->  
        </div> <!-- box 1 </div> -->        
      </div><!-- colsm 1 </div> -->
    </div><!-- row 1 <div> -->


      <div class="row"><!-- row 2 <div> -->
        <div class="col-sm-12"> <!-- colsm 2 <div> -->
          <div class="box"> <!-- box 2 <div> -->
            <div class="box-header">
              <h3 class="box-title">Barcode Details</h3>
            </div>
            <!-- /.box-header -->
          <div class="box-body">   <!-- box body 2 <div> -->        
            <table id = "getbarcode" class="table table-responsive table-striped table-bordered table-hover" > 

              <thead> 
              <th>Sr No.</th>
              <th>Barcode</th> 
              <th>Item Description</th>
              <th>MPN</th>
              <th>UPC</th>
              <th>BRAND</th>
              <th>CONDITION</th>
              <th>CATEGORY</th>
              <th>Cost</th>
              
              </thead>

            <tbody id ="tbody_getbarcode" >            

            </tbody>

          </table>
                          
          </div><!-- box body 2 </div> -->  
        </div> <!-- box 2 </div> -->        
      </div><!-- colsm 2 </div> -->
    </div><!-- row 2 <div> -->
      <div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
      <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="ajax loader" style="width: 100px; height: 100px;">
    </div>
  </section>
  
    <!-- /.content -->
  </div>  


<?php $this->load->view("template/footer.php"); ?>
<script type="text/javascript" src="<?php echo base_url('assets/dist/js/jquery.scannerdetection.js'); ?>"></script>

<script type="text/javascript">

   $(document).on('click','#auto_fill',function(){
      $(".loader").show();             
    var item_id =[];

    var count_table_rows= $("body #getbarcode tr").length;
    var count_rows = count_table_rows+1;
    if(count_rows <=2){
      alert('Please Search Any Barcode');
      return false;
    }
    var tableId= "getbarcode";
    var tdbk = document.getElementById(tableId);

    for (var i = 0; i < count_rows; i++)
          {
            
            $(tdbk.rows[i]).find(".item_id").each(function() {
            
              item_id.push($(this).val());
            
            });                                 
          }

         

          console.log(item_id);

      
      b = item_id.allValuesSame(); 

      if(b == true){
        

        var get_item_id = item_id[0];

        var url='<?php echo base_url() ?>locations/c_create_lot/get_bar_item_id';
      $.ajax({    
          type: 'POST',
          url:url,
          data: {
            'get_item_id': get_item_id            
          }, 
          dataType: 'json',
          success: function (data){ 
          $(".loader").hide();            
              if(data.getbar_query == true){
                $(".loader").hide(); 
                                
                 $('#ent_title').val(data['bar_query'][0].TITLE);
                 $('#enter_mp').val(data['bar_query'][0].MPN);

                 $('#condi_id').val(data['bar_query'][0].CONDIOTION);
                 //$('#condi_id').refresh();
                 $('#condi_id').selectpicker('refresh');

                 
                 $('#ent_cat_id').val(data['bar_query'][0].CATEGORY);
                 $('#enter_manu').val(data['bar_query'][0].BRAND);
                }else{
                alert('Error');
                return false;
              
             }
            
           }
      });


      }else if(b == false){
        $(".loader").hide(); 
        $('#ent_title').val('');
        $('#enter_mp').val('');
        $('#condi_id').val('');
        $('#condi_id').val('');
         $('#condi_id').selectpicker('refresh');
        $('#enter_manu').val('');
                 
        $('#ent_cat_id').val('');
        alert('All Items Are Not Same');
      }
      


    });

   Array.prototype.allValuesSame = function() {

    for(var i = 1; i < this.length; i++)
    {
        if(this[i] !== this[0])
            return false;
    }

    return true;
}



   $(document).on('click','#save_lot',function(){
    $('.loader').show();
        
    var bar_no =[];
    var cost_pric =[];
    var item_id =[];
    //var ent_brnd =$('#ent_brnd').val();
    //var ent_mpn =$('#ent_mpn').val();
    var ent_title =$('#ent_title').val();    
    //var ent_upc =$('#ent_upc').val();    
    var ent_cat_id =$('#ent_cat_id').val();
    var condi_id =$('#condi_id').val();
    var enter_mp =$('#enter_mp').val();
    var enter_manu =$('#enter_manu').val();

    

    var count_table_rows= $("body #getbarcode tr").length;
    var count_rows = count_table_rows+1;
    if(count_rows <=2){
       $(".loader").hide(); 
      alert('Please Search Any Barcode');
      return false;
    }
    var tableId= "getbarcode";
    var tdbk = document.getElementById(tableId);

    if(ent_title == ''){
       $(".loader").hide(); 
      alert('Title Is Empty');
      return false;
    } 
    if(condi_id == ''){
       $(".loader").hide(); 
      alert('Condition Is Empty');
      return false;
    }
    if(ent_cat_id == ''){
       $(".loader").hide(); 
      alert('Category Id Is Empty');
      return false;
    }
    if(enter_manu == ''){
       $(".loader").hide(); 
      alert('manufacture si empty'); return false; }

    for (var i = 0; i < count_rows; i++)
          {
            //compName.push($(tdbk.rows[arr[i]].("#ct_kit_mpn_id_"+(i+1))).val());
            $(tdbk.rows[i]).find(".bar_no").each(function() {
              if($(this).val() != ""){
              bar_no.push($(this).val());
            }
            }); 
            $(tdbk.rows[i]).find(".cost_pric").each(function() {
            
              cost_pric.push($(this).val());
            
            });
            $(tdbk.rows[i]).find(".item_id").each(function() {
            
              item_id.push($(this).val());
            
            });                                 
          }

          //console.log(bar_no,item_id,cost_pric);
          
      var url='<?php echo base_url() ?>locations/c_create_lot/Save_lot';
      $.ajax({    
          type: 'POST',
          url:url,
          data: {
            'bar_no': bar_no,
            'item_id': item_id,
            'cost_pric': cost_pric,
            //'ent_brnd': ent_brnd,
            //'ent_mpn': ent_mpn,
            'ent_title': ent_title,
            //'ent_upc': ent_upc,
            'condi_id': condi_id,
            'ent_cat_id': ent_cat_id,
            'enter_mp': enter_mp,
            'enter_manu': enter_manu
            
          }, 
          dataType: 'json',
          success: function (data){
          $(".loader").hide();           
              if(data == true){
                                
                 alert('Lot Created');
                 
                window.location.href = '<?php echo base_url(); ?>locations/c_create_lot/my_lot_items/';
                }else{
                alert('Error');
                return false;
              
             }
            
           }
      });

  });

var options=[];

// $(function () {
//     $("#addtoption").bind("click", function (){
//           var div = $("<div />");
//           var divHTML=GetTransferOpt("")
//           if(divHTML!=1)
//                div.html(divHTML);
//           $(".trnlistopt").append(div);
//     });
// });

function GetTransferOpt(value) {
  $(".loader").hide();           
     
    var ser_barcode = $('#ser_barcode').val();
      var option={
      ser_barcode : $('#ser_barcode').val()      
      }
      for(i=0;i<options.length;i++){       
         if(option.ser_barcode==options[i].ser_barcode)
         return 1
      
      }
      options.push(option)
    return ser_barcode;
}


  $('#click_ser_barcode').on('click', function(){
      $(".loader").show();   
    var divHTML=GetTransferOpt("")
    if(divHTML!=1){
    
  var i=0;
    var ser_barcode = $('#ser_barcode').val();
    
    $.ajax({
       url:'<?php echo base_url(); ?>locations/c_create_lot/get_barcode',
        type:'post',
        dataType:'json',
        data:{'ser_barcode':ser_barcode},
         success:function(data){

          if(data.getbar_query == true){
           // console.log(data);
          for(var k=0;k<data.bar_query.length;k++){

          $('#getbarcode').prepend('<tr><td style="width:60px;"><div style="width:60px;"><input type="number" class="form-control dynamic" id="sr_no'+i+'" name="sr_no" value=""  readonly></div></td><td ><div ><input style="background-color:white;" type="text" class="form-control bar_no"  name="bar_no"  value = "'+data.bar_query[k].BARCODE_NO+'" readonly><input style="background-color:white;" type="hidden" class="form-control item_id"  name="item_id"  value = "'+data.bar_query[k].ITEM_ID+'" readonly></div></td><td>'+data.bar_query[k].TITLE+'</td><td>'+data.bar_query[k].MPN+'</td><td>'+data.bar_query[k].UPC+'</td><td>'+data.bar_query[k].BRAND+'</td><td>'+data.bar_query[k].CONDIOTION+'</td><td>'+data.bar_query[k].CATEGORY+'</td><td><input  style ="width: 100px;" type="text" class="form-control cost_pric"  name="cost_pric"  value = "'+data.bar_query[k].COST_PRICE+'" readonly></td><td style="width:30px;"><div style="width:30px;"><button type="button" name="remove"  style="width:30px;" id="button'+i+'" class="btn btn-sm btn-danger btn_remove fa fa-trash-o"></button></div></td></tr>');
          }

          $('.dynamic').each(function(idx, elem){
          $(elem).val(idx+1);
          });

        }else {

          alert('barcode not valid ');
          return false;
        }

      }
    }); 
  }else{
    $(".loader").hide();           
    alert('duplicate barcode');
    return false;
  }
  });


  $(document).on('click','.btn_remove',function(){ 
          var row = $(this).closest('tr');
          var dynamicValue = $(row).find('.dynamic').val();
          dynamicValue = parseInt(dynamicValue);
          row.remove();
            // again call serial no function when row delete for keep serial no 
            $('.dynamic').each(function(idx, elem){
              $(elem).val(idx+1);
            });
        var count_table_rows= $("body #dynamic_tab_barc tr").length;
        var count_rows = parseInt(count_table_rows)- 1;
        $('#total_row').html('');
        $('#total_row').append(count_rows);
  });




</script>