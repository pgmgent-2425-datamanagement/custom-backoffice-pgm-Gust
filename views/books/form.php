<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <!-- Main Form Card -->
            <div class="card shadow">
                <!-- Form Header with dynamic title and book icon -->
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-book me-2"></i>
                        <?= isset($book) ? 'Edit Book' : 'Add New Book'; ?>
                    </h4>
                </div>
                
                <!-- Form Body with file upload support -->
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" action="<?= isset($book) ? '/book/update/'.$book->id : '/book/add'; ?>">
                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                        <!-- Book Title Field -->
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($book->title ?? ''); ?>" required>
                        </div>
                        
                        <!-- Book Description Field -->
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($book->description ?? ''); ?></textarea>
                        </div>
                        
                        <!-- Author Selection Dropdown -->
                        <div class="mb-3">
                            <label class="form-label">Author</label>
                            <select name="author_id" class="form-select" required>
                                <option value="">Select an author</option>
                                <?php foreach ($authors as $author): ?>
                                    <option value="<?= $author['id']; ?>" <?= (isset($book) && $book->author_id == $author['id']) ? 'selected' : ''; ?>>
                                        <?= htmlspecialchars($author['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <!-- Published Year Field with validation -->
                        <div class="mb-3">
                            <label class="form-label">Published Year</label>
                            <input type="number" name="published_year" class="form-control" value="<?= htmlspecialchars($book->published_year ?? ''); ?>" min="1900" max="<?= date('Y'); ?>" required>
                        </div>
                        
                        <!-- Genres Selection (Many-to-Many Relationship) -->
                        <div class="mb-3">
                            <label class="form-label">Genres</label>
                            <div class="row">
                                <?php foreach ($genres as $genre): ?>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="genres[]" value="<?= $genre['id']; ?>" id="genre_<?= $genre['id']; ?>"
                                                <?= (isset($bookGenres) && in_array($genre['id'], $bookGenres)) ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="genre_<?= $genre['id']; ?>">
                                                <?= htmlspecialchars($genre['name']); ?>
                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        
                        <!-- Image Upload Field with preview -->
                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <?php if (isset($book) && !empty($book->image)): ?>
                                <!-- Show current image when editing -->
                                <div class="mb-2">
                                    <img src="/uploads/<?= htmlspecialchars($book->image); ?>" alt="Current book image" class="img-fluid rounded shadow-sm mb-2" style="max-height: 150px;">
                                    <small class="text-muted d-block">Current image: <?= htmlspecialchars($book->image); ?></small>
                                </div>
                            <?php endif; ?>
                            <!-- File input for new image -->
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <small class="text-muted">Leave empty to keep current image (when editing)</small>
                        </div>
                        
                        <!-- Form Action Buttons -->
                        <div class="d-flex gap-2">
                            <!-- Submit button with dynamic text -->
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>
                                <?= isset($book) ? 'Update Book' : 'Create Book'; ?>
                            </button>
                            <!-- Cancel button - returns to books list -->
                            <a href="/books" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

