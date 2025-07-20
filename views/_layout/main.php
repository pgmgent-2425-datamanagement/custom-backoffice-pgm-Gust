<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ($title ?? '') . ' ' . $_ENV['SITE_NAME'] ?></title>
    <link rel="stylesheet" href="/css/main.css?v=<?php if( $_ENV['DEV_MODE'] == "true" ) { echo time(); }; ?>">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4 py-2 sticky-top" style="background: linear-gradient(90deg, #2563eb 0%, #1e40af 100%);">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="/">
                <i class="bi bi-book-half fs-3"></i>
                <span class="fw-bold">BookSphere</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 justify-content-end w-100">
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 rounded<?= ($_SERVER['REQUEST_URI'] == '/' ? ' active fw-bold text-white shadow-sm' : '') ?>" href="/" style="transition: background 0.2s;">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 rounded<?= (strpos($_SERVER['REQUEST_URI'], '/books') === 0 ? ' active fw-bold text-white shadow-sm' : '') ?>" href="/books" style="transition: background 0.2s;">Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 rounded<?= (strpos($_SERVER['REQUEST_URI'], '/book/add') === 0 ? ' active fw-bold text-white shadow-sm' : '') ?>" href="/book/add" style="transition: background 0.2s;">New Book</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 rounded<?= (strpos($_SERVER['REQUEST_URI'], '/authors') === 0 ? ' active fw-bold text-white shadow-sm' : '') ?>" href="/authors" style="transition: background 0.2s;">Authors</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 rounded<?= (strpos($_SERVER['REQUEST_URI'], '/author/add') === 0 ? ' active fw-bold text-white shadow-sm' : '') ?>" href="/author/add" style="transition: background 0.2s;">New Author</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 rounded<?= (strpos($_SERVER['REQUEST_URI'], '/filemanager') === 0 ? ' active fw-bold text-white shadow-sm' : '') ?>" href="/filemanager" style="transition: background 0.2s;">File Manager</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        <?= $content; ?>
    </main>
    
    <style>
    .navbar-nav .nav-link:hover {
        background: rgba(255,255,255,0.12) !important;
        color: #fff !important;
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 2px 8px rgba(30,64,175,0.08);
        transition: all 0.18s cubic-bezier(.4,0,.2,1);
    }
    .navbar-nav .nav-link.active {
        background: #1e40af !important;
        color: #fff !important;
        box-shadow: 0 2px 12px rgba(30,64,175,0.18);
    }
    </style>

    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <footer class="bg-dark text-white text-center py-3 mt-5 shadow-sm small" style="opacity:0.95;">
        &copy; <?= date('Y'); ?> - BookSphere
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
