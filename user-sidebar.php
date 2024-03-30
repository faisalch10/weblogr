<?php $page = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1); ?>


<div class="col-lg-3">
  <ul class="list-group">
    <a href="profile.php"
      class="list-group-item list-group-item-action <?= $page === 'profile.php' ? 'bg-dark text-white' : '' ?>">
      <i class="bi bi-person-circle me-2"></i>
      Basic Profile Info</a>
    <a href="my-posts.php"
      class="list-group-item list-group-item-action <?= $page === 'my-posts.php' ? 'bg-dark text-white' : '' ?>">
      <i class="bi bi-card-list me-2"></i> Your Posts
    </a>

  </ul>
</div>