<h1>Edit Book</h1>

<form method="POST" action="/book/update/<?= $book->id ?>">
    <p>
        <label>
            Title
            <input type="text" name="title" value="<?= htmlspecialchars($book->title) ?>">
        </label>
    </p>
    <p>
        <label>
            Description
            <textarea name="description" rows="6"><?= htmlspecialchars($book->description) ?></textarea>
        </label>
    </p>
    <p>
        <label>
            Author
            <input type="text" name="author" value="<?= htmlspecialchars($author['name']) ?>">
        </label>
    </p>
    <p>
        <label>
            Published Year
            <input type="text" name="published_year" value="<?= htmlspecialchars($book->published_year) ?>">
        </label>
    </p>
    <p>
        <label>Genres:</label>
        <?php foreach ($genres as $genre): ?>
            <label>
                <input type="checkbox" name="genres[]" value="<?= $genre['id'] ?>"
                    <?= in_array($genre['id'], $bookGenres) ? 'checked' : '' ?>>
                <?= htmlspecialchars($genre['name']) ?>
            </label>
        <?php endforeach; ?>
    </p>
    <input type="submit" value="Save Changes">
</form>
