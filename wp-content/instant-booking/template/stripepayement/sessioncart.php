<?php

require WPPLUGIN_DIR .'vendor/autoload.php';

\Stripe\Stripe::setApiKey('sk_test_51L82n0KaE22cyrkbZGChWTYtm9h7b2rMhyLvWC233xAyNwNJijmxDj0jSWMOe6wdKQwyRJJ2k1bLH38rVwCQK5zW00n0flgYvL');

header('Content-Type: application/json');

   $YOUR_DOMAIN = 'WPPLUGIN_URL';    
   $checkout_session = \Stripe\Checkout\Session::create([
      'line_items' => [[
        'price_data' =>[
                    'unit_amount' => 2000,
                    'currency' => 'usd',
                    'product_data' => [
                                  'name' => 'ycjhcgjzky',
                              ],
                  ],
        'quantity'=> 1
      ]],
      'mode' => 'payment',
      'success_url' => 'https://example.com/success',
      'cancel_url' => 'https://example.com/cancel',
    ]);


    wp_send_json($checkout_session);