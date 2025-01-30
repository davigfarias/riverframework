<?php

namespace Src\HTTP;

use ArrayObject;

/**
 * @author Dave Farias (davegfarias@gmail.com)
 * @package HTTP;
 */
class Request
{
    public function __construct(
        public readonly ArrayObject $get,
        public readonly ArrayObject $post,
        public readonly ArrayObject $cookies,
        public readonly ArrayObject $files,
        public readonly ArrayObject $server
    ) {
    }

    public static function createFromGlobals(): static
    {
        $flags = ArrayObject::ARRAY_AS_PROPS | ArrayObject::STD_PROP_LIST;
        $get = new ArrayObject($_GET, $flags);
        $post = new ArrayObject($_POST, $flags);
        $cookie = new ArrayObject($_COOKIE, $flags);
        $files = new ArrayObject($_FILES, $flags);
        $server = new ArrayObject($_SERVER, $flags);

        return new static($get, $post, $cookie, $files, $server);
    }

    public function __get(string $name)
    {
        if(isset($this->post[$name]))
        {
            return $this->post[$name];
        }

        if(isset($this->get[$name]))
        {
            return $this->get[$name];
        }

        if(isset($this->cookies[$name]))
        {
            return $this->cookies[$name];
        }

        if(isset($this->files[$name]))
        {
            return $this->files[$name];
        }

        if(isset($this->server[$name]))
        {
            return $this->server[$name];
        }

        return null;

    }

    public function remove(string $name): void
    {
        
        if(isset($this->post[$name]))
        {
            unset($this->post[$name]);
        }

        if(isset($this->get[$name]))
        {
            unset($this->get[$name]);
        }

        if(isset($this->cookies[$name]))
        {
            unset($this->cookies[$name]);
        }

        if(isset($this->files[$name]))
        {
            unset($this->files[$name]);
        }

        if(isset($this->server[$name]))
        {
            unset($this->server[$name]);
        }
    }
}