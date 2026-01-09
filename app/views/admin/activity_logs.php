<head>
    <link rel="stylesheet" href="/assets/css/admin/usermanage.css" />
    <link rel="stylesheet" href="/assets/css/pagination.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="/assets/js/filters.js"></script>
</head>
<main>
    <section>
    <div class="activity-logs-container">
        <h2 class="mb-4">Activity Logs</h2>

        <div class="filter">
            <form method="post" id="activityFilterForm" action="/admin/activity-logs" class="ajax-filter-form" data-target="activity-table-container">
                <input type="text" name="email" placeholder="Filter by Email" value="<?= htmlspecialchars($filters['email'] ?? '') ?>">
                <select name="activity_type">
                    <option value="">All Activities</option>
                    <option value="LOGIN" <?= ($filters['activity_type'] ?? '') == 'LOGIN' ? 'selected' : '' ?>>Login</option>
                    <option value="LOGOUT" <?= ($filters['activity_type'] ?? '') == 'LOGOUT' ? 'selected' : '' ?>>Logout</option>
                    <option value="REGISTER" <?= ($filters['activity_type'] ?? '') == 'REGISTER' ? 'selected' : '' ?>>Register</option>
                     <option value="PROFILE_CREATE" <?= ($filters['activity_type'] ?? '') == 'PROFILE_CREATE' ? 'selected' : '' ?>>Profile create</option>
                </select>

                <input type="text" id="date_range" name="date_range" value="<?= htmlspecialchars($filters['date_range'] ?? '') ?>" placeholder="Select Date Range">

                <button type="submit" class="reset" name="reset_filters" value="1">Reset</button>
            </form>
        </div>
        
        <div id="activity-table-container">
            <?php include __DIR__ . '/partials/activity_logs_table.php'; ?>
        </div>

    </div>
    </section>
</main>
