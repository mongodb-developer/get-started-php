<?php

require __DIR__.'/../vendor/autoload.php';

echo "Connecting to MongoDB\n";
$client = new MongoDB\Client($_ENV["MONGODB_URI"]);
$collection = $client->selectCollection("getstarted", "php");

echo "Dropping collection 'getstarted.php' (command)\n";
$collection->drop(); 

echo "Inserting a single document\n";
$result = $collection->insertOne( [ 'name' => 'MongoDB', 'type' => 'database', 'count'=>1, 'info'=>['x'=>203] ] );
printf("Inserted with ObjectID: %s\n", $result->getInsertedId() );

$insertManyResult = $collection->insertMany([
  [
    'name' => 'MongoDB',
    'type' => 'database',
    'count' => '1',
    'info'=>['x'=>201] 
  ],
  [
    'name' => 'MongoDB',
    'type' => 'database',
    'count' => '1',
    'info'=>['x'=>20] 
  ],
]);
printf("Inserted %d document(s)\n", $insertManyResult->getInsertedCount());

echo "Querying using find()\n";
$result = $collection->find( [ 'type' => 'database'] );
foreach ($result as $doc) {
  printf("ID: %s, Name: %s\n", $doc['_id'], $doc['name']);
}

/* Aggregation */
printf("Aggregation result: \n");
$result = $collection->aggregate([
  [ '$group' => ['_id' => 'null', 'total' => ['$sum' => '$info.x'] ] ],
]);
foreach ($result as $doc) {
    var_dump($doc);
}
printf("Finished.")
?>
