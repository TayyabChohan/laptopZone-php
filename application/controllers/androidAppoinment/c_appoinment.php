<?php

class c_appoinment extends CI_Controller{
  public function __construct(){
      parent::__construct();
      $this->load->database();
      $this->load->model('androidAppoinment/m_appoinment');
        $this->load->helper('security');     
  }
  public function start_time()
  {
      $result = $this->m_appoinment->start_time();
      echo json_encode($result);
      return json_encode($result);
  }
  public function getSeconds()
  {
    $result = $this->m_appoinment->getSeconds();
        echo json_encode($result);
        return json_encode($result);
  }
  public function testSomthing()
  {
    date_default_timezone_set('GMT');
    echo date("m/d/Y H:i:s A");
  }
  public function remove_token()
    {
        $result = $this->m_appoinment->remove_token();
        echo json_encode($result);
        return json_encode($result);
    }
  public function save_token()
    {
        $result = $this->m_appoinment->save_token();
        echo json_encode($result);
        return json_encode($result);
    }
    public function SendSingleNotification()
    {
        $title=$_POST['title'];
        $message=$_POST['message'];
        $user_id=$_POST['user_id'];
        $result = $this->m_appoinment->SendSingleNotification($user_id,$title,$message);
        echo $result;
        return $result;
    }
    public function MultipleSubmitPushAdmin()
    {
        $title=$_POST['title'];
        $message=$_POST['message'];
        $result = $this->m_appoinment->MultipleSubmitPushAdmin($title,$message);
        echo $result;
        return $result;
    }
    public function MultipleSubmitPushEmploye()
    {
        $title=$_POST['title'];
        $message=$_POST['message'];
        $result = $this->m_appoinment->MultipleSubmitPushEmploye($title,$message);
        echo $result;
        return $result;
    }
  public function stop_time()
    {
        $result = $this->m_appoinment->stop_time();
        echo json_encode($result);
        return json_encode($result);
    }
  public function in_Process_Appointment()
    {
        $result = $this->m_appoinment->in_Process_Appointment();
        echo json_encode($result);
        return json_encode($result);
    }
    public function delete_Log_Appointment_Services()
    {
        $result = $this->m_appoinment->delete_Log_Appointment_Services();
        echo json_encode($result);
        return json_encode($result);
    }
  public function get_Specific_Log_Detail()
  {
      $result = $this->m_appoinment->get_Specific_Log_Detail();
      echo json_encode($result);
      return json_encode($result);
  }
  public function Get_Summary_Appointment()
    {
        $result = $this->m_appoinment->Get_Summary_Appointment();
        echo json_encode($result);
        return json_encode($result);
    }
  public function get_Specific_Services()
    {
        $cell_id = $_POST['cell_id'];

        $result = $this->m_appoinment->get_Specific_Services($cell_id);
        echo json_encode($result);
        return json_encode($result);
    }
    public function get_Appt_DetailApproval()
    {
        $cell_id = $_POST['cell_id'];
        $result["status"] =true;
        $result["servicesData"] = $this->m_appoinment->get_Specific_Services($cell_id)["servicesData"];
        $result["employeeData"] = $this->m_appoinment->getAllEmployeesForAppt()["employeeData"];
        echo json_encode($result);
        return json_encode($result);
    }
    public function get_Appt_Detail()
    {
        $cell_id = $_POST['cell_id'];
        $result["status"] =true;
        $result["servicesData"] = $this->m_appoinment->get_Specific_Services($cell_id)["servicesData"];
        $result["employeesData"] = $this->m_appoinment->get_Appt_Employees($cell_id)["employeesData"];
        echo json_encode($result);
        return json_encode($result);
    }
  public function get_AppointmentDetail()
  {
      $user_id = $_POST['user_id'];
      $merchant_id = $_POST['merchant_id'];
      $role_id = $_POST['role_id'];
      $result = $this->m_appoinment->get_AppointmentDetail($user_id, $merchant_id, $role_id);
      echo json_encode($result);
      return json_encode($result);
  }
  public function Get_Packing_Detail_Appointment()
  {
    $appointment_log_id = $this->input->post('appointment_log_id');
    $appointment_id = $this->input->post('appointment_id');
      $result = $this->m_appoinment->Get_Packing_Detail_Appointment($appointment_log_id,$appointment_id);
      echo json_encode($result);
      return json_encode($result);
  }
  public function Save_Appointment_Packing()
  {
      $result = $this->m_appoinment->Save_Appointment_Packing();
      echo json_encode($result);
      return json_encode($result);
  }
  public function Reset_Appointment_Packing()
  {
      $result = $this->m_appoinment->Reset_Appointment_Packing();
      echo json_encode($result);
      return json_encode($result);
  }
  public function Delete_Single_Packing()
  {
      $result = $this->m_appoinment->Delete_Single_Packing();
      echo json_encode($result);
      return json_encode($result);
  }
  public function get_AllLogDetail()
  {
      $result = $this->m_appoinment->get_AllLogDetail();
      echo json_encode($result);
      return json_encode($result);
  }
  public function get_Packing_Type_And_Detail()
  {
      $result = $this->m_appoinment->get_Packing_Type_And_Detail();
      echo json_encode($result);
      return json_encode($result);
  }
  public function get_Packing_Type()
  {
      $result = $this->m_appoinment->get_Packing_Type();
      echo json_encode($result);
      return json_encode($result);
  }
  public function get_AppointmentDetailForEmployee()
  {
      $result = $this->m_appoinment->get_AppointmentDetailForEmployee();
      echo json_encode($result);
      return json_encode($result);
  }
  public function getSignInResult(){
		$data = $this->m_appoinment->getSignInResult();                
        echo json_encode($data);
   		return json_encode($data);
  }
  public function getServicesAndMerchant(){
		$data = $this->m_appoinment->getServicesAndMerchant();                
        echo json_encode($data);
   		return json_encode($data);
  }
  public function complete_Appointment()
  {
      $result = $this->m_appoinment->complete_Appointment();
      echo json_encode($result);
      return json_encode($result);
  }
  public function approve_Appointment_Approval()
    {
        $cell_id = $_POST['cell_id'];
        $user_id = $_POST['user_id'];
        $status = $_POST['status'];
        $employee_ids = $_POST['employee_ids'];
        $adminremarks= $_POST['adminremarks'];

        if (!empty($cell_id)) {
            $result = $this->m_appoinment->approve_Appointment_Approval($cell_id, $user_id, $status,$employee_ids,$adminremarks);

        }
        echo json_encode($result);
        return json_encode($result);
    }
  public function approve_Appointment()
    {
        $cell_id = $_POST['cell_id'];
        $user_id = $_POST['user_id'];
        $status = $_POST['status'];

        if (!empty($cell_id)) {
            $result = $this->m_appoinment->approve_Appointment($cell_id, $user_id, $status);

        }
        echo json_encode($result);
        return json_encode($result);
    }
    public function cancel_Appointment_Approval()
    {
        $cell_id = $_POST['cell_id'];
        $user_id = $_POST['user_id'];
        $role_id = $_POST['role_id'];
        $adminremarks= $_POST['adminremarks'];

        $result = $this->m_appoinment->cancel_Appointment_Approval($cell_id, $user_id,$role_id,$adminremarks);

        echo json_encode($result);
        return json_encode($result);
    }
  public function cancel_Appointment()
    {
        $cell_id = $_POST['cell_id'];
        $user_id = $_POST['user_id'];
        $role_id = $_POST['role_id'];

        $result = $this->m_appoinment->cancel_Appointment($cell_id, $user_id,$role_id);

        echo json_encode($result);
        return json_encode($result);
    }
    public function custom_Barcode_In_Process()
    {
        $result = $this->m_appoinment->custom_Barcode_In_Process();
        echo json_encode($result);
        return json_encode($result);
    }
  public function insert_Appointment(){              
    date_default_timezone_set('GMT');

    $services_id = $_POST['service_id'];
    $created_date = date('d/m/yy H:M:ss', time());
    $merchant_id = $_POST['mid'];
    $user_id = $_POST['user_id'];
    $employee_ids = $_POST['employee_ids'];
    $appointment_datee = $_POST['appointment_date'];
    $expected_barcode = $_POST['no_of_items'];
    $remarks = $_POST['remarks'];
    $request_for_approvel = '2';

    if (is_array($appointment_datee)) {
        $appointment_date = $appointment_datee[0];
    } else {

        $appointment_date = $appointment_datee;
    }

    $appointment_status = '1';
    $insertionRes=$this->m_appoinment->insert_Appointment($created_date, $request_for_approvel, $merchant_id, $user_id, $appointment_date, $appointment_status, $expected_barcode, $remarks);
    $result['insert_appointment'] = $insertionRes;
    if($insertionRes['status'])
    {
        $appt_id = $insertionRes['appointment_id'];
        $services_idarray = json_decode($services_id,true);
        for ($i = 0; $i < sizeof($services_idarray); $i++) {
            $service_id = $services_idarray[$i]['value'];
            $service_type = $services_idarray[$i]['type'];
            $service_charges = $services_idarray[$i]['charges'];
            if (!$service_charges)
            {
                $service_charges=$this->m_appoinment->get_service_charges($service_id,$service_type);
        
            }
            $result['insert_appointment_dt'] = $this->m_appoinment->insert_Appointment_Dt($service_id,$appt_id,$service_type,$service_charges);
        }
        $employee_idarray = json_decode($employee_ids,true);
        for ($i = 0; $i < sizeof($employee_idarray); $i++) {
            $empl_id = $employee_idarray[$i]['employee_id'];
            $this->m_appoinment->insert_Appointment_Assigning($appt_id,$empl_id);
            $this->m_appoinment->SendSingleNotification($empl_id,"New Appointment Assignmed","You have been assigned a new appointment #".$appt_id);
        }
    }
        echo json_encode($result);
        return json_encode($result);
    }
    public function insert_Appointment_Merchant(){              
        date_default_timezone_set('GMT');
    
        $services_id = $_POST['service_id'];
        $created_date = date('d/m/yy H:M:ss', time());
        $merchant_id = $_POST['mid'];
        $user_id = $_POST['user_id'];
        $appointment_datee = $_POST['appointment_date'];
        $expected_barcode = $_POST['no_of_items'];
        $remarks = $_POST['remarks'];
        $request_for_approvel = '1';
    
        if (is_array($appointment_datee)) {
            $appointment_date = $appointment_datee[0];
        } else {
    
            $appointment_date = $appointment_datee;
        }
    
        $appointment_status = '0';
        $insertionRes=$this->m_appoinment->insert_Appointment($created_date, $request_for_approvel, $merchant_id, $user_id, $appointment_date, $appointment_status, $expected_barcode, $remarks);
        $result['insert_appointment'] = $insertionRes;
        if($insertionRes['status'])
        {
            $appt_id = $insertionRes['appointment_id'];
            $services_idarray = json_decode($services_id,true);
            for ($i = 0; $i < sizeof($services_idarray); $i++) {
                $service_id = $services_idarray[$i]['value'];
                $service_type = $services_idarray[$i]['type'];
                $service_charges=$this->m_appoinment->get_service_charges($service_id,$service_type);
                $result['insert_appointment_dt'] = $this->m_appoinment->insert_Appointment_Dt($service_id,$appt_id,$service_type,$service_charges);
            }
            
        }
            echo json_encode($result);
            return json_encode($result);
        }
 
}