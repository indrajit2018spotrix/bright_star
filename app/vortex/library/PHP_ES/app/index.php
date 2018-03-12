<?php

	require '../vendor/autoload.php';
	use Elasticsearch\ClientBuilder;

	$elastic_host = "127.0.0.1:9200";
    $hosts = [
            $elastic_host
    ];
    $client = ClientBuilder::create()->setHosts($hosts)->build();


    // START: CREATE A NEW INDEX
 //    $client = ClientBuilder::create()->build();
	// $params = [
	//     'index' => 'pokedex'
	// ];

	// $response = $client->indices()->create($params);
	// END: CREATE A NEW INDEX

    $response = $client->indices()->getMapping();

    print_r(json_encode($response));

?>