<section class="news">
    <div>
        <h2>Latest news</h2>
        <?php foreach (get_terms(['taxonomy' => 'category']) as $term): ?>
            <p>
                <a href="<?= get_category_link($term) ?>">- <?= $term->name ?></a>
            </p>
        <?php endforeach; ?>
    </div>
    <div class="section-content">
        <?php while (have_posts()) : the_post(); ?>
            <div class="section-item">
                <div class="section-item-img">
                    <img src="<?= get_the_post_thumbnail_url() ?>" alt="">
                </div>
                <div class="section-item-text">
                    <a href="<?= get_the_permalink() ?>" class="h4"><?= the_title() ?></a>
                    <div><?php the_excerpt() ?></div>
                    <small class="date"><?= the_date('F j, Y') ?></small>
                    <div class="link">
                        <a href="<?= get_the_permalink() ?>">Read more</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</section>