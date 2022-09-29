<?php

get_header();
?>
    <header class="home">
        <div class="header-block">
            <h1><?php echo implode('<br>', explode(' ', esc_html( get_bloginfo( 'name' ) ))); ?></h1>
            <p><?php bloginfo( 'description' ); ?></p>
        </div>
        <div class="imgs">
            <div class="img img-1">
                <img src="<?= get_stylesheet_directory_uri() ?>/images/kzn-1.jpg" alt="">
            </div>
            <div class="img img-2">
                <img src="<?= get_stylesheet_directory_uri() ?>/images/kzn-2.jpg" alt="">
            </div>
            <div class="img img-3">
                <img src="<?= get_stylesheet_directory_uri() ?>/images/kzn-3.jpg" alt="">
            </div>
        </div>
    </header>
    <section class="museums">
        <h2>All museums</h2>
        <div class="section-content">
            <?php foreach (get_posts(['post_type' => 'page']) as $post) : ?>
                <div class="section-item">
                    <div class="section-item-text">
                        <a href="<?= get_permalink($post) ?>" class="h4"><?= $post->post_title ?></a>
                        <p><?= get_the_excerpt($post) ?></p>
                        <small class="date"><?= get_the_date('F j, Y', $post) ?></small>
                        <div class="link">
                            <a href="<?= get_permalink($post) ?>">Read more</a>
                        </div>
                    </div>
                    <div class="section-item-img">
                        <img src="<?= get_the_post_thumbnail_url($post) ?>" alt="">
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php get_template_part('news_section') ?>
    <section class="contact">
        <h2>Contact us</h2>
        <div class="contact-content">
            <form action="https://formspree.io/admin@example.com" method="POST">
                <p>
                    <input type="text" name="name" id="name">
                    <label for="name">Name</label>
                </p>
                <p>
                    <input type="email" name="email" id="email">
                    <label for="email">Email</label>
                </p>
                <p>
                    <textarea name="content" id="content" rows="2"></textarea>
                    <label for="email">Content</label>
                </p>
                <button>Send</button>
            </form>
            <div class="img">
                <img src="<?= get_stylesheet_directory_uri() ?>/images/bg.jpg" alt="">
            </div>
        </div>
    </section>
<?php

get_footer();
