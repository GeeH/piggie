<?php
/**
 * Created by Gary Hockin.
 * Date: 05/02/2015
 * @GeeH
 */

namespace Piggie\Application;


use Phly\Http\Request;
use Phly\Http\Response;

class Application
{

    /**
     * @var array
     */
    private $middleware = [];

    /**
     * @param callable $middleware
     * @return $this
     */
    public function addMiddleware($name, callable $middleware)
    {
        $this->middleware[$name] = $middleware;
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

        $renderer = new \Piggie\Renderer(array_pop($result));
        echo $renderer->render();
    }
}