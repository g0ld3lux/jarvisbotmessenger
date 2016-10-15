var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss');

    mix.styles([
        '../../../node_modules/sweetalert/dist/sweetalert.css',
        '../../../node_modules/pace-progress/themes/green/pace-theme-flash.css',
        '../../../resources/assets/js/plugins/jquery-ui/jquery-ui.min.css',
        '../../../node_modules/select2/dist/css/select2.min.css',
        '../../../node_modules/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css',
        '../../../node_modules/angular-ui-bootstrap/dist/ui-bootstrap-csp.css',
        '../../../node_modules/angular-toastr/dist/angular-toastr.min.css',
        '../../../node_modules/ui-select/dist/select.min.css',
        '../../../node_modules/datatables/media/css/jquery.dataTables.min.css',
        '../../../node_modules/angular-datatables/dist/css/angular-datatables.min.css',
        '../../../node_modules/angular-datatables/dist/plugins/bootstrap/datatables.bootstrap.min.css',
        '../../../node_modules/bootstrap-daterangepicker/daterangepicker.css',
        '../../../public/css/app.css'
    ]);

    mix.copy('node_modules/font-awesome/fonts', 'public/build/fonts');
    mix.copy('node_modules/bootstrap-sass/assets/fonts/bootstrap', 'public/build/fonts/bootstrap');

    mix.scripts([
        'pace_fix.js',
        '../../../node_modules/jquery/dist/jquery.min.js',
        '../../../node_modules/sweetalert/dist/sweetalert.min.js',
        '../../../node_modules/pace-progress/pace.min.js',
        'plugins/jquery-ui/jquery-ui.min.js',
        '../../../node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js',
        '../../../node_modules/select2/dist/js/select2.min.js',
        '../../../node_modules/chart.js/dist/Chart.min.js',
        '../../../node_modules/moment/min/moment.min.js',
        '../../../node_modules/moment-timezone/builds/moment-timezone-with-data.js',
        '../../../node_modules/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
        '../../../node_modules/underscore/underscore-min.js',
        '../../../node_modules/bootstrap-daterangepicker/daterangepicker.js',
        '../../../node_modules/angular/angular.min.js',
        '../../../node_modules/angular-animate/angular-animate.min.js',
        '../../../node_modules/angular-ui-bootstrap/dist/ui-bootstrap.js',
        '../../../node_modules/angular-ui-bootstrap/dist/ui-bootstrap-tpls.js',
        '../../../node_modules/angular-toastr/dist/angular-toastr.min.js',
        '../../../node_modules/angular-toastr/dist/angular-toastr.tpls.min.js',
        '../../../node_modules/angular-ui-sortable/dist/sortable.min.js',
        '../../../node_modules/angular-sanitize/angular-sanitize.min.js',
        '../../../node_modules/datatables/media/js/jquery.dataTables.min.js',
        '../../../node_modules/angular-datatables/dist/angular-datatables.min.js',
        '../../../node_modules/angular-datatables/dist/plugins/bootstrap/angular-datatables.bootstrap.min.js',
        '../../../node_modules/ui-select/dist/select.min.js',
        '../../../node_modules/angular-chart.js/dist/angular-chart.min.js',
        '../../../node_modules/angular-daterangepicker/js/angular-daterangepicker.min.js',
        '../../../node_modules/ng-file-upload/dist/ng-file-upload-shim.min.js',
        '../../../node_modules/ng-file-upload/dist/ng-file-upload.min.js',
        'app.js',
        'angular/app.js',
        'angular/config/**/*.js',
        'angular/controllers/**/*.js',
        'angular/factories/**/*.js',
        'angular/services/**/*.js',
        'angular/directives/**/*.js',
        'angular/filters/**/*.js'
    ]);

    mix.version([
        'css/all.css',
        'js/all.js'
    ]);
});
