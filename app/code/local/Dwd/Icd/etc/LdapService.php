<?php
class addUserGroupsAttibuteNameValuePairs {
  public $arg0; // string
  public $arg1; // string
  public $arg2; // string
  public $arg3; // attributeNameValuePair
}

class attributeNameValuePair {
  public $name; // string
  public $value; // string
}

class addUserGroupsAttibuteNameValuePairsResponse {
  public $return; // ldapStatus
}

class ldapStatus {
  public $statusMessage; // string
  public $successStatus; // boolean
}

class addGroup {
  public $arg0; // string
  public $arg1; // string
}

class addGroupResponse {
  public $return; // ldapStatus
}

class addAttributeNameValuePair {
  public $arg0; // string
  public $arg1; // attributeNameValuePair
}

class addAttributeNameValuePairResponse {
  public $return; // ldapStatus
}

class addUser {
  public $arg0; // string
  public $arg1; // string
}

class addUserResponse {
  public $return; // ldapStatus
}

class removeAttributeNameValuePair {
  public $arg0; // string
  public $arg1; // attributeNameValuePair
}

class removeAttributeNameValuePairResponse {
  public $return; // ldapStatus
}

class removeUser {
  public $arg0; // string
}

class removeUserResponse {
  public $return; // ldapStatus
}

class removeGroup {
  public $arg0; // string
  public $arg1; // string
}

class removeGroupResponse {
  public $return; // ldapStatus
}

class setPasswordUser {
  public $arg0; // string
  public $arg1; // string
}

class setPasswordUserResponse {
  public $return; // ldapStatus
}


/**
 * LdapService class
 * 
 *  
 * 
 * @author    {author}
 * @copyright {copyright}
 * @package   {package}
 */
class LdapService extends SoapClient {

  private static $classmap = array(
                                    'addUserGroupsAttibuteNameValuePairs' => 'addUserGroupsAttibuteNameValuePairs',
                                    'attributeNameValuePair' => 'attributeNameValuePair',
                                    'addUserGroupsAttibuteNameValuePairsResponse' => 'addUserGroupsAttibuteNameValuePairsResponse',
                                    'ldapStatus' => 'ldapStatus',
                                    'addGroup' => 'addGroup',
                                    'addGroupResponse' => 'addGroupResponse',
                                    'addAttributeNameValuePair' => 'addAttributeNameValuePair',
                                    'addAttributeNameValuePairResponse' => 'addAttributeNameValuePairResponse',
                                    'addUser' => 'addUser',
                                    'addUserResponse' => 'addUserResponse',
                                    'removeAttributeNameValuePair' => 'removeAttributeNameValuePair',
                                    'removeAttributeNameValuePairResponse' => 'removeAttributeNameValuePairResponse',
                                    'removeUser' => 'removeUser',
                                    'removeUserResponse' => 'removeUserResponse',
                                    'removeGroup' => 'removeGroup',
                                    'removeGroupResponse' => 'removeGroupResponse',
                                    'setPasswordUser' => 'setPasswordUser',
                                    'setPasswordUserResponse' => 'setPasswordUserResponse',
                                   );

  public function __construct($wsdl = "ICD.wsdl", $options = array()) {
    foreach(self::$classmap as $key => $value) {
      if(!isset($options['classmap'][$key])) {
        $options['classmap'][$key] = $value;
      }
    }
    parent::__construct($wsdl, $options);
  }

  /**
   *  
   *
   * @param setPasswordUser $parameters
   * @return setPasswordUserResponse
   */
  public function setPasswordUser(setPasswordUser $parameters) {
    return $this->__soapCall('setPasswordUser', array($parameters),       array(
            'uri' => 'https://kunden.dwd.de/dwdshop/services',
            'soapaction' => ''
           )
      );
  }

  /**
   *  
   *
   * @param removeGroup $parameters
   * @return removeGroupResponse
   */
  public function removeGroup(removeGroup $parameters) {
    return $this->__soapCall('removeGroup', array($parameters),       array(
            'uri' => 'https://kunden.dwd.de/dwdshop/services',
            'soapaction' => ''
           )
      );
  }

  /**
   *  
   *
   * @param addGroup $parameters
   * @return addGroupResponse
   */
  public function addGroup(addGroup $parameters) {
    return $this->__soapCall('addGroup', array($parameters),       array(
            'uri' => 'https://kunden.dwd.de/dwdshop/services',
            'soapaction' => ''
           )
      );
  }

  /**
   *  
   *
   * @param removeUser $parameters
   * @return removeUserResponse
   */
  public function removeUser(removeUser $parameters) {
    return $this->__soapCall('removeUser', array($parameters),       array(
            'uri' => 'https://kunden.dwd.de/dwdshop/services',
            'soapaction' => ''
           )
      );
  }

  /**
   *  
   *
   * @param removeAttributeNameValuePair $parameters
   * @return removeAttributeNameValuePairResponse
   */
  public function removeAttributeNameValuePair(removeAttributeNameValuePair $parameters) {
    return $this->__soapCall('removeAttributeNameValuePair', array($parameters),       array(
            'uri' => 'https://kunden.dwd.de/dwdshop/services',
            'soapaction' => ''
           )
      );
  }

  /**
   *  
   *
   * @param addUser $parameters
   * @return addUserResponse
   */
  public function addUser(addUser $parameters) {
    return $this->__soapCall('addUser', array($parameters),       array(
            'uri' => 'https://kunden.dwd.de/dwdshop/services',
            'soapaction' => ''
           )
      );
  }

  /**
   *  
   *
   * @param addAttributeNameValuePair $parameters
   * @return addAttributeNameValuePairResponse
   */
  public function addAttributeNameValuePair(addAttributeNameValuePair $parameters) {
    return $this->__soapCall('addAttributeNameValuePair', array($parameters),       array(
            'uri' => 'https://kunden.dwd.de/dwdshop/services',
            'soapaction' => ''
           )
      );
  }

  /**
   *  
   *
   * @param addUserGroupsAttibuteNameValuePairs $parameters
   * @return addUserGroupsAttibuteNameValuePairsResponse
   */
  public function addUserGroupsAttibuteNameValuePairs(addUserGroupsAttibuteNameValuePairs $parameters) {
    return $this->__soapCall('addUserGroupsAttibuteNameValuePairs', array($parameters),       array(
            'uri' => 'https://kunden.dwd.de/dwdshop/services',
            'soapaction' => ''
           )
      );
  }

}

?>
