<?php if(!$gjennomIndex) die("Access denied.");?>

<?php

class Kunde extends BasicKunde
{
	private $utlogging,$sessionExpire;

	function __construct()
	{ $this->sessionExpire=60*30; }

	function login($epost,$passord)
	{
		$db=new sql();
		$passord=renStreng($passord,$db);
		$epost=renStreng($epost,$db);
		$brukerinfo=$db->query("SELECT * FROM webprosjekt_kunde WHERE epost='$epost'");
		$rows=$db->affected_rows;
		$db->close();
		if($rows==0)
			return false;
		$brukerinfo=$brukerinfo->fetch_assoc();
		//if($brukerinfo['passord']!=$cryptPass($passord,$post)) // Denne linjen skal settes inn igjen n�r vi begynner med krypterte passord!
		if($brukerinfo['passord']!=$passord)                     // Denne linjen skal FJERNES
		   return false;
		$this->KNr=$brukerinfo['KNr'];
		$this->fornavn=$brukerinfo['Fornavn'];
		$this->etternavn=$brukerinfo['Etternavn'];
		$this->adresse=$brukerinfo['Adresse'];
		$this->postnr=$brukerinfo['PostNr'];
		$this->telefon=$brukerinfo['Telefonnr'];
		$this->epost=$brukerinfo['epost'];
		$this->passord=$brukerinfo['passord'];
		$this->utlogging=time()+$this->sessionExpire;
		return true;
	}

	function refreshSession()
	{
	   if(time()>$this->utlogging)
	      return false;
		$this->utlogging=time()+$this->sessionExpire;
		return true;
	}

	/*function endreBruker($fornavn, $etternavn, $epost, $telefon)
	{
	   $db=new sqlConnection();
		$error['fornavn']=$this->setFornavn(trim(mysql_real_escape_string($fornavn,$db->getLink())));
		$error['etternavn']=$this->setEtternavn(trim(mysql_real_escape_string($etternavn,$db->getLink())));
		$error['epost']=$this->setEpost(trim(mysql_real_escape_string($epost,$db->getLink())),$db);
		$error['telefon']=$this->setTelefon(trim(mysql_real_escape_string($telefon,$db->getLink())));
		$db->close();
		unset($db);
		return $error;
	}

	function lagreBruker()
	{
	   $id=$this->id;
	   $fornavn=$this->fornavn;
	   $etternavn=$this->etternavn;
	   $epost=$this->epost;
	   $telefon=$this->telefon;

		$db=new sqlConnection();
		$resultat=$db->update("brukere","fornavn='$fornavn',etternavn='$etternavn',epost='$epost',telefon='$telefon'","id=$id");
		$db->close();
		if(!(is_bool($resultat) && $resultat==true))
			return false;
		return true;
	}

	function endrePassord($gammelt,$nytt,$nytt2)
	{
	   $db=new sqlConnection();
	   $gammelt=trim(mysql_real_escape_string($gammelt,$db->getLink()));
	   $nytt=trim(mysql_real_escape_string($nytt,$db->getLink()));
	   $nytt2=trim(mysql_real_escape_string($nytt2,$db->getLink()));
	   $db->close();
		$kryptGammelt=new CryptPass($gammelt,$this->etternavn.$this->fornavn);
		if($kryptGammelt->getPass()!=$this->passord)
		   return "<span class=\"skjemafeil\">Feil n�v�rende passord.</span>";
		if($nytt!=$nytt2)
         return "<span class=\"skjemafeil\">Passordene du skrev var ikke like.</span>";
		if(!(strlen($nytt)>=6))
		   return "<span class=\"skjemafeil\">Passordet m� v�re p� minst 6 tegn.</span>";

		$kryptNytt=new CryptPass($nytt,$this->etternavn.$this->fornavn);
		$db=new sqlConnection();
		$resultat=$db->update("brukere","passord='".$kryptNytt->getPass()."'","id=".$this->id);
		if(!(is_bool($resultat) && $resultat==true))
			return "<span class=\"skjemafeil\">Databasefeil ved lagring av nytt passord. Vennligst pr�v igjen eller kontakt Henrik.</span>";
		$this->passord=$kryptNytt->getPass();
		$_SESSION['bruker']=serialize($this);
		return "<span class=\"skjemaOk\">Passordet ditt ble endret.</span>";
	}*/
}

?>