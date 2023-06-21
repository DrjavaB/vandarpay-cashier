<?php

namespace Vandar\Cashier\Client;

use Log;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Vandar\Cashier\Exceptions\AuthenticationException;
use Vandar\Cashier\Exceptions\DeprecatedAPIException;
use Vandar\Cashier\Exceptions\ExternalAPIException;
use Vandar\Cashier\Exceptions\InvalidPayloadException;
use Vandar\Cashier\Exceptions\TooManyRequestsException;
use Vandar\Cashier\Exceptions\UnexpectedAPIErrorException;

class Thrower
{
	/**
	 * @param ResponseInterface $response
	 * @param array             $context
	 *
	 * @throws AuthenticationException when http 401 is encountered
	 * @throws DeprecatedAPIException when http 404 is encountered
	 * @throws InvalidPayloadException when http 422 is encountered, this should be handled further in listeners and api callers
	 * @throws TooManyRequestsException when http 429 is encountered
	 * @throws UnexpectedAPIErrorException when an unknown 400-series exception is returned.
	 */
	public static function process(ResponseInterface $response, array $context = [])
	{
		
		if (
            gettype($response->json(), 'array') &&
            array_key_exists('message', $response->json())
        ) {
            Log::debug($response->getStatusCode() . ' ' . $response->getBody());
            throw new HttpException($response->getStatusCode(), $response->json()['message']);
        }

		// Response code is in 100, 200, 300 series.
		if ($response->getStatusCode() < 400) {
			return;
		}
		
		if ($response->getStatusCode() >= 500) {
			throw new ExternalAPIException($response, $context);
		}
		
		switch ($response->getStatusCode()) {
			case 401: // Unauthenticated
				throw new AuthenticationException($response, $context);
			case 404: // Not Found
				throw new NotFoundHttpException();
			case 405: // Method Not Allowed
				throw new MethodNotAllowedException();
			case 410: // Gone
				throw new DeprecatedAPIException($response, $context);
			case 422: // Unprocessable entity
				throw new InvalidPayloadException($response, $context);
			case 429: // Too Many Requests
				throw new TooManyRequestsException($response, $context);
			default:
				throw new UnexpectedAPIErrorException($response, $context);
		}
	}
}
