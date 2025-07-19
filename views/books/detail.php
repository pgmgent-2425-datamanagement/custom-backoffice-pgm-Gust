<h1><?= htmlspecialchars($book->title); ?></h1>

<?php if (!empty($book->image)): ?>
    <img src="/uploads/<?= htmlspecialchars($book->image); ?>" alt="Book Image" style="max-width: 250px; margin-bottom: 20px; display: block;">
<?php endif; ?>

<p><strong>Description:</strong> <?= htmlspecialchars($book->description); ?></p>
<p><strong>Author:</strong> <?= htmlspecialchars($author['name'] ?? ''); ?></p>
<p><strong>Published Year:</strong> <?= htmlspecialchars($book->published_year); ?></p>
<p><strong>Genres:</strong> 
    <?php
    $genreNames = array_map(function($g) { return htmlspecialchars($g['name']); }, $genres);
    echo implode(', ', $genreNames);
    ?>
</p>
<a href="/books" class="btn btn-secondary">Back to list</a>
