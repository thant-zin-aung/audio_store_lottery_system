<?php
  include('connect.php');
  // check if the admin was logged in...
  session_start();
  if ( !isset($_SESSION['is-admin-logged-in'])) {
    echo "<script>window.location='login.php'</script>";
  }
  // check if the admin was logged in...
  $winnerQuery;
  if ( isset($_POST['search-button']) ) {
      $ticketNo = trim($_POST['ticket-no']);
      $winnerQuery = "SELECT * FROM winners WHERE ticket_no='$ticketNo'";
      $winnerQueryResult = mysqli_query($connect,$winnerQuery);
      $totalResult = mysqli_num_rows($winnerQueryResult);
      if ( $totalResult == 0 ) {
        echo "<script>window.alert('Ticket no was not found in winners list...');</script>";
        echo "<script>window.location = 'index.php';</script>";
      }
      // for ( $count = 0 ; $count < $totalResult ; $count++ ) {
      //     $ticketData = mysqli_fetch_array($ticketQueryResult);
      //     $ticketId = $ticketData['ticket_id']; 
      // }
      
  } else {
      $winnerQuery = "SELECT * FROM winners ORDER BY winner_id DESC LIMIT 10";
  }
  $winnerQueryResult = mysqli_query($connect,$winnerQuery);
  $totalWinner = mysqli_num_rows($winnerQueryResult);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="nav-bar">
        <div class="title">T & T Audio Store - Myanmar</div>
        <div class="route-wrapper">
            <div class="lottery-item route">Lottery Item</div>
            <div class="ticket-generator route">Ticket Generator</div>
        </div>
    </nav>

    <div class="last-winner-wrapper container">
        <div class="title-wrapper">
            <div class="title">Last 10 Winners</div>
            <form action="index.php" method="POST" class="search-box-wrapper">
                <input type="text" name="ticket-no" class="search-box" spellcheck="false" placeholder="Enter ticket id...">
                <button type="submit" class="search-button" name="search-button">Search</button>
            </form>
        </div>

        <table class="last-winner-table table">
            <thead>
              <tr>
                <th scope="col">Winner Id</th>
                <th scope="col">Ticket No.</th>
                <th scope="col">Product Name</th>
                <th scope="col">Product Image</th>
              </tr>
            </thead>
            <tbody>
              <?php
                for ( $count = 0 ; $count < $totalWinner ; $count++ ) {
                    $winnerData = mysqli_fetch_array($winnerQueryResult);
                    $winnerId = $winnerData['winner_id'];
                    $winnerTicketNo = $winnerData['ticket_no'];
                    $winnerProductName = $winnerData['item_name'];
                    $winnerProductImagePath = $winnerData['item_image'];
                    ?>
                    <tr>
                      <th scope="row"><?php echo $winnerId?></th>
                      <td><?php echo $winnerTicketNo?></td>
                      <td><?php echo $winnerProductName?></td>
                      <td><img src="<?php echo $winnerProductImagePath?>"></td>
                    </tr>

                    <?php
                }
              ?>
            </tbody>
        </table>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>
</html>