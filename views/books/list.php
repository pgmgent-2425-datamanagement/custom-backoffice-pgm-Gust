<?php
if (isset($_GET['sort'])) {
    if ($_GET['sort'] === 'newest') {

        usort($list, function ($a, $b) {
            return strtotime($b->created_at) - strtotime($a->created_at);
        });
    } elseif ($_GET['sort'] === 'oldest') {

        usort($list, function ($a, $b) {
            return strtotime($a->created_at) - strtotime($b->created_at);
        });
    }
}
?>

<h1>Books</h1>

<form method="GET" action="">
    <label>Search
        <input type="text" name="search" placeholder="..." value="<?= htmlspecialchars($search); ?>">
    </label>
    <input type="submit" value="Search">

    <label for="sort">Sort by:</label>
    <select name="sort" id="sort">
        <option value="newest" <?= (isset($_GET['sort']) && $_GET['sort'] === 'newest') ? 'selected' : ''; ?>>Newest Added</option>
        <option value="oldest" <?= (isset($_GET['sort']) && $_GET['sort'] === 'oldest') ? 'selected' : ''; ?>>Oldest Added</option>
    </select>
    <input type="submit" value="Sort">
</form>

<?php foreach ($list as $book) : ?>
    <div class="book-item">
        <h2><?= htmlspecialchars($book->title); ?></h2>
        <p><?= htmlspecialchars($book->description); ?></p>
        <a href="/book/<?= htmlspecialchars($book->id); ?>" class="view-all">View All</a>
    </div>
<?php endforeach; ?>
