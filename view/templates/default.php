<?php

/**
 * Template view for a single page.
 *
 * This file is converted to a .html page and imported into the app.
 * To trust the HTML then use the trust filter: post.post_content | trust
 *
 * @link       https://myappuccino.com/
 * @since      1.0.0
 *
 * @package    Appuccino
 * @subpackage Appuccino/admin/partials
 */
?>
<!-- Include the header file -->
<div ng-include="app.app.base_url + 'partials/header.html'"></div>
<!-- Include the header file -->

<div class="page-body uk-padding page-has-header page-has-footer" data-template="default">
	<div class="uk-card uk-card-default uk-card-body" ng-bind-html="post.post_content"></div>
</div>

<!-- Include the footer file -->
<div ng-include="app.app.base_url + 'partials/footer.html'"></div>
<!-- Include the footer file -->
