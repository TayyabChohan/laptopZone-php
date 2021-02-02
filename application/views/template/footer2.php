  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0.0
      <?php //echo CI_VERSION;?>
    </div>
    <strong>Copyright &copy; <?php echo date('Y'); ?> <a href="#">Laptop Zone</a>.</strong> All rights reserved.
  </footer>


  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url('assets/plugins/jQuery/jquery-2.2.3.min.js');?>"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script src="http://code.jquery.com/ui/1.11.1/jquery-ui.min.js" integrity="sha256-4JY5MVcEmAVSuS6q4h9mrwCm6KNx91f3awsSQgwu0qc=" crossorigin="anonymous"></script>

<script type="text/javascript">
// double scroll
  // $(document).ready(function(){
  //    $('.double-scroll').doubleScroll();
  // });

// for manifest posted

 $(".post_btn").click(function(){

    //confirm('Are You Sure?');
    if (confirm("Are you sure?")) {
        //alert("Clicked Ok");
        var manifest_id = this.id;
    //alert(manifest_id);
    //return false;
$(document).ajaxStart(function(){
    $('body').LoadingOverlay("show");
});    
        
      $.ajax({
      //dataType: 'json',
      type: 'POST',
      url:'<?php echo base_url(); ?>index.php/manifest_loading/c_manf_load/manf_post',
      data: {'manifest_id' : manifest_id},
     success: function (response) {
      alert(response);
      window.location.reload();
      //$('#msg').html(response).delay(4500).fadeOut();

     }
  });
$(document).ajaxStop(function(){
    $('body').LoadingOverlay("hide");
});       
        
    } else {
        //alert("Clicked Cancel");
        return false;
    }

});
//for manifest posted
// for manifest manual price update

//  $(".mann-price").click(function(){
    
//     var UPC_MPN = this.id;
//     var manifest_id = this.name;
//     var m_price  = $("#"+UPC_MPN).val();
//       $.ajax({
//       //dataType: 'json',
//       type: 'POST',
//       url:'<?php //echo base_url(); ?>index.php/manifest_loading/c_manf_load/mannual_price',
//       data: { 'm_price' : m_price,'UPC_MPN' : UPC_MPN,'manifest_id' : manifest_id},
//      success: function (response) {
//       alert(response);
//       //$('#msg').html(response).delay(4500).fadeOut();

//      }
//   });
// });
//for manifest manual price update

 
//pictures order sorting
$(document).ready(function () {
  /*=============================================
  =            Multiselection option            =
  =============================================*/
  // Online link options and methods https:
  //github.com/silviomoreto/bootstrap-select
  $('.selectpicker').selectpicker();
  
  /*=====  End of Multiselection option block  ======*/


//checklist checkbox validation screen2
function onSubmit() 
{ 
  var fields = $("input[name='check_list[]']").serializeArray(); 
  if (fields.length == 0) 
  { 
    alert('Please select atleast one.'); 
    // cancel submit
    return false;
  } 
}

// register event on form, not submit button
$('#checklist_form').submit(onSubmit);

// Add Item Specifics and Attributes
  $("#add_attribute").on("click", function(){
    $(".specific_attribute").toggle();                 // .fadeToggle() // .slideToggle()
  });
  $("#add_specific").on("click", function(){
    $("#specific_fields").toggle();                 // .fadeToggle() // .slideToggle()
  });

// Checklist List table
  $("#optradio_1").on("click", function(){
    $("#ListValues").toggle();                 // .fadeToggle() // .slideToggle()
  }); 

// custom attribute on tester screen
  $(".add-row").click(function(){
    var spec_name = $("#spec_name").val();
    var custom_attribute = $("#custom_attribute").val();
 if(document.getElementById("custom_attribute").value == "")
    {
      alert("Please enter value.");
      return false;
    }else{       
    var markup = "<tr><td><input type='hidden' name='spec_h[]' id='spec_h' value='" + spec_name + "'>" + spec_name + "</td><td><input type='hidden' name='custom_h[]' id='custom_h' value='" + custom_attribute + "'>" + custom_attribute + "</td><td><input type='checkbox' name='record'></td></tr>";

    var markup_val = "<tr><td><input type='hidden' name='spec_h[]' id='spec_h' value='" + spec_name + "'>" + spec_name +  "&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<input type='hidden' name='custom_h[]' id='custom_h' value='" + custom_attribute + "'>" + custom_attribute + "</td><td><input type='checkbox' name='record'></td></tr>";    
    $("#TableDisplay tbody").append(markup);
    $("#AttributeTableVal tbody").append(markup_val);
}
  });


  // Find and remove selected table rows
  $(".delete-row").click(function(){
      $("table tbody").find('input[name="record"]').each(function(){
        if($(this).is(":checked")){
              $(this).parents("tr").remove();
          }
      });
  });

// custom attribute on checklist screen
  $(".add_row").click(function(){
    var list_name = $("#list_name").val();
    //var row_count = $('#ListTableVal tr').length;
    //alert(row_count);
    //var custom_attribute = $("#custom_attribute").val();
 if(document.getElementById("list_name").value == "")
    {
      alert("Please enter value.");
      return false;
    }else{ 
    var markup = "<tr><td><input type='checkbox' name='record[]'></td><td>" + list_name + "</td><td><input type='radio' name='cust_radio' id='cust_radio'  value='"+list_name+"'></td></tr>";
    //$("table tbody").append(markup);

    // var markup_val = "<tr><td><input type='checkbox' name='record[]'></td><td><input type='hidden' name='cust_attr[]' id='cust_attr' value='" + list_name + "'>" + list_name + "&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<input type='radio' onclick='return set_val();' name='cust_radio' id='cust_radio_"+row_count+"' value='"+list_name+"'></td><td></td></tr>";    
     $("#ListTable tbody").append(markup);
    // $("#ListTableVal tbody").append(markup_val);    
}
  });

  // Find and remove selected table rows
  $(".del_row").click(function(){
      $("table tbody").find('input[name="record[]"]').each(function(){
        if($(this).is(":checked")){
              $(this).parents("tr").remove();
          }
      });
  });  

// update order sorting images
    $('#sortable').sortable({
        //axis: 'y',
        stop: function (event, ui) {
          //var data = $(this).sortable('serialize');
          //var sortID = $('#sortable').sortable('serialize');
            //$('#q-string').text(data);
            //alert(data);
            // $.ajax({
            //     data:{ 
            // 'sortable' : sortID
            // },
            //     type: 'POST',
            //     url: '<?php //echo base_url(); ?>index.php/image_upload/image_upload/sorting_order'
            // });
  }
    });
});

$("#update_order").click(function () {
    var sortID = $('#sortable').sortable('toArray');
            $.ajax({
                data:{ 
            'sortable' : sortID
            },
          success: function(data){
              // $('form.user_status').hide();
              $('div.success').html('Pictures Order is updated.').delay(4500).fadeOut();
          },            
                type: 'POST',
                url: '<?php echo base_url(); ?>index.php/image_upload/image_upload/sorting_order'

            });

});
/*====================================================
=            tester screen checkbox check            =
====================================================*/
$("#save_attr").click(function(){
    var cat_id = $("#cat_id").val();
    var custom_attribute = $("#custom_attribute").val();
  if(custom_attribute == '' || custom_attribute == null){
    alert('Please insert custom attribute value');
    //$("#custom_attribute").focus();
    return false;
  }
    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>specifics/c_item_specifics/attribute_value',
      data: { 'cat_id' : cat_id              
    },
     success: function (data) {
        if(data == false){
          alert('Attribute value is already exist.');
          return false;
          }else{
            alert('Record successfully added.');
          }          
     }
      }); 
});
/*=====  End of tester screen checkbox check  ======*/
/*====================================================
=            tester screen checkbox check            =
====================================================*/
$("#bar_code").blur(function(){
    var bar_code = $("#bar_code").val();
    //alert(bar_code);return false;
    // var className = $('.'+bar_code).attr('class').split(' ')[3];
    // //alert(className);return false;
    // if(className == 'btn-success'){
    //   alert('Item is already tested.');return false;
    // }
    //$('#'+bar_code).prop('checked', true);

    //$('.'+bar_code).removeClass('btn-default').addClass('btn-warning');

    //return false;

    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>tester/c_tester_screen/search_barcode',
      data: { 'bar_code' : bar_code              
    },
     success: function (data) {
      //alert(data);return false;
        if(data == true){
          //alert('hello');return false;
          $('#'+bar_code).prop('checked', true);
           $('.'+bar_code).removeClass('btn-default').addClass('btn-warning');
          return false;
          }else if(data == false){
            $('.'+bar_code).removeClass('btn-default').addClass('btn-success');
            alert('Item is already tested.');return false;
          }          
     }
      }); 
});
/*=====  End of tester screen checkbox check  ======*/
//end of picture order sorting
// item_daat search on item_picture screen
$("#barcode").keydown(function(){
  var barcode = $("#barcode").val();
   //$('#bar_code').val(barcode);
  if (barcode.trim() == null || barcode.trim() == ""){
    alert("Please insert a valid Barcode");return false;
  }
      $.ajax({
        dataType: 'json',
        type: 'POST',        
        url:'<?php echo base_url(); ?>item_pictures/c_item_pictures/item_search',
        data: { 'barcode' : barcode},
       success: function (data) {
         if(data != '' ){
          //alert("No Item order found against barcode: " + barcode);
            if(data == ""){
              alert("No Item order found against barcode: " + barcode);return false;
            }else{
                  //alert(data[0].LAPTOP_ITEM_CODE);
                  $('#erp_code').val(data[0].LAPTOP_ITEM_CODE);
                  $('#inven_desc').val(data[0].ITEM_MT_DESC);
                  $('#upc').val(data[0].UPC);
                  $('#sku').val(data[0].SKU_NO);
                  $('#manufacturer').val(data[0].MANUFACTURER);
                  $('#part_no').val(data[0].MFG_PART_NO);
                  
                  $('#manifest_id').val(data[0].LZ_MANIFEST_ID);
                  $('#quantity').val(data[0].AVAIL_QTY);
            }
          }
       }
      }); 
 });


// custom attribute on tester screen
  // $(".add-row").click(function(){
  //   var spec_name = $("#spec_name").val();
  //   var custom_attribute = $("#custom_attribute").val();

  //   var markup = "<tr><td><input type='hidden' name='spec_h[]' id='spec_h' value='" + spec_name + "'>" + spec_name + "</td><td><input type='hidden' name='custom_h[]' id='custom_h' value='" + custom_attribute + "'>" + custom_attribute + "</td><td><input type='checkbox' name='record'></td></tr>";
  //   $("table tbody").append(markup);

  // });
// fetch data against SRNO for ptint on Order pulling screen
//order pulling print request

$("#add_specifics").click(function(){
  var count = $('#array_count').val(); 
  var item_id = $('#item_id').val(); 
  var item_mpn = $('#item_mpn').val();
  var item_upc = $('#item_upc').val();

  // var values = $('.selectpicker').val();
  // alert(values);return false;
  //alert(item_upc);return false;
  var cat_id = $('#cat_id').val();
  var spec_name=[];
  var spec_value=[];
  for (var i = 1; i <= count; i++) { 
 // var values = $('#specific_'+i).val();
 // alert(values);    
     spec_name.push($('#specific_name_'+i).text()); 
     spec_value.push($('#specific_'+i).val());

  }//return false;
  /*========================================
  =            custom attribute            =
  ========================================*/
  // var row_count = $('#AttributeTableVal tr').length;
  // for(var i = 1; i <= row_count -1; i++) {
  //     var t = document.getElementById('AttributeTableVal');
  //     var temp_name = $(t.rows[i].cells[0]).text();
  //     var split_val = temp_name.split("|");
  //     spec_name.push(split_val[0].trim()); 
  //     spec_value.push(split_val[1].trim());      
 // }
  /*=====  End of custom attribute  ======*/
      $.ajax({
        dataType: 'json',
        type: 'POST',        
        url:'<?php echo base_url(); ?>specifics/c_item_specifics/add_specifics',
        data: { 
          'item_id' : item_id,
          'cat_id' : cat_id,
          'spec_name' : spec_name,
          'spec_value' : spec_value,
          'item_upc' : item_upc,
          'item_mpn' : item_mpn
      },
       success: function (data) {
         if(data != ''){
          alert('Item Specific Updated');
          window.location.href = '<?php echo base_url(); ?>specifics/c_item_specifics';
                   
         }else{
           alert('Error:UPC & MPN not found');
           window.location.href = '<?php echo base_url(); ?>specifics/c_item_specifics';
         }
       }
      }); 
 });

/*====================================================
=     Tester Screen data insertion Start           =
====================================================*/

$("#tester_submit").click(function(){
  // var item_id = $('#item_id').val();
  // var manifest_id = $('#manifest_id').val();
  var count = $('#test_count').val(); 
  //var bar_code=[];
  //var barcode = $("input[name='check_info[]']:checked").val();
  var barcode = [];
  $.each($("input[name='check_info[]']:checked"), function(){            
   barcode.push($(this).val());
  });
   //alert("My favourite sports are: " + barcode.join(", "));return false;
   //alert(barcode);return false;
  var condition = $('#default_condition').val();
  var special_remarks = $('#special_remarks').val();
  var picture_note = $('#picture_note').val();
  //return false;
  var test_mt_id=[];
  var test_det_id=[];
  var selection_mode=[];

  for (var i = 1; i <= count; i++) { 
    var logical = $("input[name='logical_"+i+"']:checked").val();
    var freeText = $("input[name='free_"+i+"']").val();
    var list = $("#list_"+i).val();
    //alert(list);
    if(logical != null && logical != ""){
       test_mt_id.push($("input[name='logical_"+i+"']:checked").prop('id'));
       test_det_id.push($("input[name='logical_"+i+"']:checked").val());
       selection_mode.push('logical');
    }else if(freeText != null && freeText != ""){
     // alert('freeText1'+freeText);//return false;
      test_mt_id.push($("input[name='free_"+i+"']").prop('id'));
      test_det_id.push($("input[name='free_"+i+"']").val());
      selection_mode.push('freeText');
    }else if(list != null && list != ""){
        test_mt_id.push($("#list_"+i).prop('name'));
        test_det_id.push($("#list_"+i).val());
        selection_mode.push("list");
    }
  }
console.log(special_remarks, picture_note, barcode, condition, test_mt_id.length, test_det_id.length, selection_mode);
//return false;
if (test_mt_id.length == 0)
 {
  alert('Please Select Atleast one item test');
  return false;
 }
      $.ajax({
        dataType: 'json',
        type: 'POST',        
        url:'<?php echo base_url(); ?>tester/c_tester_screen/save_item_test',
        data: { 
          // 'item_id' : item_id,
          // 'manifest_id': manifest_id,
          'barcode' : barcode,
          'condition' : condition,
          'special_remarks' : special_remarks,
          'picture_note' : picture_note,
          'test_mt_id' : test_mt_id,
          'test_det_id' : test_det_id,
          'selection_mode' : selection_mode
      },
       success: function (data) {
         if(data == true){
          alert('Item test added.');
          window.location.href = '<?php echo base_url(); ?>tester/c_tester_screen';
                   
         }else{
           alert('Item test not inserted.');
           window.location.href = '<?php echo base_url(); ?>tester/c_tester_screen';
         }
       }
      }); 
 });

/*=====  End of Tester Screen data insertion  ======*/
/*====================================================
=     Tester Screen data Updation Start           =
====================================================*/

$("#update_test").click(function(){
  // var item_id = $('#item_id').val();
  // var manifest_id = $('#manifest_id').val();
  var count = $('#test_count').val(); 
  //var bar_code=[];
  //var barcode = $("input[name='check_info[]']:checked").val();
  var barcode = $('#bar_code').val();
  // $.each($("input[name='check_info[]']:checked"), function(){            
  //  barcode.push($(this).val());
  // });
   //alert("My favourite sports are: " + barcode.join(", "));return false;
   //alert(barcode);return false;
  var condition = $('#default_condition').val();
  var special_remarks = $('#special_remarks').val();
  var picture_note = $('#picture_note').val();
  //return false;
  var test_mt_id=[];
  var test_det_id=[];
  var selection_mode=[];

  for (var i = 1; i <= count; i++) { 
    var logical = $("input[name='logical_"+i+"']:checked").val();
    var freeText = $("input[name='free_"+i+"']").val();
    var list = $("#list_"+i).val();
    //alert(list);
    if(logical != null && logical != ""){
       test_mt_id.push($("input[name='logical_"+i+"']:checked").prop('id'));
       test_det_id.push($("input[name='logical_"+i+"']:checked").val());
       selection_mode.push('logical');
    }else if(freeText != null && freeText != ""){
     // alert('freeText1'+freeText);//return false;
      test_mt_id.push($("input[name='free_"+i+"']").prop('id'));
      test_det_id.push($("input[name='free_"+i+"']").val());
      selection_mode.push('freeText');
    }else if(list != null && list != ""){
        test_mt_id.push($("#list_"+i).prop('name'));
        test_det_id.push($("#list_"+i).val());
        selection_mode.push("list");
    }
  }//alert(test_det_id);return false; //alert(test_det_id);return false;

      $.ajax({
        dataType: 'json',
        type: 'POST',        
        url:'<?php echo base_url(); ?>tester/c_tester_screen/update_item_test',
        data: { 
          // 'item_id' : item_id,
          // 'manifest_id': manifest_id,
          'barcode' : barcode,
          'condition' : condition,
          'special_remarks' : special_remarks,
          'picture_note' : picture_note,
          'test_mt_id' : test_mt_id,
          'test_det_id' : test_det_id,
          'selection_mode' : selection_mode
      },
       success: function (data) {
         if(data == true){
          alert('Item test Updated.');
          window.location.href = '<?php echo base_url(); ?>tester/c_tester_screen';
                   
         }else{
           alert('Item test not Updated.');
           window.location.href = '<?php echo base_url(); ?>tester/c_tester_screen';
         }
       }
      }); 
 });

/*=====  End of Tester Screen data Updation  ======*/

/*==============================================
=            Hold Item for later use            =
==============================================*/

$("#hold_item").click(function(){

  var hold_barcode = [];
  $.each($("input[name='hold_item[]']:checked"), function(){            
   hold_barcode.push($(this).val());
   
  });


      $.ajax({
        dataType: 'json',
        type: 'POST',        
        url:'<?php echo base_url(); ?>tester/c_tester_screen/hold_item',
        data: { 

          'hold_barcode' : hold_barcode

      },
       success: function (data) {
         if(data == true){
          alert('Item is added to Hold.');
          //window.location.href = '<?php //echo base_url(); ?>tester/c_tester_screen';
                   
         }else{
           alert('Item is not added to Hold.');
           //window.location.href = '<?php //echo base_url(); ?>tester/c_tester_screen';
         }
       }
      }); 
 });



/*=====  End of Hold Item for later use  ======*/

/*==============================================
=            Un-Hold Single Item            =
==============================================*/

$(".unhold_item").click(function(){

  var unhold_item = $(this).attr('id');
  //alert(unhold_item);return false;


      $.ajax({
        dataType: 'json',
        type: 'POST',        
        url:'<?php echo base_url(); ?>tester/c_tester_screen/un_hold_item',
        data: { 

          'unhold_item' : unhold_item

      },
       success: function (data) {
         if(data == true){
          alert('Item is Un-Holded.');
          window.location.reload();
                   
         }else{
           alert('Item is not Un-Holded.');
           //window.location.reload();
         }
       }
      }); 
 });



/*=====  End of Un-Hold Single Item  ======*/

/*==============================================
= Un-Hold Single Item on Tester screen        =
==============================================*/

$(".unHoldItem").click(function(){

  var unhold_item = $(this).attr('id');
  var unhold_item = unhold_item.split('_');
  //alert(unhold_item[1]);return false;


      $.ajax({
        dataType: 'json',
        type: 'POST',        
        url:'<?php echo base_url(); ?>tester/c_tester_screen/un_hold_item',
        data: { 

          'unhold_item' : unhold_item[1]

      },
       success: function (data) {
         if(data == true){
          alert('Item is Un-Holded.');
          window.location.reload();
                   
         }else{
           alert('Item is not Un-Holded.');
           //window.location.reload();
         }
       }
      }); 
 });



/*=====  End of Un-Hold Single Item on Tester screen ======*/

/*==============================================
=            Un-Hold All Item            =
==============================================*/

$("#unhold_all").click(function(){

  var unHold_barcode = [];
  $.each($("input[name='selected_item_hold[]']:checked"), function(){            
   unHold_barcode.push($(this).val());
   
  });
  //alert(unHold_barcode);return false;


      $.ajax({
        dataType: 'json',
        type: 'POST',        
        url:'<?php echo base_url(); ?>tester/c_tester_screen/un_hold_all',
        data: { 

          'unHold_barcode' : unHold_barcode

      },
       success: function (data) {
         if(data == true){
          alert('Item is Un-Holded.');
          window.location.reload();
                   
         }else{
           alert('Item is not Un-Holded.');
           window.location.reload();
         }
       }
      }); 
 });



/*=====  End of Un-Hold All Item  ======*/


/*====================================================
=     Delete item test Start           =
====================================================*/

// $("#update_test").click(function(){
//   // var item_id = $('#item_id').val();
//   // var manifest_id = $('#manifest_id').val();
//   var count = $('#test_count').val(); 
//   //var bar_code=[];
//   //var barcode = $("input[name='check_info[]']:checked").val();
//   var barcode = $('#bar_code').val();
//   // $.each($("input[name='check_info[]']:checked"), function(){            
//   //  barcode.push($(this).val());
//   // });
//    //alert("My favourite sports are: " + barcode.join(", "));return false;
//    //alert(barcode);return false;
//   var condition = $('#default_condition').val();
//   var special_remarks = $('#special_remarks').val();
//   var picture_note = $('#picture_note').val();
//   //return false;
//   var test_mt_id=[];
//   var test_det_id=[];
//   var selection_mode=[];

//   for (var i = 1; i <= count; i++) { 
//     var logical = $("input[name='logical_"+i+"']:checked").val();
//     var freeText = $("input[name='free_"+i+"']").val();
//     var list = $("#list_"+i).val();
//     //alert(list);
//     if(logical != null && logical != ""){
//        test_mt_id.push($("input[name='logical_"+i+"']:checked").prop('id'));
//        test_det_id.push($("input[name='logical_"+i+"']:checked").val());
//        selection_mode.push('logical');
//     }else if(freeText != null && freeText != ""){
//      // alert('freeText1'+freeText);//return false;
//       test_mt_id.push($("input[name='free_"+i+"']").prop('id'));
//       test_det_id.push($("input[name='free_"+i+"']").val());
//       selection_mode.push('freeText');
//     }else if(list != null && list != ""){
//         test_mt_id.push($("#list_"+i).prop('name'));
//         test_det_id.push($("#list_"+i).val());
//         selection_mode.push("list");
//     }
//   }//alert(test_det_id);return false; //alert(test_det_id);return false;

//       $.ajax({
//         dataType: 'json',
//         type: 'POST',        
//         url:'<?php //echo base_url(); ?>tester/c_tester_screen/update_item_test',
//         data: { 
//           // 'item_id' : item_id,
//           // 'manifest_id': manifest_id,
//           'barcode' : barcode,
//           'condition' : condition,
//           'special_remarks' : special_remarks,
//           'picture_note' : picture_note,
//           'test_mt_id' : test_mt_id,
//           'test_det_id' : test_det_id,
//           'selection_mode' : selection_mode
//       },
//        success: function (data) {
//          if(data == true){
//           alert('Item test Updated.');
//           window.location.href = '<?php //echo base_url(); ?>tester/c_tester_screen';
                   
//          }else{
//            alert('Item test not Updated.');
//            window.location.href = '<?php //echo base_url(); ?>tester/c_tester_screen';
//          }
//        }
//       }); 
//  });

/*=====  End of Delete item test  ======*/
/*=======================================================
=            set radio button value function            =
=======================================================*/
function set_val(){
  var id = $('input[name=cust_radio]:checked').val();
  //alert(id);
}
/*=====  End of set radio button value function  ======*/


/*=====================================
=            add test call            =
=====================================*/

$("#checklist").click(function(){
  var checklist_name = $('#test_checklist_name').val();
  var max_val = $('#max_val').val();
  //alert(max_val);return false;
  var list_name = $('#list_name').val();
  var cust_radio = $("input[name='cust_radio']:checked").val();
  var optradio_1 = $('input[name=optradio_1]:checked').val();
    if (checklist_name == '' || checklist_name == null) {
     alert('Please add testing check name.');return false;
   } 
  if(optradio_1 == 'List'){

  if(list_name == '' || list_name == null ){
    alert('Please add list option.');return false;
  }else if(max_val == '' || max_val == null ){
    alert('Please enter max value.');return false;
  }else if(cust_radio == null){
    alert('Please select default option.');return false;
  }

        var default_val = $('input[name=cust_radio]:checked').val();
        var spec_name=[];
        /*========================================
      =            list option            =
      ========================================*/
      var row_count = $('#ListTable tr').length;

      for(var i = 1; i <= row_count -1; i++) {
          var t = document.getElementById('ListTable');
          var temp_name = $(t.rows[i].cells[1]).text();
          spec_name.push(temp_name.trim()); 
      }
      /*=====  End of list option  ======*/
      
          $.ajax({
            dataType: 'json',
            type: 'POST',        
            url:'<?php echo base_url(); ?>checklist/c_checklist/test_save',
            data: { 
             'checklist_name' : checklist_name,
             'optradio_1' : optradio_1,
             'spec_name' : spec_name,
             'default_val' : default_val,
             'max_val' : max_val
          },
           success: function (data) {
            if(data == false){
              alert('Testing Check Name already exist.');
              return false;
            }else{
            $('#success-msg').append('<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Record Inserted successfully. </div>').delay(3000).queue(function() { $(this).remove(); });
             $("input[name='optradio_1'][value='Logical']").prop("checked",true);
             $( "#ListValues" ).hide();
             setTimeout(function(){location.reload();},3000);
           }
             
           }
          }); 
  }else{
        var spec_name=[];
        var default_val = '';
    //alert(optradio_1); return false;
        $.ajax({
          dataType: 'json',
          type: 'POST',        
          url:'<?php echo base_url(); ?>checklist/c_checklist/test_save',
          data: { 
           'checklist_name' : checklist_name,
           'optradio_1' : optradio_1,
           'spec_name' : spec_name,
           'default_val' : default_val
        },
         success: function (data) {
          // if(data != ''){
            //alert(data);
              if(data == false){
                alert('Testing Check Name already exist.');
                return false;
              }else{
               $('#success-msg').append('<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Record Inserted successfully. </div>').delay(3000).queue(function() { $(this).remove(); });
              $('#test_checklist_name').val('');
              setTimeout(function(){location.reload();},3000);
            }

          // }
         }
        }); 
  }
  

 });

// Custom attribute and specifics
$("#save_attr").click(function(){
    var cat_id = $("#cat_id").val();
    var barcode = $("#bar_code").val();
    var item_mpn = $("#item_mpn").val();
    var item_upc = $("#item_upc").val();
    var spec_name = $("#spec_name").val();
    var custom_attribute = $("#custom_attribute").val();
  if(custom_attribute == '' || custom_attribute == null){
    alert('Please insert custom attribute value');
    //$("#custom_attribute").focus();
    return false;
  }

    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>specifics/c_item_specifics/attribute_value',
      data: { 'cat_id' : cat_id,
              'bar_code' : barcode,
              'item_mpn' : item_mpn,
              'item_upc' : item_upc,
              'spec_name' : spec_name,
              'custom_attribute' : custom_attribute
    },
     success: function (data) {
        if(data == false){
          alert('Attribute value is already exist.');
          return false;
          }else{
            alert('Record successfully added.');
          }          
     }
      }); 
 });

$("#custom_specifics").click(function(){
    var cat_id = $("#cat_id").val();
    var custom_name = $("#custom_name").val();
    var custom_value = $("#custom_value").val();
    var maxValue = $("#maxValue").val();
    var selectionMode = $("#selectionMode").val();
    var catalogue_only = $("#catalogue_only").val();

    //alert(catalogue_only);return false;

  if(custom_name == '' || custom_name == null){
    alert('Please insert specific name');
    $("#custom_name").focus();
    return false;
  }else if(custom_value == '' || custom_value == null){
    alert('Please insert specific value');
    $("#custom_value").focus();
    return false;
  }
  if(selectionMode == 'FreeText' && maxValue > 1){
    alert('You can only insert 1 against FreeText.');
    return false;
  }  

    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>specifics/c_item_specifics/custom_specific_name',
      data: { 'cat_id' : cat_id,
              'custom_name' : custom_name,
              'custom_value' : custom_value,
              'maxValue': maxValue,
              'selectionMode': selectionMode
    },
     success: function (data) {
        if(data == false){
          alert('Specific name is already exist.');
          return false;
          }else{
            alert('Record successfully added.');
          }          
     }
      }); 
 });

// checklist name check from db
$("#checklist_name").blur(function(){
    var checklist_name = $("#checklist_name").val();
  if(checklist_name == '' || checklist_name == null){
    alert('Please insert specific name');
    //$("#checklist_name").focus();
    return false;
  }

    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>checklist/c_checklist/checklist_name_check',
      data: { 'submit_checklist' : true,
      'check_list':true,
              'checklist_name' : checklist_name
              
    },
     success: function (data) {
        if(data == false){
          alert('Specific name is already exist.');
          return false;
          }else{
            alert('Record successfully added.');
          }          
     }
      }); 
 });

/*=====  End of add test call  ======*/

// fetch data against UPC or MPN in single entry form
// onblur UPC request
 
 $(document).on('change','#default_condition',function(){
//$("#default_condition").change(function(){
  
  var histo_data = $("#histo_data").val();

  if(histo_data == 0 ){

    return false;
  }else if(histo_data.length <1) {

    return false;
  }
  $(".loader").show(); 

  var condid  = $("#default_condition").val();
  var upc = $("#upc").val();
  var part_no = $("#part_no").val();

  if(upc.length == 0 && part_no.length  == 0){
    $(".loader").hide(); 
    
           $('#errorMessage_upc').html("");
        $('#errorMessage_upc').append('<p style="color:#c62828; font-size :14px;"><strong>Please Enter Upc Or Mpn</strong></p>');
        // $('#errorMessage_upc').append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Warning: Please Enter Tracking # !</strong>');
         $('#errorMessage_upc').show();
        setTimeout(function() {
          $('#errorMessage_upc').fadeOut('slow');
        }, 2200); 

    return false;
  }


      $.ajax({
        dataType: 'json',
        type: 'POST',        
        url:'<?php echo base_url(); ?>single_entry/c_single_entry/get_data',
        data: { 'upc' : upc,'condid' : condid,'part_no' : part_no},
       success: function (data) {
        $(".loader").hide(); 
        //console.log(data);//return false;
         if(data['data'] !=0){


          if(data.dekitted_pics.length != 0){            

              var dirPics = [];
             
              for(var i=0;i<data.dekitted_pics.length;i++){
                values = data.uri[i].split("/");
             
                one = values[4].substring(1);

              //console.log(one);
                //return false;
                var picture = data.dekitted_pics[i]; 
                
                var img = '<img style="width: 220px; height: 180px;" class="sort_img up-img popup_zoom_01" id="'+data.uri[i]+'" name="dekit_image[]" src="data:image;base64,'+picture+'"/>';

                dirPics.push('<li style="width: 230px; height: 220px; background: #eee!important; float: left; overflow: hidden; text-align: center; position: relative; padding: 3px; margin:5px;" id="'+values[4]+'"> <span class="tg-li"> <div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);  width:99%; height:99%; background: #eee!important; margin:5px;">'+img+' <input type="hidden" name="" value=""> <div class="text-center" style="width: 100px;"> <span class="thumb_delete" style="float: left;"><i title="Move Picture Order" style="padding: 3px;" class="fa fa-arrows" aria-hidden="true"></i></span> <span class="d_spn"><i title="Delete Picture" style="padding: 3px;" class="fa fa-trash specific_delete"></i></span> </div> </div> </span> </li> ');
              }

              $('#getsortable').html("");
              $('#getsortable').append(dirPics.join(""));
              //$('.popup_zoom_01').elevateZoom();
              
              $('.popup_zoom_01').elevateZoom({
                //zoomType: "inner",
                cursor: "crosshair",
                zoomWindowFadeIn: 600,
                zoomWindowFadeOut: 600,
                easing : true,
                scrollZoom : true
               });
              
            }else{

              $('#errorMessage_pic').html("");
              $('#errorMessage_pic').append('<p style="color:#c62828; font-size :24px;"><strong>No Picture Found</strong></p>');
              $('#errorMessage_pic').show();
              setTimeout(function() {
              $('#errorMessage_pic').fadeOut('slow');
              }, 1800); 
              $('#getsortable').html("");
              
            }

          // master pictures         
          
         }else{
          getCateory();
          

          $('#errorMessage_pic').html("");
        $('#errorMessage_pic').append('<p style="color:#c62828; font-size :24px;"><strong>No Data Found</strong></p>');       
         $('#errorMessage_pic').show();
        setTimeout(function() {
          $('#errorMessage_pic').fadeOut('slow');
        }, 2200); 
          $('#getsortable').html("");
         }
       }
      });  
 });

$("#upc").blur(function(){

  
  var upc = $("#upc").val();
$(".loader").show();
  if(upc.length <1){
    $(".loader").hide();
    $('#errorMessage_upcc').html("");
        $('#errorMessage_upcc').append('<p style="color:#c62828; font-size :18px;"><strong>Please Enter Upc</strong></p>');       
         $('#errorMessage_upcc').show();
        setTimeout(function() {
          $('#errorMessage_upcc').fadeOut('slow');
        }, 2200); 
        return false;
  } 

      $.ajax({
        dataType: 'json',
        type: 'POST',        
        url:'<?php echo base_url(); ?>single_entry/c_single_entry/get_data',
        data: { 'upc' : upc},
       success: function (data) {
        $(".loader").hide(); 
        //console.log(data);//return false;
         if(data['data'] !=0){
          $('#histo_data').val('1');
          $('#part_no').val(data['data'][0]['ITEM_MT_MFG_PART_NO']);
          $('#sku').val(data['data'][0]['ITEM_MT_BBY_SKU']);
          $('#manufacturer').val(data['data'][0]['ITEM_MT_MANUFACTURE']);
          $('#title').val(data['data'][0]['ITEM_MT_DESC']);
          // if(data['weight_qry'].length > 0){
          //   $('#title').val(data['weight_qry'][0]['ITEM_MT_DESC']);
          // }else{
          //   $('#title').val(data['data'][0]['ITEM_MT_DESC']);
          // }

          if(data['object_query'] != 0){
            $('#Object').val(data['object_query'][0]['OBJECT_NAME']);  
          }
          /*============================================================
          =            fetch category if category not found            =
          ============================================================*/
          if(data['data'][0].E_BAY_CATA_ID_SEG6 != null){
            $('#category_id').val(data['data'][0].E_BAY_CATA_ID_SEG6);
            $('#main_category').val(data['data'][0].MAIN_CATAGORY_SEG1);
            $('#sub_cat').val(data['data'][0].SUB_CATAGORY_SEG2);
            $('#category_name').val(data['data'][0].BRAND_SEG3);
            if(data['object_query'] == 0){
             getObject();
            }
          }else{
            getCateory();
          }
          /*=====  End of fetch category if category not found  ======*/
          $('#origin').val(data['data'][0]['ORIGIN_SEG4']);
          if(data['weight_qry'].length > 0){
            $('#ounces').val(data['weight_qry'][0]['WEIGHT_KG']);
          }else{
            $('#ounces').val(data['data'][0]['WEIGHT']);
          }
          // $('#ounces').val(data['weight_qry'][0]['WEIGHT_KG']);         
          
          $('#getsortable').html("");

         }else{
          getCateory();


          $('#histo_data').val('0');/// history found check 0 for not found

          $('#errorMessage_pic').html("");
        $('#errorMessage_pic').append('<p style="color:#c62828; font-size :24px;"><strong>No Data Found</strong></p>');       
         $('#errorMessage_pic').show();
        setTimeout(function() {
          $('#errorMessage_pic').fadeOut('slow');
        }, 2200); 
          $('#getsortable').html("");
         }
       }
      });  
 });


$("#part_no").blur(function(){

  $(".loader").show();
  var part_no = $("#part_no").val();

   if(part_no.length <1){
    $(".loader").hide();
    $('#errorMessage_mpn').html("");
        $('#errorMessage_mpn').append('<p style="color:#c62828; font-size :18px;"><strong>Please Enter Mpn</strong></p>');       
         $('#errorMessage_mpn').show();
        setTimeout(function() {
          $('#errorMessage_mpn').fadeOut('slow');
        }, 2200); 
        return false;
  }

   
 
  //alert(upc);return false;
      $.ajax({
        dataType: 'json',
        type: 'POST',        
        url:'<?php echo base_url(); ?>single_entry/c_single_entry/get_data',
        data: { 'part_no' : part_no},
       success: function (data) {
        $(".loader").hide(); 
        //console.log(data);//return false;
         if(data['data'] !=0){
          $('#histo_data').val('1');
          $('#sku').val(data['data'][0]['ITEM_MT_BBY_SKU']);
           if(data['data'][0]['ITEM_MT_UPC'] === $('#upc').val()){
             $('#upc').val();
           }else{
              var h_upc = data['data'][0]['ITEM_MT_UPC'];
              if(h_upc != null){
                $("<div class='col-sm-12' id='autoFillUpc'><div class='box box-primary'><div class='box-header'><span style='font-size:13px!important;color:red;'># "+ data['data'][0]['ITEM_MT_UPC'] +" UPC found from History. Against this MPN.</span><input type='hidden' id='histUpc' value='"+ data['data'][0]['ITEM_MT_UPC'] +"'><div style='width:10px;' class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div><button type='button' class='btn btn-sm' id='fillUpc'>Select</button></div></div></div>").appendTo(".historyUPC");
             }              
            }
            $("#fillUpc").click(function() {
              document.getElementById("upc").value = h_upc;
              $("#autoFillUpc").hide('fast');
            });
           $('#manufacturer').val(data['data'][0]['ITEM_MT_MANUFACTURE']);
           $('#title').val(data['data'][0]['ITEM_MT_DESC']); 
          // if(data['weight_qry'].length > 0){
          //   $('#title').val(data['weight_qry'][0]['ITEM_MT_DESC']);
          // }else{
          //   $('#title').val(data['data'][0]['ITEM_MT_DESC']);
          // }
          
          if(data['object_query'] != 0){
            $('#Object').val(data['object_query'][0]['OBJECT_NAME']);  
          }
          /*============================================================
          =            fetch category if category not found            =
          ============================================================*/
          if(data['data'][0].E_BAY_CATA_ID_SEG6 != null){
            $('#category_id').val(data['data'][0].E_BAY_CATA_ID_SEG6);
            $('#main_category').val(data['data'][0].MAIN_CATAGORY_SEG1);
            $('#sub_cat').val(data['data'][0].SUB_CATAGORY_SEG2);
            $('#category_name').val(data['data'][0].BRAND_SEG3);
            if(data['object_query'] == 0){
             getObject();
            }
          }else{
            getCateory();
          }
          /*=====  End of fetch category if category not found  ======*/
          $('#origin').val(data['data'][0]['ORIGIN_SEG4']);
          if(data['weight_qry'].length > 0){
            $('#ounces').val(data['weight_qry'][0]['WEIGHT_KG']);
          }else{
            $('#ounces').val(data['data'][0]['WEIGHT']);
          }

          $('#getsortable').html("");
         }else{
          getCateory();
          $('#histo_data').val('0');
          $('#errorMessage_pic').html("");
        $('#errorMessage_pic').append('<p style="color:#c62828; font-size :24px;"><strong>No Data Found</strong></p>');       
         $('#errorMessage_pic').show();
        setTimeout(function() {
          $('#errorMessage_pic').fadeOut('slow');
        }, 2200); 
          $('#getsortable').html("");
          //getObject();
         }
       }
      }); 
 });



// check purchase ref no
/*---Toggle Account--*/
$("#purch_ref").blur(function(){
  var PurchRefNo = $("#purch_ref").val();
  
      $.ajax({
        type: 'POST',
        url:'<?php echo base_url(); ?>manifest_loading/c_manf_load/check_purchref_no',
        data: { 'purch_ref' : PurchRefNo},
       success: function (data) {
         if(data == true){ 
              alert('Error-Purchase Ref No already exist.');
              return false;
         }
       }
      }); 
 });


  $.widget.bridge('uibutton', $.ui.button);

  /*---Toggle Account--*/
  $("#account_type").change(function(){
    var AccType = $("#account_type").val();
    
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url:'<?php echo base_url(); ?>index.php/login/login/account_type',
      data:{ 
              'account_type' : AccType
              },
       success: function (data) {
        
       }


       }); 

  });




    $(function(){
    // Menu UL LI count dynamically
    var preMenuCount = $('#Menu').children('li').length;
    document.getElementById("preMenu").innerHTML = preMenuCount;
    /*================ for catalogue to cash manue*/
    var cashMenuCount = $('#cashMenu').children('li').length;
    document.getElementById("cataCashMenu").innerHTML = cashMenuCount;
    /*================ end for catalogue to cash manue*/

    var postMenuCount = $('#PostSaleMenu').children('li').length;
    document.getElementById("postMenu").innerHTML = postMenuCount;

    var postMenuCount = $('#dekitUsMenu').children('li').length;
    document.getElementById("dekitMenu").innerHTML = postMenuCount;

    var postMenuCount = $('#eBayStreamMenu').children('li').length;
    document.getElementById("streamMenu").innerHTML = postMenuCount;

    var transMenu = $('#TransMenu').children('li').length;
    document.getElementById("rsltTrans").innerHTML = transMenu;

    var reportMenu = $('#reportMenu').children('li').length;
    document.getElementById("rsltReports").innerHTML = reportMenu;

    var posMenu = $('#posMenu').children('li').length;
    document.getElementById("posTree").innerHTML = posMenu;

    var serviceMenu = $('#serviceMenu').children('li').length;
    document.getElementById("serviceTree").innerHTML = serviceMenu;

    var bigDataMenu = $('#bigDataMenu').children('li').length;
    document.getElementById("bigDataTree").innerHTML = bigDataMenu;
     
    // var bkMenuCount = $('#bkMenu').children('li').length;
    // document.getElementById("bkPreMenu").innerHTML = bkMenuCount;

    var usersManueCount = $('#usersMenu').children('li').length;
    document.getElementById("preUsersMenu").innerHTML = usersManueCount;

    var usersManueCount = $('#warehouseMenu').children('li').length;
    document.getElementById("wareHouse").innerHTML = usersManueCount;   

    var usersManueCount = $('#merchantMenu').children('li').length;
    document.getElementById("preMerchantMenu").innerHTML = usersManueCount;  

    var usersManueCount = $('#ShopifyMenu').children('li').length;
    document.getElementById("preShopifyMenu").innerHTML = usersManueCount;    
    // $("#log").append(console.log(Count));
    //document.write(reslt);

      //Um Editor
      window.um = UM.getEditor('item_desc', {
       // autoHeight : false
        //toolbar: ['undo redo | bold italic underline']
         });
     });

/*-- Default Condition values --*/
 //   $("#default_condition").change(function(){
 //      var CondID  = $("#default_condition").val();
 //      $.ajax({
 //      dataType: 'json',
 //      type: 'POST',
 //      url:'<?php //echo base_url(); ?>index.php/seed/c_seed/get_conditions',
 //      data: { 'CondID' : CondID},
 //     success: function (data) {
 //       if(data.DEFAULT_COND!=''){ 
 //         $('#default_description').val(data.COND_DESCRIPTION);
 //       }else{
 //         document.write('No Result found');
 //        }
 //      }
 //    });
 // });
/*-- Default Condition values end --*/

/*-- Suggest Price --*/
   $("#suggest_price").click(function(){
      var UPC  = $("#upc_seed").val();
      var TITLE  = $("#title").val();
      var MPN  = $("#part_no_seed").val();
      var CONDITION = $("#it_condition").val();
// ============ The block bellow is used in Single entry =================
      if(isNaN(CONDITION))//same as is_numeric
      {
        String.prototype.capitalizeFirstLetter = function() {
         return this.charAt(0).toUpperCase() + this.slice(1);
        }
        CONDITION=CONDITION.capitalizeFirstLetter();
        if(CONDITION == 'Used'){CONDITION = 3000;}
        else if(CONDITION == 'New'){CONDITION = 1000;}
        else if(CONDITION == 'New other'){CONDITION = 1500;}
        else if(CONDITION == 'Manufacturer Refurbished'){CONDITION = 2000;}
        else if(CONDITION == 'Seller Refurbished'){CONDITION = 2500;}
        else if(CONDITION == 'For Parts or Not Working'){CONDITION = 7000;}
        else{CONDITION = 3000;}
      }
// ============ The block Above is used in Single entry =================      
      var CATEGORY = $("#category_id").val();
      $.ajax({
      type: 'POST',
      dataType: 'json',
        url:'<?php echo base_url(); ?>index.php/listing/listing/suggest_price',
      data:{ 
            'UPC' : UPC,
            'TITLE' : TITLE,
            'MPN' : MPN,
            'CONDITION' : CONDITION,
            'CATEGORY' : CATEGORY
            },
     success: function (data) {
     
     if(data.ack= 'Success' && data.itemCount > 0)
     {
        if(data.itemCount == 1)//if result is 1 than condition is changed so this check is neccessory
        {
          $( "#price-result" ).html("");
           var tr='';
           $( "#price-result" ).html( "<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>Active Listing- Price Plus Shipping Lowest</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div><table width='25%' class='table table-bordered table-striped' border='1' id='price_table'> <th>Sr. No</th><th>Seller ID</th><th>Price</th><th>Condition</th><th>Shipping Type</th>" );
        //  for ( var i = 1; i < data.itemCount+1; i++ ) {

           var item = data['item'];
           var price = item['basicInfo']['convertedCurrentPrice'];
           var username=item['sellerInfo']['sellerUserName'];
           var item_url = item['basicInfo']['viewItemURL'];
           var condition = item['basicInfo']['conditionDisplayName'];
           var ship_type = item['shippingInfo']['shippingType'];
           var trunc = ship_type.substr(0, 12);
            $('<tr>').html("<td>" + i + "</td><td><a href='"+ item_url +"' target = '_blank'>" + username + "</a></td><td>" + price + "</td><td>" + condition + "</td><td>" + trunc + "</td></tr></table></div></div>").appendTo('#price_table');
       // }

        }
        if(data.itemCount > 1)
        {
          $( "#price-result" ).html("");
           var tr='';
           $( "#price-result" ).html( "<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>Active Listing- Price Plus Shipping Lowest</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div><table width='25%' class='table table-bordered table-striped' border='1' id='price_table'> <th>Sr. No</th><th>Seller ID</th><th>Price</th><th>Condition</th><th>Shipping Type</th>" );
            for ( var i = 1; i < data.itemCount+1; i++ ) 
            {

             var item = data['item'][i-1];
             var price = item['basicInfo']['convertedCurrentPrice'];
             var username=item['sellerInfo']['sellerUserName'];
             var item_url = item['basicInfo']['viewItemURL'];
             var condition = item['basicInfo']['conditionDisplayName'];
             var ship_type = item['shippingInfo']['shippingType'];
             var trunc = ship_type.substr(0, 12);
            $('<tr>').html("<td>" + i + "</td><td><a href='"+ item_url +"' target = '_blank'>" + username + "</a></td><td>" + price + "</td><td>" + condition + "</td><td>" + trunc + "</td></tr></table></div></div>").appendTo('#price_table');
            }
            $("#price-result").html("</table></div></div>");
        }
      
    }else{
       //$( "#price-result" ).html("No Reecord found");
        $("<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>No Record Found.</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div></div></div>").appendTo("#price-result");
              
      }
     }
     }); 
 });
/*-- End Suggest Price --*/
/*-- Suggest Categories --*/
   $("#Suggest_Categories_se").click(function(){
      var UPC  = $("#upc").val();
      var MPN  = $("#part_no").val();
      var TITLE  = $("#title").val();
      $.ajax({
      type: 'POST',
      dataType: 'json',
      url:'<?php echo base_url(); ?>listing/listing/Suggest_Categories/',
      data:{ 
            'UPC' : UPC,
            'MPN' : MPN,
            'TITLE' : TITLE
            },
     success: function (data) {
     
     if(data.Ack='Success' && data.CategoryCount > 0){
       if(data.CategoryCount == 1)//if result is 1 than condition is changed so this check is neccessory
      {
          $( "#Categories_result" ).html("");
          var tr='';

         $( "#Categories_result" ).html( "<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>Suggested Categories</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div><table width='100%' class='table table-bordered table-striped' border='1' id='category_table'> <th>Sr. No</th><th>Category ID</th><th>Main Category </th><th>Sub Category</th><th>Category Name</th><th>Item(%)</th><th>Select</th>" );

            var item = data['SuggestedCategoryArray']['SuggestedCategory'];
            var CategoryParentName1=item['Category']['CategoryParentName'][0].length;//[0];//manin category
            if(CategoryParentName1 === 1){//check sub category exist or not
              var CategoryParentName1=item['Category']['CategoryParentName'];//[0];//manin category
              var CategoryID = item['Category']['CategoryID'];
              var CategoryName=item['Category']['CategoryName'];
              var PercentItemFound = item['PercentItemFound'];
              $('<tr>').html("<td>" + 1 + "</td><td>"+ CategoryID +"</td><td>" + CategoryParentName1 + "</td><td>" + '' + "</td><td>" + CategoryName + "</td><td>" + PercentItemFound + "</td><td><a class='crsr-pntr' id='cat_"+i+"' onclick='myFunction("+1+");'> Select </a></td></tr></table></div></div>").appendTo('#category_table');
            }else{
              var CategoryParentName1=item['Category']['CategoryParentName'][0];//manin category
              var CategoryParentName2=item['Category']['CategoryParentName'][1];// sub category
              var CategoryID = item['Category']['CategoryID'];
              var CategoryName=item['Category']['CategoryName'];
              var PercentItemFound = item['PercentItemFound'];
              $('<tr>').html("<td>" + 1 + "</td><td>"+ CategoryID +"</td><td>" + CategoryParentName1 + "</td><td>" + CategoryParentName2 + "</td><td>" + CategoryName + "</td><td>" + PercentItemFound + "</td><td><a class='crsr-pntr' id='cat_"+i+"' onclick='myFunction("+1+");'> Select </a></td></tr></table></div></div>").appendTo('#category_table');
            }

       }

      if(data.CategoryCount > 1){
                $( "#Categories_result" ).html("");
                     var tr='';
               //var CategoryCount = data['CategoryCount']; 
               $( "#Categories_result" ).html( "<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>Suggested Categories</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div><table width='100%' class='table table-bordered table-striped' border='1' id='category_table'> <th>Sr. No</th><th>Category ID</th><th>Main Category </th><th>Sub Category</th><th>Category Name</th><th>Item(%)</th><th>Select</th>" );
              for ( var i = 1; i <= data.CategoryCount; i++ ) 
              {
                
                var item = data['SuggestedCategoryArray']['SuggestedCategory'][i-1];
                var CategoryParentName1=item['Category']['CategoryParentName'][0].length;//manin category
                if(CategoryParentName1 === 1){//check sub category exist or not
                  var CategoryParentName1=item['Category']['CategoryParentName'];//[0];//manin category
                  var CategoryID = item['Category']['CategoryID'];
                  var CategoryName=item['Category']['CategoryName'];
                  var PercentItemFound = item['PercentItemFound'];
                  $('<tr>').html("<td>" + i + "</td><td>"+ CategoryID +"</td><td>" + CategoryParentName1 + "</td><td>" + '' + "</td><td>" + CategoryName + "</td><td>" + PercentItemFound + "</td><td><a class='crsr-pntr' id='cat_"+i+"' onclick='myFunction("+i+");'> Select </a></td></tr></table></div></div>").appendTo('#category_table');
                }else{
                  var CategoryParentName1=item['Category']['CategoryParentName'][0];//manin category
                  var CategoryParentName2=item['Category']['CategoryParentName'][1];// sub category
                  var CategoryID = item['Category']['CategoryID'];
                  var CategoryName=item['Category']['CategoryName'];
                  var PercentItemFound = item['PercentItemFound'];
                  $('<tr>').html("<td>" + i + "</td><td>"+ CategoryID +"</td><td>" + CategoryParentName1 + "</td><td>" + CategoryParentName2 + "</td><td>" + CategoryName + "</td><td>" + PercentItemFound + "</td><td><a class='crsr-pntr' id='cat_"+i+"' onclick='myFunction("+i+");'> Select </a></td></tr></table></div></div>").appendTo('#category_table');
                }
              }

              $( "</table></div></div>" ).appendTo( "#Categories_result");
            }
       
     }else{
      //$( "#Categories_result").html("No Record found");
      $("<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>No Record Found.</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div></div></div>").appendTo("#Categories_result");
      }
     }
     }); 
 });
/*-- End Suggest Cotegories --*/

/*-- Suggest Categories --*/
   $("#Suggest_Categories").click(function(){
      var UPC  = $("#upc_seed").val();
      var MPN  = $("#part_no_seed").val();
      var TITLE  = $("#title").val();
      $.ajax({
      type: 'POST',
      dataType: 'json',
      url:'<?php echo base_url(); ?>listing/listing/Suggest_Categories/',
      data:{ 
            'UPC' : UPC,
            'MPN' : MPN,
            'TITLE' : TITLE
            },
     success: function (data) {
     
     if(data.Ack='Success' && data.CategoryCount > 0){
       if(data.CategoryCount == 1)//if result is 1 than condition is changed so this check is neccessory
      {
          $( "#Categories_result" ).html("");
          var tr='';

         $( "#Categories_result" ).html( "<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>Suggested Categories</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div><table width='100%' class='table table-bordered table-striped' border='1' id='category_table'> <th>Sr. No</th><th>Category ID</th><th>Main Category </th><th>Sub Category</th><th>Category Name</th><th>Item(%)</th><th>Select</th>" );

            var item = data['SuggestedCategoryArray']['SuggestedCategory'];
            var CategoryParentName1=item['Category']['CategoryParentName'][0].length;//[0];//manin category
            if(CategoryParentName1 === 1){//check sub category exist or not
              var CategoryParentName1=item['Category']['CategoryParentName'];//[0];//manin category
              var CategoryID = item['Category']['CategoryID'];
              var CategoryName=item['Category']['CategoryName'];
              var PercentItemFound = item['PercentItemFound'];
              $('<tr>').html("<td>" + 1 + "</td><td>"+ CategoryID +"</td><td>" + CategoryParentName1 + "</td><td>" + '' + "</td><td>" + CategoryName + "</td><td>" + PercentItemFound + "</td><td><a class='crsr-pntr' id='cat_"+i+"' onclick='myFunction("+1+");'> Select </a></td></tr></table></div></div>").appendTo('#category_table');
            }else{
              var CategoryParentName1=item['Category']['CategoryParentName'][0];//manin category
              var CategoryParentName2=item['Category']['CategoryParentName'][1];// sub category
              var CategoryID = item['Category']['CategoryID'];
              var CategoryName=item['Category']['CategoryName'];
              var PercentItemFound = item['PercentItemFound'];
              $('<tr>').html("<td>" + 1 + "</td><td>"+ CategoryID +"</td><td>" + CategoryParentName1 + "</td><td>" + CategoryParentName2 + "</td><td>" + CategoryName + "</td><td>" + PercentItemFound + "</td><td><a class='crsr-pntr' id='cat_"+i+"' onclick='myFunction("+1+");'> Select </a></td></tr></table></div></div>").appendTo('#category_table');
            }

       }

      if(data.CategoryCount > 1){
                $( "#Categories_result" ).html("");
                     var tr='';
               //var CategoryCount = data['CategoryCount']; 
               $( "#Categories_result" ).html( "<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>Suggested Categories</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div><table width='100%' class='table table-bordered table-striped' border='1' id='category_table'> <th>Sr. No</th><th>Category ID</th><th>Main Category </th><th>Sub Category</th><th>Category Name</th><th>Item(%)</th><th>Select</th>" );
              for ( var i = 1; i <= data.CategoryCount; i++ ) 
              {
                
                var item = data['SuggestedCategoryArray']['SuggestedCategory'][i-1];
                var CategoryParentName1=item['Category']['CategoryParentName'][0].length;//manin category
                if(CategoryParentName1 === 1){//check sub category exist or not
                  var CategoryParentName1=item['Category']['CategoryParentName'];//[0];//manin category
                  var CategoryID = item['Category']['CategoryID'];
                  var CategoryName=item['Category']['CategoryName'];
                  var PercentItemFound = item['PercentItemFound'];
                  $('<tr>').html("<td>" + i + "</td><td>"+ CategoryID +"</td><td>" + CategoryParentName1 + "</td><td>" + '' + "</td><td>" + CategoryName + "</td><td>" + PercentItemFound + "</td><td><a class='crsr-pntr' id='cat_"+i+"' onclick='myFunction("+i+");'> Select </a></td></tr></table></div></div>").appendTo('#category_table');
                }else{
                  var CategoryParentName1=item['Category']['CategoryParentName'][0];//manin category
                  var CategoryParentName2=item['Category']['CategoryParentName'][1];// sub category
                  var CategoryID = item['Category']['CategoryID'];
                  var CategoryName=item['Category']['CategoryName'];
                  var PercentItemFound = item['PercentItemFound'];
                  $('<tr>').html("<td>" + i + "</td><td>"+ CategoryID +"</td><td>" + CategoryParentName1 + "</td><td>" + CategoryParentName2 + "</td><td>" + CategoryName + "</td><td>" + PercentItemFound + "</td><td><a class='crsr-pntr' id='cat_"+i+"' onclick='myFunction("+i+");'> Select </a></td></tr></table></div></div>").appendTo('#category_table');
                }
              }

              $( "</table></div></div>" ).appendTo( "#Categories_result");
            }
       
     }else{
      //$( "#Categories_result").html("No Record found");
      $("<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>No Record Found.</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div></div></div>").appendTo("#Categories_result");
      }
     }
     }); 
 });
/*-- End Suggest Cotegories --*/

/*-- Suggest Categories against title on single entry--*/
   $("#Suggest_Categories_for_title").click(function(){
      var UPC  = null;
      var MPN  = null;
      var TITLE  = $("#title").val().trim();
      if(TITLE == ''){
        alert("This input cannot be NULL");
        $("#title").focus();
        return false;
      }
      $.ajax({
      type: 'POST',
      dataType: 'json',
      url:'<?php echo base_url(); ?>listing/listing/Suggest_Categories/',
      data:{ 
            'UPC' : UPC,
            'MPN' : MPN,
            'TITLE' : TITLE
            },
     success: function (data) {
     
     if(data.Ack='Success' && data.CategoryCount > 0){
       if(data.CategoryCount == 1)//if result is 1 than condition is changed so this check is neccessory
      {
          $( "#Categories_result" ).html("");
          var tr='';

         $( "#Categories_result" ).html( "<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>Suggested Categories</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div><table width='100%' class='table table-bordered table-striped' border='1' id='category_table'> <th>Sr. No</th><th>Category ID</th><th>Main Category </th><th>Sub Category</th><th>Category Name</th><th>Item(%)</th><th>Select</th>" );

            var item = data['SuggestedCategoryArray']['SuggestedCategory'];
            var CategoryParentName1=item['Category']['CategoryParentName'][0].length;//[0];//manin category
            if(CategoryParentName1 === 1){//check sub category exist or not
              var CategoryParentName1=item['Category']['CategoryParentName'];//[0];//manin category
              var CategoryID = item['Category']['CategoryID'];
              var CategoryName=item['Category']['CategoryName'];
              var PercentItemFound = item['PercentItemFound'];
              $('<tr>').html("<td>" + 1 + "</td><td>"+ CategoryID +"</td><td>" + CategoryParentName1 + "</td><td>" + '' + "</td><td>" + CategoryName + "</td><td>" + PercentItemFound + "</td><td><a class='crsr-pntr' id='cat_"+i+"' onclick='myFunction("+1+");'> Select </a></td></tr></table></div></div>").appendTo('#category_table');
            }else{
              var CategoryParentName1=item['Category']['CategoryParentName'][0];//manin category
              var CategoryParentName2=item['Category']['CategoryParentName'][1];// sub category
              var CategoryID = item['Category']['CategoryID'];
              var CategoryName=item['Category']['CategoryName'];
              var PercentItemFound = item['PercentItemFound'];
              $('<tr>').html("<td>" + 1 + "</td><td>"+ CategoryID +"</td><td>" + CategoryParentName1 + "</td><td>" + CategoryParentName2 + "</td><td>" + CategoryName + "</td><td>" + PercentItemFound + "</td><td><a class='crsr-pntr' id='cat_"+i+"' onclick='myFunction("+1+");'> Select </a></td></tr></table></div></div>").appendTo('#category_table');
            }

       }

      if(data.CategoryCount > 1){
                $( "#Categories_result" ).html("");
                     var tr='';
               //var CategoryCount = data['CategoryCount']; 
               $( "#Categories_result" ).html( "<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>Suggested Categories</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div><table width='100%' class='table table-bordered table-striped' border='1' id='category_table'> <th>Sr. No</th><th>Category ID</th><th>Main Category </th><th>Sub Category</th><th>Category Name</th><th>Item(%)</th><th>Select</th>" );
              for ( var i = 1; i <= data.CategoryCount; i++ ) 
              {
                
                var item = data['SuggestedCategoryArray']['SuggestedCategory'][i-1];
                var CategoryParentName1=item['Category']['CategoryParentName'][0].length;//manin category
                if(CategoryParentName1 === 1){//check sub category exist or not
                  var CategoryParentName1=item['Category']['CategoryParentName'];//[0];//manin category
                  var CategoryID = item['Category']['CategoryID'];
                  var CategoryName=item['Category']['CategoryName'];
                  var PercentItemFound = item['PercentItemFound'];
                  $('<tr>').html("<td>" + i + "</td><td>"+ CategoryID +"</td><td>" + CategoryParentName1 + "</td><td>" + '' + "</td><td>" + CategoryName + "</td><td>" + PercentItemFound + "</td><td><a class='crsr-pntr' id='cat_"+i+"' onclick='myFunction("+i+");'> Select </a></td></tr></table></div></div>").appendTo('#category_table');
                }else{
                  var CategoryParentName1=item['Category']['CategoryParentName'][0];//manin category
                  var CategoryParentName2=item['Category']['CategoryParentName'][1];// sub category
                  var CategoryID = item['Category']['CategoryID'];
                  var CategoryName=item['Category']['CategoryName'];
                  var PercentItemFound = item['PercentItemFound'];
                  $('<tr>').html("<td>" + i + "</td><td>"+ CategoryID +"</td><td>" + CategoryParentName1 + "</td><td>" + CategoryParentName2 + "</td><td>" + CategoryName + "</td><td>" + PercentItemFound + "</td><td><a class='crsr-pntr' id='cat_"+i+"' onclick='myFunction("+i+");'> Select </a></td></tr></table></div></div>").appendTo('#category_table');
                }
              }

              $( "</table></div></div>" ).appendTo( "#Categories_result");
            }
       
     }else{
      //$( "#Categories_result").html("No Record found");
      $("<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>No Record Found.</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div></div></div>").appendTo("#Categories_result");
      }
     }
     }); 
 });
/*-- End Suggest Cotegories against title on single entry --*/
/*-- Suggest Categories for single entry UPC--*/
   //$("#upc").blur(function(){
// categry wise condiotion start

$(document).on('click','#Serch_cond',function(){
$(".loader").show();
  var card_category = $('#category_id').val();

  if(card_category == ''){
    $(".loader").hide();

    alert('Enter Category Id');
    return false;
  }

  var url='<?php echo base_url() ?>catalogueToCash/C_card_lots/get_cat_avail_cond';
   $.ajax({
      url: url,
      dataType: 'json',
      type: 'POST',
      data : {'card_category':card_category},
      success:function(data){
        $(".loader").hide();
        
      
        if(data.cond_exist == true){
          console.log('true');
          console.log(data);          
          cond_cat = [];          
          $('#apnd_radi').html('');

          for(var k = 0; k< data.get_cond.length; k++){ 


            cond_cat.push('<option value="'+data.get_cond[k].COND_NAME+'">'+data.get_cond[k].COND_NAME+'</option>');
          }
          $('#apnd_radi').append('<select class="form-control" id="default_condition" name="default_condition" required><option value="">Select Codntion</option>'+cond_cat.join("")+'</select>');  

        }else if (data.cond_exist == false){
          console.log('false');
          console.log(data);
          cond_cat = [];
          
         $('#apnd_radi').html('');

         for(var k = 0; k< data.get_all_cond.length; k++){

           cond_cat.push('<option value="'+data.get_all_cond[k].COND_NAME+'">'+data.get_all_cond[k].COND_NAME+'</option>');
           
          }
            $('#apnd_radi').append('<select class="form-control default_condition" style="width:270px;" data-live-search ="true" id="default_condition" name="default_condition"  required><option value="">Select Codntion</option>'+cond_cat.join("")+'</select>');
          
        }

      }
   });  
});
function get_cat_condiotin(){


}
// categry wise condiotion end 

function getCateory(){
      var UPC  = $("#upc").val();
      var MPN  = $("#part_no").val();
      var TITLE  = $("#title").val();
      $.ajax({
      type: 'POST',
      dataType: 'json',
      url:'<?php echo base_url(); ?>listing/listing/Suggest_Categories/',
      data:{ 
            'UPC' : UPC,
            'MPN' : MPN,
            'TITLE' : TITLE
            },
     success: function (data) {
     
     if(data.Ack='Success' && data.CategoryCount > 0){
      var category_id  = $("#category_id").val();
         if(data.CategoryCount == 1)//if result is 1 than condition is changed so this check is neccessory
        {
            var item = data['SuggestedCategoryArray']['SuggestedCategory'];
            var CategoryParentName1=item['Category']['CategoryParentName'][0].length;//[0];//manin category
            if(CategoryParentName1 === 1){//check sub category exist or not
              var CategoryParentName1=item['Category']['CategoryParentName'];//[0];//manin category
              var CategoryID = item['Category']['CategoryID'];
              var CategoryName=item['Category']['CategoryName'];
              var PercentItemFound = item['PercentItemFound'];
              if(category_id == ''){
                document.getElementById("category_id").value=CategoryID;
                document.getElementById("category_name").value=CategoryName;
                document.getElementById("main_category").value=CategoryParentName1;
              }
            }else{
              var CategoryParentName1=item['Category']['CategoryParentName'][0];//manin category
              var CategoryParentName2=item['Category']['CategoryParentName'][1];// sub category
              var CategoryID = item['Category']['CategoryID'];
              var CategoryName=item['Category']['CategoryName'];
              var PercentItemFound = item['PercentItemFound'];
              if(category_id == ''){
                document.getElementById("category_id").value=CategoryID;
                document.getElementById("category_name").value=CategoryName;
                document.getElementById("main_category").value=CategoryParentName1;
                document.getElementById("sub_cat").value=CategoryParentName2;
              }
            }
        }

        if(data.CategoryCount > 1){
            var item = data['SuggestedCategoryArray']['SuggestedCategory'][0];
            var CategoryParentName1=item['Category']['CategoryParentName'][0].length;//manin category
            if(CategoryParentName1 === 1){//check sub category exist or not
              var CategoryParentName1=item['Category']['CategoryParentName'];//[0];//manin category
              var CategoryID = item['Category']['CategoryID'];
              var CategoryName=item['Category']['CategoryName'];
              var PercentItemFound = item['PercentItemFound'];
              if(category_id == ''){
                document.getElementById("category_id").value=CategoryID;
                document.getElementById("category_name").value=CategoryName;
                document.getElementById("main_category").value=CategoryParentName1;
              }
            }else{
              var CategoryParentName1=item['Category']['CategoryParentName'][0];//manin category
              var CategoryParentName2=item['Category']['CategoryParentName'][1];// sub category
              var CategoryID = item['Category']['CategoryID'];
              var CategoryName=item['Category']['CategoryName'];
              var PercentItemFound = item['PercentItemFound'];
              if(category_id == ''){
                document.getElementById("category_id").value=CategoryID;
                document.getElementById("category_name").value=CategoryName;
                document.getElementById("main_category").value=CategoryParentName1;
                document.getElementById("sub_cat").value=CategoryParentName2;
              }
            }
       }else{
        //$( "#Categories_result").html("No Record found");
        // $("<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>No Record Found.</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div></div></div>").appendTo("#Categories_result");
        }
        getObject();
     }// end if data.Ack='Success' && data.CategoryCount > 0
   }// sucess function close
     }); // ajax call close
 //});// function close
}//getCategory function close
/*-- End Suggest Cotegories for single entry --*/
/*==================================================
=            get object on single entry            =
==================================================*/
function getObject(){
  var cat_id = $('#category_id').val();
  var object_name = $('#Object').val();
    if(cat_id == ''){
      //alert('Enter Category ');
      console.log('Category id not found');
      return false;
    }
    if(object_name != ''){
      //alert('Enter Category ');
      console.log('Object Name is Already Given');
      return false;
    }
    /*===============================================================
    =            get object drop down for given categroy            =
    ===============================================================*/

      $.ajax({
            url:'<?php echo base_url(); ?>catalogueToCash/c_tl_auction/getCatObj',
            type:'post',
            dataType:'json',
            data:{'cat_id':cat_id},
            success:function(data){
            if(data.length > 0){
              var html = '<select class="selectpicker form-control obj_dd " data-live-search="true" name="obj_dd" id = "obj_dd"  ><option value="0">select Object</option>';

                for(var i=0; i <data.length; i++) {
                  html += '<option value="'+data[i].OBJECT_ID+'">'+data[i].OBJECT_NAME+'</option>';
                }
                html += "</select>";
                $('#object_dd').html("");
                $('#object_dd').append(html);
                $('#obj_dd').selectpicker();

            }else{
              $('#object_dd').html("");
           $('#errorMessage').html("");
        $('#errorMessage').append('<p style="color:#c62828; font-size :14px;"><strong>Object Not Found</strong></p>');
        // $('#errorMessage').append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Warning: Please Enter Tracking # !</strong>');
         $('#errorMessage').show();
        setTimeout(function() {
          $('#errorMessage').fadeOut('slow');
        }, 1800); 
            }
          }
        }); 
    /*=====  End of get object drop down for given categroy  ======*/
}


/*=====  End of get object on single entry  ======*/


/*-- Suggest Categories for single entry MPN--*/
 //   $("#part_no").blur(function(){
 //      var UPC  = $("#upc").val();
 //      var MPN  = $("#part_no").val();
 //      var TITLE  = $("#title").val();
 //      $.ajax({
 //      type: 'POST',
 //      dataType: 'json',
 //      url:'<?php //echo base_url(); ?>listing/listing/Suggest_Categories/',
 //      data:{ 
 //            'UPC' : UPC,
 //            'MPN' : MPN,
 //            'TITLE' : TITLE
 //            },
 //     success: function (data) {
     
 //     if(data.Ack='Success' && data.CategoryCount > 0){
 //      var category_id  = $("#category_id").val();
 //        if(data.CategoryCount == 1)//if result is 1 than condition is changed so this check is neccessory
 //        {
 //            var item = data['SuggestedCategoryArray']['SuggestedCategory'];
 //            var CategoryParentName1=item['Category']['CategoryParentName'][0].length;//[0];//manin category
 //            if(CategoryParentName1 === 1){//check sub category exist or not
 //              var CategoryParentName1=item['Category']['CategoryParentName'];//[0];//manin category
 //              var CategoryID = item['Category']['CategoryID'];
 //              var CategoryName=item['Category']['CategoryName'];
 //              var PercentItemFound = item['PercentItemFound'];
 //              if(category_id == ''){
 //                document.getElementById("category_id").value=CategoryID;
 //                document.getElementById("category_name").value=CategoryName;
 //                document.getElementById("main_category").value=CategoryParentName1;
 //              }
 //            }else{
 //              var CategoryParentName1=item['Category']['CategoryParentName'][0];//manin category
 //              var CategoryParentName2=item['Category']['CategoryParentName'][1];// sub category
 //              var CategoryID = item['Category']['CategoryID'];
 //              var CategoryName=item['Category']['CategoryName'];
 //              var PercentItemFound = item['PercentItemFound'];
 //              if(category_id == ''){
 //                document.getElementById("category_id").value=CategoryID;
 //                document.getElementById("category_name").value=CategoryName;
 //                document.getElementById("main_category").value=CategoryParentName1;
 //                document.getElementById("sub_cat").value=CategoryParentName2;
 //              }
              
 //            }
 //        }

 //        if(data.CategoryCount > 1){
 //            var item = data['SuggestedCategoryArray']['SuggestedCategory'][0];
 //            var CategoryParentName1=item['Category']['CategoryParentName'][0].length;//manin category
 //            if(CategoryParentName1 === 1){//check sub category exist or not
 //              var CategoryParentName1=item['Category']['CategoryParentName'];//[0];//manin category
 //              var CategoryID = item['Category']['CategoryID'];
 //              var CategoryName=item['Category']['CategoryName'];
 //              var PercentItemFound = item['PercentItemFound'];
 //              if(category_id == ''){
 //                document.getElementById("category_id").value=CategoryID;
 //                document.getElementById("category_name").value=CategoryName;
 //                document.getElementById("main_category").value=CategoryParentName1;
 //              }
 //            }else{
 //              var CategoryParentName1=item['Category']['CategoryParentName'][0];//manin category
 //              var CategoryParentName2=item['Category']['CategoryParentName'][1];// sub category
 //              var CategoryID = item['Category']['CategoryID'];
 //              var CategoryName=item['Category']['CategoryName'];
 //              var PercentItemFound = item['PercentItemFound'];
 //              if(category_id == ''){
 //                document.getElementById("category_id").value=CategoryID;
 //                document.getElementById("category_name").value=CategoryName;
 //                document.getElementById("main_category").value=CategoryParentName1;
 //                document.getElementById("sub_cat").value=CategoryParentName2;
 //              }
 //            }
 //            /*===============================================================
 //            =            get object drop down for given categroy            =
 //            ===============================================================*/
 //              var cat_id = CategoryID;
 //              if(cat_id == ''){
 //                alert('Enter Category ');
 //                return false;
 //              }
 //              $.ajax({
 //                    url:'<?php //echo base_url(); ?>catalogueToCash/c_tl_auction/getCatObj',
 //                    type:'post',
 //                    dataType:'json',
 //                    data:{'cat_id':cat_id},
 //                    success:function(data){
 //                    if(data.length > 0){
 //                      var html = '<select class="selectpicker form-control obj_dd " data-live-search="true" name="obj_dd" id = "obj_dd"  ><option value="0">select Object</option>';

 //                        for(var i=0; i <data.length; i++) {
 //                          html += '<option value="'+data[i].OBJECT_ID+'">'+data[i].OBJECT_NAME+'</option>';
 //                        }
 //                        html += "</select>";
 //                        $('#object_dd').html("");
 //                        $('#object_dd').append(html);
 //                        $('#obj_dd').selectpicker();

 //                    }else{
 //                      alert('Objects Not found Against Given Category');
 //                      return false;
 //                    }
 //                  }
 //                }); 
 //            /*=====  End of get object drop down for given categroy  ======*/
 //       }else{
 //        //$( "#Categories_result").html("No Record found");
 //        // $("<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>No Record Found.</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div></div></div>").appendTo("#Categories_result");
 //        }
 //     }
 //   }
 //     }); 
 // });
/*-- End Suggest Cotegories for single entry MPN--*/


/*-- Start select Suggested Cotegories --*/
function myFunction(i) {
    var index = i;
    var t = document.getElementById('category_table');
    //$("#category_table tr").each(function() {
    var cat_id = $(t.rows[index].cells[1]).text();
    var main_cat = $(t.rows[index].cells[2]).text();
    var sub_cat = $(t.rows[index].cells[3]).text();
    var cat_name = $(t.rows[index].cells[4]).text();
    document.getElementById("category_id").value=cat_id;
    document.getElementById("category_name").value=cat_name;
    document.getElementById("main_category").value=main_cat;
    document.getElementById("sub_cat").value=sub_cat;

    get_categ_id =  document.getElementById("category_id").value;
    //console.log(get_categ_id);
    if(get_categ_id != ''){
      getObject();

    }
    
    // i++;

    //});
}
/*-- End select Suggested Cotegories --*/


// Table view
   $(function () {

    $("#saleTable").DataTable({
      "oLanguage": {
      "sInfo": "Total Order(s): _TOTAL_"
    },
      "paging": true,
      "lengthChange": true,
       "iDisplayLength": 200,
      "aLengthMenu": [[25, 50, 100, 200], [25, 50, 100, 200]],
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'      
    });
    $("#listingTable").DataTable({
      "oLanguage": {
      "sInfo": "Total Items: _TOTAL_"
    },
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'      
    });
    //$("#searchResults").DataTable();
    $('#search_results').DataTable({
      "oLanguage": {
      "sInfo": "Total Items: _TOTAL_"
    },
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
    });
    $('#templateTable').DataTable({
      "oLanguage": {
      "sInfo": "Total Orders: _TOTAL_"
    },
      "paging": true,
      "lengthChange": true,
      "iDisplayLength": 100,
      "aLengthMenu": [[25, 50, 100, 200], [25, 50, 100, 200]],
    //  "columnDefs": [{ "width": "10%", "targets": [5, 6] }],
      "order": [[ 0, "desc" ]],
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
    });
    $('#awaitingShipment').DataTable({
      "oLanguage": {
      "sInfo": "Total Orders: _TOTAL_"
    },
      "paging": true,
      "lengthChange": true,
      "iDisplayLength": 200,
      "aLengthMenu": [[25, 50, 100, 200], [25, 50, 100, 200]],
      "columnDefs": [{ "width": "10%", "targets": [5, 6] }],
      "order": [[ 12, "ASC" ]],
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
    });
    $('#paidShiped').DataTable({
      "oLanguage": {
      "sInfo": "Total Orders: _TOTAL_"
    },
      "paging": true,
      "lengthChange": true,
      "iDisplayLength": 200,
      "aLengthMenu": [[25, 50, 100, 200], [25, 50, 100, 200]],
      "columnDefs": [{ "width": "10%", "targets": [5, 6] }],
      "order": [[ 0, "desc" ]],
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
    });
    $("#listerView").DataTable({
      "oLanguage": {
      "sInfo": "Total Listing: _TOTAL_"
    },
      "iDisplayLength": 100,
      "order": [[ 0, "desc" ]],
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
    });
    $('#manifestTable').DataTable({
      "paging": true,
      "iDisplayLength": 200,
      "aLengthMenu": [[25, 50, 100, 200], [25, 50, 100, 200]],
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "order": [[ 3, "ASC" ]],
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
    });  
    $('#manifestView').DataTable({

       //"columnDefs": [
      //     { "width": "8%", "targets": 0 }
      //     { "width": "80%", "targets": 8 }
              //{ "bSortable":false, "aTargets":[ 0 ] },
            //  { "bSortable":true, "aTargets":[ 1 ] },
       //  ], 
       "aoColumnDefs": [
      { "aDataSort": [ 1, 0 ], "aTargets": [ 0 ] },
      { "aDataSort": [1, 0 ], "aTargets": [ 1 ] }
    ],

      //  "ordering": true,
      //   "aoColumns": [
      // { "aDataSort": [ 0, 1 ] },
      // { "aDataSort": [ 1, 0 ] }
      // ],
      "paging": true,
      "iDisplayLength": 200,
      "aLengthMenu": [[25, 50, 100, 200], [25, 50, 100, 200]],
      "lengthChange": true,
      "searching": true,
      "order": [[ 1, "DESC" ]],
      
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
    });
    $('#manfDetail').DataTable({

      "columnDefs": [
          { "width": "8%", "targets": 0 },
          { "width": "80%", "targets": 1 }
        ], 

      "oLanguage": {
      "sInfo": "Total Items: _TOTAL_"
    },
    "iDisplayLength": 100,
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
    }); 
    $('#manfDetailSticker').DataTable({

      "columnDefs": [
          { "width": "8%", "targets": 0 },
          { "width": "80%", "targets": 1 }
        ], 

      "oLanguage": {
      "sInfo": "Total Items: _TOTAL_"
    },
    "iDisplayLength": 100,
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
    });
    $('#manfRePrintSticker').DataTable({

      "columnDefs": [
          { "width": "8%", "targets": 0 },
          { "width": "80%", "targets": 1 }
        ], 

      "oLanguage": {
      "sInfo": "Total Items: _TOTAL_"
    },
    "iDisplayLength": 100,
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
    });         
    $('#manfDetailUnique').DataTable({
      "oLanguage": {
      "sInfo": "Total Items: _TOTAL_"
    },
    "iDisplayLength": 10,
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "order": [[ 1, "ASC" ]],
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
    });    
    $('#ItemSearchResult').DataTable({
      "oLanguage": {
      "sInfo": "Total Items: _TOTAL_"
    },
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "order": [[ 11, "ASC" ]],
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
    });
    $('#DelItemSearchResult').DataTable({
      "oLanguage": {
      "sInfo": "Total Items: _TOTAL_"
    },
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "order": [[ 1, "ASC" ]],
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
    });
    $('#ToListResult').DataTable({
      "oLanguage": {
      "sInfo": "Total Items: _TOTAL_"
    },
    "iDisplayLength": 50,
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "order": [[ 6, "ASC" ]],
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
    }); 
    $('#posReceiptView').DataTable({
      "oLanguage": {
      "sInfo": "Total Items: _TOTAL_"
    },
    "iDisplayLength": 50,
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "order": [[ 1, "DESC" ]],
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
    });    
  
    $('#SingleEntryTable').DataTable({
      "oLanguage": {
      "sInfo": "Total Records: _TOTAL_"
    },
    "iDisplayLength": 50,
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "order": [[ 1, "DESC" ]],
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
    });
    $('#TestingCheckName').DataTable({
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
    $('#TestedDataList').DataTable({
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
    $('#unTestedData').DataTable({
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
    $('#TestedData').DataTable({
      "oLanguage": {
      "sInfo": "Total Records: _TOTAL_"
    },
    "iDisplayLength": 50,
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
     "order": [[ 2, "ASC" ]],
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
    });
//     $('#checknameList').dataTable( {
// "columns": [
//     null,
//     {
//       "data": "Check Name Options", // can be null or undefined
//       "defaultContent": ""
//     }
//   ]
// } );
    $('#checknameList').DataTable({     
      "oLanguage": {
      "sInfo": "Total Records: _TOTAL_"
    },
    "iDisplayLength": 50,
      "paging": true,
      "lengthChange": true,
      "searching": true,
      //"ordering": true,
      // "order": [[ 16, "ASC" ]],
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
    });       
  $('#notInsertedData').DataTable({
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
  $('#insertedData').DataTable({
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
  $('#checklistView').DataTable({
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
 $('#holdItemData').DataTable({
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
  $('#notListed').DataTable({
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
   $('#listedItems').DataTable({
    "oLanguage": {
    "sInfo": "Total Records: _TOTAL_"
  },
  "iDisplayLength": 50,
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
     "order": [[ 14, "DESC" ]],
    "info": true,
    "autoWidth": true,
    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
  });
   $('#withoutPictures').DataTable({
    "oLanguage": {
    "sInfo": "Total Records: _TOTAL_"
  },
  "iDisplayLength": 50,
  "aLengthMenu": [[25, 50, 100, 200,500, -1], [25, 50, 100, 200,500, "All"]],
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    // "order": [[ 16, "ASC" ]],
    "info": true,
    "autoWidth": true,
    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
  });
   $('#picApproval').DataTable({
    "oLanguage": {
    "sInfo": "Total Records: _TOTAL_"
  },
  "iDisplayLength": 50,
  "aLengthMenu": [[25, 50, 100, 200,500, -1], [25, 50, 100, 200,500, "All"]],
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    // "order": [[ 16, "ASC" ]],
    "info": true,
    "autoWidth": true,
    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
  });   
   $('#posPosted').DataTable({
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
   $('#posNotPosted').DataTable({
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
   $('#poswithoutPictures').DataTable({
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
  });
    

  $(function() {

    //manifest uploading date time picker
    $('#manifestendate').datetimepicker();

    // purchase date for single entry view
    $('#purchase_date').datepicker();
    $('#start_date').datepicker();
    $('#end_date').datepicker();
    // list date for single entry view
    $('#list_date').datepicker();

    //Order pulling date
    $('#date_time').datetimepicker();
    $('#sale_date').datepicker(); 

    //Manifest Sticker Printing
    $('#from_date').datepicker();
    $('#to_date').datepicker();     


      //Date range as a button
      $('#advance_date').daterangepicker(
          {

            ranges: {
              'Today': [moment(), moment()],
              'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            //   'Last 3 Days': [moment().subtract(3, 'days'), moment()],
               'Last 7 Days': [moment().subtract(6, 'days'), moment()],
               'Last 30 Days': [moment().subtract(29, 'days'), moment()],
               'This Month': [moment().startOf('month'), moment().endOf('month')],
               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
             },

            // startDate: moment().subtract(29, 'days'),
            // endDate: moment()
          },
          function (start, end) {
            $('#advance_date').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
          }
      );

  });

  $(function() {
      //Date range as a button
      $('#date_range').daterangepicker(
          {

            ranges: {
              'Today': [moment(), moment()],
              'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            //   'Last 3 Days': [moment().subtract(3, 'days'), moment()],
               'Last 7 Days': [moment().subtract(6, 'days'), moment()],
               'Last 30 Days': [moment().subtract(29, 'days'), moment()],
               'This Month': [moment().startOf('month'), moment().endOf('month')],
               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
             },

            // startDate: moment().subtract(29, 'days'),
            // endDate: moment()
          },
          function (start, end) {
            $('#date_range').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
          }
      );

  });
   $(function() {
      //Date range as a button
      $('#lot_date').daterangepicker(
          {

            ranges: {
              'Today': [moment(), moment()],
              'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            //   'Last 3 Days': [moment().subtract(3, 'days'), moment()],
               'Last 7 Days': [moment().subtract(6, 'days'), moment()],
               'Last 30 Days': [moment().subtract(29, 'days'), moment()],
               'This Month': [moment().startOf('month'), moment().endOf('month')],
               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
             },

            // startDate: moment().subtract(29, 'days'),
            // endDate: moment()
          },
          function (start, end) {
            $('#lot_date').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
          }
      );

  });



  // Date Range filter
  $(function () {
       $('.datepicker').datepicker({
          //startDate: '-3d'
      });
        $('.datepicker_purch').datepicker({
          //startDate: '-3d'
      });

    //Date range as a button
    $('#daterange-btn').daterangepicker(
        {

          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          //   'Last 3 Days': [moment().subtract(3, 'days'), moment()],
             'Last 7 Days': [moment().subtract(6, 'days'), moment()],
             'Last 30 Days': [moment().subtract(29, 'days'), moment()],
             'This Month': [moment().startOf('month'), moment().endOf('month')],
             'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
           },

          // startDate: moment().subtract(29, 'days'),
          // endDate: moment()
        },
        function (start, end) {
          $('#daterange-btn').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
        }
    );

  $("#daterange-btn").change(function(){
    //debugger;
    var DateRange = $("#daterange-btn").val();
   // alert(DateRange);
    
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url:'<?php echo base_url(); ?>index.php/shipment/awaiting_shipment/date_range',
      data:{ 
              'daterange-btn' : DateRange
              },
       success: function (data) {

        
       }


       }); 

  });

  });

  // Get Awaiting Order Refresh
  $("#GetOrders").click(function(){
    $(".loader").show();
    $.ajax({

      url: '<?php echo base_url(); ?>listing/listing/getorders',
      type: 'POST',
      datatype : "json",
     
       success: function (data) {
        $(".loader").hide();

        window.location.reload();     
       }

       }); 

  });

  $("#UpdateOrders").click(function(){
    
    $.ajax({

      url: '<?php echo base_url(); ?>listing/listing/GetOrdersbyorderid',
      type: 'POST',
      datatype : "json",
     
       success: function (data) {

        window.location.reload();     
       }

       }); 

  });


  //Image uplaod again test start
  $(document).ready(function(){


  $("#drop-area").on('dragenter', function (e){
    e.preventDefault();
  });

  $("#drop-area").on('dragover', function (e){
    e.preventDefault();
  });

  $("#drop-area").on('drop', function (e){
    e.preventDefault();
    var image = e.originalEvent.dataTransfer.files;
    createFormData(image);
  });

  $("#btnupload").click(function(){
    var bin_name = $("#bin_id").val();
    if (bin_name == null || bin_name == ""){
      alert("Please Assign a Bin."); return false;
    }

    $("#image").trigger("click");

    //alert("Hello");return false;
  });

  $("#image").change(function(){
    var postData = new FormData($("#frmupload")[0]);
    uploadFormData(postData);
  });
  
  
// Delete image
  $(".fa-trash").click(function(){
    var id = $(this).parents('.imgCls').find('img').attr('id');
    $.ajax({
      url: '<?php echo base_url(); ?>image_upload/image_upload/delete_img',
      data: {id: id},
      type: 'POST',
      datatype : "json",
      success: function(data) {
        // console.log(data);
        // alert(data);
        window.location.reload();
      }
    });
  });

// Delete All images
  $("#del_all").click(function(){
    var item_id = $("#pic_item_id").val();
    var manifest_id = $("#pic_manifest_id").val();

    $.ajax({
      url: '<?php echo base_url(); ?>image_upload/image_upload/delete_all_images',
      data: {item_id: item_id, manifest_id: manifest_id},
      type: 'POST',
      datatype : "json",
      success: function(data) {
        // console.log(data);
        // alert(data);
        window.location.reload();
      }
    });
  });

/*============================================
=            Delete Master images            =
============================================*/

  $(".delete_master").click(function(){
     var master_url = $(this).parents('.imgCls').find('img').attr('id');
     // alert(id);
    //return false;
    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>item_pictures/c_item_pictures/master_img_delete',
      data: { 'master_url' : master_url              
    },
     success: function (data) {
      //alert(data);return false;
        if(data == true){
          alert('Item Picture has been deleted.');
          window.location.reload();
        }else if(data == false){
          alert('Error - Item Picture has been not deleted.');
          //window.location.reload();
        }
      }
      });     

  });

/*=====  End of Delete Master images  ======*/

/*================================================
=            Delete All Master images            =
================================================*/

  $(".del_master_all").click(function(){
    //var master_reorder = $('#sortable').sortable('toArray');
    if(confirm('Are you sure?')){
      var upc = $('#upc').val();
      var part_no = $('#part_no').val();
      var it_condition = $('#it_condition').val();
      var condition_name = $('#it_cond').text();
        //alert(master_all);
        //return false;
      $.ajax({
        dataType: 'json',
        type: 'POST',        
        url:'<?php echo base_url(); ?>item_pictures/c_item_pictures/delete_all_master',
        data: { 'upc':upc,
                'part_no':part_no,
                'it_condition':it_condition,
                'condition_name':condition_name

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

/*=====  End of Delete All Master images  ======*/


/*============================================
=            Delete Specific images            =
============================================*/

  $(".delete_specific").click(function(){
     var specific_url = $(this).parents('.imgCls').find('img').attr('id');
     // alert(id);
    //return false;
    $(".loader").show();
    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>item_pictures/c_item_pictures/specific_img_delete',
      data: { 'specific_url' : specific_url              
    },
     success: function (data) {
      $(".loader").hide();
      //alert(data);return false;
        if(data == true){
          alert('Item Picture has been deleted.');
          window.location.reload();
        }else if(data == false){
          alert('Error - Item Picture has been not deleted.');
          //window.location.reload();
        }
      }
      });     

  });

/*=====  End of Delete Specific images  ======*/
/*================================================
=            Delete All Specific images            =
================================================*/

  $("#specific_del_all").click(function(){
    //var master_reorder = $('#sortable').sortable('toArray');
    if(confirm('are you sure?')){
      var upc = $('#upc').val();
      var part_no = $('#part_no').val();
      var it_condition = $('#it_condition').val();
      var condition_name = $('#default_condition').text();
      var manifest_id = $('#manifest_id').val();
        //alert(master_all);
        //return false;
      $.ajax({
        dataType: 'json',
        type: 'POST',        
        url:'<?php echo base_url(); ?>item_pictures/c_item_pictures/delete_all_specific',
        data: { 'upc':upc,
                'part_no':part_no,
                'it_condition':it_condition,
                'manifest_id':manifest_id,              
                'condition_name':condition_name              
      },
       success: function (data) {
        //alert(data);return false;
          if(data == true){
            alert('Pictures has been deleted.');
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

/*=====  End of Delete All Specific images  ======*/

/*================================================
=            Master Pictures Re-Order            =
================================================*/

$("#master_reorder").click(function () {
    var master_reorder = $('#sortable').sortable('toArray');
    var upc = $('#upc').val();
    var part_no = $('#part_no').val();
    var it_condition = $('#it_condition').val();
    var condition_name = $('#it_cond').text();
    //alert(upc+"_"+part_no+"_"+it_condition+"_"+condition_name);return false;
    //alert(sortID);return false;

    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>item_pictures/c_item_pictures/master_sorting_order',
      data: { 'master_reorder' : master_reorder,
              'upc':upc,
              'part_no':part_no,
              'it_condition':it_condition,              
              'condition_name':condition_name              
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

/*=====  End of Master Pictures Re-Order  ======*/

/*================================================
=            Master Pictures Re-Order            =
================================================*/

$("#specific_order").click(function () {
    var specific_order = $('#sortable').sortable('toArray');
    var upc = $('#upc').val();
    var part_no = $('#part_no').val();
    var it_condition = $('#it_condition').val();
    var manifest_id = $('#manifest_id').val();
    var condition_name = $('#it_cond').text();
    //alert(upc+"_"+part_no+"_"+it_condition);return false;
    //alert(sortID);return false;

    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>item_pictures/c_item_pictures/specific_sorting_order',
      data: { 'specific_order' : specific_order,
              'upc':upc,
              'part_no':part_no,
              'it_condition':it_condition,
              'manifest_id':manifest_id,              
              'condition_name':condition_name              
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

/*=====  End of Master Pictures Re-Order  ======*/

/*================================================
    =            Assign Listing            =
================================================*/

$("#assign_list").click(function () {
    
  var user_name = $('#user_name').val();
  var remarks = $('#remarks').val();
  var assign_listing = [];
  $.each($("input[name='assign_listing[]']:checked"), function(){            
   assign_listing.push($(this).val());
  });    
    
  //alert(assign_listing);return false;

    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>ListingAllocation/c_ListingAllocation/AssignListing',
      data: { 'user_name' : user_name,
              'assign_listing':assign_listing,
              'remarks':remarks            
    },
     success: function (data) {
      //alert(data);return false;
        if(data == true){
          alert('Listing is assigned to selected user.');
          window.location.reload();
        }else if(data == false){
          alert('Error - Listing is not assigned to selected user.');
          //window.location.reload();
        }
      }
      });  

});

/*=====  End of Assign Listing  ======*/
/*================================================
    =           Un-Assign Listing            =
================================================*/

$("#un_assign_list").click(function () {
    
  //var un_assign_user = $('#un_assign_user').val();
  var un_assigning_list = [];
  $.each($("input[name='un_assigning_list[]']:checked"), function(){            
   un_assigning_list.push($(this).val());
  });    
    
  //alert(un_assigning_list);return false;

    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>ListingAllocation/c_ListingAllocation/UnAssigningListing',
      data: {'un_assigning_list':un_assigning_list            
    },
     success: function (data) {
      //alert(data);return false;
        if(data == true){
          alert('Listing is Un-Assigned to selected user.');
          window.location.reload();
        }else if(data == false){
          alert('Error - Listing is not Un-Assigned to selected user.');
          //window.location.reload();
        }
      }
      });  

});

/*=====  End of Assign Listing  ======*/

// var imgWidth = $(".up-img").width();

  function createFormData(image) {


    var len = image.length;

    var formImage = new FormData();
    if(len === 1){
      formImage.append('image[]', image[0]);
    }else{
      for(var i=0; i<len; i++){
        formImage.append('image[]', image[i]);
      }
    }
    
    uploadFormData(formImage);


  }
  function uploadFormData(formData) {

    // var postData = new FormData();
    var item_id = document.getElementById("pic_item_id").value;
    var manifest_id = document.getElementById("pic_manifest_id").value;

    var lz_item_id = document.getElementById("item_id").value;
    var lz_manifest_id = document.getElementById("manifest_id").value;
    // var item_id = null;
    // var manifest_id = null;
    var pic_bar_code = $("#pic_bar_code").val();
    var current_bin = $("#current_bin").val();
    var remarks = $("#remarks").val();

    var bin_id = $('#bin_id').val();
    
    //alert(bin_id); return false;

     if(item_id == '~' && manifest_id == '~'){
        var upc_mpn = document.getElementById("upc~mpn").value;
        var it_condition = document.getElementById("it_cond").value;
        var condition_name = $('#it_cond').text();
        //alert(it_condition+','+it_condition_name);return false; 
        formData.append('upc~mpn',upc_mpn);
        formData.append('it_condition',it_condition);
        formData.append('condition_name',condition_name);
        formData.append('lz_item_id',lz_item_id);
        formData.append('lz_manifest_id',lz_manifest_id);
        formData.append('pic_bar_code',pic_bar_code);
        formData.append('current_bin',current_bin);
        formData.append('bin_id',bin_id);
        formData.append('remarks',remarks);
        $(".loader").show();
        $.ajax({
          url: '<?php echo base_url(); ?>item_pictures/c_item_pictures/img_upload',
          data: formData,
          type: 'POST',
          datatype : "json",
          processData: false,
          contentType: false,
          cache: false,
          success: function(data) {
            $(".loader").hide();
              alert('Success: Item Pictures inserted');
              window.location.reload();
          }
        });
     }else{
      formData.append('pic_item_id',item_id);
    formData.append('pic_manifest_id',manifest_id);
    $.ajax({
      url: '<?php echo base_url(); ?>image_upload/image_upload/do_upload',
      data: formData,
      type: 'POST',
      datatype : "json",
      processData: false,
      contentType: false,
      cache: false,
      success: function(data) {
        window.location.reload();
      }
    });
     }

    
  }
  });

  // Onclick select all checkboxes
  function toggle(source) {
    checkboxes = document.getElementsByName('selected_item[]');
    for(var i=0, n=checkboxes.length;i<n;i++) {
      checkboxes[i].checked = source.checked;
    }
  }


  function toggle(source) {
    checkboxes = document.getElementsByName('record[]');
    for(var i=0, n=checkboxes.length;i<n;i++) {
      checkboxes[i].checked = source.checked;
    }
  }  

 function toggle(source) {
    checkboxes = document.getElementsByName('assign_listing[]');
    for(var j=0, m=checkboxes.length;j<m;j++) {
      checkboxes[j].checked = source.checked;
    }
  } 
  function toggleUnAssign(source) {
    checkboxes = document.getElementsByName('un_assigning_list[]');
    for(var i=0, n=checkboxes.length;i<n;i++) {
      checkboxes[i].checked = source.checked;
    }
  } 
  function toggleUnpostItem(source) {
    checkboxes = document.getElementsByName('unpost_item[]');
    for(var i=0, n=checkboxes.length;i<n;i++) {
      checkboxes[i].checked = source.checked;
    }
  }   
  function toggleApproval(source) {
    checkboxes = document.getElementsByName('approval[]');
    for(var i=0, n=checkboxes.length;i<n;i++) {
      checkboxes[i].checked = source.checked;
    }
  } 

  // upload checkbox validation
  function checkboxVal()
  {

    var item_id = document.getElementsByName("selected_item[]");
    //debugger;
    //var list_quantity = document.getElementsByName("list_quantity");
    var okay = false;
    for(var i = 0, l = item_id.length; i<l; i++)
    {
        // var manifest_id = document.getElementsByName(item_id[i]).value;
        // var list_quantity = document.getElementsByName(manifest_id+item_id[i]).value;
        
        //console.log(list_quantity);
        //alert(list_quantity);break;
        if(item_id[i].checked && list_quantity !== "")
        {
            okay = true;
            break;
        }
    }
    if(okay){
      return true;
    }else{
      alert("Please check atleast one item.");return false;
    }     

  }

/*******************************
* ACCORDION WITH TOGGLE ICONS
*******************************/
  function toggleIcon(e) 
    {
        $(e.target).prev('.panel-heading').find(".more-less").toggleClass('glyphicon-plus glyphicon-minus');
    }
    $('.panel-group').on('hidden.bs.collapse', toggleIcon);
    $('.panel-group').on('shown.bs.collapse', toggleIcon);

/**************************************
*     UPDATE COMPONENT QUANTITIES     *
***************************************/
$("#edit_qty").click(function(){
  var url='<?php echo base_url() ?>BundleKit/c_CreateComponent/bk_edit_quantity';
  var count = $('#qty_count').val(); 
  var component_qty=[];
  var component_id=[];
  var template_id=$("#template_id").val();
  for (var i = 1; i <= count; i++) {  
     component_qty.push($('#component_qty_'+i).val());
     component_id.push($('#component_id_'+i).val());

  }
      $.ajax({
        dataType: 'json',
        type: 'POST',        
        url:url,
        data: { 
          'component_qty' : component_qty,
          'template_id' : template_id,
          'component_id' : component_id
      },
       success: function (data) {
         if(data != ''){
          //$("#success_msg").text('success').css('color', 'green');
          alert('Data updated');
                   
         }else{
           //$("#success_msg").text('error').css('color', 'red');
           alert('Error: Fail to update data');
         }
       }
      }); 
 });
/*=====================================================================
=            htmlentites alternate for javasciprt function            =
=====================================================================*/
function escapeHtml(text) {
  return text
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
}
/*=====  End of htmlentites alternate for javasciprt function  ======*/

</script> 
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js');?>"></script>
<!-- Morris.js charts -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script> -->
<script src="<?php //echo base_url('assets/plugins/morris/morris.min.js');?>"></script>
<!-- Sparkline -->
<script src="<?php //echo base_url('assets/plugins/sparkline/jquery.sparkline.min.js');?>"></script>
<!-- jvectormap -->
<script src="<?php //echo base_url('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js');?>"></script>
<!-- DataTables -->
<script type="text/javascript" src="<?php echo base_url('assets/plugins/datatables/datatables.min.js');?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.min.js');?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.min.js');?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables/dataTables.fixedHeader.min.js');?>"></script>

<script src="<?php //echo base_url('assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js');?>"></script>
<!-- jQuery Knob Chart -->
<script src="<?php //echo base_url('assets/plugins/knob/jquery.knob.js');?>"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.11/sorting/datetime-moment.js"></script>
<script src="<?php echo base_url('assets/plugins/daterangepicker/daterangepicker.js');?>"></script>
<!-- datepicker -->
<script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datepicker.js');?>"></script>
<script src="<?php echo base_url('assets/plugins/datetimepicker/bootstrap-datetimepicker.js');?>"></script>
<!-- Bootstrap WYSIHTML5 -->
<!--<script src="<?php //echo base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js');?>"></script>-->
<!-- Um Editor -->
<script src="<?php echo base_url('assets/plugins/umeditor-dev/umeditor.config.js');?>"></script>
<script src="<?php echo base_url('assets/plugins/umeditor-dev/umeditor.js');?>"></script>
<script src="<?php //echo base_url('assets/plugins/umeditor-dev/lang/en/en.js');?>"></script>

<!-- Loader overlay -->
<!-- <script src="https://cdn.jsdelivr.net/jquery.loadingoverlay/latest/loadingoverlay.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.loadingoverlay/latest/loadingoverlay_progress.min.js"></script> -->

<!-- Slimscroll -->
<script src="<?php //echo base_url('assets/plugins/slimScroll/jquery.slimscroll.min.js');?>"></script>
<!-- Double Scroll plugin -->
<!-- <script src="<?php //echo base_url('assets/dist/js/jquery.doubleScroll.js');?>"></script> -->
<!-- iCheck 1.0.1 -->
<!-- <script src="<?php //echo base_url('assets/plugins/iCheck/icheck.js');?>"></script> -->
<!-- iCheck 1.0.1 -->
<!-- <script src="<?php// echo base_url('assets/plugins/iCheck/icheck.min.js');?>"></script> -->
<!-- FastClick -->
<script src="<?php //echo base_url('assets/plugins/fastclick/fastclick.js');?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/dist/js/app.min.js');?>"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php //echo base_url('assets/dist/js/pages/dashboard.js');?>"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.min.js"></script>
<script src="<?php echo base_url('assets/dist/js/jquery.elevatezoom.js');?>"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="<?php //echo base_url('assets/dist/js/jquery.mask.min.js');?>"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.62/jquery.inputmask.bundle.js"></script> -->
<!-- Dashboard Charts -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.3/Chart.min.js"></script> -->
<!-- <script src="<?php //echo base_url('assets/dist/js/jquery.maskMoney.js');?>" type="text/javascript"></script> -->

<!-- <script src="<?php //echo base_url('assets/dist/js/jquery.maskMoney.js');?>" type="text/javascript"></script> -->
<!-- <script src="<?php //echo base_url('assets/dist/js/jquery.price_format.2.0.js');?>" type="text/javascript"></script> -->
<!-- <script src="<?php //echo base_url('assets/dist/js/main.js');?>"></script> -->
<!-- image gallery section -->
<script src="<?php //echo base_url('assets/dist/js/image_gallery_main.js');?>"></script>
<script src="<?php //echo base_url('assets/dist/js/image_gallery_viewer.js');?>"></script>
<!-- image gallery section -->
<!-- //////////////////INPUTABLE DROPDOWN FILES///////////////////////////// -->
    <script type="text/javascript" src="<?php //echo base_url('assets/dist/js/jqxcore.js'); ?>"></script>
    <script type="text/javascript" src="<?php //echo base_url('assets/dist/js/jqxbuttons.js'); ?>"></script>
    <script type="text/javascript" src="<?php //echo base_url('assets/dist/js/jqxscrollbar.js'); ?>"></script>
    <script type="text/javascript" src="<?php //echo base_url('assets/dist/js/jqxsplitter.js'); ?>"></script>
    <script type="text/javascript" src="<?php //echo base_url('assets/dist/js/jqxlistbox.js'); ?>"></script>
    <script type="text/javascript" src="<?php //echo base_url('assets/dist/js/jqxdata.js'); ?>"></script>
    <script type="text/javascript" src="<?php //echo base_url('assets/dist/js/jqxcombobox.js'); ?>"></script>
   <!-- /////////////////////////////////////////////// -->
</body>
</html>

