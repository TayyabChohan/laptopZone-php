<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function index()
	{
		// $this->load->view('welcome_message');

$query = $this->db->query("select * from view_lz_listing");

foreach ($query->result_array() as $row)
{?>
<table>
<tr>
	<th>PICTURE</th>
	<th>TITLE</th>
	<th>MENUFACTURE</th>
	<th>MFG PART NUMBER</th>
	<th>DESCRIPTION</th>
	<th>SKU</th>
	<th>UPC</th>
	<th>CONDITION</th>
	<th>QUANTITY</th>
	<th>COST</th>
	<th>LIST QUANTITY</th>
	<th>WEIGHT</th>
	<th>RETAIL</th>
	<th>ITEM CODE</th>
	<th>LISTED</th>

</tr>
<tr>
 <?php
 $img = $row['ITEM_PIC']->load();
// $myimg = $img_id->load();
// //$foo = $MyBlob->read($MyBlob->size());
//  header("contect-type: image/jpeg");
//  echo $myimg;
//  // var_dump($myimg);
// exit;
 $pic=base64_encode($img);
 //print('<td><img src="data:image/jpeg;base64,'.$pic.'"/> </td>');
        echo "<td><img width='50px' height='50px' src='data:image/jpeg;base64,".$pic."'/></td>";
        echo "<td>".$row['TILE']."</td>";
        echo "<td>".$row['ITEM_MT_MANUFACTURE']."</td>";
        echo "<td>".$row['ITEM_MT_MFG_PART_NO']."</td>";
        echo "<td>".$row['ITEM_DESC']."</td>";
        echo "<td>".$row['ITEM_MT_BBY_SKU']."</td>";
        echo "<td>".$row['ITEM_MT_UPC']."</td>";
        echo "<td>".$row['ITEM_CONDITION']."</td>";
        echo "<td>".$row['AVAILABLE_QTY']."</td>";
        echo "<td>".$row['COST']."</td>";
        echo "<td>".$row['LIST_QTY']."</td>";
        echo "<td>".$row['WEIGHT']."</td>";
        echo "<td>".$row['RETAIL']."</td>";
        echo "<td>".$row['ITEM_CODE']."</td>";
        echo "<td>".$row['LISTED']."</td>";
        


}
?>
</tr>
</table>
<?php		
//$query = $this->db->get('SELECT * FROM ALL_TABLES WHERE UPPER(table_name) = "MANTIS_BUG_TABLE");
		//return $query->result();
		// print_r($query);

	}
}


?>
