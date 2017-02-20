<?php
require_once('../../../private/initialize.php');

if(!isset($_GET['id'])) {
  redirect_to('index.php');
}
$users_result = find_user_by_id($_GET['id']);
// No loop, only one result
$user = db_fetch_assoc($users_result);

// Set default values for all variables the page needs.
$errors = array();

if(is_post_request()) {
  if ($_POST['submit'] == "Cancel") {
    redirect_to('show.php?id=' . u($user['id']));
  }

  // Confirm that values are present before accessing them.
  if(isset($_POST['first_name'])) { $user['first_name'] = $_POST['first_name']; }
  if(isset($_POST['last_name'])) { $user['last_name'] = $_POST['last_name']; }
  if(isset($_POST['username'])) { $user['username'] = $_POST['username']; }
  if(isset($_POST['email'])) { $user['email'] = $_POST['email']; }


  $result = update_user($user);
  if($result === true) {
    redirect_to('show.php?id=' . u($user['id']));
  } else {
    $errors = $result;
  }
}
?>
<?php $page_title = 'Staff: Edit User ' . h($user['first_name']) . " " . h($user['last_name']); ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="index.php" class="btn btn-primary">Back to Users List</a><br />

  <h1><small>Edit User:</small> <?php echo h($user['first_name']) . " " . h($user['last_name']); ?></h1>

  <?php echo display_errors($errors); ?>

  <form action="#" method="post" style="">
    <div class="form-group">
      <label>First name:</label>
      <input type="text" name="first_name" value="<?php echo h($user['first_name']); ?>" class="form-control" />
    </div>
    <div class="form-group">
      <label>Last name:</label>
      <input type="text" name="last_name" value="<?php echo h($user['last_name']); ?>" class="form-control" />
    </div>
    <div class="form-group">
      <label>Username:</label>
      <input type="text" name="username" value="<?php echo h($user['username']); ?>" class="form-control" />
    </div>
    <div class="form-group">
      <label>Email:</label>
      <input type="text" name="email" value="<?php echo h($user['email']); ?>" class="form-control" />
    </div>
    <br />
    <input type="submit" name="submit" value="Update" class="btn btn-success" />
    <input type="submit" name="submit" value="Cancel" class="btn btn-danger" />
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
