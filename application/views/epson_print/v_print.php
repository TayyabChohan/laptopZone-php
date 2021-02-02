<script src="<?php echo base_url('assets/epos-2.12.0.js'); ?>"></script>
<script src="<?php echo base_url('assets/testjs.js'); ?>"></script>


     <script type="text/javascript">

    //  return 'connect'
    var customerName = '<?php echo trim(str_replace(" ", '', @$store_name[0]["BUYER_NAME"])); ?>';
    console.log(customerName)
     var ePosDev = new epson.ePOSDevice();
     var printer = null;
     connect();
        function connect()
        {
            console.log('connect')
            var printerPort = 8008;

            ePosDev.connect('192.168.0.137', printerPort, callback_connect);
        }
        function callback_connect(resultConnect)
         {
            console.log(resultConnect)
            if ((resultConnect == 'OK') || (resultConnect == 'SSL_CONNECT_OK'))
            { //Get the Printer object
                console.log('callback_connect Ok')
                console.log(ePosDev.DEVICE_TYPE_PRINTER)
                ePosDev.createDevice('local_printer', ePosDev.DEVICE_TYPE_PRINTER, {'crypto' : false, 'buffer' : false}, callback_createDevice);
            }
            else {
                    console.log('callback_connect Eror')

                        // echo json_encode(array('Error'=>'callback_connect Eror'));
                        return array('Error'=>'callback_connect Eror');
                    //Display the error message
                    }
         }
            function callback_createDevice(deviceObj, retcode)
            {
                if( retcode == 'OK' )
                {
                    printer = deviceObj;
                    printer.timeout = 60000;
                    //Register the printing complete event
                    console.log('callback_createDevice OK')
                    printer.onreceive = function (res) {
                        alert(res.success + '  Print');
                    };
                    print();
                } else{
                    // echo json_encode(array('Error'=>retcode));
                        return array('Error'=>retcode);
                    alert(retcode);
                }
            }
function print(){
     //Create the printing data
    //  printer.addText('Hello\n');

    var docDateStr = '<?php
$concatDate = date("m/d/Y");
$barDate = str_replace('/', '', $concatDate);
// var_dump($barDate);exit;
$str1 = substr($barDate, 0, 4);
$str2 = substr($barDate, 6, 8);
echo $docDateStr = $str1 . $str2;?>'
    var serialNo = '<?php echo @$data[0]["DOC_NO"]; ?>';
     var storeName = '<?php echo @$store_name[0]["STORE_NAME"]; ?>';
     var customerName = '<?php echo trim(str_replace(" ", '', @$store_name[0]["BUYER_NAME"])); ?>';
     var address = '<?php echo @$store_name[0]["ADDRESS"]; ?>';
     var city_desc = '<?php echo @$store_name[0]["CITY_DESC"]; ?>';
     var phone_no = '<?php echo @$store_name[0]["PHONE_NO"]; ?>';
    var detail = '<?php foreach (@$data as $res) {
    $text = $res["ITEM_DESC"];
    $item_desc = str_split($text, 40);
    echo @$item_desc[0] . '\t\t' . @$res["QTY"] . '\t\t' . '$' . number_format((float) @$res['DET_PRICE'], 2, '.', ',') . '\t\t' . '$' . number_format((float) @$res['DET_PRICE'], 2, '.', ',');}?>';

        var sum_price =  '<?php $sum_price = 0;foreach (@$data as $res) {$sum_price = $sum_price + $res['DET_PRICE'];}
echo $sum_price?>';
     console.log(sum_price) ;
        var sum_disc_amt = '<?php $sum_disc_amt = 0;foreach (@$data as $res) {$sum_disc_amt = $sum_disc_amt + $res['DISC_AMT'];}
echo $sum_disc_amt?>';
     console.log(sum_disc_amt) ;
        var sum_qty = '<?php $sum_qty = 0;foreach (@$data as $res) {$sum_qty = $sum_qty + $res['QTY'];}
echo $sum_qty?>';
        var total_pay_advance = '<?php $total_pay_advance = 0;foreach (@$data as $res) {$total_pay_advance = $total_pay_advance + $res['ADVANCE_PAYMENT'];}
echo $total_pay_advance?>';
        var total = Number(sum_price) - Number(sum_disc_amt);
    console.log(total)
        var pay_mode = '<?php echo @$data[0]['PAY_MODE']; ?>';
        var sales_tax = '<?php echo @$data[0]['DET_SALES_TAX']; ?>';
             sales_tax = (total / 100) * sales_tax;
              //  number_format((float) sales_tax, 2, '.', ',');
             sales_tax = sales_tax.toFixed(2)
                console.log(sales_tax)

        var receipt_total = Number(total) + Number(sales_tax);

        var receipt_totals = Number(receipt_total) - Number(total_pay_advance);
        // receipt_total = number_format((float) receipt_total, 2, '.', ',');
        // receipt_totals = number_format((float) receipt_totals, 2, '.', ',');
            receipt_total = receipt_total.toFixed(2)
            receipt_totals = receipt_totals.toFixed(2)
            console.log(receipt_total)
            console.log(receipt_totals)
        var rcpt_total
            if (pay_mode == "C") {
                rcpt_total = "Cash: $" . receipt_total;

            } else if (pay_mode == "R") {
                rcpt_total = "Credit: $" . receipt_total;
            }
        console.log(rcpt_total)
    var data = serialNo + '-' + docDateStr
    var today = new Date();
    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    var dateTime = date+' '+time;
    console.log(dateTime)
    printer.addLayout(printer.LAYOUT_RECEIPT, 800, 0, 0, 0, 35, 0);

    printer.addTextAlign(printer.ALIGN_LEFT);
    printer.addText(dateTime + '\t\t');

    printer.addTextAlign(printer.ALIGN_RIGHT);
    printer.addText('serial# '+ serialNo + '\t\t');
    printer.addText('\n');

    printer.addTextAlign(printer.ALIGN_LEFT);
    printer.addText('Store Name: '+ storeName + '\t\t');
    printer.addText('\n');

    printer.addTextAlign(printer.ALIGN_CENTER);
    printer.addTextSmooth(true);
    printer.addText('\n');

    printer.addTextDouble(true, true);
    printer.addText("Laptop Zone" + '\n');
    printer.addText('\n');

    printer.addTextDouble(false, false);
    printer.addTextAlign(printer.ALIGN_CENTER);
    printer.addTextSmooth(true);
    printer.addText(address + '\n');
    printer.addText(city_desc + '\n');
    printer.addText(phone_no + '\n');

    printer.addTextAlign(printer.ALIGN_LEFT);
    printer.addTextStyle(false, false, true, printer.COLOR_1);
    printer.addText('Customer Name: '+ customerName + '\t\t');
    printer.addTextStyle(false, false, false, printer.COLOR_1);
    printer.addText('\n');
    printer.addText('\n');


    printer.addHLine(0, 800, printer.LINE_MEDIUM);
    printer.addTextAlign(printer.ALIGN_LEFT);
    printer.addText('Item Name'  + '\t' + 'Qty' + '\t' + 'Price' + '\t' + 'Ext Price' );
    printer.addHLine(0, 800, printer.LINE_MEDIUM);
    printer.addTextAlign(printer.ALIGN_LEFT);
    printer.addText('<?php foreach (@$data as $res) {
    $text = $res["ITEM_DESC"];
    $item_desc = str_split($text, 40);
    echo @$item_desc[0] . '\t' . @$res["QTY"] . '\t' . '$' . number_format((float) @$res['DET_PRICE'], 2, '.', ',') . '\t' . '$' . number_format((float) @$res['DET_PRICE'], 2, '.', ',') . '\n';}?>');

    printer.addHLine(0, 800, printer.LINE_MEDIUM);
    printer.addTextAlign(printer.ALIGN_RIGHT);
    printer.addText('Qty: ' + sum_qty + '\n');
    printer.addTextAlign(printer.ALIGN_RIGHT);
    printer.addText('Subtotal: ' + sum_price + '\n');
    printer.addTextAlign(printer.ALIGN_RIGHT);
    printer.addText('Disc Amount: ' + sum_disc_amt + '\n');
    printer.addTextAlign(printer.ALIGN_RIGHT);
    printer.addText('Total: ' + total + '\n');
    printer.addTextAlign(printer.ALIGN_RIGHT);
    printer.addText('Advance Pay: ' + total_pay_advance + '\n');
    printer.addTextAlign(printer.ALIGN_LEFT);
    printer.addText('Exempt: ' + sales_tax  + '\n');
    printer.addTextAlign(printer.ALIGN_RIGHT);
    printer.addText('GRAND TOTAL: ' + receipt_total  + '\n');
    printer.addText('Type: ' +  rcpt_total  + '\n');
    printer.addText('Total Pay: ' + receipt_totals  + '\n');

    printer.addTextAlign(printer.ALIGN_CENTER);
    printer.addTextStyle(false, false, true, printer.COLOR_1);
    printer.addTextStyle(false, false, false, printer.COLOR_1);

    printer.addTextDouble(false, false);
    printer.addBarcode(data, printer.BARCODE_CODE39, printer.HRI_BELOW, printer.FONT_A,'3', '162');
    printer.addTextDouble(false, false);

    printer.addTextDouble(false, true);
    printer.addText('* SALE RECEIPT *\n');
    printer.addTextDouble(false, false);
    printer.addCut();
    // printer.print(canvas, cut, mode)
    //Send the printing data
    console.log('print_send')
    printer.send();
}
function disconnect(){
    //Discard the Printer object
    console.log('disonnect')
   return array('Error'=>'disonnect');
                        return json_encode(array('Error'=>'disonnect'));
    ePosDev.deleteDevice(printer, callback_deleteDevice);
}
 function callback_deleteDevice(errorCode)
{
    //Disconnect to device
    return array('Error'=>errorCode);
                        return json_encode(array('Error'=>errorCode));
    ePosDev.disconnect();
}

</script>