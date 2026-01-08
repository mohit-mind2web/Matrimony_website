        <table class="usermanage">
            <tr>
                <th>S.No</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Profile</th>
                <th>Status</th>
                <th>Joined At</th>
                <th>Action</th>
            </tr>

            <?php if (!empty($userdetails)): ?>
                <?php foreach ($userdetails as $key => $user) { ?>
                    <tr>
                        <td><?= ($pagination['offset'] ?? 0) + $key + 1 ?></td>
                        <td><?= htmlspecialchars($user['fullname']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= $user['profile_complete'] ?
                                '<span style="color:green">Completed</span>' :
                                '<span style="color:red">Incomplete</span>' ?></td>
                        <td><?php if ($user['status'] == 1): ?>
                                <span class="green">Active</span>
                            <?php else: ?>
                                <span class="red">Blocked</span>
                            <?php endif; ?>
                        </td>
                        <td><?= date('d M Y', strtotime($user['created_at'])) ?></td>
                        <td>
                            <form method="post" action="/admin/user/action" class="ajax-action-button-form">
                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                <button type="submit"><?= $user['status'] ? 'block' : 'Unblock' ?></button>
                            </form>
                        </td>
                    </tr>

                <?php }
            else: ?>
                <tr>
                    <td colspan="7" style="text-align:center;">No Record Found!</td>
                </tr>
            <?php endif; ?>

        </table>
        <?php include __DIR__ . '/../../layouts/pagination.php'; ?>
