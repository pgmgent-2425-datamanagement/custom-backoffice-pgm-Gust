<div class="container">
    <div class="row justify-content-between align-items-center mb-4">
        <div class="col">
            <h2>File Manager</h2>
            <p class="text-muted">Manage uploaded files</p>
        </div>
    </div>

    <div class="row g-4">
        <?php if (empty($files)): ?>
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="bi bi-folder-x fs-1 d-block mb-2"></i>
                    <h5>No files uploaded yet</h5>
                    <p class="mb-0">Upload files through the book forms to see them here.</p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($files as $file): ?>
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm">
                        <?php
                        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])): ?>
                            <img src="/uploads/<?= htmlspecialchars($file); ?>" alt="<?= htmlspecialchars($file); ?>" class="card-img-top" style="height: 150px; object-fit: cover;">
                        <?php else: ?>
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 150px;">
                                <i class="bi bi-file-earmark fs-1 text-muted"></i>
                            </div>
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title text-truncate" title="<?= htmlspecialchars($file); ?>"><?= htmlspecialchars($file); ?></h6>
                            <p class="card-text small text-muted">Size: <?= number_format(filesize(__DIR__ . '/../../public/uploads/' . $file) / 1024, 2); ?> KB</p>
                            <div class="mt-auto">
                                <form action="/filemanager/delete/<?= urlencode($file); ?>" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this file?');">
                                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                    <button type="submit" class="btn btn-outline-danger btn-sm w-100"><i class="bi bi-trash"></i> Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

 