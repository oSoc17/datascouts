'use strict';
 
var gulp = require('gulp');
var sass = require('gulp-sass');

gulp.task('sass', () => {
  return gulp.src('./sass/**/*.scss')
    .pipe(sass({outputStyle: 'expanded'}).on('error', sass.logError))
    .pipe(gulp.dest('./css'));
});

gulp.task('watch', () => {
  gulp.watch('./sass/**/*.scss', ['sass']);
});

