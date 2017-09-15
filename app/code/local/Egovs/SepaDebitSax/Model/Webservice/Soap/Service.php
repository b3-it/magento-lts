<?php
/**
 * File for class SepaMvServiceAlive
 * @package SepaMv
 * @subpackage Services
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
/**
 * This class stands for SepaMvServiceAlive originally named Alive
 * @package SepaMv
 * @subpackage Services
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
class Egovs_SepaDebitSax_Model_Webservice_Soap_Service extends Egovs_SepaDebitSax_Model_Webservice_WsdlClass
{
	/**
	 * Method to call the operation originally named IsAlive
	 * Documentation : Prueft, ob eine Kombination von Konzern und Glaeubiger-ID exisitert
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::getSoapClient()
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::setResult()
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::saveLastError()
	 * @param Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung $_Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung
	 * @return Egovs_SepaDebitSax_Model_Webservice_Types_Result_IsAliveResult
	 */
	public function IsAlive(Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung $_Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung) {
		try
		{
			$result =  $this->getSoapClient()->IsAlive($_Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung);
			if (!($result instanceof Egovs_SepaDebitSax_Model_Webservice_Types_Result_IsAliveResult)) {
				$result = new Egovs_SepaDebitSax_Model_Webservice_Types_Result_IsAliveResult($result);
			}
			return $this->setResult($result);
		}
		catch(SoapFault $soapFault)
		{
			return !$this->saveLastError(__METHOD__,$soapFault);
		}
	}

	/**
	 * Method to call the operation originally named SucheSEPAMandatBeenden
	 * Documentation : Beendet die Suchanfrage, d.h. das Vorverfahren moechte keine weiteren Ergebnisse; MV loescht die Suchanfrage.
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::getSoapClient()
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::setResult()
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::saveLastError()
	 * @param Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung $_identifierzierung
	 * @param string $_suchanfragenId
	 * @param string $_bearbeiter
	 * @return Egovs_SepaDebitSax_Model_Webservice_Types_Result_SucheSEPAMandatBeendenResult
	 */
	public function SucheSEPAMandatBeenden(Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung $_identifierzierung,$_suchanfragenId,$_bearbeiter)
	{
		try
		{
			return $this->setResult(new Egovs_SepaDebitSax_Model_Webservice_Types_Result_SucheSEPAMandatBeendenResult($this->getSoapClient()->SucheSEPAMandatBeenden($_identifierzierung,$_suchanfragenId,$_bearbeiter)));
		}
		catch(SoapFault $soapFault)
		{
			return !$this->saveLastError(__METHOD__,$soapFault);
		}
	}

	/**
	 * Method to call the operation originally named AnlegenSEPADebitorenMandat
	 * Documentation : Legt ein Debitorenmandat an; es wird keine Mandatsreferenz erzeugt, wenn nicht diese nicht mitgegeben wurde.
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::getSoapClient()
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::setResult()
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::saveLastError()
	 * @param Egovs_SepaDebitSax_Model_Webservice_Types_Mandat $_mandat
	 * @param string $_bearbeiter
	 * @param Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung $_identifierzierung
	 * @return Egovs_SepaDebitSax_Model_Webservice_Types_Result_AnlegenSEPADebitorenMandatResult
	 */
	public function AnlegenSEPADebitorenMandat(Egovs_SepaDebitSax_Model_Webservice_Types_Mandat $_mandat,$_bearbeiter,Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung $_identifierzierung)
	{
		try
		{
			return $this->setResult(new Egovs_SepaDebitSax_Model_Webservice_Types_Result_AnlegenSEPADebitorenMandatResult( $this->getSoapClient()->AnlegenSEPADebitorenMandat($_mandat,$_bearbeiter,$_identifierzierung)));
		}
		catch(SoapFault $soapFault)
		{
			return !$this->saveLastError(__METHOD__,$soapFault);
		}
	}
	/**
	 * Method to call the operation originally named AnlegenSEPAKreditorenMandat
	 * Documentation : Legt ein SEPA-Kreditoren-Mandat an; es wird geprueft, dass alle Pflichtfelder fuer ein Kreditorenmandat ausgefuellt sind; ausserdem wird geprueft, dass der Status korrekt gesetzt ist
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::getSoapClient()
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::setResult()
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::saveLastError()
	 * @param Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung $_identifierzierung
	 * @param Egovs_SepaDebitSax_Model_Webservice_Types_Mandat $_mandat
	 * @param string $_bearbeiter
	 * @return Egovs_SepaDebitSax_Model_Webservice_Types_Result_AnlegenSEPAKreditorenMandatResult
	 */
	public function AnlegenSEPAKreditorenMandat(Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung $_identifierzierung, Egovs_SepaDebitSax_Model_Webservice_Types_Mandat $_mandat, $_bearbeiter)
	{
		try
		{
			$_mandat->Geschaeftsbereichkennung =  $_identifierzierung->getGeschaeftsbereichsId()->getGeschaeftsbereichskennung();
			$_mandat->PruefStatus = Egovs_SepaDebitSax_Model_Webservice_Enum_PruefStatus::VALUE_GEPRUEFT;
			$res =  $this->getSoapClient()->AnlegenSEPAKreditorenMandatMitPDF($_identifierzierung,$_mandat,$_bearbeiter);
			return $this->setResult($res);
		}
		catch(SoapFault $soapFault)
		{
			return !$this->saveLastError(__METHOD__,$soapFault);
		}
	}
	/**
	 * Method to call the operation originally named AendernSEPAMandat
	 * Documentation : Aendern eines SEPA-Mandates, bei dem kein Amendment erforderlich ist: die MV prueft, ob die nach Rulebook erlaubten Aenderungen gemacht werden. Wenn nach Rulebook ein Amendment erforderlich ist, wirft die Methode einen Fehler; Das zu aendernde Mandat wird ueber die DB-ID gesucht
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::getSoapClient()
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::setResult()
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::saveLastError()
	 * @param Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung $_identifierzierung
	 * @param Egovs_SepaDebitSax_Model_Webservice_Types_Mandat $_mandat
	 * @param string $_bearbeiter
	 * @return Egovs_SepaDebitSax_Model_Webservice_Types_Result_AendernSEPAMandatResult
	 */
	public function AendernSEPAMandat(Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung $_identifierzierung,Egovs_SepaDebitSax_Model_Webservice_Types_Mandat $_mandat,$_bearbeiter)
	{
		try
		{
			$res =  $this->getSoapClient()->AendernSEPAMandat($_identifierzierung,$_mandat,$_bearbeiter);
			
			return $res;
		}
		catch(SoapFault $soapFault)
		{
			$this->saveError();
			return !$this->saveLastError(__METHOD__,$soapFault);
		}
	}
	/**
	 * Method to call the operation originally named AmendmentSEPAMandat
	 * Documentation : Gibt ein Amendment zu einem Mandat als PDF zurueck; ueber die Mandats-Id wird das letzte Amendment gesucht und dessen PDF zurueckgegeben; gibt nicht zurueck, wenn es kein Amendment gibt.
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::getSoapClient()
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::setResult()
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::saveLastError()
	 * @param Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung $_identifierzierung
	 * @param string $_mandatsreferenz
	 * @param string $_bearbeiter
	 * @return Egovs_SepaDebitSax_Model_Webservice_Types_Result_AmendmentSEPAMandatResult
	 */
	public function AmendmentSEPAMandat(Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung $_identifierzierung,$_mandatsreferenz,$_bearbeiter)
	{
		try
		{
			return $this->setResult(new Egovs_SepaDebitSax_Model_Webservice_Types_Result_AmendmentSEPAMandatResult( $this->getSoapClient()->AmendmentSEPAMandat($_identifierzierung,$_mandatsreferenz,$_bearbeiter)));
		}
		catch(SoapFault $soapFault)
		{
			return !$this->saveLastError(__METHOD__,$soapFault);
		}
	}
	/**
	 * Method to call the operation originally named SetzeLetzteNutzungSEPADebitorenMandat
	 * Documentation : Setzt die Letzte Nutzung eines Mandates; das Mandat wird ueber seine ID gefunden.
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::getSoapClient()
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::setResult()
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::saveLastError()
	 * @param Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung $_identifierzierung
	 * @param string $_mandatsreferenz
	 * @param dateTime $_letzteNutzung
	 * @param string $_bearbeiter
	 * @return Egovs_SepaDebitSax_Model_Webservice_Types_Result_SetzeLetzteNutzungSEPADebitorenMandatResult
	 */
	public function SetzeLetzteNutzungSEPADebitorenMandat(Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung $_identifierzierung,$_mandatsreferenz,$_letzteNutzung,$_bearbeiter)
	{
		try
		{
			return $this->setResult(new Egovs_SepaDebitSax_Model_Webservice_Types_Result_SetzeLetzteNutzungSEPADebitorenMandatResult( $this->getSoapClient()->SetzeLetzteNutzungSEPADebitorenMandat($_identifierzierung,$_mandatsreferenz,$_letzteNutzung,$_bearbeiter)));
		}
		catch(SoapFault $soapFault)
		{
			return !$this->saveLastError(__METHOD__,$soapFault);
		}
	}
	/**
	 * Method to call the operation originally named SetzeFaelligkeitSEPAKreditorenMandat
	 * Documentation : Legt zu einem Mandat eine neue PreNotification an; das Mandat wird ueber die SEPA-Mandats-Id gesucht.
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::getSoapClient()
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::setResult()
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::saveLastError()
	 * @param Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung $_identifierzierung
	 * @param string $_mandatsreferenz
	 * @param float $_betrag
	 * @param dateTime $_faelligkeit
	 * @param string $_verwendungszweck
	 * @param string $_anordnungsdetails
	 * @param string $_bearbeiter
	 * @return Egovs_SepaDebitSax_Model_Webservice_Types_Result_SetzeFaelligkeitSEPAKreditorenMandatResult
	 */
	public function SetzeFaelligkeitSEPAKreditorenMandat(Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung $_identifierzierung,$_mandatsreferenz,$_betrag,$_faelligkeit,$_verwendungszweck,$_anordnungsdetails,$_bearbeiter)
	{
		try
		{
			return $this->setResult(new Egovs_SepaDebitSax_Model_Webservice_Types_Result_SetzeFaelligkeitSEPAKreditorenMandatResult( $this->getSoapClient()->SetzeFaelligkeitSEPAKreditorenMandat($_identifierzierung,$_mandatsreferenz,$_betrag,$_faelligkeit,$_verwendungszweck,$_anordnungsdetails,$_bearbeiter)));
		}
		catch(SoapFault $soapFault)
		{
			return !$this->saveLastError(__METHOD__,$soapFault);
		}
	}
	/**
	 * Method to call the operation originally named SucheSEPAMandat
	 * Documentation : Sucht zu einer Suchanfrage alle passenden Mandate; Die Suchanfrage besteht im Wesentlichen aus den Attributen eines Mandates. Wildcards sind erlaubt; Uebersteigt die Anzahl der gefundenen Mandate eine bestimmte Grenze, so muss mittels „sucheSEPAMandatNext“ nach weiteren Ergebnisse gefragt werden.
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::getSoapClient()
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::setResult()
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::saveLastError()
	 * @param Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung $_identifierzierung
	 * @param Egovs_SepaDebitSax_Model_Webservice_Types_MandatSuchanfrage $_mandatAnfrage
	 * @param string $_bearbeiter
	 * @return Egovs_SepaDebitSax_Model_Webservice_Types_Result_SucheSEPAMandatResult
	 */
	public function SucheSEPAMandat(Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung $_identifierzierung,Egovs_SepaDebitSax_Model_Webservice_Types_MandatSuchanfrage $_mandatAnfrage,$_bearbeiter)
	{
		try
		{
			return $this->setResult(new Egovs_SepaDebitSax_Model_Webservice_Types_Result_SucheSEPAMandatResult( $this->getSoapClient()->SucheSEPAMandat($_identifierzierung,$_mandatAnfrage,$_bearbeiter)));
		}
		catch(SoapFault $soapFault)
		{
			return !$this->saveLastError(__METHOD__,$soapFault);
		}
	}
	/**
	 * Method to call the operation originally named LesenSEPAMandat
	 * Documentation : Gibt zu einer vollstaendigen Glaeubiger-ID (Glaeubiger-ID + Geschaeftsbereichskennung) und einer Mandatsreferenz das entsprechende Mandat zurueck.
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::getSoapClient()
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::setResult()
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::saveLastError()
	 * @param Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung $_identifierzierung
	 * @param string $_mandatsreferenz
	 * @param string $_bearbeiter
	 * @return Egovs_SepaDebitSax_Model_Webservice_Types_Result_LesenSEPAMandatResult
	 */
	public function LesenSEPAMandat(Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung $_identifierzierung,$_mandatsreferenz,$_bearbeiter)
	{
		try
		{
			$res =  $this->getSoapClient()->LesenSEPAMandat($_identifierzierung,$_mandatsreferenz,$_bearbeiter);
			return $this->setResult($res);
		}
		catch(SoapFault $soapFault)
		{
			return !$this->saveLastError(__METHOD__,$soapFault);
		}
	}

	/**
	 * Method to call the operation originally named SucheSEPAMandatNext
	 * Documentation : Sucht zu einer Suchanfrage alle passenden Mandate; diese Methode gibt zu einer vorher getaetigten Anfrage die weiteren Ergebnisse zurueck.
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::getSoapClient()
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::setResult()
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::saveLastError()
	 * @param Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung $_identifierzierung
	 * @param string $_suchanfragenId
	 * @param string $_bearbeiter
	 * @return Egovs_SepaDebitSax_Model_Webservice_Types_Result_SucheSEPAMandatNextResult
	 */
	public function SucheSEPAMandatNext(Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung $_identifierzierung,$_suchanfragenId,$_bearbeiter)
	{
		try
		{
			return $this->setResult(new Egovs_SepaDebitSax_Model_Webservice_Types_Result_SucheSEPAMandatNextResult($this->getSoapClient()->SucheSEPAMandatNext($_identifierzierung,$_suchanfragenId,$_bearbeiter)));
		}
		catch(SoapFault $soapFault)
		{
			return !$this->saveLastError(__METHOD__,$soapFault);
		}
	}

	/**
	 * Method to call the operation originally named AnlegenSEPAKreditorenMandatMitPDF
	 * Documentation : Legt ein SEPA-Kreditoren-Mandat an; es wird geprueft, dass alle Pflichtfelder fuer ein Kreditorenmandat ausgefuellt sind; ausserdem wird geprueft, dass der Status korrekt gesetzt ist.
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::getSoapClient()
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::setResult()
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::saveLastError()
	 * @param Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung $_identifierzierung
	 * @param Egovs_SepaDebitSax_Model_Webservice_Types_Mandat $_mandat
	 * @param string $_bearbeiter
	 * @return Egovs_SepaDebitSax_Model_Webservice_Types_Result_AnlegenSEPAKreditorenMandatMitPDFResult
	 */
	public function AnlegenSEPAKreditorenMandatMitPDF(Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung $_identifierzierung,Egovs_SepaDebitSax_Model_Webservice_Types_Mandat $_mandat,$_bearbeiter)
	{
		try
		{
			$_mandat->Geschaeftsbereichkennung =  $_identifierzierung->getGeschaeftsbereichsId()->getGeschaeftsbereichskennung();
			$_mandat->PruefStatus = Egovs_SepaDebitSax_Model_Webservice_Enum_PruefStatus::VALUE_GEPRUEFT;
			$client =  $this->getSoapClient();
			$res =  $client->AnlegenSEPAKreditorenMandatMitPDF($_identifierzierung,$_mandat,$_bearbeiter);
			//$res = new Egovs_SepaDebitSax_Model_Webservice_Types_Result_AnlegenSEPAKreditorenMandatMitPDFResult($res);
			$res->MandatPdf =  $client->PDFStream;
			
			return $this->setResult($res);
		}
		catch(SoapFault $soapFault)
		{
			return !$this->saveLastError(__METHOD__,$soapFault);
		}
	}
	/**
	 * Method to call the operation originally named AendernSEPAKreditorenMandatMitAmendmentMitPDF
	 * Documentation : Aendern eines SEPA-Kreditorenmandates und Erzeugen eines Amendments. Das zu aendernde Mandat wird ueber die SEPA-Mandat-ID gesucht.
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::getSoapClient()
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::setResult()
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::saveLastError()
	 * @param Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung $_identifierzierung
	 * @param Egovs_SepaDebitSax_Model_Webservice_Types_Mandat $_mandat
	 * @param string $_bearbeiter
	 * @return Egovs_SepaDebitSax_Model_Webservice_Types_Result_AendernSEPAKreditorenMandatMitAmendmentMitPDFResult
	 */
	public function AendernSEPAKreditorenMandatMitAmendmentMitPDF(Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung $_identifierzierung,Egovs_SepaDebitSax_Model_Webservice_Types_Mandat $_mandat,$_bearbeiter)
	{
		try
		{
			$client =  $this->getSoapClient();
			$res =  $client->AendernSEPAKreditorenMandatMitAmendmentMitPDF($_identifierzierung,$_mandat,$_bearbeiter);
			$res->MandatPdf =  $client->PDFStream;
			return $this->setResult($res);
		}
		catch(SoapFault $soapFault)
		{
			return !$this->saveLastError(__METHOD__,$soapFault);
		}
	}
	/**
	 * Method to call the operation originally named AnlegenSEPAPreNotificationMitPDF
	 * Documentation : Legt zu einem Mandat eine neue PreNotification an; das Mandat wird ueber die SEPA-Mandats-Id gesucht.
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::getSoapClient()
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::setResult()
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::saveLastError()
	 * @param Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung $_identifierzierung
	 * @param string $_mandatsreferenz
	 * @param float $_betrag
	 * @param dateTime $_faelligkeit
	 * @param string $_verwendungszweck
	 * @param string $_anordnungsdetails
	 * @param string $_bearbeiter
	 * @return Egovs_SepaDebitSax_Model_Webservice_Types_Result_AnlegenSEPAPreNotificationMitPDFResult
	 */
	public function AnlegenSEPAPreNotificationMitPDF(Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung $_identifierzierung,$_mandatsreferenz,$_betrag,$_faelligkeit,$_verwendungszweck,$_anordnungsdetails,$_bearbeiter)
	{
		try
		{
			$client =  $this->getSoapClient();
			$res = $client->AnlegenSEPAPreNotificationMitPDF($_identifierzierung,$_mandatsreferenz,$_betrag,$_faelligkeit,$_verwendungszweck,$_anordnungsdetails,$_bearbeiter);
			$res->PreNotificationPdf =  $client->PDFStream;
			return $this->setResult($res);
		}
		catch(SoapFault $soapFault)
		{
			$this->saveError();
			return !$this->saveLastError(__METHOD__,$soapFault);
		}
	}
	/**
	 * Method to call the operation originally named LesenSEPAMandatMitPDF
	 * Documentation : Gibt zu einer vollstaendigen Glaeubiger-ID (Glaeubiger-ID + Geschaeftsbereichskennung) und einer Mandatsreferenz das entsprechende Mandat zurueck.
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::getSoapClient()
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::setResult()
	 * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::saveLastError()
	 * @param Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung $_identifierzierung
	 * @param string $_mandatsreferenz
	 * @param string $_bearbeiter
	 * @return Egovs_SepaDebitSax_Model_Webservice_Types_Result_LesenSEPAMandatMitPDFResult
	 */
	public function LesenSEPAMandatMitPDF(Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung $_identifierzierung,$_mandatsreferenz,$_bearbeiter)
	{
		try
		{
			$client =  $this->getSoapClient();
			$res =  $client->LesenSEPAMandatMitPDF($_identifierzierung,$_mandatsreferenz,$_bearbeiter);
			$res->MandatPdf =   $client->PDFStream;
			return $this->setResult($res);
		}
		catch(SoapFault $soapFault)
		{
			return !$this->saveLastError(__METHOD__,$soapFault);
		}
	}

	/**
	 * Returns the result
	 *
	 * @see Egovs_SepaDebitSax_Model_Webservice_WsdlClass::getResult()
	 * @return Egovs_SepaDebitSax_Model_Webservice_Types_Result_AendernSEPAKreditorenMandatMitAmendmentMitPDFResult|Egovs_SepaDebitSax_Model_Webservice_Types_Result_AnlegenSEPAKreditorenMandatMitPDFResult|Egovs_SepaDebitSax_Model_Webservice_Types_Result_AnlegenSEPAPreNotificationMitPDFResult|Egovs_SepaDebitSax_Model_Webservice_Types_Result_LesenSEPAMandatMitPDFResult|Egovs_SepaDebitSax_Model_Webservice_Types_Result_SucheSEPAMandatNextResult|Egovs_SepaDebitSax_Model_Webservice_Types_Result_LesenSEPAMandatResult|Egovs_SepaDebitSax_Model_Webservice_Types_Result_SucheSEPAMandatResult|Egovs_SepaDebitSax_Model_Webservice_Types_Result_SetzeFaelligkeitSEPAKreditorenMandatResult|Egovs_SepaDebitSax_Model_Webservice_Types_Result_SetzeLetzteNutzungSEPADebitorenMandatResult|Egovs_SepaDebitSax_Model_Webservice_Types_Result_AmendmentSEPAMandatResult|Egovs_SepaDebitSax_Model_Webservice_Types_Result_AendernSEPAMandatResult|Egovs_SepaDebitSax_Model_Webservice_Types_Result_AnlegenSEPAKreditorenMandatResult|Egovs_SepaDebitSax_Model_Webservice_Types_Result_AnlegenSEPADebitorenMandatResult|Egovs_SepaDebitSax_Model_Webservice_Types_Result_SucheSEPAMandatBeendenResult|Egovs_SepaDebitSax_Model_Webservice_Types_Result_IsAliveResult
	 */
	public function getResult() {
		return parent::getResult();
	}

	/**
	 * Method returning the class name
	 * @return string __CLASS__
	 */
	public function __toString()
	{
		return __CLASS__;
	}
	
	public function saveError()
	{
		if($this->__soapClient)
		{
			$this->__soapClient->logLastError();
		}
	}
	
}
