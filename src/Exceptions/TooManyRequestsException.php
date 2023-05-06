<?php

namespace Vandar\Cashier\Exceptions;

use Psr\Http\Message\ResponseInterface;

class TooManyRequestsException extends ResponseException
{
    public function __construct(ResponseInterface $response, array $context)
    {
	    parent::__construct($response,
		    $response->json()['errors'][0],
		    $response->getStatusCode(),
		    $context);
    }
}
