<h1>Create Book</h1>

<form method="POST">
    <p>
        <label>
            Name
            <input type="text" name="title" placeholder="..." value="">
        </label>
    </p>
    <p>
        <label>
            Description
            <textarea name="description" rows="6"></textarea>
        </label>
    </p>
    <p>
        <label>
            Author
            <input type="text" name="author" placeholder="Enter author's name" value="">
        </label>
    </p>
    <p>
        <label>
            Published Date
            <input type="text" name="published_year" placeholder="YYYY" value="" pattern="\d{4}" title="Please enter a valid year (4 digits)" required>
        </label>
    </p>
    <p>
        <label>Genres:</label>
        <?php foreach ($genres as $genre): ?>
            <label>
                <input type="checkbox" name="genres[]" value="<?= $genre['id']; ?>">
                <?= htmlspecialchars($genre['name']); ?>
            </label>
        <?php endforeach; ?>
    </p>

    
    <input type="submit" value="Save">
</form>