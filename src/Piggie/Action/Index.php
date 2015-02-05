<?php
/**
 * Created by Gary Hockin.
 * Date: 05/02/15
 * @GeeH
 */

namespace Piggie\Action;

use Phly\Http\Request;
use Phly\Http\Response;

class Index
{
    function __invoke(Request $request, Response $response, array $results = [])
    {
        return '<h1>Welcome to My World</h1>';
    }
}