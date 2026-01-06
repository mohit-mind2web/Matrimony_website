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
        <h3>Report Management</h3><br>
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['success'];
                unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
        <div class="filter">
            <form method="post" id="reportFilterForm" action="/admin/managereports">
                <input type="text" id="date_range" name="date_range" value="<?= $filters['date_range'] ?? '' ?>" placeholder="Select Date Range">
                <select name="status" onchange="this.form.submit()">
                    <option value="">All Status</option>
                    <option value="0" <?= ($filters['status'] ?? '') === '0' ? 'selected' : '' ?>>Pending</option>
                    <option value="1" <?= ($filters['status'] ?? '') === '1' ? 'selected' : '' ?>>Reviewed</option>
                    <option value="2" <?= ($filters['status'] ?? '') === '2' ? 'selected' : '' ?>>Resolved</option>
                </select>
                <button type="submit" class="reset" name="reset_filters" value=1>reset</button>
            </form>
        </div>
        
        <table class="usermanage">
            <tr>
                <th>S.No</th>
                <th>Reporter</th>
                <th>Reported User</th>
                <th>Reason</th>
                <th>Description</th>
                <th>Status</th>
                <th>Reported At</th>
                <th>Action</th>
            </tr>

            <?php if (!empty($reportdetails)): ?>
                <?php foreach ($reportdetails as $i => $report) { ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($report['reporter_name']) ?></td>
                        <td>
                            <?= htmlspecialchars($report['reported_name']) ?>
                        </td>
                        <td><?= htmlspecialchars($report['reason']) ?></td>
                        <td><?= htmlspecialchars($report['description']) ?: '—' ?></td>

                        <td>
                            <?php echo match ($report['status']) {
                                0 => '<span class="badge bg-warning">Pending</span>',
                                1 => '<span class="badge bg-info">Reviewed</span>',
                                2 => '<span class="badge bg-danger">Action Taken</span>',
                            };
                            ?>
                        </td>
                        <td><?= ($report['created_at']) ?></td>
                        <td>
                            <form method="POST" action="/admin/reports/status">
                                <input type="hidden" name="report_id" value="<?= $report['id'] ?>">
                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="0" <?= $report['status'] == 0 ? 'selected' : '' ?>>Pending</option>
                                    <option value="1" <?= $report['status'] == 1 ? 'selected' : '' ?>>Reviewed</option>
                                    <option value="2" <?= $report['status'] == 2 ? 'selected' : '' ?>>Action Taken</option>
                                </select>
                            </form>
                        </td>
                    </tr>

                <?php }
            else: ?>
                <tr>
                    <td colspan="8" style="text-align:center;">No Record Found!</td>
                </tr>
            <?php endif; ?>

        </table>
        <?php include __DIR__ . '/../layouts/pagination.php'; ?>
    </section>
</main>