<?php
$autoloader = dirname( __FILE__ ) . '/vendor/autoload.php';

if ( is_readable( $autoloader ) ) {
    require_once $autoloader;
}

use Automattic\WooCommerce\Client;

$woocommerce = new Client(
    'http://localhost/tool-shop/',
    'ck_48f1ec50d1ea6b8a94e4547c02d7af3aceb6754e',
    'cs_f0d08380043961e318dbd7ebc49fd48a91def0b8',
    [
        'wp_api'  => true,
        'version' => 'wc/v2',
    ]
);


function getIdProduct($product_price , $products) {

    foreach ($products as $product) {
        if($product->price != $product_price) {
            return false;
        } else {
            return($product->id);
        }

    }
}


$products = $woocommerce->get('products',  array('per_page' => 100, 'page' => 10));


$id_product = 44;

//$products = $woocommerce->get('products/'.$id_product.'');

$id = getIdProduct('277' , $products);

if($id_product != false) {
    $data = [
        'payment_method' => 'bacs',
        'payment_method_title' => 'Direct Bank Transfer',
        'set_paid' => true,
        'billing' => [
            'first_name' => 'Test',
            'last_name' => 'Test',
            'address_1' => '969 Market',
            'address_2' => '',
            'city' => 'San Francisco',
            'state' => 'CA',
            'postcode' => '94103',
            'country' => 'US',
            'email' => 'test@test.com',
            'phone' => '(555) 555-5555'
        ],
        'shipping' => [
            'first_name' => 'Test',
            'last_name' => 'Test',
            'address_1' => '969 Market',
            'address_2' => '',
            'city' => 'San Francisco',
            'state' => 'CA',
            'postcode' => '94103',
            'country' => 'US'
        ],
        'line_items' => [
            [
                'product_id' => $id_product,
                'quantity' => 2
            ],

        ],

    ];


    print_r($woocommerce->post('orders', $data));
}



echo "<pre>";
print_r($id);
//print_r($products);
echo "</pre>";
