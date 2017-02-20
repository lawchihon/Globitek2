<?php
require_once('../../../private/initialize.php');

if(!isset($_GET['id'])) {
  redirect_to('index.php');
}
$salespeople_result = find_salesperson_by_id($_GET['id']);
// No loop, only one result
$salesperson = db_fetch_assoc($salespeople_result);

// Set default values for all variables the page needs.
$errors = array();

if(is_post_request()) {
  if ($_POST['submit'] == "Cancel") {
    redirect_to('show.php?id=' . u($salesperson['id']));
  }
  
  // Confirm that values are present before accessing them.
  if(isset($_POST['first_name'])) { $salesperson['first_name'] = $_POST['first_name']; }
  if(isset($_POST['last_name'])) { $salesperson['last_name'] = $_POST['last_name']; }
  if(isset($_POST['phone'])) { $salesperson['phone'] = $_POST['phone']; }
  if(isset($_POST['email'])) { $salesperson['email'] = $_POST['email']; }


  $result = update_salesperson($salesperson);
  if($result === true) {
    redirect_to('show.php?id=' . u($salesperson['id']));
  } else {
    $errors = $result;
  }
}
?>
<?php $page_title = 'Staff: Edit Salesperson ' . $salesperson['first_name'] . " " . $salesperson['last_name']; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="./index.php" class="btn btn-primary">Back to Salespeople List</a><br />

  <h1><small>Edit Salesperson:</small> <?php echo h($salesperson['first_name']) . " " . h($salesperson['last_name']); ?></h1>

  <!-- TODO add form -->
  <?php echo display_errors($errors); ?>

  <form action="#" method="post">
    <div class="form-group">
      <label>First name:</label>
      <input type="text" name="first_name" value="<?php echo h($salesperson['first_name']); ?>" class="form-control" />
    </div>
    <div class="form-group">
      <label>Last name:</label>
      <input type="text" name="last_name" value="<?php echo h($salesperson['last_name']); ?>" class="form-control" />
    </div>
    <div class="form-group">
      <label>Phone:</label>
      <input type="text" name="phone" value="<?php echo h($salesperson['phone']); ?>" class="form-control" />
    </div>
    <div class="form-group">
      <label>Email:</label>
      <input type="text" name="email" value="<?php echo h($salesperson['email']); ?>" class="form-control" />
    </div>
    <input type="submit" name="submit" value="Update" class="btn btn-success" />
    <input type="submit" name="submit" value="Cancel" class="btn btn-danger" />
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
