<?php if (isset($_SESSION['toastr_info'])): ?>
<div id="toast-info"><?php echo $_SESSION['toastr_info']; ?></div>
<?php unset($_SESSION['toastr_info']); endif; ?>

<?php if (!empty($_SESSION['toastr_error'])): ?>
<div id="toast-error"><?php echo $_SESSION['toastr_error']; ?></div>
<?php unset($_SESSION['toastr_error']); endif; ?>

<?php if (!empty($_SESSION['toastr_success'])): ?>
<div id="toast-success"><?php echo $_SESSION['toastr_success']; ?></div>
<?php unset($_SESSION['toastr_success']); endif; ?>

<?php if (!empty($_SESSION['toastr_warning'])): ?>
<div id="toast-warning"><?php echo $_SESSION['toastr_warning']; ?></div>
<?php unset($_SESSION['toastr_warning']); endif; ?>