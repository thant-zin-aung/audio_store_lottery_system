<?php
    session_start();
    include('admin_panel/connect.php');
    if (isset($_POST['submit-button'])) {
        $ticketNo = $_POST['ticket-no'];
        $ticketQuery = "SELECT * FROM ticket WHERE ticket_no='$ticketNo'";
        $ticketQueryResult = mysqli_query($connect,$ticketQuery);
        $totalTicket = mysqli_num_rows($ticketQueryResult);
        $isTicketClaimed;
        if ( $totalTicket != 0 ) {
            for ( $count = 0 ; $count < $totalTicket ; $count++ ) {
                $ticketData = mysqli_fetch_array($ticketQueryResult);
                $isTicketClaimed = $ticketData['is_claimed'];
            }
            if ( $isTicketClaimed == "yes" ) {
                echo "<script>window.alert('Your ticket no has been already claimed.')</script>";
                echo "<script>window.location = 'index.php'</script>";
            } else {
                $_SESSION['client-ticket-no'] = $ticketNo;
                echo "<script>window.location = 'lottery.php'</script>";
            }
        } else {
            echo "<script>window.alert('Invalid ticket no.')</script>";
            echo "<script>window.location = 'index.php'</script>";
        }
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>T & T Audio Store</title>
    <script src="https://kit.fontawesome.com/e2c9faac31.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Courgette&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    <style>
        .submit-wrapper form {
            display: flex;
            /* flex-direction: column; */
            justify-content: center;
            align-items: center;
            margin-top: 100px;
            width: 550px;
            height: 50px;
        }
        form input[type=text] {
            width: 70%;
            height: 100%;
            padding: 0 10px;
            font-size: 17px;
            outline: none;
            border: 1px solid white;
            box-sizing: border-box;
        }
        .submit-button {
            background-color: black;
            color: white;
            width: 30%;
            height: 100%;
            border: 1px solid white;
            /* border-width: 1px 1px 1px 1px; */
        }

    </style>
</head>
<body>
    <div class="main-wrapper" style="display: flex;">
        <h1 class="title">Test your luck with our <span>T & T Audio Store Myanmar</span></h1>

        <div class="submit-wrapper">
            <form action="index.php" method="POST">
                <input type="text" name="ticket-no" placeholder="Enter ticket no..." required>
                <button class="submit-button" name="submit-button">Submit</button>
            </form>
        </div>

        <p class="sub-title">Copyright &copy; 2023. All rights reserved by T & T Audio Store Myanmar.</p>
    </div>

    
    <!-- <script src="script.js"></script> -->
</body>
</html>