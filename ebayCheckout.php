<?php

/* following configration need to be configured before running this code

1- install this extention from chrome store using the bellow given url
extention name: Ignore X-Frame headers
extention URL : https://chrome.google.com/webstore/detail/ignore-x-frame-headers/gleekbfjekiniecknbkamfmkohkpodhe

2- you need to disable-web-security of chrome to run this code
to disable-web-security run the following line in run window
chrome.exe --user-data-dir="C://Chrome dev session" --disable-web-security


Note:
some info about Ignore X-Frame headers
https://gist.github.com/dergachev/e216b25d9a144914eae2
*/
?>

<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
  
  function onLoadHandler() {
  document.getElementById("test_frame").contentDocument.getElementById("cta-btn").click();
}
</script>

</head>
<body>

<iframe id="test_frame" src="<?php echo 'https://pay.ebay.com/xo?action=create&rypsvc=true&pagename=ryp&TransactionId=-1&item='.$_GET['ebay_id'].'&quantity=1'; ?>" height="800" width="1500" target="_parent" onload="onLoadHandler();"> 

</iframe>

</body>
</html>
