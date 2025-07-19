<h1>Create Book</h1>

<form method="POST" enctype="multipart/form-data">
    <p>
        <label>
            Title
            <input type="text" name="title" placeholder="Title of the book" value="<?= htmlspecialchars($book->title ?? ''); ?>" required>
        </label>
    </p>
    <p>
        <label>
            Description
            <textarea name="description" rows="6"  placeholder="Enter a description"  required><?= htmlspecialchars($book->description ?? ''); ?></textarea>
        </label>
    </p>
    <p>
        <label>
            Author
            <select name="author_id" class="form-select" required>
                <option value="">Select author</option>
                <?php foreach ($authors as $a): ?>
                    <option value="<?= $a['id']; ?>" <?= (isset($book) && $book->author_id == $a['id']) ? 'selected' : ''; ?>><?= htmlspecialchars($a['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </label>
    </p>
    <p>
        <label>
            Published Date
            <input type="text" name="published_year" placeholder="YYYY" value="<?= htmlspecialchars($book->published_year ?? ''); ?>" pattern="\d{4}" title="Please enter a valid year (4 digits)" required>
        </label>
    </p>
    <p>
        <label>Genres:</label>
        <?php foreach ($genres as $genre): ?>
            <label>
                <input type="checkbox" name="genres[]" value="<?= $genre['id']; ?>" <?= (isset($bookGenres) && in_array($genre['id'], $bookGenres)) ? 'checked' : ''; ?>>
                <?= htmlspecialchars($genre['name']); ?>
            </label>
        <?php endforeach; ?>
    </p>
    <p>
        <label>
            Book Image
            <input type="file" name="image" accept="image/*">
        </label>
        <?php if (!empty($book->image)): ?>
            <br>
            <img src="/uploads/<?= htmlspecialchars($book->image); ?>" alt="Book Image" style="max-width: 150px; margin-top: 10px;">
        <?php endif; ?>
    </p>
    <input type="submit" value="Save">
</form>