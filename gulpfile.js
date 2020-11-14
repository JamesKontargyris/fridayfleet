// Dirs
var baseDir = 'wp-content/themes/fridayfleet/';
var pluginDir = 'wp-content/plugins/fridayfleet/';
var sassDir = baseDir + 'sass/';
var jsDir = baseDir + 'js/';

// Gulp
const gulp = require('gulp');

// Sass/CSS stuff
const sass = require('gulp-sass');
const prefix = require('gulp-autoprefixer');

// JS
const uglify = require('gulp-uglify');

//Others
const rename = require('gulp-rename');
const browsersync = require('browser-sync').create();

// BrowserSync
function browserSync(done) {
    browsersync.init({
        proxy: "fridayfleet.test",
        notify: false,
        open: false,
        port:3000,
        ghostMode: false,
        https: false
    });
    done();
}

// BrowserSync Reload
function browserSyncReload(done) {
    browsersync.reload();
    done();
}

// BrowserSync Stream
function browserSyncStream(done) {
    browsersync.stream();
    done();
}


// Compile Sass
function styles() {
    return gulp
        .src([sassDir + 'style.scss'])
        .pipe(sass({
            outputStyle: 'compressed'
        }))
        .pipe(prefix(
            "last 1 version", "> 1%", "ie 8", "ie 7"
        ))
        .pipe(gulp.dest(baseDir))
        .pipe(browsersync.stream());
}

// uglify all JS
function scripts() {
    return gulp
        .src(jsDir + '**/*.js')
        .pipe(uglify())
        .pipe(rename({
            suffix: '.min'
        }))
        // Adds min to filename
        .pipe(gulp.dest(jsDir + 'min'));
}

// Watch files
function watchFiles(done) {
    // Uses polling to get around issues with changes made to files locally that are not reflected on the virtual machine
    // (https://github.com/floatdrop/gulp-watch/issues/213)
    gulp.watch(sassDir + '**/*.scss', { usePolling: true, ignoreInitial: false }, gulp.series(styles));
    gulp.watch(baseDir + '**/*.php', { usePolling: true, ignoreInitial: false }, gulp.series(browserSyncReload));
    gulp.watch(pluginDir + '**/*.php', { usePolling: true, ignoreInitial: false }, gulp.series(browserSyncReload));
    gulp.watch(baseDir + '**/*.js', { usePolling: true, ignoreInitial: false }, gulp.series(browserSyncReload));
    done();
}

// call these using gulp js, gulp img etc.
exports.css = gulp.series(styles);
exports.js = gulp.series(scripts);
exports.watch = gulp.series(watchFiles, browserSync);
exports.build = gulp.series(scripts, styles);

// call this using gulp default or just gulp
exports.default = gulp.series(watchFiles, browserSync);