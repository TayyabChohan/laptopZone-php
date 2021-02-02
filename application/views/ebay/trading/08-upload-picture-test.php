<?php
use \DTS\eBaySDK\Constants;
use \DTS\eBaySDK\Trading\Services;
use \DTS\eBaySDK\Trading\Types;
use \DTS\eBaySDK\Trading\Enums;

// foreach ($pic_data as $pic)
// {
    //$image = $pic['ITEM_PIC']->load();
    //$pic_name = $pic['ITEM_PICT_DESC'];
	require __DIR__.'/../vendor/autoload.php';
    $config = require __DIR__.'/../configuration.php';

    $service = new Services\TradingService([
        'credentials' => $config['production']['credentials'],
        'production'     => true,
        'siteId'      => Constants\SiteIds::US
    ]);

    $request = new Types\UploadSiteHostedPicturesRequestType();

    /**
     * An user token is required when using the Trading service.
     */
    $request->RequesterCredentials = new Types\CustomSecurityHeaderType();
    $request->RequesterCredentials->eBayAuthToken = $config['production']['authToken'];

    /**
     * Give the picture a name.
     */
    //$request->PictureName = 'Example';
    $request->PictureName = $pic_name;
    /**
     * Attach the picture that we want to upload.
     * Specifying the mime type is optional. Defaults to application/octet-stream if none is provided.
     */
    //$request->attachment($image, 'image/jpeg');
    $request->attachment($image);

    /**
     * Send the request.
     */
    $response = $service->uploadSiteHostedPictures($request);

    /**
     * Output the result of calling the service operation.
     */
    if (isset($response->Errors)) {
        foreach ($response->Errors as $error) {

            echo "<div class='col-sm-12'><div id='errorMsg' class='text-danger'>". $error->SeverityCode === Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning'."<br>".$error->ShortMessage."<br>".$error->LongMessage."</div></div>";
            // printf(
            //     "%s: %s\n%s\n\n",
            //     $error->SeverityCode === Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
            //     $error->ShortMessage,
            //     $error->LongMessage
            // );
        }
    }

    if ($response->Ack !== 'Failure') 
    {
        $ack        = $response->Ack;
        $picNameOut = $response->SiteHostedPictureDetails->PictureName;
        $picURL[]     = $response->SiteHostedPictureDetails->FullURL;

	}
//}


