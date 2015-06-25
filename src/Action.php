<?php
namespace Arbiter;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 *
 * Describes an action in terms of the input to be collected, the domain to be
 * invoked, and the responder that will build the response.
 *
 */
class Action
{
    protected $input;
    protected $domain;
    protected $responder;

    public function __construct($input, $domain, $responder)
    {
        $this->input = $input;
        $this->domain = $domain;
        $this->responder = $responder;
    }

    public function getInput()
    {
        return $this->input;
    }

    public function getDomain()
    {
        return $this->domain;
    }

    public function getResponder()
    {
        return $this->responder;
    }
}
