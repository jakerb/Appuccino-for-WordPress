
/**
 * The Gulp file used to compile all /source files.
 *
 * @link       https://github.com/jakerb/Appuccino-for-WordPress
 * @since      1.0.0
 *
 * @package    Appuccino
 */

var gulp = require('gulp'),
    minifyCSS = require('gulp-minify-css'),
    concat = require('gulp-concat')
    uglify = require('gulp-uglify')
    prefix = require('gulp-autoprefixer')
    sass = require('gulp-sass')
    rename = require('gulp-rename')
    sassVars = require("gulp-sass-vars")
    gulpFilter = require('gulp-filter')
    clean = require('gulp-clean');


var appuccino_config = require('./config.js');


gulp.task('js', function(){

	var files = appuccino_config.project.javascript_dir.concat(appuccino_config.project.plugins_dir);
	return gulp.src(files)
	.pipe(concat(appuccino_config.project.javascript_output_file_min))
	.pipe(uglify())
	.on('error', function (err) { 
		console.error('Gulp JS Error');
		console.warn(err.toString()); 
	})
	.pipe(gulp.dest(appuccino_config.project.javascript_output_dir));

});

gulp.task('css', function(){

	return gulp.src(appuccino_config.project.scss_dir)
	.pipe(sassVars(appuccino_config.scss, { verbose: false }))
	.pipe(sass({
		includePaths: appuccino_config.scss_include
	}))
	.pipe(concat(appuccino_config.project.scss_output_file_min))
	.pipe(minifyCSS())
	.pipe(gulp.dest(appuccino_config.project.scss_output_dir))
});

gulp.task('watch', function() {

	console.info('\n* * * Appuccino * * * \n');
	console.info('> Add/Modify SCSS variables in config.js then restart Gulp otherwise add variables inline.\n');

	gulp.watch(appuccino_config.project.javascript_dir, ['js'])
	gulp.watch(appuccino_config.project.scss_dir, ['css'])
});

gulp.task('default', ['watch']);