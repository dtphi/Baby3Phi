const mix = require('laravel-mix');
require('laravel-mix-alias');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.alias('@app', '/resources/js');

mix.alias('com@front', '/resources/js/components/front');
mix.alias('store@front', '/resources/js/stores/front');
mix.alias('v@front', '/resources/js/views/front');

mix.alias('store@admin', '/resources/js/stores/admin');
mix.alias('v@admin', '/resources/js/views/admin');

if (mix.inProduction()) {
    mix.js('resources/js/b3p-app-front.js', `public/js/front-${process.env['APP_API_NAME_KEY']}`);
    mix.webpackConfig({
        output: {
            chunkFilename: `js/front-${process.env['APP_API_NAME_KEY']}-chunks/[name].js`,
        },
    });
} else {
    mix.js('resources/js/b3p-app-front.js', 'public/js/stg');
    mix.webpackConfig({
        output: {
            chunkFilename: 'js/stg-front.chunks/[name].js',
        },
    });
}
