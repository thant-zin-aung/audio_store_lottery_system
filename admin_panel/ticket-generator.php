<?php
  include('connect.php');
  // check if the admin was logged in...
  session_start();
  if ( !isset($_SESSION['is-admin-logged-in'])) {
    echo "<script>window.location='login.php'</script>";
  }
  // check if the admin was logged in...
  function ticketGenerator() {
    $date = date("d-m-Y h:i:sa");
    $tempTicket = round(strtotime($date)/rand(1,5));
    $tempTicket *= rand(1,5);
    return "TNT-".$tempTicket;
  }

  if ( isset($_POST['generate-button']) ) {
    $ticketQuantity = $_POST['ticket-quantity'];
    
    // Generate ticket...
    $ticketArray = array();
    while (sizeof($ticketArray) < $ticketQuantity ) {
        array_push($ticketArray, ticketGenerator());
        $ticketArray = array_unique($ticketArray);
    }

    for ( $count = 0 ; $count < sizeof($ticketArray) ; $count++ ) {
      $generateQuery = "INSERT INTO ticket(ticket_no,is_claimed) VALUES('$ticketArray[$count]','no')";
      $generateQueryResult = mysqli_query($connect,$generateQuery);
      if (!$generateQueryResult) {
        echo "alert('Failed to generate ticket no.')";
      }
    }
  }



  $getTicketQuery = "SELECT * FROM ticket ORDER BY ticket_id DESC";
  $getTicketQueryResult = mysqli_query($connect,$getTicketQuery);
  $totalTicket = mysqli_num_rows($getTicketQueryResult);
  $lastTicketId=0;
  if ( $totalTicket > 0 ) {
      for ( $count = 0 ; $count < 1 ; $count++ ) {
        $ticketData = mysqli_fetch_array(mysqli_query($connect,$getTicketQuery));
        $lastTicketId = $ticketData['ticket_id'];
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="ticket-generator-style.css">
</head>
<body>
    <nav class="nav-bar">
        <div class="title">T & T Audio Store - Myanmar ( Ticket Generator )</div>
        <div class="route-wrapper">
            <div class="home route">Back To Home</div>
        </div>
    </nav>

    <div class="ticket-id-wrapper container">
        <div class="title-wrapper">
            <div class="title">Ticket ID List <span><sup>( Total ticket - <?php echo $totalTicket;?> )</sup></span></div>
            <form action="ticket-generator.php" method="POST" class="right-wrapper">
                <label for="total-ticket">Number of ticket</label>
                <input type="number" name="ticket-quantity" min="1" max="20" id="total-ticket" class="total-ticket" placeholder="1 - 20">
                <button class="add-item-button" name="generate-button">Generate</button>
            </form>
        </div>
        

        <table class="ticket-no-table table">
            <thead>
              <tr>
                <th scope="col">Ticket ID</th>
                <th scope="col">Ticket No.</th>
                <th scope="col">Claimed</th>
              </tr>
            </thead>
            <tbody>
              <?php
                for ( $count = 0 ; $count < $totalTicket ; $count++ ) {
                  $ticketData = mysqli_fetch_array($getTicketQueryResult);
                  ?>
                    <tr>
                      <th scope="row"><?php echo $ticketData['ticket_id'];?></th>
                      <td><?php echo $ticketData['ticket_no'];?></td>
                      <td class="claim-status <?php echo ($ticketData['is_claimed'] == 'no' ? 'not-claimed' : 'claimed');?>"><?php echo $ticketData['is_claimed'];?></td>
                    </tr>
                  <?php
                }
              ?>
            </tbody>
        </table>
    </div>


    <script src="ticket-generator-script.js"></script>
</body>
</html>