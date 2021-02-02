<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

require 'src/GoogleCloudVision.php';

class m_img_detect_text extends CI_Model{

  public function __construct(){
    parent::__construct();
    $this->load->database();
  }

    public function callToApi($path1){
    $key = 'AIzaSyCwek7ZrQvnqR_musHMcN5GmCI4wJRjWZE';
    $gcv = new GoogleCloudVision();
    $gcv->setKey($key);
    $gcv->setImage($path1);
    // $gcv->addFeatureOCR(1);
    $gcv->addFeature("LABEL_DETECTION", 1);
    $gcv->addFeatureUnspecified(1);
    $gcv->addFeatureFaceDetection(1);
    $gcv->addFeatureLandmarkDetection(1);
    $gcv->addFeatureLogoDetection(1);
    $gcv->addFeatureLabelDetection(1);
    $gcv->addFeatureOCR(1);
    $gcv->addFeatureSafeSeachDetection(1);
    $gcv->addFeatureImageProperty(1);
    $gcv->addFeatureWeb(1);
    
    $response = $gcv->request();
    
    return $response;
  }


  }
