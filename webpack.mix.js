const mix = require('laravel-mix');

const autoPreprocess = require('svelte-preprocess');
const postcssImport = require('postcss-import');

const production = !process.env.ROLLUP_WATCH;
const config = {
    dev: !production, // run-time checks      
    preprocess: [
        autoPreprocess({
            postcss: { plugins: [postcssImport()] },
            defaults: { style: 'postcss' }
        })
    ]
};
// const config = {};
require('laravel-mix-svelte');

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

mix.js('src/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .svelte(config);