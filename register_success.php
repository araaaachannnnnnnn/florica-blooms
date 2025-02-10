<?php
session_start();
include 'header.php';
?>

<div class="container">
  <?php if (isset($_SESSION['register_status']) && $_SESSION['register_status'] == 'success'): ?>
    <div class="alert alert-success">
      <strong><?php echo $_SESSION['register_message']; ?></strong>
    </div>
  <?php elseif (isset($_SESSION['register_status']) && $_SESSION['register_status'] == 'fail'): ?>
    <div class="alert alert-danger">
      <strong><?php echo $_SESSION['register_message']; ?></strong>
    </div>
  <?php endif; ?>
</div>

<script>
  // Redirect back to register.php after 3 seconds
  setTimeout(function() {
    window.location.href = 'register.php';
  }, 3000);
</script>

<?php
// Clear the session variables after displaying the message
unset($_SESSION['register_status']);
unset($_SESSION['register_message']);
include 'footer.php';
?>