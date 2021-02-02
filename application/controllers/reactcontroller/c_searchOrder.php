<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require 'vendor/autoload.php';
\EasyPost\EasyPost::setApiKey("EZTKac29498d9013471eac177657f1146b86kY1x5gKV0LLv8KwrFaQiig");

header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
	/**
	* Listing Controller
	*/
class c_searchOrder extends CI_Controller
{
		
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('reactcontroller/m_searchOrder');	    		
	}
	public function getOrderByID(){
		$data = $this->m_searchOrder->getOrderByID();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function changeAddress(){
		$data = $this->m_searchOrder->changeAddress();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function getMerchantAccounts(){
		$data = $this->m_searchOrder->getMerchantAccounts();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function getCancellationsFromEbay(){
		
		$userId  = $this->input->post("userId");
		$accountId = $this->input->post("accountId");
        $this->getCancellations($userId,$accountId);
		
		$data = $this->m_searchOrder->getCancellationsFromEbay();

		echo json_encode($data);
		return json_encode($data);

        
	}
	function getCancellations($userId,$accountId){
 
    //   $data['account_name'] = "dfwonline";
	  $data['cancelCall'] = 1;
	  if(!$accountId){
		 $accountId = 1; 
	  }
      $data['merchant_id'] = $accountId;
      $data['userId'] = $userId;
      $data['cancelCall'] = 1;
	  $this->load->view('ebay/postOrder/02-searchCancellation',$data,true);
		
	}
	public function approveCancellation(){
		$account_id      = $this->input->post("account_id");
		$cancel_id      = $this->input->post("cancel_id");
		$ebay_cancel_id = $this->input->post("ebay_cancel_id");
		$cancel_status  = $this->input->post("cancel_status");
		$userId         = $this->input->post("userId");

		if($cancel_status == 'CANCEL REQUESTED' || $cancel_status == 'APPROVE PENDING'){

		
		$accounts = $this->db->query("SELECT A.SITE_TOKEN FROM LZ_SELLER_ACCTS A WHERE A.LZ_SELLER_ACCT_ID = $account_id")->result_array();

		if($accounts){
			$authToken = $accounts[0]['SITE_TOKEN'];
		}

 // Your ID and token
 //Sandbox TOKEN
		//  $authToken = 'AgAAAA**AQAAAA**aAAAAA**qDMKXQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wFk4GgDpCGpQqdj6x9nY+seQ**PM8DAA**AAMAAA**Fi+1Cl1ohpYjtarq3rBdJFcy6LK5tLWHV8FWSH9cHhl2R4AfuIhdKScDaQPg6gn0xJpX/m97JRKljBkJ1auLXDA5b2ifKJq51gIFzxVmQ0fXvYfT9QIjWHnfKCZRqMg8x264bw3NouspfZJoGivHEn2G/4689m1/PPZ6cPqt1jaZYHY4EU0s61Cr9y1cimTIrttbTh7JXi2fi5lflqSeLKWELDig63uRfPCs+K7I3dFdAph/kw/4S+C8HNbm1IxL7g0KaS6PC8dAaUG/mH0w//bsnLvlqQNYjUChQc+6tufLNGegPUQonGXMTkRi5lCHrTCcEz6m8UPo9yK+cr/ZHbMa5WNzMWrDhwLQaYtQwtCKZfF9R3p6kb4uXd/jB/Bdnh1ZRZ7B7KXEGXi2SbK37/9DikaBGQcWDRoSWfsAYGsNR5ppn0/zMbq+v1EzgjAthoRKQ0Q2Bfsmh/ATOTY/HiKX/qIVq21PkebgHFZTEhJZ8whS0XUWtXGsPcvioUmXLMaxcgxZJtUaTHzCfHvMeZ1iRhow/tWgKv0fbukugzpHXDlJaTO4UHJIvt2I6okAs+RDFUGWrRMYi95FqDpAbkytCHaFR2tHbBKnCW6l8viyoX8Vicko53XShZhw0YRF7OJ3siWtJwd1BYWwYUq0inYgQJCRhjCYqvAOqyYhGYERYbMH60BihDMf9RHxyQnbKSwB5ph6iZWuWoBLHXgwNqg6QGm0vrGLDEQL8O4ygNxNOPbC2uWzIUz6fu3Ofev5';
		//Actual TOKEN
        //  $authToken = 'AgAAAA**AQAAAA**aAAAAA**W5TIWw**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AEmIKpDZeEpASdj6x9nY+seQ**u0gDAA**AAMAAA**TovLVkaNq2ICV7DWJ/AJInFnLVvQ1zmPriJtUSO2fLeG4rAYFrA+1W4GIjCubxvpo0WFxkpX7IDv62iEN61gs12nr7LKSahCFj3X2IS8jnibLC+IOLBf8XNfIwX04X09kWgz3rq0vXqXwqpCGhXsABbpnM+bCsLQpn6F1L9hHUNirVfap9q9id+FiUEReUZwlhTQf7GiqNNYkrOFLoW1Au+h+j9NslWhADDkICkc85Lz8Hb34ZqLTzqEDoNPbPvLI0aL1XvBcb3QQmE55Lf3gpJrEBqm2cMBnZp23YhDo8kqZC3H22us68xZ+23opdP++KBrOe3/lYqfGoFyT9Xi+zK5m8oV+dSc4PSw7qLULRC5pPDmLDh0LMqyDchmeiVjTY6WrGfLNKh+97BT7NUw3XUJieCXfoydHLMjs2eUh7wPOdqmBtaDjRMseBLja3QSVHm9AEmQroX3sE/B8ZMdC1n+u1YgCY+bA22Vg0DgMD4L5stnLnVdmQGqvOQ+Fwb+E6/xDc8CXpRcINWxE2kDYBtYifHL+9HgnbHt47uFx7p3V9SZMMJYYATqcJUIjFFG7NI6OovhA3MYmwgNqTd9p847JH2ZCIAULnztUJHs8QkLqItnphqw4MnumH35R6n5Zbo8N7ayhoyucD4asLoM9F6+zyHSJkIGWxstZrZU5nndbS9JtcUq4Acwsv9T9C4isfMDO19cioSdAbf5eFj7RxXYRKa4EI+Nuq0Ffl/rTSwbCQ0ZI3rXNabGQHglvRhr';

         // The data to send to the API
         $post_data = "";//json_encode(array("cancelId"=>"5142891333"));
        //  $url = 'https://api.sandbox.ebay.com/post-order/v2/cancellation/5142891333/approve'; 
         $url = 'https://api.ebay.com/post-order/v2/cancellation/'.$ebay_cancel_id.'/approve'; 
         //Setup cURL
         $header = array(
                        'Accept: application/json',
                        'Authorization: TOKEN '.$authToken,
                        'Content-Type: application/json',
                        'X-EBAY-C-MARKETPLACE-ID: EBAY-US'
                         );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        if(curl_errno($ch)){
            echo "ERROR:".curl_error($ch);
        }
		curl_close($ch); 
		$data['responseAPI'] = $response;
	}
		$data = $this->m_searchOrder->processCancel();

		echo json_encode($data);
		return json_encode($data);
		
	}
	public function CallEasyPostApi()
	{
		$fromAccount = $this->input->post('fromAccount');
		$fromAccount = trim(str_replace("  ", ' ', $fromAccount));
		$fromAccount = trim(str_replace(array("'"), "''", $fromAccount));

		$fromStreet1 = $this->input->post('fromStreet1');
		$fromStreet1 = trim(str_replace("  ", ' ', $fromStreet1));
		$fromStreet1 = trim(str_replace(array("'"), "''", $fromStreet1));

		$fromStreet2 = $this->input->post('fromStreet2');
		$fromStreet2 = trim(str_replace("  ", ' ', $fromStreet2));
		$fromStreet2 = trim(str_replace(array("'"), "''", $fromStreet2));
		
		$fromCity = $this->input->post('fromCity');
		$fromCity = trim(str_replace("  ", ' ', $fromCity));
		$fromCity = trim(str_replace(array("'"), "''", $fromCity));
		
		$fromState = $this->input->post('fromState');
		$fromState = trim(str_replace("  ", ' ', $fromState));
		$fromState = trim(str_replace(array("'"), "''", $fromState));
		
		$fromZip = $this->input->post('fromZip');
		$fromZip = trim(str_replace("  ", ' ', $fromZip));
		$fromZip = trim(str_replace(array("'"), "''", $fromZip));
		
		$fromPhone = $this->input->post('fromPhone');
		$fromPhone = trim(str_replace("  ", ' ', $fromPhone));
		$fromPhone = trim(str_replace(array("'"), "''", $fromPhone));
		
		$toName = $this->input->post('toName');
		$toName = trim(str_replace("  ", ' ', $toName));
		$toName = trim(str_replace(array("'"), "''", $toName));
		
		$toCompany = $this->input->post('toCompany');
		$toCompany = trim(str_replace("  ", ' ', $toCompany));
		$toCompany = trim(str_replace(array("'"), "''", $toCompany));
		
		$toStreet1 = $this->input->post('toStreet1');
		$toStreet1 = trim(str_replace("  ", ' ', $toStreet1));
		$toStreet1 = trim(str_replace(array("'"), "''", $toStreet1));
		
		$toCity = $this->input->post('toCity');
		$toCity = trim(str_replace("  ", ' ', $toCity));
		$toCity = trim(str_replace(array("'"), "''", $toCity));
		
		$toState = $this->input->post('toState');
		$toState = trim(str_replace("  ", ' ', $toState));
		$toState = trim(str_replace(array("'"), "''", $toState));
	
		$toZip = $this->input->post('toZip');
		$toZip = trim(str_replace("  ", ' ', $toZip));
		$toZip = trim(str_replace(array("'"), "''", $toZip));

		$parcelWeight = $this->input->post('parcelWeight');
		$parcelWeight = trim(str_replace("  ", ' ', $parcelWeight));
		$parcelWeight = trim(str_replace(array("'"), "''", $parcelWeight));
 
		$parcelLength = $this->input->post('parcelLength');
		$parcelLength = trim(str_replace("  ", ' ', $parcelLength));
		$parcelLength = trim(str_replace(array("'"), "''", $parcelLength));
 
		$parcelWidth = $this->input->post('parcelWidth');
		$parcelWidth = trim(str_replace("  ", ' ', $parcelWidth));
		$parcelWidth = trim(str_replace(array("'"), "''", $parcelWidth));
 
		$parcelHeight = $this->input->post('parcelHeight');
		$parcelHeight = trim(str_replace("  ", ' ', $parcelHeight));
		$parcelHeight = trim(str_replace(array("'"), "''", $parcelHeight));

		$sale_record_no = $this->input->post('sale_record_no');
		$lz_salesload_det_id = $this->input->post('lz_salesload_det_id');

		$from_address = \EasyPost\Address::create(array(
			'company' => $fromAccount,
			'street1' => $fromStreet1,
			'street2' => $fromStreet2,
			'city' => $fromCity,
			'state' => $fromState,
			'zip' => $fromZip,
			'phone' => $fromPhone
		));

		$to_address = \EasyPost\Address::create(array(
			'name' => $toName,
			'company' => $toCompany,
			'street1' => $toStreet1,
			'city' => $toCity,
			'state' => $toState,
			'zip' => $toZip
		));

		$parcel = \EasyPost\Parcel::create(array(
			"length" => $parcelLength,
			"width" => $parcelWidth,
			"height" => $parcelHeight,
			"weight" => $parcelWeight
		));


$shipment = \EasyPost\Shipment::create(
    array(
        "to_address"   => $to_address,
        "from_address" => $from_address,
        "parcel"       => $parcel
    )
);
		$arrayData = array();
		$i = 0;
		foreach ($shipment->rates as $rate) {
			$arrayData[$i] = array(
				"carrier" => $rate->carrier,
				"service" => $rate->service,
				"rate" => $rate->rate,
				"id" => $rate->id
			);
			$i++;
		}
				echo json_encode($arrayData);
				return json_encode($arrayData);
		
	}
	public function buyShipmentLabel(){
		$fromAccount = $this->input->post('fromAccount');
		$fromAccount = trim(str_replace("  ", ' ', $fromAccount));
		$fromAccount = trim(str_replace(array("'"), "''", $fromAccount));

		$fromStreet1 = $this->input->post('fromStreet1');
		$fromStreet1 = trim(str_replace("  ", ' ', $fromStreet1));
		$fromStreet1 = trim(str_replace(array("'"), "''", $fromStreet1));

		$fromStreet2 = $this->input->post('fromStreet2');
		$fromStreet2 = trim(str_replace("  ", ' ', $fromStreet2));
		$fromStreet2 = trim(str_replace(array("'"), "''", $fromStreet2));
		
		$fromCity = $this->input->post('fromCity');
		$fromCity = trim(str_replace("  ", ' ', $fromCity));
		$fromCity = trim(str_replace(array("'"), "''", $fromCity));
		
		$fromState = $this->input->post('fromState');
		$fromState = trim(str_replace("  ", ' ', $fromState));
		$fromState = trim(str_replace(array("'"), "''", $fromState));
		
		$fromZip = $this->input->post('fromZip');
		$fromZip = trim(str_replace("  ", ' ', $fromZip));
		$fromZip = trim(str_replace(array("'"), "''", $fromZip));
		
		$fromPhone = $this->input->post('fromPhone');
		$fromPhone = trim(str_replace("  ", ' ', $fromPhone));
		$fromPhone = trim(str_replace(array("'"), "''", $fromPhone));
		
		$toName = $this->input->post('toName');
		$toName = trim(str_replace("  ", ' ', $toName));
		$toName = trim(str_replace(array("'"), "''", $toName));
		
		$toCompany = $this->input->post('toCompany');
		$toCompany = trim(str_replace("  ", ' ', $toCompany));
		$toCompany = trim(str_replace(array("'"), "''", $toCompany));
		
		$toStreet1 = $this->input->post('toStreet1');
		$toStreet1 = trim(str_replace("  ", ' ', $toStreet1));
		$toStreet1 = trim(str_replace(array("'"), "''", $toStreet1));
		
		$toCity = $this->input->post('toCity');
		$toCity = trim(str_replace("  ", ' ', $toCity));
		$toCity = trim(str_replace(array("'"), "''", $toCity));
		
		$toState = $this->input->post('toState');
		$toState = trim(str_replace("  ", ' ', $toState));
		$toState = trim(str_replace(array("'"), "''", $toState));
	
		$toZip = $this->input->post('toZip');
		$toZip = trim(str_replace("  ", ' ', $toZip));
		$toZip = trim(str_replace(array("'"), "''", $toZip));

		$parcelWeight = $this->input->post('parcelWeight');
		$parcelWeight = trim(str_replace("  ", ' ', $parcelWeight));
		$parcelWeight = trim(str_replace(array("'"), "''", $parcelWeight));
 
		$parcelLength = $this->input->post('parcelLength');
		$parcelLength = trim(str_replace("  ", ' ', $parcelLength));
		$parcelLength = trim(str_replace(array("'"), "''", $parcelLength));
 
		$parcelWidth = $this->input->post('parcelWidth');
		$parcelWidth = trim(str_replace("  ", ' ', $parcelWidth));
		$parcelWidth = trim(str_replace(array("'"), "''", $parcelWidth));
 
		$parcelHeight = $this->input->post('parcelHeight');
		$parcelHeight = trim(str_replace("  ", ' ', $parcelHeight));
		$parcelHeight = trim(str_replace(array("'"), "''", $parcelHeight));

		$sale_record_no = $this->input->post('sale_record_no');
		$lz_salesload_det_id = $this->input->post('lz_salesload_det_id');
		$carrier = $this->input->post('carrier');
		$service = $this->input->post('service');
		$userId  = $this->input->post('userId');

		$fromAddress = \EasyPost\Address::create(array(
			'company' => $fromAccount,
			'street1' => $fromStreet1,
			'street2' => $fromStreet2,
			'city' => $fromCity,
			'state' => $fromState,
			'zip' => $fromZip,
			'phone' => $fromPhone
		));

		$toAddress = \EasyPost\Address::create(array(
			'name' => $toName,
			'company' => $toCompany,
			'street1' => $toStreet1,
			'city' => $toCity,
			'state' => $toState,
			'zip' => $toZip
		));

		$parcel = \EasyPost\Parcel::create(array(
			"length" => $parcelLength,
			"width" => $parcelWidth,
			"height" => $parcelHeight,
			"weight" => $parcelWeight
		));

		$shipment = \EasyPost\Shipment::create(array(
			"to_address" => $toAddress,
			"from_address" => $fromAddress,
			"parcel" => $parcel
		));
		$rateId = "";
		foreach ($shipment->rates as $rate) {
			if( $rate->carrier == $carrier && $rate->service == $service){
				$rateId = $rate->id;
			}
		}

		$shipment->buy(array('rate' => array('id' => $rateId)));
		
		$shippingData = array();
		$j = 0;

		$shippingData[$j] = array(
			"label_url" => $shipment->postage_label->label_url,
			"Tracking_No" => $shipment->tracking_code
		);
		$date = date("m/d/Y");
            date_default_timezone_set("America/Chicago");
            $date = date('Y-m-d H:i:s');
			$insert_date = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

			$tacking_no = $shipment->tracking_code;
			$label_link = $shipment->postage_label->label_url;

		if($tacking_no){
			$update = $this->db->query("UPDATE LZ_SALESLOAD_DET SET TRACKING_NUMBER = '$tacking_no' WHERE SALES_RECORD_NUMBER = '$sale_record_no' AND LZ_SALESLOAD_DET_ID = $lz_salesload_det_id ");

			$tracking_data = $this->db->query("SELECT TM.TRACKING_ID FROM LZ_TRACKING_MT TM WHERE TM.LZ_SALESLOAD_DET_ID = $lz_salesload_det_id AND TM.ORDER_ID = $sale_record_no")->result_array();
			if($tracking_data){

				$tracking_id = $tracking_data[0]['TRACKING_ID'];

				$this->db->query("INSERT INTO LZ_TRACKING_DET TD (TD.TRACKING_DET_ID,
																TD.TRACKING_ID,
																TD.TRACKING_NO,
																TD.LABEL_LINK) 
																VALUES(GET_SINGLE_PRIMARY_KEY('LZ_TRACKING_DET','TRACKING_DET_ID'),
																$tracking_id,
																'$tacking_no',
																'$label_link')");

			}else{
				$tracking_data = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_TRACKING_MT','TRACKING_ID') TRACKING_ID FROM DUAL ")->result_array();
				$tracking_id = $tracking_data[0]['TRACKING_ID'];
	
				$this->db->query("INSERT INTO LZ_TRACKING_MT TM (TM.TRACKING_ID,
																TM.LZ_SALESLOAD_DET_ID,
																TM.ORDER_ID,
																TM.CREATED_DATE,
																TM.CREATED_BY) 
																VALUES($tracking_id,
																$lz_salesload_det_id,
																$sale_record_no,
																$insert_date,
																$userId)");
				$this->db->query("INSERT INTO LZ_TRACKING_DET TD (TD.TRACKING_DET_ID,
																TD.TRACKING_ID,
																TD.TRACKING_NO,
																TD.LABEL_LINK) 
																VALUES(GET_SINGLE_PRIMARY_KEY('LZ_TRACKING_DET','TRACKING_DET_ID'),
																$tracking_id,
																'$tacking_no',
																'$label_link')");
			}
		}
		echo json_encode($shippingData);
		return json_encode($shippingData);

	}
	
}	