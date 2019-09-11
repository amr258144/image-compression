<?php

namespace app\Controllers;

class BuilderFactory
{
    private $server;
    private $secret;
    
    public static function construct($server, $secret=null)
    {
        return new self($server, $secret);
    }
    
    public function __construct($server, $secret=null)
    {
        $this->server = $server;
        $this->secret = $secret;
    }
    
    public function url($original)
    {
        return Builder::construct($this->server, $this->secret, $original);
    }
}