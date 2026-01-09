<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/assets/css/admin/usermanage.css" />
    <link rel="stylesheet" href="/assets/css/pagination.css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="/assets/js/filters.js"></script>

</head>
<main>
    <section>
        <h3>Report Management</h3><br>
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['success'];
                unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
        <div class="filter">
            <form method="post" id="reportFilterForm" action="/admin/managereports" class="ajax-filter-form" data-target="reports-table-container">
                <input type="text" id="date_range" name="date_range" value="<?= $filters['date_range'] ?? '' ?>" placeholder="Select Date Range">
                <select name="status">
                    <option value="">All Status</option>
                    <option value="0" <?= ($filters['status'] ?? '') === '0' ? 'selected' : '' ?>>Pending</option>
                    <option value="1" <?= ($filters['status'] ?? '') === '1' ? 'selected' : '' ?>>Reviewed</option>
                    <option value="2" <?= ($filters['status'] ?? '') === '2' ? 'selected' : '' ?>>Resolved</option>
                </select>
                <button type="submit" class="reset" name="reset_filters" value=1>reset</button>
            </form>
        </div>
        
        <div id="reports-table-container">
            <?php include __DIR__ . '/partials/reports_table.php'; ?>
        </div>
    </section>
</main>