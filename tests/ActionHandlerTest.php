<?php
namespace Elemental;

use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;

class ActionHandlerTest extends \PHPUnit_Framework_TestCase
{
    protected $actionHandler;
    protected $actionFactory;

    protected function setUp()
    {
        $this->actionFactory = new ActionFactory();
        $resolver = function ($spec) {
            // this fake resolver just returns the spec directly
            return $spec;
        };
        $this->actionHandler = new ActionHandler($resolver);
    }

    protected function newAction($input, $domain, $responder)
    {
        return $this->actionFactory->newInstance($input, $domain, $responder);
    }

    protected function assertResponse(Action $action, $expect)
    {
        $request = ServerRequestFactory::fromGlobals();
        $response = $this->actionHandler->handle(
            $action,
            $request,
            new Response()
        );
        $this->assertEquals($expect, $response->getBody()->__toString());
    }

    public function testAllElements()
    {
        $input = function ($request) {
            return [$request->getQueryParams()['noun']];
        };

        $domain = function ($noun) {
            return "Hello $noun";
        };

        $responder = function ($request, $response, $payload) {
            $response->getBody()->write($payload);
            return $response;
        };

        $action = $this->newAction($input, $domain, $responder);

        $_GET['noun'] = 'world';
        $this->assertResponse($action, 'Hello world');
    }

    public function testWithoutInput()
    {
        $domain = function () {
            return 'no input';
        };

        $responder = function ($request, $response, $payload) {
            $response->getBody()->write($payload);
            return $response;
        };

        $action = $this->newAction(null, $domain, $responder);

        $this->assertResponse($action, 'no input');
    }

    public function testWithoutInputOrDomain()
    {
        $responder = function ($request, $response) {
            $response->getBody()->write('no domain');
            return $response;
        };
        $action = $this->newAction(null, null, $responder);
        $this->assertResponse($action, 'no domain');
    }

    public function testWithoutResolver()
    {
        $this->actionHandler = new ActionHandler();
        $this->testAllElements();
    }
}
