<div class="container mt-4">
    <div class="row justify-content-center mb-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h2 class="card-title mb-3"><i class="bi bi-folder2-open text-primary"></i> File Manager</h2>
                    <p class="card-text">Below you can find all uploaded files. You can preview images or delete files you no longer need.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-4">
        <?php foreach ($files as $file): ?>
            <div class="col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm text-center">
                    <?php if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $file)): ?>
                        <img src="/uploads/<?= htmlspecialchars($file); ?>" alt="<?= htmlspecialchars($file); ?>" class="card-img-top" style="max-height: 150px; object-fit: cover; margin-top: 10px;">
                    <?php else: ?>
                        <div class="pt-4 pb-2">
                            <i class="bi bi-file-earmark-text fs-1 text-secondary"></i>
                        </div>
                    <?php endif; ?>
                    <div class="card-body p-2">
                        <div class="small mb-2 text-break"><?= htmlspecialchars($file); ?></div>
                        <a href="/uploads/<?= htmlspecialchars($file); ?>" target="_blank" class="btn btn-outline-primary btn-sm mb-1 w-100"><i class="bi bi-eye"></i> View</a>
                        <form action="/filemanager/delete/<?= urlencode($file); ?>" method="POST" style="display:inline-block; width:100%;" onsubmit="return confirm('Are you sure you want to delete this file?');">
                            <button type="submit" class="btn btn-outline-danger btn-sm w-100"><i class="bi bi-trash"></i> Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> 