<?php
class M_add_werehouse extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function add_wer()
  {


    $ware_no = $this->input->post('werehouse_no');
    $ware_desc = $this->input->post('werehouse_desc');
    $ware_desc = trim(str_replace("  ", ' ', $ware_desc));
    $ware_desc = trim(str_replace(array("'"), "''", $ware_desc));

    $ware_loc = $this->input->post('werehouse_loc');
    $ware_loc = trim(str_replace("  ", ' ', $ware_loc));
    $ware_loc = trim(str_replace(array("'"), "''", $ware_loc));

    $war_pk = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('WAREHOUSE_MT', 'WAREHOUSE_ID')ID FROM DUAL")->result_array();
    $war_pk = $war_pk[0]['ID'];

    $sav_war = $this->db->query("INSERT INTO WAREHOUSE_MT(WAREHOUSE_ID,WAREHOUSE_NO,WAREHOUSE_DESC,LOCATION) VALUES('$war_pk','$ware_no','$ware_desc','$ware_loc')");

    $get_data = $this->db->query("SELECT WAREHOUSE_ID FROM WAREHOUSE_MT where WAREHOUSE_ID = (SELECT max(WAREHOUSE_ID) from WAREHOUSE_MT)")->result_array();
    //$data = $this->db->query($get_data)->;
    $sav_war = $get_data[0]['WAREHOUSE_ID'];
    $sav_war = $this->db->query("SELECT WAREHOUSE_ID, WAREHOUSE_NO,WAREHOUSE_DESC, LOCATION FROM WAREHOUSE_MT where WAREHOUSE_ID = '$sav_war' order by WAREHOUSE_ID DESC ")->result_array();
    return array("status" => true, "tableData" => $sav_war);
  }

  public function get_wer()
  {

    // var_dump($auto_we_no); exit;
    $qry = $this->db->query("SELECT * FROM WAREHOUSE_MT")->result_array();
    return  $qry;
  }
  public function get_atu_no()
  {
    $auto_we_no = $this->db->query("SELECT max(warehouse_no + 1) WH_NO from WAREHOUSE_MT")->result_array();
    //$auto_we_no = $auto_we_no[0]['WH_NO'];
    return  $auto_we_no;
  }

  /********************************
   *   start Screen rack
   *********************************/

  public function dropdown_wer_desc()
  {
    $war_house = $this->db->query("SELECT WAREHOUSE_ID,WAREHOUSE_DESC FROM WAREHOUSE_MT")->result_array();


    return  $war_house;
  }
  public function dropdown_rack_type()
  {
    $reack_house = $this->db->query("SELECT RACK_ID,  DECODE(RACK_TYPE, 1, 'CAGE', 2, 'RACK') RACK_TYPE FROM RACK_MT")->result_array();

    return  $reack_house;
  }
  public function get_Rack()
  {
    $rackqry = $this->db->query("SELECT RA.RACK_ID,RA.RACK_NO,WA.WAREHOUSE_DESC,RA.WIDTH,RA.HEIGHT,RA.NO_OF_ROWS,DECODE(RA.RACK_TYPE,1,'CAGE',2,'RACK') RACK_TYPE FROM RACK_MT RA ,WAREHOUSE_MT WA WHERE RA.WAREHOUSE_ID = WA.WAREHOUSE_ID and RA.RACK_ID <>0 ORDER BY RACK_ID ASC ")->result_array();

    return  $rackqry;
  }

  public function add_rack()
  {

    $WarehouseDescription = $this->input->post('WarehouseDescription');
    $rack_width = $this->input->post('Rackwidth'); //ID
    $rack_height = $this->input->post('Rackheight'); //ID
    $no_of_rows = $this->input->post('NoOfRows'); //ID

    $rack_type = $this->input->post('RackTYPE'); //ID
    $no_of_rack = $this->input->post('NoOfRacks'); //ID
    $bin_array = '';
    $q = 1;
    for ($p = 0; $p < $no_of_rack; $p++) {
      $rack_pk = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('RACK_MT', 'RACK_ID')ID FROM DUAL")->result_array();
      $rack_pk = $rack_pk[0]['ID'];
      $get_val = $this->db->query("SELECT 'K' || '' || NVL(regexp_replace(MAX(RACK_NO), '[^[:digit:]]', '') + 1, 1) NEXT_VAL from RACK_MT r where r.rack_id = (select max(RACK_ID) from RACK_MT) ")->result_array();
      $get_val = $get_val[0]['NEXT_VAL'];
      $sav_war = $this->db->query("INSERT INTO RACK_MT(RACK_ID,RACK_NO,WAREHOUSE_ID,WIDTH,HEIGHT,NO_OF_ROWS,RACK_TYPE) VALUES('$rack_pk','$get_val','$WarehouseDescription','$rack_width','$rack_height','$no_of_rows','$rack_type')");

      // $get_data = $this->db->query("SELECT RACK_ID FROM RACK_MT where RACK_ID = (SELECT max(RACK_ID) from RACK_MT)")->result_array();
      // //$data = $this->db->query($get_data)->;
      // $get_id = $get_data[0]['RACK_ID'];
      // $rackqry = $this->db->query("SELECT RA.RACK_ID,RA.RACK_NO,WA.WAREHOUSE_DESC,RA.WIDTH,RA.HEIGHT,RA.NO_OF_ROWS,DECODE(RA.RACK_TYPE,1,'CAGE',2,'RACK') RACK_TYPE FROM RACK_MT RA ,WAREHOUSE_MT WA WHERE RA.WAREHOUSE_ID = WA.WAREHOUSE_ID and RA.RACK_ID <>0  and RA.RACK_ID =' $get_id'  ORDER BY RACK_ID ASC ")->result_array(); 
      for ($j = 1; $j <= $no_of_rows; $j++) { // 2
        $row_pk = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_RACK_ROWS', 'RACK_ROW_ID')ID FROM DUAL")->result_array();
        $row_pk = $row_pk[0]['ID'];


        $this->db->query("INSERT INTO LZ_RACK_ROWS(RACK_ROW_ID,RACK_ID,ROW_NO) values('$row_pk','$rack_pk',$j)");
        //2
      }

      if ($no_of_rack > 0) {
        if ($q >= 1 && $q < $no_of_rack) {
          $bin_array .= $rack_pk . ",";
        }
        if ($q == $no_of_rack) {
          $bin_array .= $rack_pk;
        }
      } else {
        $bin_array .= $rack_pk;
      }
      $q++;
    }
    $qr = "SELECT RA.RACK_ID,
        RA.RACK_NO,
        WA.WAREHOUSE_DESC,
        RA.WIDTH,
        RA.HEIGHT,
        RA.NO_OF_ROWS,
        DECODE(RA.RACK_TYPE, 1, 'CAGE', 2, 'RACK') RACK_TYPE
   FROM RACK_MT RA, WAREHOUSE_MT WA
  WHERE RA.WAREHOUSE_ID = WA.WAREHOUSE_ID
    AND RA.RACK_ID in ($bin_array)
  ORDER BY RACK_ID ASC";
    $data = $this->db->query($qr);
    return  array("status" => true, "data" => $data->result_array());
  }

  public function print_sticker()
  {
    // $rack_id = $this->uri->segment(4);
    $rack_id = $_GET['id'];
    // var_dump($rack_id); exit;
    $rack_stick = $this->db->query("SELECT 'W' || '' || WA.WAREHOUSE_NO || '-' || RA.RACK_NO RACK_NAME FROM RACK_MT RA, WAREHOUSE_MT WA WHERE RACK_ID = $rack_id AND RA.WAREHOUSE_ID = WA.WAREHOUSE_ID ")->result_array();
    return $rack_stick;
  }


  /********************************
   *   start Screen rack
   *********************************/

  /********************************
   *   start Screen add bin
   *********************************/
  public function get_bin()
  {
    $qry = $this->db->query("SELECT B.PRINT_STATUS,
          B.BIN_ID,
          B.BIN_NO || '-' || B.BIN_TYPE BIN_NAME,
          DECODE(BIN_TYPE,
                 'NA',
                 'W' || WA.WAREHOUSE_NO || '-' || M.RACK_NO || '-R' || ROW_NO || '-' ||
                 B.BIN_TYPE || '-' || B.BIN_NO,
                 B.BIN_TYPE || '-' || B.BIN_NO) BIN_NO
      FROM BIN_MT B, LZ_RACK_ROWS RA, RACK_MT M, WAREHOUSE_MT WA
      WHERE BIN_TYPE NOT IN ('No Bin')
      AND B.CURRENT_RACK_ROW_ID = RA.RACK_ROW_ID
      AND RA.RACK_ID = M.RACK_ID
      AND M.WAREHOUSE_ID = WA.WAREHOUSE_ID")->result_array();
    return $qry;
  }
  //   public function Search_printStatus()
  //   {
  //     $PrintStatus = $this->input->post('PrintStatus');
  //     $bin_type = $this->input->post('Bin_type');


  //     $bin_no = $this->db->query(" SELECT GET_BIN_NO('$bin_type') BIN_NO FROM DUAL ")->result_array();

  //     $bin_no = $bin_no[0]['BIN_NO'];
  //    // var_dump($bin_no); exit;
  //     $qry = $this->db->query("SELECT B.PRINT_STATUS,
  //     B.BIN_ID,
  //     B.BIN_NO || '-' || B.BIN_TYPE BIN_NAME,
  //     DECODE(BIN_TYPE,
  //            'NA',
  //            'W' || WA.WAREHOUSE_NO || '-' || M.RACK_NO || '-R' || ROW_NO || '-' ||
  //            B.BIN_TYPE || '-' || B.BIN_NO,
  //            B.BIN_TYPE || '-' || B.BIN_NO) BIN_NO
  // FROM BIN_MT B, LZ_RACK_ROWS RA, RACK_MT M, WAREHOUSE_MT WA
  // WHERE BIN_TYPE NOT IN ('No Bin')
  // AND B.CURRENT_RACK_ROW_ID = RA.RACK_ROW_ID
  // AND RA.RACK_ID = M.RACK_ID
  // AND  B.PRINT_STATUS='$PrintStatus'
  // AND B.BIN_TYPE=' $bin_type'
  // AND M.WAREHOUSE_ID = WA.WAREHOUSE_ID")->result_array();
  //     return $qry;
  //   }



  public function dropdowns()
  {

    $war_house = $this->db->query("SELECT WAREHOUSE_ID,WAREHOUSE_DESC FROM WAREHOUSE_MT")->result_array();
    $reack_house = $this->db->query("SELECT RACK_ID,RACK_NO FROM RACK_MT")->result_array();

    return array('war_house' => $war_house, 'reack_house' => $reack_house);
  }
  public function Search_printStatus()
  {

    $bin_type_search = $this->input->post('Bin_type'); //ID
    $print_sta = $this->input->post('PrintStatus');
    // var_dump($bin_type_search, $print_sta);
    // exit;
    // $qry = $this->db->query("SELECT WAREHOUSE_NO,WAREHOUSE_DESC,LOCATION FROM WAREHOUSE_MT order by WAREHOUSE_ID asc ")->result_array();

    // $rackqry = $this->db->query("SELECT RA.RACK_ID,RA.RACK_NO,WA.WAREHOUSE_DESC,RA.WIDTH,RA.HEIGHT,RA.NO_OF_ROWS,DECODE(RA.RACK_TYPE,1,'CAGE',2,'RACK') RACK_TYPE FROM RACK_MT RA ,WAREHOUSE_MT WA WHERE RA.WAREHOUSE_ID = WA.WAREHOUSE_ID and RA.RACK_ID <>0 ORDER BY RACK_ID ASC ")->result_array(); 

    $binqry = "SELECT B.PRINT_STATUS,
 B.BIN_ID,
 B.BIN_NO || '-' || B.BIN_TYPE BIN_NAME,
 DECODE(BIN_TYPE,
        'NA',
        'W' || WA.WAREHOUSE_NO || '-' || M.RACK_NO || '-R' || ROW_NO || '-' ||
        B.BIN_TYPE || '-' || B.BIN_NO,
        B.BIN_TYPE || '-' || B.BIN_NO) BIN_NO
FROM BIN_MT B, LZ_RACK_ROWS RA, RACK_MT M, WAREHOUSE_MT WA
WHERE BIN_TYPE NOT IN ('No Bin')
AND B.CURRENT_RACK_ROW_ID = RA.RACK_ROW_ID
AND RA.RACK_ID = M.RACK_ID
AND M.WAREHOUSE_ID = WA.WAREHOUSE_ID";

    if (!empty($bin_type_search) &&  $bin_type_search != 1) {

      $binqry .= " AND  BIN_TYPE = '$bin_type_search' ";
    }
    if (!empty($print_sta)) {
      $binqry .= " AND  PRINT_STATUS = '$print_sta'";
    }

    $binqry .= " ORDER BY BIN_TYPE,BIN_NO ";

    $binqry = $this->db->query($binqry)->result_array();

    // var_dump($this->db->last_query());
    // exit;

    return  $binqry;
  }

  public function add_bin()
  {
    $bin_type = $this->input->post('Bin_type');
    // var_dump( $bin_type); exit;
    $no_bin = $this->input->post('no_of_bins');

    ///var_dump($bin_type,$no_bin ); exit;
    $bin_array = "";
    $j = 1;
    if (!empty($bin_type) &&  $bin_type != 1) {
      // var_dump($bin_type);exit;
      for ($p = 0; $p < $no_bin; $p++) {
        $bin_pk = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('BIN_MT', 'BIN_ID')ID FROM DUAL")->result_array();
        $bin_pk = $bin_pk[0]['ID'];
        // var_dump($bin_pk);
        $bin_no = $this->db->query(" SELECT GET_BIN_NO('$bin_type') BIN_NO FROM DUAL ")->result_array();

        $bin_no = $bin_no[0]['BIN_NO'];
        $sav_war = $this->db->query("INSERT INTO BIN_MT(BIN_ID,BIN_NO,BIN_TYPE) VALUES('$bin_pk','$bin_no','$bin_type')");

        if ($no_bin > 1) {
          if ($j >= 1 && $j < $no_bin) {
            $bin_array .= $bin_pk . ",";
          }
          if ($j == $no_bin) {
            $bin_array .= $bin_pk;
          }
        } else {
          $bin_array .= $bin_pk;
        }
        $j++;
      }
    }

    $data = $this->db->query("SELECT B.PRINT_STATUS,
      B.BIN_ID,
      B.BIN_NO || '-' || B.BIN_TYPE BIN_NAME,
      DECODE(BIN_TYPE,
             'NA',
             'W' || WA.WAREHOUSE_NO || '-' || M.RACK_NO || '-R' || ROW_NO || '-' ||
             B.BIN_TYPE || '-' || B.BIN_NO,
             B.BIN_TYPE || '-' || B.BIN_NO) BIN_NO
 FROM BIN_MT B, LZ_RACK_ROWS RA, RACK_MT M, WAREHOUSE_MT WA
WHERE BIN_TYPE NOT IN ('No Bin')
  AND B.CURRENT_RACK_ROW_ID = RA.RACK_ROW_ID
  AND RA.RACK_ID = M.RACK_ID
  AND B.BIN_ID in ($bin_array)
  AND M.WAREHOUSE_ID = WA.WAREHOUSE_ID")->result_array();

    return  array("status" => true, "data" => $data);
    /********************************
     *   end Screen add bin
     *********************************/
  }


  /********************************
   *   start Screen item packing
   *********************************/
  public function get_barcode()
  {

    $barcode = $this->input->post('barcode');
    // var_dump($barcode);
    $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array();
    $str = strlen($barcode); //if length = 12 its ebay id

    if ($str == 12) {
      $ebY_deta = $this->db->query(" SELECT B.BARCODE_NO,
         CASE
           WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND
                DE.TRACKING_NUMBER IS NOT NULL THEN
            'SOLD || SHIPPED'
           WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND
                DE.TRACKING_NUMBER IS NULL THEN
            'SOLD || NOT SHIPPED'
           ELSE
            'AVAILABLE'
         END STATUS,
         B.EBAY_ITEM_ID,
         I.ITEM_DESC DESCR,
         I.ITEM_MT_MANUFACTURE MANUF,
          I.ITEM_MT_MFG_PART_NO MPN,
          I.ITEM_MT_UPC UPC,
         CO.COND_NAME CONDI,
         BI.BIN_ID,
         BI.BIN_TYPE || '-' || BI.BIN_NO BIN_NAME,
         DECODE(ROW_NO,
                0,
                RC.RACK_NO,
                'W' || '' || WA.WAREHOUSE_NO || '-' || RC.RACK_NO || '-R' ||
                RA.ROW_NO) RACK_NAME,
         (SELECT DT.BARCODE_NO
            FROM LJ_BIN_VERIFY_DT DT
           WHERE DT.BARCODE_NO = B.BARCODE_NO
             AND ROWNUM = 1) VERIFIED_YN
    FROM LZ_BARCODE_MT    B,
         LZ_SALESLOAD_DET DE,
         ITEMS_MT         I,
         LZ_ITEM_COND_MT  CO,
         BIN_MT           BI,
         LZ_RACK_ROWS     RA,
         RACK_MT          RC,
         WAREHOUSE_MT     WA
   WHERE B.EBAY_ITEM_ID = $barcode
     AND B.ITEM_ID = I.ITEM_ID
     AND B.BIN_ID = BI.BIN_ID(+)
     AND BI.CURRENT_RACK_ROW_ID = RA.RACK_ROW_ID
     AND RA.RACK_ID = RC.RACK_ID
     AND B.SALE_RECORD_NO = DE.SALES_RECORD_NUMBER(+)
     AND RC.WAREHOUSE_ID = WA.WAREHOUSE_ID
     AND B.CONDITION_ID = CO.ID(+)
   ")->result_array();

      return array('ebY_deta' => $ebY_deta, 'eby_qyery' => true, 'images' => $conditions);
    } else {

      $bar_query = $this->db->query(" SELECT B.BARCODE_NO FROM LZ_BARCODE_MT  B WHERE B.BARCODE_NO ='$barcode'");

      if ($bar_query->num_rows() > 0) {
        $bar_query = $bar_query->result_array();
        $bar_no = $bar_query[0]['BARCODE_NO'];

        $bar_deta = $this->db->query(" SELECT B.BARCODE_NO,
         CASE
           WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND
                DE.TRACKING_NUMBER IS NOT NULL THEN
            'SOLD || SHIPPED'
           WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND
                DE.TRACKING_NUMBER IS NULL THEN
            'SOLD || NOT SHIPPED'
           ELSE
            'AVAILABLE'
         END STATUS,
         B.EBAY_ITEM_ID,
         I.ITEM_DESC DESCR,
         I.ITEM_MT_MANUFACTURE MANUF,
         I.ITEM_MT_MFG_PART_NO MPN,
          I.ITEM_MT_UPC UPC,
         CO.COND_NAME CONDI,
         BI.BIN_ID,
         BI.BIN_TYPE || '-' || BI.BIN_NO BIN_NAME,
         DECODE(ROW_NO,
                0,
                RC.RACK_NO,
                'W' || '' || WA.WAREHOUSE_NO || '-' || RC.RACK_NO || '-R' ||
                RA.ROW_NO) RACK_NAME,
                (SELECT DT.BARCODE_NO
            FROM LJ_BIN_VERIFY_DT DT
           WHERE DT.BARCODE_NO = B.BARCODE_NO
             AND ROWNUM = 1) VERIFIED_YN
    FROM LZ_BARCODE_MT    B,
         ITEMS_MT         I,
         LZ_SALESLOAD_DET DE,
         LZ_ITEM_COND_MT  CO,
         BIN_MT           BI,
         LZ_RACK_ROWS     RA,
         RACK_MT          RC,
         WAREHOUSE_MT     WA
   WHERE B.BARCODE_NO = $bar_no
     AND B.ITEM_ID = I.ITEM_ID
     AND B.SALE_RECORD_NO = DE.SALES_RECORD_NUMBER(+)
     AND B.BIN_ID = BI.BIN_ID(+)
     AND BI.CURRENT_RACK_ROW_ID = RA.RACK_ROW_ID
     AND RA.RACK_ID = RC.RACK_ID
     AND RC.WAREHOUSE_ID = WA.WAREHOUSE_ID
     AND B.CONDITION_ID = CO.ID(+) ")->result_array();


        return array('bar_deta' => $bar_deta, 'bar_query' => true, 'status' => true); // if barcode valid
      } else {

        $bar_deta = $this->db->query("SELECT B.BARCODE_PRV_NO BARCODE_NO,
         'NULL' EBAY_ITEM_ID,
         'NULL' DESCR,
         'NULL' MANUF,
          NULL UPC,
          NULL MPN,
         CO.COND_NAME CONDI,
         BI.BIN_ID,
         BI.BIN_TYPE || '-' || BI.BIN_NO BIN_NAME,
         DECODE(ROW_NO,
                0,
                RC.RACK_NO,
                'W' || '' || WA.WAREHOUSE_NO || '-' || RC.RACK_NO || '-R' ||
                RA.ROW_NO) RACK_NAME,
                (SELECT DT.BARCODE_NO
            FROM LJ_BIN_VERIFY_DT DT
           WHERE DT.BARCODE_NO = B.BARCODE_PRV_NO
             AND ROWNUM = 1) VERIFIED_YN
    FROM LZ_DEKIT_US_DT  B,
         LZ_ITEM_COND_MT CO,
         BIN_MT          BI,
         LZ_RACK_ROWS    RA,
         RACK_MT         RC,
         WAREHOUSE_MT    WA
   WHERE B.BARCODE_PRV_NO = $barcode
     AND B.BIN_ID = BI.BIN_ID(+)
     AND BI.CURRENT_RACK_ROW_ID = RA.RACK_ROW_ID
     AND RA.RACK_ID = RC.RACK_ID
     AND RC.WAREHOUSE_ID = WA.WAREHOUSE_ID
     AND B.CONDITION_ID = CO.ID(+)
   ")->result_array();

        return array('bar_deta' => $bar_deta, 'det_bar' => true, 'status' => false);
        //} // if barcode not valid
      }
    } // main if str length

  }



  public function updatePacking()
  {
    $packing_id     = $this->input->post('packing');
    $packing_barcode     = $this->input->post('barcode');
    $user_id     = $this->input->post('userid');
    // var_dump($packing_id, $packing_barcode,$user_id); exit;
    date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $packing_date = "TO_DATE('" . $date . "', 'YYYY-MM-DD HH24:MI:SS')";

    $updatePacking = $this->db->query("UPDATE LZ_BARCODE_MT SET PACKING_ID = '$packing_id', PACKING_BY = '$user_id', PACKING_DATE = sysdate  WHERE BARCODE_NO = '$packing_barcode'");
    if ($updatePacking) {
      return array('status' => 1);
    } else {
      return array('status' => 0);
    }
  }


  public function get_packing_drop()
  {

    // var_dump($rack_id); exit;
    $qry = $this->db->query("SELECT PACKING_ID,
    PACKING_NAME FROM lz_packing_type_mt")->result_array();
    return $qry;
  }

  /********************************
   *   end Screen item packing
   *********************************/
}
