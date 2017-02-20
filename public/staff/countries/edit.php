<?php
require_once('../../../private/initialize.php');

if(!isset($_GET['id'])) {
  redirect_to('index.php');
}
$countries_result = find_country_by_id($_GET['id']);
// No loop, only one result
$country = db_fetch_assoc($countries_result);

// Set default values for all variables the page needs.
$errors = array();

if(is_post_request()) {
  if ($_POST['submit'] == "Cancel") {
    redirect_to('show.php?id=' . u($country['id']));
  }

  // Confirm that values are present before accessing them.
  if(isset($_POST['name'])) { $country['name'] = $_POST['name']; }
  if(isset($_POST['code'])) { $country['code'] = $_POST['code']; }

  $result = update_country($country);
  if($result === true) {
    redirect_to('show.php?id=' . u($country['id']));
  } else {
    $errors = $result;
  }
}
?>
<?php $page_title = 'Staff: Edit Country ' . $country['name']; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="./index.php" class="btn btn-primary">Back to Countries List</a><br />

  <h1><small>Edit Country:</small> <?php echo h($country['name']); ?></h1>

  <!-- TODO add form -->
  <?php echo display_errors($errors); ?>

  <form action="#" method="post">
    <div class="form-group">
      <label>Name:</label>
      <input type="text" name="name" value="<?php echo h($country['name']); ?>" class="form-control" />
    </div>
    <div class="form-group">
      <label>Code:</label>
      <input type="text" name="code" value="<?php echo h($country['code']); ?>" class="form-control" />
    </div>
    <input type="submit" name="submit" value="Update" class="btn btn-success" />
    <input type="submit" name="submit" value="Cancel" class="btn btn-danger" />
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
