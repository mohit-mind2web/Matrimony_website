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
                        <td><?= ($pagination['offset'] ?? 0) + $i + 1 ?></td>
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
                                <select name="status" class="form-select form-select-sm ajax-status-select">
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
        <?php include __DIR__ . '/../../layouts/pagination.php'; ?>
