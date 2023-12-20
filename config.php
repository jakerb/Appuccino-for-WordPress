<?php

/**
 * The configuration file for Appuccino.
 */

/**
 * @info Allow Access to the API from a device.
 */
header("Access-Control-Allow-Origin: *");

/**
 * @name APPUCCINO_PLUGIN_BASE_PATH (string)
 * @info Path to the base of the plugin folder.
 */
define('APPUCCINO_PLUGIN_BASE_PATH', dirname(__FILE__));

/**
 * @name APPUCCINO_IMAGE_MAX_SIZE (int) | default 1024
 * @info Maximum file size (kb) that should be base64 encoded. 0 = ff.
 * 		 If this is set, images that have been encoded will be available when the device is offline,
 * 		 be cautious setting this as large files will slow down the app drastically.
 */
define('APPUCCINO_IMAGE_MAX_SIZE', 1024);

/**
 * @name APPUCCINO_ENCODE_IMAGES (boolean)
 * @info Enable image encoding site-wide.
 */
define('APPUCCINO_ENCODE_IMAGES', true);

/**
 * @name APPUCCINO_V2_CORS_HEADERS (boolean)
 * @info Set custom CORS configuration to work with Appuccino V2 build.
 * @note This was implemented as iOS now enforces strict CORS policies.
 		 Enabling this will allow both V1.x and V2 apps to work.
 */
define('APPUCCINO_V2_CORS_HEADERS', true);

/**
 * @name APPUCCINO_ENCODE_MIME_TYPES (string)
 * @info The list of file types to encode base64.
 * @note Separate the file types with a vertical pipe.
 */
define('APPUCCINO_ENCODE_FILE_TYPES', 'jpg|jpeg|png|bmp');

/**
 * @name APPUCCINO_HEADER_FILE_TYPES (string)
 * @info The list of granted filetypes to be served with a MIME type.
 * @note Separate the file types with a vertical pipe. 
 * @warn BE EXTREMELY CAUTIOUS ADDING TYPES AS ALLOWING A FILE TO BE
 * 	 	 EXECUTED ON THE SERVER CAN CAUSE SERIOUS SECURITY ISSUES.
 */
define('APPUCCINO_HEADER_FILE_TYPES', 'js|css');

/**
 * @name APPUCCINO_POST_FILE (string)
 * @info The posts file name used within the manifest.
 * @note Do NOT change this if you don't know what you're doing.
 */
define('APPUCCINO_POST_FILE', 'post.json');

/**
 * @name APPUCCINO_JS_RESOURCE_DIR (string)
 * @info The directory relative to the project where all JS files to be included in the project manifest file.
 * @note Always include trailing slash at end of path.
 */
define('APPUCCINO_JS_RESOURCE_DIR', 'view/resources/js/');

/**
 * @name APPUCCINO_CSS_RESOURCE_DIR (string)
 * @info The directory relative to the project where all CSS files to be included in the project manifest file.
 * @note Always include trailing slash at end of path.
 */
define('APPUCCINO_CSS_RESOURCE_DIR', 'view/resources/css/');

/**
 * @name APPUCCINO_TEMPLATE_RESOURCE_DIR (string)
 * @info The directory relative to the project where all template files to be included in the project manifest file.
 * @note Always include trailing slash at end of path.
 */
define('APPUCCINO_TEMPLATE_RESOURCE_DIR', 'view/templates/');

/**
 * @name APPUCCINO_PARTIALS_RESOURCE_DIR (string)
 * @info The directory relative to the project where all template files to be included in the project manifest file.
 * @note Always include trailing slash at end of path.
 */
define('APPUCCINO_PARTIALS_RESOURCE_DIR', 'view/partials/');
