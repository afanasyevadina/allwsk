<?php

get_header();
?>
    <header class="category">
        <h1><?php single_term_title(); ?></h1>
    </header>
<?php
get_template_part('news_section');
get_footer();
