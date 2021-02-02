<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');
class m_appoinment extends CI_Model{

public function __construct(){
    parent::__construct();
    $this->load->database();
  }
  public function SendSingleNotification($userid,$title,$message){
    
    $image=null;
    //getting the push from push object
    $mPushNotification = array();
    $mPushNotification['data']['title'] = $title;
    $mPushNotification['data']['message'] = $message;
    $mPushNotification['data']['image'] = $image;

    //getting the token from database object 
    $devicetoken = $this->getSingleToken($userid);
    if(empty($devicetoken))
    {
        return json_encode(array(
            "status" => true, 
            "message" => "Empty Token"
        ));
    }
    //sending push notification and displaying result 
    return $this->send($devicetoken, $mPushNotification);
}
  public function MultipleSubmitPushEmploye($title,$message){
    
    $image=null;
    //getting the push from push object
    $mPushNotification = array();
    $mPushNotification['data']['title'] = $title;
    $mPushNotification['data']['message'] = $message;
    $mPushNotification['data']['image'] = $image;

    //getting the token from database object 
    $devicetoken = $this->getAlEmployeeTokens();
    if(empty($devicetoken))
    {
        return json_encode(array(
            "status" => true, 
            "message" => "Empty Token"
        ));
    }
    //sending push notification and displaying result 
    return $this->send($devicetoken, $mPushNotification);
}
public function MultipleSubmitPushAdmin($title,$message){
   
    $image=null;
    //getting the push from push object
    $mPushNotification = array();
    $mPushNotification['data']['title'] = $title;
    $mPushNotification['data']['message'] = $message;
    $mPushNotification['data']['image'] = $image;

    //getting the token from database object 
    $devicetoken = $this->getAllAdminTokens();
    if(empty($devicetoken))
    {
        return json_encode(array(
            "status" => true, 
            "message" => "Empty Token"
        ));
    }
    //sending push notification and displaying result 
    return $this->send($devicetoken, $mPushNotification);
}

public function send($registration_ids, $message) {
    $fields = array(
        'registration_ids' => $registration_ids,
        'data' => $message,
    );
    return $this->sendPushNotification($fields);
}
private function getSingleTokenByAppointmentID($cellid){
    $result1 = $this->db->query("SELECT LAM.CREATED_BY FROM LJ_APPOINTMENT_MT LAM WHERE LAM.APPOINTMENT_ID = $cellid ")->result_array();
    $userid=$result1[0]["CREATED_BY"];
    
    return $userid; 
}
private function getSingleToken($userid){
    $result = $this->db->query("SELECT NOTIFICATION_TOKEN FROM EMPLOYEE_MT WHERE EMPLOYEE_ID = $userid AND NOTIFICATION_TOKEN IS NOT NULL ")->result_array();
    $tokens = array(); 
    foreach( $result as $token){
        if(!empty($token['NOTIFICATION_TOKEN'])) 
        {
            array_push($tokens, $token['NOTIFICATION_TOKEN']);
        }
    }
    return $tokens; 
}
private function getAllAdminTokens(){
    $result = $this->db->query("SELECT NOTIFICATION_TOKEN FROM EMPLOYEE_MT WHERE ROLE_ID =1 AND NOTIFICATION_TOKEN IS NOT NULL ")->result_array();
    $tokens = array(); 
    foreach( $result as $token){
        if(!empty($token['NOTIFICATION_TOKEN'])) 
        {
            array_push($tokens, $token['NOTIFICATION_TOKEN']);
        }
    }
    return $tokens; 
}
private function getEmployeeInfo($user_id){
    $result = $this->db->query("SELECT M.USER_NAME USERNAME FROM EMPLOYEE_MT M WHERE M.EMPLOYEE_ID=$user_id ")->result_array();
    return $result; 
}
private function getAlEmployeeTokens(){
    $result = $this->db->query("SELECT NOTIFICATION_TOKEN From (SELECT NOTIFICATION_TOKEN,
    CASE
      WHEN (SELECT EMD.MERCHANT_ID
              FROM EMP_MERCHANT_DET EMD
             WHERE EMD.EMPLOYEE_ID = M.EMPLOYEE_ID) IS NULL THEN
       0
      ELSE
       (SELECT EMD.MERCHANT_ID
          FROM EMP_MERCHANT_DET EMD
         WHERE EMD.EMPLOYEE_ID = M.EMPLOYEE_ID)
    END MERCHANT_ID
FROM EMPLOYEE_MT M, EMPLOYEE_ROLE MR
WHERE M.ROLE_ID = MR.ROLE_ID) RES
where RES.MERCHANT_ID =0
AND RES.NOTIFICATION_TOKEN IS NOT NULL ")->result_array();
    $tokens = array(); 
    foreach( $result as $token){
        if(!empty($token['NOTIFICATION_TOKEN'])) 
        {
            array_push($tokens, $token['NOTIFICATION_TOKEN']);
        }
    }
    return $tokens; 
}
/*
* This function will make the actuall curl request to firebase server
* and then the message is sent 
*/
private function sendPushNotification($fields) {
     
    //importing the constant files
    // require_once 'Config.php';
    // define('FIREBASE_API_KEY', 'AIzaSyBrxixnRbQqNhRIjP5zfdfhn9_XXfFVTw8');
    $FIREBASE_API_KEY ='AIzaSyBrxixnRbQqNhRIjP5zfdfhn9_XXfFVTw8';
    //firebase server url to send the curl request
    $url = 'https://fcm.googleapis.com/fcm/send';

    //building headers for the request
    $headers = array(
        'Authorization: key=AIzaSyBrxixnRbQqNhRIjP5zfdfhn9_XXfFVTw8',
        'Content-Type: application/json'
    );

    //Initializing curl to open a connection
    $ch = curl_init();

    //Setting the curl url
    curl_setopt($ch, CURLOPT_URL, $url);
    
    //setting the method as post
    curl_setopt($ch, CURLOPT_POST, true);

    //adding headers 
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //disabling ssl support
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    //adding the fields in json format 
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

    //finally executing the curl request 
    $result = curl_exec($ch);
    if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
    }

    //Now close the connection
    curl_close($ch);

    //and return the result 
    return $result;
}
  public function getSeconds()
  {
    $user_id = (int)$_POST['user_id'];
    $appointment_id = (int)$_POST['appointment_id'];
    $result = $this->db->query("SELECT SUM(TOTAL_SECOND) TOTAL_SECOND
    FROM (SELECT DECODE(DAY, 0, 0, DAY * 86400) +
                 DECODE(HOUR, 0, 0, HOUR * 3600) +
                 DECODE(MINUTE, 0, 0, MINUTE * 60) + SECOND TOTAL_SECOND
            FROM (SELECT EXTRACT(DAY FROM(L.CHECKOUT_TIME - L.CHECKIN_TIME) DAY TO
                                 SECOND) AS DAY,
                         EXTRACT(HOUR FROM(L.CHECKOUT_TIME - L.CHECKIN_TIME) DAY TO
                                 SECOND) AS HOUR,
                         EXTRACT(MINUTE FROM(L.CHECKOUT_TIME - L.CHECKIN_TIME) DAY TO
                                 SECOND) AS MINUTE,
                         EXTRACT(SECOND FROM(L.CHECKOUT_TIME - L.CHECKIN_TIME) DAY TO
                                 SECOND) AS SECOND
                    FROM LJ_APPOINTMENT_LOG_TMP L
                   WHERE L.APPOINTMENT_ID = $appointment_id
                     AND L.EMPLOYEE_ID = $user_id
                     AND L.CHECKIN_TIME IS NOT NULL
                     AND L.CHECKOUT_TIME IS NOT NULL))
  ")->result_array();
  date_default_timezone_set("America/Chicago");
  $current_time = date("m/d/Y H:i:s");
  $resultuncomplete = $this->db->query("SELECT SUM(TOTAL_SECOND) TOTAL_SECOND
  FROM (SELECT DECODE(DAY, 0, 0, DAY * 86400) +
               DECODE(HOUR, 0, 0, HOUR * 3600) +
               DECODE(MINUTE, 0, 0, MINUTE * 60) + SECOND TOTAL_SECOND
          FROM (SELECT EXTRACT(DAY FROM(TO_DATE('$current_time' , 'MM/DD/RRRR HH24:MI:SS') - L.CHECKIN_TIME) DAY TO
                               SECOND) AS DAY,
                       EXTRACT(HOUR FROM(TO_DATE('$current_time' , 'MM/DD/RRRR HH24:MI:SS') - L.CHECKIN_TIME) DAY TO
                               SECOND) AS HOUR,
                       EXTRACT(MINUTE FROM(TO_DATE('$current_time' , 'MM/DD/RRRR HH24:MI:SS') - L.CHECKIN_TIME) DAY TO
                               SECOND) AS MINUTE,
                       EXTRACT(SECOND FROM(TO_DATE('$current_time' , 'MM/DD/RRRR HH24:MI:SS') - L.CHECKIN_TIME) DAY TO
                               SECOND) AS SECOND
                  FROM LJ_APPOINTMENT_LOG_TMP L
                 WHERE L.APPOINTMENT_ID = $appointment_id
                   AND L.EMPLOYEE_ID = $user_id
                   AND L.CHECKIN_TIME IS NOT NULL
                   AND L.CHECKOUT_TIME IS NULL))
")->result_array();
$completedSeconds=0;
$incompletedSeconds=0;
  if($result[0]["TOTAL_SECOND"]!=null)
  {
    $completedSeconds=$result[0]["TOTAL_SECOND"];
  }
  if($resultuncomplete[0]["TOTAL_SECOND"]!=null)
  {
    $incompletedSeconds=$resultuncomplete[0]["TOTAL_SECOND"];
  }
  $totalSeconds=$completedSeconds+$incompletedSeconds;
  return array("status" => true, "total_second" => $totalSeconds,"current_session" => (int)$incompletedSeconds);
  
  }
  public function start_time()
  {
    // date_default_timezone_set('GMT');
    date_default_timezone_set("America/Chicago");
    $user_id = (int)$_POST['user_id'];
    $appointment_id = (int)$_POST["appointment_id"];
    $checkin_time = date("m/d/Y H:i:s");
    $logs = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LJ_APPOINTMENT_LOG_TMP', 'APPOINTMENT_LOG_TMP_ID') LOG_ID FROM DUAL")->result_array();
    $log_id = $logs[0]['LOG_ID'];
    $qr = "INSERT INTO LJ_APPOINTMENT_LOG_TMP (APPOINTMENT_LOG_TMP_ID, APPOINTMENT_ID,EMPLOYEE_ID,CHECKIN_TIME,CHECKOUT_TIME) VALUES
         ($log_id,$appointment_id,$user_id,TO_DATE('$checkin_time', 'MM/DD/RRRR HH24:MI:SS'),null)";
    $result = $this->db->query($qr);
    if($result)
    {
        $username=$this->getEmployeeInfo($user_id);
        $this->MultipleSubmitPushAdmin("Employee Checked In",$username[0]["USERNAME"]." checked in  at ".$checkin_time);
        return array(
            "status" => true, 
            "message" => "Your work time has been started!",
            "checkin_time"=> $checkin_time,
            "log_temp_id"=> $log_id,
            "total_second"=> (int)$this->getSeconds()["total_second"]
        );
    }
    else
    {
        return array(
            "status" => false, 
            "message" => "Something went wrong | Try again"
        );
    }
  }
  public function stop_time()
  {
    // date_default_timezone_set('GMT');
    date_default_timezone_set("America/Chicago");
    $checkout_time = date("m/d/Y H:i:s");
    $user_id = (int)$_POST['user_id'];
    $appointment_id = (int)$_POST["appointment_id"];
    $log_id = (int)$_POST['log_id'];
    $tempT=$this->getSeconds();
    $seconds = (int)$tempT["current_session"] ;
    $hours = floor($seconds / 3600);
    $seconds -= $hours * 3600;
    $minutes = floor($seconds / 60);
    $seconds -= $minutes * 60;
    $qr = "UPDATE LJ_APPOINTMENT_LOG_TMP SET CHECKOUT_TIME = TO_DATE('$checkout_time' , 'MM/DD/RRRR HH24:MI:SS')
            WHERE APPOINTMENT_LOG_TMP_ID = $log_id 
            AND APPOINTMENT_ID = $appointment_id
            AND EMPLOYEE_ID = $user_id ";
    $result = $this->db->query($qr);
    if($result)
    {
        $username=$this->getEmployeeInfo($user_id);
        $this->MultipleSubmitPushAdmin("Employee Checked Out",$username[0]["USERNAME"]." checked out  at $checkout_time. He worked for $hours hours $minutes minutes in this session.");
        return array(
            "status" => true, 
            "message" => "Your work time has been stopped!",
            "checkout_time"=> $checkout_time,
            "log_temp_id"=> $log_id,
            "total_second"=> (int)$this->getSeconds()["total_second"]
        );
    }
    else
    {
        return array(
            "status" => false, 
            "message" => "Something went wrong | Try again"
        );
    }
  }
  public function remove_token()
  {
    // date_default_timezone_set('GMT');
    $user_id = (int)$_POST['user_id'];
    $qr = "UPDATE EMPLOYEE_MT
    SET NOTIFICATION_TOKEN = ''
    WHERE EMPLOYEE_MT.EMPLOYEE_ID = $user_id ";
    $result = $this->db->query($qr);
    if($result)
    {
        return array(
            "status" => true, 
            "message" => "Token Removed For Notifications!"
        );
    }
    else
    {
        return array(
            "status" => false, 
            "message" => "Token cannot be removed!"
        );
    }
  }
  public function save_token()
  {
    // date_default_timezone_set('GMT');
    $user_id = (int)$_POST['user_id'];
    $token = $_POST["token"];
    $qr = "UPDATE EMPLOYEE_MT
    SET NOTIFICATION_TOKEN = '$token'
    WHERE EMPLOYEE_MT.EMPLOYEE_ID = $user_id ";
    $result = $this->db->query($qr);
    if($result)
    {
        return array(
            "status" => true, 
            "message" => "Token Saved For Notifications!"
        );
    }
    else
    {
        return array(
            "status" => false, 
            "message" => "Token cannot be saved"
        );
    }
  }
  public function Reset_Appointment_Packing()
  {
      $appointment_log_id = $this->input->post('appointment_log_id');
      $appointment_id = $this->input->post('appointment_id');//used for summary
      
          $deletePacking = "DELETE FROM lj_appointment_packing_mt WHERE APPOINTMENT_LOG_ID = '$appointment_log_id' ";
          $result = $this->db->query($deletePacking);
          $temp2=$this->Get_Summary_Appointment();
          return array('status' => true, "message" => "Packing Deleted SuccessFully","summaryDataTotalCharge"=>$temp2["total_charge"],"summaryDataPackingCost"=>$temp2["packing_cost"]);
    }
    public function Delete_Single_Packing()
  {
    $appointment_id = $this->input->post('appointment_id');//used for summary
      $appointment_log_id = $this->input->post('appointment_log_id');
      $packing_id = $this->input->post('packing_id');
          $deletePacking = "DELETE FROM lj_appointment_packing_mt WHERE APPOINTMENT_LOG_ID = '$appointment_log_id' AND PACKING_ID = '$packing_id' ";
          $result = $this->db->query($deletePacking);
          $temp2=$this->Get_Summary_Appointment();
          return array('status' => true, "message" => "Packing Deleted SuccessFully","summaryDataTotalCharge"=>$temp2["total_charge"],"summaryDataPackingCost"=>$temp2["packing_cost"]);
    }
  public function Save_Appointment_Packing()
    {
        $appointment_id = $this->input->post('appointment_id');
        $appointment_log_id = $this->input->post('appointment_log_id');
        $appointment_dt_id = $this->input->post('appointment_dt_id');
        // $service_id = $this->input->post('service_id');
        $packing_id = $this->input->post('packing_id');
        $user_id = $this->input->post('user_id');

        if (is_null($packing_id)) {
            $deletePacking = "DELETE FROM lj_appointment_packing_mt WHERE APPOINTMENT_LOG_ID = '$appointment_log_id'";
            $result = $this->db->query($deletePacking);
            // $result = $this->Get_Packing_Detail_Appointment_using_appointment_log($appointment_log_id);
            // return array('status' => true, "message" => "Packing Deleted SuccessFully", 'data' => $result['data']);
            return array('status' => true, "message" => "Packing Deleted SuccessFully");
        }

        $deletePacking = "DELETE FROM lj_appointment_packing_mt WHERE APPOINTMENT_LOG_ID = '$appointment_log_id'";
        $result = $this->db->query($deletePacking);
        $packing_idarray = json_decode($packing_id,true);
        if (count($packing_idarray) > 0) {
            foreach ($packing_idarray as $id) {
                $packing_id = $id['value'];
                $qry = "INSERT INTO lj_appointment_packing_mt (APPOINTMENT_PACKING_ID, APPOINTMENT_LOG_ID, PACKING_ID, INSERTED_BY, INSERTED_DATE) VALUES (GET_SINGLE_PRIMARY_KEY('lj_appointment_packing_mt ', 'APPOINTMENT_PACKING_ID'), '$appointment_log_id','$packing_id', '$user_id', sysdate)";
                $result = $this->db->query($qry);
            }
        }
        // $result = $this->Get_Packing_Detail_Appointment_using_appointment_log($appointment_log_id);
        //$updatedTime = $this->Get_Summary_Appointment_After_Insert_Delete($appointment_id, $appointment_dt_id);
        $temp2=$this->Get_Summary_Appointment();
        return array('status' => true, "message" => "Record Updated","summaryDataTotalCharge"=>$temp2["total_charge"],"summaryDataPackingCost"=>$temp2["packing_cost"]);
        //return array('status' => true, "message" => "Record Updated", "summary" => $updatedTime['data'], "update_time" => $updatedTime['time'], "total_charge" => $updatedTime['total_charge'], 'packing_cost' => $updatedTime['packing_cost']);
    }
  public function get_Packing_Type_And_Detail()
    {
        $qr = "SELECT * FROM lz_packing_type_mt";
        $data = $this->db->query($qr);
        $barcode = $this->input->post('barcode');
        $appointment_id = $this->input->post('appointment_id');
        $result = $this->Get_Packing_Detail_Appointment($barcode,$appointment_id);
        if ($data->num_rows() > 0) {
            $result = array("status" => true,"data_detail" => $result["data"], "data" => $data->result_array());
        } else {
            $result = array("status" => false,"data_detail" => $result["data"], "data" =>  $data->result_array());

        }
        return $result;
    }
  public function get_Packing_Type()
    {
        $qr = "SELECT * FROM lz_packing_type_mt";
        $data = $this->db->query($qr);
        if ($data->num_rows() > 0) {
            $result = array("status" => true, "data" => $data->result_array());
        } else {
            $result = array("status" => false, "data" => "No record in DB");

        }
        return $result;
    }
    public function Get_Packing_Detail_Appointment($barcode,$appointment_id)
    {
        $qry = "select
        sd.service_desc,
        D.service_id,
        l.APPOINTMENT_LOG_ID,
        D.APPOINTMENT_DT_ID,
        m.APPOINTMENT_ID,
        l.barcode_no,
        lp.packing_id,
        lpm.packing_name,
        lpm.packing_type,
        lpm.packing_length,
        lpm.packing_width,
        lpm.packing_heigth
        from lj_appointment_mt m,
        lj_appointment_dt D,
        lj_services sd,
        lj_appointment_log l,
        lj_appointment_packing_mt lp,
        lz_packing_type_mt lpm,
        EMPLOYEE_MT EM
        where d.appointment_id = '$appointment_id'
        AND m.APPOINTMENT_ID = D.appointment_id
        and d.appointment_dt_id = l.appointment_dt_id
        AND D.service_id = sd.service_id
        AND lp.appointment_log_id = l.appointment_log_id
       AND lp.packing_id = lpm.packing_id
        AND l.BARCODE_NO IS NOT NULL
        AND l.BARCODE_NO='$barcode'
        AND EM.EMPLOYEE_ID = m.created_by ORDER BY l.barcode_no ASC";

        $result = $this->db->query($qry);
        if ($result->num_rows() > 0) {
            return array("status" => true, "data" => $result->result_array());
        } else {
            return array("status" => false, "data" => array());
        }
    }
  public function get_AllLogDetail()
  {
    date_default_timezone_set('GMT');
    $appointment_id = $_POST['appointment_id'];
    $user_id = $_POST['user_id'];
    $data["servicesData"]=$this->get_Specific_Services($appointment_id)["servicesData"];
    $temp2=$this->Get_Summary_Appointment();
    if($temp2["packing_cost"]==null)
    {
        $temp2["packing_cost"]=0;
    }
    $data["summaryData"]=$temp2["data"];
    $tempT=$this->getSeconds();
    $data["summaryDataTime"]=$tempT["total_second"];
    $data["summaryDataTimeCurrent"]=$tempT["current_session"];
    $data["summaryDataTotalCharge"]=$temp2["total_charge"];
    $data["summaryDataPackingCost"]=$temp2["packing_cost"];
    $data["logData"]=$this->get_Specific_Log_Detail()["data"];
    $data["currentTime"] = date("d/m/Y H:i:s");
    return $data;
  }
  public function in_Process_Appointment()
    {
        $start_barcode = $_POST["start_barcode"];
        $end_barcode = $_POST["end_barcode"];
        $user_id = $_POST['user_id'];
        $service_id = $_POST['service_id'];
        $remarks = $_POST['remarks'];
        $appointment_id = $_POST["appointment_id"];
        $label = $_POST["label"];
        $merchant_id =$_POST["merchant_id"];

        $qr = "SELECT APPOINTMENT_DT_ID FROM lj_appointment_dt WHERE SERVICE_ID = '$service_id' AND APPOINTMENT_ID = '$appointment_id'";
        $result = $this->db->query($qr)->result_array();
        $appointment_dt_id = $result[0]['APPOINTMENT_DT_ID'];
        $update = $this->add_Lot_Barcode_Detail($label, $service_id, $start_barcode, $end_barcode, $appointment_dt_id, $user_id, $remarks, $merchant_id);

        if (count($update['barcode']) > 0) {
            if ($update['update'] == true) {

                $qr = "UPDATE lj_appointment_mt SET APPOINTMENT_STATUS = 2 WHERE APPOINTMENT_ID = '$appointment_id'";
                $result = $this->db->query($qr);
                if ($result == true) {
                    $latestData = $this->get_Log_After_Add_Barcode_Appointment($appointment_id, $start_barcode, $end_barcode, $update['barcode']);
                    $updatedTime = $this->Get_Summary_Appointment_After_Insert_Delete($appointment_id, $appointment_dt_id);

                    if ($latestData == true) {
                        return array("status" => true, "message" => "Record Update", "data" => $latestData['data'], "summary" => $updatedTime['data'], "update_total" => count($update['barcode']), "update_time" => $updatedTime['time'], "total_charge" => $updatedTime['total_charge']);

                    } else {
                        return array("status" => false, "message" => "Record Update", "data" => $latestData['data'], "summary" => $updatedTime['data'], "update_total" => count($update['barcode']), "update_time" => $updatedTime['time'], "total_charge" => $updatedTime['total_charge']);
                    }
                } else {
                    return array("status" => false, "message" => "Record is not update mt");
                }
            } else {
                return array("status" => false, "message" => "Barcode already consumed");
            }
        } else {
            return array("status" => false, "message" => "Barcode already consumed and Barcode not for this merchant");
        }

    } 
    public function delete_Log_Appointment_Services()
    {
        $service_id = $this->input->post("service_id");
        $barcode_no = $this->input->post("barcode_no");
        $appointment_dt_id = $this->input->post("appointment_dt_id");
        $appointment_log_id = $this->input->post("appointment_log_id");
        $appointment_id = $this->input->post("appointment_id");

        $qry = "SELECT * FROM lj_appointment_log WHERE APPOINTMENT_LOG_ID = '$appointment_log_id'";
        $res = $this->db->query($qry);
        if ($res->num_rows() > 0) {
            $qr = "UPDATE  lz_merchant_barcode_dt SET APPOINTMENT_LOG_ID = null WHERE  BARCODE_NO = '$barcode_no'";
            $delAppointmentpacking = "DELETE FROM lj_appointment_packing_mt WHERE APPOINTMENT_LOG_ID = '$appointment_log_id' ";
            $del = "DELETE FROM lj_appointment_log WHERE APPOINTMENT_LOG_ID = '$appointment_log_id'";
        }
        $result = $this->db->query($qr);
        $delappointpacking = $this->db->query($delAppointmentpacking);
        $delete = $this->db->query($del);
        $updatedTime = $this->Get_Summary_Appointment_After_Insert_Delete($appointment_id, $appointment_dt_id);
        if ($result == true && $delete == true) {
            $qr = "SELECT * FROM lj_appointment_log WHERE APPOINTMENT_DT_ID ='$appointment_dt_id' AND barcode_no is not null";
            $result = $this->db->query($qr);
            if ($result->num_rows() > 0) {
                return array("status" => true, "message" => "Barcode Delete Successfuly", "summary" => $updatedTime['data'], "update_time" => $updatedTime['time'], "total_charge" => $updatedTime['total_charge'], 'packing_cost' => $updatedTime['packing_cost']);
            } else {
                $appointment_mt = "UPDATE lj_appointment_mt SET APPOINTMENT_STATUS = '1'  WHERE APPOINTMENT_ID = '$appointment_id'";
                $res = $this->db->query($appointment_mt);
                if ($res == true) {
                    return array("status" => true, "message" => "Barcode Delete Successfuly", 'appointmentstatus' => 'Approved', "summary" => $updatedTime['data'], "update_time" => $updatedTime['time'], "total_charge" => $updatedTime['total_charge'], 'packing_cost' => $updatedTime['packing_cost']);
                } else {
                    return array("status" => false, "message" => "Status Not Update");
                }
            }

        } else {
            return array("status" => false, "message" => "Record Not Found");
        }

    }
    public function check_Log_Barcode_Exist($label, $service_id, $start_barcode, $end_barcode, $appointment_dt_id, $merchant_id)
    {
        if ($start_barcode != '' && $end_barcode != '') {

            $qr = "SELECT * from lz_merchant_barcode_dt d, lz_merchant_barcode_mt m WHERE m.mt_id = d.mt_id AND m.POS_STATUS != 1 AND m.merchant_id = '$merchant_id' AND d.appointment_log_id IS NULL AND d.barcode_no BETWEEN '$start_barcode' AND '$end_barcode'";
            $existBarcode = $this->db->query($qr);
            if ($existBarcode->num_rows() > 0) {
                return array("status" => true, 'DT_ID' => $existBarcode->result_array());
            } else {
                return array("status" => false);
            }
            // if ($label == "Inventory prep" || $label == "Inventory Prop" || $service_id == 3) {
            //      $qr = "SELECT * from lz_merchant_barcode_dt d, lz_merchant_barcode_mt m WHERE m.mt_id = d.mt_id AND m.merchant_id = '$merchant_id' AND d.appointment_log_id IS NULL AND d.barcode_no BETWEEN '$start_barcode' AND '$end_barcode'";
            //     $existBarcode = $this->db->query($qr);
            //     if ($existBarcode->num_rows() > 0) {
            //         return array("status" => true, 'DT_ID' => $existBarcode->result_array());
            //     } else {
            //         return array("status" => false);
            //     }
            // }
            // if ($label == "Picture" || $label == "picture" || $service_id == 1) {

            //    $qr = "SELECT * from lz_merchant_barcode_dt d, lz_merchant_barcode_mt m WHERE m.mt_id = d.mt_id AND m.merchant_id = '$merchant_id' AND d.appointment_log_id IS NULL AND d.barcode_no BETWEEN '$start_barcode' AND '$end_barcode'";
            //     $existBarcode = $this->db->query($qr);
            //     if ($existBarcode->num_rows() > 0) {
            //         return array("status" => true, 'DT_ID' => $existBarcode->result_array());
            //     } else {
            //         return array("status" => false);
            //     }
            // }
        } else {
            return array("status" => false);
        }

    }
    public function add_Lot_Barcode_Detail($label, $service_id, $start_barcode, $end_barcode, $appointment_dt_id, $user_id, $remarks, $merchant_id)
    {
        $barcodeExist = $this->check_Log_Barcode_Exist($label, $service_id, $start_barcode, $end_barcode, $appointment_dt_id, $merchant_id);
        if ($barcodeExist["status"] == true) {
            $countDiff = $end_barcode - $start_barcode;
            if ($label == "Inventory prep" || $label == "Inventory Prop" || $service_id == 3) {
                if ($countDiff > 0) {
                    for ($i = 0; $i <= $countDiff; $i++) {

                        $appointment_log_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('lj_appointment_log ', 'APPOINTMENT_LOG_ID')ID FROM DUAL")->result_array();
                        $appointment_log_id = $appointment_log_id[0]['ID'];
                        $updateBarcode = "INSERT INTO lj_appointment_log (APPOINTMENT_LOG_ID, APPOINTMENT_DT_ID, START_TIME, STOP_TIME, REMARKS, USER_ID, BARCODE_NO) VALUES ('$appointment_log_id' ,'$appointment_dt_id', null, null,'$remarks', '$user_id', '$start_barcode' )";
                        $updateMerchantBarcode = "UPDATE lz_merchant_barcode_dt SET APPOINTMENT_LOG_ID = '$appointment_log_id' WHERE BARCODE_NO = '$start_barcode'";
                        $start_barcode = $start_barcode + 1;
                        $update = $this->db->query($updateBarcode);
                        $updateMerchant = $this->db->query($updateMerchantBarcode);
                    }
                    return array("update" => $update, "barcode" => $barcodeExist['DT_ID']);
                } else if ($countDiff == 0) {
                    $appointment_log_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('lj_appointment_log ', 'APPOINTMENT_LOG_ID')ID FROM DUAL")->result_array();
                    $appointment_log_id = $appointment_log_id[0]['ID'];
                    $updateBarcode = "INSERT INTO lj_appointment_log (APPOINTMENT_LOG_ID, APPOINTMENT_DT_ID, START_TIME, STOP_TIME, REMARKS, USER_ID, BARCODE_NO) VALUES ('$appointment_log_id' ,'$appointment_dt_id', null, null,'$remarks', '$user_id', '$start_barcode' )";
                    $updateMerchantBarcode = "UPDATE lz_merchant_barcode_dt SET APPOINTMENT_LOG_ID = '$appointment_log_id' WHERE BARCODE_NO = '$start_barcode'";
                    $update = $this->db->query($updateBarcode);
                    $updateMerchant = $this->db->query($updateMerchantBarcode);
                    return array("update" => $update, "barcode" => $barcodeExist['DT_ID']);
                    // var_dump($start_barcode);
                } else if ($countDiff < 0) {
                    for ($i = $countDiff; $i < 0; $i++) {
                        $appointment_log_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('lj_appointment_log ', 'APPOINTMENT_LOG_ID')ID FROM DUAL")->result_array();
                        $appointment_log_id = $appointment_log_id[0]['ID'];
                        $updateBarcode = "INSERT INTO lj_appointment_log (APPOINTMENT_LOG_ID, APPOINTMENT_DT_ID, START_TIME, STOP_TIME, REMARKS, USER_ID, BARCODE_NO) VALUES ('$appointment_log_id' ,'$appointment_dt_id', null, null,'$remarks', '$user_id', '$start_barcode' )";
                        $updateMerchantBarcode = "UPDATE lz_merchant_barcode_dt SET APPOINTMENT_LOG_ID = '$appointment_log_id' WHERE BARCODE_NO = '$start_barcode'";
                        $start_barcode = $start_barcode - 1;
                        // var_dump($start_barcode);
                        $update = $this->db->query($updateBarcode);
                        $updateMerchant = $this->db->query($updateMerchantBarcode);
                    }
                    return array("update" => $update, "barcode" => $barcodeExist['DT_ID']);
                }
            } else if ($label == "Picture" || $label == "picture" || $service_id == 1) {
                $countDiff = $end_barcode - $start_barcode;
                if ($countDiff > 0) {
                    for ($i = 0; $i <= $countDiff; $i++) {
                        $appointment_log_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('lj_appointment_log ', 'APPOINTMENT_LOG_ID')ID FROM DUAL")->result_array();
                        $appointment_log_id = $appointment_log_id[0]['ID'];
                        $updateBarcode = "INSERT INTO lj_appointment_log (APPOINTMENT_LOG_ID, APPOINTMENT_DT_ID, START_TIME, STOP_TIME, REMARKS, USER_ID, BARCODE_NO) VALUES ('$appointment_log_id' ,'$appointment_dt_id', null, null,'$remarks', '$user_id', '$start_barcode' )";
                        $updateMerchantBarcode = "UPDATE lz_merchant_barcode_dt SET APPOINTMENT_LOG_ID = '$appointment_log_id' WHERE BARCODE_NO = '$start_barcode'";
                        $start_barcode = $start_barcode + 1;
                        // var_dump($start_barcode);
                        $update = $this->db->query($updateBarcode);
                        $updateMerchant = $this->db->query($updateMerchantBarcode);
                    }
                    return array("update" => $update, "barcode" => $barcodeExist['DT_ID']);
                } else if ($countDiff == 0) {
                    $appointment_log_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('lj_appointment_log ', 'APPOINTMENT_LOG_ID')ID FROM DUAL")->result_array();
                    $appointment_log_id = $appointment_log_id[0]['ID'];
                    $updateBarcode = "INSERT INTO lj_appointment_log (APPOINTMENT_LOG_ID, APPOINTMENT_DT_ID, START_TIME, STOP_TIME, REMARKS, USER_ID, BARCODE_NO) VALUES ('$appointment_log_id' ,'$appointment_dt_id', null, null,'$remarks', '$user_id', '$start_barcode' )";
                    $updateMerchantBarcode = "UPDATE lz_merchant_barcode_dt SET APPOINTMENT_LOG_ID = '$appointment_log_id' WHERE BARCODE_NO = '$start_barcode'";
                    // var_dump($start_barcode);
                    $update = $this->db->query($updateBarcode);
                    $updateMerchant = $this->db->query($updateMerchantBarcode);
                    return array("update" => $update, "barcode" => $barcodeExist['DT_ID']);
                } else if ($countDiff < 0) {
                    for ($i = $countDiff; $i < 0; $i++) {
                        $appointment_log_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('lj_appointment_log ', 'APPOINTMENT_LOG_ID')ID FROM DUAL")->result_array();
                        $appointment_log_id = $appointment_log_id[0]['ID'];
                        $updateBarcode = "INSERT INTO lj_appointment_log (APPOINTMENT_LOG_ID, APPOINTMENT_DT_ID, START_TIME, STOP_TIME, REMARKS, USER_ID, BARCODE_NO) VALUES ('$appointment_log_id' ,'$appointment_dt_id', null, null,'$remarks', '$user_id', '$start_barcode' )";
                        $updateMerchantBarcode = "UPDATE lz_merchant_barcode_dt SET APPOINTMENT_LOG_ID = '$appointment_log_id' WHERE BARCODE_NO = '$start_barcode'";
                        $start_barcode = $start_barcode - 1;
                        // var_dump($start_barcode);
                        $update = $this->db->query($updateBarcode);
                        $updateMerchant = $this->db->query($updateMerchantBarcode);
                    }
                    return array("update" => $update, "barcode" => $barcodeExist['DT_ID']);
                }
            }
        } else if ($barcodeExist["status"] == false) {
            // var_dump($barcodeExist);
            // exit;
            return false;
        }
    }
    public function get_Log_After_Add_Barcode_Appointment($appointment_id, $start_barcode, $end_barcode, $update)
    {
        $barcode = count($update);
        $qr = "select * from (select
        sd.service_desc,
        lg.appointment_log_id,
        D.service_id,
        em.User_Name,
        lg.barcode_no,
        lg.START_TIME,
        D.APPOINTMENT_DT_ID,
        m.APPOINTMENT_ID
        from lj_appointment_mt m,
        lj_appointment_dt D,
        lj_services sd,
        lj_appointment_log lg,
        EMPLOYEE_MT EM
        where d.appointment_id = '$appointment_id'
         AND m.APPOINTMENT_ID = D.appointment_id
        and d.appointment_dt_id = lg.appointment_dt_id
        AND D.service_id = sd.service_id
        AND EM.EMPLOYEE_ID = m.created_by
        ORDER BY  lg.appointment_log_id DESC)where rownum <= $barcode
        ORDER BY  appointment_log_id asc";
        // AND br.BARCODE_NO = $barcode_No";
        $result = $this->db->query($qr);
        if ($result->num_rows() > 0) {
            return array("status" => true, "data" => $result->result_array());
        } else {
            return array("status" => false, "data" => "No Record");
        }
    }


  public function get_Specific_Log_Detail()
    {
        $appointment_id = $_POST['appointment_id'];
        $qr = "select
        sd.service_desc,
        D.service_id,
        em.User_Name,
        l.APPOINTMENT_LOG_ID,
        l.START_TIME,
        D.APPOINTMENT_DT_ID,
        m.APPOINTMENT_ID,
        l.barcode_no
        from lj_appointment_mt m,
        lj_appointment_dt D,
        lj_services sd,
        lj_appointment_log l,
        EMPLOYEE_MT EM
        where d.appointment_id = '$appointment_id'
        AND m.APPOINTMENT_ID = D.appointment_id
        and d.appointment_dt_id = l.appointment_dt_id
        AND D.service_id = sd.service_id
        AND l.BARCODE_NO IS NOT NULL
        AND EM.EMPLOYEE_ID = m.created_by ORDER BY l.barcode_no ASC";
        $result = $this->db->query($qr);
        if ($result->num_rows() > 0) {
            return array("status" => true, "data" => $result->result_array());
        } else {
            return array("status" => false,"data" => $result->result_array(), "message" => "No Record Found");
        }

    }
  public function Get_Summary_Appointment()
    {
        $appointment_id = $_POST['appointment_id'];
        $data = $this->Get_Time_Summary($appointment_id);
        $total_amount = "select service_id,
        appointment_id,
        service_type,
        service_desc,
        charges,
        cnt,
        PACKING_COST,
        charges * cnt total_amount
        from (select s.service_id,
                d.appointment_id,
                sr.service_type,
                s.service_desc,
                sr.charges,
                (select count(1)
                   from lj_appointment_log ll
                  where ll.appointment_dt_id = d.appointment_dt_id
                    and ll.barcode_no is not null) cnt,
                (select SUM(ABS(lpm.packing_cost))
                   from lj_appointment_log        ll,
                        lj_appointment_packing_mt lp,
                        lz_packing_type_mt        lpm
                  where ll.appointment_dt_id = d.appointment_dt_id
                    AND lp.appointment_log_id = ll.appointment_log_id
                    AND lp.packing_id = lpm.packing_id
                    and ll.barcode_no is not null) PACKING_COST
           from lj_appointment_dt d, lj_service_rate sr, lj_services s
          where d.appointment_id = '$appointment_id'
            AND d.service_id = sr.service_id
            and s.service_id = sr.service_id)";

        $result = $this->db->query($total_amount);
        $result = $result->result_array();
        $cost = $result[0]['CHARGES'];
        $Packing_cost = $result[0]['PACKING_COST'];
        $cost_per_sec = $cost / 120;
        $total_charge = $cost_per_sec * $data['total_second'];
        $total_charge = $total_charge + $Packing_cost;
        return array("status" => true, "data" => $result, "time" => $data['data'], "total_charge" => $total_charge, 'packing_cost' => $Packing_cost);

    }
    public function Get_Time_Summary($appointment_id)
    {
        $qr = "SELECT APPOINTMENT_DT_ID FROM lj_appointment_dt WHERE  APPOINTMENT_ID = '$appointment_id'";
        $result = $this->db->query($qr)->result_array();
        $appointment_dt_id = $result[0]['APPOINTMENT_DT_ID'];
//         $total_barcode = "selsect decode(Day,0,0,Day*86400) + decode(hour,0,0,hour*3600) + decode(Minute,0,0,Minute*60) + second total_second from (
        //             SELECT EXTRACT(Day FROM(l.STOP_TIME - l.START_TIME) DAY TO SECOND) as Day,
        //  EXTRACT(HOUR FROM(l.STOP_TIME -l.START_TIME) DAY TO SECOND) as Hour,
        //  EXTRACT(Minute FROM(l.STOP_TIME - l.START_TIME) DAY TO SECOND) as Minute,
        //  EXTRACT(SECOND FROM(l.STOP_TIME - l.START_TIME) DAY TO SECOND) as second
        //   from lj_appointment_log l
        //  WHERE l.appointment_dt_id = '$appointment_dt_id' AND l.Barcode_No IS NOT NULL AND l.START_TIME IS NOT NULL AND l.STOP_TIME IS NOT NULL)";
        $total_barcode = "select sum(total_second) total_second from (
        select decode(Day, 0, 0, Day * 86400) + decode(hour, 0, 0, hour * 3600) +
           decode(Minute, 0, 0, Minute * 60) + second total_second
      from (SELECT EXTRACT(Day FROM(l.STOP_TIME - l.START_TIME) DAY TO SECOND) as Day,
                   EXTRACT(HOUR FROM(l.STOP_TIME - l.START_TIME) DAY TO SECOND) as Hour,
                   EXTRACT(Minute FROM(l.STOP_TIME - l.START_TIME) DAY TO
                           SECOND) as Minute,
                   EXTRACT(SECOND FROM(l.STOP_TIME - l.START_TIME) DAY TO
                           SECOND) as second
              from lj_appointment_log l
             WHERE l.appointment_dt_id = '$appointment_dt_id'
               AND l.Barcode_No IS NOT NULL
               AND l.START_TIME IS NOT NULL
               AND l.STOP_TIME IS NOT NULL)
    )";

        $total_barcode = $this->db->query($total_barcode);
        $total_barcode = $total_barcode->result_array();
        // $total_barcodes = count($total_barcode);
        $total_sec = $total_barcode[0]["TOTAL_SECOND"];
        // $total_sec = $total_barcodes * $sec;
        // var_dump($total_sec);
        $get_time = "SELECT
            TO_CHAR(TRUNC('$total_sec'/3600),'FM9900') || ':' ||
            TO_CHAR(TRUNC(MOD('$total_sec',3600)/60),'FM00') || ':' ||
            TO_CHAR(MOD('$total_sec',60),'FM00') TOTAL_TIME
        FROM DUAL";
        $get_time = $this->db->query($get_time);
        return array("data" => $get_time->result_array(), "total_second" => $total_sec);
    }
  public function get_Specific_Services($cell_id)
    {
        $qr = "SELECT S.SERVICE_DESC,
        S.SERVICE_ID,
        S.CREATED_DATE,
        S.Created_By,
        TO_CHAR(A.APPOINTMENT_DATE, 'DD/MM/YY HH24:MI:SS') APPOINTMENT_DATE
   FROM lj_services S, lj_appointment_mt A, lj_appointment_dt SD
  WHERE SD.SERVICE_ID = S.SERVICE_ID
    AND SD.APPOINTMENT_ID = '$cell_id'
    AND A.APPOINTMENT_ID = '$cell_id'";

        $data = $this->db->query($qr);
        if ($data->num_rows() > 0) {
            $result = array("status" => true, "servicesData" => $data->result_array());
        } else {
            $result = array("status" => false, "message" => "No Reacord Found");
        }
        return $result;
    }
    public function get_Appt_Employees($cell_id)
    {
        $qr = "SELECT LAA.ASSIGNING_ID,
        LAA.EMPLOYEE_ID,
        EM.USER_NAME,
        LAA.APPOINTMENT_STATUS
   FROM LJ_APPOINTMENT_ASSIGNING LAA, EMPLOYEE_MT EM
  WHERE LAA.EMPLOYEE_ID = EM.EMPLOYEE_ID
    AND LAA.APPOINTMENT_ID = '$cell_id' ";
        $data = $this->db->query($qr);
        if ($data->num_rows() > 0) {
            $result = array("status" => true, "employeesData" => $data->result_array());
        } else {
            $result = array("status" => false, "employeesData" => $data->result_array(), "message" => "No Reacord Found");
        }
        return $result;
    }
  public function get_AppointmentDetailForEmployee()
    {
            $qr = "SELECT A.*,
            E.USER_NAME,
            M.CONTACT_PERSON,
            M.BUISNESS_NAME,
            TO_CHAR(A.APPOINTMENT_DATE, 'DD/MM/YY HH24:MI:SS') APPOINTMENT_DATE,
            TO_CHAR(A.CREATED_DATE, 'DD/MM/YY HH:MI:SS') CREATED_DATE,
            (select count(1)
               from lj_appointment_dt      dd,
                    lz_merchant_barcode_dt d,
                    lj_appointment_log     ll
              where dd.appointment_dt_id = ll.appointment_dt_id
                and dd.appointment_id = a.appointment_id
                and ll.appointment_log_id = d.appointment_log_id and ll.barcode_no is not null) TOTAL_PROCESS_BARCODE,
            Decode(A.APPOINTMENT_STATUS,
                   2,
                   'In Process',
                   0,
                   'inqueue',
                   1,
                   'Approved',
                   3,
                   'Complete',
                   4,
                   'Cancel By User',
                   5,
                   'Cancel By Admin') APPOINTMENT_STATUS,
                   Decode(A.APPOINTMENT_STATUS,
                   2,
                   '1-In Process',
                   0,
                   '3-inqueue',
                   1,
                   '2-Approved',
                   3,
                   '4-Complete',
                   4,
                   '5-Cancel By User',
                   5,
                   '6-Cancel By Admin') APPOINTMENT_STATUS_CHECK
       FROM lj_appointment_mt A, LZ_MERCHANT_MT M, EMPLOYEE_MT E
      WHERE A.MERCHANT_ID = M.MERCHANT_ID
        AND A.CREATED_BY = E.EMPLOYEE_ID
        AND(A.APPOINTMENT_STATUS=2 OR A.APPOINTMENT_STATUS=1) 
        ORDER BY APPOINTMENT_STATUS_CHECK ";
    //   ORDER BY A.APPOINTMENT_STATUS, 'inqueue', A.APPOINTMENT_ID DESC";
       
        $data = $this->db->query($qr);
        if ($data->num_rows() > 0) {
            $result = array("status" => true, "data" => $data->result_array());
        } else {
            $result = array("status" => false, "message" => "No Services");
        }
        return $result;
    }
  public function get_AppointmentDetail($user_id, $merchant_id,$roleid)
    {
        if ($roleid == 1) {

            $qr = "SELECT A.*,
            E.USER_NAME,
            M.CONTACT_PERSON,
            M.BUISNESS_NAME,
            TO_CHAR(A.APPOINTMENT_DATE, 'DD/MM/YY HH24:MI:SS') APPOINTMENT_DATE,
            TO_CHAR(A.CREATED_DATE, 'DD/MM/YY HH:MI:SS') CREATED_DATE,
            (select count(1)
               from lj_appointment_dt      dd,
                    lz_merchant_barcode_dt d,
                    lj_appointment_log     ll
              where dd.appointment_dt_id = ll.appointment_dt_id
                and dd.appointment_id = a.appointment_id
                and ll.appointment_log_id = d.appointment_log_id and ll.barcode_no is not null) TOTAL_PROCESS_BARCODE,
            Decode(A.APPOINTMENT_STATUS,
                   2,
                   'In Process',
                   0,
                   'inqueue',
                   1,
                   'Approved',
                   3,
                   'Complete',
                   4,
                   'Cancel By User',
                   5,
                   'Cancel By Admin') APPOINTMENT_STATUS,
                   Decode(A.APPOINTMENT_STATUS,
                   2,
                   '1-In Process',
                   0,
                   '2-inqueue',
                   1,
                   '3-Approved',
                   3,
                   '6-Complete',
                   4,
                   '5-Cancel By User',
                   5,
                   '4-Cancel By Admin') APPOINTMENT_STATUS_CHECK
       FROM lj_appointment_mt A, LZ_MERCHANT_MT M, EMPLOYEE_MT E
      WHERE A.MERCHANT_ID = M.MERCHANT_ID
        AND A.CREATED_BY = E.EMPLOYEE_ID
      ORDER BY APPOINTMENT_STATUS_CHECK, A.APPOINTMENT_ID DESC";
        } else {
            $qr = "SELECT A.*,
            E.USER_NAME,
            M.CONTACT_PERSON,
            M.BUISNESS_NAME,
            TO_CHAR(A.APPOINTMENT_DATE, 'DD/MM/YY HH24:MI:SS') APPOINTMENT_DATE,
            TO_CHAR(A.CREATED_DATE, 'DD/MM/YY HH:MI:SS') CREATED_DATE,
            (select count(1)
               from lj_appointment_dt      dd,
                    lz_merchant_barcode_dt d,
                    lj_appointment_log     ll
              where dd.appointment_dt_id = ll.appointment_dt_id
                and dd.appointment_id = a.appointment_id
                and ll.appointment_log_id = d.appointment_log_id) TOTAL_PROCESS_BARCODE,
            Decode(A.APPOINTMENT_STATUS,
                   2,
                   'In Process',
                   0,
                   'inqueue',
                   1,
                   'Approved',
                   3,
                   'Complete',
                   4,
                   'Cancel By User',
                   5,
                   'Cancel By Admin') APPOINTMENT_STATUS,
                   Decode(A.APPOINTMENT_STATUS,
                   2,
                   '1-In Process',
                   0,
                   '2-inqueue',
                   1,
                   '3-Approved',
                   3,
                   '6-Complete',
                   4,
                   '5-Cancel By User',
                   5,
                   '4-Cancel By Admin') APPOINTMENT_STATUS_CHECK
       FROM lj_appointment_mt A, LZ_MERCHANT_MT M, EMPLOYEE_MT E
      WHERE A.MERCHANT_ID = M.MERCHANT_ID
        AND A.CREATED_BY = E.EMPLOYEE_ID
        AND A.MERCHANT_ID = '$merchant_id'
      ORDER BY APPOINTMENT_STATUS_CHECK, A.APPOINTMENT_ID DESC";

        }
        $data = $this->db->query($qr);
        if ($data->num_rows() > 0) {
            $result = array("status" => true, "data" => $data->result_array());
        } else {
            $result = array("status" => false, "message" => "No Services");
        }
        return $result;
    }
    public function approve_Appointment_Approval($cell_id, $user_id, $status,$employee_ids,$adminremarks)
  {
      if ($status == 'inqueue' || $status == 'send to approvel') {
          $status = 1;
          $rstatus = $status + 1;
      } else if ($status == 'Approved') {
          $status = 2;
          $rstatus = $status;
      } else if ($status == 'In Process') {
          $status = 3;
          $rstatus = $status;
      } else if ($status == 'Cancel By Admin' || $status == 'Cancel By User') {
          $status = 0;
          $rstatus = 2;
      }
      $qr = "UPDATE lj_appointment_mt SET REQUEST_APPROVE_BY = '$user_id', REQUEST_APPROVAL =  '$rstatus', REQUEST_APPROVE_DATE = sysdate,  APPOINT_ACCEPT_BY = '$user_id', APPOINT_ACCEPT_DATE = sysdate, APPOINTMENT_STATUS =  '$status' , ADMIN_REMARKS =  '$adminremarks'  WHERE APPOINTMENT_ID = '$cell_id'";
      $result['status'] = $this->db->query($qr);
      $employee_idarray = json_decode($employee_ids,true);
        for ($i = 0; $i < sizeof($employee_idarray); $i++) {
            $empl_id = $employee_idarray[$i]['employee_id'];
            $this->m_appoinment->insert_Appointment_Assigning($cell_id,$empl_id);
            $this->m_appoinment->SendSingleNotification($empl_id,"New Appointment Assignmed","You have been assigned a new appointment #".$cell_id);
        }
      $username=$this->getEmployeeInfo($user_id);
        $this->MultipleSubmitPushAdmin("Appointment Approved",$username[0]["USERNAME"]." approved an appointment #".$cell_id);
        // $this->MultipleSubmitPushEmploye("Appointment Approved",$username[0]["USERNAME"]." approved an appointment #".$cell_id);
        $merchantID=$this->getSingleTokenByAppointmentID($cell_id);
        $this->SendSingleNotification($merchantID,"Appointment Approved",$username[0]["USERNAME"]." approved your appointment #".$cell_id);
      return $result;
  }
  public function approve_Appointment($cell_id, $user_id, $status)
  {
      if ($status == 'inqueue' || $status == 'send to approvel') {
          $status = 1;
          $rstatus = $status + 1;
      } else if ($status == 'Approved') {
          $status = 2;
          $rstatus = $status;
      } else if ($status == 'In Process') {
          $status = 3;
          $rstatus = $status;
      } else if ($status == 'Cancel By Admin' || $status == 'Cancel By User') {
          $status = 0;
          $rstatus = 2;
      }
      $qr = "UPDATE lj_appointment_mt SET REQUEST_APPROVE_BY = '$user_id', REQUEST_APPROVAL =  '$rstatus', REQUEST_APPROVE_DATE = sysdate,  APPOINT_ACCEPT_BY = '$user_id', APPOINT_ACCEPT_DATE = sysdate, APPOINTMENT_STATUS =  '$status'  WHERE APPOINTMENT_ID = '$cell_id'";
      $result['status'] = $this->db->query($qr);
      $username=$this->getEmployeeInfo($user_id);
        $this->MultipleSubmitPushAdmin("Appointment Approved",$username[0]["USERNAME"]." approved an appointment #".$cell_id);
        // $this->MultipleSubmitPushEmploye("Appointment Approved",$username[0]["USERNAME"]." approved an appointment #".$cell_id);
        $merchantID=$this->getSingleTokenByAppointmentID($cell_id);
        $this->SendSingleNotification($merchantID,"Appointment Approved",$username[0]["USERNAME"]." approved your appointment #".$cell_id);
      return $result;
  }
  public function cancel_Appointment_Approval($cell_id, $user_id,$roleID,$adminremarks)
  {
      if ((int)$roleID == 1) {
          $qry = "UPDATE  lj_appointment_mt SET REQUEST_APPROVAL = 3, APPOINTMENT_STATUS = 5, APPOINT_CANCEL_BY = '$user_id', APPOINT_CANCEL_DATE = sysdate, ADMIN_REMARKS =  '$adminremarks' WHERE APPOINTMENT_ID = '$cell_id'";
      } else {
          $qry = "UPDATE  lj_appointment_mt SET REQUEST_APPROVAL = 4, APPOINTMENT_STATUS = 4, APPOINT_CANCEL_BY = '$user_id', APPOINT_CANCEL_DATE = sysdate WHERE APPOINTMENT_ID = '$cell_id'";
      }
      $result['status'] = $this->db->query($qry);
      $username=$this->getEmployeeInfo($user_id);
      $merchantID=$this->getSingleTokenByAppointmentID($cell_id);
      $this->SendSingleNotification($merchantID,"Appointment Canceled",$username[0]["USERNAME"]." canceled your appointment #".$cell_id);
      return $result;

  }
  public function cancel_Appointment($cell_id, $user_id,$roleID)
  {
      if ((int)$roleID == 1) {
          $qry = "UPDATE  lj_appointment_mt SET REQUEST_APPROVAL = 3, APPOINTMENT_STATUS = 5, APPOINT_CANCEL_BY = '$user_id', APPOINT_CANCEL_DATE = sysdate WHERE APPOINTMENT_ID = '$cell_id'";
      } else {
          $qry = "UPDATE  lj_appointment_mt SET REQUEST_APPROVAL = 4, APPOINTMENT_STATUS = 4, APPOINT_CANCEL_BY = '$user_id', APPOINT_CANCEL_DATE = sysdate WHERE APPOINTMENT_ID = '$cell_id'";
      }
      $result['status'] = $this->db->query($qry);
      $username=$this->getEmployeeInfo($user_id);
      $merchantID=$this->getSingleTokenByAppointmentID($cell_id);
      $this->SendSingleNotification($merchantID,"Appointment Canceled",$username[0]["USERNAME"]." canceled your appointment #".$cell_id);
      return $result;

  }
  public function insert_Appointment($created_date, $request_for_approvel, $merchant_id, $user_id, $appointment_date, $appointment_status, $expected_barcode, $remarks)
    {
        $appt = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('lj_appointment_mt', 'APPOINTMENT_ID') LOG_ID FROM DUAL")->result_array();
        $appt_id = $appt[0]['LOG_ID'];
        $qr = "INSERT INTO lj_appointment_mt(APPOINTMENT_ID, MERCHANT_ID, APPOINTMENT_DATE, APPOINTMENT_STATUS, EXPECTED_BARCODE, REMARKS, CREATED_BY, CREATED_DATE, REQUEST_APPROVAL) VALUES ($appt_id,'$merchant_id', TO_DATE('$appointment_date', 'DD/MM/YY HH24:MI:SS'), '$appointment_status', '$expected_barcode', '$remarks', '$user_id', sysdate, '$request_for_approvel')";
        $result = $this->db->query($qr);
        if ($result == true) {
            $username=$this->getEmployeeInfo($user_id);
            $this->MultipleSubmitPushAdmin("New Appointment",$username[0]["USERNAME"]." added a new appointment at ".$appointment_date);
            return array("status" => true, 'message' => "Appointment Created", 'appointment_id' => $appt_id);
        } else {
            return array("status" => false, 'message' => "Appointment Not Created");
        }

    }
    public function complete_Appointment()
    {
        $appointment_id = $this->input->post('cell_id');
        $qr = "UPDATE lj_appointment_mt SET APPOINTMENT_STATUS = 3 WHERE APPOINTMENT_ID = '$appointment_id'";
        $result = $this->db->query($qr);
        if ($result == true) {
            $username=$this->getEmployeeInfo($user_id);
      $merchantID=$this->getSingleTokenByAppointmentID($cell_id);
      $this->SendSingleNotification($merchantID,"Appointment Completed",$username[0]["USERNAME"]." completed your appointment #".$cell_id);
            return array("status" => true, "message" => "Your appointment is complete");
        } else {
            return array("status" => false, "message" => "Record is not update mt");
        }
    }
    public function get_service_charges($service_id,$service_type)
    {
        $qr = "SELECT SR.CHARGES FROM LJ_SERVICE_RATE SR WHERE SR.SERVICE_ID='$service_id' AND SR.SERVICE_TYPE='$service_type' ";
        $result = $this->db->query($qr)->result_array();
      if (count($result) > 0)
      {
        return $result[0]['CHARGES'];
      }
      else
      {
        return 0;
      }
    }
    public function insert_Appointment_Dt($service_id,$apptid,$service_type,$service_charges)
    {

        // $qry = ("SELECT APPOINTMENT_ID FROM lj_appointment_mt where CREATED_DATE = ( select max(CREATED_DATE) from lj_appointment_mt )");

        // $data = $this->db->query($qry)->result_array();
        // $appointment_id = $data[0]['APPOINTMENT_ID'];
        $qr = "INSERT INTO lj_appointment_dt(APPOINTMENT_DT_ID, APPOINTMENT_ID, SERVICE_ID , SERVICE_TYPE , SERVICE_CHARGE ) VALUES (GET_SINGLE_PRIMARY_KEY('lj_appointment_dt', 'APPOINTMENT_DT_ID'), '$apptid', '$service_id', '$service_type', '$service_charges') ";
        $result = $this->db->query($qr);
        $data = $this->get_Latest_Appointment_Detail($apptid);
        return array('result' => $result, "data" => $data);
        // return $result;
    }
    public function insert_Appointment_Assigning($apptid,$employee_id)
    {

        $qr = "INSERT INTO LJ_APPOINTMENT_ASSIGNING(ASSIGNING_ID, APPOINTMENT_ID, EMPLOYEE_ID, APPOINTMENT_STATUS ) VALUES (GET_SINGLE_PRIMARY_KEY('LJ_APPOINTMENT_ASSIGNING', 'ASSIGNING_ID'), '$apptid', '$employee_id', '0') ";
        $result = $this->db->query($qr);
        $data = $this->get_Latest_Appointment_Detail($apptid);
        return array('result' => $result, "data" => $data);
        // return $result;
    }
    public function get_Latest_Appointment_Detail($appointment_id)
    {

        $qr = "SELECT A.*,
        E.USER_NAME,
        M.CONTACT_PERSON,
        M.BUISNESS_NAME,
        S.SERVICE_DESC,
        TO_CHAR(A.APPOINTMENT_DATE, 'DD/MM/YY HH24:MI:SS') APPOINTMENT_DATE,
        TO_CHAR(A.CREATED_DATE, 'DD/MM/YY HH24:MI:SS') CREATED_DATE,
        (select count(1)
           from lj_appointment_dt      dd,
                lz_merchant_barcode_dt d,
                lj_appointment_log     ll
          where dd.appointment_dt_id = ll.appointment_dt_id
            and dd.appointment_id = a.appointment_id
            and ll.appointment_log_id = d.appointment_log_id and ll.barcode_no is not null) TOTAL_PROCESS_BARCODEe,
        Decode(A.APPOINTMENT_STATUS,
               2,
               'In Process',
               0,
               'inqueue',
               1,
               'Approved',
               3,
               'Complete',
               4,
               'Cancel By User',
               5,
               'Cancel By Admin') APPOINTMENT_STATUS
   FROM lj_appointment_mt A,
        LZ_MERCHANT_MT    M,
        EMPLOYEE_MT       E,
        lj_services       S,
        lj_appointment_dt SD
  WHERE A.MERCHANT_ID = M.MERCHANT_ID
    AND A.CREATED_BY = E.EMPLOYEE_ID
    AND A.APPOINTMENT_ID = '$appointment_id'
    AND S.SERVICE_ID = SD.SERVICE_ID
    AND SD.APPOINTMENT_ID = '$appointment_id'";
        $data = $this->db->query($qr);
        if ($data->num_rows() > 0) {

            return $data->result_array();
        }
    }
    public function getAllEmployeesForAppt()
    {
        $qrEmp = "SELECT RES.EMPLOYEE_ID,RES.USER_NAME From (SELECT M.EMPLOYEE_ID,M.USER_NAME,
        CASE
          WHEN (SELECT EMD.MERCHANT_ID
                  FROM EMP_MERCHANT_DET EMD
                 WHERE EMD.EMPLOYEE_ID = M.EMPLOYEE_ID) IS NULL THEN
           0
          ELSE
           (SELECT EMD.MERCHANT_ID
              FROM EMP_MERCHANT_DET EMD
             WHERE EMD.EMPLOYEE_ID = M.EMPLOYEE_ID)
        END MERCHANT_ID
    FROM EMPLOYEE_MT M, EMPLOYEE_ROLE MR
    WHERE M.ROLE_ID = MR.ROLE_ID) RES
    where RES.MERCHANT_ID =0 ";
        $dataEmp =array();  
        $dataEmp = $this->db->query($qrEmp)->result_array();
        $result = array("employeeData" => $dataEmp);
        return $result;
    }
  public function getServicesAndMerchant()
    {
        $qrServices = "SELECT * FROM lj_services";
        $dataServices = $this->db->query($qrServices)->result_array();
        for($j = 0; $j < count($dataServices); $j++)
        {
            $sid=$dataServices[$j]['SERVICE_ID'];
            $dataServicesType = $this->db->query("SELECT
            LJSR.SERVICE_TYPE,
            DECODE(LJSR.SERVICE_TYPE,
                        1,
                        'Per Barcode',
                        2,
                        'Hourly',
                        3,
                        'Per Order') SERVICE_TYPE_NAME
            FROM LJ_SERVICE_RATE LJSR
            WHERE LJSR.SERVICE_ID='$sid' ")->result_array();
            $dataServices[$j]["SERVICE_TYPE"] = $dataServicesType;
        
        }
        $qrEmp = "SELECT RES.EMPLOYEE_ID,RES.USER_NAME From (SELECT M.EMPLOYEE_ID,M.USER_NAME,
        CASE
          WHEN (SELECT EMD.MERCHANT_ID
                  FROM EMP_MERCHANT_DET EMD
                 WHERE EMD.EMPLOYEE_ID = M.EMPLOYEE_ID) IS NULL THEN
           0
          ELSE
           (SELECT EMD.MERCHANT_ID
              FROM EMP_MERCHANT_DET EMD
             WHERE EMD.EMPLOYEE_ID = M.EMPLOYEE_ID)
        END MERCHANT_ID
    FROM EMPLOYEE_MT M, EMPLOYEE_ROLE MR
    WHERE M.ROLE_ID = MR.ROLE_ID) RES
    where RES.MERCHANT_ID =0 ";
        $dataEmp =array();  
        //$get_mer=null;
        $merchantID = $_POST['merchantid'];
        $roleID = $_POST['roleid'];
        // $merchantID = 1;
        // $roleID = 1;
        if ($roleID == 1) {
          $get_mer = $this->db->query("SELECT MM.MERCHANT_ID,MM.CONTACT_PERSON FROM LZ_MERCHANT_MT MM ORDER BY MM.MERCHANT_ID DESC"); // 2 means pending lot
          $dataEmp = $this->db->query($qrEmp)->result_array();
      } else {
          $get_mer = $this->db->query("SELECT MM.MERCHANT_ID,MM.CONTACT_PERSON FROM LZ_MERCHANT_MT MM WHERE MERCHANT_ID = '$merchantID' ORDER BY MM.MERCHANT_ID DESC"); // 2 means pending lot
      }

        if (count($dataServices) > 0 && $get_mer->num_rows() > 0) {
            $result = array("status" => true, "servicesData" => $dataServices,"merchantData" => $get_mer->result_array(),"employeeData" => $dataEmp);
        } else {
            $result = array("status" => false, "message" => "No Reacord Found");
        }
        return $result;
    }
    public function custom_Barcode_In_Process()
    {
        $customBarcode = $_POST["barcode"];
        $user_id = $_POST['user_id'];
        $service_id = $_POST['service_id'];
        $remarks = $_POST['remarks'];
        $appointment_id = $_POST["appointment_id"];
        $label = $_POST["label"];
        $merchant_id =$_POST["merchant_id"];
        $qr = "SELECT APPOINTMENT_DT_ID FROM lj_appointment_dt WHERE SERVICE_ID = '$service_id' AND APPOINTMENT_ID = '$appointment_id'";
        $result = $this->db->query($qr)->result_array();
        $appointment_dt_id = $result[0]['APPOINTMENT_DT_ID'];

        $update = $this->add_Lot_CustomBarcode_Barcode_Detail($label, $service_id, $customBarcode, $appointment_dt_id, $merchant_id, $user_id, $remarks);
        if ($update == true) {
            $qr = "UPDATE lj_appointment_mt SET APPOINTMENT_STATUS = 2 WHERE APPOINTMENT_ID = '$appointment_id'";
            $result = $this->db->query($qr);
            if ($result == true) {
                $latestData = $this->get_Log_After_Add_custonBarcode_Appointment($appointment_id, $customBarcode);
                $updatedTime = $this->Get_Summary_Appointment_After_Insert_Delete($appointment_id, $appointment_dt_id);
                if ($latestData == true) {
                    return array("status" => true, "message" => "Record Update", "data" => $latestData['data'], "summary" => $updatedTime['data'], "update_time" => $updatedTime['time'], "total_charge" => $updatedTime['total_charge']);

                } else {
                    return array("status" => false, "message" => "Record Update", "data" => $latestData['data'], "summary" => $updatedTime['data'], "update_time" => $updatedTime['time'], "total_charge" => $updatedTime['total_charge']);
                }
            } else {
                return array("status" => false, "message" => "Record is not update mt");
            }
        } else {
            return array("status" => false, "message" => "Barcode already consumed and Barcode not for this merchant");
        }
    }
    public function add_Lot_CustomBarcode_Barcode_Detail($label, $service_id, $customBarcode, $appointment_dt_id, $merchant_id, $user_id, $remarks)
    {
        $barcodeExist = $this->check_Lot_Custom_Barcode_Exist($label, $service_id, $customBarcode, $appointment_dt_id, $merchant_id);
        if ($barcodeExist["status"] == true) {
            if ($label == "Inventory prep" || $label == "Inventory Prop" || $service_id == 3) {
                $appointment_log_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('lj_appointment_log ', 'APPOINTMENT_LOG_ID')ID FROM DUAL")->result_array();
                $appointment_log_id = $appointment_log_id[0]['ID'];
                $updateBarcode = "INSERT INTO lj_appointment_log (APPOINTMENT_LOG_ID, APPOINTMENT_DT_ID, START_TIME, STOP_TIME, REMARKS, USER_ID, BARCODE_NO) VALUES ('$appointment_log_id' ,'$appointment_dt_id', null, null,'$remarks', '$user_id', '$customBarcode' )";
                $updateMerchantBarcode = "UPDATE lz_merchant_barcode_dt SET APPOINTMENT_LOG_ID = '$appointment_log_id' WHERE BARCODE_NO = '$customBarcode'";
                $update = $this->db->query($updateBarcode);
                $this->db->query($updateMerchantBarcode);
                return $update;

            } else if ($label == "Picture" || $label == "picture" || $service_id == 1) {
                $appointment_log_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('lj_appointment_log ', 'APPOINTMENT_LOG_ID')ID FROM DUAL")->result_array();
                $appointment_log_id = $appointment_log_id[0]['ID'];
                $updateBarcode = "INSERT INTO lj_appointment_log (APPOINTMENT_LOG_ID, APPOINTMENT_DT_ID, START_TIME, STOP_TIME, REMARKS, USER_ID, BARCODE_NO) VALUES ('$appointment_log_id' ,'$appointment_dt_id', null, null,'$remarks', '$user_id', '$customBarcode' )";
                $updateMerchantBarcode = "UPDATE lz_merchant_barcode_dt SET APPOINTMENT_LOG_ID = '$appointment_log_id' WHERE BARCODE_NO = '$customBarcode'";
                $update = $this->db->query($updateBarcode);
                $this->db->query($updateMerchantBarcode);
                return $update;

            }
        } else if ($barcodeExist["status"] == false) {
            return false;
        }
    }
    public function check_Lot_Custom_Barcode_Exist($label, $service_id, $customBarcode, $appointment_dt_id, $merchant_id)
    {
        if ($label == "Inventory prep" || $label == "Inventory prep" || $service_id == 3) {
            $qr = "SELECT * from lz_merchant_barcode_dt d, lz_merchant_barcode_mt m WHERE m.mt_id = d.mt_id AND m.POS_STATUS != 1 AND m.merchant_id = '$merchant_id' AND d.appointment_log_id IS NULL AND d.barcode_no =  '$customBarcode'";
            $existBarcode = $this->db->query($qr);
            if ($existBarcode->num_rows() > 0) {
                return array("status" => true);
            } else {
                return array("status" => false);
            }
        }
        if ($label == "Picture" || $label == "picture" || $service_id == 1) {

            $qr = "SELECT * from lz_merchant_barcode_dt d, lz_merchant_barcode_mt m WHERE m.mt_id = d.mt_id  AND m.POS_STATUS != 1 AND m.merchant_id = '$merchant_id' AND d.appointment_log_id IS NULL AND d.barcode_no =  '$customBarcode'";
            $existBarcode = $this->db->query($qr);
            if ($existBarcode->num_rows() > 0) {
                return array("status" => true);
            } else {
                return array("status" => false);
            }
        } else {
            return array("status" => false);
        }
    }

    public function Get_Summary_Appointment_After_Insert_Delete($appointment_id, $appointment_dt_id)
    {
        // $total_amount = " select service_id, appointment_id,service_type,service_desc,charges, cnt , charges * cnt total_amount from
        // (select s.service_id, d.appointment_id,sr.service_type,s.service_desc,sr.charges , (select count(1)
        //   from lj_appointment_log     ll
        //  where ll.appointment_dt_id = d.appointment_dt_id and ll.barcode_no is not null) cnt
        // from lj_appointment_dt d, lj_service_rate sr,lj_services s
        // where d.appointment_id = '$appointment_id'
        // AND d.service_id = sr.service_id
        // and s.service_id = sr.service_id)";
        $total_amount = "select service_id,
        appointment_id,
        service_type,
        service_desc,
        charges,
        cnt,
        PACKING_COST,
        charges * cnt total_amount
   from (select s.service_id,
                d.appointment_id,
                sr.service_type,
                s.service_desc,
                sr.charges,
                (select count(1)
                   from lj_appointment_log ll
                  where ll.appointment_dt_id = d.appointment_dt_id
                    and ll.barcode_no is not null) cnt,
                (select SUM(ABS(lpm.packing_cost))
                   from lj_appointment_log        ll,
                        lj_appointment_packing_mt lp,
                        lz_packing_type_mt        lpm
                 --  lj_appointment_dt         d
                  where ll.appointment_dt_id = d.appointment_dt_id
                    AND lp.appointment_log_id = ll.appointment_log_id
                    AND lp.packing_id = lpm.packing_id
                    and ll.barcode_no is not null) PACKING_COST
           from lj_appointment_dt d, lj_service_rate sr, lj_services s
         -- lj_appointment_packing_mt lp,
         -- lj_appointment_log        ll,
         --lz_packing_type_mt        lpm
          where d.appointment_id = '$appointment_id'
            AND d.service_id = sr.service_id
               --AND lp.appointment_log_id = ll.appointment_log_id
               --AND lp.packing_id = lpm.packing_id
            and s.service_id = sr.service_id)";
        $result = $this->db->query($total_amount);
        $time = $this->Get_Time_Summary($appointment_id);

        $result = $result->result_array();
        $cost = $result[0]['CHARGES'];
        $cost_per_sec = $cost / 120;
        $total_charge = $cost_per_sec * $time['total_second'];
        $total_charge = $total_charge + $result[0]['PACKING_COST'];
        return array("status" => true, "data" => $result, "time" => $time['data'], "total_charge" => $total_charge, "packing_cost" => $result[0]['PACKING_COST']);

    }
    public function get_Log_After_Add_custonBarcode_Appointment($appointment_id, $customBarcode)
    {
        $qr = "select sd.service_desc,
        D.service_id,
        em.User_Name,
        lg.barcode_no,
        lg.START_TIME,
        D.APPOINTMENT_DT_ID,
        m.APPOINTMENT_ID,
        (select count(1)
            from lz_merchant_barcode_dt dd
           where D.appointment_dt_id = lg.appointment_dt_id
             and D.appointment_id = m.appointment_id
             and lg.appointment_log_id = dd.appointment_log_id) TOTAL_PROCESS_BARCODE
   from lj_appointment_mt  m,
        lj_appointment_dt  D,
        lj_services        sd,
        lj_appointment_log lg,

        EMPLOYEE_MT EM
  where d.appointment_id = '$appointment_id'
    AND m.APPOINTMENT_ID = D.appointment_id
    AND lg.appointment_dt_id = D.APPOINTMENT_DT_ID
    AND D.service_id = sd.service_id
    AND EM.EMPLOYEE_ID = m.created_by
    AND lg.BARCODE_NO = '$customBarcode'
  ORDER BY lg.barcode_no ASC
";
        $result = $this->db->query($qr);
        if ($result->num_rows() > 0) {
            return array("status" => true, "data" => $result->result_array());
        } else {
            return array("status" => false, "data" => "No Record");
        }
    }

  public function getSignInResult(){
    if (isset($_POST['username']) && isset($_POST['password']))
    {

      $username = $_POST['username'];
      $password = $_POST['password'];
      $response= array();
      $main_query = "SELECT M.EMPLOYEE_ID,
      (M.FIRST_NAME || ' ' || M.LAST_NAME) NAME,
      M.USER_NAME,
      M.PASS_WORD,
      MR.ROLE_NAME,
      M.ROLE_ID,
      CASE
        WHEN (SELECT EMD.MERCHANT_ID
                FROM EMP_MERCHANT_DET EMD
               WHERE EMD.EMPLOYEE_ID = M.EMPLOYEE_ID) IS NULL THEN
         0
        ELSE
         (SELECT EMD.MERCHANT_ID
            FROM EMP_MERCHANT_DET EMD
           WHERE EMD.EMPLOYEE_ID = M.EMPLOYEE_ID)
      END MERCHANT_ID
 FROM EMPLOYEE_MT M, EMPLOYEE_ROLE MR
WHERE M.ROLE_ID = MR.ROLE_ID
AND M.USER_NAME ='$username' 
AND M.PASS_WORD ='$password' ";
      $row = $this->db->query($main_query)->result_array();
      if (count($row) > 0)
      {
         return array("error"=>false,"message"=>"Login Successfully!","login_data"=>$row[0]);
      }
      else
      {
         return array("error"=>true,"message"=>"Wrong Cradentials!");
      }
      
     }
    else 
   {
      return array("error"=>true,"message"=>"Empty Paraeters!");
    }
  }
}