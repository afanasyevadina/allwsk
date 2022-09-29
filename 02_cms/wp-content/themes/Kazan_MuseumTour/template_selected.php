<?php
/**
 * Template Name: Selected museums
 */
$posts = get_posts(['posts_per_page' => 6, 'category_name' => get_post_field('post_name')]);
get_header();
?>
    <div class="museum-body selected" style="background-image: url('<?= get_the_post_thumbnail_url() ?>')">
        <div class="museum-content">
            <h1><?= the_title() ?></h1>
            <section class="info">
                <h2>Info</h2>
                <article><?php the_content(); ?></article>
            </section>
            <section class="news">
                <h2>Latest news</h2>
                <?php if(count($posts)) : ?>
                    <div class="section-content">
                        <?php foreach ($posts as $post) : ?>
                            <div class="section-item">
                                <div class="section-item-img">
                                    <img src="<?= get_the_post_thumbnail_url($post) ?>" alt="">
                                </div>
                                <div class="section-item-text">
                                    <a href="<?= get_permalink($post) ?>" class="h4"><?= $post->post_title ?></a>
                                    <p><?= get_the_excerpt($post) ?></p>
                                    <small class="date"><?= get_the_date('F j, Y', $post) ?></small>
                                    <div class="link">
                                        <a href="<?= get_permalink($post) ?>">Read more</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="date">No news posts found.</div>
                <?php endif; ?>
            </section>
        </div>
    </div>
<?php

get_footer();