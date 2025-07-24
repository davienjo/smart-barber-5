<?php
session_start();
include('partials/connect.php');
include('partials/header.php');

if (!isset($_SESSION['admin_name'])) {
    header("Location: login.php");
    exit;
}

// Fetch Appointments per day
$appointmentsPerDay = [];
$result = mysqli_query($conn, "SELECT date, COUNT(*) AS total FROM bookings GROUP BY date ORDER BY date");
while ($row = mysqli_fetch_assoc($result)) {
    $appointmentsPerDay['labels'][] = $row['date'];
    $appointmentsPerDay['data'][] = $row['total'];
}

// Fetch Most Popular Services
$popularServices = [];
$result = mysqli_query($conn, "SELECT service, COUNT(*) AS count FROM bookings GROUP BY service ORDER BY count DESC LIMIT 5");
while ($row = mysqli_fetch_assoc($result)) {
    $popularServices['labels'][] = $row['service'];
    $popularServices['data'][] = $row['count'];
}

// Fetch Revenue over Time
$revenueOverTime = [];
$result = mysqli_query($conn, "SELECT date, SUM(price) AS revenue FROM bookings GROUP BY date ORDER BY date");
while ($row = mysqli_fetch_assoc($result)) {
    $revenueOverTime['labels'][] = $row['date'];
    $revenueOverTime['data'][] = $row['revenue'];
}
?>

<div class="dashboard-container">
    <a href="admin-dashboard.php" class="btn btn-primary back-btn">⬅ Back</a> 
    <h2>Analytics Dashboard</h2>

    <canvas id="appointmentsChart" height="100"></canvas>
    <canvas id="servicesChart" height="100"></canvas>
    <canvas id="revenueChart" height="100"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const appointmentsChart = new Chart(document.getElementById('appointmentsChart'), {
    type: 'bar',
    data: {
        labels: <?= json_encode($appointmentsPerDay['labels']) ?>,
        datasets: [{
            label: 'Appointments per Day',
            data: <?= json_encode($appointmentsPerDay['data']) ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.6)'
        }]
    }
});

const servicesChart = new Chart(document.getElementById('servicesChart'), {
    type: 'pie',
    data: {
        labels: <?= json_encode($popularServices['labels']) ?>,
        datasets: [{
            label: 'Most Popular Services',
            data: <?= json_encode($popularServices['data']) ?>,
            backgroundColor: ['#f39c12','#e74c3c','#8e44ad','#3498db','#2ecc71']
        }]
    }
});

const revenueChart = new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: {
        labels: <?= json_encode($revenueOverTime['labels']) ?>,
        datasets: [{
            label: 'Revenue Over Time',
            data: <?= json_encode($revenueOverTime['data']) ?>,
            backgroundColor: 'rgba(46, 204, 113, 0.5)',
            borderColor: '#2ecc71',
            fill: true,
            tension: 0.2
        }]
    }
});
</script>

<?php include('partials/footer.php'); ?>
