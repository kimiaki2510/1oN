const mix = require('laravel-mix');
const glob = require('glob');

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

// mix.react('resources/js/app.js', 'public/js')
//    .sass('resources/sass/app.scss', 'public/css');

// mix.ts('resources/ts/index.tsx', 'public/js')
mix.sass('resources/sass/app.scss', 'public/css')
   .version(); 

glob.sync('resources/ts/*.tsx').map(function (file) {
   mix.ts(file, 'public/js');
});
glob.sync('resources/sass/pages/*.scss').map(function (file) {
   mix.sass(file, 'public/css');
});

if (mix.inProduction()) {
   mix.version();
 }