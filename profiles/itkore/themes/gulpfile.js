#!/usr/bin/env node

// Plugin to handle parameters.
var argv = require('yargs')
  .alias('s', 'sync')
  .alias('t', 'theme')
  .default('sync', false)
  .default('theme', ['base'])
  .argv;

// Gulp basic.
var gulp = require('gulp');
var help = require('gulp-help');
var gulpif = require('gulp-if');

// Gulp plugins.
//var jshint = require('gulp-jshint');
//var stylish = require('jshint-stylish');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var stylelint = require('gulp-stylelint');
var postcss = require('gulp-postcss');
var autoprefixer = require('autoprefixer');

/**
 * ------- Configuration -------
 */
var configuration = {
  // Base theme.
  'base': {
    "js": {
      "paths": ['./itkore_base/js/*.js', '!./itkore_base/js/*.min.*'],
      "dest": './itkore_base/js'
    },
    "sass": {
      "paths": './itkore_base/scss/**/*.scss',
      'dest': './itkore_base/css'
    },
    "twig": {
      "paths": './itkore_base/templates/**/*.twig'
    }
  },
  // Blue sub-theme.
  'blue' : {
    "sass": {
      "paths": './itkore_blue/scss/**/*.scss',
      'dest': './itkore_blue/css'
    },
    "twig": {
      "paths": './itkore_blue/templates/**/*.twig'
    },
  },
  // Orange sub-theme.
  'orange' : {
    "sassPath": {
      "paths": './itkore_orange/scss/**/*.scss',
      'dest': './itkore_orange/css'
    },
    "twig": {
      "paths": './itkore_orange/templates/**/*.twig'
    }
  }
}

/**
 * ------- TASK's -------
 */

function sassTask(theme, config) {
  var taskName = 'sass_' + theme;

  // Process SCSS.
  gulp.task(taskName, function () {
    // Configure auto-prefixer.
    var processors = [
      autoprefixer({browsers: ['last 2 versions']})
    ];

    var pipe = gulp.src(config.sass.paths)
      .pipe(sourcemaps.init())
      .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
      .pipe(postcss(processors))
      .pipe(sourcemaps.write())
      .pipe(gulp.dest(config.sass.dest));

    // It's unknow why gulp-if don't work with browers-sync, so this if
    // statement is as litte hack.
    if (argv.sync) {
      pipe.pipe(browserSync.stream());
    }
  });

  return taskName;
}

 /**
  * Dynamically setup tasks base on the selected theme.
  *
  * @param themes
  *   Theme name as an string array. Used as index in the
  *   configuration pobject.
  */
function setupTasks(themes) {
  // Start browser sync.
  var browserSync;
  if (argv.sync) {
    browserSync = require('browser-sync').create();
    browserSync.init({
      proxy: "itkore.vm",
      host: "itkore.vm"
    });
  }

  var sassTaskNames = [];

  // Loop over the selected themes.
  for (var i in themes) {
    var theme = themes[i];
    var config = configuration[theme];

    // SASS tasks.
    sassTaskNames.push(sassTask(theme, config));
  }

  // Define sass task.
  gulp.task('sass', sassTaskNames);

}

/**
 * ------- Run task's -------
 */
setupTasks(argv.theme);


