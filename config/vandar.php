<?php

return [
    #------------------------
    # IPG Callback Url for return requests from bank page (Inserted in the Vandar dashboard)
    #------------------------
    'callback_url' => env('VANDAR_CALLBACK_URL'),

    #------------------------
    # Mandate Callback Url for return requests from bank page (Inserted in the Vandar dashboard)
    #------------------------
    'mandate_callback_url' => env('VANDAR_MANDATE_CALLBACK_URL'),

    #------------------------
    # Notify Url for getting webhook request from Vandar
    #------------------------
    'notify_url' => env('VANDAR_NOTIFY_URL'), // Default is route('vandar.webhook.withdrawal')


    #------------------------
    # Notify Url for getting webhook request from Vandar
    #------------------------
    'settlement_notify_url' => env('VANDAR_SETTLEMENT_NOTIFY_URL'), // Default is route('vandar.webhook.settlement')

    #------------------------
    # Prefix for Vandar HTTP Routes
    #------------------------
    'path' => env('VANDAR_CASHIER_PATH', 'vandar'),


    #------------------------
    # Registered mobile number in Vandar for login
    #------------------------
    'mobile' => env('VANDAR_MOBILE'),


    #------------------------
    # Vandar Account Password for login
    #------------------------
    'password' => env('VANDAR_PASSWORD'),


    #------------------------
    # Business name in vandar, is used for sending request
    #------------------------
    'business_slug' => env('VANDAR_BUSINESS_SLUG'),


    #------------------------
    # API Key of IPG for sending requests
    #------------------------
    'api_key' => env('VANDAR_API_KEY'),

	#------------------------
	# PORT for sending requests (SAMAN | BEHPARDAKHT)
	#------------------------
	'port' => env('VANDAR_PORT'),

    #------------------------
	# TOKEN for private requests
	#------------------------
	'access_token' => env('VANDAR_ACCESS_TOKEN'),
	'refresh_token' => env('VANDAR_REFRESH_TOKEN'),
	
	'api_base_url' => 'https://api.vandar.io/',
	'ipg_base_url' => 'https://ipg.vandar.io/',
	'batch_settlement_url' => 'https://batch.vandar.io/',
	'mandate_redirect_url' => 'https://subscription.vandar.io/authorizations/',
];
