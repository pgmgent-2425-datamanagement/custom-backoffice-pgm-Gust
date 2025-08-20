

<div class="container">
    <div class="row justify-content-between align-items-center mb-4">
        <div class="col">
            <h2>Authors</h2>
        </div>
        <div class="col-auto">
            <a href="/author/add" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Add Author</a>
        </div>
    </div>

    <div class="row g-4">
        <?php foreach ($authors as $author): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-primary"><?= htmlspecialchars($author['name']); ?></h5>
                        <?php if (!empty($author['birth_date'])): ?>
                            <p class="card-text text-muted">Born: <?= htmlspecialchars($author['birth_date']); ?></p>
                        <?php endif; ?>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <a href="/author/edit/<?= htmlspecialchars($author['id']); ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-pencil"></i> Edit</a>
                            <form action="/author/delete/<?= htmlspecialchars($author['id']); ?>" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this author?');">
                                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i> Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

 