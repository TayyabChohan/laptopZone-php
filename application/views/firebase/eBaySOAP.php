<?php
/*  © 2013 eBay Inc., All Rights Reserved */ 
/* Licensed under CDDL 1.0 -  http://opensource.org/licenses/cddl1.php */
?>
<?php
// Configuration class to handle settings
class eBaySession {
	protected $properties;

	const URL_PRODUCTION = 'https://api.ebay.com/wsapi';
	const URL_SANDBOX    = 'https://api.sandbox.ebay.com/wsapi';

 	public function __construct($dev, $app, $cert) {
		$this->properties = array(
			'dev'      => null,
			'app'      => null,
			'cert'     => null,
			'wsdl'     => null,
			'options'  => null,
			'token'    => null,
			'userid'   => null,
			'password' => null,
			'site'     => null,
			'location' => null,
			'ns'       => null,
			'version'  => null,
			'runame'   => null,
		);

		$this->dev = $dev;
		$this->app = $app;
		$this->cert = $cert;
	
		$this->wsdl = 'http://developer.ebay.com/webservices/latest/eBaySvc.wsdl';
#		$this->wsdl = './eBaySvc.wsdl';
		$this->options = array('trace' => true, 
		                       'exceptions' => false,
		                       'classmap' => array(/* 'UserType' => 'eBayUserType', */
		                                           'GetSearchResultsResponseType' => 'eBayGetSearchResultsResponseType',
		                                           'SearchResultItemArrayType' => 'eBaySearchResultItemArrayType',
		                                           'SearchResultItemType' => 'eBaySearchResultItemType',
		                                           'AmountType' => 'eBayAmountType',
		                                           'FeeType' => 'eBayFeeType',
		                                           'FeesType' => 'eBayFeesType',
		                                           'PaginatedItemArrayType' => 'eBayPaginatedItemArrayType',
		                                           'ItemArrayType' => 'eBayItemArrayType',
		                                           'ItemType' => 'eBayItemType',
		                                           'NameValueListArrayType' => 'eBayNameValueListArrayType',
		                                           'NameValueListType' => 'eBayNameValueListType',
		                                           'PictureDetailsType' => 'eBayPictureDetailsType',
		                                          ),
#		                       'compression' => SOAP_COMPRESSION_ACCEPT,
		                      );

		$this->ns = 'urn:ebay:apis:eBLBaseComponents';
		$this->version = 501; // should pull this from the WSDL
	}

	public function __set($property, $value) {
		 if (array_key_exists($property, $this->properties)) {
		    $this->properties[$property] = $value;
		 }
	}

	public function __get($property) {
		 if (array_key_exists($property, $this->properties)) {
		    return $this->properties[$property];
		 } else {
		    return null;
		 }
	}

	public function __isset($property) {
		 return array_key_exists($property, $this->properties);
	}

}

// Main class for communication with eBay Web services via SOAP
class eBaySOAP extends SoapClient {
	protected $headers = null;
	protected $session = null;

	public function __construct(eBaySession $session) {
		$this->session = $session;
		$this->__setHeaders();
		parent::__construct($session->wsdl, $session->options);
	}

	protected function __setHeaders() {
		$eBayAuth = $this->__geteBayAuth($this->session);
		$header_body = new SoapVar($eBayAuth, SOAP_ENC_OBJECT);
		$headers = array(new SOAPHeader($this->session->ns, 'RequesterCredentials', $header_body));
	
		$this->headers = $headers;
	}

	protected function __geteBayAuth(eBaySession $session) {
		$credentials = array();
		$eBayAuth = array();
		
		$credentials['AppId'] = new SoapVar($session->app, XSD_STRING, null, null, null, $session->ns);
		$credentials['DevId'] = new SoapVar($session->dev, XSD_STRING, null, null, null, $session->ns);
		$credentials['AuthCert'] = new SoapVar($session->cert, XSD_STRING, null, null, null, $session->ns);
		if (isset($session->userid) && ($session->userid != null)) {
			$credentials['Username'] = new SoapVar($session->userid, XSD_STRING, null, null, null, $session->ns);
		}
		if (isset($session->password) && ($session->password != null)) {
			$credentials['Password'] = new SoapVar($session->password, XSD_STRING, null, null, null, $session->ns);
		}

		if (isset($session->token)) {
			$eBayAuth['eBayAuthToken'] = new SoapVar($session->token, XSD_STRING, null, null, null, $session->ns);
		}
		$eBayAuth['Credentials'] = new SoapVar($credentials, SOAP_ENC_OBJECT, null, null, null, $session->ns);

		return $eBayAuth;
	}

 	public function __call($function, $args) {
		if (empty($args[0]['Version'])) {
			$args[0]['Version'] = $this->session->version;
		}

		$callname = $function;
		$siteid = $this->session->site;
		$version = $args[0]['Version'];
		$appid = $this->session->app;
		$Routing = 'default'; // XXX: hardcoded

		$query_string = http_build_query(array('callname' => $callname, 'siteid' => $siteid, 'version' => $version, 'appid' => $appid, 'Routing' => $Routing));
	 	$location = "{$this->session->location}?{$query_string}";

 		return $this->__soapCall($function, $args, array('location' => $location), $this->headers);
 	}
}

class eBayPlatformNotifications {
	protected $session = null;
	protected $debug;

	public function __construct(eBaySession $session, $debug = false) {
		$this->session = $session;
		$this->debug = $debug;
	}

	protected function carp($string) {
		$me = get_class($this);
		if ($this->debug) { error_log("$me: $string"); }
	}

	protected function CalculateSignature($Timestamp) {
		$DevID = $this->session->dev;
		$AppID = $this->session->app;
		$Cert  = $this->session->cert;

		$hash = "{$Timestamp}{$DevID}{$AppID}{$Cert}";
		$this->carp($hash);
		// Not quite sure why we need the pack('H*'), but we do
		$Signature = base64_encode(pack('H*', md5($hash)));
		return $Signature;
	}
}



// General utility class. Currently not used.
class eBayUtils {
	static public function findByName($values, $name) {
		foreach($values as $value) {
			if ($value->Name == $name) {
				return $value;
			}
		}
	}
}

// The following classes are used in the classmap array
// Right now, they are largely experiments to see how I can make it easier to use the API
class eBayFeesType implements ArrayAccess {
	public function offsetExists($offset) {
		foreach ($this->Fee as $value) {
			if ($value->Name == $offset) {
				return true;
			}
		}

		return false;
	}

	public function offsetGet($offset) {
		foreach ($this->Fee as $value) {
			if ($value->Name == $offset) {
				return $value;
			}
		}
	}

	public function offsetSet($offset, $value) {
		return true;
	}

	public function offsetUnset($offset) {
		return true;
	}

}

// The following classes are used in the classmap array
// Right now, they are largely experiments to see how I can make it easier to use the API
class eBayNameValueListType implements ArrayAccess { 
	public function offsetExists($offset) {
		return true;
	}

	public function offsetGet($offset) {
		foreach ($this->Fee as $value) {
			if ($value->Name == $offset) {
				return $value;
			}
		}
	}

	public function offsetSet($offset, $value) {
		return true;
	}

	public function offsetUnset($offset) {
		return true;
	}

}


class eBayFeeType {
	public function __toString() {
		return (string) $this->Fee->_;
	}
}
class eBayPaginatedItemArrayType implements IteratorAggregate {
	public function getIterator( ) {
        return $this->ItemArray;
    }
	
}


class eBayItemArrayType implements IteratorAggregate {
	public function getIterator( ) {
        return new ArrayObject($this->Item);
    }
	
}


class eBayGetSearchResultsResponseType implements IteratorAggregate {
	public function getIterator( ) {
        return $this->SearchResultItemArray;
    }
	
}

class eBaySearchResultItemArrayType implements IteratorAggregate {
	public function getIterator() {
		// put this in __wakeUp()
		if (!is_array($this->SearchResultItem)) {
			$this->SearchResultItem = array($this->SearchResultItem);
		}

        return new ArrayObject($this->SearchResultItem);
    }
}

class eBayPictureDetailsType implements IteratorAggregate {
	public function getIterator() {
		// put this in __wakeUp()
		if (!is_array($this->PictureURL)) {
			$this->PictureURL = array($this->PictureURL);
		}

        return new ArrayObject($this->PictureURL);
    }
}



class eBayNameValueListArrayType implements IteratorAggregate, ArrayAccess {
	public function getIterator() {
		// put this in __wakeUp()
		if (!is_array($this->NameValueList)) {
			$this->NameValueList = array($this->NameValueList);
		}

        return new ArrayObject($this->NameValueList);
    }

	public function offsetExists($offset) {
		foreach ($this as $NameValueList) {
			if ($NameValueList->Name == $offset) {
				return true;
			}
		}
		
		return false;
	}

	public function offsetGet($offset) {
		/* 
		  May need is_object check because we can get:
			 <NameValueList xsi:nil="true"/>
		  Instead of normal:
			  <NameValueList>
			   <Name>Year</Name>
			   <Value>19000000</Value>
			  </NameValueList>
		
		  ext/soap will create an empty array element for the nilled out element.
		  I think that's actually correct, but it would be better for eBay not to return anything here.
		  However, I am not 100% sure. This is tricky.
		  Note: nilled out elements can have attributes.
		  Also, I'm unsure if an element has to be explicitly labled as nillable in the schema if you want to nil it out.
		*/

		foreach ($this as $NameValueList) {
			if ($NameValueList->Name == $offset) {
				if ($NameValueList->Name == 'Year') {
					// eBay returns this as YYYYMMDD, but MMDD is always 0000
					// Because cars come out in 2006, not 20060000
					// So, trim off stupid 0000 at end
					$value = substr($NameValueList->Value, 0, 4); 
				} else {
					$value = $NameValueList->Value;
				}

				return $value;
			}
		}
		
		return null;
	}

	public function offsetSet($offset, $value) {
		return true;
	}

	public function offsetUnset($offset) {
		return true;
	}

}


class eBaySearchResultItemType {
	public function __toString() {
		return $this->Item->Title;
	}
}

class eBayAmountType {
	public function __toString() {
		return (string) $this->_;
	}
}

class eBayItemType {
	public function __toString() {
		return (string) $this->Title;
	}
}

class xsDateTime {
	public function __toString() {
		return $this->Item->Title;
	}

}
?>
