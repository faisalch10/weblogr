<?php include_once ("./includes/connection.php") ?>
<?php include_once ("./includes/session.php"); ?>
<?php include_once ("./includes/helpers.php"); ?>
<?php include_once ("./includes/header.php"); ?>

<?php

require 'vendor/autoload.php';

use Dotenv\Dotenv as Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
$siteKey = $_ENV['RECAPTHA_SITE_KEY'];
$secret = $_ENV['RECAPTHA_SECRET_KEY'];
$lang = $_ENV['RECAPTHA_WIDGET_LANGUAGE'];


if (isset($_POST["submit"])) {

  $name = $_POST["name"];
  $username = $_POST["username"];
  $email = $_POST["email"];
  $password = $_POST["password"];


  if (isset($_POST['g-recaptcha-response'])) {
    $recaptcha = new \ReCaptcha\ReCaptcha($secret);
    $resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
    if (!$resp->isSuccess()) {
      echo '<script type="text/javascript">toastr.error("Please complete the reCAPTCHA to proceed and verify you\'re human.")</script>';
    } else {

      if (empty($name) || empty($username) || empty($email) || empty($password)) {
        echo '<script type="text/javascript">toastr.error("Please fill all the fields. All fields are mandatory")</script>';
      } else {

        // CHECKING IF USER ALREADY EXIST WITH EMAIL OR NOT
        $is_user_exists_query = "SELECT * FROM users WHERE email='$email'";
        $execute_is_user_exists_query = mysqli_query($conn, $is_user_exists_query);

        // if below function mysqli_num_rows returns 1 means user already exist with same email
        // mysqli_num_rows($execute_is_user_exists_query);

        if (mysqli_num_rows($execute_is_user_exists_query) > 0) {
          $row = mysqli_fetch_assoc($execute_is_user_exists_query);
          if (ctype_lower($email) === ctype_lower($row['email'])) {
            echo '<script type="text/javascript">toastr.error("User already exists with same email")</script>';
          }
        } else {

          // Hashing password
          $hashed_password = password_hash($password, PASSWORD_DEFAULT);

          $query = "INSERT INTO users(name, username, email, password, user_type, profile_image) VALUES('$name', '$username', '$email', '$hashed_password', 'user', 'default.png')";
          $result = mysqli_query($conn, $query);

          // $result -> return 1 if everything went ok otherwise 0
          if ($result) {
            echo '<script type="text/javascript">toastr.success("User registered successfully!")</script>';
            redirect_to(2, 'login.php');
          } else {
            echo '<script type="text/javascript">toastr.error("Something went wrong!")</script>';
          }
        }
      }

    }
  }

}

?>

<div class="container">
  <div class="row justify-content-center pt-5">
    <div class="col-lg-5 col-12 mt-5">
      <h1 class="text-center">
        <i class="bi bi-person-add me-3"></i>Register
      </h1>
      <form action="register.php" method="POST" class="mt-5">
        <div class="input-group mb-3">
          <input name="name" type="text" class="form-control" placeholder="Enter your name" />
        </div>
        <div class="input-group mb-3">
          <input name="username" type="text" class="form-control" placeholder="Enter your username" />
        </div>
        <div class="input-group mb-3">
          <input name="email" type="text" class="form-control" placeholder="Enter your email" />
        </div>
        <div class="input-group mb-3">
          <input name="password" type="password" class="form-control" placeholder="Enter your password" />
        </div>

        <div class="g-recaptcha" data-sitekey="<?php echo $siteKey; ?>"></div>
        <script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl=<?php echo $lang; ?>">
        </script>

        <input name="submit" type="submit" value="Register" class="btn btn-dark btn-block w-100 mt-3 mb-3" />


      </form>

      <div class="d-flex justify-content-end">
        Already have an account? <a href="#">&nbsp;Login</a>
      </div>
    </div>
  </div>
</div>

<?php include_once ("./includes/footer.php") ?>