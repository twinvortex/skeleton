'use strict';

const { Transform } = require('node:stream');
const gulp = require('gulp');
const dartSass = require('sass');
const gulpSass = require('gulp-sass')(dartSass);
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');
const { minify } = require('terser');

function minifyJs() {
	return new Transform({
		objectMode: true,
		async transform(file, _encoding, callback) {
			if (file.isNull() || !file.isBuffer()) {
				callback(null, file);
				return;
			}
			try {
				const result = await minify(file.contents.toString('utf8'));
				if (result.code !== undefined) {
					file.contents = Buffer.from(result.code, 'utf8');
				}
				callback(null, file);
			} catch (err) {
				callback(err);
			}
		},
	});
}

function css() {
	return gulp.src('assets/sass/**/*.scss')
		.pipe(gulpSass().on('error', gulpSass.logError))
		.pipe(postcss([autoprefixer(), cssnano()]))
		.pipe(gulp.dest('public/assets/css'));
}

function compress() {
	return gulp.src('assets/js/**/*.js')
		.pipe(minifyJs())
		.pipe(gulp.dest('public/assets/js'));
}

function images() {
	return gulp.src('assets/images/**/*.{jpg,png,gif}', { encoding: false })
		.pipe(gulp.dest('public/assets/images'));
}

function watchFiles() {
	gulp.watch('assets/sass/**/*.scss', css);
	gulp.watch('assets/js/**/*.js', compress);
	gulp.watch('assets/images/**/*.{jpg,png,gif}', images);
}

const build = gulp.parallel(css, compress, images);

exports.css = css;
exports.compress = compress;
exports.images = images;
exports.watch = watchFiles;
exports.build = build;
exports.default = watchFiles;
