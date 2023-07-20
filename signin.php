<?php
    include('connection.php');

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = $mysqli->prepare('select id,username,password
        from users 
        where username=?');
    $query->bind_param('s', $username);
    $query->execute();

    $query->store_result();
    $query->bind_result($id, $username, $hashed_password);
    $query->fetch();

    $num_rows = $query->num_rows();
    if ($num_rows == 0) {
        $response['status'] = "user not found";
    } else {
        if (password_verify($password, $hashed_password)) {
            $response['status'] = 'logged in';
            $response['user_id'] = $id;
        } else {
            $response['status'] = "wrong password";
        }
    }
echo json_encode($response);
