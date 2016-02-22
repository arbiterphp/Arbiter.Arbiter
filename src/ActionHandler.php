<?php
namespace Arbiter;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ActionHandler
{
    protected $resolver;

    public function __construct(callable $resolver = null)
    {
        $this->resolver = $resolver;
    }

    public function handle(Action $action, Request $request, Response $response)
    {
        $responder = $this->resolve($action->getResponder());

        $domain = $this->resolve($action->getDomain());
        if (! $domain) {
            return $responder($request, $response);
        }

        $params = $this->params($action, $request);
        $payload = call_user_func_array($domain, $params);
        return $responder($request, $response, $payload);
    }

    protected function params(Action $action, Request $request)
    {
        $input = $this->resolve($action->getInput());
        if (! $input) {
            return [];
        }

        return (array) $input($request);
    }

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
