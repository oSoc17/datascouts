'use strict';
 
var gulp = require('gulp');
var sass = require('gulp-sass');
let cleanCSS = require('gulp-clean-css');
 
gulp.task('sass', () => {
  return gulp.src('./sass/**/*.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest('./css'));
});

gulp.task('watch', () => {
  gulp.watch('./sass/**/*.scss', ['sass']);
  return gulp.src('./sass/**/*.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest('./css'));
});

gulp.task('minify-css', () => {
  return gulp.src('css/*.css')
    .pipe(cleanCSS({compatibility: 'ie8'}))
    .pipe(gulp.dest('./css'));
});
