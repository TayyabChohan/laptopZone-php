<?php
if (!defined('BASEPATH'))
 exit('No direct script access allowed');
 
class m_itemHistory extends CI_Model
{
	
	public function item_manifest($barcode){
		$condition_id='';
		if (!empty($barcode) && is_numeric($barcode) ){
			$check_barcode = $this->db->query("SELECT * FROM LZ_BARCODE_MT WHERE BARCODE_NO=$barcode");
			if ($check_barcode->num_rows() > 0) {
					foreach ($check_barcode->result_array() as $check)
					{
						$condition_id=$check['CONDITION_ID'];
					} 
				}
 
				// location start
				//$loc_his = '';
				$loc_his  = $this->db->query(" SELECT BB.BARCODE_NO,TO_CHAR(L.TRANS_DATE_TIME, 'DD/MM/YYYY HH24:MI:SS')  TRAN_DA, M.ITEM_DESC TITLE, M.USER_NAME  TRANSFER_BY, L.NEW_LOC_ID, L.OLD_LOC_ID, DECODE(NEW_B.CURRENT_RACK_ROW_ID, 0, 'No Rack' || '-' || NEW_B.BIN_TYPE || '' || NEW_B.BIN_NO, 'W' || '' || WA.WAREHOUSE_NO || '-' || RAC.RACK_NO || '-R' || RO.ROW_NO || '-' || NEW_B.BIN_TYPE || '' || NEW_B.BIN_NO) NEW_LOCATION, DECODE(OLD_B.CURRENT_RACK_ROW_ID, 0, 'No Rack' || '-' || OLD_B.BIN_TYPE || '' || OLD_B.BIN_NO, 'W' || '' || OL_WA.WAREHOUSE_NO || '-' || OLD_RAC.RACK_NO || '-R' || RO_OLD.ROW_NO || '-' || OLD_B.BIN_TYPE || '' || OLD_B.BIN_NO) OLD_LOCATION FROM LZ_LOC_TRANS_LOG L, LZ_BARCODE_MT BB, EMPLOYEE_MT M, BIN_MT NEW_B, BIN_MT  OLD_B, LZ_RACK_ROWS RO,LZ_RACK_ROWS  RO_OLD, RACK_MT  RAC, RACK_MT OLD_RAC, WAREHOUSE_MT WA, WAREHOUSE_MT  OL_WA, ITEMS_MT M WHERE L.BARCODE_NO = '$barcode'AND BB.ITEM_ID = M.ITEM_ID AND L.NEW_LOC_ID = NEW_B.BIN_ID AND NEW_B.CURRENT_RACK_ROW_ID = RO.RACK_ROW_ID AND RO.RACK_ID = RAC.RACK_ID AND RAC.WAREHOUSE_ID = WA.WAREHOUSE_ID  AND BB.BARCODE_NO = L.BARCODE_NO AND L.TRANS_BY_ID = M.EMPLOYEE_ID  AND L.OLD_LOC_ID = OLD_B.BIN_ID AND OLD_B.CURRENT_RACK_ROW_ID = RO_OLD.RACK_ROW_ID AND RO_OLD.RACK_ID = OLD_RAC.RACK_ID AND OLD_RAC.WAREHOUSE_ID = OL_WA.WAREHOUSE_ID  ORDER BY L.LOC_TRANS_ID ASC ")->result_array();


				$buyer_his  = $this->db->query("SELECT B.EBAY_ITEM_ID, D.ITEM_TITLE, D.TRACKING_NUMBER, D.BUYER_FULLNAME, TO_CHAR(D.SALE_DATE, 'DD/MM/YYYY HH24:MI:SS') SALE_DATE, TO_CHAR(D.SHIPPED_ON_DATE, 'DD/MM/YYYY HH24:MI:SS') SHIPPED_ON_DATE, (SELECT DECODE(M.LZ_SELLER_ACCT_ID, 2, 'DFWONLINE', 1, 'TECHBARGAINS2015') FROM LZ_SALESLOAD_MT M WHERE M.LZ_SALELOAD_ID = D.LZ_SALELOAD_ID) ACOUNT FROM LZ_BARCODE_MT B, LZ_SALESLOAD_DET D WHERE B.BARCODE_NO = '$barcode' AND B.SALE_RECORD_NO = D.SALES_RECORD_NUMBER ")->result_array(); // location end



				if ($condition_id!='') {
					  /*//////////////////////////////////////////////////////////
				      //       FOR CHECKING IF BARCODE IS DELETED BARCODE       //
				      //////////////////////////////////////////////////////////*/
				      $deletions=$this->db->query("SELECT ITEM_CONDITION, DELETED_BY, TO_CHAR(DEL_DATE, 'DD/MM/YYYY HH24:MI:SS') AS DEL_DATE, ITEM_TITLE, REMARKS FROM LZ_DELETION_LOG L WHERE L.BARCODE= $barcode");
				      if ($deletions->num_rows() > 0){
				        foreach ($deletions->result_array() as $deletion)
				          {
				            $condition=$deletion['ITEM_CONDITION'];
				            $deleted_date=$deletion['DEL_DATE'];
				            $deleted_by_id=$deletion['DELETED_BY'];
				            $item_title=$deletion['ITEM_TITLE'];
				            $remarks=$deletion['REMARKS'];
				            $deletions = $this->db->query("SELECT T.USER_NAME FROM EMPLOYEE_MT T WHERE T.EMPLOYEE_ID= $deleted_by_id");
				          }
				        $data_array =  array(
				                'condition'=>$condition,
				                'deleted_date'=>$deleted_date,
				                'deleted_by_id'=>$deleted_by_id,
				                'item_title'=>$item_title,
				                'remarks'=>$remarks,
				                'deletions'=>$deletions,
				                'return'=>'false' 
				              );  
				      }elseif($deletions->num_rows()==0){
				        /*//////////////////////////////////////////////////////////
				        //         FOR IF BARCODE IS NOT DELETED BARCODE          //
				        //////////////////////////////////////////////////////////*/

				        /*//////////////FOR MANIFEST ////////////////////////*/
				        $manifests=$this->db->query("SELECT B.EBAY_ITEM_ID, CM.COND_NAME, DECODE(P.TRANS_STATUS,NULL,'NOT PULLED','P','PULLED','C','CANCELLED') PULL_STAT, P.PULLER_NAME, TO_CHAR(B.AUDIT_DATETIME, 'DD/MM/YYYY HH24:MI:SS') AUDIT_DATETIME, B.LZ_MANIFEST_ID, B.BARCODE_NO, DECODE(PRINT_STATUS, 1, 'YES', 0, 'NO') PRINT_STATUS, DECODE(B.EBAY_STICKER, 1, 'YES', 0, 'NO') AUDIT_ITEM, M.USER_NAME, CASE WHEN MT.MANIFEST_TYPE = 0 AND MT.SINGLE_ENTRY_ID IS NOT NULL THEN 'SINGLE ENTRY ITEM'WHEN MT.MANIFEST_TYPE = 0 AND MT.SINGLE_ENTRY_ID IS  NULL THEN 'EXCEL UPLOAD'WHEN MT.MANIFEST_TYPE = 2 THEN 'LOT ITEM'WHEN MT.MANIFEST_TYPE = 3 THEN 'DEKIT ITEM'WHEN MT.MANIFEST_TYPE = 4 THEN 'SPECIAL LOT ITEM' END ITEM_SOURCE, (SELECT M.USER_NAME FROM LZ_TESTING_DATA T,EMPLOYEE_MT MM WHERE T.LZ_BARCODE_ID = (SELECT LZ_BARCODE_MT_ID FROM LZ_BARCODE_MT WHERE BARCODE_NO = B.BARCODE_NO) AND MM.EMPLOYEE_ID = T.USER_ID(+) AND ROWNUM = 1 ) TEST_BY, (SELECT TO_CHAR(TEST_TIMESTAMP, 'DD/MM/YYYY HH24:MI:SS') AS TEST_TIMESTAMP FROM LZ_TESTING_DATA T,EMPLOYEE_MT MM WHERE T.LZ_BARCODE_ID = (SELECT LZ_BARCODE_MT_ID FROM LZ_BARCODE_MT WHERE BARCODE_NO = B.BARCODE_NO) AND MM.EMPLOYEE_ID = T.USER_ID(+) AND ROWNUM = 1 ) TEST_TIMESTAMP FROM LZ_BARCODE_MT B,LZ_MANIFEST_MT MT, LZ_ITEM_COND_MT CM ,EMPLOYEE_MT M ,LZ_SALES_PULLING P WHERE B.BARCODE_NO = $barcode AND B.LZ_MANIFEST_ID = MT.LZ_MANIFEST_ID AND B.AUDIT_BY = M.EMPLOYEE_ID(+) AND B.CONDITION_ID = CM.ID(+) AND B.PULLING_ID = P.PULLING_ID(+) ");
				        // $manifests=$this->db->query("SELECT B.EBAY_ITEM_ID, CM.COND_NAME, DECODE(P.TRANS_STATUS,NULL,'NOT PULLED','P','PULLED','C','CANCELLED') PULL_STAT, P.PULLER_NAME, TO_CHAR(B.AUDIT_DATETIME, 'DD/MM/YYYY HH24:MI:SS') AUDIT_DATETIME, B.LZ_MANIFEST_ID, B.BARCODE_NO, DECODE(PRINT_STATUS, 1, 'YES', 0, 'NO') PRINT_STATUS, DECODE(B.EBAY_STICKER, 1, 'YES', 0, 'NO') AUDIT_ITEM, M.USER_NAME, DECODE(MT.MANIFEST_TYPE,0,'Excel Upload',1,'Single ENTRY ITEM',2,'LOT ITEM',3,'DEKIT ITEM',4,'SPECIAL LOT ITEM') ITEM_SOURCE, (SELECT M.USER_NAME FROM LZ_TESTING_DATA T,EMPLOYEE_MT MM WHERE T.LZ_BARCODE_ID = (SELECT LZ_BARCODE_MT_ID FROM LZ_BARCODE_MT WHERE BARCODE_NO = B.BARCODE_NO) AND MM.EMPLOYEE_ID = T.USER_ID(+) AND ROWNUM = 1 ) TEST_BY, (SELECT TO_CHAR(TEST_TIMESTAMP, 'DD/MM/YYYY HH24:MI:SS') AS TEST_TIMESTAMP FROM LZ_TESTING_DATA T,EMPLOYEE_MT MM WHERE T.LZ_BARCODE_ID = (SELECT LZ_BARCODE_MT_ID FROM LZ_BARCODE_MT WHERE BARCODE_NO = B.BARCODE_NO) AND MM.EMPLOYEE_ID = T.USER_ID(+) AND ROWNUM = 1 ) TEST_TIMESTAMP FROM LZ_BARCODE_MT B,LZ_MANIFEST_MT MT, LZ_ITEM_COND_MT CM ,EMPLOYEE_MT M ,LZ_SALES_PULLING P WHERE B.BARCODE_NO = $barcode AND B.LZ_MANIFEST_ID = MT.LZ_MANIFEST_ID AND B.AUDIT_BY = M.EMPLOYEE_ID(+) AND B.CONDITION_ID = CM.ID(+) AND B.PULLING_ID = P.PULLING_ID(+) "); 


				        /*echo "<pre>"; 
				        print_r($manifests->result_array()); exit;*/ /*//////////////FOR ITEM TESTING ////////////////////////*/
				        $testings=$this->db->query("SELECT USER_ID, TO_CHAR(TEST_TIMESTAMP, 'DD/MM/YYYY HH24:MI:SS') AS TEST_TIMESTAMP FROM LZ_TESTING_DATA T WHERE T.LZ_BARCODE_ID = (SELECT LZ_BARCODE_MT_ID FROM LZ_BARCODE_MT WHERE BARCODE_NO=$barcode) AND ROWNUM =1 order by t.lz_testing_data_id desc");
				                
				        $conditions=$this->db->query("SELECT CONDITION_ID FROM LZ_BARCODE_MT WHERE BARCODE_NO=$barcode");
				        if ($conditions->num_rows() > 0) {
				          foreach ($conditions->result_array() as $condition){
				            $condition_id=$condition['CONDITION_ID'];
				          }
				        }
				       /*echo "<pre>";
				        print_r($results);
				        exit;*/
				        if ($testings->num_rows() > 0) {
				          foreach ($testings->result_array() as $testing)
				          {
				            $user_id=$testing['USER_ID'];
				            $test_date=$testing['TEST_TIMESTAMP'];
				            //var_dump($time_stemp); exit;
				            $users = $this->db->query("SELECT T.USER_NAME FROM EMPLOYEE_MT T WHERE T.EMPLOYEE_ID=$user_id");
				             if ($users->num_rows() > 0) {
						          foreach ($users->result_array() as $user)
						          {
						            $test_user=$user['USER_NAME'];
						          }
				        		}
				          }
				        }else {
				          $test_date='';
				          $test_user='';
				        }
				        
				          /*//////////////END FOR ITEM TESTING ///////////////////*/

				          /*////////////////////////////////////////////////////////
				          //             FOR STICKER PRINT                        //
				          /////////////////////////////////////////////////////////*/
				          	$stickers = $this->db->query("SELECT M.EBAY_ITEM_ID, M.EBAY_STICKER, TO_CHAR(M.AUDIT_DATETIME, 'DD/MM/YYYY HH24:MI:SS')  AS AUDIT_DATETIME, M.AUDIT_BY FROM LZ_BARCODE_MT M WHERE M.BARCODE_NO = $barcode");
				          	if ($stickers->num_rows() > 0) {
				              foreach ($stickers->result_array() as $value){
				                $audit_by 		=$value['AUDIT_BY'];
				                $ebay_item_id   =$value['EBAY_ITEM_ID'];
				              }
				          }
				          if (!empty($audit_by)) {
				          	$audit_bys = $this->db->query("SELECT D.USER_NAME FROM EMPLOYEE_MT D WHERE D.EMPLOYEE_ID = $audit_by");
				          	if ($audit_bys->num_rows() > 0) {
				              foreach ($audit_bys->result_array() as $value){
				                $audit_by 		=$value['USER_NAME'];
				                
				              }
				          	}
				          }
				          	//var_dump($ebay_item_id, $audit_by); exit;

				          /*////////////////////////////////////////////////////////
				          //            END  FOR STICKER PRINT                    //
				          /////////////////////////////////////////////////////////*/
				           /*////////////////////////////////////////////////////////
				          //             FOR ITEM LIST                             //
				          /////////////////////////////////////////////////////////*/
				           $listerId ='';
				          	$listers = $this->db->query("SELECT TO_CHAR(T.LIST_DATE, 'DD/MM/YYYY HH24:MI:SS') AS LIST_DATE, T.LISTER_ID, T.EBAY_ITEM_ID, T.LIST_PRICE FROM EBAY_LIST_MT T WHERE T.EBAY_ITEM_ID = '$ebay_item_id' AND ROWNUM = 1");

				          	if ($listers->num_rows() > 0) { 
				              foreach ($listers->result_array() as $value){
				                $listerId 		=@$value['LISTER_ID'];
				              } 
				          	}
				          if (!empty($listerId)) {
				          	$lister_ids = $this->db->query("SELECT D.USER_NAME FROM EMPLOYEE_MT D WHERE D.EMPLOYEE_ID = $listerId");
				          	if ($lister_ids->num_rows() > 0) {
				              foreach ($lister_ids->result_array() as $value){
				                $listerId 			= $value['USER_NAME'];
				              }
				         	}	
				          }
				          /*////////////////////////////////////////////////////////
				          //            END  FOR ITEM LIST                		   //
				          /////////////////////////////////////////////////////////*/
				          /*///////////////FOR PIC APPROVALS///////////////////////*/
				          $result =  $this->db->query("SELECT ITEM_ID, LZ_MANIFEST_ID, CONDITION_ID FROM LZ_BARCODE_MT WHERE BARCODE_NO = $barcode");
				          // echo "<pre>";
				          // print_r($result);
				          // exit;
				          if ($result->num_rows() > 0) {
				              foreach ($result->result_array() as $value)
				              {
				                $item_id=$value['ITEM_ID'];
				                $manifest_id=$value['LZ_MANIFEST_ID'];
				                $condition_id=$value['CONDITION_ID']; 
				              }
				            $pic_approvals =  $this->db->query("SELECT APPROVED_BY, TO_CHAR(APPROVED_DATE, 'DD/MM/YYYY HH24:MI:SS') AS APPROVED_DATE FROM LZ_ITEM_SEED S WHERE S.ITEM_ID =$item_id AND S.LZ_MANIFEST_ID= $manifest_id AND S.DEFAULT_COND =$condition_id");
				            if ($pic_approvals->num_rows() > 0) {
				              foreach ($pic_approvals->result_array() as $pic_approval)
				                {
				                  $approved_by=$pic_approval['APPROVED_BY'];
				                  $approved_date=$pic_approval['APPROVED_DATE'];
				                  if (!empty($approved_by) OR  $approved_by!=NULL) {
				                    $pic_approvals = $this->db->query("SELECT T.EMPLOYEE_ID, T.USER_NAME FROM EMPLOYEE_MT T WHERE T.EMPLOYEE_ID=$approved_by");
				                  }
				                }
				            }
				            $master_paths=  $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG");
				            if ($master_paths->num_rows() > 0) {
				              foreach ($master_paths->result_array() as $path)
				                {
				                  $master_path=$path['MASTER_PATH'];
				                }
				            }else {
				              $master_path='';
				            }
				            
				            //  var_dump($master_path); exit;
				            $pic_items =  $this->db->query("SELECT ITEM_MT_MFG_PART_NO, ITEM_MT_UPC FROM ITEMS_MT I WHERE I.ITEM_ID=$item_id");
				            if ($pic_items->num_rows() > 0){
				              foreach ($pic_items->result_array() as $pic_item)
				                {
				                  $item_mpn=$pic_item['ITEM_MT_MFG_PART_NO'];
				                  $item_upc=$pic_item['ITEM_MT_UPC'];
				                }
				              }else {
				                  $item_mpn='';
				                  $item_upc='';
				              } 
				          }else {
				                $pic_approvals=array();
				            }
				          
				          /*///////////////END FOR PIC APPROVALS///////////////////////*/

				          /*//////////////FOR ITEM ASSIGN////////////////////////*/
				          //var_dump($condition_id); exit;
				          $allocations =  $this->db->query("SELECT SEED_ID FROM LZ_ITEM_SEED S WHERE S.ITEM_ID =$item_id AND S.LZ_MANIFEST_ID= $manifest_id AND S.DEFAULT_COND =$condition_id")->result_array();
				          /*echo "<pre>";
				          print_r($allocations);
				          exit;*/
				          foreach ($allocations as $allocat)
				            {
				              $seed_id=$allocat['SEED_ID'];
				            }
				            //var_dump($seed_id); exit;
				            if($seed_id!=''){
				              $item_assigns =  $this->db->query("SELECT LISTER_ID,  TO_CHAR(ALLOC_DATE, 'DD/MM/YYYY HH24:MI:SS') AS ALLOC_DATE, ALLOCATED_BY FROM LZ_LISTING_ALLOC A WHERE A.SEED_ID =$seed_id");
				                /*echo "<pre>";
				                print_r($item_assigns->result_array());
				                exit;*/
				                if ($item_assigns->num_rows() > 0) {
				                  foreach ($item_assigns->result_array() as $item_assign)
				                  {
				                    $lister_id            =$item_assign['LISTER_ID']; 
				                    $assigned_id          =$item_assign['ALLOCATED_BY'];
				                    $assign_users= $this->db->query("SELECT T.USER_NAME FROM EMPLOYEE_MT T WHERE T.EMPLOYEE_ID=$lister_id");
				                      if ($assign_users->num_rows() > 0) {
				                      foreach ($assign_users->result_array() as $assign_user) {
				                        $assigned_to=$assign_user['USER_NAME'];
				                      }
				                    }else {
				                      $assigned_by='';
				                    }

				                    $assigns = $this->db->query("SELECT T.USER_NAME FROM EMPLOYEE_MT T WHERE T.EMPLOYEE_ID=$assigned_id");
				                    if ($assigns->num_rows() > 0) {
				                      foreach ($assigns->result_array() as $assig_by) {
				                        $assigned_by=$assig_by['USER_NAME'];
				                      }
				                    }else {
				                      $assigned_by='';
				                    }
				                      
				                  }
				                }else {
				                  $assigned_to='';
				                  $item_assigns=array();
				                  $assigned_by='';
				                }
				              }
				               
				          /*//////////////END FOR ITEM ASSIGN////////////////////////*/
				          $data_array = array(
				            'manifests'=>@$manifests,
				            'loc_his'=>@$loc_his,
				            'buyer_his'=>@$buyer_his,
				            'test_date'=>@$test_date,
				            'condition_id'=>@$condition_id,
				            'manifest_id'=>@$manifest_id,
				            'item_mpn'=>@$item_mpn,
				            'item_upc'=>@$item_upc,
				            'master_path'=>@$master_path,
				            'pic_approvals'=>@$pic_approvals,
				            'item_assigns'=>@$item_assigns,
				            'assigned_to'=>@$assigned_to,
				            'assigned_by'=>@$assigned_by,
				            'test_user'=>@$test_user,
				            'approved_date'=>@$approved_date,
				            'stickers'=>@$stickers,
				            'audit_by'=>@$audit_by,
				            'listers'=>@$listers,
				            'listerId'=>@$listerId,
				            'return'=>'true'
				          );
				        }

					
				}else{  //end condition if
					 $data_array = array(
			            'manifests'=>@$manifests,
			            'test_date'=>@$test_date,
			            'condition_id'=>@$condition_id,
			            'manifest_id'=>@$manifest_id,
			            'item_mpn'=>@$item_mpn,
			            'item_upc'=>@$item_upc,
			            'master_path'=>@$master_path,
			            'pic_approvals'=>@$pic_approvals,
			            'item_assigns'=>@$item_assigns,
			            'assigned_to'=>@$assigned_to,
			            'assigned_by'=>@$assigned_by,
			            'test_user'=>@$test_user,
			            'approved_date'=>@$approved_date,
			            'stickers'=>@$stickers,
			            'audit_by'=>@$audit_by,
			            'listers'=>@$listers,
				        'listerId'=>@$listerId,
			            'return'=>'true'
			          );
				    }
				    return $data_array;
					/*echo "<pre>";
					print_r($check_barcode->result_array());
					exit;*/
		}else{
			return "no_barcode";
		}
		
	}
}