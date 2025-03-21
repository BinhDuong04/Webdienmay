<div class="container-menu">
    <ul>
        <?php if (!empty($categories)) : ?>
            <?php foreach ($categories as $category) : ?>
                <li><a href="#"><?= esc($category['category_name']); ?></a></li>
            <?php endforeach; ?>
        <?php else : ?>
            <li>Không có danh mục nào</li>
        <?php endif; ?>
    </ul>
</div>
