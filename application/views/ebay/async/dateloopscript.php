<?php
ini_set('memory_limit', '-1');
    /*=======================================
    =            Get category id            =
    =======================================*/
    $cat_id = $this->uri->segment(4);
    //var_dump($cat_id);exit;
    $select_query = $this->db->query("SELECT * FROM LZ_BD_CATEGORY C  WHERE C.CATEGORY_ID = $cat_id");
    //$select_query = $this->db->query("SELECT * FROM LZ_BD_CATEGORY C  WHERE C.CATEGORY_ID IN(3680, 112529, 175673, 183062, 11848, 29585, 112661, 94879, 182089, 182088, 117042, 3323, 31388, 43304, 19006, 71470, 48636, 178893, 33963, 176981, 176975, 80053, 168068, 75708, 162045, 176972, 75390, 104046)");
    $data = $select_query->result_array();
    //$cat_id = $data[0]['CATEGORY_ID'];
    /*=====  End of Get category id  ======*/
    $flag = false;
foreach($data as $value){
    
    do{
        /*=============================================
    =            get max date inserted            =
    =============================================*/    
        if(!$flag){
            $time_query = $this->db->query("SELECT DATE_TO_UNIX_TS(MAX(D.SALE_TIME)) AS UTIME FROM LZ_BD_CATAG_DATA D WHERE D.MAIN_CATEGORY_ID =".$value['CATEGORY_ID']);
            $time_query = $time_query->result_array();
            $time = $time_query[0]['UTIME'];
             /*=====  End of get max date inserted  ======*/

            /*===========================================================
            =            convert microtime to require format            =
            ===========================================================*/
            //$time = microtime(true);
// EndTimeFrom = Limits the results to items ending on or after the specified time. Specify a time in the future.  
// EndTimeTo =  Limits the results to items ending on or before the specified time. Specify a time in the future.           
            if(!empty($time)){
                //$tMicro = sprintf("%03d",($time - floor($time)) * 1000);
                //$EndTimeFrom = gmdate('Y-m-d\TH:i:s.', $time).$tMicro.'Z';
                $EndTimeFrom = gmdate('Y-m-d', $time);
                $EndTimeFrom = new DateTime($EndTimeFrom);
                $EndTimeFrom->modify('+1 day');
                $EndTimeFrom = $EndTimeFrom->format('Y-m-d');
            }else{
                $time = strtotime('-90 days');
                //$tMicro = sprintf("%03d",($time - floor($time)) * 1000);
                $EndTimeTo = gmdate('Y-m-d', $time);
            }
            if(!empty($EndTimeFrom)){
                $EndTimeTo = new DateTime($EndTimeFrom);
                $EndTimeTo->modify('+1 day');
                $EndTimeTo = $EndTimeTo->format('Y-m-d');
            }else{
                $EndTimeFrom = null;
            }
            
            /*=====  End of convert microtime to require format  ======*/
        }else{
            $EndTimeFrom = new DateTime($EndTimeTo);
            $EndTimeFrom->modify('+1 day');
            $EndTimeFrom = $EndTimeFrom->format('Y-m-d');
            $EndTimeTo = new DateTime($EndTimeFrom);
            $EndTimeTo->modify('+1 day');
            $EndTimeTo = $EndTimeTo->format('Y-m-d');
        }
            date_default_timezone_set("America/Chicago");
            $currentDate = date('Y-m-d\TH:i:s');
            $currentDate = $currentDate.'.000Z';

        if(!empty($EndTimeFrom)){
            $EndTimeFrom = $EndTimeFrom . 'T00:00:00.000Z';
            if($currentDate < $EndTimeFrom){
            $EndTimeFrom = $currentDate;
            }
        }
        
        $EndTimeTo = $EndTimeTo . 'T23:59:59.000Z' ;
        //var_dump($EndTimeFrom,$EndTimeTo);exit;
        $endTimeLoop = $EndTimeTo;
        /*==================================================================
        =            check if enddate greater than current date            =
        ==================================================================*/
            
        if($currentDate < $EndTimeTo){
            $EndTimeTo = $currentDate;
        }
        

        /*=====  End of check if enddate greater than current date  ======*/
        include 'solditemswithdatefilter.php';
        //echo $request->paginationInput->pageNumber.'-'.$response->searchResult->count.'<br>';
        //var_dump('EndTimeFrom:'.$EndTimeFrom,'EndTimeTo:'.$EndTimeTo);
        $flag = false;
        if($response->searchResult->count == 0){
            $flag = true;
        }
    }while($currentDate >= $endTimeLoop);//($response->searchResult->count > 0 && $flag);
}//end main foreach
echo "Data Downloaded Successfully";
?>