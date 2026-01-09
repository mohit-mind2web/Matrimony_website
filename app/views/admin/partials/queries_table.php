        <table class="usermanage">
             <tr>
            <th>S.No</th>
            <th>Fullname</th>
            <th>Email</th>
            <th>Subject</th>
            <th>Message</th>
            <th>Status</th>
            <th>Received At</th>
            <th>Action</th>
        </tr>

            <?php if (!empty($queriesdetails)): ?>
                <?php foreach ($queriesdetails as $i=> $query){?>
            <tr>
                <td><?= ($pagination['offset'] ?? 0) + $i + 1 ?></td>
                <td>
                    <?= htmlspecialchars($query['fullname']) ?>
                </td>
                <td><?= htmlspecialchars($query['email']) ?></td>
                <td><?= htmlspecialchars($query['subject']) ?></td>
                 <td><?= $query['message'] ?></td>

                <td>
                    <?php echo match ($query['status']) {
                            0 => '<span class="badge bg-warning">Pending</span>',
                            1 => '<span class="badge bg-info">Reviewed</span>',
                            2 => '<span class="badge bg-danger">Resolved</span>',
                        };
                    ?>
                </td>
                <td><?=($query['created_at']) ?></td>
                <td>
                    <form method="POST" action="/admin/queries/status">
                        <input type="hidden" name="query_id" value="<?= $query['id'] ?>">
                        <select name="status" class="form-select form-select-sm ajax-status-select">
                            <option value="0" <?= $query['status']==0?'selected':'' ?>>Pending</option>
                            <option value="1" <?= $query['status']==1?'selected':'' ?>>Reviewed</option>
                            <option value="2" <?= $query['status']==2?'selected':'' ?>>Resolved</option>
                        </select>
                    </form>
                </td>
            </tr>
                  
            <?php } else: ?>
                <tr>
                    <td colspan="8" style="text-align:center;">No Record Found!</td>
                </tr>
            <?php endif; ?>
           
        </table>
        <?php include __DIR__ . '/../../layouts/pagination.php'; ?>
