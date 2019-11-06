var gulp         = require("gulp"),
	sass         = require("gulp-sass"),
	postcss      = require("gulp-postcss"),
	autoprefixer = require("autoprefixer"),
	cssnano      = require("cssnano"),
	sourcemaps   = require("gulp-sourcemaps"),
	rename       = require( "gulp-rename" ),
	concat       = require('gulp-concat'),
	notify       = require('gulp-notify'),
	plumber      = require( "gulp-plumber" ),
	babel        = require('gulp-babel'),
	uglify       = require( "gulp-uglify" );


var paths = {
	sass: {
		src: "./**/*.scss",
		dest: "./"
	},
	js: {
		src: "./**/!(*.min)*.js",
		dest: "./"
	},
};

function sass_to_css() {
	return gulp
	.src(paths.sass.src)
	 // Initialize sourcemaps before compilation starts
	 .pipe(sourcemaps.init())
	 .pipe(sass())
	 .on("error", sass.logError)
	 // Use postcss with autoprefixer and compress the compiled file using cssnano
	 .pipe(postcss([autoprefixer(), cssnano()]))
	 // Now add/write the sourcemaps
	 .pipe(sourcemaps.write())
	 .pipe(gulp.dest(paths.sass.dest))

}


function js_minify() {
	return gulp
	.src(paths.js.src)
	 .pipe(plumber({
		errorHandler: notify.onError('Error: <%= error.message %>')
	}))
	 .pipe(babel({
		presets: [
			['@babel/env', {
				modules: false
			}]
		]
	}))
	 .pipe(uglify())
	 .pipe(rename({ suffix: '.min' }))
	 .pipe(gulp.dest(paths.js.dest))

}




exports.sass_to_css = sass_to_css;
exports.js_minify = js_minify;



gulp.task( 'sass_to_css', function(){
	gulp.watch(paths.sass.src, sass_to_css);
} );

gulp.task( 'js_minify', function(){
	gulp.watch(paths.js.src, js_minify);
} );

gulp.task('default', gulp.parallel(
	'js_minify',
	'sass_to_css'
	)
);