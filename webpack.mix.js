const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Sage application. By default, we are compiling the Sass file
 | for your application, as well as bundling up your JS files.
 |
 */

mix
  .setPublicPath('./public')
  .browserSync('https://networkrail.test');

mix
  .sass('resources/styles/app.scss', 'styles')
  .sass('resources/styles/editor.scss', 'styles')
  .sass('resources/styles/amp.scss', 'styles')
  .options({
    processCssUrls: false,
    postCss: [
      require('tailwindcss'),
    ],
  });

mix
  .js('resources/scripts/app.js', 'scripts')
  .vue()

mix
  .webpackConfig({
    resolve: {
      fallback: {
        fs: false,
        tls: 'empty',
        net: 'empty',
        module: 'empty',
        console: false,
        path: require.resolve("path-browserify"),
        stream: require.resolve("stream-browserify"),
        http: require.resolve("stream-http"),
        https: require.resolve("https-browserify"),
        os: require.resolve("os-browserify/browser"),
        crypto: require.resolve("crypto-browserify"),
      },
    },
    output: {
      chunkFilename: 'scripts/[name].[chunkhash].js',
      publicPath: '/wp-content/themes/network-rail/public/',
    },
  });

mix
  .override(config => {
    config.module.rules.find(rule =>
      rule.test.test('.svg')
    ).exclude = /\.svg$/;

    config.module.rules.push({
      test: /\.svg$/,
      use: [{ loader: 'html-loader' }],
    })
  });

mix
  .copyDirectory('resources/images', 'public/images')
  .copyDirectory('resources/fonts', 'public/fonts');

mix
  .version();
