const mix = require('laravel-mix');

mix
  .js('resources/js/blueprint-name.js', 'dist/js').vue()
  .postCss('resources/css/blueprint-name.pcss', 'dist/css', [
    require('postcss-nested'),
  ])
  .copyDirectory('dist', '../../public/vendor/statamic-blueprint-name')
  .sourceMaps()
  .disableNotifications();
