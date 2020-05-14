const mix = require('laravel-mix');
const CompressionPlugin = require('compression-webpack-plugin');
const webpack = require('webpack');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .browserSync('jk.com')
    .webpackConfig({
        devtool: "cheap-module-source-map",
        plugins: [
            new CompressionPlugin({
                filename: "[path].gz[query]",
                algorithm: "gzip",
                test: /\.js$|\.css$|\.html$|\.svg$/,
                threshold: 10240,
                minRatio: 0.8
            }),
            new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/)
        ],
        resolve: {
            alias: {
                '@components': path.resolve(__dirname, 'resources', 'js', 'components')
            }
        },
        output: {
            chunkFilename: '[name].js?id=[chunkhash]',
        },
    });

if (mix.inProduction()) {
    mix.version();
}