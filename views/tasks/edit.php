<?php include 'layout/header.php'; ?>
<h2 class="mb-4">Edit Task</h2>
<form method="POST">
    <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" value="<?= $task->title ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="3"><?= $task->description ?></textarea>
    </div>
    <button type="submit" class="btn btn-warning">Update</button>
</form>
<?php include 'layout/footer.php'; ?>