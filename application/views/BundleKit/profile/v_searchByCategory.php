<?php $this->load->view("template/header.php"); ?>
<style>
  #ListValues{display: none;}

</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Save Profile
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Categories</li>
      </ol>
    </section>
    <section class="content">
       <div class="row">
        <div class="col-sm-12">
          <div class="box">
            <div class="box-body">
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
                          <strong>Warning!</strong> <?php echo $this->session->flashdata('warning'); ?>
                      </div>
                  <?php }else if($this->session->flashdata('info')){  ?>
                      <div class="alert alert-danger">
                          <a href="#" class="close" data-dismiss="alert">&times;</a>
                          <strong>Information!</strong> <?php echo $this->session->flashdata('compo'); ?>
                      </div>
                  <?php } ?>


            <div class="row text-center">
            <?php 
           /* echo "<pre>";
            print_r($data);
            exit;*/
                $itemQuery= str_replace("_", '/', $itemQuery);
                $itemQuery= str_replace("%20", ' ', $itemQuery);                             
                $main_category= str_replace("%60", ' ', $main_category);               
                $sub_category= str_replace("%60", ' ', $sub_category);               
                $category_name= str_replace("%60", ' ', $category_name);               
            ?>
              <b>Item Name:</b> &nbsp;&nbsp;<?php echo $itemQuery; ?><br>
              <b>Template Name:</b> &nbsp;&nbsp;<?php echo $components[0]['ITEM_TYPE_DESC']; ?>

              <b>Category Id:</b> &nbsp;&nbsp;<?php echo $categoryId; ?><br>
              <b>Main Category:</b> &nbsp;&nbsp;<?php echo $main_category; ?><br>
              <b>Sub Category:</b> &nbsp;&nbsp;<?php echo $sub_category; ?><br>
              <b>Category Name:</b> &nbsp;&nbsp;<?php echo $category_name; ?><br>

              <input type="hidden" name="itemName" id="itemName" value="<?php echo $itemQuery; ?>">
              <input type="hidden" name="item_upc" id="item_upc" value="<?php echo $item_upc; ?>">
              <input type="hidden" name="item_mpn" id="item_mpn" value="<?php echo $item_mpn; ?>">

              <input type="hidden" name="categoryId" id="categoryId" value="<?php echo $categoryId; ?>">
              <input type="hidden" name="main_category" id="main_category" value="<?php echo $main_category; ?>">
              <input type="hidden" name="sub_category" id="sub_category" value="<?php echo $sub_category; ?>">
              <input type="hidden" name="category_name" id="category_name" value="<?php echo $category_name; ?>">

            </div>
            <?php

              $j=1;
              if($distincts->num_rows() > 0){
              foreach ($distincts->result() as $catid) { 
              $categoryId=$catid->EBAY_CAT_ID;
              $catArray=$catid->EBAY_CAT_NAME;
              list($mainCategory, $subCategory, $CategoryName) = explode(":", $catArray);

              ?>
              <div id="accordion_<?php echo $j; ?>" role="tablist" aria-multiselectable="true">
              
                <div class="card"> 
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                       <?php
                            $p=0;
                            if($items->num_rows() > 0)
                            {
                             foreach ($items->result() as $catsIds)
                             {
                              if($categoryId==$catsIds->EBAY_CAT_ID)
                              {
                                $p++;
                              }
                            }
                          } 
                        ?>

                      <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne_<?php echo $j; ?>">
                          <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion_<?php echo $j; ?>" href="#collapseOne_<?php echo $j?>" aria-expanded="true" aria-controls="collapseOne_<?php echo $j; ?>">
                              <i class="more-less glyphicon glyphicon-plus pull-right"></i>
                              <b>Main Category:</b> &nbsp;&nbsp;<?php echo $mainCategory; ?> 
                              &nbsp;&nbsp;&nbsp;&nbsp;
                              <b>Sub Category:</b> &nbsp;&nbsp;<?php echo $subCategory; ?> 
                              &nbsp;&nbsp;&nbsp;&nbsp;
                              <b>Category Name:</b> &nbsp;&nbsp;<?php echo $CategoryName; ?> 
                              &nbsp;&nbsp;&nbsp;&nbsp; 
                              <b>Total Items:</b> &nbsp;&nbsp;<?php echo $p; ?> 
                            </a>
                          </h4>
                        </div>
                        <div id="collapseOne_<?php echo $j?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                          <div class="panel-body  form-scroll">
                             <table id="bk_listing_<?php echo $j; ?>" class="table table-bordered table-striped" >
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>SR. NO</th>
                                    <th>CATEGORY ID</th>
                                    <th>ASSIGN COMPONENTS</th>
                                    <th>EBAY ID</th>
                                    <th>TITLE</th>
                                    <th>MERCHANT</th>
                                    <th>MPN</th>
                                    <th>UPC</th>
                                    <th>ITEM ID</th>
                                    <th>PRICE</th>
                                    <th>QTY LISTED</th>
                                    <th>QTY SOLD</th>
                                    <th>MANUFACTURER</th> 
                                    <th>SUGGEST PRICE</th>
                                    <TH>REMARKS</TH>       
                                </tr>
                                </thead>
                                 <tbody>
                                  <?php                          
                                  $i=1;
                                  if($items->num_rows() > 0)
                                  {
                                   foreach ($items->result() as $catResult) {
                                    if($categoryId==$catResult->EBAY_CAT_ID){
                                     ?>
                                     <tr>
                                  <td><input type="checkbox" name="save_component" value="<?php echo $i; ?>" id="<?php echo $i; ?>" style="display: none;"></td>
                                     <td><?php echo $i; ?></td>
                                     <td><?php echo $catResult->EBAY_CAT_ID; ?></td>
                                      <td> <?php //$purchase_no = $this->session->userdata('purchase_no'); ?>
                                        <select name="item_template" class="form-control bk_component_selection" id="<?php echo $i.'2'; ?>" style="width: 150px;">
                                          <option value="">---</option>
                                            <?php 
                                            $cc=1;                               
                                         
                                             foreach ($components as $component) {
                                              ?>
                                              <option value="<?php echo $component['LZ_COMPONENT_ID']; ?>" class="data_id"><?php echo $component['LZ_COMPONENT_DESC'];?></option>
                                              <?php
                                              $cc++;
                                              }
                                        
                                        ?>
                                        </select>
                                        </td>
                                      <td><?php echo $catResult->EBAY_ITEM_ID; ?></td>
                                      <td><?php echo $catResult->ITEM_TITLE; ?></td>
                                      <td><?php echo $catResult->SELLER_ACC; ?></td>                
                                      <td><?php echo $catResult->MPN; ?></td>
                                      <td><?php echo $catResult->UPC; ?></td>
                                      <td><?php echo $catResult->EBAY_ITEM_ID; ?></td>
                                      <td><?php echo $catResult->LISTED_PRICE; ?></td>
                                      <td><?php echo $catResult->QTY_LISTED; ?></td>
                                      <td><?php echo $catResult->QTY_SOLD; ?></td>
                                      <td><?php echo $catResult->ITEM_MANUFACTURE; ?></td>  
                                                                          
                                      <td><input type="text" name="suggestPrice" class="suggestPrice"></td>
                                      <td><input type="text" name="u_comment" class="u_comment" value=""></td>                     
                                     <?php
                                     $i++;
                                    echo "</tr>"; 
                                      } 
                                    } ?>
                                    <?php 
                                    $h=1;                               
                                     foreach ($components as $component) {
                                      ?>
                                    <input type="hidden" name="tempID" id="tempID" value="<?php echo $component['LZ_BK_ITEM_TYPE_ID']; ?>">
                                    <input type="hidden" name="tempName" id="tempName" value="<?php echo $component['ITEM_TYPE_DESC']; ?>">
                                    <?php
                                     $h++;
                                    }           
                                  ?>
                                  </tbody>
                                </table>
                              <?php }else { ?>
                               </tbody>
                            </table>
                           <?php }                             
                          ?>                               
                          </div>
                          
                        </div>
                         
                      </div>

                    </div><!-- panel-group -->

                  </div>
                </div>  
                  <?php $j++;
                  
                   }//end accordian foreach
                } //end if
                ?>
                <input type="hidden" id="countJs" value="<?php echo $j; ?>">
                <input type="hidden" id="CategoryName" name="category_name" value="<?php echo $CategoryName; ?>">
                
                <div class="form-group" id="dsds" style="margin-left: 6px;">
                   <button class="btn btn-primary" id="bk_listing" value="bk_listing_<?php echo $j; ?>" >Save</button>
                </div>
       <!-- end accordian  -->
           </div> <!-- box body class -->
          </div><!-- box class -->       
      <!-- /.col -->
        </div>
    <!-- /.row -->
      </div>
   
    <!-- /.content -->
    </section>
  <!-- /.content -->
  </div>  

<script>

function addRow (argument) {
    var myTable = document.getElementById("ListTable");
    var currentIndex = myTable.rows.length;
    var currentRow = myTable.insertRow(-1);

    var list = document.createElement("input");
    list.setAttribute("type", "text");
    list.setAttribute("name", "list" + currentIndex);
    //list.setAttribute("id", "list" + currentIndex);
    list.setAttribute("value", "");
    list.setAttribute("class", "form-control");
    list.setAttribute("placeholder", "Enter list value");

    // var keywordsBox = document.createElement("input");
    // keywordsBox.setAttribute("name", "keywords" + currentIndex);

    var defaultRadio = document.createElement("input");
    defaultRadio.setAttribute("type", "radio" );
    defaultRadio.setAttribute("name", "listRadio");
    // defaultRadio.setAttribute("id", "listRadio");
    //defaultRadio.setAttribute("class", "btn btn-primary");

    var addRowBox = document.createElement("input");
    addRowBox.setAttribute("type", "button");
    defaultRadio.setAttribute("name", "add_row");
    addRowBox.setAttribute("value", "Add Row");
    addRowBox.setAttribute("onclick", "addRow();");
    addRowBox.setAttribute("class", "btn btn-primary");

    var dellRow = document.createElement("input");
    dellRow.setAttribute("type", "button");
    defaultRadio.setAttribute("name", "del_row");
    dellRow.setAttribute("value", "Delete Row");
    dellRow.setAttribute("onclick", "deleteRow(this);");
    dellRow.setAttribute("class", "btn btn-danger");            

    var currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(list);

    // currentCell = currentRow.insertCell(-1);
    // currentCell.appendChild(keywordsBox);

    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(defaultRadio);

    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(addRowBox);

    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(dellRow);            
}
function deleteRow(r) {
    var i = r.parentNode.parentNode.rowIndex;
    document.getElementById("ListTable").deleteRow(i);
}
</script>

<?php $this->load->view("template/footer.php"); ?>
<script>
  /***********************************
  FOR SAVING BK ACCORDIAN DATA  
*************************************/
var chkeck = document.getElementsByName("save_component");
var selct = document.getElementsByClassName("bk_component_selection");
//console.log(chkeck, selct); return false;

for (var k = 0; k < selct.length; k++) {
    (function(k) {
        selct[k].onchange = function(){
            chkeck[k].checked = selct[k].value !== '';
        }
    })(k);
}

$("#bk_listing").click(function(){
    this.disabled = true;
  var fields = $("input[name='save_component']").serializeArray(); 
    if (fields.length === 0) 
    { 
        alert('Please Select at least one Component'); 
        // cancel submit
        return false;
    }  

  var arr=[];
  var url='<?php echo base_url() ?>BundleKit/c_advanceCategories/saveEbaycatData';
  var count=$("#countJs").val();

 
  //alert(count); return false;
  var templateiD=$("#tempID").val();
  var profile_id=$("#profile_id").val();
  var itemName=$("#itemName").val();
  var item_upc=$("#item_upc").val();
  var item_mpn=$("#item_mpn").val();

  var categoryId=$("#categoryId").val();
  var main_category=$("#main_category").val();
  var sub_category=$("#sub_category").val();
  var category_name=$("#category_name").val();
  //console.log(categoryId, main_category, sub_category, category_name); return false;
  var CategoryName=[];
  var componentName=[];
  var remarks=[];
  var mpn=[];
  var upc=[];
  var titles=[];
  var itemPrice=[];
  var brand=[];
  var itemId=[];
  var suggestPrice=[];
  var remarks=[];
  //var category_id=[];
  var catId=[];

  for (var j = 1; j < count; j++) {
      var tableId="bk_listing_"+j;
      var tdbk = document.getElementById(tableId);
      $.each($("#"+tableId+" input[name='save_component']:checked"), function()
      {            
        arr.push($(this).val());
      });
      //console.log(arr); return false;
      //category_id.push($(tdbk.rows[1].cells[2]).text());
             for (var i = 0; i < arr.length; i++)
                {
                  //catId=$(tdbk.rows[arr[i]].cells[2]).text();
                  
                  titles.push($(tdbk.rows[arr[i]].cells[4]).text());
                  mpn.push($(tdbk.rows[arr[i]].cells[6]).text());
                  upc.push($(tdbk.rows[arr[i]].cells[7]).text());
                  itemId.push($(tdbk.rows[arr[i]].cells[3]).text());
                  itemPrice.push($(tdbk.rows[arr[i]].cells[8]).text());
                  brand.push($(tdbk.rows[arr[i]].cells[11]).text());
                  catId.push($(tdbk.rows[arr[i]].cells[14]).text());
                  CategoryName.push($(tdbk.rows[arr[i]].cells[15]).text());
                    $(tdbk.rows[arr[i]]).find(".bk_component_selection").each(function()
                        {
                          componentName.push($(this).val());
                        });
                     $(tdbk.rows[arr[i]]).find(".suggestPrice").each(function()
                        {
                          suggestPrice.push($(this).val());
                        });
                     $(tdbk.rows[arr[i]]).find(".u_comment").each(function()
                        {
                          remarks.push($(this).val());
                        });           
                }
                //console.log(arr); return false;
                arr=[];
  }
  
//console.log(componentName); return false;
  $.ajax({
    url:url,
    type: 'POST',
    data: {
      'templateiD': templateiD,
      'itemName': itemName,
      'componentName': componentName,
      'mpn': mpn,
      'upc': upc,
      'catId': catId,
      'brand': brand,
      'itemId': itemId,
      'item_upc': item_upc,
      'item_mpn': item_mpn,
      'suggestPrice': suggestPrice,
      'CategoryName': CategoryName,
      'remarks': remarks,
      'titles': titles,
      'profile_id': profile_id,
      'itemPrice': itemPrice,
      'categoryId': categoryId,
      'main_category': main_category,
      'sub_category': sub_category,
      'category_name': category_name
    },
    dataType: 'json',
    success: function (data) {
         if(data != ''){
           window.location.href = '<?php echo base_url(); ?>BundleKit/c_advanceCategories/showProfilesList';
               //alert("data is inserted");    
         }else{
           alert('Error: Fail to insert data');
         }
       }
  });
  
  });

$(".search_category").click(function(){
  var fields = $("input[name='cat_list[]']").serializeArray(); 
    if (fields.length === 0) 
    { 
        alert('Please select atleast one category'); 
        // cancel submit
        return false;
    }
  });

function bk_checkboxVal()
  {

var fields = $("input[name='save_component']").serializeArray(); 
    if (fields.length === 0) 
    { 
        alert('Please Select at least one Component'); 
        // cancel submit
        return false;
    }     

  }
</script>