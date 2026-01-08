<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/assets/css/admin/usermanage.css" />
    <link rel="stylesheet" href="/assets/css/pagination.css" />
    <script src="/assets/js/filters.js"></script>

</head>
<main>
    <section>
        <h2>User Management</h2><br>
        <div class="filter">
            <form method="post" action="/admin/usermanage" class="ajax-filter-form" data-target="users-table-container">
                <input type="text" name="name" placeholder="Enter name"
                value="<?= htmlspecialchars($filters['name'] ?? '') ?>">
                <select name="profilestatus">
                    <option value="">All Profiles</option>
                    <option value="1" <?= ($filters['profilestatus'] ?? '') === '1' ? 'selected' : '' ?>>Completed Profiles</option>
                    <option value="0" <?= ($filters['profilestatus'] ?? '') === '0' ? 'selected' : '' ?>>Incomplete Profiles</option>
                </select>

                <select name="userstatus">
                    <option value="">All Users</option>
                    <option value="1" <?= ($filters['userstatus'] ?? '') === '1' ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?= ($filters['userstatus'] ?? '') === '0' ? 'selected' : '' ?>>Blocked</option>
                </select>
                 <button type="submit" class="reset" name="reset_filters" value=1>reset</button>
                 <button type="submit" class="export" name="export" value="1">Export CSV</button>
            </form>
        </div>
        <div id="users-table-container">
            <?php include __DIR__ . '/partials/users_table.php'; ?>
        </div>
    </section>
</main>