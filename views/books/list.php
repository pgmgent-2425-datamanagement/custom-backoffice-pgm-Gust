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

<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-primary fw-bold">
                        <i class="bi bi-book-half me-2"></i>Book Management
                    </h1>
                    <p class="text-muted mb-0">Manage your book collection with ease</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="/book/add" class="btn btn-primary btn-lg">
                        <i class="bi bi-plus-circle me-2"></i>Add New Book
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form method="GET" action="" class="row g-3 align-items-end">
                        <div class="col-lg-6">
                            <label for="search" class="form-label fw-semibold text-muted small mb-2">
                                <i class="bi bi-search me-1"></i>Search Books
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-search text-muted"></i>
                                </span>
                                <input type="text" name="search" id="search" class="form-control border-start-0 ps-0" 
                                       placeholder="Search by title, description, or author..." 
                                       value="<?= htmlspecialchars($search); ?>">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <label for="sort" class="form-label fw-semibold text-muted small mb-2">
                                <i class="bi bi-sort-down me-1"></i>Sort Order
                            </label>
                            <select name="sort" id="sort" class="form-select">
                                <option value="newest" <?= (isset($_GET['sort']) && $_GET['sort'] === 'newest') ? 'selected' : ''; ?>>Newest First</option>
                                <option value="oldest" <?= (isset($_GET['sort']) && $_GET['sort'] === 'oldest') ? 'selected' : ''; ?>>Oldest First</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <button type="submit" class="btn btn-outline-primary w-100">
                                <i class="bi bi-funnel me-1"></i>Apply Filters
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Results Summary -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <span class="badge bg-primary fs-6 px-3 py-2">
                        <i class="bi bi-collection me-1"></i><?= count($list); ?> Books Found
                    </span>
                    <?php if (!empty($search)): ?>
                        <span class="text-muted">
                            <i class="bi bi-search me-1"></i>Results for: "<strong><?= htmlspecialchars($search); ?></strong>"
                        </span>
                    <?php endif; ?>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary btn-sm" id="exportBtn">
                        <i class="bi bi-download me-1"></i>Export
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Books Grid -->
    <div class="row g-4">
        <?php if (empty($list)): ?>
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-book text-muted" style="font-size: 4rem;"></i>
                    <h4 class="text-muted mt-3">No books found</h4>
                    <p class="text-muted">Try adjusting your search criteria or add a new book.</p>
                    <a href="/book/add" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Add Your First Book
                    </a>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($list as $book) : ?>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm book-card">
                        <div class="position-relative">
                            <?php if (!empty($book->image)): ?>
                                <img src="/uploads/<?= htmlspecialchars($book->image); ?>" 
                                     class="card-img-top book-image" 
                                     alt="<?= htmlspecialchars($book->title); ?>"
                                     style="height: 200px; object-fit: cover;">
                            <?php else: ?>
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                     style="height: 200px;">
                                    <i class="bi bi-book text-muted" style="font-size: 3rem;"></i>
                                </div>
                            <?php endif; ?>
                            

                        </div>
                        
                        <div class="card-body d-flex flex-column p-3">
                            <h5 class="card-title text-primary fw-bold mb-2 line-clamp-2" 
                                title="<?= htmlspecialchars($book->title); ?>">
                                <?= htmlspecialchars($book->title); ?>
                            </h5>
                            
                            <p class="card-text text-muted small flex-grow-1 line-clamp-3 mb-3" 
                               title="<?= htmlspecialchars($book->description); ?>">
                                <?= htmlspecialchars($book->description); ?>
                            </p>
                            
                            <!-- Book Meta Info -->
                            <div class="small text-muted mb-3">
                                <?php if (!empty($book->published_year)): ?>
                                    <div class="mb-1">
                                        <i class="bi bi-calendar3 me-1"></i><?= htmlspecialchars($book->published_year); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($book->isbn)): ?>
                                    <div class="mb-1">
                                        <i class="bi bi-upc-scan me-1"></i><?= htmlspecialchars($book->isbn); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="d-grid gap-2">
                                <a href="/book/<?= htmlspecialchars($book->id); ?>" 
                                   class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-eye me-1"></i>View Details
                                </a>
                                <div class="d-flex gap-1">
                                    <a href="/book/edit/<?= htmlspecialchars($book->id); ?>" 
                                       class="btn btn-outline-secondary btn-sm flex-fill">
                                        <i class="bi bi-pencil me-1"></i>Edit
                                    </a>
                                    <form action="/book/delete/<?= htmlspecialchars($book->id); ?>" 
                                          method="POST" 
                                          class="flex-fill" 
                                          onsubmit="return confirm('Are you sure you want to delete this book?');">
                                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                        <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                            <i class="bi bi-trash me-1"></i>Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Make books data available to JavaScript -->
<script>
window.booksData = <?= json_encode($list); ?>;
</script>

<!-- Load books JavaScript -->
<script src="/js/books.js"></script>
