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

mix.alias('com@admin', '/resources/js/components/admin');
mix.alias('store@admin', '/resources/js/stores/admin');
mix.alias('v@admin', '/resources/js/views/admin');
mix.alias('api@admin', '/resources/js/api/admin');

if (mix.inProduction()) {
    mix.js('resources/js/b3p-app-admin.js', `public/js/admin-${process.env['APP_API_NAME_KEY']}`);
    mix.webpackConfig({
        output: {
            chunkFilename: `js/admin-${process.env['APP_API_NAME_KEY']}-chunks/[name].js`,
        },
    });
} else {
    mix.js('resources/js/b3p-app-admin.js', 'public/js/stg');
    mix.webpackConfig({
        output: {
            chunkFilename: 'js/stg-admin.chunks/[name].js',
        },
    });
}
