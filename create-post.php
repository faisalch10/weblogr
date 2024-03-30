<?php include_once("./includes/connection.php") ?>
<?php include_once("./includes/session.php"); ?>
<?php include_once("./includes/helpers.php"); ?>
<?php include_once("./includes/header.php"); ?>

<?php

if (isset($_POST["submit"])) {
  $title = $_POST['title'];
  $description = $_POST['description'];
  $category_id = $_POST['category_id'];
  $is_draft = isset($_POST['is_draft']) && $_POST['is_draft'] ? 1 : 0;
  $is_private = isset($_POST['is_private']) && $_POST['is_private'] ? 1 : 0;

  if (empty($title) || empty($description) || empty($category_id)) {
    echo '<script type="text/javascript">toastr.error("Please fill all the fields. All fields are mandatory")</script>';
  } else {

    $user_id = $_SESSION['id'];
    $create_blog_post_query = "INSERT INTO posts(title, description, category_id, user_id, is_draft, is_private) VALUES('$title', '$description', '$category_id', '$user_id', $is_draft, $is_private)";
    $execute_create_blog_post_query = mysqli_query($conn, $create_blog_post_query);


    // $execute_create_blog_post_query); return 1 if everything went well
    if ($execute_create_blog_post_query) {
      echo '<script type="text/javascript">toastr.success("Post created successfully")</script>';
    } else {
      $error = mysqli_error($conn);
      echo "Error: $error";
      echo '<script type="text/javascript">toastr.error("Something went wrong while creating blog post")</script>';
    }

  }

}

?>

<div class="container ckeditor-container">
  <div class="row justify-content-center pt-5">
    <div class="col-lg-8 col-12 mt-5">
      <h1 class="text-center">
        <i class="bi bi-plus-circle-dotted me-3"></i>Create Post
      </h1>
      <form action="create-post.php" method="POST" class="mt-5">

        <div class="row">

          <div class="col-lg-6">
            <div class="input-group">
              <input name="title" type="text" class="form-control" placeholder="Enter blog post title" />
            </div>
          </div>

          <div class="col-lg-6">
            <div class="input-group">
              <select class="form-select" name="category_id" aria-label="Default select example">
                <option value="" selected>Select Blog Post Category</option>
                <?php
                $get_categories_query = "SELECT * FROM categories";
                $execute_get_categories_query = mysqli_query($conn, $get_categories_query);
                while ($data = mysqli_fetch_array($execute_get_categories_query)) {
                  $cat_id = $data['id'];
                  $cat_name = $data['name'];
                  ?>
                  <option value=<?= $cat_id; ?>><?= $cat_name ?></option>
                  <?php
                }
                ?>
              </select>
            </div>

          </div>

          <div class="col-lg-12 my-4">
            <div class="input-group w-100">
              <textarea rows="10" name="description" id="editor"
                placeholder="Enter your blog post description"></textarea>
            </div>

          </div>


          <div class="col-lg-6">
            <div class="input-group mb-3">
              <div class="form-check form-switch">
                <input name="is_draft" value="1" class="form-check-input" type="checkbox">
                <label class="form-check-label">
                  Save post as draft
                </label>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="input-group mb-3">
              <div class="form-check form-switch">
                <input name="is_private" value="1" class="form-check-input" type="checkbox">
                <label class="form-check-label">
                  Want to make your post private?
                </label>
              </div>
            </div>
          </div>
        </div>

        <input name="submit" type="submit" value="Create Blog Post" class="btn btn-dark btn-block w-100 mt-3 mb-3" />


      </form>
    </div>
  </div>
</div>


<?php include_once("./includes/ckeditor-scripts.php"); ?>
<?php include_once("./includes/footer.php"); ?>