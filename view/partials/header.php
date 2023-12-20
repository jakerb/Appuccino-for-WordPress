<?php

/**
 * Partial view for a single page.
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/jakerb/Appuccino-for-WordPress
 * @since      1.0.0
 *
 * @package    Appuccino
 * @subpackage Appuccino/admin/partials
 */
?>
<div id="offcanvas-push" uk-offcanvas="mode: slide; overlay: true; flip: true" >
    <div class="uk-offcanvas-bar">
        <div class=""><a class="uk-close uk-offcanvas-close"><span uk-icon="close"></span></a></div>
        <ul class="uk-nav uk-nav-default">
            <li class="uk-nav-header">Title</li>
            <li class="uk-nav-divider"></li>
            <li>
            	<a href="#"><span class=""></span> Link</a>
            </li>
        </ul>

    </div>
</div>

<nav class="uk-navbar-container uk-nav-primary uk-position-fixed uk-position-top-left uk-width-1-1 uk-position-z-index" uk-navbar>
	<div class="uk-navbar-left">
		<ul class="uk-navbar-nav">
            <li><a href="#/" uk-icon="home"></a></li>
		</ul>
	</div>

    <div class="uk-navbar-center">
        <ul class="uk-navbar-nav">
            <li>
                <a href="#/">
                	My App
                </a>
            </li>
        </ul>
    </div>
    <div class="uk-navbar-right">
		<ul class="uk-navbar-nav">
			<li><a href uk-toggle="target: #offcanvas-push" uk-icon="menu"></a></li>
		</ul>
	</div>
</nav>