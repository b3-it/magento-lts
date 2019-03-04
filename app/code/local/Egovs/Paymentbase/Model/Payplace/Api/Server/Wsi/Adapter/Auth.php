<?php 
class Egovs_Paymentbase_Model_Payplace_Api_Server_Wsi_Adapter_Auth
{
	private $_supportedSchemes=array('basic','digest');
	protected $_supportedAlgos = array('MD5');
	protected $_useOpaque;
	/**
	 * Whether or not to do Proxy Authentication instead of origin server
	 * authentication (send 407's instead of 401's). Off by default.
	 *
	 * @var boolean
	 */
	protected $_imaProxy;
	
	/**
	 * Flag indicating the client is IE and didn't bother to return the opaque string
	 *
	 * @var boolean
	 */
	protected $_ieNoOpaque;
	
	
	public function getRequestUser()
	{
		$request = $this->_apache_request_headers();
		$this->_request = array();
		foreach($request as $k=>$v)
		{
			$this->_request[strtolower($k)] = $v;
		}
		
		
		if (empty($this->_request)) {
			/**
			 * @see Zend_Auth_Adapter_Exception
			 */
			#require_once 'Zend/Auth/Adapter/Exception.php';
			throw new Zend_Auth_Adapter_Exception('Request objects must be set before calling '
					. 'authenticate()');
		}
		
		
		if ($this->_imaProxy) {
			$getHeader = 'proxy-authorization';
		} else {
			$getHeader = 'authorization';
		}
		
		$authHeader = $this->_request[$getHeader];
		if (!$authHeader) {
			throw new Zend_Auth_Adapter_Exception('Unsupported authentication');
			//return $this->_challengeClient();
		}
		
		
		list($clientScheme) = explode(' ', $authHeader);
		$clientScheme = strtolower($clientScheme);
		
		if (!in_array($clientScheme, $this->_supportedSchemes)) {
			$this->_response->setHttpResponseCode(400);
			return new Zend_Auth_Result(
					Zend_Auth_Result::FAILURE_UNCATEGORIZED,
					array(),
					array('Client requested an incorrect or unsupported authentication scheme')
			);
		}
				
		switch ($clientScheme) {
			case 'basic':
				$result = $this->_basicAuth($authHeader);
				break;
				
			case 'digest':
				//$result = $this->_digestAuth($authHeader);
				throw new Zend_Auth_Adapter_Exception('Unsupported digest authentication scheme');
				break;
			default:
				/**
				 * @see Zend_Auth_Adapter_Exception
				 */
				#require_once 'Zend/Auth/Adapter/Exception.php';
				throw new Zend_Auth_Adapter_Exception('Unsupported authentication scheme');
		}
		
		return $result;
		
		
	}
	
	
	protected function _basicAuth($header)
	{
		if (empty($header)) {
			/**
			 * @see Zend_Auth_Adapter_Exception
			 */
			#require_once 'Zend/Auth/Adapter/Exception.php';
			throw new Zend_Auth_Adapter_Exception('The value of the client Authorization header is required');
		}
		
		// Decode the Authorization header
		$auth = substr($header, strlen('Basic '));
		$auth = base64_decode($auth);
		if (!$auth) {
			/**
			 * @see Zend_Auth_Adapter_Exception
			 */
			#require_once 'Zend/Auth/Adapter/Exception.php';
			throw new Zend_Auth_Adapter_Exception('Unable to base64_decode Authorization header value');
		}
		
		$creds = array_filter(explode(':', $auth));
		if (count($creds) != 2) {
			//return $this->_challengeClient();
			throw new Zend_Auth_Adapter_Exception('Unable to Parse Username');
		}
		
		return $creds;
	}
	
	
	protected function _digestAuth($header)
	{
		if (empty($header)) {
			/**
			 * @see Zend_Auth_Adapter_Exception
			 */
			#require_once 'Zend/Auth/Adapter/Exception.php';
			throw new Zend_Auth_Adapter_Exception('The value of the client Authorization header is required');
		}
		
	
		$data = $this->_parseDigestAuth($header);
		if ($data === false) {
			$this->_response->setHttpResponseCode(400);
			return new Zend_Auth_Result(
					Zend_Auth_Result::FAILURE_UNCATEGORIZED,
					array(),
					array('Invalid Authorization header format')
			);
		}
	}
	
	protected function _parseDigestAuth($header)
	{
		$temp = null;
		$data = array();
	
		// See ZF-1052. Detect invalid usernames instead of just returning a
		// 400 code.
		$ret = preg_match('/username="([^"]+)"/', $header, $temp);
		if (!$ret || empty($temp[1])
		|| !ctype_print($temp[1])
		|| strpos($temp[1], ':') !== false) {
			$data['username'] = '::invalid::';
		} else {
			$data['username'] = $temp[1];
		}
		$temp = null;
	
		$ret = preg_match('/realm="([^"]+)"/', $header, $temp);
		if (!$ret || empty($temp[1])) {
			return false;
		}
		if (!ctype_print($temp[1]) || strpos($temp[1], ':') !== false) {
			return false;
		} else {
			$data['realm'] = $temp[1];
		}
		$temp = null;
	
		$ret = preg_match('/nonce="([^"]+)"/', $header, $temp);
		if (!$ret || empty($temp[1])) {
			return false;
		}
		if (!ctype_xdigit($temp[1])) {
			return false;
		} else {
			$data['nonce'] = $temp[1];
		}
		$temp = null;
	
		$ret = preg_match('/uri="([^"]+)"/', $header, $temp);
		if (!$ret || empty($temp[1])) {
			return false;
		}
		// Section 3.2.2.5 in RFC 2617 says the authenticating server must
		// verify that the URI field in the Authorization header is for the
		// same resource requested in the Request Line.
		$rUri = @parse_url($this->_request->getRequestUri());
		$cUri = @parse_url($temp[1]);
		if (false === $rUri || false === $cUri) {
			return false;
		} else {
			// Make sure the path portion of both URIs is the same
			if ($rUri['path'] != $cUri['path']) {
				return false;
			}
			// Section 3.2.2.5 seems to suggest that the value of the URI
			// Authorization field should be made into an absolute URI if the
			// Request URI is absolute, but it's vague, and that's a bunch of
			// code I don't want to write right now.
			$data['uri'] = $temp[1];
		}
		$temp = null;
	
		$ret = preg_match('/response="([^"]+)"/', $header, $temp);
		if (!$ret || empty($temp[1])) {
			return false;
		}
		if (32 != strlen($temp[1]) || !ctype_xdigit($temp[1])) {
			return false;
		} else {
			$data['response'] = $temp[1];
		}
		$temp = null;
	
		// The spec says this should default to MD5 if omitted. OK, so how does
		// that square with the algo we send out in the WWW-Authenticate header,
		// if it can easily be overridden by the client?
		$ret = preg_match('/algorithm="?(' . $this->_algo . ')"?/', $header, $temp);
		if ($ret && !empty($temp[1])
		&& in_array($temp[1], $this->_supportedAlgos)) {
			$data['algorithm'] = $temp[1];
		} else {
			$data['algorithm'] = 'MD5';  // = $this->_algo; ?
		}
		$temp = null;
	
		// Not optional in this implementation
		$ret = preg_match('/cnonce="([^"]+)"/', $header, $temp);
		if (!$ret || empty($temp[1])) {
			return false;
		}
		if (!ctype_print($temp[1])) {
			return false;
		} else {
			$data['cnonce'] = $temp[1];
		}
		$temp = null;
	
		// If the server sent an opaque value, the client must send it back
		if ($this->_useOpaque) {
			$ret = preg_match('/opaque="([^"]+)"/', $header, $temp);
			if (!$ret || empty($temp[1])) {
	
				// Big surprise: IE isn't RFC 2617-compliant.
				if (false !== strpos($this->_request->getHeader('User-Agent'), 'MSIE')) {
					$temp[1] = '';
					$this->_ieNoOpaque = true;
				} else {
					return false;
				}
			}
			// This implementation only sends MD5 hex strings in the opaque value
			if (!$this->_ieNoOpaque &&
			(32 != strlen($temp[1]) || !ctype_xdigit($temp[1]))) {
				return false;
			} else {
				$data['opaque'] = $temp[1];
			}
			$temp = null;
		}
	
		// Not optional in this implementation, but must be one of the supported
		// qop types
		$ret = preg_match('/qop="?(' . implode('|', $this->_supportedQops) . ')"?/', $header, $temp);
		if (!$ret || empty($temp[1])) {
			return false;
		}
		if (!in_array($temp[1], $this->_supportedQops)) {
			return false;
		} else {
			$data['qop'] = $temp[1];
		}
		$temp = null;
	
		// Not optional in this implementation. The spec says this value
		// shouldn't be a quoted string, but apparently some implementations
		// quote it anyway. See ZF-1544.
		$ret = preg_match('/nc="?([0-9A-Fa-f]{8})"?/', $header, $temp);
		if (!$ret || empty($temp[1])) {
			return false;
		}
		if (8 != strlen($temp[1]) || !ctype_xdigit($temp[1])) {
			return false;
		} else {
			$data['nc'] = $temp[1];
		}
		$temp = null;
	
		return $data;
	}
	
	
	private function _apache_request_headers() {
		$arh = array();
		$rx_http = '/\AHTTP_/';
		foreach($_SERVER as $key => $val) {
			if( preg_match($rx_http, $key) ) {
				$arh_key = preg_replace($rx_http, '', $key);
				// do some nasty string manipulations to restore the original letter case
				// this should work in most cases
				$rx_matches = explode('_', $arh_key);
				if( count($rx_matches) > 0 and strlen($arh_key) > 2 ) {
					foreach($rx_matches as $ak_key => $ak_val) $rx_matches[$ak_key] = ucfirst($ak_val);
					$arh_key = implode('-', $rx_matches);
				}
				$arh[$arh_key] = $val;
			}
		}
		return( $arh );
	}
}

