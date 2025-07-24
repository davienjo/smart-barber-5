<?php
include('partials/header.php');

?>




  <h1 class="h1-contact">Contact us</h1>
  <section class="contact-us-page">


    <section class="form-container">
      <h2 class="form-h2">Write us a message</h2>

      <form action="" method="post">
        <div>
          <label for="full_name">Full Name</label>
          <input
            type="text"
            name="full_name"
            placeholder="Enter your fullname"
            id="full_name" />
        </div>

        <div>
          <label for="email"> Your Email</label>
          <input
            type="email"
            name="email"
            placeholder="Enter your email"
            id="email" />
        </div>

        <div>
          <label for="textarea">Your Message</label>
          <textarea
            name="textarea"
            id="textarea"
            cols="20"
            rows="5"
            placeholder=" Type Your Message"></textarea>
        </div>

         <div>
          <input type="submit" name="submit" value="submit" class="btn-form">
         
         </div>
      </form>
    </section>


    <div class="container-map">
      <h2>Locate us</h2>

      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d429155.64985068096!2d-117.437420938153!3d32.82463303015271!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80deab82897fc6a5%3A0x65e19df063b57089!2sThe%20Hillcrest%20Notary!5e0!3m2!1sen!2ske!4v1752517236899!5m2!1sen!2ske"
        width="100%"
        height="300"
        style="border: 0"
        allowfullscreen=""
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"></iframe>

      <div class="contact-info">

        <p><strong>Phone:</strong> +1475843857</p>
        <p><strong>Location:</strong> San Diego USA</p>
        <p><strong>Hours:</strong> Mon–Sat: 9AM – 9PM</p>
      </div>

    </div>
  </section>



<?php



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $message = $_POST['textarea'];

    $sql = "INSERT INTO customer_messages (full_name, email, message)
            VALUES ('$full_name', '$email', '$message')";

    $res = mysqli_query($conn, $sql);

    if ($res) {
        echo "<script>alert('Message sent successfully!');</script>";
    } else {
        echo "<script>alert('Failed to send message');</script>";
    }
}
?>



  <?php
  include('partials/footer.php');
  ?>