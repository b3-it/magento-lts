<?php
class BKG_VirtualGeo_Helper_Gdz extends Mage_Core_Helper_Abstract
{
    public function describe($typeName) {
        try {
            $fdata = $this->__curl_get("http://sg.geodatenzentrum.de/gdz_interrest/describe?typeName=".$typeName);

            // fdata has attributeName, srs and geometryName
            $data = json_decode($fdata, true);
            if ($data === false) {
                throw new Exception(json_last_error_msg());
            }
            return $data;
        } catch (Exception $e) {
            Mage::logException($e);
            // do nothing for now
        }
        return array();
    }
    
    public function listLayer() {
        try {
            $fdata = $this->__curl_get("http://sg.geodatenzentrum.de/gdz_interrest/list");
            $data = json_decode($fdata, true);
            if ($data === false) {
                throw new Exception(json_last_error_msg());
            }
            return $data;
        } catch (Exception $e) {
            Mage::logException($e);
            // do nothing for now
        }
        return array();
    }
    
    public function includeLayer($layer) {
        $haystack = $this->listLayer();
        return is_array($haystack) && in_array($this->__getLayerName($layer), $haystack);
    }
    
    /**
     * 
     * @param string $sourceName
     * @param mixed $ids
     * @param string $targetName
     * 
     * @throws \Exception
     * @return string
     */
    public function intersect($sourceName, $ids, $targetName) {
        
        if (is_numeric($sourceName)) {
            $sourceName = $this->__getLayerName($sourceName);
        }
        if (is_numeric($targetName)) {
            $targetName = $this->__getLayerName($targetName);
        }
        // ids need to be an array
        if(!is_array($ids)) {
            $ids = array($ids);
        }
        $fields = array(
            "source" => $sourceName,
            "target" => $targetName,
            "ids" => $ids
        );
        
        Mage::log("intersect" . json_encode($fields));
        $data = $this->__curl_post("http://sg.geodatenzentrum.de/gdz_interrest/intersect", $fields);
        $result = json_decode($data, true);
        // throw exception if the respond of the service is no valid json
        if ($result === false) {
            throw new Exception(json_last_error_msg());
        }
        return $result;
    }
    
    private function __getLayerName($id) {
        if (is_numeric($id)) {
            /**
             * @var Bkg_Viewer_Model_Service_Layer $layer
             */
            $layer = Mage::getModel('bkgviewer/service_layer')->load($id);
            $name = $layer->getName();
            // turns xyz:abc into abc
            if ($p = strpos($name, ":")) {
                $name = substr($name, $p + 1);
            }
            return $name;
        }
        return $id;
    }
    
    /**
     * 
     * @param string $url
     * @return string
     */
    private function __curl_get($url) {
        $res = "";
        try {
            $cs = curl_init($url);
            
            curl_setopt($cs, CURLOPT_FOLLOWLOCATION, true); // Follow any Location headers
            curl_setopt($cs, CURLOPT_RETURNTRANSFER, true); // receive returned characters
            
            curl_setopt($cs, CURLOPT_ENCODING ,"");
            $res = curl_exec($cs);
            
            if(curl_error($cs))
            {
                throw new Exception(curl_error($cs));
            }
            
            curl_close($cs);
        }
        catch(Exception $ex) {
            curl_close($cs);
            Mage::logException($ex);
        }
        return $res;
    }
    
    /**
     * post as json
     * @param string $url
     * @param array $data
     * @return string
     */
    private function __curl_post($url, $data) {
        $res = "";
        try {
            $cs = curl_init($url);
            curl_setopt($cs, CURLOPT_RETURNTRANSFER, true); // receive returned characters
            curl_setopt($cs, CURLOPT_CUSTOMREQUEST, "POST");
            //curl_setopt($cs, CURLOPT_POST, count($fields));
            //$urlEnc = http_build_query($fields, null, '&');
            
            $data_string = json_encode($data);
            curl_setopt($cs, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($cs, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
            );
            
            $res = curl_exec($cs);
            
            if(curl_error($cs))
            {
                throw new Exception(curl_error($cs));
            }
            
            curl_close($cs);
        }
        catch(Exception $ex) {
            curl_close($cs);
            Mage::logException($ex);
        }
        return $res;
    }
}