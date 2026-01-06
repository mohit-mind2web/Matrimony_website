
<head>
    <link rel="stylesheet" href="/assets/css/admin/usermanage.css" />
</head>
<main>
    <section>
    <div class="activity-logs-container">
        <h2 class="mb-4">Activity Logs</h2>
        
        <div class="table-responsive">
            <table class="usermanage">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>User_Id</th>
                        <th>User (Email)</th>
                        <th>Role</th>
                        <th>Activity</th>
                        <th>Description</th>
                        <th>IP Address</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($logs)): ?>
                        <tr>
                            <td colspan="7" class="text-center">No activity logs found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($logs as $log): ?>
                            <tr>
                                <td><?= htmlspecialchars($log['id']) ?></td>
                                <td><?= $log['user_id'] ?></td>
                                <td><?= htmlspecialchars($log['email'] ?? 'N/A') ?> </td>
                                <td><?= htmlspecialchars($log['user_role'] ?? 'Unknown') ?></td>
                                <td>
                                    <span class="badge bg-<?= $log['activity_type'] == 'LOGIN' ? 'success' : ($log['activity_type'] == 'LOGOUT' ? 'secondary' : 'primary') ?>">
                                        <?= htmlspecialchars($log['activity_type']) ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($log['description']) ?></td>
                                <td><?= htmlspecialchars($log['ip_address']) ?></td>
                                <td><?= date('d M Y H:i', strtotime($log['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            
        </div>
        <?php include __DIR__ . '/../layouts/pagination.php'; ?>

    </div>
    </section>
</main>
