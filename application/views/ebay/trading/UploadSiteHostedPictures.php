<?php
/*  © 2013 eBay Inc., All Rights Reserved */ 
/* Licensed under CDDL 1.0 -  http://opensource.org/licenses/cddl1.php */
?>
<!-- <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<TITLE>UploadSiteHostedPictures</TITLE>
</HEAD>
<BODY> -->

<?php    
 require __DIR__.'/../configuration.php';
    

    $siteID  = 0;                            // siteID needed in request - US=0, UK=3, DE=77...
    $verb    = 'UploadSiteHostedPictures';   // the call being made:
    $version = 517;                          // eBay API version
    
    //$file      = 'ebay-logo.jpg';       // image file to read and upload
    $picNameIn = $pic_name;
    $multiPartImageData = $image;
    //$handle = fopen($file,'r');         // do a binary read of image
    //$multiPartImageData = fread($handle,filesize($file));
   // fclose($handle);

    ///Build the request XML request which is first part of multi-part POST
    $xmlReq = '<?xml version="1.0" encoding="utf-8"?>' . "\n";
    $xmlReq .= '<' . $verb . 'Request xmlns="urn:ebay:apis:eBLBaseComponents">' . "\n";
    $xmlReq .= "<Version>$version</Version>\n";
    $xmlReq .= "<PictureName>$picNameIn</PictureName>\n";    
    $xmlReq .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>\n";
    $xmlReq .= '</' . $verb . 'Request>';

    $boundary = "MIME_boundary";
    $CRLF = "\r\n";
    
    // The complete POST consists of an XML request plus the binary image separated by boundaries
    $firstPart   = '';
    $firstPart  .= "--" . $boundary . $CRLF;
    $firstPart  .= 'Content-Disposition: form-data; name="XML Payload"' . $CRLF;
    $firstPart  .= 'Content-Type: text/xml;charset=utf-8' . $CRLF . $CRLF;
    $firstPart  .= $xmlReq;
    $firstPart  .= $CRLF;
    
    $secondPart = "--" . $boundary . $CRLF;
    $secondPart .= 'Content-Disposition: form-data; name="dummy"; filename="dummy"' . $CRLF;
    $secondPart .= "Content-Transfer-Encoding: binary" . $CRLF;
    $secondPart .= "Content-Type: application/octet-stream" . $CRLF . $CRLF;
    $secondPart .= $multiPartImageData;
    $secondPart .= $CRLF;
    $secondPart .= "--" . $boundary . "--" . $CRLF;
    
    $fullPost = $firstPart . $secondPart;
    
    // Create a new eBay session (defined below) 
    $session = new eBaySession($userToken, $devID, $appID, $certID, false, $version, $siteID, $verb, $boundary);

    $respXmlStr = $session->sendHttpRequest($fullPost);   // send multi-part request and get string XML response
    
    if(stristr($respXmlStr, 'HTTP 404') || $respXmlStr == '')
        die('<P>Error sending request');
        
    $respXmlObj = simplexml_load_string($respXmlStr);     // create SimpleXML object from string for easier parsing
                                                          // need SimpleXML library loaded for this
    /* Returned XML is of form 
      <?xml version="1.0" encoding="utf-8"?>
      <UploadSiteHostedPicturesResponse xmlns="urn:ebay:apis:eBLBaseComponents">
        <Timestamp>2007-06-19T16:53:50.370Z</Timestamp>
        <Ack>Success</Ack>
        <Version>517</Version>
        <Build>e517_core_Bundled_4784308_R1</Build>
        <PictureSystemVersion>2</PictureSystemVersion>
        <SiteHostedPictureDetails>
          <PictureName>my_pic</PictureName>
          <PictureSet>Standard</PictureSet>
          <PictureFormat>JPG</PictureFormat>
          <FullURL>http://i21.ebayimg.com/06/i/000/a5/e9/0e60_1.JPG?set_id=7</FullURL>
          <BaseURL>http://i21.ebayimg.com/06/i/000/a5/e9/0e60_</BaseURL>
          <PictureSetMember>...</PictureSetMember>
          <PictureSetMember>...</PictureSetMember>
          <PictureSetMember>...</PictureSetMember>
        </SiteHostedPictureDetails>
      </UploadSiteHostedPicturesResponse>
    */
    
    $ack        = $respXmlObj->Ack;
    $picNameOut = $respXmlObj->SiteHostedPictureDetails->PictureName;
    $pictureURL = $respXmlObj->SiteHostedPictureDetails->FullURL;
    $picURL[] = (string)$pictureURL; // string cast to remove the error  Expected string but got SimpleXMLElement
    
    // print "<P>Picture Upload Outcome : $ack </P>\n";
    // print "<P>picNameOut = $picNameOut </P>\n";
    // print "<P>picURL = $picURL</P>\n";
    // print "<IMG SRC=\"$picURL\">";
    // exit;
?>
<!-- </BODY>
</HTML> -->


<?php
// This is a modified version of the 'eBaySession' class which is used in many
// of the other PHP samples.  This has been modified to accomodate multi-part HttpRequests

    
?>
