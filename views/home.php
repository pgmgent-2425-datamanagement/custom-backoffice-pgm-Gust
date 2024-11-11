<h1>Admin Dashboard</h1>

   <div class="charts-container">
            <div class="chart">
                <h3>Books per Genre</h3>
                <canvas id="chart1" width="400" height="400"></canvas>
            </div>

            <div class="chart">
                <h3>Books per Author</h3>
                <canvas id="chart2" width="400" height="400"></canvas>
            </div>
        </div>

<?php
$host = 'db';
$db = 'db';
$user = 'db';
$pass = 'db';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmtGenres = $pdo->query("SELECT genres.name, COUNT(books.id) as book_count
                                FROM genres
                                LEFT JOIN book_genre ON genres.id = book_genre.genre_id
                                LEFT JOIN books ON book_genre.book_id = books.id
                                GROUP BY genres.name");
    $genresData = $stmtGenres->fetchAll(PDO::FETCH_ASSOC);

    $stmtAuthors = $pdo->query("SELECT authors.name, COUNT(books.id) as book_count
                                FROM authors
                                LEFT JOIN books ON authors.id = books.author_id
                                GROUP BY authors.name");
    $authorsData = $stmtAuthors->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
    exit;
}
?>

<script>
    const genresData = <?php echo json_encode($genresData); ?>;
    const authorsData = <?php echo json_encode($authorsData); ?>;

    document.addEventListener('DOMContentLoaded', function () {
        const ctx1 = document.getElementById('chart1').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: genresData.map(genre => genre.name),
                datasets: [{
                    label: 'Books per Genre',
                    data: genresData.map(genre => genre.book_count),
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true, position: 'top' }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        const ctx2 = document.getElementById('chart2').getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: authorsData.map(author => author.name),
                datasets: [{
                    label: 'Books per Author',
                    data: authorsData.map(author => author.book_count),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true, position: 'top' }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    });
</script>