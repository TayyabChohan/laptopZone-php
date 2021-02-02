<?php

class c_rssfeed extends CI_Controller{
	public function __construct(){
	      parent::__construct();
	      $this->load->database();
	      $this->load->model('rssFeed/m_rssfeed');
        $this->load->helper('security');
	      /*=============================================
        =  Section lz_bigData db connection block  =
        =============================================*/
        $CI = &get_instance();
        //setting the second parameter to TRUE (Boolean) the function will return the database object.
        $this->db2 = $CI->load->database('bigData', TRUE);
        // $qry = $this->db2->query("SELECT * FROM lz_bd_category");
        // print_r($qry->result());exit;

        /*=====  End of Section lz_bigData db connection block  ======*/	
	      if(!$this->loginmodel->is_logged_in())
	       {
	         redirect('login/login/');
	       }      

	     // $this->load->model('manifest_loading/csv_model');
  	}

  	public function index(){
      //$this->output->delete_cache();
      //$this->load->library('my_output');
      //$this->output->nocache();
      //$this->load->library('rssparser');
  		$result['pageTitle'] = 'eBay RSS Feed';
      $result['data'] = $this->m_rssfeed->loadData();
      //$result['data'] = $this->m_rssfeed->loadMultipleData();
     // $result['data'] = $this->m_rssfeed->loadDynamicData();
      $this->load->view('rssfeed/v_rssFeed',$result);
  	}
    /*==============================================================
    =            tem function added for testing purpose            =
    ==============================================================*/
        public function verified_rssfeed(){
      //$this->output->delete_cache();
      //$this->load->library('my_output');
      //$this->output->nocache();
      //$this->load->library('rssparser');
      $result['pageTitle'] = 'eBay RSS Feed';
      $result['data'] = $this->m_rssfeed->verified_rssfeed();
      //$result['data'] = $this->m_rssfeed->loadMultipleData();
     // $result['data'] = $this->m_rssfeed->loadDynamicData();
        $this->load->view('rssfeed/v_rssFeed_verified',$result);
    }
    
    
    /*=====  End of tem function added for testing purpose  ======*/
    public function get_item(){
      $data = $this->m_rssfeed->get_item();
      echo json_encode($data);
      return json_encode($data);
    }
    public function fetch_rss_feed(){
      //$this->output->nocache();
      $this->load->library('rssparser');
      $result['pageTitle'] = 'eBay RSS Feed';
      $data = $this->m_rssfeed->fetch_rss_feed();
      echo json_encode($data);
      return json_encode($data);
    }
    public function update_rss_feed(){
      //$this->output->nocache();
      //$this->load->library('rssparser');
      //$result['pageTitle'] = 'eBay RSS Feed';
      $data = $this->m_rssfeed->update_rss_feed();
      echo json_encode($data);
      // ob_get_flush();
      // flush();
      return json_encode($data);
    }  
    public function update_lookup_feed(){
      $data = $this->m_rssfeed->update_lookup_feed();
      echo json_encode($data);
      return json_encode($data);
    } 
    public function updateAutoBuy(){
      $data = $this->m_rssfeed->updateAutoBuy();
      echo json_encode($data);
      return json_encode($data);
    } 
    public function updateAutoBIN(){
      $data = $this->m_rssfeed->updateAutoBIN();
      echo json_encode($data);
      return json_encode($data);
    } 
    public function updateAutoBuyAuction(){
      $data = $this->m_rssfeed->updateAutoBuyAuction();
      echo json_encode($data);
      return json_encode($data);
    }
    public function updateCatAuction(){
      $data = $this->m_rssfeed->updateCatAuction();
      echo json_encode($data);
      return json_encode($data);
    }
    public function update_local_feed(){
      $data = $this->m_rssfeed->update_local_feed();
      echo json_encode($data);
      return json_encode($data);
    }    
    public function commet_ajax(){
      //$this->output->nocache();
      //$this->load->library('rssparser');
      //$result['pageTitle'] = 'eBay RSS Feed';
      $data = $this->m_rssfeed->commet_ajax();
      echo json_encode($data);
    //flush();
      return json_encode($data);
    }  
    public function discard_item(){
      $data = $this->m_rssfeed->discard_item();
      echo json_encode($data);
      return json_encode($data);
    }
    public function fesibility_index(){
      $result['data'] = $this->m_rssfeed->fesibility_index();
      $this->load->view('catalogueToCash/v_fesibility_index',$result);   
    }
    public function qty_detail(){
      $data = $this->m_rssfeed->qty_detail();
      echo json_encode($data);
      return json_encode($data);
    }


  public  function loaddata()
  {
   header("Content-Type: text/event-stream");
   header("Cache-Control: no-cache");
   header("Connection: keep-alive");
    
  // $this->load->model('m_sse');
   while(true)
   {
    $data=$this->m_rssfeed->update_rss_feed_test();
    $this->load->view('rssfeed/v_rssfeed_test',$data);
    sleep(1);
   }
  }

    /*=====================================
    =            Yosaf methods            =
    =====================================*/
     public function addRssFeedUrl(){
      $result['data']         = $this->m_rssfeed->getCategories();
      $result['conditions']   = $this->m_rssfeed->rss_conditions();
      $result['listings']     = $this->m_rssfeed->rss_listings();
      $result['pageTitle']    = 'Add RSS Feed URL';
      $this->load->view('rssFeed/v_addRssFeedUrl',$result); 
    }
    public function loadAddRssFeedUrl(){
      //echo "imran"; exit;
      $data = $this->m_rssfeed->loadRssUrls();
      echo json_encode($data);
      return json_encode($data); 
    }

    public function loadRssUrls(){
      $data = $this->m_rssfeed->loadRssUrls();
      echo json_encode($data);
      return json_encode($data); 
    }
    public function updateRssUrls(){
      $data = $this->m_rssfeed->updateRssUrls();
      echo json_encode($data);
      return json_encode($data); 
    }

    public function getMpns(){
      $data = $this->m_rssfeed->getMpns();
      echo json_encode($data);
      return json_encode($data);      
    }
    public function saveMpn(){
      $data = $this->m_rssfeed->saveMpn();
      echo json_encode($data);
      return json_encode($data);      
    }
    public function addRssUrls(){
      $data = $this->m_rssfeed->addRssUrls();
      echo json_encode($data);
      return json_encode($data);

    }
    
    
    /*=====  End of Yosaf methods  ======*/

    /*======================================
    =            Faisal Methods            =
    ======================================*/
    public function CatFilter(){

      $result['pageTitle'] = 'Search - eBay RSS Feed';
      $result['data'] = $this->m_rssfeed->filterDataCategories();
      $this->load->view('rssfeed/v_rssFeed',$result);

    } 
    public function CatFilterLookupFeed(){

      $result['pageTitle'] = 'Search - eBay Hot RSS Feed';
      $result['data'] = $this->m_rssfeed->CatFilterLookupFeed();
      $this->load->view('rssfeed/v_hotRssFeed',$result);

    }
    public function CatFiltercatAuction(){

      $result['pageTitle'] = 'Search - Main Category Auction';
      $result['data'] = $this->m_rssfeed->CatFiltercatAuction();
      $this->load->view('rssfeed/v_catAuctionFilter',$result);

    }       
    public function hotRssFeed(){

      $result['pageTitle'] = 'eBay Hot RSS Feed';
      $result['data'] = $this->m_rssfeed->hotRssFeed();
      $this->load->view('rssfeed/v_hotRssFeed',$result);

    }
    public function lookupFeed(){
      //var_dump('function call');
      //exit;
      $result['pageTitle'] = 'eBay Lookup Feed';
      $result['data'] = $this->m_rssfeed->lookupFeed();
      $this->load->view('rssfeed/v_lookupFeed',$result);

    }
    public function autoBuy(){
      //var_dump('function call');
      //exit;
      $result['pageTitle'] = 'Auto Buy item';
      $result['data'] = $this->m_rssfeed->autoBuy();
      $this->load->view('rssfeed/v_autoBuy',$result);

    }
    public function autoBuyAuction(){
      //var_dump('function call');
      //exit;
      $result['pageTitle'] = 'Auto Buy Auction item';
      $result['data'] = $this->m_rssfeed->autoBuyAuction();
      $this->load->view('rssfeed/v_autoBuyAuction',$result);

    }
    public function catAuction(){
      //var_dump('function call');
      //exit;
      $result['pageTitle'] = 'Main Cateogry Auction item';
      $result['data'] = $this->m_rssfeed->catAuction();
      $this->load->view('rssfeed/v_catAuction',$result);

    }
    public function autoBIN(){
      //var_dump('function call');
      //exit;
      $result['pageTitle'] = 'Auto Purchased Item';
      $result['data'] = $this->m_rssfeed->autoBIN();
      $this->load->view('rssfeed/v_autoBIN',$result);

    }
    //By Danish
public function loadlookupfeed(){
  $data = $this->m_rssfeed->loadlookupfeed();
    echo json_encode($data);
    return json_encode($data);
  }
  public function loadAutoBuy(){
  $data = $this->m_rssfeed->loadAutoBuy();
    echo json_encode($data);
    return json_encode($data);
  }
  public function loadAutoBIN(){
  $data = $this->m_rssfeed->loadAutoBIN();
    echo json_encode($data);
    return json_encode($data);
  }
  public function loadAutoBuyAuction(){
  $data = $this->m_rssfeed->loadAutoBuyAuction();
    echo json_encode($data);
    return json_encode($data);
  }
  public function loadCatAuction(){
  $data = $this->m_rssfeed->loadCatAuction();
    echo json_encode($data);
    return json_encode($data);
  }
  public function loadCatAuctionFilter(){
  $data = $this->m_rssfeed->loadCatAuctionFilter();
    echo json_encode($data);
    return json_encode($data);
  }
    //
    public function getMpnPrice(){
      $data = $this->m_rssfeed->getMpnPrice();
      echo json_encode($data);
      return json_encode($data); 

    }
    /*=====  End of Faisal Methods  ======*/
    public function hotSellingItem(){
        $data = $this->m_rssfeed->hotSellingItem();
        echo json_encode($data);
        return json_encode($data); 
    }
    
    public function checkFeed(){
        $data = $this->m_rssfeed->checkFeed();
        echo json_encode($data);
        return json_encode($data); 
    }
    public function delRssURL(){
        $data = $this->m_rssfeed->delRssURL();
        echo json_encode($data);
        return json_encode($data); 
    }
    public function checkout($ebay_id){
      //var_dump($ebay_id);exit;
      if(!empty($ebay_id)){
        $this->m_rssfeed->checkout($ebay_id);
        $data['ebay_id'] =  $ebay_id;
        $this->load->view('eBayCheckout/v_ebayCheckout',$data);
      }
        
    }
    public function update_feed_url(){
        $data = $this->m_rssfeed->update_feed_url();
        echo json_encode($data);
        return json_encode($data); 
    }
    public function updateUrl(){
        $data = $this->m_rssfeed->updateUrl();
        echo json_encode($data);
        return json_encode($data); 
    }
    public function localFeed(){
      $result['pageTitle'] = 'Local | Dallas Feed';
      $result['data'] = $this->m_rssfeed->localFeed();
      $this->load->view('rssfeed/v_localFeed',$result);

    }
    //By Danish
   public function loadlocalfeed(){
  $data = $this->m_rssfeed->loadlocalfeed();
    echo json_encode($data);
    return json_encode($data);
  }
    //end Danish 
    public function categoryFeed(){
      $result['pageTitle'] = 'Category Feed';
      $result['data'] = $this->m_rssfeed->categoryFeed();
      $this->load->view('rssfeed/v_categoryFeed',$result);
    }
  //by Danish 


  public function loadcategoryfeed(){
  $data = $this->m_rssfeed->loadcategoryfeed();
    echo json_encode($data);
    return json_encode($data);
  }

    //end danish 


    public function update_category_feed(){
      $data = $this->m_rssfeed->update_category_feed();
      echo json_encode($data);
      return json_encode($data);
    }
    public function getCats(){
      $data = $this->m_rssfeed->getCategories();
      echo json_encode($data);
      return json_encode($data);
    }
    public function delAllStream(){
      $data = $this->m_rssfeed->delAllStream();
      echo json_encode($data);
      return json_encode($data);
    }
    public function similarFeed(){
      $result['pageTitle'] = 'Similar Feed';
      //$result['data'] = $this->m_rssfeed->categoryFeed();
      $this->load->view('rssfeed/v_similarFeed',$result);
    }
    public function loadSimilarFeed(){
      $data = $this->m_rssfeed->loadSimilarFeed();
      echo json_encode($data);
      return json_encode($data);
    }
    public function markedAsView(){
      $data = $this->m_rssfeed->markedAsView();
      echo json_encode($data);
      return json_encode($data);
    }
    
 }