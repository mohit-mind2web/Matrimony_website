
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/assets/css/admin/dashboard.css" />
    
</head>
    <main>
        <section>
            <div class="container">
                <div class="card" onclick="totaluser()">
                    <h3>Total Users</h3>
                    <p><?= $totalcounts['totalusers'] ?></p>
                </div>
                <div class="card">
                    <h3>Total Profiles Created</h3>
                    <p><?= $totalprofiles['totalprofiles'] ?></p>
                </div>
                 <div class="card">
                    <h3>Profiles Incomplete</h3>
                    <p><?= $totalcounts['profileincomplete'] ?></p>
                </div>
                <div class="card">
                    <h3>Total Male Users</h3>
                    <p><?= $totalprofiles['maleprofiles'] ?></p>
                </div>
                <div class="card">
                    <h3>Total Female Users</h3>
                    <p><?= $totalprofiles['femaleprofiles'] ?></p>
                </div>
            </div>

        <div class="recent-queries">
            <div class="recentquery">
                <h3>Recent Contact Queries</h3>
                <a href="/admin/managequeries">Go to queries</a>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Query-ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($recentQueries)): ?>
                        <?php foreach ($recentQueries as $query): ?>
                        <tr>
                            <td class="query-id"><?= $query['id'] ?></td>
                            <td><?= htmlspecialchars($query['fullname']) ?></td>
                            <td><?= htmlspecialchars($query['email']) ?></td>
                            <td><?= htmlspecialchars($query['subject']) ?></td>
                            <td><?= date('d M Y', strtotime($query['created_at'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="no-queries">No recent queries found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
    </main>