<?php $this->load->view('template/header');
ini_set('memory_limit', '-1');
?>
<style type="text/css">
  .m-3{
    margin: 3px;
  }
  .show-flag{
    border: 2px solid red;
    padding: 1px;
  }

 label.btn span {
  font-size: 1em ;
}

label input[type="radio"] ~ i.fa.fa-circle-o{
    color: #c8c8c8;    display: inline;
}
label input[type="radio"] ~ i.fa.fa-dot-circle-o{
    display: none;
}
label input[type="radio"]:checked ~ i.fa.fa-circle-o{
    display: none;
}
label input[type="radio"]:checked ~ i.fa.fa-dot-circle-o{
    color: red;    display: inline;
}
label:hover input[type="radio"] ~ i.fa {
color: red;
}

label input[type="checkbox"] ~ i.fa.fa-square-o{
    color: #c8c8c8;    display: inline;
}
label input[type="checkbox"] ~ i.fa.fa-check-square-o{
    display: none;
}
label input[type="checkbox"]:checked ~ i.fa.fa-square-o{
    display: none;
}
label input[type="checkbox"]:checked ~ i.fa.fa-check-square-o{
    color: #7AA3CC;    display: inline;
}
label:hover input[type="checkbox"] ~ i.fa {
color: red;
}

div[data-toggle="buttons"] label.active{
    color: red;

}

div[data-toggle="buttons"] label {
display: inline-block;
padding: 6px 12px;
margin-bottom: 0;
font-size: 14px;
font-weight: normal;
line-height: 2em;
text-align: left;
white-space: nowrap;
vertical-align: top;
cursor: pointer;
background-color: none;
border: 0px solid #c8c8c8;
border-radius: 3px;
color: black;
-webkit-user-select: none;
-moz-user-select: none;
-ms-user-select: none;
-o-user-select: none;
user-select: none;
}
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

div[data-toggle="buttons"] label:hover {
color: red;
}

div[data-toggle="buttons"] label:active, div[data-toggle="buttons"] label.active {
-webkit-box-shadow: none;
box-shadow: none;
}
#contentSec{
  display: none;
}
#objectSection{
  display: none;
}

</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          Special Item Recognition
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Special Item Recognition</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- //////////////////////////////////////////// -->
       <div class="box" id= "dyn_box3">
            <div class="box-header with-border">
              <h3 class="box-title">Add Special Lot</h3>
              <div class="box-tools pull-right">
               <!--  <a target="_blank" class="" href="<?php //echo base_url().'catalogueToCash/c_card_lots/special_lot_detail'?>">Lot Detail</a> -->
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body ">
              <!-- <form method="post" action="<?php //echo base_url().'catalogueToCash/c_card_lots/add_special_lot'?>" enctype="multipart/form-data" > -->
                <?php if ($this->session->flashdata('success')) {?>
                      <div class="alert alert-success">
                          <a href="#" class="close" data-dismiss="alert">&times;</a>
                          <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
                      </div>
                  <?php } else if ($this->session->flashdata('error')) {?>
                      <div class="alert alert-danger">
                          <a href="#" class="close" data-dismiss="alert">&times;</a>
                          <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
                      </div>
                  <?php } else if ($this->session->flashdata('warning')) {?>
                      <div class="alert alert-warning">
                          <a href="#" class="close" data-dismiss="alert">&times;</a>
                          <strong>Error!</strong> <?php echo $this->session->flashdata('warning'); ?>
                      </div>
                  <?php } else if ($this->session->flashdata('compo')) {?>
                      <div class="alert alert-danger">
                          <a href="#" class="close" data-dismiss="alert">&times;</a>
                          <strong>Error!</strong> <?php echo $this->session->flashdata('compo'); ?>
                      </div>
                  <?php }?>
               <?php $sessionData = $this->session->userdata("specialLot");
//var_dump($sessionData['up_cond_item']);
// echo "<pre>";
// print_r(@$datas['item_history']);
// exit;
?>
                <div class="col-sm-12">
                  <div class="col-sm-8" id="">
                       <div id="update_message">

                      </div>
                      <div class="alert success pull-right" style="font-size:16px;color:green;font-weight:600;"></div>
                    </div>
                    <div class="col-sm-2 pull-right">
                    <div class="form-group">
                      <div class="pull-right">
                      <a target="_blank" class="btn btn-primary" href="<?php echo base_url() . 'catalogueToCash/c_card_lots/special_lot_detail' ?>">Lot Detail</a>

                    </div>
                    </div>
                </div>
                </div>
              <form method="post"  id="myForm" action="<?php echo base_url() . 'catalogueToCash/c_card_lots/syncDevice' ?>">
              <div class="col-md-12"><!-- Custom Tabs -->

                <div class="col-sm-1">
                  <label for="Special Lot UPC" class="control-label">Barcode:</label>
                  <div class="form-group">

                    <input type="text" name="card_barc" id="card_barc" value="<?php echo @$this->uri->segment(5); ?>" placeholder="Enter UPC" class="form-control card_barc" readonly>



                  </div>
                </div>

                <div class="col-sm-3">
                  <label for="Special Lot UPC" class="control-label">UPC:</label>
                  <div class="input-group input-group-md">
                    <?php
if (!empty(@$datas['update_note'][0]['CARD_UPC'])) {
    $upc = @$datas['update_note'][0]['CARD_UPC'];
} else {
    $upc = @$datas['item_history'][0]['CARD_UPC'];
}
?>
                    <input type="text" name="card_upc" id="card_upc" value="<?php echo @$upc; ?>" placeholder="Enter UPC" class="form-control card_upc">
                    <div class="input-group-btn">
                        <button class="btn btn-info Serch_upc" title="Search on Ebay " id="Serch_upc" type="button"><i class="glyphicon glyphicon-search"></i><button class="btn btn-danger serch_upc_sys" title="Search in System " id="serch_upc_sys" type="button"><i class="glyphicon glyphicon-search"></i></button>
                        </div>
                      <!-- <button style="margin-top:5px;" type="button" title="Search on Ebay " id="Serch_upc" class="btn btn-success btn-xs Serch_upc"   style="height: 28px; margin-bottom: auto;">Search upc On Ebay</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button style="margin-top:5px;" type="button" title="Get Category Object" class="btn btn-danger btn-xs serch_upc_sys"   style="height: 28px; margin-bottom: auto;">Search upc in System</button> -->



                  </div>
                </div>


                <div class="col-sm-3">
                  <label for="Special Lot MPN" class="control-label">MPN:</label>
                    <div class="input-group input-group-md">
                    <?php
if (!empty(@$datas['update_note'][0]['CARD_MPN'])) {
    $mpn = @$datas['update_note'][0]['CARD_MPN'];
} else {
    $mpn = @$datas['item_history'][0]['CARD_MPN'];
}
?>
                    <input type="text" name="card_mpn" id="card_mpn" value="<?php echo @$mpn; ?>" placeholder="Enter MPN" class="form-control card_mpn">
                    <input type="hidden" name="special_lot_id" id="special_lot_id" value="<?php echo $this->uri->segment(4); ?>">
                    <input type="hidden" name="barcode" id="barcode" value="<?php echo $this->uri->segment(5); ?>">
                    <div class="input-group-btn">
                        <button class="btn btn-info Serch_mpn" title="Search on Ebay " id="Serch_mpn" type="button"><i class="glyphicon glyphicon-search"></i><button class="btn btn-danger serch_mpn_sys" title="Search in System " id="serch_mpn_sys" type="button"><i class="glyphicon glyphicon-search"></i></button>
                        </div>
                    <!-- <button style="margin-top:5px;" type="button" title="Search on Ebay " id="Serch_mpn" class="btn btn-success btn-xs Serch_mpn"   style="height: 28px; margin-bottom: auto;">Search Mpn On Ebay</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button style="margin-top:5px;" type="button" title="Get Category Object" class="btn btn-danger btn-xs serch_mpn_sys"   style="height: 28px; margin-bottom: auto;">Search Mpn in System</button> -->


                  </div>
                </div>


                <?php $employee_location = $this->session->userdata('employee_location');?>
               <div class="col-sm-1">
                  <div class="form-group">
                    <label for="Special Lot Bin/Rack" class="control-label">BIN/RACK:</label>
                    <select class="selectpicker form-control up_bin_rack" data-live-search ="true" id="up_bin_rack"  name="up_bin_rack" <?php if ($employee_location == 'PK') {
    echo "disabled";
}?>>
                    <option value = "0">Select Bin</option>
                      <?php
foreach ($data['bin'] as $bins) {
    if ($bins['BIN_ID'] == @$datas['update_note'][0]['BIN_ID']) {
        $selected = "selected";
    } else {
        $selected = "";
    }

    ?>
                          <option value="<?php echo $bins['BIN_ID']; ?>" <?php echo $selected; ?>><?php echo $bins['BIN_NO']; ?></option>
                      <?php
}
?>
                    </select>

                  </div>
                </div>

                <div>
                   <?php
if (!empty(@$datas['update_note'][0]['CATEGORY_ID'])) {
    $category_id = @$datas['update_note'][0]['CATEGORY_ID'];
} else {
    $category_id = @$datas['item_history'][0]['CATEGORY_ID'];
}
if (!empty(@$datas['update_note'][0]['CATALOG_MT_ID'])) {
    $catalog_mt_id = @$datas['update_note'][0]['CATALOG_MT_ID'];
} else {
    $catalog_mt_id = @$datas['item_history'][0]['CATALOG_MT_ID'];
}
?>
                    <input type="hidden" name="br_cata_id" id="br_cata_id" value="<?php echo @$category_id; ?>" placeholder="Enter Brand Name" class="form-control br_cata_id">
                    <input type="hidden" name="br_catalog_id" id="br_catalog_id" value="<?php echo @$catalog_mt_id; ?>" placeholder="Enter Brand Name" class="form-control br_catalog_id">
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="Special Lot Object" class="control-label">Object:</label>
                     <div class="form-group" id ="apnd_obj">
                    <select class=" selectpicker form-control up_object_desc"  data-live-search ="true" id="up_object_desc" name="up_object_desc" >

                      <option value = "">Select Object</option>

                      <?php
if (!empty(@$datas['update_note'][0]['OBJECT_ID'])) {
    $object_id = @$datas['update_note'][0]['OBJECT_ID'];
} else {
    $object_id = @$datas['item_history'][0]['OBJECT_ID'];
}

foreach ($data['obj'] as $object) {
    if ($object['OBJECT_ID'] === @$object_id) {
        $selecte = "selected";
    } else {
        $selecte = "";
    }
    ?>
                          <option value="<?php echo $object['OBJECT_ID']; ?>" <?php echo $selecte; ?>><?php echo $object['OBJECT_NAME']; ?></option>
                      <?php
}
?>
                    </select>
                    </div>
                  </div>
                </div>



                <div class="col-sm-2">
                  <label for="Special Lot MPN" class="control-label">Category Id:</label>


                    <div class="col-sm-12" id="errorMessage_cat_id" ></div>
                    <div class="input-group input-group-md">
                    <input type="number" name="card_category" id="card_category" value="<?php echo @$datas['update_note'][0]['CATEGORY_ID']; ?>" placeholder="Enter Category" class="form-control card_category">
                    <div class="input-group-btn">
                        <button class="btn btn-info Serch_con" title="Search Condition Against Category" id="Serch_con" type="button"><i class="glyphicon glyphicon-search"></i>
                        </div>
                  </div>
                </div>
              </div>
              <div class="col-md-12"><!-- Custom Tabs -->
                <div class="col-sm-2">
                  <div class="form-group">
                  <?php
if (!empty(@$datas['update_note'][0]['BRAND'])) {
    $brand = @$datas['update_note'][0]['BRAND'];
} else {
    $brand = @$datas['item_history'][0]['BRAND'];
}

?>
                    <label for="Brand Name" class="control-label">Brand:</label>
                     <input type="text" name="brand_name" id="brand_name" value="<?php echo @$brand; ?>" placeholder="Enter Brand Name" class="form-control brand_name">
                  <div >


                     <div class="form-group" >
                    <select class=" selectpicker form-control selc_brand"  data-live-search ="true" id="selc_brand" name="selc_brand" >

                      <option value = "">Select Brand</option>
                      <?php
foreach ($data['las_brand'] as $las_brand) {
    ?>
                          <option value="<?php echo $las_brand['BRAND']; ?>" <?php// echo $selecte; ?><?php echo $las_brand['BRAND']; ?></option>
                      <?php
}
?>
                    </select>
                    </div>

                </div>
                  </div>

                </div>


                <div class="col-sm-5">
                  <label for="">MPN Description:</label><span>Maximum of 80 characters -
                    <input class="c-count" type="text" id='titlelength' name="titlelength" size="3" maxlength="3" value="80" readonly style=""> characters left</span><br/>
                  <div class="input-group input-group-md">
                    <?php
if (!empty(@$datas['update_note'][0]['MPN_DESCRIPTION'])) {
    $mpn_description = @$datas['update_note'][0]['MPN_DESCRIPTION'];
} else {
    $mpn_description = @$datas['item_history'][0]['MPN_DESCRIPTION'];
}

?>
                    <input type="text" name="mpn_description" id="mpn_description" class="form-control mpn_description"  maxlength="80" onKeyUp="textCounter(this,'titlelength' ,80)"  value="<?php echo @$mpn_description; ?>">
                    <div class="input-group-btn">
                        <button class="btn btn-info Serch_desc" title="Search on Ebay " id="Serch_desc" type="button"><i class="glyphicon glyphicon-search"></i><button class="btn btn-danger Serch_desc_sys" title="Search in System " id="Serch_desc_sys" type="button"><i class="glyphicon glyphicon-search"></i></button>
                        </div>
                   <!--  <button style="margin-top:5px;" type="button" title="Search on Ebay " id="Serch_desc" class="btn btn-success btn-xs Serch_desc"   style="height: 28px; margin-bottom: auto;">Search Description On Ebay</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button style="margin-top:5px;" type="button" title="Get Category Object" class="btn btn-danger btn-xs Serch_desc_sys"   style="height: 28px; margin-bottom: auto;">Search Description in System</button> -->
                     <!-- <div class="input-group-btn">
                        <button class="btn btn-info " id="Serch_desc" type="button"><i class="glyphicon glyphicon-search"></i></button>
                        </div> -->

                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="Special Lot Remarks" class="control-label">Remarks:</label>
                    <?php
if (!empty(@$datas['update_note'][0]['LOT_REMARKS'])) {
    $lot_remarks = @$datas['update_note'][0]['LOT_REMARKS'];
} else {
    $lot_remarks = '';
}

?>
                    <input type="text" name="up_remarks" id="up_remarks" value="<?php echo @$lot_remarks; ?>" placeholder="Enter Remarks" class="form-control up_remarks">
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="Cost" class="control-label">Average Sold Price $:</label>
                    <?php
if (!empty(@$datas['update_note'][0]['AVG_SOLD'])) {
    $avg_sold = @$datas['update_note'][0]['AVG_SOLD'];
} else {
    $avg_sold = @$datas['item_history'][0]['AVG_SOLD'];
}

?>
                    <input type="number" name="get_cost" id="get_cost" value="<?php echo @$avg_sold; ?>" placeholder="Enter Cost" class="form-control get_cost">
                  </div>
                </div>
              </div>
              <div class="col-sm-12">
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="Cost" class="control-label">Object Name:</label>
                    <?php
if (!empty(@$datas['update_note'][0]['FB_OBJECT_NAME'])) {
    $fb_object_name = @$datas['update_note'][0]['FB_OBJECT_NAME'];
} else {
    $fb_object_name = '';
}

?>
                    <input type="text" name="fb_object_name" id="fb_object_name" value="<?php echo @$fb_object_name; ?>" class="form-control fb_object_name" readonly>
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="Cost" class="control-label">EAN:</label>
                    <?php
if (!empty(@$datas['update_note'][0]['EAN'])) {

    $ean = @$datas['update_note'][0]['EAN'];
} else {
    $ean = '';
}

?>
                    <input type="text" name="ean" id="ean" value="<?php echo @$ean; ?>" class="form-control ean" readonly>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="Cost" class="control-label">Condition Remarks:</label>
                    <?php
if (!empty(@$datas['update_note'][0]['CONDITION_REMRAKS'])) {
    $condition_remraks = @$datas['update_note'][0]['CONDITION_REMRAKS'];
} else {
    $condition_remraks = '';
}

?>
                    <input type="text" name="condition_remraks" id="condition_remraks" value="<?php echo @$condition_remraks; ?>" class="form-control condition_remraks" readonly>
                  </div>
                </div>

              </div>
              <div class="col-md-12">
              <div class="col-sm-6">
                  <div class="form-group">
                    <label for="Cost" class="control-label">Barcode Notes:</label>
                    <?php
if (!empty(@$datas['update_note'][0]['BARCODE_NOTES'])) {
    $barcode_notes = @$datas['update_note'][0]['BARCODE_NOTES'];
} else {
    $barcode_notes = '';
}

?>
                    <input type="text" name="barcode_notes" id="barcode_notes" value="<?php echo @$barcode_notes; ?>" class="form-control condition_remraks" readonly>
                  </div>
                </div>
                   </div>

              <div class="col-md-12">
                <?php //if ($employee_location == 'PK') { ?>
                      <!-- <div class="col-sm-3">
                        <div class="form-group">
                          <label for="Lot Condition" class="cotrol-label">Condition:</label>
                            <?php
//foreach ($data['conds'] as $cond) {
// if ($cond['ID'] == @$datas['item_history'][0]['CONDITION_ID']) { ?>
                                <input  type="hidden" class="form-control" id="up_cond_item" name="up_cond_item" value="<?php //echo $cond['ID']; ?>">
                                <input  type="text" class="form-control" id="item_condition" name="item_condition" value="<?php //echo $cond['COND_NAME']; ?>" readonly>          -->
                            <?php // } // if closing

// } //foreach closing
?>
                       <!--  </div>
                      </div> -->
                   <?php // }else{ ?>
                <div class="form-group p-t-24">
                <label for="Packing Type" class="cotrol-label">Conditions:</label>
                   <div class="btn-group btn-group-horizontal " data-toggle="buttons">
                    <?php
foreach ($data['conds'] as $cond) {
    if ($cond['ID'] == @$datas['update_note'][0]['CONDITION_ID']) {
        $checked = 'checked="checked"';
    } else {
        $checked = "";
    }

    ?>
                          <label class="btn ">
                          <input type="radio" naem ="get_my_old_cond" id ="get_my_old_cond" class="radioBtnClass" value="<?php echo $cond['ID']; ?>" <?php echo $checked; ?> ><i class="fa fa-circle-o fa-2x" style="font-size: 1em;"></i><i class="fa fa-dot-circle-o fa-2x" style="font-size: 1em; "></i> <span><?php echo $cond['COND_NAME']; ?></span>
                        </label>
                      <?php
}
?>
                  </div>
                </div>
                <?php //} //location else closing ?>
                <!-- apended condition -->







                <div class="form-group  p-t-24" >
                  <label for="Packing Type" class="cotrol-label">Available Conditions:</label>
                  <div id ="apnd_radi">

                  </div>

                </div>
                <!-- apended condition end -->













              </div>
              <div class="col-sm-12">
                <div class="col-sm-2 pull-right">
                  <div class="form-group">
                    <input  type="button" class="btn btn-success" id="add_onupdate_save" name="add_onupdate_save" value="Update">
                  </div>
                </div>

                <div class="col-sm-2 pull-right">
                  <div class="form-group">
                    <input  type="button" class="btn btn-info" id="upd_remar_only" name="upd_remar_only" value="Update Remarks">
                  </div>
                </div>
              </div>

              <div class="col-sm-12">
                <!-- Category Result -->
                  <div id="my_history">
                  </div>
                  <div id="my_Categories_result">
                  </div>
                  <!-- Category Result -->
              </div>
              <!--- start image loading box -->
             <!--  <div class="col-sm-12">
               <div class="col-sm-1 pull-right">
                 <div class="form-group">
                   <input  type="submit" class="btn btn-success" id="add_onupdate_save" name="add_onupdate_save" value="Save">
                 </div>
               </div>
             </div> -->
          <!-- </form> -->
      </div> <!--body-->
     </div><!--box -->
       <!--- start image loading box -->

      <div class="box" id ="addPicsBox">
        <div class="box-header">
          <h3 class="box-title">Add Pictures</h3>
        </div>
        <div class="box-body">
        <div class="row">
          <div class="col-sm-12">
            <div class="col-sm-12">
              <label>Picture Notes:</label>
              <?php
if (!empty(@$datas['update_note'][0]['PIC_NOTES'])) {
    $pic_notes = @$datas['update_note'][0]['PIC_NOTES'];
} else {
    $pic_notes = '';
}

?>
              <div class="form-group">
                <textarea name="pic_notes" id="pic_notes" value="<?php echo @$pic_notes; ?>" cols="30" rows="4" class="form-control"><?php echo @$pic_notes; ?></textarea>
              </div>
            </div>
              <!-- <div class="col-sm-2">
                <input type="button" name="saveTextArea" id="saveTextArea" class="btn btn-sm btn-primary" value="Save Notes" />
              </div>
              <div class="col-sm-6" id="saveNoteMessage">

              </div> -->
          </div>
         <div class="col-sm-12">
            <div class="col-sm-12 p-b">
                <label for="Live Pictures From PhotoLab">Master Pictures:</label>
                <div id="" class="col-sm-12 b-full">
                  <div id="" class="col-sm-12 p-t">
                   <ul id="live_pics" class="docs-pictures clearfix" style="height: 140px !important; list-style: none; white-space: nowrap; position: relative; padding: 0; margin: 0; vertical-align: top; left: 0; width: 100%;">
                      <?php
$path = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 5");
$path = $path->result_array();
$master_path = $path[0]["MASTER_PATH"];
//var_dump($dir); exit;
$dir = $master_path;
$dir = preg_replace("/[\r\n]*/", "", $dir);
// Open a directory, and read its contents
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        $i = 1;
        while (($file = readdir($dh)) !== false) {
            $parts = explode(".", $file);
            if (is_array($parts) && count($parts) > 1) {
                $extension = end($parts);
                //var_dump($extension);exit;
                if (!empty($extension)) {
                    ?>
                                <li id="<?php //echo $im->ITEM_PICTURE_ID;?>" style="width: 105px; height: 125px; background: #eee; float: left; overflow: hidden; text-align: center; position: relative; padding: 3px;">
                                  <span class="tg-li">
                                    <div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);cursor: pointer!important;">
                                        <?php
//$url = 'D:/item_pictures/master_pictures/'.@$row['UPC'].'~'.$mpn.'/'.@$it_condition.'/'.$parts['0'].'.'.$extension;
                    //$master_path = $data['path_query'][0]['MASTER_PATH'];
                    $url = $master_path . '/' . $parts['0'] . '.' . $extension;
                    $image_name = $parts['0'] . '.' . $extension;
                    $url = preg_replace("/[\r\n]*/", "", $url);
                    $img = file_get_contents($url);
                    $img = base64_encode($img);
                    echo '<img class="sort_img up-img zoom_01" id="" name="" src="data:image;base64,' . $img . '"/>';?>
                                          <input type="hidden" name="img_<?php echo $i ?>" value="<?php echo $url; ?>">
                                    </div>
                                    <input type="radio" name="mpn_picture" id="mpn_picture" value="MPN_" pic_name="<?php echo $image_name; ?>" title="MPN Picture">
                                    <span class="d_live_spn">
                                      <i title="Delete Picture" style="" id="<?php echo $url; ?>" class="fa fa-trash delSpecificLivePictures"></i>
                                    </span>
                                  </span>
                                </li>
                              <?php
//echo '<img style ="width:250px;" src="./images/'.$parts['0'].'.'.$extension.'" /><br />';
                }
            }
        } //while closing
        closedir($dh);
    }
}
?>
                </ul>
                  </div>
                  <div class="col-sm-12">
                    <div class="col-sm-1">
                      <div class="form-group">
                        <input class="btn btn-sm btn-success save_pics" title="Save" type="button" id="save_pics_master" name="save_pics_master" value="Save">
                      </div>
                    </div>
                    <div class="col-sm-9">
                      <div id="pics_insertion_msg">
                      </div>
                    </div>
                     <div class="col-sm-4">
                      <div class="form-group pull-right">
                        <input class="btn btn-sm btn-primary syncPictures"  title="Sync PS1 Pictures" type="submit" id="syncPictures" name="syncPictures" value="PS1" style="margin-right: 5px;">
                        <input class="btn btn-sm btn-primary syncPictures"  title="Sync PS2 Pictures" type="submit" id="syncPictures" name="syncPictures" value="PS2" style="margin-right: 5px;">
                        <input class="btn btn-sm btn-danger delLivePictures" title="Delete Live Pictures" type="button" id="delLivePictures" name="delLivePictures" value="Delete All">
                      </div>
                    </div>
                  </div>
                </form>
                </div>
            </div>
          </div>
          <div class="col-sm-12 ">
            <div id="drop-img-area" class="col-sm-12 p-b">
              <label for="">Upload Pictures:</label>
              <div id="" class="col-sm-12 b-full">
                <div class="col-sm-2">
                  <div  class="commoncss">
                    <h4>Drag / Upload image!</h4>
                    <div class="uploadimg">
                     <form id="frmupload" enctype="multipart/form-data">
                        <input type="file" multiple="multiple" name="dekit_image[]" id="dekit_image" style="display:none"/>
                        <span id="btnupload_img" style=" font-size: 2.5em; margin-top: 0.7em; cursor: pointer;" class="fa fa-cloud-upload"></span>
                        </form>
                    </div>
                  </div>
                </div>
                <div id="" class="col-sm-12 p-t">
                  <ul id="sortable" class="docs-pictures clearfix" style="height: auto !important; width: 100%;">
                    <?php
$barcode_prv = $this->uri->segment(5);
$get_folder = $this->db->query("SELECT L.FOLDER_NAME FROM LZ_SPECIAL_LOTS L WHERE L.BARCODE_PRV_NO = $barcode_prv")->result_array();
$folder_name = $get_folder[0]['FOLDER_NAME'];

$master_path = '';
$master = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 5")->result_array();
$master_path = $master[0]["MASTER_PATH"];
$dir = $master_path . $folder_name;
//var_dump($dir);
//exit;
$dir = preg_replace("/[\r\n]*/", "", $dir);
// Open a directory, and read its contents
if (is_dir($dir)) {

    if ($dh = opendir($dir)) {
        $i = 1;
        while (($file = readdir($dh)) !== false) {
            $parts = explode(".", $file);
            if (is_array($parts) && count($parts) > 1) {

                $extension = end($parts);
                //var_dump($extension);exit;
                if (!empty($extension)) {
                    $url = $master_path . $folder_name . '/' . $parts['0'] . '.' . $extension;
                    $image_name = $parts['0'] . '.' . $extension;
                    // Find MPN from Image Name
                    $mystring = $image_name;
                    $findme = 'MPN';
                    $pos = strpos($mystring, $findme);
                    //var_dump($pos);
                    ?>
                                  <li id="<?php echo $image_name; ?>" style="width: 200px; height: 230px; background: #eee!important; float: left; overflow: hidden; text-align: center; position: relative; padding: 3px; margin:5px;">
                                    <span class="tg-li">
                                      <div class="thumb imgCls" style="<?php if (@$pos !== false) {echo 'border: 5px solid #00a65a !important;';} else {echo 'border: 2px solid rgb(55, 152, 198) !important;';}?> display: block; width:180px; height:180px; background: #eee!important; margin:5px;">
                                          <?php
$url = preg_replace("/[\r\n]*/", "", $url);
                    $img = file_get_contents($url);
                    $img = base64_encode($img);
                    echo '<img class="sort_img up-img zoom_01 north" id="' . $url . '" name="" src="data:image;base64,' . $img . '"/>';?>
                                            <input type="hidden" name="img_<?php echo $i ?>" value="<?php echo $url; ?>">
                                          <!-- </div> -->
                                          <div class="text-center" style="width: 100px;">
                                            <span class="thumb_delete" style="float: left;">
                                              <i title="Move Picture Order" style="padding: 3px;" class="fa fa-arrows" aria-hidden="true"></i>
                                            </span>
                                            <span class="d_spn" style="float: left;"><i title="Delete Picture" style="padding: 3px;" id="<?php echo $url; ?>" class="fa fa-trash specific_delete"></i></span>
                                            <span class="d_spn" style="float: left; margin-top: 5px;"><i title="Rotate Pic" style="padding: 2px;"  class="fa fa-repeat rot_my_pic_lot"></i></span>
                                            <span class="d_spn" style="float: left; margin-top: -23px;  margin-left: 139px;"><i title="Save Image" style="padding: 2px;"  class="fa fa-check save_img_lot"></i></span>
                                            <input style="float: right; margin-top:-15px" type="radio" name="mpn_picture" id="mpn_picture" value="MPN_" pic_name="<?php echo $image_name; ?>" title="MPN Picture" <?php if (@$pos !== false) {echo 'checked';}?>>
                                           
                                            <!--  -->
                                          </div>
                                          </div>
                                        </span>
                                      </li>
                                    <?php
//echo '<img style ="width:250px;" src="./images/'.$parts['0'].'.'.$extension.'" /><br />';
                }
            }
        } //while closing
        closedir($dh);
    }
}
?>

                  </ul>
                  <input type="hidden" name="barcode_prv" id="barcode_prv" value = "<?php echo $folder_name; ?>"/>
                  <div id="" class="col-sm-10 p-t">
                  </div>
                  <div class="col-sm-12 " style="padding-left:0px !important;padding-right:0px !important;">
                  <div class="col-sm-8" id="">
                    <div id="upload_message">
                      </div>
                      <div class="alert success pull-right" style="font-size:16px;color:green;font-weight:600;"></div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group pull-right">
                        <input class="btn btn-sm btn-success" style="margin-right: 5px;" type="button" name="mark_mpn" id="mark_mpn" title="Mark as MPN" value="Mark MPN">
                        <input id="master_reorder_dekit" style="margin-right: 5px;" class="btn btn-sm btn-primary" title="Sort or Re-arrange Picture Order" type="button" name="update_order" value="Update Order">
                          <span><i id="" title="Delete All Pictures" class="btn btn-sm btn-danger del_master_all_dekit">Delete All</i></span>
                      </div>
                    </div><!--</form>-->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div> <!-- row -->
      </div> <!--body-->
     </div><!--box -->
      <!-- //////////////////////////////////////////// -->
      <!-- Dynamic table append input rows Barcode Detail Table Start  -->
      <!-- Dynamic table append input rows Barcode Detail Table end  -->
      <!-- Barcode Detail Table Start  -->
    </section>
      <div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
      <img align="center" src="<?php echo base_url() . 'assets/images/ajax-loader.gif' ?>" alt="ajax loader" style="width: 100px; height: 100px;">
    </div>
  </div>
<!-- End Listing Form Data -->
<?php $this->load->view('template/footer');?>
<script text="javascript">
//   document.getElementById("myForm").onkeypress = function(e) {
//   var key = e.charCode || e.keyCode || 0;
//   if (key == 13) {
//     //alert("I told you not to, why did you do it?");
//     e.preventDefault();
//   }
// }


 //image rotation functions strt
$(document).on('click','.rot_my_pic_lot',function(){

//return false;
 //$(".rot_my_pic_seed_seed").click(function(){

 var img = $(this).parents('.imgCls').find('img');


    if(img.hasClass('north')){
        img.attr('class','west');
        img.attr('stat_rot','270');

    }else if(img.hasClass('west')){
        img.attr('class','south');
        img.attr('stat_rot','180');
    }else if(img.hasClass('south')){
        img.attr('class','east');
        img.attr('stat_rot','90');
    }else if(img.hasClass('east')){
        img.attr('class','north');
        img.attr('stat_rot','0');
    }

  });
  $(".save_img_lot").click(function(){
    $(".loader").show();
    var get_pic = $(this).parents('.imgCls').find('img').attr('src');
    var get_url = $(this).parents('.imgCls').find('img').attr('id');
    var stat_rot = $(this).parents('.imgCls').find('img').attr('stat_rot');
    //var child_barcode = $('#child_barcode').val();
    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>item_pictures/c_item_pictures/sav_my_pic',
      data: { 'get_pic' : get_pic,'get_url' : get_url ,'stat_rot' : stat_rot 
    },
     success: function (data) {
      $(".loader").hide();
      console.log(data);
      if(data == 'true'){
        alert("Picture Saved");
        return false;
      }else{
        alert("error");
        return false;
      }   
      }
      });  
});
  var tableData = '';
    $(document).ready(function(){
      $('#dyn_box').hide();
      $('#dyn_box2').hide();
  //   $(window).keydown(function(event){
  //   if(event.keyCode == 13) {
  //     event.preventDefault();
  //     return false;
  //   }
  // });
      //$('#dyn_box3').hide();
      //loadFirstRow();
     /* $("#dekit_image").change(function(){
        var postData = new FormData($("#frmupload")[0]);
        uploadDekitFormData(postData);
      });*/
    });
    /*=====  End of Reorder  ======*/

function loadFirstRow(){
  var l=0;
  $("#update_add").prop("disabled", true);

  var up_bin_id = $('#up_bin_rack'+l).val();

  var category = $('#it_cat').val();
  // var url='<?php echo base_url() ?>dekitting_pk_us/c_dekitting_us/save_mast_barcode';
    var obj = [];
      $.ajax({
        url:'<?php echo base_url(); ?>catalogueToCash/c_card_lots/obj_dropdown',
        type:'post',
        dataType:'json',
        data:{'category':category},
        success:function(data){
        obj = [];
        bin = [];
        conditions = [];
       // alert(data.length);return false;
       /////////////////////////////////////
        for(var j = 0;j<data.obj.length;j++){
        obj.push('<option value="'+data.obj[j].OBJECT_ID+'">'+data.obj[j].OBJECT_NAME+'</option>')
        }
        ////////////////////////////////////

        for(var k = 0;k<data.bin.length;k++){
        bin.push('<option value="'+data.bin[k].BIN_ID+'">'+data.bin[k].BIN_NO+'</option>')
        }

        /////////////////////////////////////
        /////////////////////////////////////
         for(var k = 0;k<data.bin.length; k++){
            if (data.bin[k].BIN_ID == up_bin_id) {
              var bin_selected = "selected";
            }else{
              var bin_selected = "";
            }
            bin.push('<option value="'+data.bin[k].BIN_ID+'" '+bin_selected+'>'+data.bin[k].BIN_NO+'</option>');
        }
        ////////////////////////////////////////
        /////////////////////////////////////
         for(var k = 0;k<data.conds.length;k++){
            if (data.conds[k].ID == 3000) {
              var bin_selected = "selected";
            }else{
              var bin_selected = "";
            }
            conditions.push('<option value="'+data.conds[k].ID+'" '+bin_selected+'>'+data.conds[k].COND_NAME+'</option>');
        }
        ////////////////////////////////////////
        //console.log(bin);
        $('#tab_add_onupdate').append('<tr><td style="width:60px;"><div style="width:60px;"><input type="number" class="form-control dynamic" id="sr_no'+l+'" name="sr_no" value=""  readonly></div></td><td style="width:140px;"><div style="width:140px;"><input type="text" class="form-control card_upc" id="card_upc_'+l+'" name="card_upc" value="" style="width:140px;"></div></td><td style="width:140px;"><div style="width:140px;"><input type="text" class="form-control card_mpn" id="card_mpn_'+l+'" name="card_mpn" value="" style="width:140px;"></div></td><td style="width:200px;"><div style="width:200px;"> <select id="up_cond_item'+l+'" style="width:200px;" name="up_cond_item" class="form-control up_cond_item">'+conditions.join("")+'</select> </div> </td><td style="width:270px;"><div style="width:270px;"><select class="form-control up_object_desc" style="width:270px;" data-live-search ="true" id="up_object_desc'+l+'" name="up_object_desc" >'+obj.join("")+'</select> </div></td> <td><button class="btn btn-primary btn-sm upload_card_img" id="upload_card_img">Uplaod Image</td> <td style="width:140px;"><div style="width:140px;"> <select class="form-control up_bin_rack" data-live-search ="true" id="up_bin_rack'+l+'"  name="up_bin_rack" style="width:140px;">'+bin.join("")+'</select></div></td><td><div style="float:left;margin-right:8px;"><a href="" title="Print Sticker" class="btn btn-primary btn-sm" target="_blank"> <span class="glyphicon glyphicon-print" aria-hidden="true"></span> </a> </div></td><td style="width:340px;"><div style="width:340px;"><input type="text" class="form-control up_remarks" id="up_remarks'+l+'"  name="up_remarks" style="width:340px;"></div></td><td style="width:30px;"><div style="width:30px;"><button type="button" name="remove"  style="width:30px;" id="button'+l+'" class="btn btn-sm btn-danger btn_remove fa fa-trash-o"></button></div></td></tr>');
         //$('.up_cond_item').selectpicker();
         $('.up_object_desc').selectpicker();
         $('.up_bin_rack').selectpicker();
          $("#update_add").prop("disabled", false);

         //function for adding serial no against class name dynamic start
         $('.dynamic').each(function(idx, elem){
          $(elem).val(idx+1);
          // console.log($(elem).val(idx+1));

        });//function for adding serial no against class name dynamic end
        $(".loader").hide();
      }
      });
  l++;
}
  /*=========================================================
  function on add button for append new field for input start on update add
  ===========================================================*/
 var l=0;
 $('#update_add').on('click',function(){
  $("#update_add").prop("disabled", true);

  var up_bin_id = $('#up_bin_rack'+l).val();

  var category = $('#it_cat').val();
  // var url='<?php echo base_url() ?>dekitting_pk_us/c_dekitting_us/save_mast_barcode';
    var obj = [];
      $.ajax({
        url:'<?php echo base_url(); ?>catalogueToCash/c_card_lots/obj_dropdown',
        type:'post',
        dataType:'json',
        data:{'category':category},
        success:function(data){
        obj = [];
        bin = [];
        conditions = [];
       // alert(data.length);return false;
        for(var j = 0;j<data.obj.length;j++){
        obj.push('<option value="'+data.obj[j].OBJECT_ID+'">'+data.obj[j].OBJECT_NAME+'</option>')
        }

        for(var k = 0;k<data.bin.length;k++){
        bin.push('<option value="'+data.bin[k].BIN_ID+'">'+data.bin[k].BIN_NO+'</option>')
        }
         for(var k = 0;k<data.bin.length;k++){
          if (data.bin[k].BIN_ID == up_bin_id) {
            var bin_selected = "selected";
          }else{
            var bin_selected = "";
          }
        bin.push('<option value="'+data.bin[k].BIN_ID+'" '+bin_selected+'>'+data.bin[k].BIN_NO+'</option>');

        }

        ////////////////////////////////////////
        ////////////////////////////////////////
         for(var k = 0;k<data.conds.length;k++){
            if (data.conds[k].ID == 3000) {
              var bin_selected = "selected";
            }else{
              var bin_selected = "";
            }
            conditions.push('<option value="'+data.conds[k].ID+'" '+bin_selected+'>'+data.conds[k].COND_NAME+'</option>');
        }
        ////////////////////////////////////////
        //console.log(bin);
        $('#tab_add_onupdate').append('<tr><td style="width:60px;"><div style="width:60px;"><input type="number" class="form-control dynamic" id="sr_no'+l+'" name="sr_no" value=""  readonly></div></td><td style="width:140px;"><div style="width:140px;"><input type="text" class="form-control card_upc" id="card_upc_'+l+'" name="card_upc" value="" style="width:140px;"></div></td><td style="width:140px;"><div style="width:140px;"><input type="text" class="form-control card_mpn" id="card_mpn_'+l+'" name="card_mpn" value="" style="width:140px;"></div></td><td style="width:200px;"><div style="width:200px;"> <select id="up_cond_item'+l+'" style="width:200px;" name="up_cond_item" class="form-control up_cond_item">'+conditions.join("")+'</select> </div> </td><td style="width:270px;"><div style="width:270px;"><select class="form-control up_object_desc" style="width:270px;" data-live-search ="true" id="up_object_desc'+l+'" name="up_object_desc" >'+obj.join("")+'</select> </div></td> <td><button class="btn btn-primary btn-sm upload_card_img" id="upload_card_img">Uplaod Image</td> <td style="width:140px;"><div style="width:140px;"> <select class="form-control up_bin_rack" data-live-search ="true" id="up_bin_rack'+l+'"  name="up_bin_rack" style="width:140px;">'+bin.join("")+'</select></div></td><td><div style="float:left;margin-right:8px;"><a href="" title="Print Sticker" class="btn btn-primary btn-sm" target="_blank"> <span class="glyphicon glyphicon-print" aria-hidden="true"></span> </a> </div></td><td style="width:340px;"><div style="width:340px;"><input type="text" class="form-control up_remarks" id="up_remarks'+l+'"  name="up_remarks" style="width:340px;"></div></td><td style="width:30px;"><div style="width:30px;"><button type="button" name="remove"  style="width:30px;" id="button'+l+'" class="btn btn-sm btn-danger btn_remove fa fa-trash-o"></button></div></td></tr>');

         //$('.up_cond_item').selectpicker();
         $('.up_object_desc').selectpicker();
         $('.up_bin_rack').selectpicker();
          $("#update_add").prop("disabled", false);

         //function for adding serial no against class name dynamic start
         $('.dynamic').each(function(idx, elem){
          $(elem).val(idx+1);
          // console.log($(elem).val(idx+1));

        });//function for adding serial no against class name dynamic end
        $(".loader").hide();
      }
      });
        l++;

});// function on add button for append new field for input on update add end

 /*=========================================================
  save buton for insert dynamic_tab_dekit table values into table LZ_DEKIT_US_MT and LZ_DEKIT_US_DT  start
  ===========================================================*/

 //save buton for insert dynamic_tab_dekit table values into table LZ_DEKIT_US_MT and LZ_DEKIT_US_DT  end
    // get master barcode info on blur start
    //**************************************
 $(document).on('blur','#master_barcode', function(){
    var master_barcode = $(this).val();
    if(master_barcode == ''){
      //alert('Please Enter Barcode');
      $('#errorMessage').html("");
        $('#errorMessage').append('<p style="color:#c62828; font-size :18px;"><strong>Warning: Please Enter Barcode No !</strong></p>');
        // $('#errorMessage').append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Warning: Please Enter Tracking # !</strong>');
         $('#errorMessage').show();
        setTimeout(function() {
          $('#errorMessage').fadeOut('slow');
        }, 1800);
      $(".loader").hide();
      return false;
    }else{
    //$(".loader").show();
     $.ajax({
            type: 'POST',
            dataType: 'json',
            url:'<?php echo base_url(); ?>dekitting_pk_us/c_dekitting_us/master_barcode_det',
            data:{
                  'master_barcode' : master_barcode
                  },
           success: function (data) {
            $(".loader").hide();
            console.log(data);
            if(data){
              var det =data.master_bar[0].ITEM_MT_DESC;
            var cond_seg =data.master_bar[0].CONDITIONS_SEG5;
            var mpn =data.master_bar[0].ITEM_MT_MFG_PART_NO;
            var it_cat =data.master_bar[0].CATEGORY_ID;
              $("#item_detail").val(det);
              $("#it_cond").val(cond_seg);
              $("#item_mpn").val(mpn);
              $("#it_cat").val(it_cat);
          }else{
            $("#item_detail").val(det);
              $("#it_cond").val(cond_seg);
              $("#item_mpn").val(mpn);
              $("#it_cat").val(it_cat);
          }

        }

      //     }, //success
      //    complete: function(data){
      //   $(".loader").hide();
      // }
    }); ///ajax call
   }
  });// get master barcode info on blur End
    //**************************************

//function to remove row on button class btn_remove start
       $(document).on('click','.btn_remove',function(){
          var row = $(this).closest('tr');
          var dynamicValue = $(row).find('.dynamic').val();
          dynamicValue = parseInt(dynamicValue);
          row.remove();
            // again call serial no function when row delete for keep serial no
            $('.dynamic').each(function(idx, elem){
              $(elem).val(idx+1);
            });
        });
//function to remove row on button class btn_remove start


 /*=========================================================
  save buton for insert dynamic_tab_dekit table values into table LZ_DEKIT_US_MT and LZ_DEKIT_US_DT  start
  ===========================================================*/
 $('#dynamic-tab-save').on('click', function(){
  var arr=[];
  var cond_item =[];
  var object_desc =[];
  var bin_rack =[];
  var remarks =[];
  var weight_in =[];

  var count_table_rows= $("body #dynamic_tab_dekit tr").length;
  var count_rows = count_table_rows+1;
  var tableId= "dynamic_tab_dekit";
  // console.log(tableId-1);
  // return false;
  var tdbk = document.getElementById(tableId);

  for (var i = 0; i < count_rows; i++){
            //compName.push($(tdbk.rows[arr[i]].("#ct_kit_mpn_id_"+(i+1))).val());
            $(tdbk.rows[i]).find(".cond_item").each(function() {
              if($(this).val() != ""){
              cond_item.push($(this).val());
            }
            });
            $(tdbk.rows[i]).find(".object_desc").each(function() {
              if($(this).val() != ""){
              object_desc.push($(this).val());
            }
            });
            $(tdbk.rows[i]).find(".weight_in").each(function() {
              //if($(this).val() != ""){
              weight_in.push($(this).val());
            //}
            });
            $(tdbk.rows[i]).find(".bin_rack").each(function() {
              if($(this).val() != ""){
              bin_rack.push($(this).val());
            }
            });

            $(tdbk.rows[i]).find('.remarks').each(function() {
             // if($(this).val() != ""){
              remarks.push($(this).val());
            //}
            });
          }

  var master_barcode = $('#master_barcode').val();
  var url='<?php echo base_url() ?>dekitting_pk_us/c_dekitting_us/save_mast_barcode';
  $(".loader").show();
  $.ajax({
          type: 'POST',
          url:url,
          data: {
            'cond_item': cond_item,
            'object_desc': object_desc,
            'bin_rack': bin_rack,
            'weight_in': weight_in,
            'remarks': remarks,
            'master_barcode': master_barcode
          },
          dataType: 'json',
          success: function (data){
              if(data == true){
                $(".loader").hide();
                  alert('Components added Successfully!');
                  $('#dyn_box').hide();
                   $('#dynamic_tab_body').html("");
                   $('#dyn_box2').show();
                  show_master_detail();

                }else{
              alert('data not saved');

             }

           }
      });
 });//save buton for insert dynamic_tab_dekit table values into table LZ_DEKIT_US_MT and LZ_DEKIT_US_DT  end

/*=========================================================================
=           Function for append detail in table of saved barcode Start    =
=========================================================================*/
 function show_master_detail(){

            $('#dyn_box3').show();

           var master_barcode = $('#master_barcode').val();
           console.log(master_barcode);

             $.ajax({
                url: '<?php echo base_url(); ?>dekitting_pk_us/c_pic_shoot_us/showMasterDetails',
                type: 'post',
                dataType: 'json',
                data : {'master_barcode':master_barcode},
                success:function(data){
                  if(data.res == 2){
                  console.log('success:function');
                  var arr = [];
                  for(var i=0;i<data.det.length;i++){
                    var j = i + 1;
                    var cond = '';
                    if(data.det[i].CONDITION_ID == 1000){
                      cond = 'New';
                    }
                    if(data.det[i].CONDITION_ID == 3000){
                      cond = 'Used';
                    }
                    if(data.det[i].CONDITION_ID == 1500){
                      cond = 'New Other';
                    }
                    if(data.det[i].CONDITION_ID == 2000){
                      cond = 'Manufacturer refurbished';
                    }
                    if(data.det[i].CONDITION_ID == 2500){
                      cond = 'Seller refurbished';
                    }
                    if(data.det[i].CONDITION_ID == 7000){
                      cond = 'For parts or not working';
                    }
                     var dekit = data.det[i].DEKIT_REMARKS;
                      if( typeof dekit == 'object'){
                        dekit = JSON.stringify(dekit);
                        dekit = '';
                        // alert(dekit);
                      }
                      if( dekit !== ''){
                        dekit = dekit.replace(/"/g, "'");

                      }
                      console.log(dekit);

                    arr.push('<tr> <td style="width:60px;"><div style="width:60px;"><input type="number" class="form-control dynamic_up" id="sr_no2'+i+'" name="sr_no2" value=""  readonly></div></td><td><div style="width:100px;" class="p-t-5"><button class="btn btn-xs btn-danger delete_spec" id="delete_'+data.det[i].LZ_DEKIT_US_DT_ID+'" style="margin-left: 2px;"><span class="glyphicon glyphicon-trash " aria-hidden="true"></span></button><button class="btn btn-xs btn-warning edit_spec" id="edit_'+data.det[i].LZ_DEKIT_US_DT_ID+'" style="margin-left: 2px;"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button><a style="margin-left: 3px;" href="<?php echo base_url(); ?>dekitting_pk_us/c_dekitting_us/print_single_us_pk/'+data.det[i].LZ_DEKIT_US_DT_ID+'" class="btn btn-primary btn-xs" target="_blank"> <span class="glyphicon glyphicon-print" aria-hidden="true"></span> </a></div></td> <td><div style="width:200px;"><input type="text" id="barcode_no'+i+'" class="form-control barcode_no" value="'+data.det[i].BARCODE_PRV_NO+'" readonly></div></td><td><div style="width:200px;"><input type="text" id="obj_name'+i+'" class="form-control obj_name" value="'+data.det[i].OBJECT_NAME+'" readonly></div></td><td><div style="width:200px;"><input type="text" id="condition'+i+'" class="form-control condition" value="'+cond+'" readonly></div></td><td><div style="width:200px;"><input type="text" id="weight'+i+'" class="form-control weight" value="'+data.det[i].WEIGHT+'" readonly></div></td><td><div style="width:200px;"><input type="text" id="binRack_no'+i+'" class="form-control binRack_no" value="'+data.det[i].BIN_NO+'" readonly></div></td><td><div style="width:200px;"><input type="text" id="det_ramarks'+i+'" class="form-control det_ramarks" value="'+dekit+'" readonly></div></td> </tr>');

                  }

                  $('#table_body ').html("");

                 $('#table_body ').append(arr.join(""));
                 //function for adding serial no against class name dynamic start
         $('.dynamic_up').each(function(idx, elem){
          $(elem).val(idx+1);
          // console.log($(elem).val(idx+1));
        });//function for adding serial no against class name dynamic end

        //arr = '';
                  $(".loader").hide();
                }
              }
            });
          }
/*=======================================================================
=           Function for append detail in table of saved barcode End    =
=========================================================================*/
$(document).on('blur','#master_barcode', function(){
//$(document).on('click','#search_m_barcode',function(){
  $('#dynamic_tab_body').html('');
  var master_barcode = $('#master_barcode').val();
  //console.log(master_barcode);
  //tableData.destroy();
  $(".loader").show();
      $.ajax({
      url: '<?php echo base_url(); ?>dekitting_pk_us/c_pic_shoot_us/showMasterDetails',
      type: 'post',
      dataType: 'json',
      data : {'master_barcode':master_barcode},
      success:function(data){
        $(".loader").hide();
        if(data == 1){
        console.log('add barcode function');

        $('#dyn_box').show();
        $('#dyn_box2').hide();
        $('#dyn_box3').hide();
  /*=========================================================
  function on add button for append new field for input start
  ===========================================================*/
 var i=0;
 $('#add').on('click',function(){
  $("#add").prop("disabled", true);
  var category = $('#it_cat').val();
  var binId = $('#bin_rack'+i).val();
  console.log(binId,'#bin_rack'+i);
  // var url='<?php //echo base_url() ?>dekitting_pk_us/c_dekitting_us/save_mast_barcode';
    var obj = [];
      $.ajax({
        url:'<?php echo base_url(); ?>dekitting_pk_us/c_dekitting_us/obj_dropdown',
        type:'post',
        dataType:'json',
        data:{'category':category},
        success:function(data){
          //console.log(data.rack_bin_id); return false;
        obj = [];
        bin = [];

        for(var j = 0;j<data.obj.length;j++){
        obj.push('<option value="'+data.obj[j].OBJECT_ID+'">'+data.obj[j].OBJECT_NAME+'</option>')

        }
        for(var k = 0;k<data.bin.length;k++){
          if (data.bin[k].BIN_ID == binId) {
            var bin_selected = "selected";
          }else{
            var bin_selected = "";
          }
        bin.push('<option value="'+data.bin[k].BIN_ID+'" '+bin_selected+'>'+data.bin[k].BIN_NO+'</option>');
        }
        //console.log(bin);
        $('#dynamic_tab_dekit').append('<tr><td style="width:60px;"><div style="width:60px;"><input type="number" class="form-control dynamic" id="sr_no'+i+'" name="sr_no" value=""  readonly></div></td><td style="width:260px;"><div style="width:260px;"> <select id="cond_item'+i+'" style="width:260px;" name="cond_item" class="form-control cond_item" data-live-search ="true"><option value="3000">Used</option><option value="1500">New other</option><option value="2000">Manufacturer refurbished</option><option value="2500">Seller refurbished</option><option value="1000">New</option><option value="7000">For parts or not working</option></select> </div> </td><td style="width:270px;"><div style="width:270px;"><select class="form-control object_desc" style="width:270px;" data-live-search ="true" id="object_desc'+i+'" name="object_desc" >'+obj.join("")+'</select> </div></td> <td style="width:140px;"><div style="width:140px;"><input type="number" class="form-control weight_in" id="weight_in'+i+'" name="weight_in" value="0" style="width:140px;"></div></td><td style="width:140px;"><div style="width:140px;"> <select class="form-control bin_rack" id="bin_rack'+i+'"  data-live-search ="true" name="bin_rack" style="width:140px;">'+bin.join("")+'</select></div></td><td style="width:340px;"><div style="width:340px;"><input type="text" class="form-control remarks" id="remarks'+i+'"  name="remarks" style="width:340px;"></div></td><td style="width:30px;"><div style="width:30px;"><button type="button" name="remove"  style="width:30px;" id="button'+i+'" class="btn btn-sm btn-danger btn_remove fa fa-trash-o"></button></div></td></tr>');

         $('.cond_item').selectpicker();
         $('.object_desc').selectpicker();
         $('body .bin_rack').selectpicker();
         $("#add").prop("disabled", false);

          // var e = document.getElementById("#bin_rack");
          // var strUser = e.options[e.selectedIndex].value;
          // console.log(strUser);
          // var get = $('#bin_rack').val();
          // console.log(get);
          // function for adding serial no against class name dynamic start

         $('.dynamic').each(function(idx, elem){
          $(elem).val(idx+1);
          // console.log($(elem).val(idx+1));

          });//function for adding serial no against class name dynamic end
          $(".loader").hide();
      }
      });
      i++;
    });// function on add button for append new field for input end
  }else if(data == 3){
      //alert('Please Enter Barcode');
        $('#errorMessage').html("");
        $('#errorMessage').append('<p style="color:#c62828; font-size :18px;"><strong>Warning: Invalid Barcode No! Try another Barcode</strong></p>')
        // $('#errorMessage').append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Warning: Please Enter Tracking # !</strong>');
         $('#errorMessage').show();
        setTimeout(function() {
          $('#errorMessage').fadeOut('slow');
        }, 1800);
        $('#dyn_box').hide();
        $('#dyn_box2').hide();
        $('#dyn_box3').hide();
        console.log('invalid barcode function');
        return false;
      }else if(data.res == 2){
            console.log('update barcoe function');
            $('#errorMessage').html("");
            $('#errorMessage').append('<p style="color:#c62828; font-size :18px;"><strong>Barcode No Already Dekited</strong></p>')
            // $('#errorMessage').append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Warning: Please Enter Tracking # !</strong>');

             $('#errorMessage').show();
            setTimeout(function() {
              $('#errorMessage').fadeOut('slow');
            }, 1800);
            $('#dyn_box').hide();
            //$('#table_body').html('');
            $('#dyn_box2').show();

            $(".loader").show();
            show_master_detail();// call function which get's records against master barcode
          }
        }
      });
    });

// class = .delete_spec button for deleting records start
//*******************************************************
$(document).on('click','.delete_spec',function(){
  var det_id = this.id.match(/\d+/);
  det_id = parseInt(det_id);
  var master_barcode = $('#master_barcode').val();
  $.ajax({
    url: '<?php echo base_url(); ?>dekitting_pk_us/c_dekitting_us/deleteDeKitDet',
    type: 'post',
    dataType: 'json',
    data : {'det_id':det_id},
    success:function(data){
      if(data == 1){
        $('#danger-modal').modal('show');
        $(".loader").show();
        show_master_detail(); // call function which get's records against master barcode
      }
    }
  });
});// class = .delete_spec button for deleting records end
  //******************************************************


/*=============================================
=            Section comment block            =
=============================================*/
$(document).on('click','.edit_spec',function(){
  var det_id = this.id.match(/\d+/);
  det_id = parseInt(det_id);
 $('#edit-modal').modal('show');
 $("#appCat").html("");
 $('#master_barcode').val();
 var category = $('#it_cat').val();
  var master_barcode = $('#master_barcode').val();

    var obj = [];
      $.ajax({
        url:'<?php echo base_url(); ?>dekitting_pk_us/c_dekitting_us/update_obj_dropdown',
        type:'post',
        dataType:'json',
        data:{'category':category},
        success:function(data){
        obj = [];
        bin = [];

        $.ajax({
          url: '<?php echo base_url(); ?>dekitting_pk_us/c_dekitting_us/getDetDetails',
          type: 'post',
          dataType: 'json',
          data : {'det_id':det_id},
          success:function(result){
            console.log(result.selectable[0].OBJECT_ID);
            for(var j = 0;j<data.obj.length;j++){
          if (data.obj[j].OBJECT_ID == result.selectable[0].OBJECT_ID) {
            var objSlected = 'selected';
          }else{
            var objSlected = '';
          }

          obj.push('<option value="'+data.obj[j].OBJECT_ID+'" '+objSlected+'>'+data.obj[j].OBJECT_NAME+'</option>');
        }

        for(var k = 0;k<data.bin.length;k++){
          if (data.bin[k].BIN_ID == result.selectable[0].BIN_ID) {
            var binSlected = 'selected';
          }else{
            var binSlected = '';
          }
          bin.push('<option value="'+data.bin[k].BIN_ID+'" '+binSlected+'>'+data.bin[k].BIN_NO+'</option>');
        }
        ////////////////////////////////////////////////
        //////////////////////////////////////////
        var conditions = [];
        for(var i = 0; i<result.conds.length; i++){
          if (result.selectable[0].CONDITION_ID == result.conds[i].ID){
                var selected = "selected";
                }else{
                  var selected = "";
                }
              conditions.push('<option value="'+result.conds[i].ID+'" '+selected+'>'+result.conds[i].COND_NAME+'</option>');
            }
        ///////////////////////////////////////////////
        var dekit_remarks = result.selectable[0].DEKIT_REMARKS;
        if (dekit_remarks == null || dekit_remarks == '') {
          dekit_remarks = '';
        }
        //////////////////////////////////////////////
              $('.bin_rackDet').html('');
              $('.object_descDet').html('');
              $('#cond_itemDet').html('');
        ///console.log(result.selectable[0].BIN_ID, result.selectable[0].OBJECT_ID);
              $("#appCat").append('<table id="detailsOFdet" class="table table-responsive table-striped table-bordered table-hover"><thead><tr><th>Barcode</th> <th>Condition</th> <th>Object</th> <th>Weight</th> <th>BIN/Rack</th> <th>Dekitting Remarks</th></tr></thead><tbody><tr><td style="width:100px;"><div style="width:100%;"><input type="text" id="barcode_noDet" class="form-control barcode_no" value="'+result.selectable[0].BARCODE_PRV_NO+'" readonly></div></td> <td style="width:100px;"><div style="width:100%;"><select id="cond_itemDet" name="cond_item" class="selectpicker form-control cond_item" result-live-search ="true">'+conditions.join("")+'</select></div></td> <td style="width:100px;" ><div><select class="selectpicker form-control object_descDet" result-live-search ="true" id="object_descDet" name="object_desc" >'+obj.join("")+'</select> </div></td> <td style="width:100px;"><div style="width:100px;"><input type="number" class="form-control weight_in" id="weight_in_det" name="weight_in" value="'+result.selectable[0].WEIGHT+'"  ></div></td><td style="width:100px;"><div style="width:100%;"> <select class="selectpicker form-control bin_rackDet" result-live-search ="true" id="det_bin_rack"  name="bin_rack">'+bin.join("")+'</select></div></td> <td style="width:100px;"><div style="width:100%;"><input type="text" class="form-control remarks" id="detRemarkDekit"  name="remarks" value="'+dekit_remarks+'"><input id="DET_dt_id" type="hidden" value="'+result.selectable[0].LZ_DEKIT_US_DT_ID+'"></div></td></tr></tbody></table>');

              $('.bin_rackDet').selectpicker();
              $('.object_descDet').selectpicker();
              $('#cond_itemDet').selectpicker();
              }
            });
          }
        });
});

$(document).on('click','#updateSpec',function(){
  var barcode = $('#barcode_noDet').val();
  var condition = $('#cond_itemDet').val();
  var object  = $('#object_descDet').val();
  var weight = $('#weight_in_det').val();
  var dekit_remark = $('#detRemarkDekit').val();
  var bin = $('#det_bin_rack').val();
  var det_id = $('#DET_dt_id').val();

  det_id = parseInt(det_id);
    // console.log(det_id);

  $('#master_barcode').val();
  var master_barcode = $('#master_barcode').val();

  $.ajax({
      url: '<?php echo base_url(); ?>dekitting_pk_us/c_dekitting_us/updateDetKit',
      type: 'post',
      resultType: 'json',
      data : {'det_id':det_id,'bin':bin,'dekit_remark':dekit_remark,'weight':weight,'object':object,'condition':condition,'barcode':barcode},
      success:function(data){
        if(data == 1){
          $('#successMessage').text('successMessage');
          $('#successMessage').text('Updated Successfully !!!');
          $('#success-modal').modal('show');
        }else{
          alert('item not updated !');
        }
      }
  });
});

//print all button for all sticker printing start
//***********************************************
$(document).on('click','#print',function(){

  var master_barcode = $('#master_barcode').val();
  window.open("<?php echo base_url(); ?>dekitting_pk_us/c_dekitting_us/print_all_us_pk/"+master_barcode,"_blank");
});
//print all button for all sticker printing end
//*********************************************

/*$(document).on('change', ".bin_rack", function(e){
    //e.eventPreventDefault();
    var bins_id = $(this).val();
   var test =  $.session.set('bin_id', 'bins_id');
//$.session.set(‘some key’, ‘a value’);
      //var test = $.session.get("bin_id");
    //var sValue = '<%=HttpContext.Current.Session["bin_id"]%>';

    console.log(test);


  //   $.ajax({
  //   url: '<?php //echo base_url();?>dekitting_pk_us/c_dekitting_us/save_bin',
  //   type: 'post',
  //   dataType: 'json',
  //   data : {'bin_id':bin_id}
  // });
  });*/
</script>
<script>
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

$(document).ready(function(){
  $('#barcode_prv').focus();
  //$('#addPicsBox').hide();
  //$('#addbarcodePic').prop('disabled',true);
  // $('#tab_1').hide();
  // $('#tab_2').show();
  //reload();

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
    uploadDekitFormData(formImage);
  }

  $("#btnupload_img").click(function(){

    $("#dekit_image").trigger("click");
  });

  $("#dekit_image").change(function(){
    var postData = new FormData($("#frmupload")[0]);
    var dekit_image = $("#dekit_image").val();
    //alert(dekit_image.length);
    if (dekit_image.length == 0 || dekit_image == null || dekit_image == '') {
      //alert('ll');
      return false;
    }
    //return false;
    uploadDekitFormData(postData);
  });

/*======== Sync Picture for Live Pictures end =========*/

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
        url:'<?php echo base_url(); ?>catalogueToCash/c_card_lots/delete_all_master',
        data: {
                'child_barcode':child_barcode,
                'it_condition':it_condition
      },
       success: function (data) {
        //alert(data);return false;
        var reload = function () {
            var regex = new RegExp("([?;&])reload[^&;]*[;&]?");
            var query = window.location.href.split('#')[0].replace(regex, "$1").replace(/&$/, '');
            window.location.href =
                (window.location.href.indexOf('?') < 0 ? "?" : query + (query.slice(-1) != "?" ? "&" : ""))
                + "reload=" + new Date().getTime() + window.location.hash;
        };
        var href="javascript:reload();void 0;";

          if(data == true){
            //reload();
            $('.loader').hide();
              $('#upload_message').append('<div class="alert alert-success alert-dismissable" id="message"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> All Pictures deleted Successfully !!</div>');

              setTimeout(function(){$('#upload_message').html("");},1000);
              //setTimeout(function(){$('#addPicsBox').hide();},2000);
              setTimeout(function(){$('#barcode_prv').focus();},1000);

              window.location.href=window.location.href; return false;

              // $('#barcode_prv').val('');
              // $('#singleObj').val('');
              // $('#condition_segs').val('');
              // $('#search_weight').val('');
              // $('#search_bin').val('');
              // $('#search_Remarks').val('');

          }else if(data == false){
            $('.loader').hide();
            $('#upload_message').append('<div class="alert alert-danger alert-dismissable" id="message"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong>  Pictures Not deleted  !!</div>');
              $('#barcode_prv').val('');
              setTimeout(function(){$('#upload_message').html("");},1000);
              //setTimeout(function(){$('#addPicsBox').hide();},2000);
              setTimeout(function(){$('#barcode_prv').focus();},1000);
            // alert('Error -  Pictures not deleted.');
            window.location.href=window.location.href; return false;
          }
        }
        });
    }else{
      //$('#addPicsBox').hide();
      $('#barcode_prv').focus();
    }


  });

/*=====  End of dele master  ======*/

/*============================================
=            Delete Specific images            =
============================================*/

  $(document).on('click','.specific_delete',function(){
    // alert('clicked');
     var specific_url = $(this).attr('id');
     var child_barcode = $('#barcode_prv').val();
     //alert(specific_url);return false;
     // alert(id);
    //return false;
    if(confirm('Are you sure?')){
      $('.loader').show();
        $.ajax({
          dataType: 'json',
          type: 'POST',
          // url:'<?php echo base_url(); ?>item_pictures/c_item_pictures/specific_img_delete',
          url:'<?php echo base_url(); ?>dekitting_pk_us/c_pic_shoot_us/specific_img_delete',
          data: { 'specific_url' : specific_url, 'child_barcode':child_barcode
        },
         success: function (data) {
          // alert(data);return false;

            if(data == true){
              //reload();
              $('.loader').hide();
              $('#upload_message').append('<div class="alert alert-success alert-dismissable" id="message"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Pictures deleted Successfully !!</div>');

              setTimeout(function(){$('#upload_message').html("");},1000);
              //setTimeout(function(){$('#addPicsBox').hide();},2000);
              setTimeout(function(){$('#barcode_prv').focus();},1000);
              // alert('Item Picture has been deleted.');//return false;
             var reload = function () {
            var regex = new RegExp("([?;&])reload[^&;]*[;&]?");
            var query = window.location.href.split('#')[0].replace(regex, "$1").replace(/&$/, '');
            window.location.href =
                (window.location.href.indexOf('?') < 0 ? "?" : query + (query.slice(-1) != "?" ? "&" : ""))
                + "reload=" + new Date().getTime() + window.location.hash;
        };
        var href="javascript:reload();void 0;";
      window.location.href=window.location.href; return false;
              // loadRecords();
              // $('#barcode_prv').val('');

              // $('#singleObj').val('');
              // $('#condition_segs').val('');
              // $('#search_weight').val('');
              // $('#search_bin').val('');
              // $('#search_Remarks').val('');

            }else if(data == false){
              $('.loader').hide();
              $('#upload_message').append('<div class="alert alert-danger alert-dismissable" id="message"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Pictures Not deleted  !!</div>');
              $('#barcode_prv').val('');
              setTimeout(function(){$('#upload_message').html("");},1000);
              //setTimeout(function(){$('#addPicsBox').hide();},2000);
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

/*=====================================================
=  Delete All Live pictures from Master tab start     =
=====================================================*/

  $(".delLivePictures").click(function(){
    //var master_reorder = $('#sortable').sortable('toArray');
    if(confirm('Are you sure?')){

      $('.loader').show();
      $.ajax({
        dataType: 'json',
        type: 'POST',
        url:'<?php echo base_url(); ?>catalogueToCash/c_card_lots/deleteAllLivePictures',
        data: {},
       success: function (data) {
        //alert(data);return false;
          $('.loader').hide();
           var reload = function () {
            var regex = new RegExp("([?;&])reload[^&;]*[;&]?");
            var query = window.location.href.split('#')[0].replace(regex, "$1").replace(/&$/, '');
            window.location.href =
                (window.location.href.indexOf('?') < 0 ? "?" : query + (query.slice(-1) != "?" ? "&" : ""))
                + "reload=" + new Date().getTime() + window.location.hash;
        };
        var href="javascript:reload();void 0;";

          if(data == true){
            $('.loader').hide();
            //reload();
              $('#upload_message').append('<div class="alert alert-success alert-dismissable" id="message"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> All Pictures deleted Successfully !!</div>');

              setTimeout(function(){$('#upload_message').html("");},1000);
              //setTimeout(function(){$('#addPicsBox').hide();},2000);
              setTimeout(function(){$('#barcode_prv').focus();},1000);
              window.location.href=window.location.href; return false;

              // $('.loader').hide();
              // $('#barcode_prv').val('');
              // $('#singleObj').val('');
              // $('#condition_segs').val('');
              // $('#search_weight').val('');
              // $('#search_bin').val('');
              // $('#search_Remarks').val('');
              // $('#addPicsBox').hide();


          }else if(data == false){
            $('.loader').hide();
            $('#upload_message').append('<div class="alert alert-danger alert-dismissable" id="message"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong>  Pictures Not deleted  !!</div>');
              $('#barcode_prv').val('');
              setTimeout(function(){$('#upload_message').html("");},1000);
              //setTimeout(function(){$('#addPicsBox').hide();},2000);
              setTimeout(function(){$('#barcode_prv').focus();},1000);
            // alert('Error -  Pictures not deleted.');
            window.location.href=window.location.href; return false;
          }
        }
        });
    }else{
      $('#addPicsBox').hide();
      $('#barcode_prv').focus();
    }


  });

/*=====  End of Delete All Live pictures from Master tab  ======*/

/*=====================================================
=  Delete Specific selected Live picture from Master tab start     =
=====================================================*/


  $(document).on('click','.delSpecificLivePictures',function(){
    //var master_reorder = $('#sortable').sortable('toArray');
    var pic_path = $(this).attr('id');
    //console.log(pic_path);return false;
    if(confirm('Are you sure?')){

      $('.loader').show();
      $.ajax({
        dataType: 'json',
        type: 'POST',
        url:'<?php echo base_url(); ?>catalogueToCash/c_card_lots/deleteSpecificLivePictures',
        data: {'pic_path':pic_path},
       success: function (data) {
        //alert(data);return false;
          $('.loader').hide();
           var reload = function () {
            var regex = new RegExp("([?;&])reload[^&;]*[;&]?");
            var query = window.location.href.split('#')[0].replace(regex, "$1").replace(/&$/, '');
            window.location.href =
                (window.location.href.indexOf('?') < 0 ? "?" : query + (query.slice(-1) != "?" ? "&" : ""))
                + "reload=" + new Date().getTime() + window.location.hash;
        };
        var href="javascript:reload();void 0;";

          if(data == true){
            $('.loader').hide();
            //reload();
              $('#upload_message').append('<div class="alert alert-success alert-dismissable" id="message"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Picture is deleted Successfully !!</div>');

              setTimeout(function(){$('#upload_message').html("");},1000);
              //setTimeout(function(){$('#addPicsBox').hide();},2000);
              setTimeout(function(){$('#barcode_prv').focus();},1000);


      window.location.href=window.location.href; return false;
              // $('.loader').hide();
              // $('#barcode_prv').val('');
              // $('#singleObj').val('');
              // $('#condition_segs').val('');
              // $('#search_weight').val('');
              // $('#search_bin').val('');
              // $('#search_Remarks').val('');
              // $('#addPicsBox').hide();

          }else if(data == false){
            $('.loader').hide();
            $('#upload_message').append('<div class="alert alert-danger alert-dismissable" id="message"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Picture is Not deleted  !!</div>');
              $('#barcode_prv').val('');
              setTimeout(function(){$('#upload_message').html("");},1000);
              //setTimeout(function(){$('#addPicsBox').hide();},2000);
              setTimeout(function(){$('#barcode_prv').focus();},1000);
            // alert('Error -  Pictures not deleted.');
            window.location.href=window.location.href; return false;
          }
        }
        });
    }else{
      $('#addPicsBox').hide();
      $('#barcode_prv').focus();
    }


  });

/*=====  End of Specific selected Live picture from Master tab  ======*/

/*================================================
=            Update Order of pictures            =
================================================*/
$(document).on('click','#master_reorder_dekit',function () {
    var master_reorder = $('#sortable').sortable('toArray');

     //var child_barcode = '<?php //echo $this->uri->segment(5); ?>';
    var child_barcode = $('#barcode_prv').val();
    //var condition = $('#condition_segs').val();
    //alert(upc+"_"+part_no+"_"+it_condition);
    //console.log(master_reorder,child_barcode); return false;
    //alert(sortID);return false;
    $('.loader').show();
    $.ajax({
      dataType: 'json',
      type: 'POST',
      url:'<?php echo base_url(); ?>catalogueToCash/c_card_lots/master_sorting_order',
      data: { 'master_reorder' : master_reorder,
              'child_barcode':child_barcode
    },
     success: function (data) {
        var reload = function () {
            var regex = new RegExp("([?;&])reload[^&;]*[;&]?");
            var query = window.location.href.split('#')[0].replace(regex, "$1").replace(/&$/, '');
            window.location.href =
                (window.location.href.indexOf('?') < 0 ? "?" : query + (query.slice(-1) != "?" ? "&" : ""))
                + "reload=" + new Date().getTime() + window.location.hash;
        };
        var href="javascript:reload();void 0;";

        if(data == true){
          $('.loader').hide();
          $('#upload_message').append('<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Pictures Order Updated Successfully !!</div>');
              // $('#barcode_prv').val('');
              // $('#singleObj').val('');
              // $('#condition_segs').val('');
              // $('#search_weight').val('');
              // $('#search_bin').val('');
              // $('#search_Remarks').val('');
              setTimeout(function(){$('#upload_message').html("");},1000);
              //setTimeout(function(){$('#addPicsBox').hide();},2000);
              setTimeout(function(){$('#barcode_prv').focus();},1000);
            window.location.href=window.location.href; return false;



        }else if(data == false){
          $('.loader').hide();
          $('#upload_message').append('<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Pictures Order Not Updated !!</div>');
              // $('#barcode_prv').val('');
              // $('#singleObj').val('');
              // $('#condition_segs').val('');
              // $('#search_weight').val('');
              // $('#search_bin').val('');
              // $('#search_Remarks').val('');
              setTimeout(function(){$('#upload_message').html("");},1000);
              //setTimeout(function(){$('#addPicsBox').hide();},2000);
              setTimeout(function(){$('#barcode_prv').focus();},1000);
              window.location.href=window.location.href; return false;

        }

      }
      });

});


 $('#upd_remar_only').on('click', function(){

  var special_lot_id  = $('#special_lot_id').val();
  var up_remarks  = $('#up_remarks').val();

  if(up_remarks == ''){
    alert('Enter Remarks');
  return false;

  }
  var url='<?php echo base_url() ?>catalogueToCash/c_card_lots/upda_remar_only';

  $.ajax({
          type: 'POST',
          url:url,
           dataType: 'json',
          data: {
            'special_lot_id': special_lot_id,
            'up_remarks': up_remarks },
          success: function(data) {
            if(data ==true){
              alert('Remarks Updated');
              return false;
            }else{
              alert('Remarks not Updated');
              return false;
            }

          }
      });

  });




 $('#add_onupdate_save').on('click', function(){
    var card_upc                = $('#card_upc').val();
    var card_mpn                = $('#card_mpn').val();
    var up_cond_item            = $("input[name='up_cond_item']:checked").val();
    if(up_cond_item === "" || up_cond_item === null || up_cond_item === undefined){
      var up_cond_item            = $("#up_cond_item").val();
    }
    var up_object_desc          = $('#up_object_desc').val();
    var up_bin_rack             = $('#up_bin_rack').val();
    var pic_notes               = $('#pic_notes').val();
    var up_remarks              = $('#up_remarks').val();
    var brand_name              = $('#brand_name').val();
    var mpn_description         = $('#mpn_description').val();
    var special_lot_id          = $('#special_lot_id').val();
    var barcode                 = $('#barcode').val();
    var get_cost                = $('#get_cost').val();
    var get_card_category       =$('#card_category').val();

    if(mpn_description == ''){
      $('#mpn_description').focus();
      alert('Enter Mpn Description');
      return false;
    }

    if(get_card_category == ''){
      $('#card_category').focus();
      alert('Enter Category Id');
      return false;
    }
    if(card_mpn == ''){
      $('#card_mpn').focus();
      alert('Enter Mpn');
      return false;
    }

    if(brand_name == ''){
      $('#brand_name').focus();
      alert('Enter Brand Name');
      return false;
    }
    ///console.log(up_cond_item); return false;
  $('.loader').show();
  var url='<?php echo base_url() ?>catalogueToCash/c_card_lots/update_without_picture';
  $(".loader").show();
  $.ajax({
          type: 'POST',
          url:url,
           dataType: 'json',
          data: {
            'card_upc': card_upc,
            'card_mpn': card_mpn,
            'up_cond_item': up_cond_item,
            'up_object_desc': up_object_desc,
            'up_bin_rack': up_bin_rack,
            'pic_notes': pic_notes,
            'brand_name': brand_name,
            'mpn_description': mpn_description,
            'special_lot_id': special_lot_id,
            'up_remarks': up_remarks,
            'barcode': barcode,
            'get_cost': get_cost,
            'get_card_category': get_card_category
          },
          success: function(data) {
            //alert(data);
            if (data == 1) {
              $('.loader').hide();
              $('#update_message').append('<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Lot Uploaded Successfully !!</div>');
              setTimeout(function(){$('#update_message').html("");},1000);
              window.location.href = '<?php echo base_url(); ?>catalogueToCash/c_card_lots/special_lot_detail';
            }else if(data == 0){
              $('.loader').hide();
              $('#update_message').append('<div class="alert alert-warning alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Warning!</strong> Lot Updation Failed !!</div>');
              setTimeout(function(){$('#update_message').html("");},1000);
              //window.location.href = '<?php //echo base_url(); ?>catalogueToCash/c_card_lots/special_lot_detail';
            }
          }
      });
 });
/*=====  End of Reorder  ======*/


function uploadDekitFormData(formData) {

    var card_upc                = $('#card_upc').val();
    var card_mpn                = $('#card_mpn').val();
    var up_cond_item            = $("input[name='up_cond_item']:checked").val();
    var up_object_desc          = $('#up_object_desc').val();
    var up_bin_rack             = $('#up_bin_rack').val();
    var pic_notes               = $('#pic_notes').val();
    var up_remarks              = $('#up_remarks').val();
    var brand_name              = $('#brand_name').val();
    var mpn_description         = $('#mpn_description').val();
    var special_lot_id          = $('#special_lot_id').val();
    var barcode                 = $('#barcode').val();

  formData.append('card_upc',card_upc);
  formData.append('card_mpn',card_mpn);
  formData.append('up_cond_item',up_cond_item);
  formData.append('up_object_desc',up_object_desc);
  formData.append('up_bin_rack',up_bin_rack);
  formData.append('pic_notes',pic_notes);
  formData.append('up_remarks',up_remarks);
  formData.append('brand_name',brand_name);
  formData.append('mpn_description',mpn_description);
  formData.append('special_lot_id',special_lot_id);
  formData.append('barcode',barcode);

  $('.loader').show();
  $.ajax({
    url: '<?php echo base_url(); ?>catalogueToCash/c_card_lots/update_special_lot',
    type: 'POST',
    datatype : "json",
    processData: false,
    contentType: false,
    cache: false,
    data: formData,
    success: function(data) {
      //reload();

      $('.loader').hide();
      $('#upload_message').append('<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Pictures Uploaded Successfully !!</div>');
      // $('#barcode_prv').val('');
      // $('#singleObj').val('');
      // $('#condition_segs').val('');
      // $('#search_weight').val('');
      // $('#search_bin').val('');
      // $('#search_Remarks').val('');
      setTimeout(function(){$('#upload_message').html("");},1000);
      //setTimeout(function(){$('#addPicsBox').hide();},2000);
      setTimeout(function(){$('#barcode_prv').focus();},1000);
      window.location.href = '<?php echo base_url(); ?>catalogueToCash/c_card_lots/special_lot_detail';

    }
  });

}

  /*=================================================================
  =            save and move images on click save button            =
  =================================================================*/
   $("#save_pics_master").click(function(){
    var radio_btn = $('input[name=mpn_picture]:checked').val();
    var pic_name = $('input[name=mpn_picture]:checked').attr('pic_name');
    var card_upc          = $('#card_upc').val();
    var card_mpn          = $('#card_mpn').val();
    var up_cond_item      = $("input[name='up_cond_item']:checked").val();
    var up_object_desc    = $('#up_object_desc').val();
    var up_bin_rack       = $('#up_bin_rack').val();

    //////////////////////////////
    var pic_notes         = $('#pic_notes').val();
    var up_remarks        = $('#up_remarks').val();

    ////////////////////////////

    if(card_mpn == '' || card_mpn == null){
      alert('Please Enter MPN');
      $('#card_mpn').focus();
      return false;
    }

    $(".loader").show();
    $.ajax({
      dataType: 'json',
      type: 'POST',
      url:'<?php echo base_url(); ?>catalogueToCash/c_card_lots/save_pics_master',
      data: {
              'radio_btn':radio_btn,
              'pic_name':pic_name,
              'card_upc':card_upc,
              'card_mpn':card_mpn,
              'up_cond_item':up_cond_item,
              'up_object_desc':up_object_desc,
              'pic_notes':pic_notes,
              'up_remarks':up_remarks,
              'up_bin_rack':up_bin_rack
    },
     success: function (data) {
      //alert(data);return false;
      $(".loader").hide();
      var reload = function () {
            var regex = new RegExp("([?;&])reload[^&;]*[;&]?");
            var query = window.location.href.split('#')[0].replace(regex, "$1").replace(/&$/, '');
            window.location.href =
                (window.location.href.indexOf('?') < 0 ? "?" : query + (query.slice(-1) != "?" ? "&" : ""))
                + "reload=" + new Date().getTime() + window.location.hash;
        };
        var href="javascript:reload();void 0;";

        if(data == true){
          $(".loader").hide();
          //reload();
          $('#pics_insertion_msg').append('<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Master Pictures has been added.</div>').delay(3000).queue(function() { $(this).remove(); });
              // $('#barcode_prv').val('');
              // $('#singleObj').val('');
              // $('#condition_segs').val('');
              // $('#search_weight').val('');
              // $('#search_bin').val('');
              // $('#search_Remarks').val('');
        // $('#barcode_prv').focus();
            //setTimeout(function(){$('#addPicsBox').hide();},1000);
            setTimeout(function(){$('#barcode_prv').focus();},1000);
          // alert('Master Pictures has been added.');
           window.location.href=window.location.href; return false;
        }else if(data == false){
          $('#pics_insertion_msg').append('<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Error!</strong> Pictures not added.</div>').delay(3000).queue(function() { $(this).remove(); });
              // $('#barcode_prv').val('');
              // $('#singleObj').val('');
              // $('#condition_segs').val('');
              // $('#search_weight').val('');
              // $('#search_bin').val('');
              // $('#search_Remarks').val('');        // $('#barcode_prv').focus();
            //setTimeout(function(){$('#addPicsBox').hide();},1000);
            setTimeout(function(){$('#barcode_prv').focus();},1000);
          //alert('Error -  Pictures not added.');
          window.location.href=window.location.href; return false;
        }
        // $('#barcode_prv').val('');
        // $('#addPicsBox').hide();
        $('#barcode_prv').focus();
      }
      });
  });


  /*=====  End of save and move images on click save button  ======*/
  /*=================================================================
  =            Save and Marks as MPN Start                         =
  =================================================================*/
   $("#mark_mpn").click(function(){
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
      url:'<?php echo base_url(); ?>dekitting_pk_us/c_pic_shoot_us/saveAndMarkasMPN',
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
          //reload();
          $('#pics_insertion_msg').append('<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Picture is marked as MPN.</div>').delay(3000).queue(function() { $(this).remove(); });
              // $('#barcode_prv').val('');
              // $('#singleObj').val('');
              // $('#condition_segs').val('');
              // $('#search_weight').val('');
              // $('#search_bin').val('');
              // $('#search_Remarks').val('');
        // $('#barcode_prv').focus();
            //setTimeout(function(){$('#addPicsBox').hide();},1000);
            setTimeout(function(){$('#barcode_prv').focus();},1000);
          // alert('Master Pictures has been added.');
           window.location.reload();
        }else if(data == false){
          $('#pics_insertion_msg').append('<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Error!</strong> Picture is not marked as MPN.</div>').delay(3000).queue(function() { $(this).remove(); });
              // $('#barcode_prv').val('');
              // $('#singleObj').val('');
              // $('#condition_segs').val('');
              // $('#search_weight').val('');
              // $('#search_bin').val('');
              // $('#search_Remarks').val('');        // $('#barcode_prv').focus();
            //setTimeout(function(){$('#addPicsBox').hide();},1000);
            setTimeout(function(){
              $('#barcode_prv').focus();
            },1000);
          //alert('Error -  Pictures not added.');
          //window.location.reload();
        }
        // $('#barcode_prv').val('');
        // $('#addPicsBox').hide();
        $('#barcode_prv').focus();
      }
      });
  });


  /*=====  End of Save and Marks as MPN   ======*/

  /*=========================================
  =            save history pics            =
  =========================================*/

  $("#save_history_master").click(function(){

    var barcode = $('#barcode_prv').val();
    var condition = $('#condition_segs').val();
    var radio_btn = $('input[name=mpn_picture_history]:checked').val();
    var pic_name = $('input[name=mpn_picture_history]:checked').attr('pic_name');

    var bin_id = $('#bin_id').val();
    if(bin_id == '' || bin_id == null){
      alert('Please Assign a Bin. Its Mandatory.');
      $('#bin_id').focus();
      return false;

    }

    $(".loader").show();

    $.ajax({
      dataType: 'json',
      type: 'POST',
      url:'<?php echo base_url(); ?>dekitting_pk_us/c_pic_shoot_us/save_history_master',
      data: {
              'barcode':barcode,
              'condition':condition,
              'radio_btn':radio_btn,
              'pic_name':pic_name,
              'bin_id':bin_id
    },
     success: function (data) {
      //alert(data);return false;
      $(".loader").hide();
        if(data == true){
          //reload();
          $('#pics_history_msg').append('<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> History Pictures has been added.</div>').delay(3000).queue(function() { $(this).remove(); });
              // $('#barcode_prv').val('');
              // $('#singleObj').val('');
              // $('#condition_segs').val('');
              // $('#search_weight').val('');
              // $('#search_bin').val('');
              // $('#search_Remarks').val('');
        // $('#barcode_prv').focus();
            //setTimeout(function(){$('#addPicsBox').hide();},2000);
            setTimeout(function(){$('#barcode_prv').focus();},2000);
          // alert('Master Pictures has been added.');
            window.location.reload();
        }else if(data == false){
          $('#pics_history_msg').append('<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Error!</strong> Pictures not added.</div>').delay(3000).queue(function() { $(this).remove(); });
              // $('#barcode_prv').val('');
              // $('#singleObj').val('');
              // $('#condition_segs').val('');
              // $('#search_weight').val('');
              // $('#search_bin').val('');
              // $('#search_Remarks').val('');        // $('#barcode_prv').focus();
            //setTimeout(function(){$('#addPicsBox').hide();},1000);
            setTimeout(function(){$('#barcode_prv').focus();},1000);
          //alert('Error -  Pictures not added.');
          //window.location.reload();
        }
        //$('#barcode_prv').val('');
        //$('#addPicsBox').hide();
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
              // $('#barcode_prv').val('');
              // $('#singleObj').val('');
              // $('#condition_segs').val('');
              // $('#search_weight').val('');
              // $('#search_bin').val('');
              // $('#search_Remarks').val('');
            //setTimeout(function(){$('#addPicsBox').hide();},1000);
            setTimeout(function(){$('#barcode_prv').focus();},1000);
            // alert('Picture note saved !!');
            // $('#barcode_prv').focus();
             // window.location.reload();
          }else{
            $('#saveNoteMessage').append('<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Error!</strong> Picture Notes Not Updated !!</div>').delay(2000).queue(function() { $(this).remove(); });
              // $('#barcode_prv').val('');
              // $('#singleObj').val('');
              // $('#condition_segs').val('');
              // $('#search_weight').val('');
              // $('#search_bin').val('');
              // $('#search_Remarks').val('');
            //setTimeout(function(){$('#addPicsBox').hide();},1000);
            setTimeout(function(){$('#barcode_prv').focus();},1000);
            // $('#barcode_prv').focus();
          }
        }

      });
});
  function textCounter(field,cnt, maxlimit) {
      var cntfield = document.getElementById(cnt);
         if (field.value.length > maxlimit){ // if too long...trim it!
        field.value = field.value.substring(0, maxlimit);
        // otherwise, update 'characters left' counter
        }else{
       cntfield.value = parseInt(parseInt(maxlimit) - parseInt(field.value.length));
     }
    }
  /*=====  End of textarea save  ======*/
  $(document).on('click','#Serch_desc',function(){
  //$(this).removeClass("btn-success").addClass("btn-primary");
    //var row_id            = $(this).attr("rd");
    var category_id        = 177;//$('#br_cata_id').val();
    var mpn                = $('#mpn_description').val();
    if(mpn == ''){
      $('#mpn_description').focus();
      alert('Enter Mpn Description');
      return false;
    }
    //var condition_id      = $("#up_cond_item").val();
    var condition_id      = $('input[name=up_cond_item]:checked').val();
    var catalogue_mt_id      = $("#br_catalog_id").val();

  console.log(category_id,mpn,condition_id,catalogue_mt_id);
  // return false;
  $(".loader").show();
  $.ajax({

        url :"<?php echo base_url() ?>catalogueToCash/C_card_lots/get_avg_sold_price", // json datasource
        type: "post" ,
        data: {
        'category_id': category_id,
        'mpn' : mpn,
        'condition_id':condition_id,
        'catalogue_mt_id':catalogue_mt_id
        },
        dataType: 'json',

        success : function(data){
       // console.log(data);
       // return false;

    if(data.ack= 'Success' && data.resultCount > 0)
     {
        if(data.resultCount == 1)//if result is 1 than condition is changed so this check is neccessory
        {
          //$( "#sold_price_data" ).html("");

           var item = data['item'][0];
           var price = parseFloat(item['basicInfo']['convertedCurrentPrice']);
           var title = item['basicInfo']['title'];
           var categoryId = item['basicInfo']['categoryId'];
          var categoryName = item['basicInfo']['categoryName'];
           //console.log(title);
           //table.row(this_tr).find('cata_avg_price').val(price);
           $('#get_cost').val(price.toFixed(2));
           $("#my_Categories_result").html("");

            var tr='';
          $("#my_Categories_result").html( "<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>Ebay Suggested Titles</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div><table width='100%' class='table table-bordered table-striped' border='1' id='mycategory_table'> <th>Sr. No</th><th>Title</th><th>Category Id</th<th>Category Name</th><th>Select</th>" );

            $('<tr>').html("<td>"+1+"</td><td>"+ title +"</td><td>"+ categoryId +"</td><td>"+ categoryName +"</td><td><a class='crsr-pntr' id='cat_"+1+"' onclick='selct_funct("+1+");'> Select </a></td></tr></table></div></div>").appendTo('#mycategory_table');

           //$('#kit-components-table tr').eq(row_id).find('td').eq(8).find('input').val(price.toFixed(2));
           //$('#kit-components-table tr').eq(row_id).find('td').eq(9).find('input').val(price.toFixed(2)).trigger('blur');//call blur function to calculate seling expense
       // }

        }
        if(data.resultCount > 1)
        {
          var title_arr = [];
          if(data.resultCount > 15){
            var loop = 15;
          }else{
            var loop = data.resultCount;
          }
          var sum_price = 0;
          /////////////////////////////////////
          $( "#my_Categories_result" ).html("");
          var tr='';

         $( "#my_Categories_result" ).html( "<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>Ebay Suggested Titles</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div><table width='100%' class='table table-bordered table-striped' border='1' id='mycategory_table'> <th>Sr. No</th><th>Title</th><th>Category Id</th><th>Category Name</th><th>Select</th>" );
          //////////////////////////////////////////////////

            for ( var i = 1; i <= loop; i++ )
            {
              //console.log(i-1);
             var item = data['item'][i-1];
              //var item = data['item'][0];
             var price = item['basicInfo']['convertedCurrentPrice'];
             sum_price = parseFloat(sum_price) + parseFloat(price) ;
             var title = item['basicInfo']['title'];
             var categoryId = item['basicInfo']['categoryId'];
              var categoryName = item['basicInfo']['categoryName'];

             $('<tr>').html("<td>" + i + "</td><td>"+ title +"</td><td>"+ categoryId +"</td><td>"+ categoryName +"</td><td><a class='crsr-pntr' id='cat_"+i+"' onclick='selct_funct("+i+");'> Select </a></td></tr></table></div></div>").appendTo('#mycategory_table');
             //title_arr.push(title);

            //console.log(i-1,price,sum_price);
            }
            //console.log(title_arr);

            var avg_price = parseFloat(sum_price) / parseFloat(loop) ;
            $('#get_cost').val(avg_price.toFixed(2));

        }
      $(".loader").hide();
    }else{
       $(".loader").hide();
        // $("<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>No Record Found.</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div></div></div>").appendTo("#sold_price_data");
        if(data == 'EXCEPTION'){
          $("#my_Categories_result").html("");
          alert("keyword not found");
        }else{
          $("#my_Categories_result").html("");
          alert("No result found on eBay");
        }

      }
        },
         complete: function(data){
          $(".loader").hide();
        },
      error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
    }

  });
});

$(document).on('click','#Serch_upc',function(){
  //$(this).removeClass("btn-success").addClass("btn-primary");
    //var row_id            = $(this).attr("rd");
    var category_id        = $('#br_cata_id').val();
    var mpn                = $('#card_upc').val();
    if(mpn == ''){
      $('#card_upc').focus();
      alert('Enter Upc');
      return false;
    }
    //var condition_id      = $("#up_cond_item").val();
    var condition_id      = $('input[name=up_cond_item]:checked').val();
    var catalogue_mt_id      = $("#br_catalog_id").val();
    console.log(category_id,mpn,condition_id,catalogue_mt_id);

  // console.log(category_id,mpn,condition_id);
  // return false;
  $(".loader").show();
  $.ajax({

        url :"<?php echo base_url() ?>catalogueToCash/C_card_lots/get_avg_sold_price", // json datasource
        type: "post" ,
        data: {
        'category_id': category_id,
        'mpn' : mpn,
        'condition_id':condition_id,
        'catalogue_mt_id':catalogue_mt_id
        },
        dataType: 'json',

        success : function(data){
       // console.log(data);
       // return false;

    if(data.ack= 'Success' && data.resultCount > 0)
     {
        if(data.resultCount == 1)//if result is 1 than condition is changed so this check is neccessory
        {
          //$( "#sold_price_data" ).html("");

           var item = data['item'][0];
           var price = parseFloat(item['basicInfo']['convertedCurrentPrice']);
           var title = item['basicInfo']['title'];
           var categoryId = item['basicInfo']['categoryId'];
            var categoryName = item['basicInfo']['categoryName'];
           //console.log(title);
           //table.row(this_tr).find('cata_avg_price').val(price);
           $('#get_cost').val(price.toFixed(2));
           $("#my_Categories_result").html("");

            var tr='';
          $("#my_Categories_result").html( "<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>Suggested Titles</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div><table width='100%' class='table table-bordered table-striped' border='1' id='mycategory_table'> <th>Sr. No</th><th>Title</th><th>Category Id</th><th>Category Name</th><th>Select</th>" );

            $('<tr>').html("<td>"+1+"</td><td>"+ title +"</td><td>"+ categoryId +"</td><td>"+ categoryName +"</td><td><a class='crsr-pntr' id='cat_"+1+"' onclick='selct_funct("+1+");'> Select </a></td></tr></table></div></div>").appendTo('#mycategory_table');

           //$('#kit-components-table tr').eq(row_id).find('td').eq(8).find('input').val(price.toFixed(2));
           //$('#kit-components-table tr').eq(row_id).find('td').eq(9).find('input').val(price.toFixed(2)).trigger('blur');//call blur function to calculate seling expense
       // }

        }
        if(data.resultCount > 1)
        {
          var title_arr = [];
          if(data.resultCount > 15){
            var loop = 15;
          }else{
            var loop = data.resultCount;
          }
          var sum_price = 0;
          /////////////////////////////////////
          $( "#my_Categories_result" ).html("");
          var tr='';

         $( "#my_Categories_result" ).html( "<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>Suggested Titles</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div><table width='100%' class='table table-bordered table-striped' border='1' id='mycategory_table'> <th>Sr. No</th><th>Title</th><th>Category Id</th><th>Category Name</th><th>Select</th>" );
          //////////////////////////////////////////////////

            for ( var i = 1; i <= loop; i++ )
            {
              //console.log(i-1);
             var item = data['item'][i-1];
              //var item = data['item'][0];
             var price = item['basicInfo']['convertedCurrentPrice'];
             sum_price = parseFloat(sum_price) + parseFloat(price) ;
             var title = item['basicInfo']['title'];
             var categoryId = item['basicInfo']['categoryId'];
              var categoryName = item['basicInfo']['categoryName'];

             $('<tr>').html("<td>" + i + "</td><td>"+ title +"</td><td>"+ categoryId +"</td><td>"+ categoryName +"</td><td><a class='crsr-pntr' id='cat_"+i+"' onclick='selct_funct("+i+");'> Select </a></td></tr></table></div></div>").appendTo('#mycategory_table');
             //title_arr.push(title);

            //console.log(i-1,price,sum_price);
            }
            //console.log(title_arr);

            var avg_price = parseFloat(sum_price) / parseFloat(loop) ;
            $('#get_cost').val(avg_price.toFixed(2));

        }
      $(".loader").hide();
    }else{
       $(".loader").hide();
        // $("<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>No Record Found.</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div></div></div>").appendTo("#sold_price_data");
        if(data == 'EXCEPTION'){
          $("#my_Categories_result").html("");
          alert("keyword not found");
        }else{
          $("#my_Categories_result").html("");
          alert("No result found on eBay");
        }

      }
        },
         complete: function(data){
          $(".loader").hide();
        },
      error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
    }

  });
});



  $(document).on('click','#Serch_mpn',function(){
  //$(this).removeClass("btn-success").addClass("btn-primary");
    //var row_id            = $(this).attr("rd");
    var category_id        = $('#br_cata_id').val();
    var mpn                = $('#card_mpn').val();
    if(mpn == ''){
      $('#card_mpn').focus();
      alert('Enter mpn');
      return false;
    }
    //var condition_id      = $("#up_cond_item").val();
    var condition_id      = $('input[name=up_cond_item]:checked').val();
    var catalogue_mt_id      = $("#br_catalog_id").val();
    console.log(category_id,mpn,condition_id,catalogue_mt_id);

  // console.log(category_id,mpn,condition_id);
  // return false;
  $(".loader").show();
  $.ajax({

        url :"<?php echo base_url() ?>catalogueToCash/C_card_lots/get_avg_sold_price", // json datasource
        type: "post" ,
        data: {
        'category_id': category_id,
        'mpn' : mpn,
        'condition_id':condition_id,
        'catalogue_mt_id':catalogue_mt_id
        },
        dataType: 'json',

        success : function(data){
       // console.log(data);
       // return false;

    if(data.ack= 'Success' && data.resultCount > 0)
     {
        if(data.resultCount == 1)//if result is 1 than condition is changed so this check is neccessory
        {
          //$( "#sold_price_data" ).html("");

           var item = data['item'][0];
           var price = parseFloat(item['basicInfo']['convertedCurrentPrice']);
           var title = item['basicInfo']['title'];
           var categoryId = item['basicInfo']['categoryId'];
            var categoryName = item['basicInfo']['categoryName'];
           //console.log(title);
           //table.row(this_tr).find('cata_avg_price').val(price);
           $('#get_cost').val(price.toFixed(2));
           $("#my_Categories_result").html("");

            var tr='';
          $("#my_Categories_result").html( "<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>Suggested Titles</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div><table width='100%' class='table table-bordered table-striped' border='1' id='mycategory_table'> <th>Sr. No</th><th>Title</th><th>Category Id</th><th>Category Name</th><th>Select</th>" );

            $('<tr>').html("<td>"+1+"</td><td>"+ title +"</td><td>"+ categoryId +"</td><td>"+ categoryName +"</td><td><a class='crsr-pntr' id='cat_"+1+"' onclick='selct_funct("+1+");'> Select </a></td></tr></table></div></div>").appendTo('#mycategory_table');

           //$('#kit-components-table tr').eq(row_id).find('td').eq(8).find('input').val(price.toFixed(2));
           //$('#kit-components-table tr').eq(row_id).find('td').eq(9).find('input').val(price.toFixed(2)).trigger('blur');//call blur function to calculate seling expense
       // }

        }
        if(data.resultCount > 1)
        {
          var title_arr = [];
          if(data.resultCount > 15){
            var loop = 15;
          }else{
            var loop = data.resultCount;
          }
          var sum_price = 0;
          /////////////////////////////////////
          $( "#my_Categories_result" ).html("");
          var tr='';

         $( "#my_Categories_result" ).html( "<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>Suggested Titles</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div><table width='100%' class='table table-bordered table-striped' border='1' id='mycategory_table'> <th>Sr. No</th><th>Title</th><th>Category Id</th><th>Category Name</th><th>Select</th>" );
          //////////////////////////////////////////////////

            for ( var i = 1; i <= loop; i++ )
            {
              //console.log(i-1);
             var item = data['item'][i-1];
              //var item = data['item'][0];
             var price = item['basicInfo']['convertedCurrentPrice'];
             sum_price = parseFloat(sum_price) + parseFloat(price) ;
             var title = item['basicInfo']['title'];
             var categoryId = item['basicInfo']['categoryId'];
            var categoryName = item['basicInfo']['categoryName'];

             $('<tr>').html("<td>" + i + "</td><td>"+ title +"</td><td>"+ categoryId +"</td><td>"+ categoryName +"</td><td><a class='crsr-pntr' id='cat_"+i+"' onclick='selct_funct("+i+");'> Select </a></td></tr></table></div></div>").appendTo('#mycategory_table');
             //title_arr.push(title);

            //console.log(i-1,price,sum_price);
            }
            //console.log(title_arr);

            var avg_price = parseFloat(sum_price) / parseFloat(loop) ;
            $('#get_cost').val(avg_price.toFixed(2));

        }
      $(".loader").hide();
    }else{
       $(".loader").hide();
        // $("<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>No Record Found.</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div></div></div>").appendTo("#sold_price_data");
        if(data == 'EXCEPTION'){
          $("#my_Categories_result").html("");
          alert("keyword not found");
        }else{
          $("#my_Categories_result").html("");
          alert("No result found on eBay");
        }

      }
        },
         complete: function(data){
          $(".loader").hide();
        },
      error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
    }

  });
});

$(document).on('click','.Serch_desc_sys',function(){
$(".loader").show();
  var getcategory_id    =$('#card_category').val();
  var get_desc            = $('#mpn_description').val();
  if(get_desc == ''){
      $(".loader").hide();
      $('#mpn').focus();
      alert('Enter Mpn Description');
      return false;
    }
    var url='<?php echo base_url() ?>catalogueToCash/C_card_lots/serch_desc_sys';
   $.ajax({
      url: url,
      dataType: 'json',
      type: 'POST',
      data : {'category_id':getcategory_id,'get_desc':get_desc},
      success:function(data){
        $(".loader").hide();

        if(data.exist == true){

          $("#my_history" ).html("");
          var tr='';
          $( "#my_history" ).html( "<div class='col-sm-12'><div class='box box-danger'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>History Titles</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div><table width='100%' class='table table-bordered table-striped' border='1' id='mycategory_histry_table'> <th>Sr. No</th><th>Category Id</th><th>Title</th><th>MPN</th><th>UPC</th><th>Object Name</th><th>Brand Name</th><th>Condition</th><th>Select</th>" );
          //console.log(data.get_his.length);
          for(var k = 0; k< data.desc_sys_quer.length; k++){

              if(data.desc_sys_quer[k].CATE !== null){
                        CATE = data.desc_sys_quer[k].CATE;

              }else{
                CATE = '';
              }
              if(data.desc_sys_quer[k].UPC !== null){
                        upc = data.desc_sys_quer[k].UPC;

              }else{
                upc = '';
              }
              if(data.desc_sys_quer[k].OBJECT_NAME !== null){
                        object_name = data.desc_sys_quer[k].OBJECT_NAME;

              }else{
                object_name = '';
              }
              if(data.desc_sys_quer[k].BRAND !== null){
                        brand = data.desc_sys_quer[k].BRAND;

              }else{
                brand = '';
              }
              if(data.desc_sys_quer[k].COND_NAME !== null){
                        get_cond_name = data.desc_sys_quer[k].COND_NAME;

              }else{
                get_cond_name = '';
              }


            $('<tr>').html("<td>"+ parseInt(k+1) +"</td><td>"+ CATE+"</td><td>"+ data.desc_sys_quer[k].TITLE +"</td><td>"+ data.desc_sys_quer[k].MPN +"</td><td>"+ upc +"</td><td>"+object_name+"</td><td>"+ brand +"</td><td>"+ get_cond_name+"</td><td><a class='crsr-pntr'  onclick='select_his_funct("+parseInt(k+1)+");'> Select </a></td></tr></table></div></div>").appendTo('#mycategory_histry_table');


        }
     }else {
      alert('No History Found');
      $("#my_history" ).html("");

      return false;
     }
     }
        });
});

$(document).on('click','.serch_mpn_sys',function(){
$(".loader").show();
  var getcategory_id    =$('#card_category').val();
  var card_mpn            = $('#card_mpn').val();
  if(card_mpn == ''){
    $(".loader").hide();
      $('#card_mpn').focus();
      alert('Enter Mpn');
      return false;
    }
    var url='<?php echo base_url() ?>catalogueToCash/C_card_lots/serch_mpn_sys';
   $.ajax({
      url: url,
      dataType: 'json',
      type: 'POST',
      data : {'category_id':getcategory_id,'card_mpn':card_mpn},
      success:function(data){
        $(".loader").hide();
        // console.log(data);
        // return false;

        if(data.exist == true){

          $("#my_history" ).html("");
          var tr='';
          $( "#my_history" ).html( "<div class='col-sm-12'><div class='box box-danger'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>History Titles</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div><table width='100%' class='table table-bordered table-striped' border='1' id='mycategory_histry_table'> <th>Sr. No</th><th>Category Id</th><th>Title</th><th>MPN</th><th>UPC</th><th>Object Name</th><th>Brand Name</th><th>Condition</th><th>Select</th>" );
          //console.log(data.get_his.length);
          for(var k = 0; k< data.desc_mpn_quer.length; k++){

              if(data.desc_mpn_quer[k].CATE !== null){
                        CATE = data.desc_mpn_quer[k].CATE;

              }else{
                CATE = '';
              }
              if(data.desc_mpn_quer[k].UPC !== null){
                        upc = data.desc_mpn_quer[k].UPC;

              }else{
                upc = '';
              }
              if(data.desc_mpn_quer[k].OBJECT_NAME !== null){
                        object_name = data.desc_mpn_quer[k].OBJECT_NAME;

              }else{
                object_name = '';
              }
              if(data.desc_mpn_quer[k].BRAND !== null){
                        brand = data.desc_mpn_quer[k].BRAND;

              }else{
                brand = '';
              }
              if(data.desc_mpn_quer[k].COND_NAME !== null){
                        get_cond_name = data.desc_mpn_quer[k].COND_NAME;

              }else{
                get_cond_name = '';
              }


            $('<tr>').html("<td>"+ parseInt(k+1) +"</td><td>"+ CATE+"</td><td>"+ data.desc_mpn_quer[k].TITLE +"</td><td>"+ data.desc_mpn_quer[k].MPN +"</td><td>"+ upc +"</td><td>"+object_name+"</td><td>"+ brand +"</td><td>"+ get_cond_name+"</td><td><a class='crsr-pntr'  onclick='select_his_funct("+parseInt(k+1)+");'> Select </a></td></tr></table></div></div>").appendTo('#mycategory_histry_table');


        }
     }else {
      alert('No History Found');
      $("#my_history" ).html("");

      return false;
     }
     }
        });
});

$(document).on('click','.serch_upc_sys',function(){
$(".loader").show();
  var getcategory_id    =$('#card_category').val();
  var card_upc            = $('#card_upc').val();
  if(card_upc == ''){
    $(".loader").hide();
      $('#card_upc').focus();
      alert('Enter Upc');
      return false;
    }
    var url='<?php echo base_url() ?>catalogueToCash/C_card_lots/serch_upc_sys';
   $.ajax({
      url: url,
      dataType: 'json',
      type: 'POST',
      data : {'category_id':getcategory_id,'card_upc':card_upc},
      success:function(data){
        $(".loader").hide();
        // console.log(data);
        // return false;

        if(data.exist == true){

          $("#my_history" ).html("");
          var tr='';
          $( "#my_history" ).html( "<div class='col-sm-12'><div class='box box-danger'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>History Titles</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div><table width='100%' class='table table-bordered table-striped' border='1' id='mycategory_histry_table'> <th>Sr. No</th><th>Category Id</th><th>Title</th><th>MPN</th><th>UPC</th><th>Object Name</th><th>Brand Name</th><th>Condition</th><th>Select</th>" );
          //console.log(data.get_his.length);
          for(var k = 0; k< data.desc_upc_quer.length; k++){

              if(data.desc_upc_quer[k].CATE !== null){
                        CATE = data.desc_upc_quer[k].CATE;

              }else{
                CATE = '';
              }
              if(data.desc_upc_quer[k].UPC !== null){
                        upc = data.desc_upc_quer[k].UPC;

              }else{
                upc = '';
              }
              if(data.desc_upc_quer[k].OBJECT_NAME !== null){
                        object_name = data.desc_upc_quer[k].OBJECT_NAME;

              }else{
                object_name = '';
              }
              if(data.desc_upc_quer[k].BRAND !== null){
                        brand = data.desc_upc_quer[k].BRAND;

              }else{
                brand = '';
              }
              if(data.desc_upc_quer[k].COND_NAME !== null){
                        get_cond_name = data.desc_upc_quer[k].COND_NAME;

              }else{
                get_cond_name = '';
              }


            $('<tr>').html("<td>"+ parseInt(k+1) +"</td><td>"+ CATE +"</td><td>"+ data.desc_upc_quer[k].TITLE +"</td><td>"+ data.desc_upc_quer[k].MPN +"</td><td>"+ upc +"</td><td>"+object_name+"</td><td>"+ brand +"</td><td>"+ get_cond_name+"</td><td><a class='crsr-pntr'  onclick='select_his_funct("+parseInt(k+1)+");'> Select </a></td></tr></table></div></div>").appendTo('#mycategory_histry_table');


        }
     }else {
      alert('No History Found');
      $("#my_history" ).html("");

      return false;
     }
     }
        });
});

function selct_funct(i) {
  //return false;
    var index = i;
    var t = document.getElementById('mycategory_table');

    //$("#category_table tr").each(function() {
    //var cat_id = $(t.rows[index].cells[1]).text();
    var get_tile = $(t.rows[index].cells[1]).text();
    var get_tile_categor = $(t.rows[index].cells[2]).text();
    if(get_tile_categor.length !=0){
      $('#Serch_con').trigger("click");
    }
    //console.log(get_tile_categor);

    document.getElementById("mpn_description").value=get_tile;

    // i++;

    //});
}

function select_his_funct(i) {
    var index = i;

    var t = document.getElementById('mycategory_histry_table');
// console.log(t);
//     return false;
    var get_cat = $(t.rows[index].cells[1]).text();
    //console.log(get_cat);

    var get_tile = $(t.rows[index].cells[2]).text();
    var get_mpn = $(t.rows[index].cells[3]).text();
    var get_upc = $(t.rows[index].cells[4]).text();
    var get_obj = $(t.rows[index].cells[5]).text();
    var get_brand = $(t.rows[index].cells[6]).text();


    document.getElementById("card_category").value = get_cat;
    document.getElementById("mpn_description").value = get_tile;
    document.getElementById("card_mpn").value = get_mpn;
    document.getElementById("card_upc").value = get_upc;
    document.getElementById("brand_name").value = get_brand;

    if(get_obj.length !=0){
      get_obj_Drop(get_obj);
    }
    if(get_cat.length !=0){
      $('#Serch_con').trigger("click");
    }

    // i++;

    //});
}
function get_obj_Drop(objectdesc){



  var url='<?php echo base_url() ?>catalogueToCash/C_card_lots/get_avil_obj';
  $.ajax({
      url: url,
      dataType: 'json',
      type: 'POST',
      data : {},
      success:function(data){

        if(data){
          // console.log('true');
          // console.log(data);
          obj_selc = [];
          $('#apnd_obj').html('');

          for(var k = 0; k< data.obj.length; k++){

            if(data.obj[k].OBJECT_NAME == objectdesc ){
              var obj_selected = "selected";
            }else{
              var obj_selected = "";
            }

//apnd_obj up_object_desc
            obj_selc.push('<option value="'+data.obj[k].OBJECT_ID+'" '+obj_selected+'>'+data.obj[k].OBJECT_NAME+'</option>');
          }

          $('#apnd_obj').append('<select class="form-control up_object_desc" id="up_object_desc" name="up_object_desc" data-live-search ="true" required><option value="">Select Object</option>'+obj_selc.join("")+'</select>');
          $('.up_object_desc').selectpicker();

        }

      }
   });




}

$(document).on('change','body #selc_brand',function(){

  var get_brnd =$('#selc_brand').val();

   $('#brand_name').val(get_brnd);


  });
/*=====  End of getsold price function  ======*/
$(document).on('change','body #up_object_desc',function(){
$(".loader").show();
  var get_obj_id = $('#up_object_desc').val();

  if(get_obj_id == ''){
    $(".loader").show();
    return false;

  }

  var get_old_cond = $("input[type='radio'].radioBtnClass:checked").val();

  var url='<?php echo base_url() ?>catalogueToCash/C_card_lots/get_obj_id';
   $.ajax({
      url: url,
      dataType: 'json',
      type: 'POST',
      data : {'get_obj_id':get_obj_id},
      success:function(data){
        $(".loader").hide();
        console.log(data);

        if(data.cond_exist == true){

          $('#card_category').val(data['quer'][0].CATEGORY_ID);

          $('#apnd_radi').html('');
          console.log(get_old_cond);

          for(var k = 0; k< data.get_cond.length; k++){
            //console.log(data['get_cond'][k].CONDITION_ID);
            if(data['get_cond'][k].CONDITION_ID == get_old_cond){

              var  check = 'checked = checked';
            }else{
              var  check = '';
            }
            $('#apnd_radi').append('<div class="btn-group btn-group-horizontal" data-toggle="buttons"><label class="btn "><input type="radio" name="up_cond_item" id="up_cond_item" value='+data['get_cond'][k].CONDITION_ID+' '+check+' ><i class="fa fa-circle-o fa-2x" style="font-size: 1em;"></i><i class="fa fa-dot-circle-o fa-2x" style="font-size: 1em; "></i> <span>'+data['get_cond'][k].COND_NAME+'</span></label></div>');

          }
          //console.log(data['get_cat'][0].CATEGORY_ID);
        }else if (data.cond_exist == false){
          $('#card_category').val(data['quer'][0].CATEGORY_ID);
         $('#apnd_radi').html('');
         console.log(get_old_cond);

         for(var k = 0; k< data.get_all_cond.length; k++){
            //console.log(data['get_all_cond'][k].CONDITION_ID);
            if(data['get_all_cond'][k].CONDITION_ID == get_old_cond){

              var  check = 'checked = checked';
            }else{
              var  check = '';
            }
            $('#apnd_radi').append('<div class="btn-group btn-group-horizontal" data-toggle="buttons"><label class="btn "><input type="radio" name="up_cond_item" id="up_cond_item" value='+data['get_all_cond'][k].CONDITION_ID+' '+check+' ><i class="fa fa-circle-o fa-2x" style="font-size: 1em;"></i><i class="fa fa-dot-circle-o fa-2x" style="font-size: 1em; "></i> <span>'+data['get_all_cond'][k].COND_NAME+'</span></label></div>');

          }
          // alert('Condition Not Found');
          // return false;
        }else if (data.exist ==false){
          // alert('Category Not Found Against given condition');
          // return false;

        }

     }
        });
});

$(document).on('click','#Serch_con',function(){
$(".loader").show();

  var card_category = $('#card_category').val();
  var get_old_cond = $("input[type='radio'].radioBtnClass:checked").val();
  var up_object_desc          = $('#up_object_desc').val();

  if(card_category ==''){
    $(".loader").hide();

    $('#errorMessage_cat_id').html("");
        $('#errorMessage_cat_id').append('<p style="color:#c62828; font-size :18px;"><strong>Enter Category Id</strong></p>');
         $('#errorMessage_cat_id').show();
        setTimeout(function() {
          $('#errorMessage_cat_id').fadeOut('slow');
        }, 2200);
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

          console.log(data.get_obj_name);

           if(up_object_desc == ''){

          if(data.get_obj_name.length !=0 ){
            get_obj_Drop(data.get_obj_name);
          }
          }

          $('#apnd_radi').html('');

          for(var k = 0; k< data.get_cond.length; k++){
            //console.log(data['get_cond'][k].CONDITION_ID);
            if(data['get_cond'][k].CONDITION_ID == get_old_cond){

              var  check = 'checked = checked';
            }else{
              var  check = '';
            }
            $('#apnd_radi').append('<div class="btn-group btn-group-horizontal" data-toggle="buttons"><label class="btn "><input type="radio" name="up_cond_item" id="up_cond_item" value='+data['get_cond'][k].CONDITION_ID+' '+check+' ><i class="fa fa-circle-o fa-2x" style="font-size: 1em;"></i><i class="fa fa-dot-circle-o fa-2x" style="font-size: 1em; "></i> <span>'+data['get_cond'][k].COND_NAME+'</span></label></div>');

          }
          //console.log(data['get_cat'][0].CATEGORY_ID);
        }else if (data.cond_exist == false){
          //$('#card_category').val(data['quer'][0].CATEGORY_ID);
          console.log(data.get_obj_name);
          if(up_object_desc == ''){
            if(data.get_obj_name.length !=0 ){
            get_obj_Drop(data.get_obj_name);
            }
          }

         $('#apnd_radi').html('');

         for(var k = 0; k< data.get_all_cond.length; k++){
            //console.log(data['get_all_cond'][k].CONDITION_ID);
            if(data['get_all_cond'][k].CONDITION_ID == get_old_cond){

              var  check = 'checked = checked';
            }else{
              var  check = '';
            }
            $('#apnd_radi').append('<div class="btn-group btn-group-horizontal" data-toggle="buttons"><label class="btn "><input type="radio" name="up_cond_item" id="up_cond_item" value='+data['get_all_cond'][k].CONDITION_ID+' '+check+' ><i class="fa fa-circle-o fa-2x" style="font-size: 1em;"></i><i class="fa fa-dot-circle-o fa-2x" style="font-size: 1em; "></i> <span>'+data['get_all_cond'][k].COND_NAME+'</span></label></div>');

          }
          // alert('Condition Not Found');
          // return false;
        }

     }
        });
});



</script>


