<?php
/**
 * 
 * Hilfsklasse für Slpb
 * Sollte nur statische Elemente enthalten!
 * 
 * 2010-03-13
 * Diese Klasse darf nicht von Mage_Core_Helper_Abstract erben (oder anderen?), da sonst die "include" Anweisung im autoload
 * fehlschlägt!
 * 
 * @author Frank Rochlitzer
 *
 */
class Slpb_Helper
{	
	const LOG_FILE = "egovs.log";
	const EXCEPTION_LOG_FILE = "egovs_exception.log";
}