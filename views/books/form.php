<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><?= isset($book) ? 'Edit Book' : 'Add New Book'; ?></h4>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($book->title ?? ''); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="5" class="form-control" required><?= htmlspecialchars($book->description ?? ''); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Author</label>
                            <select name="author_id" class="form-select" required>
                                <option value="">Select author</option>
                                <?php foreach ($authors as $a): ?>
                                    <option value="<?= $a['id']; ?>" <?= (isset($book) && $book->author_id == $a['id']) ? 'selected' : ''; ?>><?= htmlspecialchars($a['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Year of Publication</label>
                            <input type="text" name="published_year" class="form-control" value="<?= htmlspecialchars($book->published_year ?? ''); ?>" pattern="\d{4}" title="Enter a valid year (4 digits)" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Genres</label><br>
                            <?php foreach ($genres as $genre): ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="genres[]" value="<?= $genre['id']; ?>" <?= (isset($bookGenres) && in_array($genre['id'], $bookGenres)) ? 'checked' : ''; ?>>
                                    <label class="form-check-label">
                                        <?= htmlspecialchars($genre['name']); ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Book Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <?php if (!empty($book->image)): ?>
                                <div class="mt-2">
                                    <img src="/uploads/<?= htmlspecialchars($book->image); ?>" alt="Book Image" style="max-width: 120px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="/books" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Cancel</a>
                            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">