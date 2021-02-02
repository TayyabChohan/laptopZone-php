<?php
if (!defined('BASEPATH'))
 exit('No direct script access allowed');
 
class m_bk_webhook extends CI_Model
{
	function bk_addWebhook()
	{
		$this->form_validation->set_rules('webhook_name', 'webhook name', 'trim|required');
		$this->form_validation->set_rules('categoryId', 'category id', 'trim|required');
		$this->form_validation->set_rules('main_category', 'main category', 'trim|required');
		$this->form_validation->set_rules('sub_category', 'sub name', 'trim|required');
		$this->form_validation->set_rules('category_name', 'category name', 'trim|required');
		$this->form_validation->set_rules('web_keyword', 'webhook keyword', 'trim|required');
		if($this->form_validation->run()==FALSE)
		{
			$data['pageTitle'] = 'Add Webhook';
			$this->load->view("BundleKit/api/v_webhook_listing", $data);
		}else {
				$webhook_name=ucfirst($this->input->post('webhook_name'));
				$categoryId=ucfirst($this->input->post('categoryId'));
				$main_category=ucfirst($this->input->post('main_category'));
				$sub_category=ucfirst($this->input->post('sub_category'));
				$category_name=ucfirst($this->input->post('category_name'));
				$web_keyword=ucfirst($this->input->post('web_keyword'));
				$webhook_condition=$this->input->post('webhook_condition');
			  	$query =$this->db->query("SELECT * FROM LZ_IND_WEBHOOK WHERE WEBHOOK_NAME LIKE '%$webhook_name%'");
			    if($query->num_rows() >0){
			        $this->session->set_flashdata('warning',"Webhook already exist");
			        redirect(site_url()."BundleKit/c_bk_webhook");
			    }else{
						$qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_IND_WEBHOOK','WEBHOOK_ID') ID FROM DUAL");
			        	$rs = $qry->result_array();
			        	$lz_webhook_id= $rs[0]['ID']; 
						$query=$this->db->query("INSERT INTO LZ_IND_WEBHOOK (WEBHOOK_ID, WEBHOOK_NAME, WEBHOOK_KEYWORDS, CATEGORY_ID, MAIN_CATEGORY, SUB_CATEGORY, CATEGORY_NAME, CONDITION_ID) VALUES($lz_webhook_id, '$webhook_name', '$web_keyword', $categoryId, '$main_category', '$sub_category', '$category_name', $webhook_condition)"); 
						if($query)
							{
								$this->session->set_flashdata('success', "Webhook created Successfully"); 
							}else{
								$this->session->set_flashdata('error',"Webhook creation Failed");
							}			
					}	
				}
		redirect(site_url()."BundleKit/c_bk_webhook");
	}
	function bk_getAll()
	{
		$webhooks_data=[];
		$kit_query=$this->db->query("SELECT DISTINCT WH.WEBHOOK_ID, WH.KIT_ID, KM.LZ_BK_KIT_DESC,KM.KIT_KEYWORD,KD.CATEGORY_ID,KD.CATEGORY_NAME,WH.CONDITION_ID,WH.CREATED_BY,WH.EDIT_BY FROM LZ_IND_WEBHOOK WH, LZ_BK_KIT_MT KM, LZ_BK_KIT_DET KD WHERE KM.LZ_BK_KIT_ID = KD.LZ_BK_KIT_ID AND KM.LZ_BK_KIT_ID = WH.KIT_ID");
		$webhook_query=$this->db->query("SELECT * FROM LZ_IND_WEBHOOK WD WHERE WD.KIT_ID IS NULL");
		$webhook_ids=$this->db->query("SELECT * FROM LZ_IND_WEBHOOK")->result_array();
		$i=0;
		foreach ($webhook_ids as $wh_id) {			
			$webhook_count=$this->db->query("SELECT COUNT(*) as total_rows FROM LZ_WEBHOOK_DATA WHERE WEBHOOK_ID=".$wh_id['WEBHOOK_ID']);
			$webhook_count=$webhook_count->result_array();
			array_push($webhooks_data, $webhook_count[0]['TOTAL_ROWS']);
			$i++;
		}
		/*echo "<pre>";
		print_r($webhooks_data);
		exit;*/	
		return array(
			'kit_query'=>$kit_query,
			'webhook_query'=>$webhook_query,
			'webhooks_data'=>$webhooks_data
			);
	}
	function bkWebhooks()
	{
		$web_data = $this->db->query("SELECT WEBHOOK_ID, EBAY_ID, TITLE, CONDITION_ID, CONDITION_NAME, ITEM_URL, PRICE, LISTING_TYPE, TO_CHAR(START_TIME, 'DD/MM/YYYY HH24:MI:SS') as START_TIME, TO_CHAR(END_TIME, 'DD/MM/YYYY HH24:MI:SS') as END_TIME, INSERTED_DATE, SELLER_ID, FEEDBACK_SCORE, STATUS, IS_DELETED, UPC, MPN, MANUFACTURER, QUANTITY  FROM LZ_WEBHOOK_DATA D WHERE IS_DELETED = 0 ORDER BY PRICE, START_TIME, FEEDBACK_SCORE DESC");
		$searchs = $this->db->query("SELECT DISTINCT W.WEBHOOK_ID, W.WEBHOOK_NAME FROM LZ_IND_WEBHOOK W, LZ_WEBHOOK_DATA D WHERE W.WEBHOOK_ID = D.WEBHOOK_ID"); 
		return array(
				'web_data' =>$web_data,
				'searchs' =>$searchs
		 			);
	}
	function bk_getWebhookDetail($webhook_id='')
	{ 
		return $query=$this->db->query("SELECT WH.WEBHOOK_ID, WH.WEBHOOK_NAME, WD.EBAY_ID, WD.TITLE, WD.SELLER_ID, WD.LISTING_TYPE, WD.PRICE, WD.FEEDBACK_SCORE, WD.STATUS, WD.CONDITION_NAME, WD.ITEM_URL, TO_CHAR(START_TIME, 'DD/MM/YYYY HH24:MI:SS') as START_TIME, TO_CHAR(END_TIME, 'DD/MM/YYYY HH24:MI:SS') as END_TIME FROM LZ_IND_WEBHOOK WH, LZ_WEBHOOK_DATA WD WHERE WH.WEBHOOK_ID = WD.WEBHOOK_ID AND WH.WEBHOOK_ID = $webhook_id AND WD.IS_DELETED = 0"); 
	}	
	function bk_deleteWebhook($webhook_id)
	{
		$detailDelete=$this->db->query("DELETE FROM  LZ_WEBHOOK_DATA WHERE WEBHOOK_ID=$webhook_id");
		if ($detailDelete) {
			$masterDelete=$this->db->query("DELETE FROM  LZ_IND_WEBHOOK WHERE WEBHOOK_ID=$webhook_id");
		}
		if($masterDelete)
			{
		  		$this->session->set_flashdata('success', "Webhook deleted successfully"); 
			}else{
		  		$this->session->set_flashdata('error',"Webhook deletion Failed");
			} 		  
		redirect(base_url()."BundleKit/c_bk_webhook");
	}
	function pullWebhookData($webhook_id)
	{
		$webhook_qry=$this->db->query("SELECT W.WEBHOOK_ID,W.WEBHOOK_KEYWORDS,W.CATEGORY_ID AS WEBHOOK_CATEGORY_ID,W.CONDITION_ID,KM.LZ_BK_KIT_ID AS KIT_ID,KM.KIT_KEYWORD,KD.CATEGORY_ID AS KIT_CATEGORY_ID FROM LZ_IND_WEBHOOK W, LZ_BK_KIT_MT KM, LZ_BK_KIT_DET KD WHERE W.KIT_ID = KM.LZ_BK_KIT_ID AND KM.LZ_BK_KIT_ID = KD.LZ_BK_KIT_ID AND W.WEBHOOK_ID = $webhook_id");
		if($webhook_qry->num_rows() > 0){
			return $webhook_qry;
		}else{
			$webhook_qry=$this->db->query("SELECT W.WEBHOOK_ID,W.WEBHOOK_KEYWORDS,W.CATEGORY_ID AS WEBHOOK_CATEGORY_ID,W.CONDITION_ID FROM LZ_IND_WEBHOOK W WHERE W.WEBHOOK_ID = $webhook_id");
			$webhook_qry= $webhook_qry->result_array();
			return $webhook_qry;
		}	
	}

	function wh_delete($ebay_id='', $webhook_id='', $webhook_condition='', $webhook_status='')
	{
		$query1=$this->db->query("UPDATE LZ_WEBHOOK_DATA SET IS_DELETED = 1 WHERE EBAY_ID=$ebay_id");
			if($query1)
			{
			  $this->session->set_flashdata('success', "Selected row has been deleted"); 
			}else {
			  $this->session->set_flashdata('error',"Deletion Failed");
			} 		  
			redirect(base_url()."BundleKit/c_bk_webhook/filtersStatus/".$webhook_id."/".$webhook_condition."/".$webhook_status);
	}
	function wh_filters($webhook_id='', $webhook_condition='', $webhook_status='')
	{
		if ($this->input->post('search_webhook')) {
			$this->session->set_userdata('webhook_id', $webhook_id);
			$this->session->set_userdata('webhook_condition', $webhook_condition);
			$this->session->set_userdata('webhook_status', $webhook_status);
			if ($webhook_condition==0 && $webhook_status=="All"){
				$web_data=$this->db->query("SELECT * FROM LZ_IND_WEBHOOK WH, LZ_WEBHOOK_DATA WD  WHERE WH.WEBHOOK_ID = WD.WEBHOOK_ID AND WD.WEBHOOK_ID=$webhook_id AND WD.IS_DELETED = 0"); 
			}elseif($webhook_condition==0 && $webhook_status!="All"){
				$web_data=$this->db->query("SELECT * FROM LZ_IND_WEBHOOK WH, LZ_WEBHOOK_DATA WD  WHERE WH.WEBHOOK_ID = WD.WEBHOOK_ID AND WD.WEBHOOK_ID=$webhook_id AND WD.STATUS='$webhook_status' AND WD.IS_DELETED = 0");
			}elseif($webhook_condition!=0 && $webhook_status!="All"){
				$web_data=$this->db->query("SELECT * FROM LZ_IND_WEBHOOK WH, LZ_WEBHOOK_DATA WD  WHERE WH.WEBHOOK_ID = WD.WEBHOOK_ID AND WD.WEBHOOK_ID=$webhook_id AND WD.STATUS='$webhook_status' AND WD.CONDITION_ID=$webhook_condition AND WD.IS_DELETED = 0");
			}elseif($webhook_condition!=0 && $webhook_status=="All"){
				$web_data=$this->db->query("SELECT * FROM LZ_IND_WEBHOOK WH, LZ_WEBHOOK_DATA WD  WHERE WH.WEBHOOK_ID = WD.WEBHOOK_ID AND WD.WEBHOOK_ID=$webhook_id AND WD.CONDITION_ID=$webhook_condition AND WD.IS_DELETED = 0");
			}

			$searchs = $this->db->query("SELECT DISTINCT W.WEBHOOK_ID,W.WEBHOOK_NAME FROM LZ_IND_WEBHOOK W, LZ_WEBHOOK_DATA D WHERE W.WEBHOOK_ID = D.WEBHOOK_ID"); 
			return array(
						'web_data' =>$web_data,
						'searchs' =>$searchs
			 			);		
		}
	}
	function wh_saveStatus($webhook_id='', $webhook_condition='', $webhook_status='')
	{
		$this->session->set_userdata('webhook_id', $webhook_id);
		$this->session->set_userdata('webhook_condition', $webhook_condition);
		$this->session->set_userdata('webhook_status', $webhook_status);
		if ($webhook_condition==0 && $webhook_status=="All"){
			$web_data=$this->db->query("SELECT * FROM LZ_IND_WEBHOOK WH, LZ_WEBHOOK_DATA WD  WHERE WH.WEBHOOK_ID = WD.WEBHOOK_ID AND WD.WEBHOOK_ID=$webhook_id"); 
		}elseif($webhook_condition==0 && $webhook_status!="All"){
			$web_data=$this->db->query("SELECT * FROM LZ_IND_WEBHOOK WH, LZ_WEBHOOK_DATA WD  WHERE WH.WEBHOOK_ID = WD.WEBHOOK_ID AND WD.WEBHOOK_ID=$webhook_id AND WD.STATUS='$webhook_status'");
		}elseif($webhook_condition!=0 && $webhook_status!="All"){
			$web_data=$this->db->query("SELECT * FROM LZ_IND_WEBHOOK WH, LZ_WEBHOOK_DATA WD  WHERE WH.WEBHOOK_ID = WD.WEBHOOK_ID AND WD.WEBHOOK_ID=$webhook_id AND WD.STATUS='$webhook_status' AND WD.CONDITION_ID=$webhook_condition");
		}elseif($webhook_condition!=0 && $webhook_status=="All"){
			$web_data=$this->db->query("SELECT * FROM LZ_IND_WEBHOOK WH, LZ_WEBHOOK_DATA WD  WHERE WH.WEBHOOK_ID = WD.WEBHOOK_ID AND WD.WEBHOOK_ID=$webhook_id AND WD.CONDITION_ID=$webhook_condition");
		}
		$searchs = $this->db->query("SELECT DISTINCT W.WEBHOOK_ID,W.WEBHOOK_NAME FROM LZ_IND_WEBHOOK W, LZ_WEBHOOK_DATA D WHERE W.WEBHOOK_ID = D.WEBHOOK_ID"); 
		return array(
					'web_data' =>$web_data,
					'searchs' =>$searchs
		 			);	
	}
	function wh_save_mpn_upc()
	{
		$upc=$this->input->post('upc');
		$mpn=$this->input->post('mpn');
		$webhook_id=$this->input->post('webhook_id');
		$ebay_id=$this->input->post('ebay_id');
		$manufacturer=$this->input->post('manufacturer');
		$item_qty=$this->input->post('item_qty');
		$i=0;         	
		foreach ($ebay_id as $ebayId)
			{
  				$qry="UPDATE LZ_WEBHOOK_DATA SET UPC='$upc[$i]', MPN='$mpn[$i]', MANUFACTURER='$manufacturer[$i]', QUANTITY='$item_qty[$i]' WHERE WEBHOOK_ID=$webhook_id AND EBAY_ID=$ebayId";
				$qq=$this->db->query($qry); 
				$i++;
			}
			if($qq)
				{
			 	 $this->session->set_flashdata('success', "Data updated successfully"); 
				}else{
		  			$this->session->set_flashdata('error',"Data updation has Failed");
				} 
				echo json_encode($qq);
        		return json_encode($qq);
	}
}