
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/assets/css/admin/usermanage.css" />
    
</head>
    <main>
        <section>
        <h2>User Management</h2>
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
                <?php foreach ($userdetails as $user){?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['fullname']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= $user['profile_complete'] ?
                        '<span style="color:green">Completed</span>' :
                       '<span style="color:red">Incompleted</span>'?></td>
                        <td><?php if($user['status']==1):?>
                            <span class="green">Active</span>
                            <?php else:?>
                            <span class="red">Blocked</span>
                            <?php endif;?>
                        </td>
                        <td><?= date('d M Y',strtotime($user['created_at'])) ?></td>
                        <td><form method="post" action="/admin/user/action">
                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                            <button type="submit"><?= $user['status']?'block':'Unblock' ?></button>
                        </form></td>
                    </tr>
                  
            <?php } else: ?>
                <tr>
                    <td colspan="6" style="text-align:center;">No Record Found!</td>
                </tr>
            <?php endif; ?>
           
        </table>
        <?php include __DIR__ . '/../layouts/pagination.php'; ?>
        </section>
    </main>