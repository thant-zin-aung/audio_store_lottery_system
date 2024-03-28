<?php
    include('connect.php');
    // check if the admin was logged in...
    session_start();
    if ( !isset($_SESSION['is-admin-logged-in'])) {
      echo "<script>window.location='login.php'</script>";
    }
    // check if the admin was logged in...
    if ( isset($_POST['add-item-button']) ) {
      $itemName = $_POST['item-name'];
      $itemImage = $_FILES['item-image'];

      $file_name = $_FILES['item-image']['name'];
      $file_tmp = $_FILES['item-image']['tmp_name'];
      $file_ext = substr(strrchr($file_name, '.'), 1);
      $final_image_path = "images/".$itemName.".".$file_ext;
      $uploadFile = move_uploaded_file($file_tmp , $final_image_path);

      if ( $uploadFile ) {
          $insertLotteryItemQuery = "INSERT INTO lottery_items(item_name,item_image) VALUES('$itemName','$final_image_path');";
          $insertLotteryItemQueryResult = mysqli_query($connect,$insertLotteryItemQuery);
          if ( $insertLotteryItemQueryResult ) {
            echo "<script>window.alert('Item added successfully...');</script>";
          } else {
            echo "<script>window.alert('Failed to add new lottery item...');</script>";
          }
          echo "<script>window.location.href='lottery-item.php'</script>";
  
      }
    } else if ( isset($_POST['delete-item-button']) ) {
        $itemId = $_POST['item-id'];
        $deleteItemQuery = "DELETE FROM lottery_items WHERE id=$itemId";
        $deleteItemQueryResult = mysqli_query($connect,$deleteItemQuery);
        if ( $deleteItemQueryResult ) {
          echo "<script>window.alert('Item deleted successfully...');</script>";
          echo "<script>window.location.href='lottery-item.php'</script>";
        }
    }

    $lotteryItemQuery = "SELECT * FROM lottery_items ORDER BY id DESC";
    $lotteryItemQueryResult = mysqli_query($connect,$lotteryItemQuery);
    $totalLotteryItem = mysqli_num_rows($lotteryItemQueryResult);
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
    <link rel="stylesheet" href="lottery-item-style.css">
</head>
<body>
    <nav class="nav-bar">
        <div class="title">T & T Audio Store - Myanmar ( Lottery Item )</div>
        <div class="route-wrapper">
            <div class="home route">Back To Home</div>
        </div>
    </nav>

    <div class="lottery-item-wrapper container">
        <div class="title-wrapper">
            <div class="title">Lottery Items</div>
            <form action="lottery-item.php" method="POST" class="right-wrapper" enctype="multipart/form-data">
                <input type="text" name="item-name" placeholder="Enter product name" class="new-product-name-box" required>
                <input type="file" name="item-image" placeholder="Select product image" class="new-product-image-box" required>
                <button class="add-item-button" name="add-item-button"><i class="fa-solid fa-plus"></i> Add Item</button>
            </form>
        </div>
        

        <table class="lottery-item-table table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Product Name</th>
                <th scope="col">Product Image</th>
                <th scope="col">Option</th>
              </tr>
            </thead>
            <tbody>
              <?php
                for ( $count = 0 ; $count < $totalLotteryItem ; $count++ ) {
                    $lotteryItemData = mysqli_fetch_array($lotteryItemQueryResult);
                    $id = $lotteryItemData['id'];
                    $itemName = $lotteryItemData['item_name'];
                    $itemImagePath = $lotteryItemData['item_image'];
                    ?>
                      <tr>
                        <th scope="row"><?php echo $count+1?></th>
                        <td><?php echo $itemName?></td>
                        <td><img src="<?php echo $itemImagePath?>"></td>
                        <td>
                          <form action="lottery-item.php" method="POST">
                            <input type="hidden" name="item-id" value="<?php echo $id;?>">
                            <button class="btn btn-outline-danger" name="delete-item-button">Delete</button>
                          </form>
                      </td>
                      </tr>

                    <?php
                }
              ?>

            </tbody>
        </table>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="lottery-item-script.js"></script>
</body>
</html>