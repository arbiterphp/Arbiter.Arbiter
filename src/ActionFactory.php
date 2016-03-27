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
 * A factory for Action instances.
 *
 * @package arbiter/arbiter
 *
 */
class ActionFactory
{
    /**
     *
     * Returns a new Action instance.
     *
     * @param mixed $input The input specification.
     *
     * @param mixed $domain The domain specification.
     *
     * @param mixed $responder The responder specification.
     *
     * @return Action
     *
     */
    public function newInstance($input, $domain, $responder)
    {
        return new Action($input, $domain, $responder);
    }
}
