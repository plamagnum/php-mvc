<?php include 'layout/header.php'; ?>
<h2 class="mb-4">Task List</h2>
<a href="/tasks/create" class="btn btn-success mb-3">Create New Task</a>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
        <tr>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= htmlspecialchars($row['description']) ?></td>
            <td><?= $row['created_at'] ?></td>
            <td>
                <a href="/tasks/edit/<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                <a href="/tasks/delete/<?= $row['id'] ?>" class="btn btn-sm btn-danger">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php include 'layout/footer.php'; ?>