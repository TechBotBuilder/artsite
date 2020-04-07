<?php
//session class with static methods

namespace security;

class SecureSession {
	public static function session_start(){
		session_save_path('');//TODO check if host is secure or choose a location
		session_start();
	}
	
}