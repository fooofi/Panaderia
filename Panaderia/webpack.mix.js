const mix = require("laravel-mix");

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

mix.react("resources/js/app.js", "public/js");
mix.sass("resources/sass/style.scss", "public/css");
mix.copy("resources/assets", "public/assets");
//**************** COREUI CSS ********************

mix.copy(
    "node_modules/@coreui/chartjs/dist/css/coreui-chartjs.css",
    "public/css"
);
mix.copy("node_modules/cropperjs/dist/cropper.css", "public/css");

//**************** COREUI JS *********************
mix.copy(
    "node_modules/@coreui/coreui/dist/js/coreui.bundle.min.js",
    "public/js"
    );
mix.copy("node_modules/@coreui/utils/dist/coreui-utils.js", "public/js");
mix.copy("node_modules/axios/dist/axios.min.js", "public/js");

// views scripts
mix.copy("node_modules/chart.js/dist/Chart.min.js", "public/js");
mix.copy(
    "node_modules/@coreui/chartjs/dist/js/coreui-chartjs.bundle.js",
"public/js"
);
mix.copy("node_modules/cropperjs/dist/cropper.js", "public/js");

//**************** COREUI ASSETS *****************
mix.copy("node_modules/@coreui/icons/fonts", "public/fonts");
mix.copy("node_modules/@coreui/icons/css/free.min.css", "public/css");
mix.copy("node_modules/@coreui/icons/css/brand.min.css", "public/css");
mix.copy("node_modules/@coreui/icons/css/flag.min.css", "public/css");
mix.copy("node_modules/@coreui/icons/sprites/", "public/icons/sprites");
