<?php $page = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1); ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Weblogr | A dream website for every blogger</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;800&display=swap" rel="stylesheet" />
  <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
  <link rel="stylesheet" href="assets/css/style.css" />
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="index.php">
        <i class="bi bi-pen me-2"></i>BlogVista</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02"
        aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <?php
        if (isset($_SESSION["user_type"])) {
          ?>
          <form class="d-flex mt-3 mt-md-0">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
            <button class="btn btn-outline-light" type="submit">Search</button>
          </form>
          <?php
        }

        ?>
        <?php
        if (isset($_SESSION["user_type"])) {
          ?>
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link <?= $page === 'create-post.php' ? 'active' : '' ?>" aria-current="page"
                href="create-post.php">Create Post</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?= $page === 'profile.php' ? 'active' : '' ?>" href="profile.php">Profile</a>
            </li>
            <li class="nav-item">
              <a class="btn btn-outline-light" href="logout.php" tabindex="-1" aria-disabled="true"> <i
                  class="bi bi-box-arrow-in-right me-2"></i>Logout</a>
            </li>
          </ul>
          <?php

        } else {
          ?>
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a href='login.php <?= $page === 'login.php' ? 'active' : '' ?>' class="nav-link active" aria-current="page"
                href="#">Login</a>
            </li>
            <li class="nav-item">
              <a href='register.php <?= $page === 'register.php' ? 'active' : '' ?>' class="nav-link" href="#"> Register
              </a>
            </li>
          </ul>
          <?php
        }

        ?>





      </div>
    </div>
  </nav>