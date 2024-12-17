<?php
require 'vendor/autoload.php';


$mongoHost = 'mongodb://root:example@mongodb:27017';
$databaseName = 'watchdb';
$collectionName = 'watches';

try {
    $client = new MongoDB\Client($mongoHost);
    $collection = $client->$databaseName->$collectionName;

    echo "<p style='color: green;'>Connected to MongoDB container successfully!</p>";

    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    echo "<form method='GET'>
            <input type='text' name='search' placeholder='Search watches by brand or model' value='$search'>
            <button type='submit'>Search</button>
          </form>";

    if (!empty($search)) {
        $filter = [
            '$or' => [
                ['brand' => new MongoDB\BSON\Regex($search, 'i')],
                ['model' => new MongoDB\BSON\Regex($search, 'i')]
            ]
        ];

      
        $watches = $collection->find($filter);
        $hasResults = false;

        foreach ($watches as $watch) {
            if (!$hasResults) {
                echo "<h3>Search Results:</h3><ul>";
                $hasResults = true;
            }
            echo "<li>Brand: {$watch['brand']}, Model: {$watch['model']}, Price: \${$watch['price']}</li>";
        }

        if (!$hasResults) {
            echo "<p>No results found for '<strong>$search</strong>'.</p>";
        } else {
            echo "</ul>";
        }
    }

} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>
