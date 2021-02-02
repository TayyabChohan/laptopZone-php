<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Single Entry Model
 */
require_once "vendor/autoload.php";

\EasyPost\EasyPost::setApiKey('EZTKac29498d9013471eac177657f1146b86kY1x5gKV0LLv8KwrFaQiig');
class m_lzw_shipment extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function callEasyPost()
    {
        echo $addres = $this->input->post('ship_address');
        exit();
        // "street1":_street1,
        // "street2":_street2,
        // "city":_city,
        // "state":_state,
        // "zip":_zip,
        // "phone": _phone,

        // "weight":_weight,
        // "quantity":_quantit,
        // "remarks":_remarks,
        // "length":_length,
        // "width":_width,
        // "height":_height,

        $street1 = $this->input->post('street1');
        $street2 = $this->input->post('street2');
        $city = $this->input->post('city');
        $state = $this->input->post('state');
        $zip = $this->input->post('zip');
        $phone = $this->input->post('phone');
        $userId = $this->input->post('userId');
        $addressId = $this->input->post('addressId');
        //save the new address and update the old one.

        // $result = $this->saveAddress($street1, $street2, $city, $state, $zip, $phone, $userId, $addressId);
        // return $result;
        //$result = $this->product->saveAddress();

        $weight = $this->input->post('ship_weight');
        $length = $this->input->post('ship_length');
        $width = $this->input->post('ship_width');
        $height = $this->input->post('ship_height');
        $userEmail = $this->input->post('userEmail');
        $offerRequestId = $this->input->post('searcInput');

        $userSelectedService = $this->input->post('userSelectedService');
        $selectedService = $this->input->post('selectedService');
        $selectedRate = $this->input->post('selectedRate');

        $fromAddress = \EasyPost\Address::create(array(
            'company' => 'EasyPost',
            // 'street1' => '417 Montgomery Street',
            'street1' => $street1,
            'street2' => $street2,
            'city' => $city,
            'state' => $state,
            'zip' => $zip,
            'phone' => $phone,
            // 'city' => 'San Francisco',
            // 'state' => 'CA',
            // 'zip' => '94104',
            // 'phone' => '415-528-7555',
        ));

        $toAddress = \EasyPost\Address::create(array(
            'name' => 'Syed kamran Kazmi',
            'company' => 'Laptop Zone',
            'street1' => '2720 Royal Lane',
            'city' => 'Dallas',
            'state' => 'TX',
            'zip' => '75229',
            // 'name' => 'George Costanza',
            // 'company' => 'Vandelay Industries',
            // 'street1' => '1 E 161st St.',
            // 'city' => 'Bronx',
            // 'state' => 'NY',
            // 'zip' => '10451',
        ));

        $parcel = \EasyPost\Parcel::create(array(
            "length" => $length,
            "width" => $width,
            "height" => $height,
            "weight" => $weight,
        ));

        // $parcel = \EasyPost\Parcel::create(array(
        //     "length" => 9,
        //     "width" => 6,
        //     "height" => 2,
        //     "weight" => 10,
        // ));

        // $parcel = \EasyPost\Parcel::create(array(
        //     "predefined_package" => 'FlatRateEnvelope',
        //     "weight" => 10
        // ));

        $shipment = \EasyPost\Shipment::create(array(
            "to_address" => $toAddress,
            "from_address" => $fromAddress,
            "parcel" => $parcel,
        ));
        $arrayData = array();
        $i = 0;

        // // $shipment->buy(array('rate' => array('id' => '{RATE_ID}')));
        // $shipment->insure(array('amount' => 100));
        // // Print PNG link
        // $arrayData[$i] = array(
        //     "label_url" => $shipment->postage_label->label_url,
        //     "Tracking No" => $shipment->tracking_code,
        // );

        // return json_encode($arrayData);

        // //OR
        if ($userSelectedService == "no") {
            foreach ($shipment->rates as $rate) {
                $arrayData[$i] = array(
                    "carrier" => $rate->carrier,
                    "service" => $rate->service,
                    "rate" => $rate->rate,
                    "id" => $rate->id,
                );
                $i++;
            }
            //here we return all available carriers with service & rate . when user select his desired option
            //with respect of service and rate we get the rate id in else part  and we get shipping label.
            return $arrayData;
        } else { //on 2nd call , send back the shipping label .
            $selectedRateId = 0;
            foreach ($shipment->rates as $rate) {
                if ($rate->carrier == "USPS" && $rate->service == $selectedService) {
                    // return $val["id"].$val["carrier"].$val["service"];
                    $selectedRateId = $rate->id;
                }
            }
            $shipment->buy(array('rate' => array('id' => $selectedRateId)));
            // $shipment->insure(array('amount' => 100));
            // // Print PNG link
            $arrayData[$i] = array(
                "label_url" => $shipment->postage_label->label_url,
                "Tracking_No" => $shipment->tracking_code,
            );

            // file_put_contents('non.jpg', file_get_contents($arrayData[$i]["label_url"]));
            //$this->sendEmail("tahiramjad79@gmail.com", $arrayData[$i]["label_url"]);
            $shippingLabel = date("d_m_y") . time() . "_" . mt_rand(1, 500);
            $shippingLabelPathAndName = "assets/shippingLabels/ShippingLabel" . $shippingLabel . ".jpg";
            copy($arrayData[$i]["label_url"], $shippingLabelPathAndName);
            $result = $this->sendEmail($userEmail, $shippingLabelPathAndName);
            if ($result == true) {
                unlink($shippingLabelPathAndName);
                $this->addShipment($offerRequestId, $userId, $arrayData[$i]["Tracking_No"], $arrayData[$i]["label_url"]); //insert shping info in db.
            } else {
                return $result;
            }
            return $arrayData;
        }

    }
}    