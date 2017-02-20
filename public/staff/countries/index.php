<?php require_once('../../../private/initialize.php'); ?>

<?php $page_title = 'Staff: Country'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="../index.php" class="btn btn-primary">Back to Menu</a><br />

  <h1>Countries</h1>

  <a href="./new.php" class="btn btn-success">Add a Country</a><br />
  <br />

  <?php
    $country_result = find_all_countries();

    echo "<table id=\"country\" class=\"table\">";
    echo "<tr class=\"active\">";
    echo "<th>Name</th>";
    echo "<th>Code</th>";
    echo "<th></th>";
    echo "<th></th>";
    echo "</tr>";
    while($country = db_fetch_assoc($country_result)) {
      echo "<tr>";
      echo "<td>" . h($country['name']) . "</td>";
      echo "<td>" . h($country['code']) . "</td>";
      echo "<td>";
      echo "<a href=\"show.php?id=" . u($country['id']) . "\" class=\"btn btn-info\">Show</a>";
      echo "</td>";
      echo "<td>";
      echo "<a href=\"edit.php?id=" . u($country['id']) . "\" class=\"btn btn-success\">Edit</a>";
      echo "</td>";
      echo "</tr>";
    } // end while $states
    db_free_result($country_result);
    echo "</table>"; // #states
  ?>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
