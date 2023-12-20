
/**
 * The configuration file used in Gulp.
 *
 * @link       https://github.com/jakerb/Appuccino-for-WordPress
 * @since      1.0.0
 *
 * @package    Appuccino
 */

var config = {};

config.scss_include = [];

config.scss = {
	primary: '#89c773',
	secondary: '#facc2d'
};

config.project = {
	javascript_dir: ['./js/*.js'],
	javascript_output_dir: '../resources/js/',
	javascript_output_file: 'script.js',
	javascript_output_file_min: 'script.min.js',

	scss_dir: ['./scss/*.scss'],
	scss_output_dir: '../resources/css/',
	scss_output_file: 'stylesheet.css',
	scss_output_file_min: 'stylesheet.min.css',

	plugins_dir: './plugins/*.js'
};

module.exports = config;