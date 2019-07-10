<?php
/**
 * Created by PhpStorm.
 * User: f.rochlitzer
 * Date: 05.02.2018
 * Time: 11:58
 */

class Egovs_Base_Model_Cms_Wysiwyg_Media_Storage extends Mage_Cms_Model_Wysiwyg_Images_Storage
{
    /**
     * Prepare allowed_extensions config settings
     *
     * @param string $type Type of storage, e.g. image, media etc.
     * @return array Array of allowed file extensions
     */
    public function getAllowedExtensions($type = null)
    {
        $extensions = $this->getConfigData('extensions');

        if (is_string($type) && array_key_exists("{$type}_allowed", $extensions)) {
            $allowed = $extensions["{$type}_allowed"];
        } else {
            $allowed = array(array());
            $types = array('media', 'image', 'doc');
            foreach ($types as $_type) {
                $allowed[] = $extensions["{$_type}_allowed"];
            }
            $allowed = array_merge(...$allowed);
        }

        return array_keys(array_filter($allowed));
    }

    /**
     * Upload and resize new file
     *
     * @param string $targetPath Target directory
     * @param string $type Type of storage, e.g. image, media etc.
     * @throws Mage_Core_Exception
     * @return array File info Array
     */
    public function uploadFile($targetPath, $type = null)
    {
        if (is_null($type)) {
            $uploader = new Mage_Core_Model_File_Uploader('media');
        } else {
            $uploader = new Mage_Core_Model_File_Uploader($type);
        }

        if ($allowed = $this->getAllowedExtensions($type)) {
            $uploader->setAllowedExtensions($allowed);
        }
        $uploader->setAllowRenameFiles(true);
        $uploader->setFilesDispersion(false);
        if ($type == 'image') {
            $uploader->addValidateCallback(
                Mage_Core_Model_File_Validator_Image::NAME,
                Mage::getModel('core/file_validator_image'),
                'validate'
            );
        } else {
            $uploader->addValidateCallback(
                'isMedia',
                Mage::getModel('egovsbase/file_validator_media'),
                'validate'
            );
        }
        $result = $uploader->save($targetPath);

        if (!$result) {
            Mage::throwException( Mage::helper('cms')->__('Cannot upload file.') );
        }

        if ($type == "image") {
            // create thumbnail
            $this->resizeFile($targetPath . DS . $uploader->getUploadedFileName(), true);
        }

        $result['cookie'] = array(
            'name'     => session_name(),
            'value'    => $this->getSession()->getSessionId(),
            'lifetime' => $this->getSession()->getCookieLifetime(),
            'path'     => $this->getSession()->getCookiePath(),
            'domain'   => $this->getSession()->getCookieDomain()
        );

        return $result;
    }
}