<?php 
session_start();
include("connection.php");
include("functions.php");
$errorMessage = "";
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // something was posted
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
    if(!empty($user_name) && !empty($password) && !is_numeric($user_name)) {
        // read from the database
        $query = "select * from users where user_name = '$user_name' limit 1";
        $result = mysqli_query($con, $query);
        if($result) {
            if($result && mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);
                if($user_data['password'] === $password) {
                    $_SESSION['user_id'] = $user_data['user_id'];   
                    header("location: index.php");
                    die;
                }
            }
        }
        $errorMessage = "Please enter valid information.";

    } else {
        $errorMessage = "Please enter valid information.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <style>
        #box {
            margin-top: 100px;
            border: 1px solid black;
            padding: 15px;
            background-color: wheat;
            display: flex;
            flex-direction: column;
            width: 400px;
            margin-left: 200px;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
            box-shadow: 1px 1px 2px black;
        }
        #head {
            font-size: 40px;
        }
        .input {
            width: 300px;
            height: 35px;
            border-radius: 10px;
            border: none;
            padding: 5px;
        }
        .btn {
            width: 150px;
            height: 35px;
            border-radius: 10px;
            border: none;
            box-shadow: 1px 1px 1px 1px grey;
            background-color: brown;
            color: white;
            cursor: pointer;
        }
        .error {
            margin-bottom: 15px;
            border-radius: 10px;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div id="box">
        <h2 id="head">Sign In</h2>
        <form method="post">
            <input placeholder="Enter your username" class="input" type="text" name="user_name"> <br><br>
            <input placeholder="Enter your password" class="input" type="password" name="password"> <br><br>
            <div class="error"><?php echo $errorMessage ?></div>
            <input class="btn" type="submit" value="Sign In"> <br><br>
            <a href="signup.php">Sign Up</a> <br><br>
        </form>
    </div>
</body>
</html>