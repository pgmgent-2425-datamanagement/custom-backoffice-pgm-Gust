<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <!-- Main Form Card -->
            <div class="card shadow">
                <!-- Form Header with dynamic title -->
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><?= isset($author) ? 'Edit Author' : 'Add New Author'; ?></h4>
                </div>
                
                <!-- Form Body -->
                <div class="card-body">
                    <form method="POST">
                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                        <!-- Author Name Field -->
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($author['name'] ?? ''); ?>" required>
                        </div>
                        
                        <!-- Author Birth Date Field (Optional) -->
                        <div class="mb-3">
                            <label class="form-label">Birth Date</label>
                            <input type="date" name="birth_date" class="form-control" value="<?= htmlspecialchars($author['birth_date'] ?? ''); ?>">
                        </div>
                        
                        <!-- Form Action Buttons -->
                        <div class="d-flex justify-content-between">
                            <!-- Cancel button - returns to authors list -->
                            <a href="/authors" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Cancel</a>
                            <!-- Submit button - saves the author data -->
                            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

 