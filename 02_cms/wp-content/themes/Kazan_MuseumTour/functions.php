<?php

add_action('login_head', function () {
    ?>
    <style>
        h1 {
            display: none;
        }
        body {
            background-image: url("<?= get_stylesheet_directory_uri() ?>/images/login.jpg");
            background-size: cover;
        }
    </style>
    <?php
});

add_action('init', function () {
    $post = get_post_type_object('post');
    foreach ($post->labels as $key => $label) {
        $label = str_replace('post', 'news post', $label);
        $label = str_replace('Post', 'News post', $label);
        $post->labels->{$key} = $label;
    }
    $page = get_post_type_object('page');
    foreach ($page->labels as $key => $label) {
        $label = str_replace('Page', 'Museum', $label);
        $label = str_replace('page', 'museum', $label);
        $page->labels->{$key} = $label;
    }
});

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('k-script', get_stylesheet_directory_uri() . '/js/script.js', [], '1.0', true);
});

add_action('init', function () {
    add_option('footer_links', [
        'facebook' => [
            'url' => '',
            'enabled' => true,
        ],
        'twitter' => [
            'url' => '',
            'enabled' => true,
        ],
        'instagram' => [
            'url' => '',
            'enabled' => true,
        ],
    ]);
});

add_action('admin_menu', function () {
    add_menu_page('Footer links', 'Footer links', 'manage_options', 'footer_links', function () {
        ?>
        <h1>Footer links</h1>
        <form action="<?= admin_url('admin-post.php') ?>" method="POST">
            <input type="hidden" name="action" value="footer_links">
            <table class="widefat">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>URL</th>
                    <th>Enabled</th>
                </tr>
                </thead>
               <tbody>
               <?php foreach (get_option('footer_links') ?? [] as $key => $item): ?>
                   <tr>
                       <td><?= ucfirst($key) ?></td>
                       <td>
                           <input type="text" name="footer_links[<?= $key ?>][url]" value="<?= $item['url'] ?>">
                       </td>
                       <td>
                           <input type="hidden" name="footer_links[<?= $key ?>][enabled]" value="">
                           <input type="checkbox" name="footer_links[<?= $key ?>][enabled]" value="1" <?= $item['enabled'] ? 'checked' : '' ?>>
                       </td>
                   </tr>
               <?php endforeach; ?>
               </tbody>
            </table>
            <br>
            <button class="button-primary">Save</button>
        </form>
        <?php
    });
});

add_action('admin_post_footer_links', function () {
    update_option('footer_links', $_POST['footer_links']);
    wp_redirect(wp_get_referer());
});

add_filter('site_url', function ($url) {
    return preg_replace("/(wp-admin)/", WP_ADMIN_DIR, $url, 1);
}, 10, 3);