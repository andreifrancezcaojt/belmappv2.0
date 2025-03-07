<?php
echo $_SERVER['REQUEST_URI'];
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "cap";


// $servername = "localhost";
// $username = "u607950924_basc_elibrary";
// $password = "B@scElibrary@2024!";
// $dbname = "u607950924_cap";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the function exists before declaring it
if (!function_exists('getMostActiveUser')) {
    function getMostActiveUser($conn)
    {
        $q = "SELECT a.username, COUNT(b.user_id) AS login_count
              FROM users a
              LEFT JOIN login_history b ON a.id = b.user_id
              GROUP BY a.username
              ORDER BY login_count DESC
              LIMIT 1";
        $result = mysqli_query($conn, $q);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row['username'];
        } else {
            return "No users found";
        }
    }
}

function get($sql)
{
    error_reporting(0);
    global $conn;
    $rs = mysqli_query($conn, $sql);
    $rw = mysqli_fetch_array($rs);
    return $rw[0];
}

function getbooks() {
    global $conn;
    // $b = mysqli_query($conn, 'SELECT a.id, a.pdf_id, a.rating, b.pdf_name, a.views
    //                            FROM ratings a
    //                            JOIN pdf_file b ON a.pdf_id = b.id
    //                            ORDER BY a.views DESC
    //                            LIMIT 3');
    $b = mysqli_query($conn, 'SELECT * FROM pdf_file ORDER BY views DESC LIMIT 3');
    $bks = array();
    $views = array();
    
    while($rw = mysqli_fetch_array($b)) {
        $bks[] = $rw['pdf_name'];
        $views[] = $rw['views']; // Add views to the array
    }
    
    return array('names' => $bks, 'views' => $views); // Return both names and views
}


?>