<?php
interface Egovs_Paymentbase_Model_Sepa_Bankaccount
{
	public function getIban();
	public function setIban($iban);
	public function getBic();
	public function setBic($bic);
	
	public function getBankname($bic);
}