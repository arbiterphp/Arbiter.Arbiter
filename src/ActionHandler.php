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
 * Actually performs a given Action: collects input, sends that input to the
 * domain, gets back the domain output, and passes that output to the responder.
 *
 * @package arbiter/arbiter
 *
 */
class ActionHandler
{
    /**
     *
     * Resvoles each Action specification to a callable.
     *
     * @var callable
     *
     */
    protected $resolver;

    /**
     *
     * Constructor.
     *
     * @param callable $resolver Resvoles each Action specification to a
     * callable; when not present, each specification is presumed to already be
     * callable.
     *
     */
    public function __construct(callable $resolver = null)
    {
        $this->resolver = $resolver;
    }

    /**
     *
     * Performs the Action: collects input, passes that input to the domain and
     * gets back the output, and passes that output to the responder.
     *
     * @param Action $action The Action to perform.
     *
     * @param mixed $request the input context
     *
     * @param mixed $response the output context
     *
     * @return mixed the output of the responder
     *
     */
    public function handle(Action $action, $request, $response)
    {
        $responder = $this->resolve($action->getResponder());
        if (! $responder) {
            throw new Exception('Could not resolve responder for action.');
        }

        $domain = $this->resolve($action->getDomain());
        if (! $domain) {
            return $responder($request, $response);
        }

        $params = [];
        $input = $this->resolve($action->getInput());
        if ($input) {
            $params = (array) $input($request);
        }

        $payload = call_user_func_array($domain, $params);
        return $responder($request, $response, $payload);
    }

    /**
     *
     * Resolves a specification into a callable.
     *
     * @param mixed $spec The specification.
     *
     * @return callable|null
     *
     */
    protected function resolve($spec)
    {
        if (! $spec) {
            return null;
        }

        if (! $this->resolver) {
            return $spec;
        }

        return call_user_func($this->resolver, $spec);
    }
}
