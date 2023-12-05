<?php

// Connect to MongoDB database

require 'vendor/autoload.php';

use MongoDB\Client;

$mongoClient = new Client('mongodb://localhost:27017');

$db = $mongoClient->selectDatabase('guvi');

$collection = $db->selectCollection('project');


// Retrieve session ID from local storage
$session_id = $_SESSION['session_id'];

// Retrieve user information from Redis
$redis = new Redis();
$redis->connect('localhost');
$user_data = $redis->get($session_id);

if ($user_data) {
    // Decode user data
    $user = json_decode($user_data, true);

    // Retrieve user profile details from MongoDB
    $profile = $collection->findOne(['user_id' => $user['_id']]);

    // Update profile if necessary
    if (isset($_POST['update'])) {
        $age = $_POST['age'];
        $dob = $_POST['dob'];
        $contact = $_POST['contact'];

        $update = ['$set' => [
            'age' => $age,
            'dob' => $dob,
            'contact' => $contact
        ]];

        $collection->updateOne(['user_id' => $user['_id']], $update);

        $profile = $collection->findOne(['user_id' => $user['_id']]);
    }

    // Prepare profile data for display
    $profile_data = [
        'name' => $user['username'],
        'email' => $user['email'],
        'age' => $profile['age'],
        'dob' => $profile['dob'],
        'contact' => $profile['contact']
    ];

    echo json_encode([
        'success' => true,
        'profile' => $profile_data
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid session.'
    ]);
}
?>