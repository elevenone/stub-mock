<?php
// @codingStandardsIgnoreFile

namespace Jnjxp\Mockup;

use Psr\Http\Message\ResponseInterface as Response;

class Send
{

    public function __invoke($response)
    {
        $this->sendStatus($response);
        $this->sendHeaders($response);
        $this->sendBody($response);
    }

    protected function sendStatus(Response $response)
    {
        $version = $response->getProtocolVersion();
        $status = $response->getStatusCode();
        $phrase = $response->getReasonPhrase();
        header("HTTP/{$version} {$status} {$phrase}");
    }

    protected function sendHeaders(Response $response)
    {
        foreach ($response->getHeaders() as $name => $values) {
            $this->sendHeader($name, $values);
        }
    }

    protected function sendHeader($name, $values)
    {
        $name = str_replace('-', ' ', $name);
        $name = ucwords($name);
        $name = str_replace(' ', '-', $name);
        foreach ($values as $value) {
            header("{$name}: {$value}", false);
        }
    }

    protected function sendBody(Response $response)
    {
        $stream = $response->getBody();
        $stream->rewind();
        while (! $stream->eof()) {
            echo $stream->read(8192);
        }
    }
}
