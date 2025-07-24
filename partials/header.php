
<?php
include('partials/connect.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
    rel="stylesheet" />
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr"
    crossorigin="anonymous" />
  <link rel="stylesheet" href="styles.css" />
  <link rel="stylesheet" href="media-queries.css">
  <title>Smart-barber-shop</title>
</head>

<body>
  <header>
    <!-- nav bar section -->


    <nav class="navbar navbar-expand-lg navbar-dark my-navbar fixed-top">

      <div class="container">
        <a class="navbar-brand" href="index.html">Smart-Barber</a>

        <!-- Toggle button for mobile -->
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNavAltMarkup"
          aria-controls="navbarNavAltMarkup"
          aria-expanded="false"
          aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu items -->
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav ms-auto gap-3">
            <a class="nav-link active" href="index.php">Home</a>
            <a class="nav-link" href="about-us.php">About</a>
            <a class="nav-link" href="services.php">Services</a>
            <a class="nav-link" href="contacts.php">Contacts</a>
            <a class="btn-1" href="book.php">Book Appointment</a>
          </div>
        </div>
      </div>
    </nav>

    <!-- end of nav bar -->