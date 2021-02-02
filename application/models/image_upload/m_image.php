<?php 

	/**
	* Image Upload Model
	*/
	class M_Image extends CI_Model
	{

		public function __construct(){
		parent::__construct();
		$this->load->database();
	}
		
	public function delete($id){
		 $con =  oci_connect('laptop_zone', 's', 'wizmen-pc/ORCL') or die ('Error connecting to oracle');
		 
		 $qry = "DELETE FROM ITEM_PICTURES_MT WHERE ITEM_PICTURE_ID = $id";
		  $result = oci_parse($con,$qry);
		  $result = oci_execute($result, OCI_DEFAULT);
		  //die(oci_execute($result, OCI_DEFAULT));
		  if($result){
		     oci_commit($con);
		    echo "Image deleted.";
		  }
		  else{
		     oci_rollback($con);
		    echo "Image not deleted.";
  }

	}

	public function delete_all($item_id,$manifest_id){
		 $con =  oci_connect('laptop_zone', 's', 'wizmen-pc/ORCL') or die ('Error connecting to oracle');
		 
		 $qry = "DELETE FROM item_pictures_mt WHERE item_id = $item_id and lz_manifest_id = $manifest_id";
		  $result = oci_parse($con,$qry);
		  $result = oci_execute($result, OCI_DEFAULT);
		  //die(oci_execute($result, OCI_DEFAULT));
		  if($result){
		     oci_commit($con);
		    echo "Image deleted.";
		  }
		  else{
		     oci_rollback($con);
		    echo "Image not deleted.";
  }

	}	

		public function save($name,$image,$item_id,$manifest_id,$srno){
 


 $con =  oci_connect('laptop_zone', 's', 'wizmen-pc/ORCL') or die ('Error connecting to oracle');		
		//---------- START CREATING ITEM PICTURE ID -------------//
		$query = "SELECT MAX(ITEM_PICTURE_ID) AS PIC_ID FROM ITEM_PICTURES_MT";
					$rsl = oci_parse($con, $query);

					$reslt=oci_execute($rsl, OCI_DEFAULT);	
					$row = oci_fetch_array($rsl,OCI_NUM);

					if(@$row[0]== 0){$pic_id = 1;}else{$pic_id = $row[0]+1;}

		//---------- END CREATING ITEM PICTURE ID -------------//

		//---------- STRAT CHECKING IF ITEM ALREADY EXSIST -------------//			
		  $check = "SELECT * FROM ITEM_PICTURES_MT WHERE ITEM_ID = $item_id AND LZ_MANIFEST_ID = $manifest_id";
		  //$check = "SELECT * FROM ITEM_PICTURES_MT WHERE ITEM_PICT_DESC = '$name'";
		  $rs = oci_parse($con, $check);
		  @oci_execute($rs, OCI_DEFAULT);
		  $data = @oci_fetch_array($rs, OCI_NUM);
		 // print_r($data);exit;
		  if(@!empty($data)) {
		    //die("IF Upload called");
		    //echo ($name . " " . "Image already exists.\n");
				$query = "SELECT MAX(SRNO) AS PIC_SRNO FROM ITEM_PICTURES_MT WHERE ITEM_ID = $item_id AND LZ_MANIFEST_ID = $manifest_id";
				$rsl = oci_parse($con, $query);
				$reslt=oci_execute($rsl, OCI_DEFAULT);	
				$row = oci_fetch_array($rsl,OCI_NUM);

				if(@$row[0]== 0){$PIC_SRNO = 1;}else{$PIC_SRNO = $row[0]+1;}

				 $lob = oci_new_descriptor($con, OCI_D_LOB);
		    $qry = "INSERT INTO ITEM_PICTURES_MT (ITEM_PICTURE_ID,ITEM_PICT_DESC,ITEM_ID,SRNO,ITEM_PIC,LZ_MANIFEST_ID) VALUES(:ID,:DESCRIPTION,:ITEMID,:SRNO, empty_blob(),:LZ_MANIFEST_ID) RETURNING ITEM_PIC INTO :blobbind";
		    $result = oci_parse($con, $qry);
		      // var_dump($result);exit;
		    oci_bind_by_name($result,':ID', $pic_id);
		    oci_bind_by_name($result,':DESCRIPTION', $name);
		    oci_bind_by_name($result,':ITEMID', $item_id);
		    oci_bind_by_name($result,':SRNO', $PIC_SRNO);
		    oci_bind_by_name($result,':blobbind', $lob, -1, OCI_B_BLOB);
		    oci_bind_by_name($result,':LZ_MANIFEST_ID', $manifest_id);
		    oci_execute($result, OCI_DEFAULT);

		   
		    if(!$lob->save($image)) {
		        oci_rollback($con);
		    }
		    else {
		        oci_commit($con);
		    }

		    oci_free_statement($result);
		    $lob->free();
		  } //---------- END CHECKING IF ITEM ALREADY EXSIST  -------------//
		  else{

	  		
		    $lob = oci_new_descriptor($con, OCI_D_LOB);
		    $qry = "INSERT INTO ITEM_PICTURES_MT (ITEM_PICTURE_ID,ITEM_PICT_DESC,ITEM_ID,SRNO,ITEM_PIC,LZ_MANIFEST_ID) VALUES(:ID,:DESCRIPTION,:ITEMID,:SRNO, empty_blob(),:LZ_MANIFEST_ID) RETURNING ITEM_PIC INTO :blobbind";
		    $result = oci_parse($con, $qry);
		      // var_dump($result);exit;
		    oci_bind_by_name($result,':ID', $pic_id);
		    oci_bind_by_name($result,':DESCRIPTION', $name);
		    oci_bind_by_name($result,':ITEMID', $item_id);
		    oci_bind_by_name($result,':SRNO', $srno);
		    oci_bind_by_name($result,':blobbind', $lob, -1, OCI_B_BLOB);
		    oci_bind_by_name($result,':LZ_MANIFEST_ID', $manifest_id);
		    oci_execute($result, OCI_DEFAULT);

		   
		    if(!$lob->save($image)) {
		        oci_rollback($con);
		    }
		    else {
		        oci_commit($con);
		    }

		    oci_free_statement($result);
		    $lob->free();


		    //$qry="insert into images (img_name,image) values ('$name','$image')";

		    // $result=oci_parse($con,$qry);
		    // if($result){
		    //   echo ($name . " " . "Image uploaded.\n");
		    // }
		    // else{
		    //   echo ($name . " " . "Image not uploaded.\n");
		    // }
		  }
		  oci_close($con);
		  $seed_history=$this->session->userdata('seed_history');
		  if($seed_history){
		  	$this->session->unset_userdata('seed_history');
			}
		}
		
		public function displayimage($ID){

		$con =  oci_connect('laptop_zone', 's', 'wizmen-pc/ORCL') or die ('Error connecting to oracle');

           $query = $this->db->query("SELECT * FROM ITEM_PICTURES_MT WHERE ITEM_ID = '$ID' order by SRNO");
    	return $query->result();

        if($query->num_rows() > 0){
    	return $query->result();
		}
            // $result = oci_parse($con,$qry);
            // $query = oci_execute($result);
            //var_dump($query);
            
            // $values = oci_num_rows($result);
            //var_dump($values);
            //exit;
           
            oci_close($con);
                          
         }

         public function update_order($sortable){
        	$i = 1;
        	foreach($sortable as $sort_id){
        		//$query = $this->db->query("UPDATE FROM ITEM_PICTURES_MT SET SRNO = $i WHERE ITEM_PICTURE_ID = $sort_id");
        		$this->db->set('SRNO', $i);
        		$this->db->where('ITEM_PICTURE_ID', $sort_id);
				$this->db->update('ITEM_PICTURES_MT');
        		//$this->db->get();
	

        		$i++;
			}


         }                             

		
	}




 ?>