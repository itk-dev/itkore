var gulp = require('gulp');

// Plugins.
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');

var sassPath = './scss/**/*.scss';

/**
 * Process SCSS using libsass
 */
gulp.task('sass', function () {
  gulp.src(sassPath)
    .pipe(sass({
      outputStyle: 'nested'
    }).on('error', sass.logError))
    .pipe(gulp.dest('./css'));
});

// Tasks to compile sass.
gulp.task('default', ['watch']);
