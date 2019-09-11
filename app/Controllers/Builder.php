<?php
namespace app\Controllers;
use Exception;
require_once 'Url.php';
use app\Controllers\Url;

class Builder
{
    private $server;
    private $secret;
    private $original;
    private $commands;
    public static function construct($server, $secret, $original)
    {
        return new self($server, $secret, $original);
    }
    public function __construct($server, $secret, $original)
    {
        $this->server = $server;
        $this->secret = $secret;
        $this->original = $original;
        $this->commands = new CommandSet();
    }
    public function __clone()
    {
        $this->commands = clone $this->commands;
    }
    // Proxy remaining method calls to CommandSet
    public function __call($method, $args)
    {
        $proxied = array($this->commands, $method);
        if (!is_callable($proxied)) {
            throw new Exception(sprintf(
                'Method "%s" not found for %s',
                $method,
                get_class($this->commands)
            ));
        }
        call_user_func_array($proxied, $args);
        return $this;
    }
    public function build()
    {
        return new Url(
            $this->server,
            $this->secret,
            $this->original,
            $this->commands->toArray()
        );
    }
    public function __toString()
    {
        return (string) $this->build();
    }
}