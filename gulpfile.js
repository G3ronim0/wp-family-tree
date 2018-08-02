// process.env.DISABLE_NOTIFIER = true; // Uncomment to disable all Gulp notifications.

/**
 * WP_Translations.
 *
 * This file adds gulp tasks to the WP_Translations Plugin.
 *
 * @author Sadler Jerome
 */

// Require our dependencies.
var args       = require('yargs').argv,
  gulp         = require('gulp'),
  wpPot        = require('gulp-wp-pot');

  var paths = {
    php: ['./*.php', './**/*.php', './**/**/*.php'],
  };


/**
 * Scan the theme and create a POT file.
 *
 * https://www.npmjs.com/package/gulp-wp-pot
 */
gulp.task('translate', function () {

  return gulp.src(paths.php)

    .pipe(wpPot({
      domain: 'wp-family-tree',
    }))

    .pipe(gulp.dest('./languages/wp-family-tree.pot'));

});
