let mix = require('laravel-mix');

require('laravel-mix-tailwind');

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

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
   .tailwind('resources/assets/tailwind.js')
   .browserSync('danastyffl.test')
   .copyDirectory('resources/assets/images', 'public/images')
   .extract([
    'axios',
    'vue',
    'vue-router',
    'vue-touch',
    'vue2-filters',
    'lodash',
    'jquery'
  ])
  .autoload({
    jquery: ['$', 'window.jQuery', 'jQuery'],
    lodash: ['_', 'window._'],
    vue: ['Vue', 'window.Vue'],
    axios: ['axios', 'window.axios'],
  });

if (mix.inProduction()) {
    mix.version();
}
