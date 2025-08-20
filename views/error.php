<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-danger shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-exclamation-triangle me-2"></i>Error
                    </h4>
                </div>
                <div class="card-body text-center py-4">
                    <i class="bi bi-x-circle text-danger" style="font-size: 4rem;"></i>
                    <h5 class="text-danger mt-3">Something went wrong</h5>
                    <p class="text-muted mb-4"><?= htmlspecialchars($message ?? 'An unknown error occurred') ?></p>
                    
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="javascript:history.back()" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Go Back
                        </a>
                        <a href="/" class="btn btn-primary">
                            <i class="bi bi-house me-2"></i>Go Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
