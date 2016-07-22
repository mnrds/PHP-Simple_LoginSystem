<?php
	// Simple PHP LoginSystem
	// by mnrds
	//
	// Version 1.2
	// https://github.com/mnrds/PHP-Simple_LoginSystem
	// ----------------------------------------------------------

	$acc2 = $_POST['account'];
	$pass2  = $_POST['pass'];
	$rcode  = $_POST['code'];
	
	// Code for account making
	$ccode = 'CODE1';
	
	// Username taken?
	$search = "$acc2";
	$lines = file('acc_list2.php');
	foreach($lines as $line){
		if(strpos($line, $search) !== false){
			echo "Username $acc2 is taken. ";
			exit();
		}
	}
	
	// If fields default --> error
	if($acc2 == "Account name" || $pass2 == "Password") { 
		echo "Invalid Account name / Password. "; 
		exit(); 
	}
	
	// check if name only contains letters, numbers and whitespace
	// Username check
	if (!preg_match("/^[a-z0-9.]+$/i",$acc2)) {
		echo "Only letters, numbers and white space allowed. ";
		exit();
    	}
    	// Password check
	if (!preg_match("/^[a-z0-9.]+$/i",$pass2)) {
		echo "Only letters, numbers and white space allowed. ";
		exit();
	}
	
	// Coocie check (spamprotect)
	if(isset($_COOKIE['creg'])) { 
		echo "Stop spamming. "; exit(); 
	}
	
	// If fields empty --> error
	if(empty($acc2)) { echo "Error: No nicname. "; exit(); }
	if(empty($pass2))  { echo "Error: No message. "; exit(); }
	if(empty($rcode))  { echo "Error: No code. "; exit(); }
	
	// If wrong code --> error
	if(($rcode) != $ccode)  { echo "Error: Wrong code."; exit(); }
	
	// 2min spam time
  	setcookie("creg", creg, time()+120);
	
	// Adding style
	$logit2 = "\n$";
	$logit3 = '"';
	$logitUSN = "USN[";
	$logitACC = "$acc2";
	$logit4 = "] = ";
	$logit5 = "$pass2";
	$logit6 = ";";

  	// Fixing " and ' 
  	$logit = str_replace("\\\"","\"",$logit);
  	$logit = str_replace("\\'","'",$logit);
	$logit2 = str_replace("\\\"","\"",$logit2);
  	$logit2 = str_replace("\\'","'",$logit2);

	// Creating an account --> /acc_list2.php
  	$fp = fopen("acc_list2.php", "a+");
	fwrite($fp, $logit2); //rivi
	fwrite($fp, $logitUSN); //USN
	fwrite($fp, $logit3); //"
	fwrite($fp, $logitACC); //$acc
	fwrite($fp, $logit3); //"
	fwrite($fp, $logit4); //] ) 
	fwrite($fp, $logit3); //"
	fwrite($fp, $logit5); //pass
	fwrite($fp, $logit3); //"
	fwrite($fp, $logit6); //;
  	fclose($fp);

  	// Sending user back
  	echo "<br><br><br><center>New account $acc2 created.<br><br>
	You can now login <a href='index.html'>here</a></center>";
	exit();

?>
