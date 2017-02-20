<?php require_once('../../../private/initialize.php'); ?>

<?php
if(!isset($_GET['id'])) {
  redirect_to('index.php');
}
$countries_result = find_country_by_id($_GET['id']);
// No loop, only one result
$country = db_fetch_assoc($countries_result);
?>

<?php $page_title = 'Staff: Country of ' . $country['name']; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="./index.php" class="btn btn-primary">Back to Countries List</a><br />

  <h1><small>Country:</small> <?php echo h($country['name']); ?></h1>

  <table id="country" class="table">
    <tr>
      <td>Name: </td>
      <td><?php echo h($country['name']); ?></td>
    </tr>
    <tr>
      <td>Code: </td>
      <td><?php echo h($country['code']); ?></td>
    </tr>
  </table>

  <a href="edit.php?id=<?php echo u($country['id']); ?>" class="btn btn-success">Edit</a><br />
  <hr />   

  <h2>States</h2>
  <br />
  <a href="../states/new.php?country_id=<?php echo u($country['id']); ?>" class="btn btn-success">Add a State</a><br />
  <br />

<?php
    $state_result = find_states_for_country_id($country['id']);

    echo "<ul id=\"states\" class=\"list-group\">";
    while($state = db_fetch_assoc($state_result)) {
      echo "<li class=\"list-group-item\">";
      echo "<a href=\"../states/show.php?id=", u($state['id']), "\">";
      echo h($state['name']);
      echo "</a>";
      echo "</li>";
    } // end while $territory
    db_free_result($state_result);
    echo "</ul>"; // #territories

    db_free_result($countries_result);
  ?>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
