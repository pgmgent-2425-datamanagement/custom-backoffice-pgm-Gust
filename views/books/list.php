<h1>Books</h1>

<form>
    <label>Search
        <input type="text" name="search" placeholder="..." value="<?= $search ?>">
    </label>
    <input type="submit" value="Search">
</form>

<?php foreach ($list as $book) : ?>
<h2><?= $book->title; ?></h2>
<p><?= $book->description; ?></p>
<a href="/book/<?= $book->id; ?>">Bekijk alles</a>
<?php endforeach; ?>
