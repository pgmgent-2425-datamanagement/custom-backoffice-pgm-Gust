<h1><?= htmlspecialchars($book->title); ?></h1>
<p><?= htmlspecialchars($book->description); ?></p>
<p><strong>Author:</strong> <?= htmlspecialchars($author['name']); ?></p>
<p><strong>Published Year:</strong> <?= htmlspecialchars($book->published_year); ?></p>

<p><strong>Genre:</strong>
    <?php foreach ($genres as $genre): ?>
        <?= htmlspecialchars($genre['name']); ?> 
    <?php endforeach; ?>
</p>

<form method="POST" action="/book/delete/<?= $book->id ?>" onsubmit="return confirm('Are you sure you want to delete this');">
    <input type="submit" value="Delete Book" />
</form>

<a href="/book/edit/<?= $book->id ?>" class="edit-btn">Edit Book info</a>
