<?php
/**
 * Created by Gary Hockin.
 * Date: 04/02/2015
 * @GeeH
 */

namespace Piggie;


use Phly\Http\Response;

class Renderer
{
    /**
     * @var Response
     */
    private $response;

    function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function render()
    {
        $this->sendHeaders();
        return $this->response->getBody();
    }

    /**
     * Send response headers
     * Stolen from MWOP
     *
     * Sends the response status/reason, followed by all headers;
     * header names are filtered to be word-cased.
     *
     */
    private function sendHeaders()
    {
        if ($this->response->getReasonPhrase()) {
            header(sprintf(
                'HTTP/%s %d %s',
                $this->response->getProtocolVersion(),
                $this->response->getStatusCode(),
                $this->response->getReasonPhrase()
            ));
        } else {
            header(sprintf(
                'HTTP/%s %d',
                $this->response->getProtocolVersion(),
                $this->response->getStatusCode()
            ));
        }

        foreach ($this->response->getHeaders() as $header => $values) {
            $name  = $this->filterHeader($header);
            $first = true;
            foreach ($values as $value) {
                header(sprintf(
                    '%s: %s',
                    $name,
                    $value
                ), $first);
                $first = false;
            }
        }
    }
}