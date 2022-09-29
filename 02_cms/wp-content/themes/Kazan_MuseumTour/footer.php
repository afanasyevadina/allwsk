</div>
<footer id="footer">
<div id="copyright">
    Copyright © <?= date('Y') ?> - All rights reserved
</div>
    <div class="links">
        <?php foreach(array_filter(get_option('footer_links'), function($item) {return $item['enabled'];}) as $key => $item): ?>
            <a href="<?= $item['url'] ?>"><?= ucfirst($key) ?></a>
        <?php endforeach; ?>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>