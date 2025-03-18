<?php include 'layout/header.php'; ?>
<h2 class="mb-4">Delete Task</h2>
<div class="alert alert-danger">
    Are you sure you want to delete this task?
</div>
<form method="POST">
    <button type="submit" class="btn btn-danger">Confirm Delete</button>
    <a href="/tasks" class="btn btn-secondary">Cancel</a>
</form>
<?php include 'layout/footer.php'; ?>