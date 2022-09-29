<?php

get_header();
?>
    <div class="museum-header" style="background-image: url('<?= get_the_post_thumbnail_url() ?>')">
        <h1><?= the_title() ?></h1>
    </div>
    <div class="museum-body">
        <div class="museum-content">
            <article>
                <p>
                    <small class="date"><?= get_the_date('F j, Y', get_the_ID()) ?></small>
                </p>
                <?php the_content(); ?>
            </article>
        </div>
    </div>
<?php

get_footer();
