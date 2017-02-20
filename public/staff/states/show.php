<?php require_once('../../../private/initialize.php'); ?>

<?php
if(!isset($_GET['id'])) {
  redirect_to('index.php');
}
$id = $_GET['id'];
$state_result = find_state_by_id($id);
// No loop, only one result
$state = db_fetch_assoc($state_result);
?>

<?php $page_title = 'Staff: State of ' . $state['name']; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="./index.php" class="btn btn-primary">Back to States List</a><br />

  <h1><small>State:</small> <?php echo h($state['name']); ?></h1>

  <table id="state" class="table">
    <tr>
      <td>Name: </td>
      <td><?php echo h($state['name']); ?></td>
    </tr>
    <tr>
      <td>Code: </td>
      <td><?php echo h($state['code']); ?></td>
    </tr>
    <tr>
      <td>Country ID: </td>
      <td><?php echo h($state['country_id']); ?></td>
    </tr>
  </table>

  <a href="edit.php?id=<?php echo u($state['id']); ?>" class="btn btn-success">Edit</a><br />
  <hr />   

  <h2>Territories</h2>
  <br />
  <a href="../territories/new.php?state_id=<?php echo u($state['id']); ?>" class="btn btn-success">Add a Territory</a><br />
  <br />

<?php
    $territory_result = find_territories_for_state_id($state['id']);

    echo "<ul id=\"territories\" class=\"list-group\">";
    while($territory = db_fetch_assoc($territory_result)) {
      echo "<li class=\"list-group-item\">";
      echo "<a href=\"../territories/show.php?id=", u($territory['id']), "\">";
      echo h($territory['name']);
      echo "</a>";
      echo "</li>";
    } // end while $territory
    db_free_result($territory_result);
    echo "</ul>"; // #territories

    db_free_result($state_result);
  ?>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
