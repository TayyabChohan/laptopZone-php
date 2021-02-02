<?php

    $list_qry = $this->db->query("SELECT E.EBAY_ITEM_ID, TO_CHAR(E.LIST_DATE, 'YYYY-MM-DD HH24:MI:SS') LIST_DATE, E.LZ_SELLER_ACCT_ID, U.EBAY_URL, E.LIST_QTY, E.LIST_PRICE, TRIM(E.STATUS) STATUS, D.ACCOUNT_NAME FROM EBAY_LIST_MT E, LZ_LISTED_ITEM_URL U , LJ_MERHCANT_ACC_DT D WHERE E.EBAY_ITEM_ID = U.EBAY_ID(+) AND E.LZ_SELLER_ACCT_ID = D.ACCT_ID(+) AND E.LIST_ID = $list_id")->result_array(); 
    $ebay_id = $list_qry[0]['EBAY_ITEM_ID'];
    $list_date = $list_qry[0]['LIST_DATE'];
    //$lz_seller_acct_id = $list_qry[0]['LZ_SELLER_ACCT_ID'];
    $account_type = $list_qry[0]['ACCOUNT_NAME'];
    $ebay_url = $list_qry[0]['EBAY_URL'];
    $list_qty = $list_qry[0]['LIST_QTY'];
    if(@$check_btn == 'revise'){
        $list_qty = 0;
    }
    $list_price = $list_qry[0]['LIST_PRICE'];
    $status = $list_qry[0]['STATUS'];

    // if(empty($lz_seller_acct_id)){
    //     $account_type = $this->session->userdata('account_type');
    // }else{
    //     $account_type = $lz_seller_acct_id;
    // }
    
        // if($account_type == 1)
        // {
        //     $account_type = 'Techbargains2015';
        // }elseif($account_type == 2)
        // {
        //     $account_type = 'Dfwonline';
        // }

        $emp_name = $this->session->userdata('employee_name');
        if($status == 'ADD'){
            echo "<div class='col-sm-12'>
                <div id='errorMsg' class='text-danger'>
                    The item is listed on eBay With the Following Details:<br>
                    <ul>
                        <li>Ebay Id: <a href='".$ebay_url."' target='_blank'>".$ebay_id."</a></li>
                        <li>Ebay Account: ".$account_type."</li>
                        <li>Listed By: " .$emp_name." </li>
                        <li>Timestamp: " .$list_date." </li>
                        <li>List Qty: " .$list_qty." </li>
                        <li>List Price: $ ".$list_price." </li>
                    </ul>
                </div>
               
            </div>";
        }else{
            $current_qty = $this->session->userdata('current_qty');
             echo "<div class='col-sm-12'>
                    <div id='errorMsg' class='text-danger'>
                        The item is <strong>Revised</strong> on eBay With the Following Details:<br>
                        <ul>
                            <li>Ebay Id: <a href='".$ebay_url."' target='_blank' >".$ebay_id."</a></li>
                            <li>Ebay Account: ".$account_type."</li>
                            <li>Listed By: " .$emp_name." </li>
                            <li>Timestamp: " .$list_date." </li>
                            <li>List Price: $ ".$list_price." </li>
                            <li><strong style='color:red;'>eBay Qty: ".$current_qty."</strong></li>
                            <li><strong style='color:red;'>Pushed Qty: ".$list_qty."</strong></li>
                        </ul>
                    </div>
                  </div>";
        }
            $url =  base_url('/listing/listing/print_label').'/'.$list_id;
            ?>
             <a class="prnt_btn" href="<?php echo $url; ?>" target="_blank">Print Sticker</a>
             <a style="margin-left: 5px;" class="prnt_btn" title="Back to Item Listing" href='<?php echo base_url(); ?>/tolist/c_tolist/lister_view'>Back to Item Listing</a><br><br>
<?php 
// comented by adil asad
// if(strpos(@$shopify_data, 'k2bay') !== false){
//     echo "<div class='col-sm-12'>
//                     <div id='errorMsg' class='text-danger'>
//                         The item is <strong>Listed</strong> on Shopify With the Following Details:<br>
//                         <ul>
//                             <li>Shopify Item URL: <a href='".@$shopify_data."' target='_blank' >Shopify Item Url</a></li>
//                             <li>Listed By: " .$emp_name." </li>
//                             <li>Timestamp: " .$list_date." </li>
//                             <li>List Price: $ ".$list_price." </li>
//                             <li><strong style='color:red;'>Qty: ".$list_qty."</strong></li>
//                         </ul>
//                     </div>
//                   </div>";

// }
             

?>