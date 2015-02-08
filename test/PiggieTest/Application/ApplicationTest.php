<?php

/**
 * Created by Gary Hockin.
 * Date: 06/02/2015
 * @GeeH
 */

use Piggie\Renderer;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{


    public function testAddMiddleware()
    {
        $name     = 'miami';
        $renderer = $this->getRendererMock();

        $application = new Piggie\Application\Application($renderer);
        $application->addMiddleware($name, function () {
        });

        $middleware = $application->getMiddleware();

        $this->assertArrayHasKey($name, $middleware);
        $this->assertInternalType('callable', $middleware[$name]);
    }

    public function testRun()
    {
        $request  = new \Phly\Http\Request();
        $response = new \Phly\Http\Response();

        $middleware = $this->getMockBuilder('stdClass')
            ->setMethods(['__invoke'])
            ->getMock();
        $middleware->expects($this->once())
            ->method('__invoke')
            ->with($request, $response)
            ->will($this->returnValue($response));

        $renderer = $this->getRendererMock();
        $renderer->expects($this->once())
            ->method('render');

        $application = new \Piggie\Application\Application($renderer);
        $application->addMiddleware('mock', $middleware);

        $application->run($request, $response);
    }

    /**
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getRendererMock()
    {
        $renderer = $this->getMockBuilder(Renderer::class)
            ->setMethods(['render'])
            ->disableOriginalConstructor()
            ->getMock();
        return $renderer;
    }
}
