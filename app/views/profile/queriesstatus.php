<head>
    <meta charset="UTF-8">
    <title>My Queries Status</title>
        <link rel="stylesheet" href="/assets/css/queriesstatus.css" />
    <script src="/assets/js/filters.js"></script>
</head>
    <main>
        <section>
            <div class="btn">
            <a href="/user/contactsupport" >Back to Contact Support</a></div>
            <h3>My Queries Status</h3>
            
            <div class="filter-section" style="margin-bottom: 20px;">
                <form method="post" action="/user/queriesstatus" class="ajax-filter-form" data-target="queries-status-container">
                    <select name="status" style="padding: 8px; border-radius: 4px; border: 1px solid #ddd;">
                        <option value="">All Status</option>
                        <option value="0" <?= ($filters['status'] ?? '') === '0' ? 'selected' : '' ?>>Pending</option>
                        <option value="1" <?= ($filters['status'] ?? '') === '1' ? 'selected' : '' ?>>Reviewed</option>
                        <option value="2" <?= ($filters['status'] ?? '') === '2' ? 'selected' : '' ?>>Resolved</option>
                    </select>
                </form>
            </div>

            <div id="queries-status-container">
                <?php include __DIR__ . '/partials/queries_status_table.php'; ?>
            </div>
        </section>
    </main>
    </main>
</html>