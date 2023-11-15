<?php include_once("./includes/connection.php") ?>
<?php include_once("./includes/session.php"); ?>
<?php include_once("./includes/helpers.php"); ?>
<?php include_once("./includes/header.php"); ?>

<div class="container">
  <div class="row mt-5">
    <div class="col-lg-3">
      <ul class="list-group">
        <a href="profile.php" class="list-group-item list-group-item-action bg-dark text-white">
          <i class="bi bi-person-circle me-2"></i>
          Basic Profile Info</a>
        <a href="my-posts.php" class="list-group-item list-group-item-action">
          <i class="bi bi-card-list me-2"></i> Your Posts
        </a>

      </ul>
    </div>
  </div>
</div>

<?php include_once("./includes/footer.php"); ?>