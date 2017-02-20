<?php
require_once('../../../private/initialize.php');

$errors = array();
$state = array(
  'name' => '',
  'code' => '',
  'country_id' => ''
);

if(is_post_request()) {

  // Confirm that values are present before accessing them.
  if(isset($_POST['name'])) { $state['name'] = $_POST['name']; }
  if(isset($_POST['code'])) { $state['code'] = $_POST['code']; }
  if(isset($_POST['country_id'])) { $state['country_id'] = $_POST['country_id']; }

  $result = insert_state($state);
  if($result === true) {
    $new_id = db_insert_id($db);
    redirect_to('show.php?id=' . u($new_id));
  } else {
    $errors = $result;
  }
}
?>
<?php $page_title = 'Staff: New State'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="./index.php" class="btn btn-primary">Back to States List</a><br />

  <h1>New State</h1>

  <!-- TODO add form -->
  <?php echo display_errors($errors); ?>

  <form action="#" method="post">
    <div class="form-group">
      <label>Name:</label>
      <input type="text" name="name" value="<?php echo h($state['name']); ?>" class="form-control" />
    </div>
    <div class="form-group">
      <label>Code:</label>
      <input type="text" name="code" value="<?php echo h($state['code']); ?>" class="form-control" />
    </div>
    <div class="form-group">
      <label>Country ID:</label>
      <input type="text" name="country_id" value="<?php echo h($state['country_id']); ?>" class="form-control" />
    </div>
    <input type="submit" name="submit" value="Create" class="btn btn-success" />
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
