
/*-- Template load data --*/
   $("#temp_name").change(function(){
      var TempID  = $("#temp_name").val();
      //document.write(ProdId);
      $.ajax({
      dataType: 'json',
      type: 'POST',
      url:'<?php echo base_url(); ?>index.php/seed/c_seed/get_template',
      data: { 'TempID' : TempID},
     success: function (data) {
      //alert(data);
     if(data.TEMPLATE_ID!=''){ 
        $('#category_id').val(data.CATEGORY_ID);
       $('#category_name').val(data.TEMPLATE_NAME);
      //document.getElementById("default_condition").innerHTML=$('#default_condition').val(data.DEFAULT_COND);
       $('#default_condition').val(data.DEFAULT_COND);
       $('#default_description').val(data.DETAIL_COND);
       $('#shipping_service').val(data.SHIPPING_SERVICE);
       $('#shipping_cost').val(data.SHIPPING_COST);
       $('#additional_cost').val(data.ADDITIONAL_COST);
       $('#site_id').val(data.EBAY_LOCAL);
       $('#listing_type').val(data.LIST_TYPE);
       $('#currency').val(data.CURRENCY);
       // $('#ship_from').val(data.SHIP);
       $('#handling_time').val(data.HANDLING_TIME);
       $('#zip_code').val(data.SHIP_FROM_ZIP_CODE);
       // $('#shipping_source').val(data.SHIPPING_S);
       $('#ship_from_loc').val(data.SHIP_FROM_LOC);
       $('#bid_length').val(data.BID_LENGTH);
       $('#payment_method').val(data.PAYMENT_METHOD);
       $('#paypal').val(data.PAYPAL_EMAIL);
       $('#dispatch_time').val(data.DISPATCH_TIME_MAX);
       $('#return_accepted').val(data.RETURN_OPTION);
       $('#return_within').val(data.RETURN_DAYS);
       $('#cost_paidby').val(data.SHIPPING_PAID_BY);


     }else{
       document.write('No Result found');
       
      }
     }
     }); 
 });
/*-- End Template load data --*/

/*-- Suggest Price --*/
   $("#suggest_price").click(function(){
      var UPC  = $("#upc").val();
      $.ajax({
      type: 'POST',
      dataType: 'json',
      url:'<?php echo base_url(); ?>index.php/listing/listing/suggest_price',
      data:{ 'UPC' : UPC},
     success: function (data) {
     
     if(data.ack= 'Success' && data.itemCount > 0)
     {
        if(data.itemCount == 1)//if result is 1 than condition is changed so this check is neccessory
        {
          $( "#price-result" ).html("");
           var tr='';
           $( "#price-result" ).html( "<table border='1' id='price_table'> <th>Sr. No</th><th>Seller ID</th><th>Price</th>" );
        //  for ( var i = 1; i < data.itemCount+1; i++ ) {

           var item = data['item'];
           var price = item['basicInfo']['convertedCurrentPrice'];
           var username=item['sellerInfo']['sellerUserName'];
           var item_url = item['basicInfo']['viewItemURL'];
            $('<tr>').html("<td>" + i + "</td><td><a href='"+ item_url +"' target = '_blank'>" + username + "</a></td><td>" + price + "</td>").appendTo('#price_table');
       // }

        }
        if(data.itemCount > 1)
        {
          $( "#price-result" ).html("");
           var tr='';
           $( "#price-result" ).html( "<table border='1' id='price_table'> <th>Sr. No</th><th>Seller ID</th><th>Price</th>" );
            for ( var i = 1; i < data.itemCount+1; i++ ) 
            {

             var item = data['item'][i-1];
             var price = item['basicInfo']['convertedCurrentPrice'];
             var username=item['sellerInfo']['sellerUserName'];
             var item_url = item['basicInfo']['viewItemURL'];
            $('<tr>').html("<td>" + i + "</td><td><a href='"+ item_url +"' target = '_blank'>" + username + "</a></td><td>" + price + "</td>").appendTo('#price_table');
            }
        }
      
    }else{
       $( "#price-result" ).html("No Reecord found");
              
      }
     }
     }); 
 });
/*-- End Suggest Price --*/

/*-- Suggest Categories --*/
   $("#Suggest_Categories").click(function(){
      var UPC  = $("#upc").val();
      $.ajax({
      type: 'POST',
      dataType: 'json',
      url:'<?php echo base_url(); ?>listing/listing/Suggest_Categories/',
      data:{ 'UPC' : UPC},
     success: function (data) {
     
     if(data.Ack='Success' && data.CategoryCount > 0){
       if(data.CategoryCount == 1)//if result is 1 than condition is changed so this check is neccessory
      {
          $( "#Categories_result" ).html("");
          var tr='';
          //var CategoryCount = data['CategoryCount'];
         $( "#Categories_result" ).html( "<table border='1' id='category_table'> <th>Sr. No</th><th>Category ID</th><th>Category Name</th><th>Item(%)</th><th>Select</th>" );
        //for ( var i = 1; i <= data.CategoryCount; i++ ) 
        //{
          var item = data['SuggestedCategoryArray']['SuggestedCategory'];
          var CategoryID = item['Category']['CategoryID'];
          var CategoryName=item['Category']['CategoryName'];
          var PercentItemFound = item['PercentItemFound'];
          $('<tr>').html("<td>" + 1 + "</td><td>"+ CategoryID +"</td><td>" + CategoryName + "</td><td>" + PercentItemFound + "</td><td><a id='cat_"+i+"' onclick='myFunction("+1+");'> Select </a></td>").appendTo('#category_table');
        //}
       }

      if(data.CategoryCount > 1){
                $( "#Categories_result" ).html("");
                     var tr='';
               //var CategoryCount = data['CategoryCount'];
               $( "#Categories_result" ).html( "<table border='1' id='category_table'> <th>Sr. No</th><th>Category ID</th><th>Category Name</th><th>Item(%)</th><th>Select</th>" );
              for ( var i = 1; i <= data.CategoryCount; i++ ) 
              {
                
                 var item = data['SuggestedCategoryArray']['SuggestedCategory'][i-1];
                 var CategoryID = item['Category']['CategoryID'];
                 var CategoryName=item['Category']['CategoryName'];
                 var PercentItemFound = item['PercentItemFound'];
                  $('<tr>').html("<td>" + i + "</td><td>"+ CategoryID +"</td><td>" + CategoryName + "</td><td>" + PercentItemFound + "</td><td><a id='cat_"+i+"' onclick='myFunction("+i+");'> Select </a></td>").appendTo('#category_table');
              }
            }
       
     }else{
      $( "#Categories_result" ).html("No Record found");
      }
     }
     }); 
 });
/*-- End Suggest Cotegories --*/

/*-- Start select Suggested Cotegories --*/
function myFunction(i) {
    var index = i;
    var t = document.getElementById('category_table');
    //$("#category_table tr").each(function() {
    var cat_id = $(t.rows[index].cells[1]).text();
    var cat_name = $(t.rows[index].cells[2]).text();
    document.getElementById("category_id").value=cat_id;
    document.getElementById("category_name").value=cat_name;
    
    // i++;

    //});
}
/*-- End select Suggested Cotegories --*/
