var elixir = require('laravel-elixir');
var remove = require('del');   // execute: $ npm install --save-dev del

var Task = elixir.Task;

elixir.extend('remove', function(path) {

    new Task('remove', function() {
        console.log('Current directory: ${process.cwd()}'); //for debug, remove this if you don't want
        return remove(path);
    });
});
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

var paths = {
    "theme": "../../../resources/theme/adminto/Horizontal/assets",
    "public_assets": "../../../public/assets",
    "theme_root": "resources/theme/adminto/Horizontal/assets",
    "bower": "../../../vendor/bower",
    "scripts": "resources/js",
}

elixir(function(mix) {
    mix.remove([ 'public/assets' ]);
    //--------build css-------//
    mix.styles([
        paths.theme+'/plugins/custombox/dist/custombox.min.css',
        paths.theme+'/css/bootstrap.min.css',
        //paths.theme+'/css/bootstrap-theme.min.css',
        paths.theme+'/css/typicons.css',
    ], 'public/assets/css/dependencies.css');
    //theme less -- cant mix the less for some reason.  Theme files must be out of date vs compiled
    mix.less(paths.theme+'/less/*.less', 'public/assets/css/styles.css');
    //compile css
    mix.stylesIn("public/assets/css","public/assets/css/all.css");
    //custom css
    mix.less('custom.less', 'public/assets/css/custom.css');
    //version css
    mix.version('assets/css/custom.css');


    //------copy fonts-------//

    mix.copy(paths.theme_root+'/fonts', 'public/assets/fonts');


    //------build js-------//
    //
    mix.scripts([
        paths.theme+'/js/jquery.min.js',
        paths.theme+'/js/bootstrap.js',
        paths.theme+'/js/detect.js',
        paths.theme+'/js/fastclick.js',
        paths.theme+'/js/jquery.slimscroll.js',
        paths.theme+'/js/jquery.blockUI.js',
        paths.theme+'/js/waves.js',
        paths.theme+'/js/wow.min.js',
        paths.theme+'/js/jquery.nicescroll.js',
        paths.theme+'/js/jquery.scrollTo.min.js',
        paths.theme+'/js/jquery.scrollTo.min.js',
        paths.theme+'/plugins/custombox/dist/custombox.min.js',
        paths.theme+'/plugins/custombox/dist/legacy.min.js',
        paths.theme+'/plugins/jquery-validation/dist/jquery.validate.min.js',
        paths.theme+'/plugins/bootstrap-wizard/jquery.bootstrap.wizard.js',

    ], 'public/assets/js/dependencies.js');

    //forms
    mix.scripts([
        paths.bower+'/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
        paths.bower+'/jquery.inputmask/dist/jquery.inputmask.bundle.js',
        paths.bower+'/select2/dist/js/select2.full.min.js',
        paths.bower+'/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js',
        paths.bower+'/switchery/dist/switchery.min.js',
        paths.bower+'/jquery-validation/dist/jquery.validate.min.js',
        paths.bower+'/jquery-validation/dist/additional-methods.min.js',
        paths.bower+'/Mention.js/bootstrap-typeahead.js',
        paths.bower+'/Mention.js/mention.js',
        paths.bower+'/jquery-form/jquery.form.js',

    ], 'public/assets/js/forms.js');
    mix.styles([
        paths.bower+'/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css',
        paths.bower+'/select2/dist/css/select2.min.css',
        paths.bower+'/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css',
        paths.bower+'/switchery/dist/switchery.min.css'

    ], 'public/assets/css/forms.css');

    //datatables
    mix.scripts([
        paths.theme+'/plugins/datatables/jquery.dataTables.min.js',
        paths.theme+'/plugins/datatables/dataTables.bootstrap.js',
        paths.theme+'/plugins/datatables/dataTables.buttons.min.js',
        paths.theme+'/plugins/datatables/buttons.bootstrap.min.js',
        paths.theme+'/plugins/datatables/jszip.min.js',
        paths.theme+'/plugins/datatables/pdfmake.min.js',
        paths.theme+'/plugins/datatables/vfs_fonts.js',
        paths.theme+'/plugins/datatables/buttons.html5.min.js',
        paths.theme+'/plugins/datatables/buttons.print.min.js',
        paths.theme+'/plugins/datatables/dataTables.fixedHeader.min.js',
        paths.theme+'/plugins/datatables/dataTables.keyTable.min.js',
        paths.theme+'/plugins/datatables/dataTables.responsive.min.js',
        paths.theme+'/plugins/datatables/responsive.bootstrap.min.js',
        paths.theme+'/plugins/datatables/dataTables.scroller.min.js',
        paths.theme+'/plugins/magnific-popup/dist/jquery.magnific-popup.min.js'
    ], 'public/assets/js/datatables.js');
    mix.styles([
        paths.theme+'/plugins/datatables/jquery.dataTables.min.css',
        paths.theme+'/plugins/datatables/buttons.bootstrap.min.css',
        paths.theme+'/plugins/datatables/fixedHeader.bootstrap.min.css',
        paths.theme+'/plugins/datatables/responsive.bootstrap.min.css',
        paths.theme+'/plugins/datatables/scroller.bootstrap.min.css',
        paths.theme+'/plugins/magnific-popup/dist/magnific-popup.css'
    ], 'public/assets/css/datatables.css');


    //core app
    mix.scripts([
        paths.theme+'/js/jquery.core.js',
        paths.theme+'/js/jquery.app.js'
    ], 'public/assets/js/app.js');
    //modernizr
    mix.copy(paths.theme_root+'/js/modernizr.min.js', 'public/assets/js');

    //------copy plugins-------//
    mix.copy(paths.theme_root+'/plugins', 'public/assets/plugins');

    //------copy pages js-------//
    mix.copy(paths.theme_root+'/pages', 'public/assets/pages');

    //------copy images-------//
    mix.copy(paths.theme_root+'/images', 'public/assets/images');

    //------copy custom js-------//
    mix.copy(paths.scripts, 'public/assets/js');
});
