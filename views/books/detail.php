<h1><?= $book->title; ?></h1>
<p><?= $book->description; ?></p>
<p><strong>Author:</strong> <?= $author['name']; ?></p>
<p><strong>Published Year:</strong> <?= $book->published_year; ?></p>

<p><strong>Genre:</strong>
    <?php foreach ($genres as $genre): ?>
        <?= $genre['name']; ?> 
    <?php endforeach; ?>
</p>
<form method="POST" action="/book/delete/<?= $book->id ?>" onsubmit="return confirm('Weet je zeker dat je dit boek wilt verwijderen?');">
    <input type="submit" value="Verwijder Boek" />
</form>

<a href="/book/edit/<?= $book->id ?>" class="edit-btn">Bewerk dit boek</a>
