var path = require('path');
var webpack = require('webpack');
let FriendlyErrorsWebpackPlugin = require('friendly-errors-webpack-plugin');
let BrowserSyncPlugin = require('browser-sync-webpack-plugin');
var EslintFriendlyFormatter = require('eslint-friendly-formatter');
var AutoPrefixer = require('autoprefixer');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
let ExtractTextPlugin = require('extract-text-webpack-plugin');
var files = getFilePaths();
var extractScss = new ExtractTextPlugin(files.css.build);
const fs = require('fs');

module.exports = {
    context: files.context.base,
    entry: files.js.src,
    output: getOutput(),
    module: getModule(),
    devtool: getDevtool(),
    devServer: getDevServer(),
    resolve: getResolve(),
    performance: getPerformance(),
    plugins: getPlugins(),
}

addUglifyPluginForProduction();
addBrowserSyncPluginForDevelopment();
addHashFileForProductionCacheBusting();

function getFilePaths(){
    return {
        context: {
            base: path.resolve(__dirname, './'),
            build: path.resolve(__dirname, './public'),
            node_modules: path.resolve(__dirname, './node_modules'),
        },
        js: {
            src: path.resolve(__dirname, './resources/app/app.js'),
            build: process.env.NODE_ENV === 'production' && process.env.BUILD_TARGET !== 'ios' ? 'js/app.[hash].js' : 'js/app.js',
        },
        css: {
            src: path.resolve(__dirname, './resources/app/app.scss'),
            build: process.env.NODE_ENV === 'production' && process.env.BUILD_TARGET !== 'ios' ? 'css/app.[hash].css' : 'css/app.css',
        },
    }
}
function getOutput(){
    return {
        path: files.context.build,
        publicPath: '',
        filename: files.js.build,
    }
}
function getModule(){
    return {
        rules: [
            getJsRule(),
            getMainStyleFileRule(),
            getCssRule(),
            getSassRule(),
            getHtmlRule(),
            getImageRule(),
            getFontRule(),
            getVueEslintRule(),
            getVueRule(),
        ]
    }

    function getJsRule(){
        return {
            test: /\.jsx?$/,
            exclude: /(node_modules|bower_components)/,
            use: [
                {
                    loader: 'babel-loader',
                    options:getBabelConfig(),
                },
                {
                    loader: 'eslint-loader',
                    options: {
                      formatter: EslintFriendlyFormatter,
                    },
                }
            ]
        }
    }
    function getBabelConfig(){
        return {
            cacheDirectory: true,
            presets: [
                [
                    'env',
                    {
                        modules: false,
                        targets: {
                            browsers: ['> 2%'],
                            uglify: true
                        }
                    },
                ]
            ],
        }
    }
    function getCssRule(){
        return {
            test: /\.css$/,
            exclude: [],
            loaders: ['style-loader', 'css-loader']
        }
    }
    function getSassRule(){
        return {
            test: /\.s[ac]ss$/,
            exclude: [files.css.src],
            loaders: ['style-loader', 'css-loader', 'sass-loader']
        }
    }
    function getHtmlRule(){
        return {
            test: /\.html$/,
            loaders: ['html-loader']
        }
    }
    function getImageRule(){
        return {
            test: /\.(png|jpe?g|gif)$/,
            loaders: [
                {
                    loader: 'file-loader',
                    options: {
                        name: path => {
                            if (! /node_modules|bower_components/.test(path)) {
                                return 'images/[name].[ext]?[hash]';
                            }

                            return 'images/vendor/' + path
                                .replace(/\\/g, '/')
                                .replace(
                                    /((.*(node_modules|bower_components))|images|image|img|assets)\//g, ''
                                ) + '?[hash]';
                        },
                        publicPath: '/',
                    }
                },
                {
                    loader: 'img-loader',
                    options: {
                        enabled: true,
                        gifsicle: {},
                        mozjpeg: {},
                        optipng: {},
                        svgo: {}
                    }
                }
            ]
        }
    }
    function getFontRule(){
        return {
            test: /\.(woff(2)?|ttf|eot|svg)(\?v=\d+\.\d+\.\d+)?$/,
            loader: 'file-loader',
            options: {
                name: function(path){

                    var isNotAPackageFile = ! /node_modules|bower_components/.test(path);

                    if (isNotAPackageFile) {
                        return 'fonts/[name].[ext]?[hash]';
                    }

                    return 'fonts/vendor/' + path
                        .replace(/\\/g, '/')
                        .replace(
                            /((.*(node_modules|bower_components))|fonts|font|assets)\//g, ''
                        ) + '?[hash]';
                },
                publicPath: '/',
            }
        }
    }
    function getMainStyleFileRule(){
        return {
            test: files.css.src,
            use: extractScss.extract({
                fallback: "style-loader",
                use: [
                    {
                        loader: 'css-loader',
                        options: {
                            url: false,
                            sourceMap: true,
                            importLoaders: 1
                        }
                    },
                    {
                        loader: 'postcss-loader',
                        options: {
                            sourceMap: true,
                            ident: 'postcss',
                            plugins: [
                                AutoPrefixer(),
                            ]
                        }
                    },
                    {
                        loader: 'resolve-url-loader',
                        options: {
                            sourceMap: true,
                            root: files.context.node_modules
                        }
                    },
                    {
                        loader: 'sass-loader',
                        options: {
                            precision: 8,
                            outputStyle: 'expanded',
                            sourceMap: true
                        }
                    }
                ]
            }),
        }
    }
    function getVueEslintRule(){
        return {
            enforce: 'pre',
            test: /\.vue$/,
            loader: 'eslint-loader',
            exclude: /node_modules/,
            options: {
              formatter: EslintFriendlyFormatter,
            },
        }
    }
    function getVueRule(){
        return {
            test: /\.vue$/,
            loader: 'vue-loader',
            exclude: /bower_components/,
            options: {
                loaders: {
                    js: {
                        loader: 'babel-loader!eslint-loader',
                        options: getBabelConfig(),
                    }
                },
                postcss: [],
                preLoaders: {},
                postLoaders: {}
            }
        }
    }
}
function getDevtool(){
    if(process.env.NODE_ENV === 'production'){
        return '#source-map';
    } else {
        return 'inline-source-map';
    }
}
function getDevServer(){
    return {
        headers: {
            'Access-Control-Allow-Origin': '*'
        },
        contentBase: files.context.build,
        historyApiFallback: true,
        noInfo: true,
        compress: true,
        quiet: true
    }
}
function getResolve(){
    return {
        extensions: ['*', '.js', '.jsx', '.vue'],
        alias: {
            'vue$': 'vue/dist/vue.common.js',
            vue_root: path.resolve(__dirname, './resources/app')
        }
    }
}
function getPerformance(){
    return {
        hints: false,
    }
}
function getPlugins(){
    return [
        defineProcessEnv(),
        extractScss,
        new FriendlyErrorsWebpackPlugin({ clearConsole: true }),
        getBrowserSyncPlugin(),
        getLoaderOptions()
    ]

    function getBrowserSyncPlugin(){
        return new BrowserSyncPlugin(
            {
                port: 3000,
                proxy: '0.0.0.0',
                open: false,
                host: 'localhost',
                files: [
                    'app/**/*.php',
                    'resources/views/**/*.php',
                    'public/js/**/*.js',
                    'public/css/**/*.css',
                ],
            },
            { reload: false }
        )
    }
    function getLoaderOptions(){
        return new webpack.LoaderOptionsPlugin({
            minimize: process.env.NODE_ENV === 'production',
            options: {
                context: __dirname,
                output: { path: './' }
            }
        })
    }
    function defineProcessEnv(){
        if(process.env.NODE_ENV === 'production'){
            return new webpack.DefinePlugin({
              'process.env': {
                NODE_ENV: '"production"'
              }
            })
        } else if(process.env.NODE_ENV === 'development'){
            return new webpack.DefinePlugin({
                'process.env': {
                    NODE_ENV: '"development"'
                }
            })
        }
    }
}

function addBrowserSyncPluginForDevelopment(){
    if (process.env.NODE_ENV !== 'production') {
        module.exports.plugins = (module.exports.plugins || []).concat([
            new BrowserSyncPlugin(
                {
                    port: 3000,
                    proxy: '0.0.0.0',
                    open: false,
                    host: 'localhost',
                    files: [
                        'app/**/*.php',
                        'resources/views/**/*.php',
                        'public/js/**/*.js',
                        'public/css/**/*.css',
                    ],
                },
                { reload: true }
            )
        ]);
    }
}

function addUglifyPluginForProduction(){
    if (process.env.NODE_ENV === 'production') {
      module.exports.plugins = (module.exports.plugins || []).concat([
        new UglifyJsPlugin({
          sourceMap: true,
          uglifyOptions: {
              compress: {
                  warnings: false
              }
          }
        })
      ])
    }
}

function addHashFileForProductionCacheBusting(){
    if (process.env.NODE_ENV === 'production' && process.env.BUILD_TARGET !== 'ios') {
        module.exports.plugins = (module.exports.plugins || []).concat([versionHashPlugin]);
    }

    function versionHashPlugin(){
        this.plugin("done", saveVersionHashToFile);

        function saveVersionHashToFile(buildStatsData){
            var buildStats = buildStatsData.toJson();
            var buildPath = files.context.build;
            var hashFileLocation = path.resolve(buildPath, './hash.json');
            fs.writeFileSync(hashFileLocation, `{"hash": "${buildStats.hash}"}`);
        }
    }

}
