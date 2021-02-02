<html>
  <head>
    <title>eBay Search Results</title>
    <style type="text/css"> body { font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; } h1 { color: #777; font-weight: normal; font-size: 24px; margin: 0; margin-left: 5px; } tr { border-bottom: 1px solid #CCC; padding: 15px 0; display: block; } .image-container { text-align: center; border: 1px solid #CCC; width: 150px; } .data-container { vertical-align: top; padding-left: 15px; } p { margin: 0 0 5px; } .item-link, .item-link:hover, .item-link:visited, .item-link:active { text-decoration: none; color: #333; } .title { color: #5786bd; font-weight: bold; margin-bottom: 10px; } .subtitle { color: #777; font-size: 12px; } .price { color: #333; font-weight: bold; } .bin { color: #777; font-size: 12px; } .fs { font-size: 12px; font-weight: bold; } </style>
  </head>
  <body>
    <h1>eBay Search Results</h1>
    <div id="results"></div>
    <script> function _cb_findItemsByKeywords(root) { var items = root && root.findItemsByKeywordsResponse && root.findItemsByKeywordsResponse[0] && root.findItemsByKeywordsResponse[0].searchResult && root.findItemsByKeywordsResponse[0].searchResult[0] && root.findItemsByKeywordsResponse[0].searchResult[0].item || []; var html = []; html.push('
      <table width="100%" border="0" cellspacing="0" cellpadding="3">
        <tbody>'); for (var i = 0; i < items.length; ++i) { var item = items[i]; var shippingInfo = item.shippingInfo && item.shippingInfo[0] || {}; var sellingStatus = item.sellingStatus && item.sellingStatus[0] || {}; var listingInfo = item.listingInfo && item.listingInfo[0] || {}; var title = item.title; var subtitle = item.subtitle || ''; var pic = item.galleryURL; var viewitem = item.viewItemURL; var currentPrice = sellingStatus.currentPrice && sellingStatus.currentPrice[0] || {}; var displayPrice = currentPrice['@currencyId'] + ' ' + currentPrice['__value__']; var buyItNowAvailable = listingInfo.buyItNowAvailable && listingInfo.buyItNowAvailable[0] === 'true'; var freeShipping = shippingInfo.shippingType && shippingInfo.shippingType[0] === 'Free'; if (null !== title && null !== viewitem) { html.push('
          <tr>
            <td class="image-container">
              <img src="' + pic + '"border = "0">
              </td>'); html.push('
              <td class="data-container">
                <a class="item-link" href="' + viewitem + '"target="_blank">'); html.push('
                  <p class="title">' + title + '</p>'); html.push('
                  <p class="subtitle">' + subtitle + '</p>'); html.push('
                  <p class="price">' + displayPrice + '</p>'); if (buyItNowAvailable) { html.push('
                  <p class="bin">Buy It Now</p>'); } if (freeShipping) { html.push('
                  <p class="fs">Free shipping</p>'); } html.push('
                </a>
              </td>
            </tr>'); } } html.push(" 
          </tbody>
        </table>"); document.getElementById("results").innerHTML = html.join(""); } 
      </script>
    </body>
  </html>