var gulp = require('gulp'),
        concat = require('gulp-concat'),
        debug = require('gulp-debug'),
        uglify = require('gulp-uglify'),
        uglifycss = require('gulp-clean-css'),
        rename = require('gulp-rename'),
        sass = require('gulp-sass'),
        less = require('gulp-less'),
        autoprefixer = require('gulp-autoprefixer'),
        browserSync = require('browser-sync').create();

var DEST = 'public';

var cssSrc = [
    'node_modules/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css',
    'node_modules/gentelella/vendors/font-awesome/css/font-awesome.min.css',
    'node_modules/gentelella/vendors/nprogress/nprogress.css',
    'node_modules/gentelella/vendors/iCheck/skins/flat/green.css',
    'node_modules/gentelella/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css',
    'node_modules/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.css',
    'node_modules/gentelella/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css',
    'node_modules/gentelella/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css',
    'node_modules/gentelella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css',
    'node_modules/gentelella/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css',
    'node_modules/gentelella/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css',
    'node_modules/gentelella/vendors/jquery.tagsinput/src/jquery.tagsinput.css',
    'node_modules/gentelella/vendors/switchery/dist/switchery.min.css',
    'node_modules/fancybox/dist/css/jquery.fancybox.css',
    'node_modules/gentelella/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css',
    'node_modules/pnotify/src/pnotify.css',
    'node_modules/pnotify/src/pnotify.brighttheme.css',
];

var myCssSrc = [
    'public/css/styles.css',
];

var jsSrc = [
    'node_modules/gentelella/vendors/jquery/dist/jquery.min.js',
    'node_modules/gentelella/vendors/bootstrap/dist/js/bootstrap.min.js',
    'node_modules/gentelella/vendors/fastclick/lib/fastclick.js',
    'node_modules/gentelella/vendors/nprogress/nprogress.js',
    'node_modules/gentelella/vendors/Chart.js/dist/Chart.min.js',
    'node_modules/gentelella/vendors/raphael/raphael.min.js',
    'node_modules/gentelella/vendors/morris.js/morris.min.js',
    'node_modules/gentelella/vendors/gauge.js/dist/gauge.min.js',
    'node_modules/gentelella/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js',
    'node_modules/gentelella/vendors/iCheck/icheck.min.js',
    'node_modules/gentelella/vendors/datatables.net/js/jquery.dataTables.min.js',
    'node_modules/gentelella/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js',
    'node_modules/gentelella/vendors/datatables.net-buttons/js/dataTables.buttons.min.js',
    'node_modules/gentelella/vendors/datatables.net-responsive/js/dataTables.responsive.min.js',
    'node_modules/gentelella/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js',
    'node_modules/gentelella/vendors/datatables.net-buttons/js/buttons.flash.min.js',
    'node_modules/gentelella/vendors/datatables.net-buttons/js/buttons.html5.min.js',
    'node_modules/gentelella/vendors/datatables.net-buttons/js/buttons.print.min.js',
    'node_modules/gentelella/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js',
    'node_modules/gentelella/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js',

    'node_modules/gentelella/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js',
    'node_modules/gentelella/vendors/datatables.net-scroller/js/dataTables.scroller.min.js',
    'node_modules/gentelella/vendors/echarts/dist/echarts.min.js',
    'node_modules/gentelella/vendors/DateJS/build/date.js',
    'node_modules/gentelella/vendors/moment/min/moment.min.js',
    'node_modules/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.js',
    'node_modules/gentelella/vendors/jquery.tagsinput/src/jquery.tagsinput.js',
    'node_modules/fancybox/dist/js/jquery.fancybox.js',
    'node_modules/gentelella/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js',
    'node_modules/gentelella/vendors/switchery/dist/switchery.min.js',
    'node_modules/pnotify/src/pnotify.js',
    'node_modules/gentelella/src/js/custom.js',
    'node_modules/gentelella/src/js/helper.js',
];

var sassSrc = [
    'node_modules/gentelella/src/scss/custom.scss',
    'node_modules/gentelella/src/scss/daterangepicker.scss',
];

var customScriptSrc = [
    'public/js/functions.js',
    'public/js/scripts.js',
    'public/js/init.js',
]

gulp.task('css', function () {
    return gulp.src(cssSrc)
            .pipe(debug({title: 'vendor css:'}))
            .pipe(concat('vendor.css'))
            .pipe(uglifycss())
            .pipe(rename({suffix: '.min'}))
            .pipe(gulp.dest(DEST + '/css'));
});

gulp.task('mycss', function () {
    return gulp.src(myCssSrc)
            .pipe(debug({title: 'custom css:'}))
            .pipe(concat('styles.css'))
            .pipe(uglifycss())
            .pipe(rename({suffix: '.min'}))
            .pipe(gulp.dest(DEST + '/css'));
});

gulp.task('sass', function () {
    return gulp.src(sassSrc)
            .pipe(debug({title: 'app css:'}))
            .pipe(concat('custom.css'))
            .pipe(uglifycss())
            .pipe(rename({suffix: '.min'}))
            .pipe(gulp.dest(DEST + '/css'));
});

gulp.task('scripts', function () {
    return gulp.src(jsSrc)
            .pipe(debug({title: 'vendor scripts:'}))
            .pipe(concat('vendor.js'))
            .pipe(rename({suffix: '.min'}))
            .pipe(uglify())
            .pipe(gulp.dest(DEST + '/js'));
});

gulp.task('myscripts', function () {
    return gulp.src(customScriptSrc)
            .pipe(debug({title: 'custom scripts:'}))
            .pipe(concat('custom.js'))
            .pipe(rename({suffix: '.min'}))
            .pipe(uglify())
            .pipe(gulp.dest(DEST + '/js'));
});

gulp.task('watch', function () {
    gulp.watch(sassSrc, ['sass']);
    gulp.watch(cssSrc, ['css']);
    gulp.watch(myCssSrc, ['mycss']);
    gulp.watch(jsSrc, ['scripts']);
    gulp.watch(customScriptSrc, ['myscripts']);
});

gulp.task('default', ['watch']);
