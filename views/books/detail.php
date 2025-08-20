<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-lg border-0 mb-4">
                <div class="row g-0 align-items-center">
                    <?php if (!empty($book->image)): ?>
                        <div class="col-md-4 text-center p-4">
                            <img src="/uploads/<?= htmlspecialchars($book->image); ?>" alt="Book Image" class="img-fluid rounded shadow-sm mb-3 book-image">
                        </div>
                    <?php endif; ?>
                    <div class="col-md-8 p-4">
                        <h2 class="card-title mb-2 text-primary fw-bold">
                            <i class="bi bi-book-half me-2"></i><?= htmlspecialchars($book->title); ?>
                        </h2>
                        <div class="mb-3 text-muted small">
                            <span class="me-3"><i class="bi bi-person"></i> <?= htmlspecialchars($author['name'] ?? ''); ?></span>
                            <span class="me-3"><i class="bi bi-calendar"></i> <?= htmlspecialchars($book->published_year); ?></span>
                        </div>
                        <div class="mb-3">
                            <?php
                            $genreNames = array_map(function($g) { return htmlspecialchars($g['name']); }, $genres);
                            foreach ($genres as $genre) {
                                echo '<span class="badge bg-secondary me-1 mb-1"><i class="bi bi-tag"></i> ' . htmlspecialchars($genre['name']) . '</span>';
                            }
                            ?>
                        </div>
                        <div class="mb-4">
                            <h6 class="fw-semibold text-dark mb-1">Description</h6>
                            <p class="card-text text-body description-text"> <?= htmlspecialchars($book->description); ?></p>
                        </div>
                        <div class="d-flex flex-wrap gap-2 mt-4">
                            <a href="/books" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Back to list</a>
                            <a href="/book/edit/<?= htmlspecialchars($book->id); ?>" class="btn btn-primary"><i class="bi bi-pencil"></i> Edit</a>
                            <form action="/book/delete/<?= htmlspecialchars($book->id); ?>" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this book?');">
                                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i> Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


