<?php

namespace Vandar\Cashier;

use Vandar\Cashier\Client\Client;

class Vandar
{
	const VERSION = '1.0.0-b.6';
	
	// URL Generation Functionality
	protected const API_VERSIONS = [
		'AUTH' => '3',
		'TRANSACTION' => '3',
		'SETTLEMENT' => '3',
		'SETTLEMENT_LEGACY' => '2.1',
		'IPG' => '3',
		'MANDATE' => '3',
		'WITHDRAWAL' => '3',
		'CUSTOMER' => '2',
	];
	
	/**
	 * @return array
	 */
	public static function getBanksHealth(): array
	{
		return Client::request('GET', 'https://health.vandar.io/subscription')->json();
	}
	
	/**
	 * @param string      $api            can be AUTH, TRANSACTION, SETTLEMENT, IPG, IPG_API, MANDATE, MANDATE_API, or WITHDRAWAL
	 * @param string      $additional     Additional portion to add to the url
	 * @param string|null $version_number the api version to which the requests should be sent, for backwards compatibility
	 *                                    reasons
	 *
	 * @return string full url for the selected endpoint
	 */
	public static function url(string $api, string $additional = '', string $version_number = null): string
	{
		$base_url = config('vandar.ipg_base_url', 'https://ipg.vandar.io/');
		$business_slug = config('vandar.business_slug');
		$api = strtoupper($api);
		$append_version = true;
		$additional = $additional ? '/' . $additional : '';
		switch ($api) {
			case 'IPG_API':
				$base_url = $base_url.'api/';
				$api = 'IPG';
			break;
			case 'MANDATE':
				$base_url = config('vandar.mandate_redirect_url');
				$append_version = false;
			break;
			case 'MANDATE_API':
				$additional = 'business/' . $business_slug . '/subscription/authorization/' . $additional;
				$api = 'MANDATE';
			break;
			case 'WITHDRAWAL':
				$additional = 'business/' . $business_slug . '/subscription/withdrawal/' . $additional;
			break;
			case 'SETTLEMENT_LEGACY':
			case 'SETTLEMENT':
				$additional = 'business/' . $business_slug . '/settlement/' . $additional;
			break;
			case 'CUSTOMER':
				$base_url = config('vandar.api_base_url');
				$additional = 'business/' . $business_slug . '/customers' . $additional;
			break;
			case 'TRANSACTION':
				$base_url = config('vandar.api_base_url');
				$additional = 'business/' . $business_slug . '/transaction' . $additional;
			break;
			default:
		}
		
		if (!$append_version) {
			return $base_url . $additional;
		}
		return $base_url . 'v' . ($version_number ?? self::API_VERSIONS[ $api ]) . '/' . $additional;
	}
}
