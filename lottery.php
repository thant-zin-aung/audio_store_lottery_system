<?php
    session_start();
    include('admin_panel/connect.php');
    if ( !isset($_SESSION['client-ticket-no']) ) {
        echo "<script>window.alert('Ticket no. was not filled up!')</script>";
        echo "<script>window.location = 'index.php'</script>";
    }
    $ticketNo = $_SESSION['client-ticket-no'];
    $itemQuery = "SELECT * FROM lottery_items";
    $itemQueryResult = mysqli_query($connect,$itemQuery);
    $itemQueryResult1 = mysqli_query($connect,$itemQuery);
    $totalItem = mysqli_num_rows($itemQueryResult1);

    $wonProductName;
    $wonProductImage;
    $randomNumber = rand(0,$totalItem-1);
    if ( isset($_POST['submit-button']) ) {
        for ( $count = 0 ; $count < $totalItem ; $count++ ) {
            $itemData = mysqli_fetch_array($itemQueryResult1);
            if ( $count == $randomNumber ) {
                $wonProductName = $itemData['item_name'];
                $wonProductImage = $itemData['item_image'];
                break;
            }
        }
        $winnerQuery = "INSERT INTO winners(ticket_no,item_name,item_image) VALUES('$ticketNo','$wonProductName','$wonProductImage')";
        $winnerQueryResult = mysqli_query($connect,$winnerQuery);
        $ticketQuery = "UPDATE ticket SET is_claimed='yes' WHERE ticket_no='$ticketNo'";
        $ticketQueryResult = mysqli_query($connect,$ticketQuery);
        if( !$winnerQueryResult || !$ticketQueryResult ) {
            echo "<script>window.alert('Failed to save the prize to database!')</script>";   
        } else {
            unset($_SESSION['client-ticket-no']);
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
            margin-top: 0px !important;
        }
    </style>
</head>
<body>
    <div class="main-wrapper" style="display: <?php echo isset($_POST['submit-button'])?"none":"flex";?>">
        <h1 class="title">Test your luck with our <span>T & T Audio Store Myanmar</span></h1>
        <div class="lucky-box-wrapper">
            <?php
                for ( $count = 0 ; $count < $totalItem ; $count++ ) {
                    $itemData = mysqli_fetch_array($itemQueryResult);
                    $itemImage = $itemData['item_image'];
                    
                    ?>
                        <div class="lucky-box" style="background-image: url('admin_panel/<?php echo $itemImage?>');">
                            <!-- <span>T & T</span> -->
                        </div>
                    <?php
                }
            ?>
        </div>

        <div class="submit-wrapper">
            <form action="lottery.php" method="POST">
                <button class="submit-button try-your-luck-button" name="submit-button">Try your luck!</button>
            </form>
        </div>

        <p class="sub-title">All the products displayed above this text are the products which are available in the T & T Audio Store - Myanmar's lucky draw system. By clicking the "Try your luck!" button, you agree with the decision made by <u>T & T Audio Store</u> in the situation of disputation.</p>
    </div>

    <div class="second-main-wrapper" style="display: <?php echo isset($_POST['submit-button'])?"flex":"none";?>">
        <div class="congrat-wrapper">
            <div class="product-name"><?php echo $wonProductName;?></div>
            <img class="product-image" src="admin_panel/<?php echo $wonProductImage;?>">
            <div class="congrat-text">Congratulations</div>
            <div class="outro">You can contant to ask or claim the product you pocess. Send a message via messenger or directly to the phone call.</div>
            <a href="index.php"><button class="ok-button">OK</button></a>
        </div>
    </div>
    
    <script src="script.js"></script>
</body>
</html>