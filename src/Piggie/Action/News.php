<?php
/**
 * Created by Gary Hockin.
 * Date: 05/02/2015
 * @GeeH
 */

namespace Piggie\Action;

use Phly\Http\Request;
use Phly\Http\Response;

class News
{
    public function __invoke(Request $request, Response $response)
    {
        if ($request->getMethod() === 'GET') {
            $response = $response->withStatus(500);
            $response->getBody()->write('<h1>500 Error</h1><p>News is fucked</p>');
            return $response;
        }
        return 'POSTED';
    }
}