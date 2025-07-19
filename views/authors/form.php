<h1><?= isset($author) ? 'Edit' : 'Add'; ?> Author</h1>
<form method="POST">
    <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($author['name'] ?? ''); ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Birth Date</label>
        <input type="date" name="birth_date" class="form-control" value="<?= htmlspecialchars($author['birth_date'] ?? ''); ?>">
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
    <a href="/authors" class="btn btn-secondary">Cancel</a>
</form> 