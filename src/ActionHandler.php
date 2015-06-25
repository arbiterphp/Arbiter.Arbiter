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

        $domainSpec = $action->getDomain();
        if (! $domainSpec) {
            return $responder($request, $response);
        }

        $domain = $this->resolve($domainSpec);
        $params = $this->params($action, $request);
        $payload = call_user_func_array($domain, $params);
        return $responder($request, $response, $payload);
    }

    protected function params(Action $action, Request $request)
    {
        $inputSpec = $action->getInput();
        if (! $inputSpec) {
            return [];
        }

        $input = $this->resolve($inputSpec);
        return (array) $input($request);
    }

    protected function resolve($spec)
    {
        if (! $this->resolver) {
            return $spec;
        }

        return call_user_func($this->resolver, $spec);
    }
}
