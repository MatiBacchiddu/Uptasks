<?php 

$conn = mysqli_connect(
    'localhost',
    'root',
    '',
    'uptask'
);

if($conn->connect_error) {
    echo $conn_connect_error;
}

$conn->set_charset('utf8');

// echo '<pre>';
// var_dump($conn->ping());
// echo '</pre>';

?>

