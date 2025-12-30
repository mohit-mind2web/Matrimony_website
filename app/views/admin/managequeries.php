
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/assets/css/admin/usermanage.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="/assets/js/filters.js"></script>
    
</head>
    <main>
        <section>
        <h3>Manage Queries</h3><br>
         <?php if (!empty($_SESSION['message'])): ?>
    <div class="alert alert-success">
        <?= $_SESSION['message']; unset($_SESSION['message']); ?>
    </div>
<?php endif; ?>
        <div class="filter">
    <form method="post" id="queryFilterForm" action="/admin/managequeries">
        <input type="text" name="name" placeholder="User name or email"
            value="<?= htmlspecialchars($filters['name'] ?? '') ?>" 
            onkeyup="autoSubmit('queryFilterForm')">
        <input type="text" id="date_range" name="date_range" value="<?= $filters['date_range'] ?? '' ?>" placeholder="Select Date Range">
         <select name="status" onchange="this.form.submit()">
            <option value="">All Status</option>
            <option value="0" <?= ($filters['status'] ?? '')==='0'?'selected':'' ?>>Pending</option>
            <option value="1" <?= ($filters['status'] ?? '')==='1'?'selected':'' ?>>Reviewed</option>
            <option value="2" <?= ($filters['status'] ?? '')==='2'?'selected':'' ?>>Resolved</option>
        </select>
        <button type="submit" class="reset" name="reset_filters" value=1>reset</button>
    </form>
</div>
        <table class="usermanage">
             <tr>
            <th>S.No</th>
            <th>User_id</th>
            <th>Fullname</th>
            <th>Email</th>
            <th>Subject</th>
            <th>Status</th>
            <th>Received At</th>
            <th>Action</th>
        </tr>

            <?php if (!empty($queriesdetails)): ?>
                <?php foreach ($queriesdetails as $i=> $query){?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= htmlspecialchars($query['user_id']) ?></td>
                <td>
                    <?= htmlspecialchars($query['fullname']) ?>
                </td>
                <td><?= htmlspecialchars($query['email']) ?></td>
                <td><?= htmlspecialchars($query['subject']) ?></td>

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
                        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
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
        <?php include __DIR__ . '/../layouts/pagination.php'; ?>
        </section>
    </main>