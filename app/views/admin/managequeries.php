
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/assets/css/admin/usermanage.css" />

     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="/assets/js/filters.js"></script>
    
</head>
    <main>
        <section>
        <h3>Manage Queries</h3><br>
         <?php if (!empty($_SESSION['message'])): ?>
    <div class="alert alert-success">
        <?= $_SESSION['message']; unset($_SESSION['message']); ?>
    </div>
<?php endif; ?>
        <div class="filter">
    <form method="post" id="queryFilterForm" action="/admin/managequeries" class="ajax-filter-form" data-target="queries-table-container">
        <input type="text" name="name" placeholder="User name or email"
            value="<?= htmlspecialchars($filters['name'] ?? '') ?>">
        <input type="text" id="date_range" name="date_range" value="<?= $filters['date_range'] ?? '' ?>" placeholder="Select Date Range">
         <select name="status">
            <option value="">All Status</option>
            <option value="0" <?= ($filters['status'] ?? '')==='0'?'selected':'' ?>>Pending</option>
            <option value="1" <?= ($filters['status'] ?? '')==='1'?'selected':'' ?>>Reviewed</option>
            <option value="2" <?= ($filters['status'] ?? '')==='2'?'selected':'' ?>>Resolved</option>
        </select>
        <button type="submit" class="reset" name="reset_filters" value=1>reset</button>
    </form>
</div>
        <div id="queries-table-container">
             <?php include __DIR__ . '/partials/queries_table.php'; ?>
        </div>
        </section>
    </main>