<?php
session_start();
include('partials/connect.php');
include('partials/header.php');

// Restrict to logged-in admins only
if (!isset($_SESSION['admin_name'])) {
    header("Location: login.php");
    exit;
}

// Fetch customer info
$sql = "SELECT u.id, u.name, u.email, COUNT(b.id) AS total_bookings
        FROM users u
        LEFT JOIN bookings b ON u.id = b.user_id
        WHERE u.role = 'customer'
        GROUP BY u.id
        ORDER BY u.name ASC";


$result = mysqli_query($conn, $sql);
?>

<div class="dashboard-container">
 <a href="admin-dashboard.php" class="btn btn-primary back-btn">⬅ Back</a>
  <h2>All Customers</h2>

  <div class="table-container">
    <table>
      <tr>
        <th>SN</th>
        <th>Name</th>
        <th>Email</th>
        <th>Total Bookings</th>
        <th>Actions</th>
      </tr>

      <?php
      if (mysqli_num_rows($result) > 0) {
          $sn = 1;
          while($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";
              echo "<td>" . $sn++ . "</td>";
              echo "<td>" . htmlspecialchars($row['name']) . "</td>";
              echo "<td>" . htmlspecialchars($row['email']) . "</td>";
              echo "<td>" . $row['total_bookings'] . "</td>";
              echo "<td><a href='customer-history.php?id=" . $row['id'] . "' class='btn btn-sm btn-info'>View History</a></td>";
              echo "</tr>";
          }
      } else {
          echo "<tr><td colspan='5'>No customers found.</td></tr>";
      }
      ?>
    </table>
  </div>
</div>

<?php include('partials/footer.php'); ?>
