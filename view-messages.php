<?php
include('partials/connect.php');
include('partials/header.php');
?>

<h2 class="dashboard-title mt-2">Customer Messages</h2><br>

<a href="admin-dashboard.php" class="btn btn-primary ms-3">⬅ Back</a>

<div class="d-flex justify-content-center mt-5 px-3">
<table class="table">

  <tr>
    <th>ID</th>
    <th>Full Name</th>
    <th>Email</th>
    <th>Message</th>
    <th>Date</th>
  </tr>

  <?php
  $sql = "SELECT * FROM customer_messages ORDER BY submitted_at DESC";
  $res = mysqli_query($conn, $sql);

  if (mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
      echo "<tr>
              <td>{$row['id']}</td>
              <td>{$row['full_name']}</td>
              <td>{$row['email']}</td>
              <td>{$row['message']}</td>
              <td>{$row['submitted_at']}</td>
            </tr>";
    }
  } else {
    echo "<tr><td colspan='5'>No messages found</td></tr>";
  }
  ?>
</table>
</div>

<?php include('partials/footer.php'); ?>
