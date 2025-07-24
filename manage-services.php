<?php
session_start();
include('partials/connect.php');
include('partials/header.php');

// Admin check
if (!isset($_SESSION['admin_name'])) {
    header("Location: login.php");
    exit;
}

// Fetch services
$sql = "SELECT * FROM services ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="dashboard-container">
<a href="admin-dashboard.php" class="btn btn-primary back-btn">⬅ Back</a>
  <h2>Manage Services</h2>

  <a href="add-service.php" class="btn btn-primary">Add New Service</a>

  <div class="table-container">
    <table>
      <tr>
        <th>ID</th>
        <th>Service Name</th>
        <th>Price (USD)</th>
        <th>Actions</th>
      </tr>

      <?php
      if (mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";
              echo "<td>{$row['id']}</td>";
              echo "<td>" . htmlspecialchars($row['name']) . "</td>";
              echo "<td>$" . number_format($row['price'], 2) . "</td>";
              echo "<td>
                      <a href='edit-service.php?id={$row['id']}' class='btn btn-sm btn-warning'>Edit</a>
                      <a href='delete-service.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick=\"return confirm('Delete this service?');\">Delete</a>
                    </td>";
              echo "</tr>";
          }
      } else {
          echo "<tr><td colspan='4'>No services found.</td></tr>";
      }
      ?>
    </table>
  </div>
</div>

<?php include('partials/footer.php'); ?>
