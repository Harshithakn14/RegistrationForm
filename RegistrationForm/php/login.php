<?php

// Connect to MySQL database
$db = mysqli_connect('localhost', 'root', '', 'form');

// Prepare login query
$stmt = $db->prepare("SELECT * FROM users WHERE email = ? AND password = ?");

// Bind parameters
$stmt->bind_param('ss', $email, $password);

// Extract form data
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);


// Execute the query
$stmt->execute();

// Check login credentials
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Generate session ID
    $session_id = sha1(uniqid());

    // Store session information in Redis
    $redis = new Redis();
    $redis->connect('localhost');
    $redis->set($session_id, json_encode($user));
    $redis->expire($session_id, 3600); // Set session timeout to 1 hour

    // Set session ID in local storage
    $_SESSION['session_id'] = $session_id;

    echo json_encode([
        'success' => true,
        'message' => "Login successful.",
        'redirect' => 'profile.html'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => "Invalid login credentials."
    ]);
}

// Close database connection
$db->close();
?>