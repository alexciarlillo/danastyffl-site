let mix = require('laravel-mix');
let ImageminPlugin = require( 'imagemin-webpack-plugin' ).default;

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
   .extract([
    'axios',
    'vue',
    'vue-router',
    'vue-touch',
    'vue2-filters',
    'lodash',
    'jquery',
    'moment',
    'pusher-js',
    'laravel-echo'
  ])
  .autoload({
    jquery: ['$', 'window.jQuery', 'jQuery'],
    lodash: ['_', 'window._'],
    vue: ['Vue', 'window.Vue'],
    axios: ['axios', 'window.axios'],
    moment: ['moment', 'windows.moment']
  });

mix.webpackConfig( {
    plugins: [
        new ImageminPlugin( {
            pngquant: {
                quality: '95-100',
            },
            test: /\.(jpe?g|png|gif|svg)$/i,
        } ),
    ],
} )

if (mix.inProduction()) {
    mix.version();
}
