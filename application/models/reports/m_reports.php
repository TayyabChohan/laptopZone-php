<?php 
// Test

	/**
	* m_reports Model
	*/
	class m_reports extends CI_Model
	{

		public function __construct(){
		parent::__construct();
		$this->load->database();
		
	}
	public function get_emp(){

    $qyer =$this->db->query("SELECT M.EMPLOYEE_ID,M.USER_NAME FROM EMPLOYEE_MT M WHERE M.LOCATION = 'PK' AND M.STATUS =1 ")->result_array();

    return  array('qyer' => $qyer );


     }
	public function sale_data(){
		$from = date('m/01/Y');
		$to = date('m/d/Y');
		$rslt =$from." - ".$to;
		$this->session->set_userdata('date_range', $rslt);
		$fromdate = date_create($from);
		$todate = date_create($to);
		$from = date_format($fromdate,'d-m-y');
		$to = date_format($todate, 'd-m-y');

		$query = $this->db->query("SELECT I.ITEM_CODE, LM.LZ_SELLER_ACCT_ID, T.WIZ_ERP_CODE, MI.USER_NAME LIST_BY, GET_EBAY.EB_ID, GET_EBAY.LISTER_ID, T.SALES_RECORD_NUMBER, T.SALE_DATE, T.ITEM_ID, T.ITEM_TITLE, T.QUANTITY, T.TOTAL_PRICE, T.EBAY_FEE_PERC, T.SHIPPING_CHARGES, T.PAYPAL_PER_TRANS_FEE, T.SALES_TAX, T.INSURANCE, D.COST_OF_SALE MAT_COST, (NVL(T.EBAY_FEE_PERC, 0) + NVL(T.SHIPPING_CHARGES, 0) + NVL(T.PAYPAL_PER_TRANS_FEE, 0) + NVL(T.SALES_TAX, 0) + NVL(T.INSURANCE, 0) + NVL(D.COST_OF_SALE, 0)) COST_OF_SALE, T.TOTAL_PRICE - (NVL(T.EBAY_FEE_PERC, 0) + NVL(T.SHIPPING_CHARGES, 0) + NVL(T.PAYPAL_PER_TRANS_FEE, 0) + NVL(T.SALES_TAX, 0) + NVL(T.INSURANCE, 0) + NVL(D.COST_OF_SALE, 0)) TOTAL_PL FROM LZ_SALESLOAD_MT  LM, LZ_SALESLOAD_DET T, DC_MT            M, DC_DETAIL        D, ITEMS_MT         I, (SELECT LISTER_ID, EB_ID FROM (SELECT MAX(EB.LISTER_ID) LISTER_ID, EB.EBAY_ITEM_ID EB_ID FROM EBAY_LIST_MT EB /*WHERE EB.LISTER_ID =5*/ GROUP BY EB.EBAY_ITEM_ID)) GET_EBAY, EMPLOYEE_MT MI WHERE LM.LZ_SALELOAD_ID = T.LZ_SALELOAD_ID AND T.GNRTD_DC_ID = M.DC_ID(+) AND T.ITEM_ID = GET_EBAY.EB_ID(+) AND get_ebay.lister_id = MI.EMPLOYEE_ID(+) AND M.DC_ID = D.DC_ID(+) AND D.ITEM_ID = I.ITEM_ID(+) AND LM.LOADING_DATE BETWEEN TO_DATE('$from "."00:00:00', 'DD-MM-YY HH24:MI:SS') AND TO_DATE('$to ". "23:59:59', 'DD-MM-YY HH24:MI:SS')"); return $query->result_array();

		// $query = $this->db->query("SELECT II.ITEM_CODE, T.SALES_RECORD_NUMBER, T.ITEM_ID, II.ITEM_CODE, MI.USER_NAME LIST_BY, GET_SRN.ITEM_ID, GET_SRN.LZ_MANIFEST_ID, (SELECT NVL(MAX(DE.PO_DETAIL_RETIAL_PRICE / DE.AVAILABLE_QTY), 0) FROM LZ_MANIFEST_DET DE WHERE DE.LZ_MANIFEST_ID = GET_SRN.LZ_MANIFEST_ID AND DE.LAPTOP_ITEM_CODE = II.ITEM_CODE) MAT_COST, GET_EBAY.EB_ID, GET_EBAY.LISTER_ID, LM.LZ_SELLER_ACCT_ID, T.WIZ_ERP_CODE, T.SALES_RECORD_NUMBER, T.SALE_DATE, T.ITEM_ID, T.ITEM_TITLE, T.QUANTITY, T.TOTAL_PRICE, T.EBAY_FEE_PERC, T.SHIPPING_CHARGES, T.PAYPAL_PER_TRANS_FEE, T.SALES_TAX, T.INSURANCE, (NVL(T.EBAY_FEE_PERC, 0) + NVL(T.SHIPPING_CHARGES, 0) + NVL(T.PAYPAL_PER_TRANS_FEE, 0) + NVL(T.SALES_TAX, 0) + NVL(T.INSURANCE, 0) + NVL((SELECT NVL(MAX(DE.PO_DETAIL_RETIAL_PRICE / DE.AVAILABLE_QTY), 0) FROM LZ_MANIFEST_DET DE WHERE DE.LZ_MANIFEST_ID = GET_SRN.LZ_MANIFEST_ID AND DE.LAPTOP_ITEM_CODE = II.ITEM_CODE), 0)) COST_OF_SALE, T.TOTAL_PRICE - (NVL(T.EBAY_FEE_PERC, 0) + NVL(T.SHIPPING_CHARGES, 0) + NVL(T.PAYPAL_PER_TRANS_FEE, 0) + NVL(T.SALES_TAX, 0) + NVL(T.INSURANCE, 0) + NVL((SELECT NVL(MAX(DE.PO_DETAIL_RETIAL_PRICE / DE.AVAILABLE_QTY), 0) FROM LZ_MANIFEST_DET DE WHERE DE.LZ_MANIFEST_ID = GET_SRN.LZ_MANIFEST_ID AND DE.LAPTOP_ITEM_CODE = II.ITEM_CODE), 0)) TOTAL_PL FROM LZ_SALESLOAD_MT LM, LZ_SALESLOAD_DET T, (SELECT LISTER_ID, EB_ID FROM (SELECT MAX(EB.LISTER_ID) LISTER_ID, EB.EBAY_ITEM_ID EB_ID FROM EBAY_LIST_MT EB GROUP BY EB.EBAY_ITEM_ID)) GET_EBAY, EMPLOYEE_MT MI, (SELECT M.SALE_RECORD_NO SRN, MAX(M.LZ_MANIFEST_ID) LZ_MANIFEST_ID, MAX(M.ITEM_ID) ITEM_ID FROM LZ_BARCODE_MT M GROUP BY M.SALE_RECORD_NO) GET_SRN, ITEMS_MT II WHERE LM.LZ_SALELOAD_ID = T.LZ_SALELOAD_ID AND T.ITEM_ID = GET_EBAY.EB_ID(+) AND GET_EBAY.LISTER_ID = MI.EMPLOYEE_ID(+) AND LM.LZ_SELLER_ACCT_ID IN (1, 2) AND T.SALES_RECORD_NUMBER = GET_SRN.SRN(+) AND GET_SRN.ITEM_ID = II.ITEM_ID(+) AND LM.LOADING_DATE BETWEEN TO_DATE('$from "."00:00:00', 'DD-MM-YY HH24:MI:SS') AND TO_DATE('$to ". "23:59:59', 'DD-MM-YY HH24:MI:SS')"); return $query->result_array();

		 // and t.sale_date between '01-Oct-2016' and '30-Oct-2016' and lm.lz_seller_acct_id = 1
		 }
	public function sum_data(){
	$from = date('01-m-y');
	$to = date('d-m-y');		
	$query = $this->db->query("select sum(total_price) Total_Sale_Price,sum(ebay_fee_perc) Total_EBAY_FEE,sum(shipping_charges) Total_SHIP_FEE,sum(paypal_per_trans_fee) Total_PAYPAL_FEE,sum(sales_tax) SUM_TAX,sum(Mat_Cost) Total_cost,sum(Cost_of_sale) SUM_COST,sum(TOTAL_PL) TOTAL_PL from (select lm.lz_seller_acct_id,t.wiz_erp_code,t.sales_record_number,t.sale_date,t.item_id,t.item_title,t.quantity,t.total_price,t.ebay_fee_perc,t.shipping_charges,t.paypal_per_trans_fee,t.sales_tax,t.insurance,d.cost_of_sale Mat_Cost,(nvl(t.ebay_fee_perc,0) + nvl(t.shipping_charges,0) + nvl(t.paypal_per_trans_fee,0) + nvl(t.sales_tax,0) + nvl(t.insurance,0) + nvl(d.cost_of_sale,0)) Cost_of_sale,t.total_price - (nvl(t.ebay_fee_perc,0) + nvl(t.shipping_charges,0) + nvl(t.paypal_per_trans_fee,0) + nvl(t.sales_tax,0) + nvl(t.insurance,0) + nvl(d.cost_of_sale,0)) Total_PL from lz_salesload_mt lm, LZ_SALESLOAD_DET t, dc_mt m, dc_detail d where lm.lz_saleload_id = t.lz_saleload_id and t.gnrtd_dc_id = m.dc_id(+) and m.dc_id = d.dc_id(+) AND lm.loading_date between TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS'))
");
		return $query->result_array();
	}
	public function search_sum_data($from,$to,$sale_pl_radio){
		$main_qry = "select sum(total_price) Total_Sale_Price,sum(ebay_fee_perc) Total_EBAY_FEE,sum(shipping_charges) Total_SHIP_FEE,sum(paypal_per_trans_fee) Total_PAYPAL_FEE,sum(sales_tax) SUM_TAX,sum(Mat_Cost) Total_cost,sum(Cost_of_sale) SUM_COST,sum(TOTAL_PL) TOTAL_PL from (select lm.lz_seller_acct_id,t.wiz_erp_code,t.sales_record_number,t.sale_date,t.item_id,t.item_title,t.quantity,t.total_price,t.ebay_fee_perc,t.shipping_charges,t.paypal_per_trans_fee,t.sales_tax,t.insurance,d.cost_of_sale Mat_Cost,(nvl(t.ebay_fee_perc,0) + nvl(t.shipping_charges,0) + nvl(t.paypal_per_trans_fee,0) + nvl(t.sales_tax,0) + nvl(t.insurance,0) + nvl(d.cost_of_sale,0)) Cost_of_sale,t.total_price - (nvl(t.ebay_fee_perc,0) + nvl(t.shipping_charges,0) + nvl(t.paypal_per_trans_fee,0) + nvl(t.sales_tax,0) + nvl(t.insurance,0) + nvl(d.cost_of_sale,0)) Total_PL from lz_salesload_mt lm, LZ_SALESLOAD_DET t, dc_mt m, dc_detail d where lm.lz_saleload_id = t.lz_saleload_id and t.gnrtd_dc_id = m.dc_id(+) and m.dc_id = d.dc_id(+)";
		$date_qry = "AND lm.loading_date between TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')";
		$sub_qry="";
		
		if($sale_pl_radio == 1){
			 $sub_qry= "and lm.lz_seller_acct_id = 1";
			 $this->session->set_userdata('sale_pl', $sale_pl_radio);
		}elseif($sale_pl_radio == 2){
			$sub_qry = "and lm.lz_seller_acct_id = 2";
			$this->session->set_userdata('sale_pl', $sale_pl_radio);
		}elseif($sale_pl_radio == 'Both'){
			$sub_qry = "and lm.lz_seller_acct_id in (1,2)";
			$this->session->set_userdata('sale_pl', $sale_pl_radio);
		}
		
	$query = $this->db->query($main_qry." ".$date_qry." ".$sub_qry.")");
 		return $query->result_array();
	}

	public function search_sale_data($from,$to,$sale_pl_radio){

		$get_emplo = $this->input->post('get_emp');
		$this->session->set_userdata('get_emplo', $get_emplo);
		// var_dump($get_emp);
		// exit;
		//$main_qry = "select lm.lz_seller_acct_id,t.wiz_erp_code,t.sales_record_number,t.sale_date,t.item_id,t.item_title,t.quantity,t.total_price,t.ebay_fee_perc,t.shipping_charges,t.paypal_per_trans_fee,t.sales_tax,t.insurance,d.cost_of_sale Mat_Cost,(nvl(t.ebay_fee_perc,0) + nvl(t.shipping_charges,0) + nvl(t.paypal_per_trans_fee,0) + nvl(t.sales_tax,0) + nvl(t.insurance,0) + nvl(d.cost_of_sale,0)) Cost_of_sale,t.total_price - (nvl(t.ebay_fee_perc,0) + nvl(t.shipping_charges,0) + nvl(t.paypal_per_trans_fee,0) + nvl(t.sales_tax,0) + nvl(t.insurance,0) + nvl(d.cost_of_sale,0)) Total_PL from lz_salesload_mt lm, LZ_SALESLOAD_DET t, dc_mt m, dc_detail d where lm.lz_saleload_id = t.lz_saleload_id and t.gnrtd_dc_id = m.dc_id(+) and m.dc_id = d.dc_id(+)";
		// $main_qry = "SELECT  I.ITEM_CODE, LM.LZ_SELLER_ACCT_ID, T.WIZ_ERP_CODE, T.SALES_RECORD_NUMBER, T.SALE_DATE, T.ITEM_ID, T.ITEM_TITLE, T.QUANTITY, T.TOTAL_PRICE, T.EBAY_FEE_PERC, T.SHIPPING_CHARGES, T.PAYPAL_PER_TRANS_FEE, T.SALES_TAX, T.INSURANCE, D.COST_OF_SALE MAT_COST, (NVL(T.EBAY_FEE_PERC, 0) + NVL(T.SHIPPING_CHARGES, 0) + NVL(T.PAYPAL_PER_TRANS_FEE, 0) + NVL(T.SALES_TAX, 0) + NVL(T.INSURANCE, 0) + NVL(D.COST_OF_SALE, 0)) COST_OF_SALE, T.TOTAL_PRICE - (NVL(T.EBAY_FEE_PERC, 0) + NVL(T.SHIPPING_CHARGES, 0) + NVL(T.PAYPAL_PER_TRANS_FEE, 0) + NVL(T.SALES_TAX, 0) + NVL(T.INSURANCE, 0) + NVL(D.COST_OF_SALE, 0)) TOTAL_PL FROM LZ_SALESLOAD_MT LM, LZ_SALESLOAD_DET T, DC_MT M, DC_DETAIL D,ITEMS_MT I WHERE LM.LZ_SALELOAD_ID = T.LZ_SALELOAD_ID AND T.GNRTD_DC_ID = M.DC_ID(+) AND M.DC_ID = D.DC_ID(+) AND D.ITEM_ID = I.ITEM_ID(+)";

		$main_qry = "SELECT I.ITEM_CODE, T.ITEM_ID, MI.USER_NAME LIST_BY, GET_EBAY.EB_ID, GET_EBAY.LISTER_ID, LM.LZ_SELLER_ACCT_ID, T.WIZ_ERP_CODE, T.SALES_RECORD_NUMBER, T.SALE_DATE, T.ITEM_ID, T.ITEM_TITLE, T.QUANTITY, T.TOTAL_PRICE, T.EBAY_FEE_PERC, T.SHIPPING_CHARGES, T.PAYPAL_PER_TRANS_FEE, T.SALES_TAX, T.INSURANCE, D.COST_OF_SALE MAT_COST, (NVL(T.EBAY_FEE_PERC, 0) + NVL(T.SHIPPING_CHARGES, 0) + NVL(T.PAYPAL_PER_TRANS_FEE, 0) + NVL(T.SALES_TAX, 0) + NVL(T.INSURANCE, 0) + NVL(D.COST_OF_SALE, 0)) COST_OF_SALE, T.TOTAL_PRICE - (NVL(T.EBAY_FEE_PERC, 0) + NVL(T.SHIPPING_CHARGES, 0) + NVL(T.PAYPAL_PER_TRANS_FEE, 0) + NVL(T.SALES_TAX, 0) + NVL(T.INSURANCE, 0) + NVL(D.COST_OF_SALE, 0)) TOTAL_PL FROM LZ_SALESLOAD_MT LM, LZ_SALESLOAD_DET T, DC_MT M, DC_DETAIL D, ITEMS_MT I, (SELECT LISTER_ID, EB_ID FROM (SELECT MAX(EB.LISTER_ID) LISTER_ID, EB.EBAY_ITEM_ID EB_ID FROM EBAY_LIST_MT EB /*WHERE EB.LISTER_ID =5*/ GROUP BY EB.EBAY_ITEM_ID) ) GET_EBAY, EMPLOYEE_MT MI WHERE LM.LZ_SALELOAD_ID = T.LZ_SALELOAD_ID AND T.GNRTD_DC_ID = M.DC_ID(+) AND T.ITEM_ID = GET_EBAY.EB_ID(+) AND M.DC_ID = D.DC_ID(+) AND D.ITEM_ID = I.ITEM_ID(+) AND get_ebay.lister_id =  MI.EMPLOYEE_ID(+)";

		// $main_qry = "SELECT II.ITEM_CODE,, T.SALES_RECORD_NUMBER, T.ITEM_ID, II.ITEM_CODE, MI.USER_NAME LIST_BY, GET_SRN.ITEM_ID, GET_SRN.LZ_MANIFEST_ID, (SELECT NVL(MAX(DE.PO_DETAIL_RETIAL_PRICE / DE.AVAILABLE_QTY), 0) FROM LZ_MANIFEST_DET DE WHERE DE.LZ_MANIFEST_ID = GET_SRN.LZ_MANIFEST_ID AND DE.LAPTOP_ITEM_CODE = II.ITEM_CODE) MAT_COST, GET_EBAY.EB_ID, GET_EBAY.LISTER_ID, LM.LZ_SELLER_ACCT_ID, T.WIZ_ERP_CODE, T.SALES_RECORD_NUMBER, T.SALE_DATE, T.ITEM_ID, T.ITEM_TITLE, T.QUANTITY, T.TOTAL_PRICE, T.EBAY_FEE_PERC, T.SHIPPING_CHARGES, T.PAYPAL_PER_TRANS_FEE, T.SALES_TAX, T.INSURANCE, (NVL(T.EBAY_FEE_PERC, 0) + NVL(T.SHIPPING_CHARGES, 0) + NVL(T.PAYPAL_PER_TRANS_FEE, 0) + NVL(T.SALES_TAX, 0) + NVL(T.INSURANCE, 0) + NVL((SELECT NVL(MAX(DE.PO_DETAIL_RETIAL_PRICE / DE.AVAILABLE_QTY), 0) FROM LZ_MANIFEST_DET DE WHERE DE.LZ_MANIFEST_ID = GET_SRN.LZ_MANIFEST_ID AND DE.LAPTOP_ITEM_CODE = II.ITEM_CODE), 0)) COST_OF_SALE, T.TOTAL_PRICE - (NVL(T.EBAY_FEE_PERC, 0) + NVL(T.SHIPPING_CHARGES, 0) + NVL(T.PAYPAL_PER_TRANS_FEE, 0) + NVL(T.SALES_TAX, 0) + NVL(T.INSURANCE, 0) + NVL((SELECT NVL(MAX(DE.PO_DETAIL_RETIAL_PRICE / DE.AVAILABLE_QTY), 0) FROM LZ_MANIFEST_DET DE WHERE DE.LZ_MANIFEST_ID = GET_SRN.LZ_MANIFEST_ID AND DE.LAPTOP_ITEM_CODE = II.ITEM_CODE), 0)) TOTAL_PL FROM LZ_SALESLOAD_MT LM, LZ_SALESLOAD_DET T, (SELECT LISTER_ID, EB_ID FROM (SELECT MAX(EB.LISTER_ID) LISTER_ID, EB.EBAY_ITEM_ID EB_ID FROM EBAY_LIST_MT EB GROUP BY EB.EBAY_ITEM_ID)) GET_EBAY, EMPLOYEE_MT MI, (SELECT M.SALE_RECORD_NO SRN, MAX(M.LZ_MANIFEST_ID) LZ_MANIFEST_ID, MAX(M.ITEM_ID) ITEM_ID FROM LZ_BARCODE_MT M GROUP BY M.SALE_RECORD_NO) GET_SRN, ITEMS_MT II WHERE LM.LZ_SALELOAD_ID = T.LZ_SALELOAD_ID AND T.ITEM_ID = GET_EBAY.EB_ID(+) AND GET_EBAY.LISTER_ID = MI.EMPLOYEE_ID(+)  AND T.SALES_RECORD_NUMBER = GET_SRN.SRN(+) AND GET_SRN.ITEM_ID = II.ITEM_ID(+)"; 

		$date_qry = "AND  t.sale_date between TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')";
		$sub_qry="";

		if(!empty($get_emplo)){
			$date_qry.= "and get_ebay.lister_id = '$get_emplo'";

		}


   /*and get_ebay.lister_id = 3*/
		
		if($sale_pl_radio == 1){
			 $sub_qry= "and lm.lz_seller_acct_id = 1";
			 $this->session->set_userdata('sale_pl', $sale_pl_radio);
		}elseif($sale_pl_radio == 2){
			$sub_qry = "and lm.lz_seller_acct_id = 2";
			$this->session->set_userdata('sale_pl', $sale_pl_radio);
		}elseif($sale_pl_radio == 'Both'){
			$sub_qry = "and lm.lz_seller_acct_id in (1,2)";
			$this->session->set_userdata('sale_pl', $sale_pl_radio);
		}
	// 	if(!empty($purchase_no)){
	// 	$purchase_no = "AND lm.purch_ref_no = '$purchase_no'";
	// }else{
	// 	$purchase_no = "";
	// }
	$query = $this->db->query($main_qry." ".$date_qry." ".$sub_qry);
 		return $query->result_array();

	}
	public function manifest_data(){
		$from = date('m/01/Y');
		$to = date('m/d/Y');
		$rslt =$from." - ".$to;
		$this->session->set_userdata('date_range', $rslt);
		$fromdate = date_create($from);
		$todate = date_create($to);
		$from = date_format($fromdate,'d-m-y');
		$to = date_format($todate, 'd-m-y');
		$query = $this->db->query("select purchase_items.LZ_MANIFEST_ID,lm.loading_no,lm.purch_ref_no,lm.loading_date,purchase_items.ITEM_ID,i.item_desc,purchase_items.Purchase_QTY,purchase_items.Purchase_Value,purchase_items.cost_rate,List_Items.LIST_QTY,List_Items.List_Value,List_Items.Ebay_Item_Id,sale_qry.sale_qty,sale_qry.sale_amt,sale_qry.ebay_fee EBAY_FEE,sale_qry.ship_fee SHIP_FEE,sale_qry.paypal_fee PAYPAL_FEE,nvl(sale_qry.dc_amt, 0) + (nvl(sale_qry.ebay_fee, 0) + nvl(sale_qry.ship_fee, 0) + nvl(sale_qry.paypal_fee, 0)) cosg,sale_qry.sale_amt - (nvl(sale_qry.dc_amt, 0) + (nvl(sale_qry.ebay_fee, 0) + nvl(sale_qry.ship_fee, 0) + nvl(sale_qry.paypal_fee, 0))) PL, round(decode(sale_qry.sale_amt, 0, 0,  round(((sale_qry.sale_amt - (nvl(sale_qry.dc_amt, 0) + (nvl(sale_qry.ebay_fee, 0) + nvl(sale_qry.ship_fee, 0) + nvl(sale_qry.paypal_fee, 0)))) / sale_qry.sale_amt * 100))), 2) GP, Salvage_Items.Salvage_QTY, purchase_items.cost_rate * Salvage_Items.Salvage_QTY Salvage_value, i.item_code From (SELECT LM.LZ_MANIFEST_ID, IM.ITEM_ID, SUM(NVL(LD.AVAILABLE_QTY, 0)) Purchase_QTY, COUNT(DISTINCT IM.ITEM_ID) Purchase_NOI, (sum(LD.PO_DETAIL_RETIAL_PRICE * NVL(LD.AVAILABLE_QTY, 0))) Purchase_Value, sum(LD.PO_DETAIL_RETIAL_PRICE * NVL(LD.AVAILABLE_QTY, 0)) / SUM(NVL(LD.AVAILABLE_QTY, 0)) cost_rate FROM LZ_MANIFEST_MT LM, LZ_MANIFEST_DET LD, ITEMS_MT IM WHERE LM.LZ_MANIFEST_ID = LD.LZ_MANIFEST_ID AND IM.ITEM_CODE = LD.LAPTOP_ITEM_CODE group by LM.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, IM.ITEM_ID) purchase_items, (SELECT T.LZ_MANIFEST_ID, T.Item_Id,T.Ebay_Item_Id, SUM(nvl(T.LIST_QTY, 0)) LIST_QTY, SUM(nvl(T.LIST_PRICE, 0) * nvl(T.LIST_QTY, 0)) LIST_Value, count(distinct(T.ITEM_ID)) LIST_NOI FROM EBAY_LIST_MT T WHERE upper(T.ENTRY_TYPE) = upper('l') GROUP BY T.LZ_MANIFEST_ID, T.ITEM_ID,T.Ebay_Item_Id) List_Items, (SELECT T.LZ_MANIFEST_ID, T.Item_Id, SUM(nvl(T.Salvage_Qty, 0)) Salvage_QTY, count(distinct(T.ITEM_ID)) Salvage_LIST_NOI FROM EBAY_LIST_MT T WHERE upper(T.ENTRY_TYPE) = upper('s') GROUP BY T.LZ_MANIFEST_ID, T.ITEM_ID) Salvage_Items, (select eb.lz_manifest_id, dd.item_id, sum(pd.qty) sale_qty, sum(pd.qty * (dd.line_amount / dd.primary_qty)) sale_amt, sum(sd.ebay_fee_perc) Ebay_FEE, sum(sd.shipping_charges) SHIP_FEE, sum(sd.paypal_per_trans_fee) PAYPAL_FEE, sum(pd.qty * (dd.cost_of_sale / dd.primary_qty)) dc_amt from lz_sales_pulling      pm, lz_pull_manifest_bind pd, ebay_list_mt          eb, lz_salesload_mt       sm, lz_salesload_det      sd, dc_mt                 dm, dc_detail             dd where pm.pulling_id = pd.pulling_id and eb.list_id = pd.list_id and sm.lz_saleload_id = sd.lz_saleload_id and pm.sales_record_no = sd.sales_record_number and dm.dc_id = dd.dc_id and sd.gnrtd_dc_id = dm.dc_id and eb.entry_type = 'L' group by eb.lz_manifest_id, dd.item_id) sale_qry, items_mt i, lz_manifest_mt lm  Where purchase_items.LZ_MANIFEST_ID = List_Items.LZ_MANIFEST_ID(+) AND purchase_items.Item_Id = List_Items.Item_Id(+) AND purchase_items.Item_Id = i.item_id and purchase_items.LZ_MANIFEST_ID = lm.lz_manifest_id AND purchase_items.LZ_MANIFEST_ID = Salvage_Items.LZ_MANIFEST_ID(+) AND purchase_items.Item_Id = Salvage_Items.Item_Id(+) AND purchase_items.LZ_MANIFEST_ID = sale_qry.LZ_MANIFEST_ID(+) AND purchase_items.Item_Id = sale_qry.Item_Id(+) AND lm.loading_date between TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')");
 			return $query->result_array();
		    

	}
	public function sum_manf_data(){
	$from = date('01-m-y');
	$to = date('d-m-y');
		
	$query = $this->db->query("select sum(t.cost_rate) Total_cost,sum(t.List_Value) Total_List,sum(t.List_Qty) Total_List_Qty,sum(t.sale_amt) Total_Sale_Price,sum(t.sale_qty) Total_Sale_Qty,sum(t.ebay_fee) Total_EBAY_FEE,sum(t.ship_fee) Total_SHIP_FEE,sum(t.paypal_fee) Total_PAYPAL_FEE from (select purchase_items.LZ_MANIFEST_ID,lm.loading_no,lm.purch_ref_no,lm.loading_date,purchase_items.ITEM_ID,i.item_desc,purchase_items.Purchase_QTY,purchase_items.Purchase_Value,purchase_items.cost_rate,List_Items.LIST_QTY,List_Items.List_Value,List_Items.Ebay_Item_Id,sale_qry.sale_qty,sale_qry.sale_amt,sale_qry.ebay_fee EBAY_FEE,sale_qry.ship_fee SHIP_FEE,sale_qry.paypal_fee PAYPAL_FEE,nvl(sale_qry.dc_amt, 0) + (nvl(sale_qry.ebay_fee, 0) + nvl(sale_qry.ship_fee, 0) + nvl(sale_qry.paypal_fee, 0)) cosg,sale_qry.sale_amt - (nvl(sale_qry.dc_amt, 0) + (nvl(sale_qry.ebay_fee, 0) + nvl(sale_qry.ship_fee, 0) + nvl(sale_qry.paypal_fee, 0))) PL, round(decode(sale_qry.sale_amt, 0, 0,  round(((sale_qry.sale_amt - (nvl(sale_qry.dc_amt, 0) + (nvl(sale_qry.ebay_fee, 0) + nvl(sale_qry.ship_fee, 0) + nvl(sale_qry.paypal_fee, 0)))) / sale_qry.sale_amt * 100))), 2) GP, Salvage_Items.Salvage_QTY, purchase_items.cost_rate * Salvage_Items.Salvage_QTY Salvage_value, i.item_code From (SELECT LM.LZ_MANIFEST_ID, IM.ITEM_ID, SUM(NVL(LD.AVAILABLE_QTY, 0)) Purchase_QTY, COUNT(DISTINCT IM.ITEM_ID) Purchase_NOI, (sum(LD.PO_DETAIL_RETIAL_PRICE * NVL(LD.AVAILABLE_QTY, 0))) Purchase_Value, sum(LD.PO_DETAIL_RETIAL_PRICE * NVL(LD.AVAILABLE_QTY, 0)) / SUM(NVL(LD.AVAILABLE_QTY, 0)) cost_rate FROM LZ_MANIFEST_MT LM, LZ_MANIFEST_DET LD, ITEMS_MT IM WHERE LM.LZ_MANIFEST_ID = LD.LZ_MANIFEST_ID AND IM.ITEM_CODE = LD.LAPTOP_ITEM_CODE group by LM.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, IM.ITEM_ID) purchase_items, (SELECT T.LZ_MANIFEST_ID, T.Item_Id,T.Ebay_Item_Id, SUM(nvl(T.LIST_QTY, 0)) LIST_QTY, SUM(nvl(T.LIST_PRICE, 0) * nvl(T.LIST_QTY, 0)) LIST_Value, count(distinct(T.ITEM_ID)) LIST_NOI FROM EBAY_LIST_MT T WHERE upper(T.ENTRY_TYPE) = upper('l') GROUP BY T.LZ_MANIFEST_ID, T.ITEM_ID,T.Ebay_Item_Id) List_Items, (SELECT T.LZ_MANIFEST_ID, T.Item_Id, SUM(nvl(T.Salvage_Qty, 0)) Salvage_QTY, count(distinct(T.ITEM_ID)) Salvage_LIST_NOI FROM EBAY_LIST_MT T WHERE upper(T.ENTRY_TYPE) = upper('s') GROUP BY T.LZ_MANIFEST_ID, T.ITEM_ID) Salvage_Items, (select eb.lz_manifest_id, dd.item_id, sum(pd.qty) sale_qty, sum(pd.qty * (dd.line_amount / dd.primary_qty)) sale_amt, sum(sd.ebay_fee_perc) Ebay_FEE, sum(sd.shipping_charges) SHIP_FEE, sum(sd.paypal_per_trans_fee) PAYPAL_FEE, sum(pd.qty * (dd.cost_of_sale / dd.primary_qty)) dc_amt from lz_sales_pulling      pm, lz_pull_manifest_bind pd, ebay_list_mt          eb, lz_salesload_mt       sm, lz_salesload_det      sd, dc_mt                 dm, dc_detail             dd where pm.pulling_id = pd.pulling_id and eb.list_id = pd.list_id and sm.lz_saleload_id = sd.lz_saleload_id and pm.sales_record_no = sd.sales_record_number and dm.dc_id = dd.dc_id and sd.gnrtd_dc_id = dm.dc_id and eb.entry_type = 'L' group by eb.lz_manifest_id, dd.item_id) sale_qry, items_mt i, lz_manifest_mt lm  Where purchase_items.LZ_MANIFEST_ID = List_Items.LZ_MANIFEST_ID(+) AND purchase_items.Item_Id = List_Items.Item_Id(+) AND purchase_items.Item_Id = i.item_id and purchase_items.LZ_MANIFEST_ID = lm.lz_manifest_id AND purchase_items.LZ_MANIFEST_ID = Salvage_Items.LZ_MANIFEST_ID(+) AND purchase_items.Item_Id = Salvage_Items.Item_Id(+) AND purchase_items.LZ_MANIFEST_ID = sale_qry.LZ_MANIFEST_ID(+) AND purchase_items.Item_Id = sale_qry.Item_Id(+) AND lm.loading_date between TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')) t");
 		return $query->result_array();

		   

	}
	public function search_sum_manf_data($from,$to,$purchase_no,$manif_radio){
		$main_qry = "select sum(t.cost_rate) Total_cost,sum(t.List_Value) Total_List,sum(t.List_Qty) Total_List_Qty,sum(t.sale_amt) Total_Sale_Price,sum(t.sale_qty) Total_Sale_Qty,sum(t.ebay_fee) Total_EBAY_FEE,sum(t.ship_fee) Total_SHIP_FEE,sum(t.paypal_fee) Total_PAYPAL_FEE from (select purchase_items.LZ_MANIFEST_ID,lm.loading_no,lm.purch_ref_no,lm.loading_date,purchase_items.ITEM_ID,i.item_desc,purchase_items.Purchase_QTY,purchase_items.Purchase_Value,purchase_items.cost_rate,List_Items.LIST_QTY,List_Items.List_Value,List_Items.Ebay_Item_Id,sale_qry.sale_qty,sale_qry.sale_amt,sale_qry.ebay_fee EBAY_FEE,sale_qry.ship_fee SHIP_FEE,sale_qry.paypal_fee PAYPAL_FEE,nvl(sale_qry.dc_amt, 0) + (nvl(sale_qry.ebay_fee, 0) + nvl(sale_qry.ship_fee, 0) + nvl(sale_qry.paypal_fee, 0)) cosg,sale_qry.sale_amt - (nvl(sale_qry.dc_amt, 0) + (nvl(sale_qry.ebay_fee, 0) + nvl(sale_qry.ship_fee, 0) + nvl(sale_qry.paypal_fee, 0))) PL, round(decode(sale_qry.sale_amt, 0, 0,  round(((sale_qry.sale_amt - (nvl(sale_qry.dc_amt, 0) + (nvl(sale_qry.ebay_fee, 0) + nvl(sale_qry.ship_fee, 0) + nvl(sale_qry.paypal_fee, 0)))) / sale_qry.sale_amt * 100))), 2) GP, Salvage_Items.Salvage_QTY, purchase_items.cost_rate * Salvage_Items.Salvage_QTY Salvage_value, i.item_code From (SELECT LM.LZ_MANIFEST_ID, IM.ITEM_ID, SUM(NVL(LD.AVAILABLE_QTY, 0)) Purchase_QTY, COUNT(DISTINCT IM.ITEM_ID) Purchase_NOI, (sum(LD.PO_DETAIL_RETIAL_PRICE * NVL(LD.AVAILABLE_QTY, 0))) Purchase_Value, sum(LD.PO_DETAIL_RETIAL_PRICE * NVL(LD.AVAILABLE_QTY, 0)) / SUM(NVL(LD.AVAILABLE_QTY, 0)) cost_rate FROM LZ_MANIFEST_MT LM, LZ_MANIFEST_DET LD, ITEMS_MT IM WHERE LM.LZ_MANIFEST_ID = LD.LZ_MANIFEST_ID AND IM.ITEM_CODE = LD.LAPTOP_ITEM_CODE group by LM.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, IM.ITEM_ID) purchase_items, (SELECT T.LZ_MANIFEST_ID, T.Item_Id,T.Ebay_Item_Id, SUM(nvl(T.LIST_QTY, 0)) LIST_QTY, SUM(nvl(T.LIST_PRICE, 0) * nvl(T.LIST_QTY, 0)) LIST_Value, count(distinct(T.ITEM_ID)) LIST_NOI FROM EBAY_LIST_MT T WHERE upper(T.ENTRY_TYPE) = upper('l') GROUP BY T.LZ_MANIFEST_ID, T.ITEM_ID,T.Ebay_Item_Id) List_Items, (SELECT T.LZ_MANIFEST_ID, T.Item_Id, SUM(nvl(T.Salvage_Qty, 0)) Salvage_QTY, count(distinct(T.ITEM_ID)) Salvage_LIST_NOI FROM EBAY_LIST_MT T WHERE upper(T.ENTRY_TYPE) = upper('s') GROUP BY T.LZ_MANIFEST_ID, T.ITEM_ID) Salvage_Items, (select eb.lz_manifest_id, dd.item_id, sum(pd.qty) sale_qty, sum(pd.qty * (dd.line_amount / dd.primary_qty)) sale_amt, sum(sd.ebay_fee_perc) Ebay_FEE, sum(sd.shipping_charges) SHIP_FEE, sum(sd.paypal_per_trans_fee) PAYPAL_FEE, sum(pd.qty * (dd.cost_of_sale / dd.primary_qty)) dc_amt from lz_sales_pulling      pm, lz_pull_manifest_bind pd, ebay_list_mt          eb, lz_salesload_mt       sm, lz_salesload_det      sd, dc_mt                 dm, dc_detail             dd where pm.pulling_id = pd.pulling_id and eb.list_id = pd.list_id and sm.lz_saleload_id = sd.lz_saleload_id and pm.sales_record_no = sd.sales_record_number and dm.dc_id = dd.dc_id and sd.gnrtd_dc_id = dm.dc_id and eb.entry_type = 'L' group by eb.lz_manifest_id, dd.item_id) sale_qry, items_mt i, lz_manifest_mt lm  Where purchase_items.LZ_MANIFEST_ID = List_Items.LZ_MANIFEST_ID(+) AND purchase_items.Item_Id = List_Items.Item_Id(+) AND purchase_items.Item_Id = i.item_id and purchase_items.LZ_MANIFEST_ID = lm.lz_manifest_id AND purchase_items.LZ_MANIFEST_ID = Salvage_Items.LZ_MANIFEST_ID(+) AND purchase_items.Item_Id = Salvage_Items.Item_Id(+) AND purchase_items.LZ_MANIFEST_ID = sale_qry.LZ_MANIFEST_ID(+) AND purchase_items.Item_Id = sale_qry.Item_Id(+)";
		$date_qry = "AND lm.loading_date between TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')";
		$sub_qry="";
		
		if($manif_radio == 'active'){
			 $sub_qry= "AND sale_qry.sale_amt is null AND List_Items.Ebay_Item_Id is not null";
			 $this->session->set_userdata('manif', $manif_radio);
		}elseif($manif_radio == 'sold'){
			$sub_qry = "AND sale_qry.sale_amt is not null";
			$this->session->set_userdata('manif', $manif_radio);
		}elseif($manif_radio == 'Both'){
			$sub_qry = "";
			$this->session->set_userdata('manif', $manif_radio);
		}
		if(!empty($purchase_no)){
		$purchase_no = "AND lm.purch_ref_no = '$purchase_no'";
	}else{
		$purchase_no = "";
	}
	$query = $this->db->query($main_qry." ".$date_qry." ".$sub_qry." ".$purchase_no.") t");
 		return $query->result_array();

		   

	}

	public function search_manifest_data($from,$to,$purchase_no,$manif_radio){
		$main_qry = "select purchase_items.LZ_MANIFEST_ID,lm.loading_no,lm.purch_ref_no,lm.loading_date,purchase_items.ITEM_ID,i.item_desc,purchase_items.Purchase_QTY,purchase_items.Purchase_Value,purchase_items.cost_rate,List_Items.LIST_QTY,List_Items.List_Value,List_Items.Ebay_Item_Id,sale_qry.sale_qty,sale_qry.sale_amt,sale_qry.ebay_fee EBAY_FEE,sale_qry.ship_fee SHIP_FEE,sale_qry.paypal_fee PAYPAL_FEE,nvl(sale_qry.dc_amt, 0) + (nvl(sale_qry.ebay_fee, 0) + nvl(sale_qry.ship_fee, 0) + nvl(sale_qry.paypal_fee, 0)) cosg,sale_qry.sale_amt - (nvl(sale_qry.dc_amt, 0) + (nvl(sale_qry.ebay_fee, 0) + nvl(sale_qry.ship_fee, 0) + nvl(sale_qry.paypal_fee, 0))) PL, round(decode(sale_qry.sale_amt, 0, 0,  round(((sale_qry.sale_amt - (nvl(sale_qry.dc_amt, 0) + (nvl(sale_qry.ebay_fee, 0) + nvl(sale_qry.ship_fee, 0) + nvl(sale_qry.paypal_fee, 0)))) / sale_qry.sale_amt * 100))), 2) GP, Salvage_Items.Salvage_QTY, purchase_items.cost_rate * Salvage_Items.Salvage_QTY Salvage_value, i.item_code From (SELECT LM.LZ_MANIFEST_ID, IM.ITEM_ID, SUM(NVL(LD.AVAILABLE_QTY, 0)) Purchase_QTY, COUNT(DISTINCT IM.ITEM_ID) Purchase_NOI, (sum(LD.PO_DETAIL_RETIAL_PRICE * NVL(LD.AVAILABLE_QTY, 0))) Purchase_Value, sum(LD.PO_DETAIL_RETIAL_PRICE * NVL(LD.AVAILABLE_QTY, 0)) / SUM(NVL(LD.AVAILABLE_QTY, 0)) cost_rate FROM LZ_MANIFEST_MT LM, LZ_MANIFEST_DET LD, ITEMS_MT IM WHERE LM.LZ_MANIFEST_ID = LD.LZ_MANIFEST_ID AND IM.ITEM_CODE = LD.LAPTOP_ITEM_CODE group by LM.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, IM.ITEM_ID) purchase_items, (SELECT T.LZ_MANIFEST_ID, T.Item_Id,T.Ebay_Item_Id, SUM(nvl(T.LIST_QTY, 0)) LIST_QTY, SUM(nvl(T.LIST_PRICE, 0) * nvl(T.LIST_QTY, 0)) LIST_Value, count(distinct(T.ITEM_ID)) LIST_NOI FROM EBAY_LIST_MT T WHERE upper(T.ENTRY_TYPE) = upper('l') GROUP BY T.LZ_MANIFEST_ID, T.ITEM_ID,T.Ebay_Item_Id) List_Items, (SELECT T.LZ_MANIFEST_ID, T.Item_Id, SUM(nvl(T.Salvage_Qty, 0)) Salvage_QTY, count(distinct(T.ITEM_ID)) Salvage_LIST_NOI FROM EBAY_LIST_MT T WHERE upper(T.ENTRY_TYPE) = upper('s') GROUP BY T.LZ_MANIFEST_ID, T.ITEM_ID) Salvage_Items, (select eb.lz_manifest_id, dd.item_id, sum(pd.qty) sale_qty, sum(pd.qty * (dd.line_amount / dd.primary_qty)) sale_amt, sum(sd.ebay_fee_perc) Ebay_FEE, sum(sd.shipping_charges) SHIP_FEE, sum(sd.paypal_per_trans_fee) PAYPAL_FEE, sum(pd.qty * (dd.cost_of_sale / dd.primary_qty)) dc_amt from lz_sales_pulling      pm, lz_pull_manifest_bind pd, ebay_list_mt          eb, lz_salesload_mt       sm, lz_salesload_det      sd, dc_mt                 dm, dc_detail             dd where pm.pulling_id = pd.pulling_id and eb.list_id = pd.list_id and sm.lz_saleload_id = sd.lz_saleload_id and pm.sales_record_no = sd.sales_record_number and dm.dc_id = dd.dc_id and sd.gnrtd_dc_id = dm.dc_id and eb.entry_type = 'L' group by eb.lz_manifest_id, dd.item_id) sale_qry, items_mt i, lz_manifest_mt lm  Where purchase_items.LZ_MANIFEST_ID = List_Items.LZ_MANIFEST_ID(+) AND purchase_items.Item_Id = List_Items.Item_Id(+) AND purchase_items.Item_Id = i.item_id and purchase_items.LZ_MANIFEST_ID = lm.lz_manifest_id AND purchase_items.LZ_MANIFEST_ID = Salvage_Items.LZ_MANIFEST_ID(+) AND purchase_items.Item_Id = Salvage_Items.Item_Id(+) AND purchase_items.LZ_MANIFEST_ID = sale_qry.LZ_MANIFEST_ID(+) AND purchase_items.Item_Id = sale_qry.Item_Id(+)";
		$date_qry = "AND lm.loading_date between TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')";
		$sub_qry="";
		
		if($manif_radio == 'active'){
			 $sub_qry= "AND sale_qry.sale_amt is null AND List_Items.Ebay_Item_Id is not null";
			 $this->session->set_userdata('manif', $manif_radio);
		}elseif($manif_radio == 'sold'){
			$sub_qry = "AND sale_qry.sale_amt is not null";
			$this->session->set_userdata('manif', $manif_radio);
		}elseif($manif_radio == 'Both'){
			$sub_qry = "";
			$this->session->set_userdata('manif', $manif_radio);
		}
		if(!empty($purchase_no)){
		$purchase_no = "AND lm.purch_ref_no = '$purchase_no'";
	}else{
		$purchase_no = "";
	}
	$query = $this->db->query($main_qry." ".$date_qry." ".$sub_qry." ".$purchase_no);
 		return $query->result_array();

	}		
	
	
//  ============== Post Manifest pl report start =====================

	public function post_manifest_data($from,$to,$purchase_no,$manif_dropdown,$keyword_search){
		if(!empty($from) && !empty($to) && !empty($manif_dropdown))
		{
			$main_qry = "select purchase_items.LZ_MANIFEST_ID, purchase_items.Item_Bar_Code, purchase_items.ITEM_MT_MFG_PART_NO, purchase_items.Item_Mt_Upc, lm.loading_no, lm.purch_ref_no, lm.loading_date, purchase_items.ITEM_ID, i.item_desc, purchase_items.Purchase_QTY, purchase_items.Purchase_Value, purchase_items.cost_rate, List_Items.LIST_QTY, List_Items.List_Value, List_Items.Ebay_Item_Id, sale_qry.sale_qty, sale_qry.sale_amt, sale_qry.ebay_fee EBAY_FEE, sale_qry.ship_fee SHIP_FEE, sale_qry.paypal_fee PAYPAL_FEE, nvl(sale_qry.dc_amt, 0) + (nvl(sale_qry.ebay_fee, 0) + nvl(sale_qry.ship_fee, 0) + nvl(sale_qry.paypal_fee, 0)) cosg, sale_qry.sale_amt - (nvl(sale_qry.dc_amt, 0) + (nvl(sale_qry.ebay_fee, 0) + nvl(sale_qry.ship_fee, 0) + nvl(sale_qry.paypal_fee, 0))) PL, round(decode(sale_qry.sale_amt, 0, 0, round(((sale_qry.sale_amt - (nvl(sale_qry.dc_amt, 0) + (nvl(sale_qry.ebay_fee, 0) + nvl(sale_qry.ship_fee, 0) + nvl(sale_qry.paypal_fee, 0)))) / sale_qry.sale_amt * 100))), 2) GP, Salvage_Items.Salvage_QTY, purchase_items.cost_rate * Salvage_Items.Salvage_QTY Salvage_value, i.item_code From (SELECT LM.LZ_MANIFEST_ID, IM.ITEM_ID, IM.Item_Bar_Code, IM.ITEM_MT_MFG_PART_NO, IM.Item_Mt_Upc, SUM(NVL(LD.AVAILABLE_QTY, 0)) Purchase_QTY, COUNT(DISTINCT IM.ITEM_ID) Purchase_NOI, (sum(LD.PO_DETAIL_RETIAL_PRICE * NVL(LD.AVAILABLE_QTY, 0))) Purchase_Value, sum(LD.PO_DETAIL_RETIAL_PRICE * NVL(LD.AVAILABLE_QTY, 0)) / SUM(NVL(LD.AVAILABLE_QTY, 0)) cost_rate FROM LZ_MANIFEST_MT LM, LZ_MANIFEST_DET LD, ITEMS_MT IM WHERE LM.LZ_MANIFEST_ID = LD.LZ_MANIFEST_ID AND IM.ITEM_CODE = LD.LAPTOP_ITEM_CODE AND LM.excel_file_name<>'FORM ENTRY' group by LM.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, IM.Item_Bar_Code, IM.ITEM_MT_MFG_PART_NO, IM.Item_Mt_Upc, IM.ITEM_ID) purchase_items, (SELECT T.LZ_MANIFEST_ID, T.Item_Id, T.Ebay_Item_Id, SUM(nvl(T.LIST_QTY, 0)) LIST_QTY, SUM(nvl(T.LIST_PRICE, 0) * nvl(T.LIST_QTY, 0)) LIST_Value, count(distinct(T.ITEM_ID)) LIST_NOI FROM EBAY_LIST_MT T WHERE upper(T.ENTRY_TYPE) = upper('l') GROUP BY T.LZ_MANIFEST_ID, T.ITEM_ID, T.Ebay_Item_Id) List_Items, (SELECT T.LZ_MANIFEST_ID, T.Item_Id, SUM(nvl(T.Salvage_Qty, 0)) Salvage_QTY, count(distinct(T.ITEM_ID)) Salvage_LIST_NOI FROM EBAY_LIST_MT T WHERE upper(T.ENTRY_TYPE) = upper('s') GROUP BY T.LZ_MANIFEST_ID, T.ITEM_ID) Salvage_Items, (select eb.lz_manifest_id, dd.item_id, sum(pd.qty) sale_qty, sum(pd.qty * (dd.line_amount / dd.primary_qty)) sale_amt, sum(sd.ebay_fee_perc) Ebay_FEE, sum(sd.shipping_charges) SHIP_FEE, sum(sd.paypal_per_trans_fee) PAYPAL_FEE, sum(pd.qty * (dd.cost_of_sale / dd.primary_qty)) dc_amt from lz_sales_pulling      pm, lz_pull_manifest_bind pd, ebay_list_mt          eb, lz_salesload_mt       sm, lz_salesload_det      sd, dc_mt                 dm, dc_detail             dd where pm.pulling_id = pd.pulling_id and eb.list_id = pd.list_id and sm.lz_saleload_id = sd.lz_saleload_id and pm.sales_record_no = sd.sales_record_number and dm.dc_id = dd.dc_id and sd.gnrtd_dc_id = dm.dc_id and eb.entry_type = 'L'group by eb.lz_manifest_id, dd.item_id) sale_qry, items_mt i, lz_manifest_mt lm Where purchase_items.LZ_MANIFEST_ID = List_Items.LZ_MANIFEST_ID(+) AND purchase_items.Item_Id = List_Items.Item_Id(+) AND purchase_items.Item_Id = i.item_id and purchase_items.LZ_MANIFEST_ID = lm.lz_manifest_id AND purchase_items.LZ_MANIFEST_ID = Salvage_Items.LZ_MANIFEST_ID(+) AND purchase_items.Item_Id = Salvage_Items.Item_Id(+) AND purchase_items.LZ_MANIFEST_ID = sale_qry.LZ_MANIFEST_ID(+) AND purchase_items.Item_Id = sale_qry.Item_Id(+)"; 
			$date_qry = "AND lm.loading_date between TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')";
			$sub_qry="";
			
			if($manif_dropdown == 'Active'){
				 $sub_qry= "AND sale_qry.sale_amt is null AND List_Items.Ebay_Item_Id is not null";
				 $this->session->set_userdata('manif', $manif_dropdown);
			}elseif($manif_dropdown == 'Sold'){
				$sub_qry = "AND sale_qry.sale_amt is not null";
				$this->session->set_userdata('manif', $manif_dropdown);
			}elseif($manif_dropdown == 'Not Listed'){
				$sub_qry = "AND List_Items.list_qty is null";
				$this->session->set_userdata('manif', $manif_dropdown);
			}elseif($manif_dropdown == 'All'){
				$sub_qry = "";
				$this->session->set_userdata('manif', $manif_dropdown);
			}
			if(!empty($purchase_no)){
			$purchase_no = "AND lm.purch_ref_no = '$purchase_no'";
			}else{
				$purchase_no = "";
			}
			if(!empty($keyword_search)){
			$keyword_search = "AND (purchase_items.LZ_MANIFEST_ID like '%$keyword_search%' or purchase_items.Item_Bar_Code like '%$keyword_search%' or purchase_items.ITEM_MT_MFG_PART_NO like '%$keyword_search%' or purchase_items.Item_Mt_Upc like '%$keyword_search%' or lm.purch_ref_no like '%$keyword_search%' or purchase_items.ITEM_ID like '%$keyword_search%' or i.item_desc like '%$keyword_search%' or List_Items.Ebay_Item_Id like '%$keyword_search%' or i.item_code like '%$keyword_search%')";
			}else{
				$keyword_search = "";
			}			
			$query = $this->db->query($main_qry." ".$date_qry." ".$sub_qry." ".$purchase_no. " ". $keyword_search);
						
		}else{
			$from = date('m/d/Y', strtotime('-3 months'));// date('m/01/Y');
			$to = date('m/d/Y');
			$rslt =$from." - ".$to;
			$this->session->set_userdata('date_range', $rslt);
			$fromdate = date_create($from);
			$todate = date_create($to);
			$from = date_format($fromdate,'d-m-y');
			$to = date_format($todate, 'd-m-y');
			$query = $this->db->query("select purchase_items.LZ_MANIFEST_ID, purchase_items.Item_Bar_Code, purchase_items.ITEM_MT_MFG_PART_NO, purchase_items.Item_Mt_Upc, lm.loading_no, lm.purch_ref_no, lm.loading_date, purchase_items.ITEM_ID, i.item_desc, purchase_items.Purchase_QTY, purchase_items.Purchase_Value, purchase_items.cost_rate, List_Items.LIST_QTY, List_Items.List_Value, List_Items.Ebay_Item_Id, sale_qry.sale_qty, sale_qry.sale_amt, sale_qry.ebay_fee EBAY_FEE, sale_qry.ship_fee SHIP_FEE, sale_qry.paypal_fee PAYPAL_FEE, nvl(sale_qry.dc_amt, 0) + (nvl(sale_qry.ebay_fee, 0) + nvl(sale_qry.ship_fee, 0) + nvl(sale_qry.paypal_fee, 0)) cosg, sale_qry.sale_amt - (nvl(sale_qry.dc_amt, 0) + (nvl(sale_qry.ebay_fee, 0) + nvl(sale_qry.ship_fee, 0) + nvl(sale_qry.paypal_fee, 0))) PL, round(decode(sale_qry.sale_amt, 0, 0, round(((sale_qry.sale_amt - (nvl(sale_qry.dc_amt, 0) + (nvl(sale_qry.ebay_fee, 0) + nvl(sale_qry.ship_fee, 0) + nvl(sale_qry.paypal_fee, 0)))) / sale_qry.sale_amt * 100))), 2) GP, Salvage_Items.Salvage_QTY, purchase_items.cost_rate * Salvage_Items.Salvage_QTY Salvage_value, i.item_code From (SELECT LM.LZ_MANIFEST_ID, IM.ITEM_ID, IM.Item_Bar_Code, IM.ITEM_MT_MFG_PART_NO, IM.Item_Mt_Upc, SUM(NVL(LD.AVAILABLE_QTY, 0)) Purchase_QTY, COUNT(DISTINCT IM.ITEM_ID) Purchase_NOI, (sum(LD.PO_DETAIL_RETIAL_PRICE * NVL(LD.AVAILABLE_QTY, 0))) Purchase_Value, sum(LD.PO_DETAIL_RETIAL_PRICE * NVL(LD.AVAILABLE_QTY, 0)) / SUM(NVL(LD.AVAILABLE_QTY, 0)) cost_rate FROM LZ_MANIFEST_MT LM, LZ_MANIFEST_DET LD, ITEMS_MT IM WHERE LM.LZ_MANIFEST_ID = LD.LZ_MANIFEST_ID AND IM.ITEM_CODE = LD.LAPTOP_ITEM_CODE AND LM.excel_file_name<>'FORM ENTRY' group by LM.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, IM.Item_Bar_Code, IM.ITEM_MT_MFG_PART_NO, IM.Item_Mt_Upc, IM.ITEM_ID) purchase_items, (SELECT T.LZ_MANIFEST_ID, T.Item_Id, T.Ebay_Item_Id, SUM(nvl(T.LIST_QTY, 0)) LIST_QTY, SUM(nvl(T.LIST_PRICE, 0) * nvl(T.LIST_QTY, 0)) LIST_Value, count(distinct(T.ITEM_ID)) LIST_NOI FROM EBAY_LIST_MT T WHERE upper(T.ENTRY_TYPE) = upper('l') GROUP BY T.LZ_MANIFEST_ID, T.ITEM_ID, T.Ebay_Item_Id) List_Items, (SELECT T.LZ_MANIFEST_ID, T.Item_Id, SUM(nvl(T.Salvage_Qty, 0)) Salvage_QTY, count(distinct(T.ITEM_ID)) Salvage_LIST_NOI FROM EBAY_LIST_MT T WHERE upper(T.ENTRY_TYPE) = upper('s') GROUP BY T.LZ_MANIFEST_ID, T.ITEM_ID) Salvage_Items, (select eb.lz_manifest_id, dd.item_id, sum(pd.qty) sale_qty, sum(pd.qty * (dd.line_amount / dd.primary_qty)) sale_amt, sum(sd.ebay_fee_perc) Ebay_FEE, sum(sd.shipping_charges) SHIP_FEE, sum(sd.paypal_per_trans_fee) PAYPAL_FEE, sum(pd.qty * (dd.cost_of_sale / dd.primary_qty)) dc_amt from lz_sales_pulling      pm, lz_pull_manifest_bind pd, ebay_list_mt          eb, lz_salesload_mt       sm, lz_salesload_det      sd, dc_mt                 dm, dc_detail             dd where pm.pulling_id = pd.pulling_id and eb.list_id = pd.list_id and sm.lz_saleload_id = sd.lz_saleload_id and pm.sales_record_no = sd.sales_record_number and dm.dc_id = dd.dc_id and sd.gnrtd_dc_id = dm.dc_id and eb.entry_type = 'L'group by eb.lz_manifest_id, dd.item_id) sale_qry, items_mt i, lz_manifest_mt lm Where purchase_items.LZ_MANIFEST_ID = List_Items.LZ_MANIFEST_ID(+) AND purchase_items.Item_Id = List_Items.Item_Id(+) AND purchase_items.Item_Id = i.item_id and purchase_items.LZ_MANIFEST_ID = lm.lz_manifest_id AND purchase_items.LZ_MANIFEST_ID = Salvage_Items.LZ_MANIFEST_ID(+) AND purchase_items.Item_Id = Salvage_Items.Item_Id(+) AND purchase_items.LZ_MANIFEST_ID = sale_qry.LZ_MANIFEST_ID(+) AND purchase_items.Item_Id = sale_qry.Item_Id(+) AND lm.loading_date between TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')"); }
		return $query->result_array();
		    

	}
	public function post_sum_manf_data($from,$to,$purchase_no,$manif_dropdown,$keyword_search){
	if(!empty($from) && !empty($to) && !empty($manif_dropdown))
		{
					$sub_main_qry1 = "(select sum(sum_qry.list_qty) Total_list_qty, sum(sum_qry.list_value) Total_list_val, sum(sum_qry.sale_qty) Total_sold_qty, sum(sum_qry.sale_amt) total_sale_amt, (sum(sum_qry.purchase_qty) - sum(sum_qry.list_qty)) not_listed_qty, (sum(sum_qry.purchase_value) - sum(sum_qry.list_value)) not_listed_value, sum(sum_qry.salvage_qty) total_salvage_qty, sum(sum_qry.salvage_value) total_salvage_value, count(distinct item_id) total_unq from (select qry.LZ_MANIFEST_ID, qry.ITEM_ID, qry.Purchase_QTY, qry.Purchase_Value, qry.cost_rate, qry.LIST_QTY, qry.List_Value, qry.sale_qty, qry.sale_amt, qry.Salvage_QTY, qry.Salvage_value from (select purchase_items.LZ_MANIFEST_ID, purchase_items.Item_Bar_Code, purchase_items.ITEM_MT_MFG_PART_NO, purchase_items.Item_Mt_Upc, lm.loading_no, lm.purch_ref_no, lm.loading_date, purchase_items.ITEM_ID, i.item_desc, purchase_items.Purchase_QTY, purchase_items.Purchase_Value, purchase_items.cost_rate, List_Items.LIST_QTY, List_Items.List_Value, List_Items.Ebay_Item_Id, sale_qry.sale_qty, sale_qry.sale_amt, sale_qry.ebay_fee EBAY_FEE, sale_qry.ship_fee SHIP_FEE, sale_qry.paypal_fee PAYPAL_FEE, nvl(sale_qry.dc_amt, 0) + (nvl(sale_qry.ebay_fee, 0) + nvl(sale_qry.ship_fee, 0) + nvl(sale_qry.paypal_fee, 0)) cosg, sale_qry.sale_amt - (nvl(sale_qry.dc_amt, 0) + (nvl(sale_qry.ebay_fee, 0) + nvl(sale_qry.ship_fee, 0) + nvl(sale_qry.paypal_fee, 0))) PL, round(decode(sale_qry.sale_amt, 0, 0, round(((sale_qry.sale_amt - (nvl(sale_qry.dc_amt, 0) + (nvl(sale_qry.ebay_fee, 0) + nvl(sale_qry.ship_fee, 0) + nvl(sale_qry.paypal_fee, 0)))) / sale_qry.sale_amt * 100))), 2) GP, Salvage_Items.Salvage_QTY, purchase_items.cost_rate * Salvage_Items.Salvage_QTY Salvage_value, i.item_code From (SELECT LM.LZ_MANIFEST_ID, IM.ITEM_ID, IM.Item_Bar_Code, IM.ITEM_MT_MFG_PART_NO, IM.Item_Mt_Upc, SUM(NVL(LD.AVAILABLE_QTY, 0)) Purchase_QTY, COUNT(DISTINCT IM.ITEM_ID) Purchase_NOI, (sum(LD.PO_DETAIL_RETIAL_PRICE * NVL(LD.AVAILABLE_QTY, 0))) Purchase_Value, sum(LD.PO_DETAIL_RETIAL_PRICE * NVL(LD.AVAILABLE_QTY, 0)) / SUM(NVL(LD.AVAILABLE_QTY, 0)) cost_rate FROM LZ_MANIFEST_MT LM, LZ_MANIFEST_DET LD, ITEMS_MT IM WHERE LM.LZ_MANIFEST_ID = LD.LZ_MANIFEST_ID AND IM.ITEM_CODE = LD.LAPTOP_ITEM_CODE AND LM.excel_file_name<>'FORM ENTRY' group by LM.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, IM.Item_Bar_Code, IM.ITEM_MT_MFG_PART_NO, IM.Item_Mt_Upc, IM.ITEM_ID) purchase_items, (SELECT T.LZ_MANIFEST_ID, T.Item_Id, T.Ebay_Item_Id, SUM(nvl(T.LIST_QTY, 0)) LIST_QTY, SUM(nvl(T.LIST_PRICE, 0) * nvl(T.LIST_QTY, 0)) LIST_Value, count(distinct(T.ITEM_ID)) LIST_NOI FROM EBAY_LIST_MT T WHERE upper(T.ENTRY_TYPE) = upper('l') GROUP BY T.LZ_MANIFEST_ID, T.ITEM_ID, T.Ebay_Item_Id) List_Items, (SELECT T.LZ_MANIFEST_ID, T.Item_Id, SUM(nvl(T.Salvage_Qty, 0)) Salvage_QTY, count(distinct(T.ITEM_ID)) Salvage_LIST_NOI FROM EBAY_LIST_MT T WHERE upper(T.ENTRY_TYPE) = upper('s') GROUP BY T.LZ_MANIFEST_ID, T.ITEM_ID) Salvage_Items, (select eb.lz_manifest_id, dd.item_id, sum(pd.qty) sale_qty, sum(pd.qty * (dd.line_amount / dd.primary_qty)) sale_amt, sum(sd.ebay_fee_perc) Ebay_FEE, sum(sd.shipping_charges) SHIP_FEE, sum(sd.paypal_per_trans_fee) PAYPAL_FEE, sum(pd.qty * (dd.cost_of_sale / dd.primary_qty)) dc_amt from lz_sales_pulling      pm, lz_pull_manifest_bind pd, ebay_list_mt          eb, lz_salesload_mt       sm, lz_salesload_det      sd, dc_mt                 dm, dc_detail             dd where pm.pulling_id = pd.pulling_id and eb.list_id = pd.list_id and sm.lz_saleload_id = sd.lz_saleload_id and pm.sales_record_no = sd.sales_record_number and dm.dc_id = dd.dc_id and sd.gnrtd_dc_id = dm.dc_id and eb.entry_type = 'L'group by eb.lz_manifest_id, dd.item_id) sale_qry, items_mt i, lz_manifest_mt lm Where purchase_items.LZ_MANIFEST_ID = List_Items.LZ_MANIFEST_ID(+) AND purchase_items.Item_Id = List_Items.Item_Id(+) AND purchase_items.Item_Id = i.item_id and purchase_items.LZ_MANIFEST_ID = lm.lz_manifest_id AND purchase_items.LZ_MANIFEST_ID = Salvage_Items.LZ_MANIFEST_ID(+) AND purchase_items.Item_Id = Salvage_Items.Item_Id(+) AND purchase_items.LZ_MANIFEST_ID = sale_qry.LZ_MANIFEST_ID(+) AND purchase_items.Item_Id = sale_qry.Item_Id(+)";
					$date_qry1 = "AND lm.loading_date between TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')";
					$sub_qry1="";			
					if($manif_dropdown == 'Active'){
					 $sub_qry1= "AND sale_qry.sale_amt is null AND List_Items.Ebay_Item_Id is not null";
					 $this->session->set_userdata('manif', $manif_dropdown);
					}elseif($manif_dropdown == 'Sold'){
						$sub_qry1 = "AND sale_qry.sale_amt is not null";
						$this->session->set_userdata('manif', $manif_dropdown);
					}elseif($manif_dropdown == 'Not Listed'){
						$sub_qry1 = "AND List_Items.list_qty is null";
						$this->session->set_userdata('manif', $manif_dropdown);
					}elseif($manif_dropdown == 'All'){
						$sub_qry1 = "";
						$this->session->set_userdata('manif', $manif_dropdown);
					}
					if(!empty($purchase_no)){
					$purch_no = "AND lm.purch_ref_no = '$purchase_no'";
					}else{
						$purch_no = "";
					}
					if(!empty($keyword_search)){
					$keyword= "AND (purchase_items.LZ_MANIFEST_ID like '%$keyword_search%' or purchase_items.Item_Bar_Code like '%$keyword_search%' or purchase_items.ITEM_MT_MFG_PART_NO like '%$keyword_search%' or purchase_items.Item_Mt_Upc like '%$keyword_search%' or lm.purch_ref_no like '%$keyword_search%' or purchase_items.ITEM_ID like '%$keyword_search%' or i.item_desc like '%$keyword_search%' or List_Items.Ebay_Item_Id like '%$keyword_search%' or i.item_code like '%$keyword_search%')";
					}else{
						$keyword = "";
					}
					$summary_query = $sub_main_qry1." ".$date_qry1." ".$sub_qry1." ".$purch_no." ".$keyword.") qry ) sum_qry)";


					$sub_main_qry2 = "(select sum(pur.purchase_value) not_listed_value from (select qry.LZ_MANIFEST_ID, qry.ITEM_ID, qry.Purchase_QTY, qry.Purchase_Value, qry.cost_rate, qry.LIST_QTY, qry.List_Value, qry.sale_qty, qry.sale_amt, qry.Salvage_QTY, qry.Salvage_value from (select purchase_items.LZ_MANIFEST_ID, purchase_items.Item_Bar_Code, purchase_items.ITEM_MT_MFG_PART_NO, purchase_items.Item_Mt_Upc, lm.loading_no, lm.purch_ref_no, lm.loading_date, purchase_items.ITEM_ID, i.item_desc, purchase_items.Purchase_QTY, purchase_items.Purchase_Value, purchase_items.cost_rate, List_Items.LIST_QTY, List_Items.List_Value, List_Items.Ebay_Item_Id, sale_qry.sale_qty, sale_qry.sale_amt, sale_qry.ebay_fee EBAY_FEE, sale_qry.ship_fee SHIP_FEE, sale_qry.paypal_fee PAYPAL_FEE, nvl(sale_qry.dc_amt, 0) + (nvl(sale_qry.ebay_fee, 0) + nvl(sale_qry.ship_fee, 0) + nvl(sale_qry.paypal_fee, 0)) cosg, sale_qry.sale_amt - (nvl(sale_qry.dc_amt, 0) + (nvl(sale_qry.ebay_fee, 0) + nvl(sale_qry.ship_fee, 0) + nvl(sale_qry.paypal_fee, 0))) PL, round(decode(sale_qry.sale_amt, 0, 0, round(((sale_qry.sale_amt - (nvl(sale_qry.dc_amt, 0) + (nvl(sale_qry.ebay_fee, 0) + nvl(sale_qry.ship_fee, 0) + nvl(sale_qry.paypal_fee, 0)))) / sale_qry.sale_amt * 100))), 2) GP, Salvage_Items.Salvage_QTY, purchase_items.cost_rate * Salvage_Items.Salvage_QTY Salvage_value, i.item_code From (SELECT LM.LZ_MANIFEST_ID, IM.ITEM_ID, IM.Item_Bar_Code, IM.ITEM_MT_MFG_PART_NO, IM.Item_Mt_Upc, SUM(NVL(LD.AVAILABLE_QTY, 0)) Purchase_QTY, COUNT(DISTINCT IM.ITEM_ID) Purchase_NOI, (sum(LD.PO_DETAIL_RETIAL_PRICE * NVL(LD.AVAILABLE_QTY, 0))) Purchase_Value, sum(LD.PO_DETAIL_RETIAL_PRICE * NVL(LD.AVAILABLE_QTY, 0)) / SUM(NVL(LD.AVAILABLE_QTY, 0)) cost_rate FROM LZ_MANIFEST_MT LM, LZ_MANIFEST_DET LD, ITEMS_MT IM WHERE LM.LZ_MANIFEST_ID = LD.LZ_MANIFEST_ID AND IM.ITEM_CODE = LD.LAPTOP_ITEM_CODE AND LM.excel_file_name<>'FORM ENTRY' group by LM.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, IM.Item_Bar_Code, IM.ITEM_MT_MFG_PART_NO, IM.Item_Mt_Upc, IM.ITEM_ID) purchase_items, (SELECT T.LZ_MANIFEST_ID, T.Item_Id, T.Ebay_Item_Id, SUM(nvl(T.LIST_QTY, 0)) LIST_QTY, SUM(nvl(T.LIST_PRICE, 0) * nvl(T.LIST_QTY, 0)) LIST_Value, count(distinct(T.ITEM_ID)) LIST_NOI FROM EBAY_LIST_MT T WHERE upper(T.ENTRY_TYPE) = upper('l') GROUP BY T.LZ_MANIFEST_ID, T.ITEM_ID, T.Ebay_Item_Id) List_Items, (SELECT T.LZ_MANIFEST_ID, T.Item_Id, SUM(nvl(T.Salvage_Qty, 0)) Salvage_QTY, count(distinct(T.ITEM_ID)) Salvage_LIST_NOI FROM EBAY_LIST_MT T WHERE upper(T.ENTRY_TYPE) = upper('s') GROUP BY T.LZ_MANIFEST_ID, T.ITEM_ID) Salvage_Items, (select eb.lz_manifest_id, dd.item_id, sum(pd.qty) sale_qty, sum(pd.qty * (dd.line_amount / dd.primary_qty)) sale_amt, sum(sd.ebay_fee_perc) Ebay_FEE, sum(sd.shipping_charges) SHIP_FEE, sum(sd.paypal_per_trans_fee) PAYPAL_FEE, sum(pd.qty * (dd.cost_of_sale / dd.primary_qty)) dc_amt from lz_sales_pulling      pm, lz_pull_manifest_bind pd, ebay_list_mt          eb, lz_salesload_mt       sm, lz_salesload_det      sd, dc_mt                 dm, dc_detail             dd where pm.pulling_id = pd.pulling_id and eb.list_id = pd.list_id and sm.lz_saleload_id = sd.lz_saleload_id and pm.sales_record_no = sd.sales_record_number and dm.dc_id = dd.dc_id and sd.gnrtd_dc_id = dm.dc_id and eb.entry_type = 'L'group by eb.lz_manifest_id, dd.item_id) sale_qry, items_mt i, lz_manifest_mt lm Where purchase_items.LZ_MANIFEST_ID = List_Items.LZ_MANIFEST_ID(+) AND purchase_items.Item_Id = List_Items.Item_Id(+) AND purchase_items.Item_Id = i.item_id and purchase_items.LZ_MANIFEST_ID = lm.lz_manifest_id AND purchase_items.LZ_MANIFEST_ID = Salvage_Items.LZ_MANIFEST_ID(+) AND purchase_items.Item_Id = Salvage_Items.Item_Id(+) AND purchase_items.LZ_MANIFEST_ID = sale_qry.LZ_MANIFEST_ID(+) AND purchase_items.Item_Id = sale_qry.Item_Id(+)"; 
 					$date_qry2 = "AND lm.loading_date between TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')";
					$sub_qry2="";			
					if($manif_dropdown == 'Active'){
					 $sub_qry2= "AND sale_qry.sale_amt is null AND List_Items.Ebay_Item_Id is not null";
					 $this->session->set_userdata('manif', $manif_dropdown);
					}elseif($manif_dropdown == 'Sold'){
						$sub_qry2 = "AND sale_qry.sale_amt is not null";
						$this->session->set_userdata('manif', $manif_dropdown);
					}elseif($manif_dropdown == 'Not Listed'){
						$sub_qry2 = "AND List_Items.list_qty is null";
						$this->session->set_userdata('manif', $manif_dropdown);
					}elseif($manif_dropdown == 'All'){
						$sub_qry2 = "";
						$this->session->set_userdata('manif', $manif_dropdown);
					}
					if(!empty($purchase_no)){
					$this->session->set_userdata('purchase_no', $purchase_no);
					$purchase_num = "AND lm.purch_ref_no = '$purchase_no'";

					}else{
						$purchase_num = "";
					}
					if(!empty($keyword_search)){
					$key= "AND (purchase_items.LZ_MANIFEST_ID like '%$keyword_search%' or purchase_items.Item_Bar_Code like '%$keyword_search%' or purchase_items.ITEM_MT_MFG_PART_NO like '%$keyword_search%' or purchase_items.Item_Mt_Upc like '%$keyword_search%' or lm.purch_ref_no like '%$keyword_search%' or purchase_items.ITEM_ID like '%$keyword_search%' or i.item_desc like '%$keyword_search%' or List_Items.Ebay_Item_Id like '%$keyword_search%' or i.item_code like '%$keyword_search%')";
					}else{
						$key = "";
					}
					$not_listed_query = $sub_main_qry2." ".$date_qry2." ".$sub_qry2." ".$purchase_num." ".$key." ) qry) pur)";
					$wrap_qry = "Select * from ";

					$query = $this->db->query($wrap_qry. $summary_query.",".$not_listed_query);
					//print_r($wrap_qry. $summary_query.",".$not_listed_query);exit;

			
		}else{
				$from = date('m/d/Y', strtotime('-3 months'));// date('m/01/Y');
				$to = date('m/d/Y');
				$rslt =$from." - ".$to;
				$this->session->set_userdata('date_range', $rslt);
				$fromdate = date_create($from);
				$todate = date_create($to);
				$from = date_format($fromdate,'d-m-y');
				$to = date_format($todate, 'd-m-y');
					
				$query = $this->db->query("select sum(sum_qry.list_qty) Total_list_qty, sum(sum_qry.list_value) Total_list_val, sum(sum_qry.sale_qty) Total_sold_qty, sum(sum_qry.sale_amt) total_sale_amt, (sum(sum_qry.purchase_qty) - sum(sum_qry.list_qty)) not_listed_qty, (sum(sum_qry.purchase_value) - sum(sum_qry.list_value)) not_listed_value, sum(sum_qry.salvage_qty) total_salvage_qty, sum(sum_qry.salvage_value) total_salvage_value, count(distinct item_id) total_unq from (select qry.LZ_MANIFEST_ID, qry.ITEM_ID, qry.Purchase_QTY, qry.Purchase_Value, qry.cost_rate, qry.LIST_QTY, qry.List_Value, qry.sale_qty, qry.sale_amt, qry.Salvage_QTY, qry.Salvage_value from (select purchase_items.LZ_MANIFEST_ID, purchase_items.Item_Bar_Code, purchase_items.ITEM_MT_MFG_PART_NO, purchase_items.Item_Mt_Upc, lm.loading_no, lm.purch_ref_no, lm.loading_date, purchase_items.ITEM_ID, i.item_desc, purchase_items.Purchase_QTY, purchase_items.Purchase_Value, purchase_items.cost_rate, List_Items.LIST_QTY, List_Items.List_Value, List_Items.Ebay_Item_Id, sale_qry.sale_qty, sale_qry.sale_amt, sale_qry.ebay_fee EBAY_FEE, sale_qry.ship_fee SHIP_FEE, sale_qry.paypal_fee PAYPAL_FEE, nvl(sale_qry.dc_amt, 0) + (nvl(sale_qry.ebay_fee, 0) + nvl(sale_qry.ship_fee, 0) + nvl(sale_qry.paypal_fee, 0)) cosg, sale_qry.sale_amt - (nvl(sale_qry.dc_amt, 0) + (nvl(sale_qry.ebay_fee, 0) + nvl(sale_qry.ship_fee, 0) + nvl(sale_qry.paypal_fee, 0))) PL, round(decode(sale_qry.sale_amt, 0, 0, round(((sale_qry.sale_amt - (nvl(sale_qry.dc_amt, 0) + (nvl(sale_qry.ebay_fee, 0) + nvl(sale_qry.ship_fee, 0) + nvl(sale_qry.paypal_fee, 0)))) / sale_qry.sale_amt * 100))), 2) GP, Salvage_Items.Salvage_QTY, purchase_items.cost_rate * Salvage_Items.Salvage_QTY Salvage_value, i.item_code From (SELECT LM.LZ_MANIFEST_ID, IM.ITEM_ID, IM.Item_Bar_Code, IM.ITEM_MT_MFG_PART_NO, IM.Item_Mt_Upc, SUM(NVL(LD.AVAILABLE_QTY, 0)) Purchase_QTY, COUNT(DISTINCT IM.ITEM_ID) Purchase_NOI, (sum(LD.PO_DETAIL_RETIAL_PRICE * NVL(LD.AVAILABLE_QTY, 0))) Purchase_Value, sum(LD.PO_DETAIL_RETIAL_PRICE * NVL(LD.AVAILABLE_QTY, 0)) / SUM(NVL(LD.AVAILABLE_QTY, 0)) cost_rate FROM LZ_MANIFEST_MT LM, LZ_MANIFEST_DET LD, ITEMS_MT IM WHERE LM.LZ_MANIFEST_ID = LD.LZ_MANIFEST_ID AND IM.ITEM_CODE = LD.LAPTOP_ITEM_CODE AND LM.excel_file_name<>'FORM ENTRY' group by LM.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, IM.Item_Bar_Code, IM.ITEM_MT_MFG_PART_NO, IM.Item_Mt_Upc, IM.ITEM_ID) purchase_items, (SELECT T.LZ_MANIFEST_ID, T.Item_Id, T.Ebay_Item_Id, SUM(nvl(T.LIST_QTY, 0)) LIST_QTY, SUM(nvl(T.LIST_PRICE, 0) * nvl(T.LIST_QTY, 0)) LIST_Value, count(distinct(T.ITEM_ID)) LIST_NOI FROM EBAY_LIST_MT T WHERE upper(T.ENTRY_TYPE) = upper('l') GROUP BY T.LZ_MANIFEST_ID, T.ITEM_ID, T.Ebay_Item_Id) List_Items, (SELECT T.LZ_MANIFEST_ID, T.Item_Id, SUM(nvl(T.Salvage_Qty, 0)) Salvage_QTY, count(distinct(T.ITEM_ID)) Salvage_LIST_NOI FROM EBAY_LIST_MT T WHERE upper(T.ENTRY_TYPE) = upper('s') GROUP BY T.LZ_MANIFEST_ID, T.ITEM_ID) Salvage_Items, (select eb.lz_manifest_id, dd.item_id, sum(pd.qty) sale_qty, sum(pd.qty * (dd.line_amount / dd.primary_qty)) sale_amt, sum(sd.ebay_fee_perc) Ebay_FEE, sum(sd.shipping_charges) SHIP_FEE, sum(sd.paypal_per_trans_fee) PAYPAL_FEE, sum(pd.qty * (dd.cost_of_sale / dd.primary_qty)) dc_amt from lz_sales_pulling      pm, lz_pull_manifest_bind pd, ebay_list_mt          eb, lz_salesload_mt       sm, lz_salesload_det      sd, dc_mt                 dm, dc_detail             dd where pm.pulling_id = pd.pulling_id and eb.list_id = pd.list_id and sm.lz_saleload_id = sd.lz_saleload_id and pm.sales_record_no = sd.sales_record_number and dm.dc_id = dd.dc_id and sd.gnrtd_dc_id = dm.dc_id and eb.entry_type = 'L'group by eb.lz_manifest_id, dd.item_id) sale_qry, items_mt i, lz_manifest_mt lm Where purchase_items.LZ_MANIFEST_ID = List_Items.LZ_MANIFEST_ID(+) AND purchase_items.Item_Id = List_Items.Item_Id(+) AND purchase_items.Item_Id = i.item_id and purchase_items.LZ_MANIFEST_ID = lm.lz_manifest_id AND purchase_items.LZ_MANIFEST_ID = Salvage_Items.LZ_MANIFEST_ID(+) AND purchase_items.Item_Id = Salvage_Items.Item_Id(+) AND purchase_items.LZ_MANIFEST_ID = sale_qry.LZ_MANIFEST_ID(+) AND purchase_items.Item_Id = sale_qry.Item_Id(+) AND lm.loading_date between TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')) qry ) sum_qry ");
				// print_r($query);exit;
			}


	
	$summary_data = $query->result_array();

	$total_main = "select  sum(sum_qry.Purchase_Value) total_purch_amt, sum(sum_qry.sale_amt) total_sale_amt, sum(sum_qry.Listing_cost) Total_Listing_cost from (select qry.LZ_MANIFEST_ID, qry.ITEM_ID, qry.Purchase_QTY, qry.Purchase_Value, qry.cost_rate, qry.LIST_QTY, (qry.cost_rate*qry.LIST_QTY) Listing_cost, qry.List_Value, qry.sale_qty, qry.sale_amt, qry.Salvage_QTY, qry.Salvage_value from (select purchase_items.LZ_MANIFEST_ID, purchase_items.Item_Bar_Code, purchase_items.ITEM_MT_MFG_PART_NO, purchase_items.Item_Mt_Upc, lm.loading_no, lm.purch_ref_no, lm.loading_date, purchase_items.ITEM_ID, i.item_desc, purchase_items.Purchase_QTY, purchase_items.Purchase_Value, purchase_items.cost_rate, List_Items.LIST_QTY, List_Items.List_Value, List_Items.Ebay_Item_Id, sale_qry.sale_qty, sale_qry.sale_amt, sale_qry.ebay_fee EBAY_FEE, sale_qry.ship_fee SHIP_FEE, sale_qry.paypal_fee PAYPAL_FEE, nvl(sale_qry.dc_amt, 0) + (nvl(sale_qry.ebay_fee, 0) + nvl(sale_qry.ship_fee, 0) + nvl(sale_qry.paypal_fee, 0)) cosg, sale_qry.sale_amt - (nvl(sale_qry.dc_amt, 0) + (nvl(sale_qry.ebay_fee, 0) + nvl(sale_qry.ship_fee, 0) + nvl(sale_qry.paypal_fee, 0))) PL, round(decode(sale_qry.sale_amt, 0, 0, round(((sale_qry.sale_amt - (nvl(sale_qry.dc_amt, 0) + (nvl(sale_qry.ebay_fee, 0) + nvl(sale_qry.ship_fee, 0) + nvl(sale_qry.paypal_fee, 0)))) / sale_qry.sale_amt * 100))), 2) GP, Salvage_Items.Salvage_QTY, purchase_items.cost_rate * Salvage_Items.Salvage_QTY Salvage_value, i.item_code From (SELECT LM.LZ_MANIFEST_ID, IM.ITEM_ID, IM.Item_Bar_Code, IM.ITEM_MT_MFG_PART_NO, IM.Item_Mt_Upc, SUM(NVL(LD.AVAILABLE_QTY, 0)) Purchase_QTY, COUNT(DISTINCT IM.ITEM_ID) Purchase_NOI, (sum(LD.PO_DETAIL_RETIAL_PRICE * NVL(LD.AVAILABLE_QTY, 0))) Purchase_Value, sum(LD.PO_DETAIL_RETIAL_PRICE * NVL(LD.AVAILABLE_QTY, 0)) / SUM(NVL(LD.AVAILABLE_QTY, 0)) cost_rate FROM LZ_MANIFEST_MT  LM, LZ_MANIFEST_DET LD, ITEMS_MT        IM WHERE LM.LZ_MANIFEST_ID = LD.LZ_MANIFEST_ID AND IM.ITEM_CODE = LD.LAPTOP_ITEM_CODE AND LM.excel_file_name <> 'FORM ENTRY'group by LM.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, IM.Item_Bar_Code, IM.ITEM_MT_MFG_PART_NO, IM.Item_Mt_Upc, IM.ITEM_ID) purchase_items, (SELECT T.LZ_MANIFEST_ID, T.Item_Id, T.Ebay_Item_Id, SUM(nvl(T.LIST_QTY, 0)) LIST_QTY, SUM(nvl(T.LIST_PRICE, 0) * nvl(T.LIST_QTY, 0)) LIST_Value, count(distinct(T.ITEM_ID)) LIST_NOI FROM EBAY_LIST_MT T WHERE upper(T.ENTRY_TYPE) = upper('l') GROUP BY T.LZ_MANIFEST_ID, T.ITEM_ID, T.Ebay_Item_Id) List_Items, (SELECT T.LZ_MANIFEST_ID, T.Item_Id, SUM(nvl(T.Salvage_Qty, 0)) Salvage_QTY, count(distinct(T.ITEM_ID)) Salvage_LIST_NOI FROM EBAY_LIST_MT T WHERE upper(T.ENTRY_TYPE) = upper('s') GROUP BY T.LZ_MANIFEST_ID, T.ITEM_ID) Salvage_Items, (select eb.lz_manifest_id, dd.item_id, sum(pd.qty) sale_qty, sum(pd.qty * (dd.line_amount / dd.primary_qty)) sale_amt, sum(sd.ebay_fee_perc) Ebay_FEE, sum(sd.shipping_charges) SHIP_FEE, sum(sd.paypal_per_trans_fee) PAYPAL_FEE, sum(pd.qty * (dd.cost_of_sale / dd.primary_qty)) dc_amt from lz_sales_pulling      pm, lz_pull_manifest_bind pd, ebay_list_mt          eb, lz_salesload_mt       sm, lz_salesload_det      sd, dc_mt                 dm, dc_detail             dd where pm.pulling_id = pd.pulling_id and eb.list_id = pd.list_id and sm.lz_saleload_id = sd.lz_saleload_id and pm.sales_record_no = sd.sales_record_number and dm.dc_id = dd.dc_id and sd.gnrtd_dc_id = dm.dc_id and eb.entry_type = 'L'group by eb.lz_manifest_id, dd.item_id) sale_qry, items_mt i, lz_manifest_mt lm Where purchase_items.LZ_MANIFEST_ID = List_Items.LZ_MANIFEST_ID(+) AND purchase_items.Item_Id = List_Items.Item_Id(+) AND purchase_items.Item_Id = i.item_id and purchase_items.LZ_MANIFEST_ID = lm.lz_manifest_id AND purchase_items.LZ_MANIFEST_ID = Salvage_Items.LZ_MANIFEST_ID(+) AND purchase_items.Item_Id = Salvage_Items.Item_Id(+) AND purchase_items.LZ_MANIFEST_ID = sale_qry.LZ_MANIFEST_ID(+) AND purchase_items.Item_Id = sale_qry.Item_Id(+) "; 
	//$date_qry2 = "AND lm.loading_date between TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')";
	if(!empty($purchase_no)){
		$this->session->set_userdata('purchase_no', $purchase_no);
		$purchase_num = "AND lm.purch_ref_no = '$purchase_no'";

		}else{
			$purchase_num = "";
		}
		$total_cost_amt = $this->db->query($total_main." ".$purchase_num." ) qry) sum_qry");
		$total_cost_amt = $total_cost_amt->result_array();
		$total_listing_cost = "AND sale_qry.sale_amt is null AND List_Items.Ebay_Item_Id is not null ) qry) sum_qry";
		$total_list_cost = $this->db->query($total_main." ".$purchase_num." ".$total_listing_cost);
		$total_list_cost = $total_list_cost->result_array();

		return array('summary_data'=>$summary_data,'total_cost_amt'=>$total_cost_amt,'total_list_cost'=>$total_list_cost);
		

	}
	public function item_detail($item_id,$manifest_id,$ebay_id){
		$query = $this->db->query("select e.item_id,e.LZ_MANIFEST_ID, e.LISTER_ID, TO_CHAR(e.LIST_DATE, 'DD/MM/YYYY HH24:MI:SS') as LIST_DATE, e.AVAIL_QTY, e.it_barcode, e.Lz_Seller_Acct_Id from view_lz_listing_revised e where e.item_id = $item_id and e.LZ_MANIFEST_ID = $manifest_id"); 
		$detail= $query->result_array();
		$user_query = $this->db->query("select e.employee_id,e.user_name from employee_mt e");
		$user = $user_query->result_array();
		if(!empty($ebay_id))
		{
			$query = $this->db->query("select TO_CHAR(d.sale_date, 'DD-MM-YYYY HH24:MI:SS') as sale_date, TO_CHAR(d.paid_on_date, 'DD-MM-YYYY HH24:MI:SS') as paid_on_date, d.sales_record_number, d.item_title, d.item_id, d.buyer_email, d.user_id, d.quantity, d.sale_price, d.total_price, d.paypal_per_trans_fee, d.ebay_fee_perc from LZ_SALESLOAD_MT m, LZ_SALESLOAD_det d where m.lz_saleload_id = d.lz_saleload_id and (d.orderstatus <> 'Cancelled' or d.orderstatus is null) and d.tracking_number is not null and m.lz_seller_acct_id in (1, 2) and d.item_id = '$ebay_id'order by d.sales_record_number desc "); 
			$sale_data= $query->result_array();
			return array('detail'=>$detail,'user'=>$user,'sale_data'=>$sale_data);
		}else{
			return array('detail'=>$detail,'user'=>$user,'sale_data'=>NULL);
		}

		
	}
}

 ?>
