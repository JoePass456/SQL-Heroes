<?php
$servername = "localhost";
$username = "root";
$password = "root";
$database = "superheroes";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";

$sql = "SELECT id, name, about_me, biography FROM heroes";
$all_heroes = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $_POST['name'];
  $aboutme = $_POST['aboutme'];
  $bio = $_POST['bio'];

  $sql = "INSERT INTO heroes (name, about_me, biography)
VALUES('$name', '$aboutme', '$bio')";
  if ($conn->query($sql) === TRUE) {
    echo 'New Record created successfully';
  }
}

$state = "";;


?>

<!doctype html>
<html lang="en">
  
  <head>
  <title>Title</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
  <ul>
    <?php
    $state = $_GET["state"];
    $profile_id = $_GET["profileid"];

    if ($state == "delete") {
      $sql = "DELETE FROM heroes WHERE id=$profile_id";
      $all_heroes = $conn->query($sql);

      if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
      } else {
        echo "Error deleting record: " . $conn->error;
      }
      echo "<button><a href='index.php'>Back</a></button>";
    }

    if ($all_heroes->num_rows > 0) {
      // output data of each row
      while ($row = $all_heroes->fetch_assoc()) {
        // echo "<pre>" . print_r($row, 1) . "</pre>";
        echo "<li>
        <a href='index.php?profileid="
          . $row["id"]
          . "&state=profile'>"
          . $row["name"]
          . "</a>
          <a href='index.php?profileid="
          . $row["id"]
          . "&state=delete'>-- DELETE --</a>        
          </li>";
      }
    } else {

      echo "0 results";
    }

    if ($profile_id != 0) {
      // echo "got id";
      $sql = "SELECT id, name, about_me, biography FROM heroes WHERE id = '$profile_id'";
      $profile = $conn->query($sql);
      if ($profile->num_rows > 0) {
        // output data of each row
        while ($row = $profile->fetch_assoc()) {
          // echo "<pre>" . print_r($row, 1) . "</pre>";
          echo "<h3>" . $row["name"] . "</h3>";
          echo "<p>" . $row["about_me"] . "</p>";
          echo "<p>" . $row["biography"] . "</p>";
        }
      } else {
        echo "0 results";
      }
      $sql = "SELECT ability FROM abilities 
      INNER JOIN ability_hero WHERE id = '$profile_id'";
      $profile = $conn->query($sql);
      if ($profile->num_rows > 0) {
        // output data of each row
        while ($row = $profile->fetch_assoc()) {
          // echo "<pre>" . print_r($row, 1) . "</pre>";
          echo "<h3>Ability: " . $row["name"] . "</h3>";
          
        }
      } else {
        echo "0 results";
      }

    } else {
      //echo "no id";
    }

    ?>
  </ul>
  <div>
    <?php
    // echo $state . $profile_id;
    // $row = $result->fetch_assoc();
    // var_dump($result);

    ?>
  </div>
  <form action='<?php echo $_SERVER['PHP_SELF']; ?>' method='post'>
    <div class="form-group">
      <label for="name">New Hero Name:</label>
      <input name="name" type="text" class="form-control" id="name">
    </div>
    <div class="form-group">
      <label for="aboutme">About Me:</label>
      <input name="aboutme" type="text" class="form-control" id="aboutme">
    </div>
    <div class="form-group">
      <label for="bio">Biography:</label>
      <input name="bio" type="text" class="form-control" id="bio">
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
  </form>
  <?php


  

  $conn->close();
  ?>



  <!-- <button></button> -->
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>