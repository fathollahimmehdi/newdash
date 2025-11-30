<div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h4 class="text-themecolor"><?php echo htmlspecialchars($this->data['pageTitle']); ?></h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
    <?php foreach($this->data['breadcrumb'] as $crumb): ?>
        <?php if(!empty($crumb['link'])): ?>
            <li class="breadcrumb-item">
                <a href="<?= htmlspecialchars($crumb['link']) ?>"><?= htmlspecialchars($crumb['title']) ?></a>
            </li>
        <?php else: ?>
            <li class="breadcrumb-item active" aria-current="page">
                <?= htmlspecialchars($crumb['title']) ?>
            </li>
        <?php endif; ?>
    <?php endforeach; ?>
</ol>

                            <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</button>
                        </div>
                    </div>
                </div>