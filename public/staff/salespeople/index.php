<?php require_once('../../../private/initialize.php'); ?>

<?php $page_title = 'Staff: Salespeople'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="../index.php" class="btn btn-primary">Back to Menu</a><br />

  <h1>Salespeople</h1>

  <a href="./new.php" class="btn btn-success">Add a Salesperson</a><br />
  <br />

  <?php
    $salespeople_result = find_all_salespeople();

    echo "<table id=\"salespeople\" class=\"table\">";
    echo "<tr class=\"active\">";
    echo "<th>First name</th>";
    echo "<th>Last name</th>";
    echo "<th></th>";
    echo "<th></th>";
    echo "<th></th>";
    echo "</tr>";
    while($salesperson = db_fetch_assoc($salespeople_result)) {
      echo "<tr>";
      echo "<td>" . h($salesperson['first_name']) . "</td>";
      echo "<td>" . h($salesperson['last_name']) . "</td>";
      echo "<td>";
      echo "<a href=\"show.php?id=" . u($salesperson['id']) . "\" class=\"btn btn-info\">Show</a>";
      echo "</td>";
      echo "<td>";
      echo "<a href=\"edit.php?id=" . u($salesperson['id']) . "\" class=\"btn btn-success\">Edit</a>";
      echo "</td>";
      echo "<td>";
      echo "<a href=\"delete.php?id=" . u($salesperson['id']) . "\" class=\"btn btn-danger\">Delete</a>";
      echo "</td>";
      echo "</tr>";
    } // end while $salesperson
    db_free_result($salespeople_result);
    echo "</table>"; // #salespeople
  ?>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
