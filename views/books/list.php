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

<div class="container">
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="GET" action="" class="row g-3 align-items-center">
                        <div class="col-md-5">
                            <input type="text" name="search" class="form-control" placeholder="Search by title or description..." value="<?= htmlspecialchars($search); ?>">
                        </div>
                        <div class="col-md-3">
                            <select name="sort" id="sort" class="form-select">
                                <option value="newest" <?= (isset($_GET['sort']) && $_GET['sort'] === 'newest') ? 'selected' : ''; ?>>Newest first</option>
                                <option value="oldest" <?= (isset($_GET['sort']) && $_GET['sort'] === 'oldest') ? 'selected' : ''; ?>>Oldest first</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i> Search</button>
                        </div>
                        <div class="col-md-2">
                            <a href="/book/add" class="btn btn-success w-100"><i class="bi bi-plus-circle"></i> New Book</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <?php foreach ($list as $book) : ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <?php if (!empty($book->image)): ?>
                        <img src="/uploads/<?= htmlspecialchars($book->image); ?>" class="card-img-top" alt="<?= htmlspecialchars($book->title); ?>" style="max-height: 200px; object-fit: cover;">
                    <?php endif; ?>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-primary"><?= htmlspecialchars($book->title); ?></h5>
                        <p class="card-text flex-grow-1"><?= htmlspecialchars($book->description); ?></p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <a href="/book/<?= htmlspecialchars($book->id); ?>" class="btn btn-outline-primary btn-sm"><i class="bi bi-eye"></i> Details</a>
                            <a href="/book/edit/<?= htmlspecialchars($book->id); ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-pencil"></i> Edit</a>
                            <form action="/book/delete/<?= htmlspecialchars($book->id); ?>" method="POST" style="display:inline-block" onsubmit="return confirm('Are you sure you want to delete this book?');">
                                <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i> Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
