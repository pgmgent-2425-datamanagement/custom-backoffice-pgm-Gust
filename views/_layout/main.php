<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ($title ?? '') . ' ' . $_ENV['SITE_NAME'] ?></title>
    <!-- Load main CSS with cache busting in development mode -->
    <link rel="stylesheet" href="/css/main.css">
    <!-- Chart.js for dashboard charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">

    <!-- Main Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4 py-2 sticky-top">
        <div class="container">
            <!-- Brand/Logo Section -->
            <a class="navbar-brand d-flex align-items-center gap-2" href="/">
                <i class="bi bi-book-half fs-4"></i>
                <span class="fw-bold">BookSphere</span>
            </a>
            
            <!-- Mobile Navigation Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Navigation Menu Items -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 justify-content-end w-100">
                    <!-- Dashboard Link -->
                    <li class="nav-item">
                        <a class="nav-link px-2 py-1 rounded<?= ($_SERVER['REQUEST_URI'] == '/' ? ' active fw-bold text-white bg-primary-dark' : '') ?>" href="/">Dashboard</a>
                    </li>
                    
                    <!-- Books Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle px-2 py-1 rounded<?= (strpos($_SERVER['REQUEST_URI'], '/books') === 0 || strpos($_SERVER['REQUEST_URI'], '/book/add') === 0 ? ' active fw-bold text-white bg-primary-dark' : '') ?>" href="#" id="booksDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Books</a>
                        <ul class="dropdown-menu" aria-labelledby="booksDropdown">
                            <li><a class="dropdown-item" href="/books">All Books</a></li>
                            <li><a class="dropdown-item" href="/book/add">Add Book</a></li>
                        </ul>
                    </li>
                    
                    <!-- Authors Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle px-2 py-1 rounded<?= (strpos($_SERVER['REQUEST_URI'], '/authors') === 0 || strpos($_SERVER['REQUEST_URI'], '/author/add') === 0 ? ' active fw-bold text-white bg-primary-dark' : '') ?>" href="#" id="authorsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Authors</a>
                        <ul class="dropdown-menu" aria-labelledby="authorsDropdown">
                            <li><a class="dropdown-item" href="/authors">All Authors</a></li>
                            <li><a class="dropdown-item" href="/author/add">Add Author</a></li>
                        </ul>
                    </li>
                    
                    <!-- File Manager Link -->
                    <li class="nav-item">
                        <a class="nav-link px-2 py-1 rounded<?= (strpos($_SERVER['REQUEST_URI'], '/filemanager') === 0 ? ' active fw-bold text-white bg-primary-dark' : '') ?>" href="/filemanager">File Manager</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="container py-4">
        <?= $content; ?>
    </main>

    <!-- Bootstrap Icons for UI icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Footer Section -->
    <footer class="bg-dark text-white text-center py-3 mt-5 shadow-sm small" style="opacity:0.95;">
        &copy; <?= date('Y'); ?> - BookSphere
    </footer>
    
    <!-- Bootstrap JavaScript Bundle for interactive components -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>