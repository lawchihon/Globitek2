<?php
require_once('../../../private/initialize.php');

// Set default values for all variables the page needs.
$errors = array();
$user = array(
  'first_name' => '',
  'last_name' => '',
  'username' => '',
  'email' => ''
);

if(is_post_request()) {

  // Confirm that values are present before accessing them.
  if(isset($_POST['first_name'])) { $user['first_name'] = $_POST['first_name']; }
  if(isset($_POST['last_name'])) { $user['last_name'] = $_POST['last_name']; }
  if(isset($_POST['username'])) { $user['username'] = $_POST['username']; }
  if(isset($_POST['email'])) { $user['email'] = $_POST['email']; }

  $result = insert_user($user);
  if($result === true) {
    $new_id = db_insert_id($db);
    redirect_to('show.php?id=' . u($new_id));
  } else {
    $errors = $result;
  }
}
?>
<?php $page_title = 'Staff: New User'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="index.php" class="btn btn-primary">Back to Users List</a><br />

  <h1>New User</h1>

  <?php echo display_errors($errors); ?>

  <form action="new.php" method="post">
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
    <input type="submit" name="submit" value="Create" class="btn btn-success" />
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
