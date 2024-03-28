<?php
    include('connect.php');
    // Important don't move this variable to any other place...
    $actualAdminPassword;
    // Important don't move this variable to any other place...
    if ( isset($_POST['login-button']) ) {
        // if admin password empty...
        if ( empty(trim($_POST['admin-password'])) ) {
            echo "<script>window.location='login.php'</script>";
        }
        $adminPassword = $_POST['admin-password'];
        $adminQuery = "SELECT * FROM admins";
        $adminQueryResult = mysqli_query($connect,$adminQuery);
        for ( $count = 0 ; $count < 1 ; $count++ ) {
            $adminData = mysqli_fetch_array($adminQueryResult);
            $actualAdminPassword = $adminData['admin_password'];
        }
        if ( $adminPassword === $actualAdminPassword ) {
            session_start();
            $_SESSION['is-admin-logged-in']="yes";
            echo "<script>window.location='index.php'</script>";
        } else {
            echo "<script>window.alert('Wrong password!!!')</script>";   
            echo "<script>window.location='login.php'</script>";
        }


    } else if ( isset($_POST['update-button'])) {
        $currentAdminPassword = $_POST['admin-current-password'];
        $newAdminPassword1 = $_POST['admin-new-password-1'];
        $newAdminPassword2 = $_POST['admin-new-password-2'];
        $adminQuery = "SELECT * FROM admins";
        $adminQueryResult = mysqli_query($connect,$adminQuery);
        for ( $count = 0 ; $count < 1 ; $count++ ) {
            $adminData = mysqli_fetch_array($adminQueryResult);
            $actualAdminPassword = $adminData['admin_password'];
            break;
        }
        if ( $currentAdminPassword == $actualAdminPassword ) {
            // All conditions are correct...
            if ( $newAdminPassword1 === $newAdminPassword2 ) {
                $updatePasswordQuery = "UPDATE admins SET admin_password='$newAdminPassword1' WHERE admin_password='$currentAdminPassword'";
                $updatePasswordQueryResult = mysqli_query($connect,$updatePasswordQuery);
                if ( $updatePasswordQueryResult ) {
                    session_start();
                    $_SESSION['is-admin-logged-in']="yes";
                    echo "<script>window.alert('Admin password was updated successfully...')</script>";
                    echo "<script>window.location='index.php'</script>";
                } else {
                    echo "<script>window.alert('Failed to update admin password. Something went wrong...')</script>";   
                    echo "<script>window.location='login.php'</script>";
                }
            } else {
                echo "<script>window.alert('New admin passwords are not match...')</script>";   
                echo "<script>window.location='login.php'</script>";
            }
        } else {
            echo "<script>window.alert('Current admin password is not correct...')</script>";   
            echo "<script>window.location='login.php'</script>";
        }
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>T & T Login</title>
    <script src="https://kit.fontawesome.com/e2c9faac31.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Courgette&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <style>
        .form-wrapper {
            width: 550px;
            height: 350px;
            background-color: white;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: black;
            padding: 0 50px;
            box-sizing: border-box;
            /* margin: 30px 0; */
        }
        .password-box {
            outline: none;
            border: none;
            border: 3px solid #CDCDCD;
            background-color: #E5E5E5;
            box-shadow: 1px 1px 16px 1px #B2B2B2;
            border-radius: 5px;
            width: 100%;
            height: 50px;
            margin: 40px 0;
            font-size: 16px;
            padding: 0 10px;
            box-sizing: border-box;
            transition: all 0.3s;
        }
        .password-box:focus {
            box-shadow: 1px 1px 16px 1px #7C7C7C;
        }
        .button-wrapper {
            width: 100%;
            height: 50px;
            display: flex;
            justify-content: space-between;
        }
        .button {
            width: 48%;
            height: 100%;
            background-color: black;
            color: white;
            border: none;
            outline: none;
            border-radius: 5px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .reset-button {
            background-color: #DE4343;
        }
        .sub-title {
            font-size: 11px;
            margin-top: 40px;
        }
        .reset-form-wrapper {
            height: 550px;
            display: none;
        }
        .reset-form-wrapper h1 {
            margin-bottom: 20px;
        }
        .reset-form-wrapper .password-box {
            margin: 20px 0;
        }
        .reset-form-wrapper .button-wrapper {
            margin-top: 20px;
        }
        .reset-form-wrapper .update-button {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <form action="login.php" method="POST" class="form-wrapper">
            <h1>T & T Audio Store Admin Login</h1>
            <input type="password" name="admin-password" class="password-box" placeholder="Enter admin password...">
            <div class="button-wrapper">
                <button type="submit" name="login-button" class="button login-button">Login</button>
                <div class="button reset-button">Reset password</div>
            </div>
            <p class="sub-title">Copyright &copy; 2023. All rights reserved by T & T Audio Store Myanmar.</p>
        </form>

        <form action="login.php" method="POST" class="form-wrapper reset-form-wrapper">
            <h1>T & T Audio Store Admin Reset</h1>
            <input type="password" name="admin-current-password" class="password-box" placeholder="Current admin password..." required>
            <input type="password" name="admin-new-password-1" class="password-box" placeholder="New admin password..." required>
            <input type="password" name="admin-new-password-2" class="password-box" placeholder="Confirm new admin password..." required>
            <div class="button-wrapper">
                <button type="submit" name="update-button" class="button update-button">Update</button>
                <!-- <button type="submit" name="reset-button" class="button reset-button">Reset password</button> -->
            </div>
            <p class="sub-title">Copyright &copy; 2023. All rights reserved by T & T Audio Store Myanmar.</p>
        </form>
    </div>

    <script src="login-script.js"></script>
</body>
</html>