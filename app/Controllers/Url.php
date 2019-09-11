<?php
namespace app\Controllers;

require_once 'CommandSet.php';
use app\Controllers\CommandSet;

class Url
{
	private $server;
    private $secret;
    private $original;
    private $commands = [];
    
    public function __construct($server, $secret, $original, $commands) {
        $this->server = $server;
        $this->secret = $secret;
        $this->original = $original;
        $this->commands = $commands;
    }

    public function stringify($server, $secret, $original, $commands) {
    	if(count($commands) > 0 ) {
    		$commandPath = implode('/', $commands);
    		$imgPath = sprintf('%s/%s', $commandPath, $original);
    	} else {
    		$imgPath = $original;
    	}

    	$signature = $secret ? self::signURL($imgPath, $secret) : 'unsafe';

    	return sprintf(
    		'%s/%s/%s',
    		$server,
    		$signature,
    		$imgPath
    	);
    }

    public function signURL($msg, $secret) {
    	$signature = hash_hmac("sha1", $msg, $secret, true);
    	return strtr(base64_encode($signature), '/+', '_-');
    }

    public function __toString() {
    	return $this->stringify(
    		$this->server,
            $this->secret,
            $this->original,
            $this->commands
    	);
    }
}

?>