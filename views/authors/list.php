<h1>Authors</h1>
<a href="/author/add" class="btn btn-success mb-3">Add Author</a>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Name</th>
            <th>Birth Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($authors as $author): ?>
            <tr>
                <td><?= htmlspecialchars($author['name']); ?></td>
                <td><?= htmlspecialchars($author['birth_date']); ?></td>
                <td>
                    <a href="/author/edit/<?= $author['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                    <form action="/author/delete/<?= $author['id']; ?>" method="POST" style="display:inline-block" onsubmit="return confirm('Delete this author?');">
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table> 