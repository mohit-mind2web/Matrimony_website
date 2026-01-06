<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/assets/css/admin/usermanage.css" />
    <link rel="stylesheet" href="/assets/css/pagination.css" />
    <script src="/assets/js/filters.js"></script>

</head>
<main>
    <section>
        <h2>User Management</h2><br>
        <div class="filter">
            <form method="post" action="/admin/usermanage" id="filterform">
                <input type="text" name="name" placeholder="Enter name"
                value="<?= htmlspecialchars($filters['name'] ?? '') ?>" onkeyup="autoSubmit('filterform')">
                <select name="profilestatus" onchange="this.form.submit()">
                    <option value="">All Profiles</option>
                    <option value="1" <?= ($filters['profilestatus'] ?? '') === '1' ? 'selected' : '' ?>>Completed Profiles</option>
                    <option value="0" <?= ($filters['profilestatus'] ?? '') === '0' ? 'selected' : '' ?>>Incomplete Profiles</option>
                </select>

                </select>
                <select name="userstatus" onchange="this.form.submit()">
                    <option value="">All Users</option>
                    <option value="1" <?= ($filters['userstatus'] ?? '') === '1' ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?= ($filters['userstatus'] ?? '') === '0' ? 'selected' : '' ?>>Blocked</option>
                </select>
                 <button type="submit" class="reset" name="reset_filters" value=1>reset</button>
                 <button type="submit" class="export" name="export" value="1">Export CSV</button>
            </form>
        </div>
        <table class="usermanage">
            <tr>
                <th>User Id</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Profile</th>
                <th>Status</th>
                <th>Joined At</th>
                <th>Action</th>
            </tr>

            <?php if (!empty($userdetails)): ?>
                <?php foreach ($userdetails as $user) { ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
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
                            <form method="post" action="/admin/user/action">
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
        <?php include __DIR__ . '/../layouts/pagination.php'; ?>
    </section>
</main>