<div class="col-lg-3">
  <h2 class="ms-3">Other Posts</h2>
  <div class="row">
    <div class="col-lg-12">
      <?php
      $get_id_from_url = $_GET['id'];
      $get_four_random_posts_query = "SELECT posts.*, categories.name AS category_name
                                      FROM posts
                                      LEFT JOIN categories ON posts.category_id = categories.id
                                      WHERE posts.id != $get_id_from_url
                                      ORDER BY RAND()
                                      LIMIT 4";
      $execute_get_four_random_posts_query = mysqli_query($conn, $get_four_random_posts_query);
      while ($row = mysqli_fetch_assoc($execute_get_four_random_posts_query)) {
        ?>
        <div class="card-body">
          <h6 class="card-title mb-2">
            <?= substr($row['title'], 0, 58) . '...'; ?>
          </h6>

          <div class="d-flex justify-content-between align-items-center">
            <div>
              <a href="single-post.php?id=<?= $row['id']; ?>" class="btn btn-dark btn-sm">
                Read more
              </a>
            </div>
            <div class="bg-light p-1 rounded border">
              Category:
              <?= $row['category_name']; ?>
            </div>
          </div>
        </div>
        <?php
      }

      ?>
    </div>
  </div>
</div>