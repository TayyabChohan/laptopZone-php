<?php $this->load->view('template/header');
ini_set('memory_limit', '-1');
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Upload Pictures
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Upload Pictures</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
		
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Upload Pictures</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <div class="row">
              <div class="col-sm-12">

<?php

require 'Cloudinary.php';
require 'Uploader.php';
require 'Api.php';

\Cloudinary::config(array( 
  "cloud_name" => "ecologix", 
  "api_key" => "567368836433995", 
  "api_secret" => "THXklWb19H_es1k6XLBF6hLI2v0" 
));


if(isset($_POST["submit"])) {


// ====== start delete single or multiple picture from cloudniary
// $api = new \Cloudinary\Api();
// $api->delete_resources(array("sample_2"));
// ====== end delete single or multiple picture from cloudniary

//===== start Image upload inside a Folder
//multiple images from a folder
//$result = $_FILES["fileToUpload"];
// $images = glob("\*.{JPG,jpg,GIF,gif,PNG,png,BMP,bmp,JPEG,jpeg}",GLOB_BRACE);
// $files = $_FILES["fileToUpload"]["tmp_name"];
//print_r($result);//exit;
for ($i = 0; $i < count($_FILES['fileToUpload']["tmp_name"]); $i++) {
	var_dump($_FILES["fileToUpload"]["tmp_name"]);
	\Cloudinary\Uploader::upload($_FILES["fileToUpload"]["tmp_name"][$i], array("folder"=>"103155"));
}
//===== end Image upload inside a Folder

//===== start Image upload local directory Folder
//D:/item_pictures/dekitted_pictures/103155/Used/A_mme8bl7zgp.jpg
\Cloudinary\Uploader::upload("D:/item_pictures/dekitted_pictures/103155/Used/A_mme8bl7zgp.jpg");
\Cloudinary\Uploader::upload("D:/item_pictures/dekitted_pictures/103155/Used/");
//===== end Image upload local directory Folder

//=====Upload single image
// \Cloudinary\Uploader::upload($_FILES["fileToUpload"]["tmp_name"],
//     array(
//        //"public_id" => "sample_2",
//        "crop" => "limit", "width" => "2000", "height" => "2000",
//        "eager" => array(
//          array( "width" => 200, "height" => 200, 
//                 "crop" => "thumb", "gravity" => "face",
//                 "radius" => 20, "effect" => "sepia" ),
//          array( "width" => 100, "height" => 150, 
//                 "crop" => "fit", "format" => "png" )
//        ),                                     
//        "tags" => array( "special", "for_homepage" )
//     ));
//====== End upload single image

//========Show image on fronend 
//echo cl_image_tag("sample.jpg", array( "alt" => "Sample Image" ));
// 


				    // $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
				    // var_dump($_FILES["fileToUpload"]);exit;
				    // if($check !== false) {
				    //     echo "File is an image - " . $check["mime"] . ".";
				    //     $uploadOk = 1;
				    // } else {
				    //     echo "File is not an image.";
				    //     $uploadOk = 0;
				    // }
}

?>

				<div class="col-sm-12">
					<div class="form-group">
						<?php echo cl_image_tag("sample_id.jpg", array("alt"=>"Sample Image", "width"=>200, "height"=>200)); ?>
						<?php echo cl_image_tag("sample_1.jpg", array("alt"=>"Sample Image", "width"=>200, "height"=>200)); ?>
						<?php echo cl_image_tag("106163/myimage.jpg", array("alt"=>"Sample Image", "width"=>200, "height"=>200)); ?>
						<?php //echo cl_image_tag("sample_2.jpg", array("alt"=>"Sample Image", "width"=>200, "height"=>200)); ?>
						<?php  //echo cl_image_tag(); ?>
					</div>
				</div>


				<form action="<?php echo base_url('listing/listing/uploadImageOnCloudinary');?>" method="post" enctype="multipart/form-data">
				    Select image to upload:
				    <div class="col-sm-6">
				    	<div class="form-group">
				    		<input type="file" multiple="multiple" name="fileToUpload[]" id="fileToUpload">
				    	</div>
				    </div>
				    <div class="col-sm-2">
				    	<div class="form-group">
				    		<input type="submit" value="Upload Image" name="submit">
				    	</div>
				    </div>
				    
				    
				</form>
              </div>
            </div>  
							

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>	
<!-- End Listing Form Data -->
<?php $this->load->view('template/footer');?>
