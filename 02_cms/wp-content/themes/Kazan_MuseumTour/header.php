<!DOCTYPE html>
<html <?php language_attributes(); ?> class="html">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width" />
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<input type="checkbox" id="menu-checker" autocomplete="off">
<nav>
    <a href="<?= site_url() ?>" class="logo">K.</a>
    <?php wp_nav_menu(); ?>
    <label for="menu-checker" class="menu-toggler">
        <span></span><span></span><span></span>
    </label>
</nav>
<div id="container">