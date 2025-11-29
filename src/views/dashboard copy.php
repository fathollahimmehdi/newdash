<?php include 'src/views/layouts/header.php'; ?>

<div class="row g-4">
    <div class="col-md-3">
        <div class="card card-modern text-white bg-primary">
            <div class="card-body">
                <h6 class="card-title">Users</h6>
                <h3 class="card-text"><?= $data['users_count'] ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-modern text-white bg-success">
            <div class="card-body">
                <h6 class="card-title">Sales</h6>
                <h3 class="card-text">$<?= $data['sales'] ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-modern text-white bg-warning">
            <div class="card-body">
                <h6 class="card-title">Revenue</h6>
                <h3 class="card-text">$8,200</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-modern text-white bg-danger">
            <div class="card-body">
                <h6 class="card-title">Alerts</h6>
                <h3 class="card-text">5</h3>
            </div>
        </div>
    </div>
</div>

<?php include 'src/views/layouts/footer.php'; ?>
