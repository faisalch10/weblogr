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
  $email = $_POST['email'];
  $password = $_POST['password'];

  if (isset($_POST['g-recaptcha-response'])) {
    $recaptcha = new \ReCaptcha\ReCaptcha($secret);
    $resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
    if (!$resp->isSuccess()) {
      echo '<script type="text/javascript">toastr.error("Please complete the reCAPTCHA to proceed and verify you\'re human.")</script>';
    } else {

      if (empty($email) || empty($password)) {
        echo '<script type="text/javascript">toastr.error("Please provide email and password. Both fields are mandatory")</script>';
      } else {

        $query = "SELECT * FROM users WHERE email = '$email'";
        $execute = mysqli_query($conn, $query);

        // mysqli_fetch_assoc() return associative array
        if ($is_user_found = mysqli_fetch_assoc($execute)) {
          if (password_verify($password, $is_user_found['password'])) {

            $_SESSION['user_type'] = $is_user_found['user_type'];
            $_SESSION['name'] = $is_user_found['name'];
            $_SESSION['id'] = $is_user_found['id'];

            if ($is_user_found['user_type'] === 'admin') {
              // redirect_to('../admin/admin-dashboard.php');
              echo "Please show admin page";
            } else {
              echo '<script type="text/javascript">toastr.success("You logged in successfully. Please wait while we redirecting you")</script>';
              redirect_to(1.5, 'index.php');
            }
          } else {
            echo '<script type="text/javascript">toastr.error("Invalid Password")</script>';
          }
        } else {
          echo '<script type="text/javascript">toastr.error("User not exists with this email")</script>';
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
        <i class="bi bi-person me-3"></i>Login
      </h1>
      <form class="mt-5" action="login.php" method="POST">
        <div class="input-group mb-3">
          <input name="email" type="text" class="form-control" placeholder="Enter your email" />
        </div>
        <div class="input-group mb-3">
          <input name="password" type="password" class="form-control" placeholder="Enter your password" />
        </div>

        <div class="g-recaptcha" data-sitekey="<?php echo $siteKey; ?>"></div>
        <script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl=<?php echo $lang; ?>">
        </script>
        <input name="submit" type="submit" value="Login" class="btn btn-dark btn-block w-100 mt-3 mb-3" />

      </form>

      <div class="d-flex justify-content-end">
        Don't have an account? <a href="#">&nbsp;Register</a>
      </div>

    </div>
  </div>
</div>

<?php include_once ("./includes/footer.php"); ?>