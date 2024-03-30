<?php include_once("./includes/connection.php") ?>
<?php include_once("./includes/session.php"); ?>
<?php include_once("./includes/helpers.php"); ?>
<?php include_once("./includes/header.php"); ?>


<?php
if (isset($_POST['submit'])) {

  $user_id = $_SESSION['id'];
  $name = $_POST['name'];
  $bio = $_POST['bio'];


  // Only if statement only run when user picked a profile photo
  if (!empty($_FILES['profile_image']['name'])) {
    $image_one_time = microtime(); // generate random timestamp
    $profile_image = $image_one_time . $_FILES['profile_image']['name']; // generate unique name so we can save this name into our database.
    $target = './uploads/' . $image_one_time . basename($_FILES['profile_image']['name']);
    // in above line we create a path to the folder where we want to save our image
  }

  if (empty($user_id) || empty($name) || empty($bio)) {
    echo '<script type="text/javascript">toastr.error("Name and Bio are mandatory fields. Please fill these fields")</script>';
  } else {
    $update_user_query = empty($_FILES['profile_image']['name']) ?

      "UPDATE users SET name='$name', bio='$bio' WHERE 
    id='$user_id'"

      : "UPDATE users SET name='$name', bio='$bio', profile_image='$profile_image' WHERE id='$user_id'";

    $execute_update_user_query = mysqli_query($conn, $update_user_query);

    if (!empty($_FILES['profile_image']['name'])) {
      // move the image into our target folder
      move_uploaded_file($_FILES['profile_image']['tmp_name'], $target);
    }

    if ($execute_update_user_query) {
      echo '<script type="text/javascript">toastr.success("Profile updated successfully")</script>';
    } else {
      $error = mysqli_error($conn);
      echo "Error: $error";
      echo '<script type="text/javascript">toastr.error("Something went wrong while updating the profile")</script>';
    }

  }
}

?>


<?php

$user_id = $_SESSION['id'];
$get_user_query = "SELECT * FROM users WHERE id='$user_id'";
$execute_get_user_query = mysqli_query($conn, $get_user_query);
$row = mysqli_fetch_assoc($execute_get_user_query);

$row_id = $row["id"];
$row_name = $row["name"];
$row_bio = $row["bio"];
$row_profile_image = $row["profile_image"];

?>

<div class="container">
  <div class="row mt-5">
    <?php include_once("./user-sidebar.php") ?>
    <div class="col-lg-9">

      <form class="row" action="profile.php" method="POST" enctype="multipart/form-data">
        <input class="d-none" name="profile_image" type="file" class="form-control" id="inputGroupFile01">
        <div class="d-flex align-items-center flex-column input-group mb-3 mt-3 mt-lg-0">
          <img class="rounded-circle" src="./uploads/<?= $row_profile_image; ?>" alt="logo" width="150" height="150">
          <label class="input-group-text mt-2" for="inputGroupFile01">
            Upload Profile Picture
          </label>
        </div>
        <div class="mb-3 col-lg-12">
          <label class="form-label">Name</label>
          <input type="text" class="form-control" name="name" value="<?= $row_name; ?>">
        </div>
        <div class="mb-3 col-lg-12">
          <label class="form-label">Bio</label>
          <textarea rows="8" type="text" class="form-control" name="bio"><?= $row_bio; ?></textarea>
          <div class="form-text">Please write your short bio with maximum of 500 characters</div>
        </div>
        <div class="d-flex justify-content-end">
          <input type="submit" name="submit" class="btn btn-dark w-80" value="Update Profile" />
        </div>
      </form>
    </div>
  </div>
</div>

<?php include_once("./includes/footer.php"); ?>