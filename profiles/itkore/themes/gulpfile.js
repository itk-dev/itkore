#!/usr/bin/env node

// Plugin to handle parameters.
var argv = require('yargs')
  .alias('s', 'sync')
  .alias('t', 'theme')
  .alias('d', 'domain')
  .default('sync', false)
  .default('theme', ['base'])
  .default('domain', 'itkore.vm')
  .argv;

// Gulp basic.
var gulp = require('gulp');
var help = require('gulp-help');
var gulpif = require('gulp-if');

// Gulp plugins.
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var stylelint = require('gulp-stylelint');
var postcss = require('gulp-postcss');
var autoprefixer = require('autoprefixer');

// Browser-sync needs to be a globe variable.
var browserSync;

/**
 * Configuration object.
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
 * Setup task for sass compilation.
 *
 * @param theme
 *    Name of the theme to setup the task.
 * @param config
 *    Selected theme configuration object.
 *
 * @return string
 *    The name of the new task.
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
 * Setup stylelint tasks.
 *
 * Note: Because stylelint task is async it returns it's gulp process.
 *
 * @param theme
 *    Name of the theme to setup the task.
 * @param config
 *    Selected theme configuration object.
 *
 * @return string
 *    The name of the new task.
 */
function stylelintTask(theme, config) {
  var taskName = 'stylelint_' + theme;

  gulp.task(taskName, function lintCssTask() {
    return gulp.src(config.sass.paths)
      .pipe(stylelint({
        reporters: [
          {formatter: 'string', console: true}
        ]
      }));
  });

  return taskName;
}

/**
 * Watch sass and stylelint tasks.
 *
 * @param theme
 *    Name of the theme to setup the task.
 * @param config
 *    Selected theme configuration object.
 *
 * @return string
 *    The name of the new task.
 */
function watchTasks(theme, config) {
  var taskName = 'watch_' + theme;

  gulp.task(taskName, function() {
    gulp.watch(config.sass.paths, ['sass']);
    gulp.watch(config.sass.paths, ['stylelint']);

    if (argv.sync && config.hasOwnProperty('twig')) {
      gulp.watch(config.twig.paths).on('change', browserSync.reload);
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
  if (argv.sync) {
    browserSync = require('browser-sync').create();
    browserSync.init({
      proxy: argv.domain,
      host: argv.domain
    });
  }

  // Define task arrays.
  var sassTaskNames = [];
  var stylelintTaskNames = [];
  var watchTasksNames = [];

  // Ensure themes is an array and if not convert it.
  if (Object.prototype.toString.call(themes) !== '[object Array]') {
    themes = [ themes ];
  }

  // Loop over the selected themes.
  for (var i in themes) {
    var theme = themes[i];
    var config = configuration[theme];

    // SASS tasks.
    sassTaskNames.push(sassTask(theme, config));

    // Stylelint tasks.
    stylelintTaskNames.push(stylelintTask(theme, config));

    // Watch tasks.
    watchTasksNames.push(watchTasks(theme, config));
  }

  // Define tasks.
  gulp.task('sass', sassTaskNames);
  gulp.task('stylelint', stylelintTaskNames);
  gulp.task('watch', watchTasksNames);

  // Default task;
  gulp.task('default', ['sass', 'watch']);
}

/**
 * ------- Run task's -------
 */
setupTasks(argv.theme);
