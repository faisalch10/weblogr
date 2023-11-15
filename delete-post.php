<?php include_once("./includes/connection.php") ?>
<?php include_once("./includes/session.php"); ?>
<?php include_once("./includes/helpers.php"); ?>
<?php include_once("./includes/header.php"); ?>


<?php
$get_id_from_url = $_GET['id'];
$delete_blog_post_query = "DELETE FROM posts WHERE id='$get_id_from_url'";
$execute_delete_blog_post_query = mysqli_query($conn, $delete_blog_post_query);

if ($execute_delete_blog_post_query) {
  echo '<script type="text/javascript">toastr.success("Post deleted successfully")</script>';
  redirect_to(0.5, 'my-posts.php');
} else {
  $error = mysqli_error($conn);
  echo "Error: $error";
  echo '<script type="text/javascript">toastr.error("Something went wrong while deleting blog post")</script>';
}


?>

<?php include_once("./includes/footer.php"); ?>