<?php
//session class with static methods
// credit to Robert Hafner at blog.teamtreehouse.com/how-to-create-bulletproof-sessions with modifications

namespace security;

class SecureSession {
	public static function sessionStart(){
		session_save_path('../sessions/');//TODO check if host is secure or choose a location
		session_set_cookie_params(['domain'=>$_SERVER['SERVER_NAME']]);
		session_start();
		
		if(self::validateSession())
		{
			if(!self::isHijacked())
			{
				error_log('WARN: POSSIBLE SESSION HIJACK: IP changed from '
					.$_SESSION['IPaddress']??'(none)'.' to '.$_SERVER['REMOTE_ADDR']
					.', user agent from '.strip_tags($_SESSION['userAgent']??'(none)').' to '.strip_tags($_SERVER['HTTP_USER_AGENT']),
					3 /*send to file*/,
					'../logs/session.log'
				);
				$_SESSION = array();
				$_SESSION['IPaddress'] = $_SERVER['REMOTE_ADDR'];
				$_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
				self::regenerateSession();
			}elseif(rand(1, 100) <= 5){
				//5% chance to regenerate session anyway
				// to keep the session ID a moving target.
				self::regenerateSession();
			}
		}else{
			$_SESSION = array();
			session_destroy();
			session_start();
		}
	}
	
	protected static function isHijacked(){
		if(!isset($_SESSION['IPaddress']) || !isset($_SESSION['userAgent']))
			return false;
		if($_SESSION['IPaddress'] != $_SERVER['REMOTE_ADDR'])
			return false;
		if($_SESSION['userAgent'] != $_SERVER['HTTP_USER_AGENT'])
			return false;
	}
	
	public static function regenerateSession()
	{
		//if the session is obsolete, there is already a new ID
		if(isset($_SESSION['OBSOLETE']) || $_SESSION['OBSOLETE'])
			return;
		
		//set current session to expire in 10 seconds
		$_SESSION['OBSOLETE'] = true;
		$_SESSION['EXPIRES'] = time() + 10;
		
		// create a new session without destroying the old one.
		session_regenerate_id(false);
		
		// grab current session ID and close both sessions
		$newSession = session_id();
		session_write_close();
		
		// set session ID to the new one, and start back up again.
		session_id($newSession);
		session_start();
		
		//unset obsolete/expiratin values for the new session (we want to keep it)
		unset($_SESSION['OBSOLETE']);
		unset($_SESSION['EXPIRES']);
	}
	
	protected static function validateSession()
	{
		//invalid if is obsolete or expired
		if (isset($_SESSION['OBSOLETE']) && !isset($_SESSION['EXPIRES']))
			return false;
		if (isset($_SESSION['EXPIRES']) && $_SESSION['EXPIRES'] < time())
			return false;
		
		return true;
	}
	
}