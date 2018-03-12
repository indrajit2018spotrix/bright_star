<?php

	namespace app\vortex\library\PHP_ES;

	require 'vendor/autoload.php';
	use config\vortex\Host_Config;
	use Elasticsearch\ClientBuilder;

	class ES_Implementation{

		public static function getElasticHost($selected_elastic){
			$elastic_host = Host_Config::batch();
			return $elastic_host[$selected_elastic]['elastic_host'];
		}

		public static function init_es($selected_elastic){

			$elastic_host = ES_Implementation::getElasticHost($selected_elastic);

		    $hosts = [
		            $elastic_host
		    ];
		    $client = ClientBuilder::create()->setHosts($hosts)->build();

		    $response = $client->indices()->getMapping();

		    return $response;

		}

		// Check ElasticSearch Server is up or not
		public static function server_up(){

			$elastic_host=env('ELASTIC_HOST','');

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $elastic_host);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$elastic_up = json_decode(curl_exec($ch), true);
			curl_close($ch);

			$server_status=0;
			if(isset($elastic_up['cluster_uuid'])){
				$server_status=1;
			}

			return $server_status;

		}
		
		// Search Data with check the Index is exists or not
		public static function search_es($index,$type,$search_data){

			$elastic_host=env('ELASTIC_HOST','');
			$hosts = [
				$elastic_host
			];
			$client = ClientBuilder::create()->setHosts($hosts)->build();

			$params_check_index = ['index' => $index];
			$check_index=$client->indices()->exists($params_check_index);

			$return_array=array();
			$all_val=array();
			$total_val=0;

			//echo $search_data; die;
			if(!empty($check_index)){
				$params_serch_id = [
					'index' => $index,
					'type' => $type,
					'body' => $search_data
				];
				$response_serch_id = $client->search($params_serch_id);
				$all_val=$response_serch_id['hits']['hits'];
				$total_val=$response_serch_id['hits']['total'];
				$return_array['error']=0;
				$return_array['message']='Index Is Ok';
				$return_array['total']=$total_val;
				$return_array['value']=$all_val;
			}
			else{
				$return_array['error']=1;
				$return_array['message']='Index Not Exists';
				$return_array['total']=$total_val;
				$return_array['value']=$all_val;
			}

			return $return_array;

		}
		
		// Search Data with check the Index is exists or not
		public static function group_es($index,$type,$search_data){

			$elastic_host=env('ELASTIC_HOST','');
			$hosts = [
				$elastic_host
			];
			$client = ClientBuilder::create()->setHosts($hosts)->build();

			$params_check_index = ['index' => $index];
			$check_index=$client->indices()->exists($params_check_index);

			$return_array=array();
			$all_val=array();
			$total_val=0;

			if(!empty($check_index)){
				$params_serch_id = [
					'index' => $index,
					'type' => $type,
					'body' => $search_data
				];
				$response_serch_id = $client->search($params_serch_id);
				$all_val=$response_serch_id['aggregations']['group_by']['buckets'];
				$total_val=$response_serch_id['hits']['total'];
				$return_array['error']=0;
				$return_array['message']='Index Is Ok';
				$return_array['total']=$total_val;
				$return_array['value']=$all_val;
			}
			else{
				$return_array['error']=1;
				$return_array['message']='Index Not Exists';
				$return_array['total']=$total_val;
				$return_array['value']=$all_val;
			}

			return $return_array;

		}
		
		// Search By ID
		public static function search_by_id($index,$type,$id){

			$elastic_host=env('ELASTIC_HOST','');
			$hosts = [
				$elastic_host
			];
			$client = ClientBuilder::create()->setHosts($hosts)->build();

			$params_check_index = ['index' => $index];
			$check_index=$client->indices()->exists($params_check_index);
			$return_array=array();
			$all_val=array();
			$total_val=0;

			if(!empty($check_index)){
				$params_serch_id = [
					'index' => $index,
					'type' => $type,
					'body' => [
						'size' => 1,
						'query' => [
							'bool' => [
								'must' => [
									[ 'match' => [ '_id' => $id ] ],
								]
							]
						]
					]
				];
				$response_serch_id = $client->search($params_serch_id);
				$all_val=$response_serch_id['hits']['hits'];
				$total_val=$response_serch_id['hits']['total'];
				$return_array['id']=$id;
				$return_array['total']=$total_val;
				$return_array['value']=$all_val;
			}
			else{
				$return_array['error']=1;
				$return_array['message']='Index Not Exists';
				$return_array['total']=$total_val;
				$return_array['value']=$all_val;
			}

			return $return_array;

		}
		
		// Update Data in ElasticSearch
		public static function update_data($index,$type,$id,$updateData){

			$elastic_host=env('ELASTIC_HOST','');
			$hosts = [
				$elastic_host
			];
			$client = ClientBuilder::create()->setHosts($hosts)->build();

			$params_update = [
				'index' => $index,
				'type' => $type,
				'id' => $id,
				'body' => [
					'doc' => $updateData
				],
				'client' => [ 'ignore' => [400, 404] ]
			];
			$response_update = $client->update($params_update);
			$return_array=array();

			if(isset($response_update['_shards']['successful'])){
				if($response_update['_shards']['successful']==1){
					$return_array['id']=$response_update['_id'];
					$return_array['error']=0;
				}
				else{
					if($response_update['result']=='noop'){
						$return_array['id']=$response_update['_id'];
						$return_array['error']=0;
					}
					else{
						$return_array['id']=0;
						$return_array['error']=1;
					}
				}
			}
			else{
				$return_array['id']=0;
				$return_array['error']=1;
			}

			return $return_array;

		}
		
		// Insert Data in ElasticSearch
		public static function insert_data_id($index,$type,$addData,$id){

			$elastic_host=env('ELASTIC_HOST','');
			$hosts = [
				$elastic_host
			];
			$client = ClientBuilder::create()->setHosts($hosts)->build();

			$params_insert = [
				'index' => $index,
				'type' => $type,
				'id' => $id,
				'body' => $addData,
				'client' => [ 'ignore' => [400, 404] ]
			];
			$response_insert = $client->index($params_insert);

			$return_array=array();

			if(isset($response_insert['_shards']['successful'])){
				if($response_insert['_shards']['successful']==1){
					$return_array['id']=$response_insert['_id'];
					$return_array['error']=0;
				}
				else{
					if($response_insert['result']=='noop'){
						$return_array['id']=$response_insert['_id'];
						$return_array['error']=0;
					}
					else{
						$return_array['id']=0;
						$return_array['error']=1;
					}
				}
			}
			else{
				$return_array['id']=0;
				$return_array['error']=1;
			}

			return $return_array;

		}
		
		// Insert Data in ElasticSearch
		public static function insert_data($index,$type,$addData,$id=0){

			$elastic_host=env('ELASTIC_HOST','');
			$hosts = [
				$elastic_host
			];
			$client = ClientBuilder::create()->setHosts($hosts)->build();

			if($id!=0){
				$params_insert = [
					'index' => $index,
					'type' => $type,
					'id' => $id,
					'body' => $addData,
					'client' => [ 'ignore' => [400, 404] ]
				];
			}
			else{
				$params_insert = [
					'index' => $index,
					'type' => $type,
					'body' => $addData,
					'client' => [ 'ignore' => [400, 404] ]
				];
			}
			$response_insert = $client->index($params_insert);

			$return_array=array();
			if(isset($response_insert['_shards']['successful'])){
				if($response_insert['_shards']['successful']==1){
					$return_array['id']=$response_insert['_id'];
					$return_array['error']=0;
				}
				else{
					if($response_insert['result']=='noop'){
						$return_array['id']=$response_insert['_id'];
						$return_array['error']=0;
					}
					else{
						$return_array['id']=0;
						$return_array['error']=1;
					}
				}
			}
			else{
				$return_array['id']=0;
				$return_array['error']=1;
			}

			return $return_array;

		}
		
		// Delete Data in ElasticSearch
		public static function delete_data($index,$type,$id){

			$elastic_host=env('ELASTIC_HOST','');
			$hosts = [
				$elastic_host
			];
			$client = ClientBuilder::create()->setHosts($hosts)->build();

			$params_delete = [
				'index' => $index,
				'type' => $type,
				'id' => $id
			];
			$response_delete = $client->delete($params_delete);

			$return_array=array();

			if(isset($response_delete['_shards']['successful'])){
				if($response_delete['_shards']['successful']==1){
					$return_array['id']=$response_delete['_id'];
					$return_array['error']=0;
				}
				else{
					$return_array['id']=0;
					$return_array['error']=1;
				}
			}
			else{
				$return_array['id']=0;
				$return_array['error']=1;
			}

			return $return_array;

		}
		
		// Search Share Data with check the Index is exists or not
		public static function search_share($index,$type,$search_data){

			$elastic_host='http://niklavs:Niklavs1983@185.171.233.18:9200';
			$hosts = [
				$elastic_host
			];
			$client = ClientBuilder::create()->setHosts($hosts)->build();

			$params_check_index = ['index' => $index];
			$check_index=$client->indices()->exists($params_check_index);

			$return_array=array();
			$all_val=array();
			$total_val=0;

			if(!empty($check_index)){
				$params_serch_id = [
					'index' => $index,
					'type' => $type,
					'body' => $search_data
				];
				$response_serch_id = $client->search($params_serch_id);
				$all_val=$response_serch_id['hits']['hits'];
				$total_val=$response_serch_id['hits']['total'];
				$return_array['error']=0;
				$return_array['message']='Index Is Ok';
				$return_array['total']=$total_val;
				$return_array['value']=$all_val;
			}
			else{
				$return_array['error']=1;
				$return_array['message']='Index Not Exists';
				$return_array['total']=$total_val;
				$return_array['value']=$all_val;
			}

			return $return_array;

		}

		public static function cron_update_data($index,$type,$id,$updateData){

			$elastic_host=env('ELASTIC_HOST','');
			$hosts = [
				$elastic_host
			];
			$client = ClientBuilder::create()->setHosts($hosts)->build();

			$params_update = [
				'index' => $index,
				'type' => $type,
				'id' => $id,
				'body' => [
					'doc' => $updateData
				],
				'client' => [ 'ignore' => [400, 404, 409] ]
			];
			$response_update = $client->update($params_update);

			$return_array=array();

			if(isset($response_update['_shards']['successful'])){
				if($response_update['_shards']['successful']==1){
					$return_array['id']=$response_update['_id'];
					$return_array['error']=0;
				}
				else{
					if($response_update['result']=='noop'){
						$return_array['id']=$response_update['_id'];
						$return_array['error']=0;
					}
					else{
						$return_array['id']=0;
						$return_array['error']=1;
					}
				}
			}
			else{
				$return_array['id']=0;
				$return_array['error']=1;
			}

			return $return_array;

		}
		
		// Insert Data in ElasticSearch
		public static function cron_insert_data_id($index,$type,$addData,$id){

			$elastic_host=env('ELASTIC_HOST','');
			$hosts = [
				$elastic_host
			];
			$client = ClientBuilder::create()->setHosts($hosts)->build();

			$params_insert = [
				'index' => $index,
				'type' => $type,
				'id' => $id,
				'body' => $addData,
				'client' => [ 'ignore' => [400, 404, 409] ]
			];
			$response_insert = $client->index($params_insert);

			$return_array=array();

			if(isset($response_insert['_shards']['successful'])){
				if($response_insert['_shards']['successful']==1){
					$return_array['id']=$response_insert['_id'];
					$return_array['error']=0;
				}
				else{
					if($response_insert['result']=='noop'){
						$return_array['id']=$response_insert['_id'];
						$return_array['error']=0;
					}
					else{
						$return_array['id']=0;
						$return_array['error']=1;
					}
				}
			}
			else{
				$return_array['id']=0;
				$return_array['error']=1;
			}

			return $return_array;

		}
		
		// Insert Data in ElasticSearch
		public static function cron_insert_data($index,$type,$addData,$id=0){

			$elastic_host=env('ELASTIC_HOST','');
			$hosts = [
				$elastic_host
			];
			$client = ClientBuilder::create()->setHosts($hosts)->build();

			if($id!=0){
				$params_insert = [
					'index' => $index,
					'type' => $type,
					'id' => $id,
					'body' => $addData,
					'client' => [ 'ignore' => [400, 404, 409] ]
				];
			}
			else{
				$params_insert = [
					'index' => $index,
					'type' => $type,
					'body' => $addData,
					'client' => [ 'ignore' => [400, 404, 409] ]
				];
			}
			$response_insert = $client->index($params_insert);

			$return_array=array();

			if(isset($response_insert['_shards']['successful'])){
				if($response_insert['_shards']['successful']==1){
					$return_array['id']=$response_insert['_id'];
					$return_array['error']=0;
				}
				else{
					if($response_insert['result']=='noop'){
						$return_array['id']=$response_insert['_id'];
						$return_array['error']=0;
					}
					else{
						$return_array['id']=0;
						$return_array['error']=1;
					}
				}
			}
			else{
				$return_array['id']=0;
				$return_array['error']=1;
			}

			return $return_array;

		}
		
		// Delete Data in ElasticSearch
		public static function cron_delete_data($index,$type,$id){

			$elastic_host=env('ELASTIC_HOST','');
			$hosts = [
				$elastic_host
			];
			$client = ClientBuilder::create()->setHosts($hosts)->build();

			$params_delete = [
				'index' => $index,
				'type' => $type,
				'id' => $id
			];
			$response_delete = $client->delete($params_delete);

			$return_array=array();

			if(isset($response_delete['_shards']['successful'])){
				if($response_delete['_shards']['successful']==1){
					$return_array['id']=$response_delete['_id'];
					$return_array['error']=0;
				}
				else{
					$return_array['id']=0;
					$return_array['error']=1;
				}
			}
			else{
				$return_array['id']=0;
				$return_array['error']=1;
			}

			return $return_array;

		}
		
		//Update sendout as per JobID status
		public static function job_status_update($s_id){

			$row_flag = 0;
			$db_name=env('DB_NAME','');
			$index_name=$db_name.'_send_out';
			$index_name_job=$db_name.'_job';

			$search_data_job='{
				"_source": [ "hostname", "created" ],
				"size":"1",
				"query":{
					"bool":{
					  "must":[
						{"match":{"sendout_id":"'.$s_id.'"}},
						{"match":{"status":"finish"}}
						]
					}
				}
			}';
			$response_search_job=es::search_es($index_name_job,$index_name_job,$search_data_job);

			$count_job=$response_search_job['total'];

			if($count_job==0){
				$search_data_job='{
					"_source": [ "hostname", "created" ],
					"size":"1",
					"query":{
						"bool":{
						  "must":[
							{"match":{"sendout_id":"'.$s_id.'"}}
							]
						}
					}
				}';
				$response_search_job=es::search_es($index_name_job,$index_name_job,$search_data_job);

				$count_job1=$response_search_job['total'];
				if($count_job1==0){
					$count_job=1;
				}
			}
			if($count_job!=0){
				$arrUpdateData = [
				  'status_stat' => 'send'
				];

				$response_update=es::update_data($index_name,$index_name,$s_id,$arrUpdateData);
				$row_flag=1;
			}

			return $row_flag;

		}
		
		// Add Cron file while add cron run
		public static function run_cron_file($index_type_cron){

			$db_name=env('DB_NAME','');
			$index_name_cron=$db_name.'_cron';
			$index_type_cron=$index_type_cron;
			$cron_id=md5($index_type_cron);

			$cron_responce=es::search_by_id($index_name_cron,$index_type_cron,$cron_id);

			$run_time=date("Y-m-d H:i:s");

			if($cron_responce['total']==0){
				$single_document_cron = [
				  'cron_id' => $cron_id,
				  'cron_name' => $index_type_cron,
				  'last_run' => $run_time,
				  'cron_status' => 'success',
				  'status' => 'active'
				];
				$response_data_cron=es::cron_insert_data_id($index_name_cron,$index_type_cron,$single_document_cron,$cron_id);
			}
			else{
				$single_document_cron = [
				  'last_run' => $run_time
				];
				$response_data_cron=es::cron_update_data($index_name_cron,$index_type_cron,$cron_id,$single_document_cron);
			}
			if($response_data_cron['error']==0){
				return 1;
			}
			else{
				return 0;
			}
			
		}

	}

?>