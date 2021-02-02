<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');
class m_dekitting extends CI_Model{

public function __construct(){
    parent::__construct();
    $this->load->database();
  }

/*======================================
=            ADIL METHODS            =
======================================*/


		public function searchMasterBarcode($master_barcode)
		{
			// $LZ_BARCODE_MT = "select * from lz_barcode_mt m where m.barcode_no = '".$master_barcode."'";
			$LZ_SPECIAL_LOTS = "SELECT L.BARCODE_PRV_NO BARCODE_NO,
													L.MPN_DESCRIPTION ITEM_DESC,
													L.FOLDER_NAME,
													L.CARD_UPC UPC,
													L.CARD_MPN MPN,
													L.BRAND,
													L.CONDITION_ID,
													C.COND_NAME CONDITION,
													L.LZ_DEKIT_US_MT_ID,
													'0' child_enable --'1' for TRUE, '0' for FALSE
										FROM LZ_SPECIAL_LOTS L, LZ_ITEM_COND_MT C, LZ_BARCODE_MT BM
										WHERE L.CONDITION_ID = C.ID(+)
											AND L.BARCODE_PRV_NO ='".$master_barcode."'
											AND BM.BARCODE_NO(+) = L.BARCODE_PRV_NO
										--	AND BM.EBAY_ITEM_ID IS NULL";
			$LZ_MERCHANT_BARCODE_DT = "select D.BARCODE_NO,'0' child_enable --'1' for TRUE, '0' for FALSE 
			from LZ_MERCHANT_BARCODE_DT D where D.BARCODE_NO = '".$master_barcode."'";
			$barcode_avail = "";
			$barcode_scope = "";
			$det  = "";
			$path = "";
			$url = "";
			$image_path_array = [];

			/**
			 * Check in LZ_BARCODE_MT if barcode exists.
			 */
			// if($this->db->query($LZ_BARCODE_MT)->num_rows() > 0){
			// 	$barcode_scope = "LZ_BARCODE_MT";
			// 	$barcode_avail = "SELECT B.BARCODE_NO, B.ITEM_ID, I.ITEM_DESC, I.ITEM_MT_MFG_PART_NO, I.ITEM_MT_UPC, I.ITEM_MT_MANUFACTURE, I.ITEM_CONDITION
      //   FROM LZ_BARCODE_MT B, LZ_MANIFEST_DET DE, ITEMS_MT I, LZ_DEKIT_US_MT K, LZ_ITEM_COND_MT CM
      //  WHERE B.BARCODE_NO = '".$master_barcode."'
      //    AND B.ITEM_ID = I.ITEM_ID
      //    AND I.ITEM_CODE = DE.LAPTOP_ITEM_CODE
      //    AND B.LZ_MANIFEST_ID = DE.LZ_MANIFEST_ID
      //    AND B.BARCODE_NO = K.BARCODE_NO
      //    AND ROWNUM <= 1";

			// }
			/**
			 * Check in LZ_SPECIAL_LOTS if barcode exists.
			 */
			// else 
			if($this->db->query($LZ_SPECIAL_LOTS)->num_rows() > 0){
				$barcode_scope = "LZ_SPECIAL_LOTS";
				$barcode_avail = "  SELECT L.BARCODE_PRV_NO BARCODE_NO,
														L.MPN_DESCRIPTION ITEM_DESC,
														L.FOLDER_NAME,
														L.CARD_UPC UPC,
														L.CARD_MPN MPN,
														L.BRAND,
														L.CONDITION_ID,
														C.COND_NAME CONDITION,
														K.LZ_DEKIT_US_MT_ID,
														'1' child_enable --'1' for TRUE, '0' for FALSE
											FROM LZ_SPECIAL_LOTS L, LZ_ITEM_COND_MT C,  LZ_DEKIT_US_MT K
											WHERE L.CONDITION_ID = C.ID(+)
											AND K.LZ_DEKIT_US_MT_ID = L.LZ_DEKIT_US_MT_ID
											AND L.BARCODE_PRV_NO ='".$master_barcode."'";
				$LZ_SPECIAL_LOTS = $this->db->query($LZ_SPECIAL_LOTS)->result_array();

			}
			/**
			 * Check in LZ_MERCHANT_BARCODE_DT if barcode exists.
			 */
			else if($this->db->query($LZ_MERCHANT_BARCODE_DT)->num_rows() > 0){
				$barcode_scope = "LZ_MERCHANT_BARCODE_DT";
				$barcode_avail = "SELECT BT.BARCODE_NO,
													BT.UPC,
													BT.MPN,
													BT.ITEM_DESC,
													BT.BRAND,
													CM.COND_NAME CONDITION,
													BT.FOLDER_NAME,
													DT.LZ_DEKIT_US_MT_ID,
													'1' child_enable --'1' for TRUE, '0' for FALSE
										FROM LZ_MERCHANT_BARCODE_DT BT, LZ_DEKIT_US_MT DT, LZ_ITEM_COND_MT CM
										WHERE BT.LZ_DEKIT_US_MT_ID = DT.LZ_DEKIT_US_MT_ID
											AND CM.ID = BT.COND_ID
											AND BT.BARCODE_NO = '".$master_barcode."'";
				$LZ_MERCHANT_BARCODE_DT = $this->db->query($LZ_MERCHANT_BARCODE_DT)->result_array();
			}
			else{
				// $barcode_scope = "not a valid barcode";
				// echo "not a valid barcode";
				return array('invalid'=> 2);
			}
			if(!empty($barcode_avail))
			{
				$DEKITTED = $this->db->query($barcode_avail);
				if($DEKITTED->num_rows() > 0)
				{
					$DEKITTED = $DEKITTED->result_array();
					// if($barcode_scope == "LZ_BARCODE_MT")
					// {
					// 	$det = $this->db->query("SELECT D.LZ_DEKIT_US_DT_ID,C.COND_NAME,DECODE(D.PRINT_STATUS,0,'False',1,'True',D.PRINT_STATUS) PRINT_STATUS,D.BARCODE_PRV_NO,B.BIN_TYPE ||'-'|| B.BIN_NO BIN_NO,O.OBJECT_NAME,D.DEKIT_REMARKS,D.PIC_NOTES,D.WEIGHT,D.CONDITION_ID FROM LZ_DEKIT_US_MT M, LZ_DEKIT_US_DT D,LZ_BD_OBJECTS_MT O,BIN_MT B,LZ_ITEM_COND_MT C WHERE M.BARCODE_NO = $master_barcode AND M.LZ_DEKIT_US_MT_ID = D.LZ_DEKIT_US_MT_ID AND D.OBJECT_ID = O.OBJECT_ID(+) AND B.BIN_ID (+)= D.BIN_ID  AND D.CONDITION_ID = C.ID(+) ORDER BY D.BARCODE_PRV_NO desc"); $det = $det->result_array();
					// 	$path = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 2");
					// 	$path = $path->result_array();
					// 	$path = $path[0]['MASTER_PATH'].$DEKITTED[0]['BARCODE_NO'];

					// }
					// else 
					if($barcode_scope == "LZ_SPECIAL_LOTS")
					{
						$det = $this->db->query("SELECT D.LZ_DEKIT_US_DT_ID,C.COND_NAME,D.PRINT_STATUS,D.BARCODE_PRV_NO BARCODE_NO,B.BIN_TYPE ||'-'|| B.BIN_NO BIN_NO,O.OBJECT_NAME,D.DEKIT_REMARKS,D.PIC_NOTES,D.WEIGHT,D.CONDITION_ID FROM LZ_DEKIT_US_MT M, LZ_DEKIT_US_DT D,LZ_BD_OBJECTS_MT O,BIN_MT B,LZ_ITEM_COND_MT C WHERE M.BARCODE_NO = $master_barcode AND M.LZ_DEKIT_US_MT_ID = D.LZ_DEKIT_US_MT_ID AND D.OBJECT_ID = O.OBJECT_ID(+) AND B.BIN_ID (+)= D.BIN_ID  AND D.CONDITION_ID = C.ID(+) ORDER BY D.BARCODE_PRV_NO desc"); $det = $det->result_array();
						$path = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 2");
						$path = $path->result_array();
						$path = $path[0]['MASTER_PATH'].$DEKITTED[0]['FOLDER_NAME'];
					}
					else if($barcode_scope == "LZ_MERCHANT_BARCODE_DT")	
					{
						$det = $this->db->query("SELECT D.LZ_DEKIT_US_DT_ID,C.COND_NAME,D.PRINT_STATUS,D.BARCODE_PRV_NO BARCODE_NO,B.BIN_TYPE ||'-'|| B.BIN_NO BIN_NO,O.OBJECT_NAME,D.DEKIT_REMARKS,D.PIC_NOTES,D.WEIGHT,D.CONDITION_ID FROM LZ_DEKIT_US_MT M, LZ_DEKIT_US_DT D,LZ_BD_OBJECTS_MT O,BIN_MT B,LZ_ITEM_COND_MT C WHERE M.BARCODE_NO = $master_barcode AND M.LZ_DEKIT_US_MT_ID = D.LZ_DEKIT_US_MT_ID AND D.OBJECT_ID = O.OBJECT_ID(+) AND B.BIN_ID (+)= D.BIN_ID  AND D.CONDITION_ID = C.ID(+) ORDER BY D.BARCODE_PRV_NO desc"); $det = $det->result_array();
						$path = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 2");
						$path = $path->result_array();
						$path = $path[0]['MASTER_PATH'].$DEKITTED[0]['FOLDER_NAME'];
					}
					$images = "";
					// return "barcode is already dekitted";
					// return 2;
					$m_flag = false;
					if(is_dir(@$path)){
						// var_dump($d_dir);
						 $iterator = new \FilesystemIterator(@$path);
							 if(@$iterator->valid()){    
									 $m_flag = true;
							 }else{
								 $m_flag = false;
							 }
						}
						if($m_flag)
						{
							if(is_dir($path))
							{
								$images = scandir($path);
								if(count($images) > 0)
								{
									for($i=2; $i<count($images)-1; $i++)
									{
									$image_path_array[$i-2] = $images[$i];}
								}
							}
						}

					return array('mt'=>$DEKITTED ,'det'=>$det ,'barcode_scope'=>$barcode_scope,'image'=>$image_path_array,'dir_path'=>$path);

				}
				// return "barcode is available to dekit in"+ $barcode_scope;
				else {
					$mt = "";
					// if($barcode_scope == "LZ_BARCODE_MT")
					// {
					// 		$BARCODE_MT_DETAIL = "SELECT B.BARCODE_NO, B.ITEM_ID, I.ITEM_DESC, I.ITEM_MT_MFG_PART_NO, I.ITEM_MT_UPC, I.ITEM_MT_MANUFACTURE, I.ITEM_CONDITION
					// 		FROM LZ_BARCODE_MT B, LZ_MANIFEST_DET DE, ITEMS_MT I, 
					// 		LZ_ITEM_COND_MT CM
					// 	 WHERE B.BARCODE_NO = '".$master_barcode."'
					// 		 AND B.ITEM_ID = I.ITEM_ID
					// 		 AND I.ITEM_CODE = DE.LAPTOP_ITEM_CODE
					// 		 AND B.LZ_MANIFEST_ID = DE.LZ_MANIFEST_ID
					// 		 AND ROWNUM <= 1";
					// 		 $mt = $this->db->query($BARCODE_MT_DETAIL)->result_array();
							
					// }
					// else 
					if($barcode_scope == "LZ_SPECIAL_LOTS" )
					{
							$mt = $LZ_SPECIAL_LOTS;
							$path = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 2");
							$path = $path->result_array();
							$path = $path[0]['MASTER_PATH'].$mt[0]['FOLDER_NAME'];
					}
					else if($barcode_scope == "LZ_MERCHANT_BARCODE_DT")
					{
						  $mt = $LZ_MERCHANT_BARCODE_DT;
					}
					$images = "";
					// return "barcode is already dekitted";
					// return 2;
					$m_flag = false;
					if(is_dir(@$path)){
						// var_dump($d_dir);
						 $iterator = new \FilesystemIterator(@$path);
							 if(@$iterator->valid()){    
									 $m_flag = true;
							 }else{
								 $m_flag = false;
							 }
						}
						if($m_flag)
						{
							if(is_dir($path))
							{
								$images = scandir($path);
								if(count($images) > 0)
								{
									for($i=2; $i<count($images)-1; $i++)
									{
									$image_path_array[$i-2] = $images[$i];}
								}
							}
						}
						return array('mt'=>$mt ,'barcode_scope'=>$barcode_scope,'image'=>$image_path_array,'dir_path'=>$path);
				}
				
			}
			else{
				// return $barcode_scope;
				return array('valid'=> 0);
			}
		}
		public function createMasterDekit($masterBarcode, $userId)
		{
			$qry_single_pk = "select get_single_primary_key('LZ_DEKIT_US_MT', 'LZ_DEKIT_US_MT_ID') pk from dual";
			$qry_single_pk = $this->db->query($qry_single_pk)->result_array();
			// var_dump($qry_single_pk[0]);
			// echo($qry_single_pk[0]['pk']);
			// exit;
			$qry_insert_mt = "INSERT INTO LZ_DEKIT_US_MT
			(LZ_DEKIT_US_MT_ID, BARCODE_NO, DEKIT_BY, DEKIT_DATE_TIME)
		VALUES
			('".$qry_single_pk[0]['PK']."',
			'".$masterBarcode->barcode_no."',
			 '".$userId."',
			 SYSDATE)
		";
			//   //var_dump($qry_insert_mt);exit;
			$result =	$this->db->query($qry_insert_mt);
				if($masterBarcode->barcodeScope == "LZ_MERCHANT_BARCODE_DT")
				{
					$qry_update_merchant_det = "UPDATE LZ_MERCHANT_BARCODE_DT DT  SET DT.LZ_DEKIT_US_MT_ID = '".$qry_single_pk[0]['PK']."',
																																						DT.ITEM_DESC         = '".$masterBarcode->item_desc."',
																																						DT.COND_ID           = '".$masterBarcode->condition_id."',
																																						DT.UPC               = '".$masterBarcode->UPC."',
																																						DT.MPN               = '".$masterBarcode->MPN."',
																																						DT.BRAND             = '".$masterBarcode->Brand."',
																																						DT.FOLDER_NAME       = '".$masterBarcode->folderName."'
																																				WHERE 
																																						DT.BARCODE_NO = '".$masterBarcode->barcode_no."'";
				$result =	$this->db->query($qry_update_merchant_det);
				}
				else if($masterBarcode->barcodeScope == "LZ_SPECIAL_LOTS")
				{
					$qry_update_special_lots = "UPDATE LZ_SPECIAL_LOTS L SET L.CARD_UPC = '".$masterBarcode->UPC."',
																																						L.MPN_DESCRIPTION = '".$masterBarcode->item_desc."',
																																						L.CARD_MPN = '".$masterBarcode->MPN."',
																																						L.CONDITION_ID = '".$masterBarcode->condition_id."',
																																						L.LZ_DEKIT_US_MT_ID = '".$qry_single_pk[0]['PK']."',
																																						L.FOLDER_NAME = '".$masterBarcode->folderName."',
																																						L.BRAND   = '".$masterBarcode->Brand."'
																																				 WHERE 
																																						L.BARCODE_PRV_NO = '".$masterBarcode->barcode_no."'";
								$result =	$this->db->query($qry_update_special_lots);			
				}
				if($result == "1")
				$result = $qry_single_pk[0]['PK'];
				else
				$result = "";
			return $result;
		}

		public function getNewBarcode()
		{
			$qry_single_pk = "select seq_barcode_no.nextval barcode from dual";
			$qry_single_pk = $this->db->query($qry_single_pk)->result_array();

			return array('BARCODE' => $qry_single_pk[0]['BARCODE']);
		}

		public function createChildDekit($childBarcode, $mt_id)
		{
			$qry_insert_mt = "INSERT INTO LZ_DEKIT_US_DT
			(LZ_DEKIT_US_DT_ID,
			 LZ_DEKIT_US_MT_ID,
			 BARCODE_PRV_NO,
			 CONDITION_ID,
			 WEIGHT,
			 DEKIT_REMARKS,
			 PRINT_STATUS)
		VALUES
			(get_single_primary_key('LZ_DEKIT_US_DT', 'LZ_DEKIT_US_DT_ID'),
			'".$mt_id."',
			'".$childBarcode->barcode."',
			'".$childBarcode->cond_id."',
			'".$childBarcode->weight."',
			'".$childBarcode->dekittingRemarks."',
			'".$childBarcode->printStatus."'
			)
		
		";
			//   //var_dump($qry_insert_mt);exit;
			$result =	$this->db->query($qry_insert_mt);

			if($result == "1")
				$result = "success";
				else
				$result = "failure";
			return $result;
		}

    // public function searchBarcode($master_barcode){ 

		
		// $barcode_mt_avail = $this->db->query("SELECT B.BARCODE_NO,B.ITEM_ID FROM LZ_BARCODE_MT B, LZ_MANIFEST_DET DE,ITEMS_MT I WHERE B.BARCODE_NO = $master_barcode AND B.ITEM_ID = I.ITEM_ID AND I.ITEM_CODE = DE.LAPTOP_ITEM_CODE AND B.LZ_MANIFEST_ID = DE.LZ_MANIFEST_ID AND B.BARCODE_NO in  (SELECT K.BARCODE_NO FROM LZ_DEKIT_US_MT K) AND ROWNUM <=1 ");


		// // OLD BARCODE CHECK $barcode_avail = $this->db->query("SELECT B.BARCODE_NO,,B.ITEM_ID FROM LZ_BARCODE_MT     B, LZ_MANIFEST_MT    M, /*LZ_BD_TRACKING_NO T, */LZ_SINGLE_ENTRY   S WHERE B.LZ_MANIFEST_ID = M.LZ_MANIFEST_ID AND M.SINGLE_ENTRY_ID = S.ID /*AND S.ID = T.LZ_SINGLE_ENTRY_ID*/ AND B.BARCODE_NO = $master_barcode /*AND T.LZ_ESTIMATE_ID IS NULL*/ AND B.BARCODE_NO in  (SELECT K.BARCODE_NO FROM LZ_DEKIT_US_MT K)");

		// // $add_barcode_comp = $this->db->query("SELECT B.BARCODE_NO,,B.ITEM_ID FROM LZ_BARCODE_MT     B, LZ_MANIFEST_MT    M, LZ_BD_TRACKING_NO T, LZ_SINGLE_ENTRY   S WHERE B.LZ_MANIFEST_ID = M.LZ_MANIFEST_ID AND M.SINGLE_ENTRY_ID = S.ID AND S.ID = T.LZ_SINGLE_ENTRY_ID AND B.BARCODE_NO = $master_barcode AND T.LZ_ESTIMATE_ID IS NULL AND B.BARCODE_NO not in  (SELECT K.BARCODE_NO FROM LZ_DEKIT_US_MT K)");

		// $barcod_valid = $this->db->query("select * from LZ_MERCHANT_BARCODE_DT D WHERE D.BARCODE_NO = $master_barcode ");



		// if ($barcode_mt_avail->num_rows() > 0) {			

		// $det = $this->db->query("SELECT D.LZ_DEKIT_US_DT_ID,C.COND_NAME,DECODE(D.PRINT_STATUS,0,'False',1,'True',D.PRINT_STATUS) PRINT_STATUS,D.BARCODE_PRV_NO,B.BIN_TYPE ||'-'|| B.BIN_NO BIN_NO,O.OBJECT_NAME,D.DEKIT_REMARKS,D.PIC_NOTES,D.WEIGHT,D.CONDITION_ID FROM LZ_DEKIT_US_MT M, LZ_DEKIT_US_DT D,LZ_BD_OBJECTS_MT O,BIN_MT B,LZ_ITEM_COND_MT C WHERE M.BARCODE_NO = $master_barcode AND M.LZ_DEKIT_US_MT_ID = D.LZ_DEKIT_US_MT_ID AND D.OBJECT_ID = O.OBJECT_ID(+) AND B.BIN_ID (+)= D.BIN_ID  AND D.CONDITION_ID = C.ID(+) ORDER BY D.BARCODE_PRV_NO desc"); $det = $det->result_array();
		// // var_dump($det[0]['CONDITION_ID']);exit;
		// $path = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 2");
		// $path = $path->result_array();

		// // var_dump($path[0]["MASTER_PATH"]);exit;
		// $flag = [];
		// $i = 0;
		// $master_path = $path[0]["MASTER_PATH"];
		// $dir_path = [];
		// foreach (@$det as $row){
	  //     $it_condition  = @$row['CONDITION_ID'];
		//   if(is_numeric(@$it_condition)){
		//         if(@$it_condition == 3000){
		//           @$it_condition = 'Used';
		//         }elseif(@$it_condition == 1000){
		//           @$it_condition = 'New'; 
		//         }elseif(@$it_condition == 1500){
		//           @$it_condition = 'New other'; 
		//         }elseif(@$it_condition == 2000){
		//             @$it_condition = 'Manufacturer refurbished';
		//         }elseif(@$it_condition == 2500){
		//           @$it_condition = 'Seller refurbished'; 
		//         }elseif(@$it_condition == 7000){
		//           @$it_condition = 'For parts or not working'; 
		//         }
		//       }
		//         // if($det[$i]['DEKIT_REMARKS'] == null){
		//         // 	$det[$i]['DEKIT_REMARKS'] == '';
		//         // }
		//         $barcode_prv_no = $row["BARCODE_PRV_NO"];
		//         $m_dir =  $master_path.$barcode_prv_no."/thumb/";
		        
		//         $m_dir = preg_replace("/[\r\n]*/","",$m_dir);

		//         if(is_dir(@$m_dir)){
    //                 $iterator = new \FilesystemIterator(@$m_dir);
    //                 if (@$iterator->valid()){    
    //                   $m_flag = true;
    //                   $flag[$i] = $m_flag;

    //                    $images = scandir($m_dir);
    //                 // Image selection and display:
    //                 //display first image
	  //                 if (count($images) > 0) { // make sure at least one image exists
	  //                     $url = $images[2]; // first image
	  //                     $img = file_get_contents($m_dir.$url);
	  //                     // var_dump($img);exit;
	  //                     $img =base64_encode($img);
	  //                     $dir_path[$i] = $img;
	  //                 }else{
	  //                 	$dir_path[$i] = $m_dir;
	  //                 }

    //               }else{
    //                 $m_flag = false;
    //                 $flag[$i] = $m_flag;
    //               }
    //           	}else{
	  //               $m_flag = false;
	  //               $flag[$i] = $m_flag;
	  //           }

	  //           $i++;
		// }
		// return array('det'=>$det ,'res'=>2,'flag'=>$flag,'dir_path'=>$dir_path);
		// }
		// else if()
		// else if($barcod_valid->num_rows() > 0) {
		// 	return 1; // for adding new items
		// }else{

		// 	return 3; // barcode not valid
		// }
    // }

    
}