<?php

/**
 * Helper-Klasse, die api-Aufrufinstanzen verwaltet
 *
 * @package TKonnekt
 * @author	Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2017 B3 IT Systeme GmbH - http://www.b3-it.de
 * @version 1.0.0.0 / 2017-09-07
 */
class TKonnekt_SDK_TransactionType_Helper
{

    /**
     * Gibt eine Instanz eines Api-Aufrufs zurück
     *
     * @param string $transType
     *
     * @return TKonnekt_SDK_InterfaceApi
     */
    public static function getTransactionTypeByName($transType)
    {
        switch ($transType) {
            //debit card apis
            case 'debitCardTransaction':
                return new TKonnekt_SDK_DebitCardTransaction();

            //tools apis
            case 'getTransactionTool':
                return new TKonnekt_SDK_Tools_GetTransaction();
        }

        return null;
    }
}