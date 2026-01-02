
<head>
    
</head>
<main>
    <div class="activity-logs-container">
        <h2 class="mb-4">Activity Logs</h2>
        
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
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
                                <td><?= htmlspecialchars($log['email'] ?? 'N/A') ?> (ID: <?= $log['user_id'] ?>)</td>
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

        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php if ($currentPage > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $currentPage - 1 ?>">Previous</a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($currentPage < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $currentPage + 1 ?>">Next</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</main>
