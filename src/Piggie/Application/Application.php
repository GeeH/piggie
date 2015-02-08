<?php
/**
 * Created by Gary Hockin.
 * Date: 05/02/2015
 * @GeeH
 */

namespace Piggie\Application;


use Phly\Http\Request;
use Phly\Http\Response;
use Piggie\Renderer;

class Application
{
    /**
     * @var array
     */
    private $middleware = [];
    /**
     * @var Renderer
     */
    private $renderer;

    function __construct(Renderer $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * @param callable $middleware
     * @return $this
     */
    public function addMiddleware($name, callable $middleware)
    {
        $this->middleware[$name] = $middleware;
    }

    /**
     * @return array
     */
    public function getMiddleware()
    {
        return $this->middleware;
    }

    /**
     * @param Request $request
     * @param Response $response
     */
    public function run(Request $request, Response $response)
    {
        $result = [];
        foreach ($this->middleware as $name => $function) {
            $result[$name] = $function($request, $response, $result);
            if ($result[$name] instanceof Response) {
                break;
            }
        }

        echo $this->renderer->render();
    }
}