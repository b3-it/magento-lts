<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum
 * @package Egovs_Paymentbase
 * @subpackage Enumerations
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum originally named addressNoteEnum
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Enumerations
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * Constant for value 'PPB'
     * Meta informations extracted from the WSDL
     * - documentation : Confirmation on personal level. The address supplied (incl. name and first name) was completely correct or could be corrected completely. In this case only the freight routing code and possibly the corrected fields are returned to the initiator.
     * @return string 'PPB'
     */
    const VALUE_PPB = 'PPB';
    /**
     * Constant for value 'PHB'
     * Meta informations extracted from the WSDL
     * - documentation : Confirmation on household level. The address supplied (incl. name without first name) could be corrected completely or was completely correct on household level and had a first name, which is not rectifiable/known. In this case the corrected fields except the first name are returned to the initiator, as the first name could not be confirmed. The existence of the first name at this address could not be confirmed. In addition the field eScoreFreightRouting- Code is returned to the initiator as long as the freight routing code is available.
     * @return string 'PHB'
     */
    const VALUE_PHB = 'PHB';
    /**
     * Constant for value 'PAB'
     * Meta informations extracted from the WSDL
     * - documentation : Confirmation on address level. The address supplied (without name, without first name) could be corrected completely or on address level was already complete and had not rectifiable/known personal data. In this case the corrected fields except the first name and surname are returned to the initiator, as the first name and surname could not be confirmed. The existence of the first name and surname at this address could not be confirmed. In addition the field eScoreFreightRoutingCode is returned to the initiator as long as the freight routing code is available.
     * @return string 'PAB'
     */
    const VALUE_PAB = 'PAB';
    /**
     * Constant for value 'PNZ'
     * Meta informations extracted from the WSDL
     * - documentation : The person at the address supplied is known, but at this address is not or no longer deliverable. This corresponds to a confirmation on address level (PAB), however, with the above-mentioned limitation, that the person queried is undeliverable there.
     * @return string 'PNZ'
     */
    const VALUE_PNZ = 'PNZ';
    /**
     * Constant for value 'PPV'
     * Meta informations extracted from the WSDL
     * - documentation : The person at the address supplied is deceased according to the Deutsche Post (German mail).
     * @return string 'PPV'
     */
    const VALUE_PPV = 'PPV';
    /**
     * Constant for value 'PKI'
     * Meta informations extracted from the WSDL
     * - documentation : The response of the Deutsche Post (German mail) is possibly contradictory and/or ambiguous. Therefore the person/address is not assessed!
     * @return string 'PKI'
     */
    const VALUE_PKI = 'PKI';
    /**
     * Constant for value 'PPF'
     * Meta informations extracted from the WSDL
     * - documentation : eScore: the address is postally wrong.
     * @return string 'PPF'
     */
    const VALUE_PPF = 'PPF';
    /**
     * Constant for value 'PNP'
     * Meta informations extracted from the WSDL
     * - documentation : eScore: the address cannot be checked because it contains structural errors, e.g. the name is missing.
     * @return string 'PNP'
     */
    const VALUE_PNP = 'PNP';
    /**
     * Constant for value 'PUG'
     * Meta informations extracted from the WSDL
     * - documentation : eScore: the address if formally correct but the building is not known.
     * @return string 'PUG'
     */
    const VALUE_PUG = 'PUG';
    /**
     * Constant for value 'PUZ'
     * Meta informations extracted from the WSDL
     * - documentation : eScore: outdated address. The person moved away, the new address is known.
     * @return string 'PUZ'
     */
    const VALUE_PUZ = 'PUZ';
    /**
     * Constant for value 'B0'
     * Meta informations extracted from the WSDL
     * - documentation : Bürgel: the returned address equals the submitted address.
     * @return string 'B0'
     */
    const VALUE_B0 = 'B0';
    /**
     * Constant for value 'B1'
     * Meta informations extracted from the WSDL
     * - documentation : Bürgel: the requested person/address was found in the database.
     * @return string 'B1'
     */
    const VALUE_B1 = 'B1';
    /**
     * Constant for value 'B2'
     * Meta informations extracted from the WSDL
     * - documentation : Bürgel: found submitted data in history, updated response data.
     * @return string 'B2'
     */
    const VALUE_B2 = 'B2';
    /**
     * Constant for value 'B3'
     * Meta informations extracted from the WSDL
     * - documentation : Bürgel: person data from input, address corrected.
     * @return string 'B3'
     */
    const VALUE_B3 = 'B3';
    /**
     * Constant for value 'B4'
     * Meta informations extracted from the WSDL
     * - documentation : Bürgel: found input data in database after correction.
     * @return string 'B4'
     */
    const VALUE_B4 = 'B4';
    /**
     * Return true if value is allowed
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum::VALUE_PPB
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum::VALUE_PHB
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum::VALUE_PAB
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum::VALUE_PNZ
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum::VALUE_PPV
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum::VALUE_PKI
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum::VALUE_PPF
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum::VALUE_PNP
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum::VALUE_PUG
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum::VALUE_PUZ
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum::VALUE_B0
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum::VALUE_B1
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum::VALUE_B2
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum::VALUE_B3
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum::VALUE_B4
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum::VALUE_PPB,Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum::VALUE_PHB,Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum::VALUE_PAB,Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum::VALUE_PNZ,Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum::VALUE_PPV,Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum::VALUE_PKI,Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum::VALUE_PPF,Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum::VALUE_PNP,Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum::VALUE_PUG,Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum::VALUE_PUZ,Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum::VALUE_B0,Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum::VALUE_B1,Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum::VALUE_B2,Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum::VALUE_B3,Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum::VALUE_B4));
    }
    /**
     * Method returning the class name
     * @return string __CLASS__
     */
    public function __toString()
    {
        return __CLASS__;
    }
}
