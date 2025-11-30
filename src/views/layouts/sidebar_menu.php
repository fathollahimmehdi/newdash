<nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">--- PERSONAL</li>
                        <?php foreach($this->sidebarMenu as $menu): ?>
                        <li><a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="<?= $menu['icon'] ?>"></i><span class="hide-menu"><?= $menu['title'] ?></span>
        </a>
        <?php if(!empty($menu['children'])): ?>
        <ul aria-expanded="false" class="collapse">
            <?php foreach($menu['children'] as $child): ?>
            <li><a href="<?= $child['link'] ?>"><?= $child['title'] ?></a></li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </li>
<?php endforeach; ?>
                        
                </nav>