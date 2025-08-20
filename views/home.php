<?php
// Database queries zijn verplaatst naar HomeController voor betere performance
?>

<div class="container mb-4">
    <div class="row g-3 mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 mb-4 welcome-card">
                <div class="card-body py-4 px-3 text-center">
                    <div class="mb-2">
                        <i class="bi bi-house-door-fill text-primary welcome-icon"></i>
                    </div>
                    <h3 class="card-title mb-3 fw-bold display-6 text-gradient">Welcome to the BookSphere Backoffice</h3>
                    <div class="mb-3 text-primary-emphasis fw-medium fs-5">Your central hub for book management</div>
                    <p class="card-text mb-4 fs-6 text-muted lh-base">Manage your books, authors, genres, and uploads in one place. Use the quick action buttons below to get started!</p>
                    
                    <div class="row g-3 justify-content-center">
                        <div class="col-6 col-md-3">
                            <a href="/books" class="btn btn-primary btn-lg w-100 h-100 d-flex flex-column align-items-center justify-content-center text-decoration-none p-3 rounded-3 shadow-sm hover-lift">
                                <i class="bi bi-book fs-1 mb-2"></i>
                                <span class="fw-semibold">Books</span>
                                <small class="text-light opacity-75">Manage Collection</small>
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <a href="/authors" class="btn btn-secondary btn-lg w-100 h-100 d-flex flex-column align-items-center justify-content-center text-decoration-none p-3 rounded-3 shadow-sm hover-lift">
                                <i class="bi bi-person fs-1 mb-2"></i>
                                <span class="fw-semibold">Authors</span>
                                <small class="text-light opacity-75">Manage Writers</small>
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <a href="/filemanager" class="btn btn-warning btn-lg w-100 h-100 d-flex flex-column align-items-center justify-content-center text-decoration-none p-3 rounded-3 shadow-sm hover-lift">
                                <i class="bi bi-folder fs-1 mb-2"></i>
                                <span class="fw-semibold">Files</span>
                                <small class="text-dark opacity-75">Manage Uploads</small>
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <a href="/book/add" class="btn btn-success btn-lg w-100 h-100 d-flex flex-column align-items-center justify-content-center text-decoration-none p-3 rounded-3 shadow-sm hover-lift">
                                <i class="bi bi-plus-circle fs-1 mb-2"></i>
                                <span class="fw-semibold">Add Book</span>
                                <small class="text-light opacity-75">New Entry</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Info cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body py-3">
                    <div class="fs-2 mb-1 text-primary"><i class="bi bi-book"></i></div>
                    <div class="fw-bold fs-4"><?= $counts['total_books'] ?></div>
                    <div class="small text-muted">Books</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body py-3">
                    <div class="fs-2 mb-1 text-secondary"><i class="bi bi-person"></i></div>
                    <div class="fw-bold fs-4"><?= $counts['total_authors'] ?></div>
                    <div class="small text-muted">Authors</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body py-3">
                    <div class="fs-2 mb-1 text-success"><i class="bi bi-tags"></i></div>
                    <div class="fw-bold fs-4"><?= $counts['total_genres'] ?></div>
                    <div class="small text-muted">Genres</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body py-3">
                    <div class="fs-2 mb-1 text-dark"><i class="bi bi-image"></i></div>
                    <div class="fw-bold fs-4"><?= $counts['total_uploads'] ?></div>
                    <div class="small text-muted">Uploads</div>
                </div>
            </div>
        </div>
    </div>
    <!-- Dashboard charts in cards -->
    <div class="row g-4 charts-container">
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h4 class="card-title mb-3">Books per Genre</h4>
                    <p class="text-muted small mb-2">See which genres are most popular in your collection.</p>
                    <canvas id="chart1" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-center shadow-sm h-100">
                <div class="card-body">
                    <h4 class="card-title mb-3">Books per Year</h4>
                    <p class="text-muted small mb-2">Track how your collection grows over time.</p>
                    <canvas id="chart2" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Chart 1: Books per Genre
    const genresData = <?php echo json_encode($genresData); ?>;
    const genreLabels = genresData.map(g => g.name);
    const genreCounts = genresData.map(g => g.book_count);
    new Chart(document.getElementById('chart1').getContext('2d'), {
        type: 'bar',
        data: {
            labels: genreLabels,
            datasets: [{
                label: 'Books',
                data: genreCounts,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    // Chart 2: Books per Year
    const yearsData = <?php echo json_encode($yearsData); ?>;
    const yearLabels = yearsData.map(y => y.published_year);
    const yearCounts = yearsData.map(y => y.book_count);
    new Chart(document.getElementById('chart2').getContext('2d'), {
        type: 'line',
        data: {
            labels: yearLabels,
            datasets: [{
                label: 'Books',
                data: yearCounts,
                fill: false,
                borderColor: 'rgba(255, 99, 132, 1)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });
</script>