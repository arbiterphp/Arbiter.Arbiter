<?php
namespace Arbiter;

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

    protected function assertResponse(Action $action, $request, $expect)
    {
        $response = $this->actionHandler->handle(
            $action,
            $request,
            []
        );
        $this->assertEquals($expect, $response['output']);
    }

    public function testAllElements()
    {
        $input = function ($request) {
            return [isset($request['noun']) ? $request['noun']:''];
        };

        $domain = function ($noun) {
            return "Hello $noun";
        };

        $responder = function ($request, $response, $payload) {
            $response['output'] = $payload;
            return $response;
        };

        $action = $this->newAction($input, $domain, $responder);

        $request = ['noun' => 'world'];
        $this->assertResponse($action, $request, 'Hello world');
    }

    public function testWithoutInput()
    {
        $input = null;

        $domain = function () {
            return 'no input';
        };

        $responder = function ($request, $response, $payload) {
            $response['output'] = $payload;
            return $response;
        };

        $action = $this->newAction($input, $domain, $responder);

        $this->assertResponse($action, [], 'no input');
    }

    public function testWithoutInputOrDomain()
    {
        $input = null;

        $domain = null;

        $responder = function ($request, $response) {
            $response['output'] = 'no domain';
            return $response;
        };

        $action = $this->newAction($input, $domain, $responder);

        $this->assertResponse($action, [], 'no domain');
    }

    public function testWithoutResponder()
    {
        $input = null;
        $domain = null;
        $responder = null;
        $action = $this->newAction($input, $domain, $responder);

        $this->setExpectedException(
            Exception::CLASS,
            'Could not resolve responder for action.'
        );
        $this->assertResponse($action, [], 'no domain');
    }

    public function testWithoutResolver()
    {
        $this->actionHandler = new ActionHandler();
        $this->testAllElements();
    }
}
