            <table class="querystatus">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($queriesdetails)): ?>
                        <?php foreach ($queriesdetails as $i => $query): ?>
                        <tr>
                            <td><?= ($pagination['offset'] ?? 0) + $i + 1 ?></td>
                            <td><?= htmlspecialchars($query['subject']) ?></td>
                            <td><?= htmlspecialchars($query['message']) ?></td>
                            <td><?= date('d M Y', strtotime($query['created_at'])) ?></td>
                            <td>
                                <?php echo match ($query['status']) {
                                    0 => '<span class="pending">Pending</span>',
                                    1 => '<span class="reviewed">Reviewed</span>',
                                    2 => '<span class="resolved">Resolved</span>',
                                    default => '<span class="badge bg-secondary">Unknown</span>'
                                };
                                ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align:center;">No queries found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            
            <?php include __DIR__ . '/../../layouts/pagination.php'; ?>
