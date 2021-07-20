const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    //.scripts([
    //    'public/js/admin.js',
    //    'public/js/admin2.js',
    //], 'public/js/admin/all.js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/admin.scss', 'public/css/admin')
    //.stylus('resources/sass/app.less', 'public/css')
    //.styles([
    //    'resources/css/style1.css',
    //    'resources/css/style2.css',
    //], 'public/css/plain.css')
    .sourceMaps();

    if (mix.inProduction()) {
        mix.version();
    }

    mix.browserSync('127.0.0.1:8000');