<?php
class Egovs_Ldap_Model_Ldapauth {
	public function authenticate($username, $password, $user) {
		try {
			$ldapauth = $this->_tryauth($username, $password);
			if (isset ($ldapauth['is_auth']) && ($ldapauth['is_auth'] === true)) {

				// falls der user in Magento bekannt ist
				if ($user->getId()) {
					$isActive = ($user->getData('is_active') == '1') || ($ldapauth['is_active'] == '1') ? '1' : '0';
					$user->setData('is_active', $isActive);
					return $user;
				} else {
					//neuen user anlegen
					$user->setData('username', $ldapauth['username']);
					$user->setData('email', $ldapauth['email']);
					$user->setData('lastname', $ldapauth['lastname']);
					$user->setData('firstname', $ldapauth['firstname']);
					$user->setData('is_active', $ldapauth['is_active']);
					$user->setPassword(md5(microtime() + mt_rand()));
					$user->save();
					$user = Mage :: getModel('admin/user')->loadByUsername($ldapauth['username']);

					//default rolle
					$uRole = Mage :: getStoreConfig('admin/ldap/default_role');
					if (isset ($uRole)) {
						//gibts die rolle ?
						$role = Mage :: getModel('admin/role')->load($uRole);
						if ($role->getId()) {
							$user->setRoleId($role->getId())->setUserId($user->getId())->add()->save();
						}
					}
					return $user;

				}
			}
		} catch (Exception $e) {
			Mage :: log("ldap: auth" . $e->getMessage(), Zend_log :: DEBUG, Egovs_Helper :: LOG_FILE);
			return null;
		}

		return null;
	}

	//daten vom LDAP - Server holen
	private function _tryauth($username, $password) {
		$res = array ();

		try {

			// Konfigurationsvariablen (siehe system.xml)

			// z. B.: $active = 1;
			$active = intval(Mage :: getStoreConfig('admin/ldap/active'));

			// z. B. $servername = 'edvberaterhome.dyndns.org';
			$servername = Mage :: getStoreConfig('admin/ldap/servername');

			// z. B. $port = 10389;
			$port = Mage :: getStoreConfig('admin/ldap/port');

			// z. B. $ldapprotocolversionthree = 1;
			$ldapprotocolversionthree = intval(Mage :: getStoreConfig('admin/ldap/ldapprotocolversionthree'));

			// z. B. $oubind = 'system';
			$oubind = Mage :: getStoreConfig('admin/ldap/oubind');

			// z. B. $acceptedldapcategory = 1;
			$acceptedldapcategory = intval(Mage :: getStoreConfig('admin/ldap/acceptedldapcategory'));

			// Konfiguration pruefen
			{
				if (!isset ($servername)) {
					Mage :: throwException(Mage :: helper('adminhtml')->__('Servername not set.'));
				}
			}

			// Ergebnisdaten
			$email = '';
			$lastname = '';
			$firstname = '';

			// wenn aktiv
			if ($active === 1) {

				// Zugriff LDAP
				$resource = ldap_connect($servername, intval($port));

				// LDAP Version
				if ($ldapprotocolversionthree === 1) {
					ldap_set_option($resource, LDAP_OPT_PROTOCOL_VERSION, 3);
				}

				$userNameSet = false;
				$isError = false;

				if (ldap_bind($resource, 'uid=' . $username . ',ou=' . $oubind, $password)) {

					$result = ldap_search($resource, 'ou=' . $oubind, 'uid=' . $username);
					if ($result) {
						if (ldap_count_entries($resource, $result) === 1) {
							$info = ldap_get_entries($resource, $result);

							if (isset ($info['count']) && ($info['count'] === 1) && (isset ($info[0]))) {
								for ($x = 0, $xMax = count($info[0]); $x <= $xMax; $x++) {
									if (isset ($info[0][$x])) {
										switch ($info[0][$x]) {
											case 'uid' :
												if (isset ($info[0]['uid']) && ($info[0]['uid']['count'] === 1) && isset ($info[0]['uid'][0])) {
													if ($info[0]['uid'][0] == $username) {
														// Benutzername stimmt
														$userNameSet = true;
													} else {
														// Login fehlgeschlagen
														$isError = true;
													}
												} else {
													// Login fehlgeschlagen
													$isError = true;
												}
												break;
											case 'mail' :
												if (isset ($info[0]['mail']) && ($info[0]['mail']['count'] === 1) && isset ($info[0]['mail'][0])) {
													if (trim($info[0]['mail'][0]) != '') {
														// E-Mail-Adresse setzen
														$email = $info[0]['mail'][0];
													} else {
														// Login fehlgeschlagen
														$isError = true;
													}
												} else {
													// Login fehlgeschlagen
													$isError = true;
												}
												break;
											case 'sn' :
												if (isset ($info[0]['sn']) && ($info[0]['sn']['count'] === 1) && isset ($info[0]['sn'][0])) {
													if (trim($info[0]['sn'][0]) != '') {
														// Nachname setzen
														$lastname = $info[0]['sn'][0];
													} else {
														// Login fehlgeschlagen
														$isError = true;
													}
												} else {
													// Login fehlgeschlagen
													$isError = true;
												}
												break;
											case 'givenname' :
												if (isset ($info[0]['givenname']) && ($info[0]['givenname']['count'] === 1) && isset ($info[0]['givenname'][0])) {
													if (trim($info[0]['givenname'][0]) != '') {
														// Vorname stimmt
														$firstname = $info[0]['givenname'][0];
													} else {
														// Login fehlgeschlagen
														$isError = true;
													}
												} else {
													// Login fehlgeschlagen
													$isError = true;
												}
												break;
											case 'businesscategory' :
												if (isset ($info[0]['businesscategory']) && ($info[0]['businesscategory']['count'] === 1) && isset ($info[0]['businesscategory'][0])) {
													if (trim($info[0]['businesscategory'][0]) == $acceptedldapcategory) {
														// alles in Ordnung
													} else {
														// Login fehlgeschlagen
														$isError = true;
													}
												} else {
													// Login fehlgeschlagen
													$isError = true;
												}
												break;
										}
									}
								}
							}
						}
					} else {
						$isError = true;
					}

					// Ende LDAP-Verbindung
					if (!ldap_close($resource)) {
						$isError = true;
					}
				} else {
					$isError = true;
				}

				if ($userNameSet && !$isError && (trim($email) != '') && (trim($lastname) != '') && (trim($firstname) != '')) {

					$res = array (
						'username' => $username,
						'email' => $email,
						'lastname' => $lastname,
						'firstname' => $firstname,

						//ein flag vom Server damit der user disabled werden kann
						'is_active' => '1',

						// userexists && $password == $Ldap->password
						'is_auth' => true,
					);

				} else {
					Mage :: throwException(Mage :: helper('adminhtml')->__('Invalid Username or Password.'));
				}
			}

		} catch (Exception $e) {
			Mage :: log("ldap: tryauth" . $e->getMessage(), Zend_log :: DEBUG, Egovs_Helper :: LOG_FILE);
			return $res;
		}

		return $res;
	}
}