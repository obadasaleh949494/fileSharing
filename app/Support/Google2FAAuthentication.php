<?php
namespace App\Support;
use PragmaRX\Google2FALaravel\Support\Authenticator;

class Google2FAAuthentication extends Authenticator 
{
	protected function canPassWithoutChecking ()
	{
		if(!count($this->getUser()->passworddSecurity))
		{
			return true;
		}
	return !$this->getUser()->passworddSecurity->google2fa_enable || !$this->enabled() || $this->noUserIsAuthenticated() || $this->twoFactorAuthStillValid();
		
	}
	protected function getGoogle2FaSecretKey()
	{
		$secret=$this->getUser()->passworddSecurity->{$this->config('otp_secret_column')};

		if(is_null($secret)|| empty($secret))
			throw new InvalidSecretKey("secret key can not be empty");
			
			return $secret;
	}
}