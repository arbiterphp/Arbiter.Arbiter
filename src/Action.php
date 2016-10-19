<?php
/**
 *
 * This file is part of Arbiter for PHP.
 *
 * @license MIT https://opensource.org/licenses/MIT
 *
 */
namespace Arbiter;

/**
 *
 * Describes an action in terms of the input to be collected, the domain to be
 * invoked, and the responder that will build the response.
 *
 * @package arbiter/arbiter
 *
 */
class Action
{
    /**
     *
     * The input specification.
     *
     * @var mixed
     *
     */
    protected $input;

    /**
     *
     * The domain specification.
     *
     * @var mixed
     *
     */
    protected $domain;

    /**
     *
     * The responder specification.
     *
     * @var mixed
     *
     */
    protected $responder;

    /**
     *
     * Constructor.
     *
     * @param mixed $input The input specification.
     *
     * @param mixed $domain The domain specification.
     *
     * @param mixed $responder The responder specification.
     *
     */
    public function __construct($input, $domain, $responder)
    {
        $this->input = $input;
        $this->domain = $domain;
        $this->responder = $responder;
    }

    /**
     *
     * Returns the input specification.
     *
     * @return mixed
     *
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     *
     * Returns the domain specification.
     *
     * @return mixed
     *
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     *
     * Returns the responder specification.
     *
     * @return mixed
     *
     */
    public function getResponder()
    {
        return $this->responder;
    }
}
