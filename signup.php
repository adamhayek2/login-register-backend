<?php
    include('connection.php');
    

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $check_username = $mysqli->prepare('select username from users where username=?');
    $check_username->bind_param('s', $username);
    $check_username->execute();
    $check_username->store_result();
    

    if ( $check_username->num_rows() == 0) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $query = $mysqli->prepare('insert into users(username, email, password) values(?, ?, ?)');
        $query->bind_param('sss', $username, $email, $hashed_password);
        $query->execute();

        $response['status'] = "success";
        $response['message'] = "another message in success";
    } else {
        $response['status'] = "failed";
        $response['message'] = "another message in fail";
    }

    // types of http request : POST,GET,PUT,DELETE 
    echo json_encode($response);
