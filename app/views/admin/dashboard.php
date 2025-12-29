
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/assets/css/admin/dashboard.css" />
    
</head>
    <main>
        <section>
            <div class="container">
                <div class="card">
                    <h3>Total Users</h3>
                    <p><?= $totalcounts['totalusers'] ?></p>
                </div>
                <div class="card">
                    <h3>Total Profiles Created</h3>
                    <p><?= $totalprofiles['totalprofiles'] ?></p>
                </div>
                 <div class="card">
                    <h3>Profiles InCompleted</h3>
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

        </section>
    </main>
 