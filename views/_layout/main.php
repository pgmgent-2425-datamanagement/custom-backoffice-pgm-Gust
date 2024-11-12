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
<body>

    <nav>
        <a href="/">Home</a>
        <a href="/books">Books</a>
        <a href="/book/add">Add Book</a>
    </nav>

    <main>
        <?= $content; ?>

    </main>
    
    <footer>
        &copy; <?= date('Y'); ?> - BookSphere
    </footer>
</body>
</html>
