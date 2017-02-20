<?php
require_once('../../../private/initialize.php');

if(!isset($_GET['id'])) {
  redirect_to('index.php');
}
$id = h($_GET['id']);
$users_result = find_user_by_id($id);
// No loop, only one result
$user = db_fetch_assoc($users_result);

if(is_post_request()) {
  if ($_POST['submit'] == "Edit") {
    redirect_to('edit.php?id=' . u($user['id']));
  } elseif ($_POST['submit'] == "Delete") {
    redirect_to('delete.php?id=' . u($user['id']));
  }
}
?>

<?php $page_title = 'Staff: User ' . h($user['first_name']) . " " . h($user['last_name']); ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="index.php" class="btn btn-primary">Back to Users List</a><br />

  <h1><small>User:</small> <?php echo h($user['first_name']) . " " . h($user['last_name']); ?></h1>
  <table class="table">
    <tr>
      <td>Name: </td>
      <td><?php echo h($user['first_name']) . " " . h($user['last_name']); ?></td>
    </tr>
    <tr>
      <td>Username: </td>
      <td><?php echo h($user['username']); ?></td>
    </tr>
    <tr>
      <td>Email: </td>
      <td><?php echo h($user['email']); ?></td>
    </tr>
  </table>

  <?php db_free_result($users_result); ?>

  <form action="#" method="post">
    <input type="submit" name="submit" value="Edit" class="btn btn-success">
    <input type="submit" name="submit" value="Delete" class="btn btn-danger">
  </form>
</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
