const mix = require('laravel-mix');

mix.webpackConfig({
    resolve: {
        symlinks: false,
        alias: {
          '~': path.join(__dirname, './resources/js')
        }
    }
})

mix.extract([
    'axios',
    'date-fns',
    'markdown-it',
    'vee-validate',
    'vform',
    'vue',
    'vuetify',
])

mix.js('resources/js/app.js', 'public/js')
   .stylus('resources/stylus/app.styl', 'public/css');
