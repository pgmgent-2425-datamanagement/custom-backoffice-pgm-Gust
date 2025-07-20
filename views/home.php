<?php
global $db;

// Info cards
$totalBooks = $db->query('SELECT COUNT(*) FROM books')->fetchColumn();
$totalAuthors = $db->query('SELECT COUNT(*) FROM authors')->fetchColumn();
$totalGenres = $db->query('SELECT COUNT(*) FROM genres')->fetchColumn();
$uploadsDir = __DIR__ . '/../public/uploads/';
$totalUploads = is_dir($uploadsDir) ? count(array_diff(scandir($uploadsDir), ['.', '..'])) : 0;

// Charts data
$stmtGenres = $db->query("SELECT genres.name, COUNT(books.id) as book_count
    FROM genres
    LEFT JOIN book_genre ON genres.id = book_genre.genre_id
    LEFT JOIN books ON book_genre.book_id = books.id
    GROUP BY genres.name");
$genresData = $stmtGenres->fetchAll(PDO::FETCH_ASSOC);

$stmtYears = $db->query("SELECT published_year, COUNT(*) as book_count
    FROM books
    GROUP BY published_year
    ORDER BY published_year");
$yearsData = $stmtYears->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mb-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            <div class="card shadow-sm border-0 mb-4 welcome-card" style="background: linear-gradient(120deg, #f8fafc 80%, #e0e7ff 100%); border-radius: 1rem;">
                <div class="card-body py-4 px-3 text-center">
                    <div class="mb-2">
                        <i class="bi bi-house-door-fill text-primary" style="font-size: 2rem;"></i>
                    </div>
                    <h3 class="card-title mb-2 fw-bold">Welcome to the BookSphere Backoffice</h3>
                    <div class="mb-2 text-primary-emphasis small">Your central hub for book management</div>
                    <p class="card-text mb-3">Manage your books, authors, genres, and uploads in one place. Use the quick action buttons below to get started!</p>
                    <div class="d-flex flex-wrap justify-content-center gap-2 mt-2">
                        <a href="/books" class="btn btn-primary px-3 py-2 welcome-btn"><i class="bi bi-book"></i> Books</a>
                        <a href="/authors" class="btn btn-secondary px-3 py-2 welcome-btn"><i class="bi bi-person"></i> Authors</a>
                        <a href="/filemanager" class="btn btn-outline-dark px-3 py-2 welcome-btn"><i class="bi bi-folder"></i> Files</a>
                        <a href="/book/add" class="btn btn-success px-3 py-2 welcome-btn"><i class="bi bi-plus-circle"></i> Add Book</a>
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
                    <div class="fw-bold fs-4"><?= $totalBooks ?></div>
                    <div class="small text-muted">Books</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body py-3">
                    <div class="fs-2 mb-1 text-secondary"><i class="bi bi-person"></i></div>
                    <div class="fw-bold fs-4"><?= $totalAuthors ?></div>
                    <div class="small text-muted">Authors</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body py-3">
                    <div class="fs-2 mb-1 text-success"><i class="bi bi-tags"></i></div>
                    <div class="fw-bold fs-4"><?= $totalGenres ?></div>
                    <div class="small text-muted">Genres</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body py-3">
                    <div class="fs-2 mb-1 text-dark"><i class="bi bi-image"></i></div>
                    <div class="fw-bold fs-4"><?= $totalUploads ?></div>
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
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h4 class="card-title mb-3">Books per Year</h4>
                    <p class="text-muted small mb-2">Track how your collection grows over time.</p>
                    <canvas id="chart2" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.welcome-card {
    box-shadow: 0 4px 24px rgba(30,64,175,0.06) !important;
    border: none !important;
}
.welcome-btn {
    transition: transform 0.13s cubic-bezier(.4,0,.2,1), box-shadow 0.13s cubic-bezier(.4,0,.2,1);
    font-size: 1rem;
}
.welcome-btn:hover, .welcome-btn:focus {
    transform: translateY(-1px) scale(1.03);
    box-shadow: 0 2px 8px rgba(30,64,175,0.10);
    z-index: 2;
}
</style>

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