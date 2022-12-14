<?php
  session_start();
  require('db.php');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Previous Orders | BookTicket</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" type="image/png" href="img/logo.png">
  </head>
  <body>

    <?php
      if (isset($_SESSION['username'])) {
    ?>
    <nav>
      <div class="logo">
        <img src="img/logo.png"> <h1> BookTicket</h1><span><i>Cheap, Reliable, Instant</i></span>
      </div>
      <ul>
        <li class="special"><a href="buywelcome.php">Buy a Ticket</a></li>
        <li><a href="comment.php">Movie Review</a></li>
        <li><a href="history.php">Purchase History</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>

    <main>
      <div class="bar">
        <h2>Previous Orders</h2>
        <span class="aside"><i>Your Username - <?php print $_SESSION['username'] ?></i></span>
      </div>
      <?php

        $query = "SELECT * FROM ticket WHERE UserId = '" . $_SESSION['username'] ."'";
        echo $query;
        $record = mysqli_query($db_conn, $query) or die("Query Error!".mysqli_error($db_conn));
        while ($row = mysqli_fetch_array($record)) {
          $query2 = "SELECT * FROM broadcast WHERE BroadCastId = " . $row['BroadCastId'];
          $record2 = mysqli_query($db_conn, $query2) or die("Query Error!".mysqli_error($db_conn));
          $broadcastRow = mysqli_fetch_array($record2);
          mysqli_free_result($record2);
          $query2 = "SELECT * FROM film WHERE FilmId = " . $broadcastRow['FilmId'];
          $record2 = mysqli_query($db_conn, $query2) or die("Query Error!".mysqli_error($db_conn));
          $filmRow = mysqli_fetch_array($record2);
          mysqli_free_result($record2);
          $rowName = chr(64 + $row['SeatRow']);
      ?>
      <section>
        <p><b>Cinema</b>: Broadway</p>
        <p><b>House</b>: House <?php print chr(65 + $broadcastRow['HouseId'] - 1) ?></p>
        <p><b>SeatNo</b>: <?php print $rowName . $row['SeatCol'] ?></p>
        <p><b>Film</b>: <?php print $filmRow['FilmName'] ?></p>
        <p><b>Category</b>: <?php print $filmRow['Category'] ?></p>
        <p><b>Show Time</b>: <?php print $broadcastRow['Dates'] . " " . $broadcastRow['Time'] . " (" . $broadcastRow['day'] . ")" ?></p>
        <p><b>Ticket Fee</b>: <?php
          if ($row['TicketFee'] == 50)
            print "$50(Student/Senior)";
          else
            print "$75(Adult)";

        ?></p>
      </section>
      <?php
        }
        mysqli_free_result($record);
      ?>
    </main>

    <?php
      }
      else {
    ?>
    <nav>
      <div class="logo">
        <img src="img/logo.png"> <h1> BookTicket</h1><span><i>Cheap, Reliable, Instant</i></span>
      </div>
    </nav>
    <main>
      <div class="bar">
        <h2>Oops...</h2>
        <span class="aside"><i>you don't seem to be logged in, redirecting you to login page.</i></span>
      </div>
      <i class="fas fa-exclamation-triangle full-icon"></i>
    </main>
    <?php
        header( "refresh:3;url=index.html" );
      }
      mysqli_close($db_conn);
    ?>
  </body>
</html>
