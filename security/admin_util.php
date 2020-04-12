<?php
//utility, get admin username, set/check password, get/set email

namespace security;

class Admin {
	private $username;
	private $password_h;
	private $email;
	
	public function __construct(){
		require_once '../databases/query.php';
		$res = \database\query("SELECT val FROM config WHERE nam='admin'")[0]['val'];
		$dat = json_decode($res, true);
		
		$this->username = $dat['username'];
		$this->password_h = $dat['password_h'];
		$this->email = $dat['email'];
	}
	
	public function checkPassword($candidate){
		return password_verify($candidate, $this->password_h);
	}
	public function getUsername(){return $this->username;}
	public function getEmail(){return $this->email;}
	
	public function setPassword($newpass)
	{
		$dat = array();
		$dat['username'] = $this->username;
		$dat['password_h'] = password_hash($newpass);
		$dat['email'] = $this->email;
		$put = json_encode($dat);
		\database\query("UPDATE config SET val = :put WHERE nam='admin'", ['put'=>$put]);
	}
	public function setEmail($email)
	{
		$dat = array();
		$dat['username'] = $this->username;
		$dat['password_h'] = $this->password_h;
		$dat['email'] = $email;
		$put = json_encode($dat);
		\database\query("UPDATE config SET val = :put WHERE nam='admin'", ['put'=>$put]);
	}
	
	
}