<?php

namespace App;

/**
 * Application configuration
 *
 * PHP version 5.4
 */
class Config
{

    /**
     * Database host
     * @var string
     */
    const DB_HOST = 'localhost';

    /**
     * Database name
     * @var string
     */
    const DB_NAME = 'mvclogin';

    /**
     * Database user
     * @var string
     */
    const DB_USER = 'mvcuser';

    /**
     * Database password
     * @var string
     */
    const DB_PASSWORD = 'Wakkera%18';

    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = true;
	
	/**
		*Secret key for hashing
		*@var boolean
		*/
	
	const SECRET_KEY = 'mTAG49mzoNVSjHXYGQepG5188a3eJxLh';
		
	    /**
     * Mailgun API key
     *
     * @var string
     */
    const MAILGUN_API_KEY = '17df3bcabdfb58087b1f26c08f946b25-e470a504-8ede63e2';

    /**
     * Mailgun domain
     *
     * @var string
     */
    const MAILGUN_DOMAIN = 'https://api.mailgun.net/v3/sandboxfb288f43df5149a1a464ea7ce83d6389.mailgun.org';
}
