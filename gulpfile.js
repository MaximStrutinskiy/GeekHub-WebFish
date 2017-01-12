// command run gulp - $gulp run
var gulp = require('gulp'),
  rename = require('gulp-rename'),
  notify = require('gulp-notify'),
  prefix = require('gulp-autoprefixer'),
  sass = require('gulp-sass'),
  sassGlob = require('gulp-sass-glob'),
  minifyCss = require('gulp-minify-css'),
  jshint = require('gulp-jshint'),
  jsmin = require('gulp-jsmin'),
  imagemin = require('gulp-imagemin');


//img
gulp.task('img', function () {
  return gulp.src('web/assets/src/img/*.*')
    .pipe(imagemin())
    .pipe(gulp.dest('web/assets/assets/img/'));
});

//js
gulp.task('js', function () {
  return gulp.src('web/assets/src/js/**/*.js')
    .pipe(jsmin())
    .pipe(jshint())
    .pipe(jshint.reporter('default'))
    .pipe(rename('main.min.js'))
    .pipe(gulp.dest('web/assets/assets/js/'));
});

//sass
gulp.task('sass', function () {
  return gulp.src('web/assets/src/scss/**/*.scss')
    .pipe(sassGlob())
    .pipe(sass({
      includePaths: [
        'node_modules/breakpoint-sass/stylesheets',
        'node_modules/susy/sass'
      ]
    }))
    .pipe(prefix('last 20 versions'))
    .pipe(minifyCss(''))
    .pipe(notify('Gulp DONE!'))
    .pipe(rename('main.min.css'))
    .pipe(gulp.dest('web/assets/assets/css/'));
});

//watch
gulp.task('watch', function () {
  gulp.watch('web/assets/src/scss/**/*.scss', ['sass']);
  gulp.watch('web/assets/src/js/*.js', ['js']);
  gulp.watch('web/assets/src/img/*.*', ['img']);
});

// default
gulp.task('wh', ['watch']);
gulp.task('default', ['sass', 'js', 'img']);