const config            = require('./config.js'); // node config
const webpack			= require('webpack');
const path				= require('path');
const autoprefixer      = require('autoprefixer');
const ip                = require('ip').address();

// recognizes certain classes of webpack errors and cleans, aggregates and prioritizes them to provide a better Developer Experience
// const FriendlyErrorsWebpackPlugin	= require('friendly-errors-webpack-plugin');

// const BundleAnalyzerPlugin 		    = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;

let entry = {};
for (const e of config.entry) entry[e] = `./${config.assets}/js/${e}.js`;

module.exports = {

	mode: 'development',

	// devtool: 'cheap-module-eval-source-map', // fastest, otherwise 'inline-source-map'
	// devtool: 'inline-cheap-module-source-map',
	// devtool: 'inline-module-source-map',
	devtool: 'cheap-module-source-map',

	context: path.resolve(__dirname, config.src),

	entry: entry,
	
	devServer: {
		https: true,
		disableHostCheck: true, // 3.1.14 hmr issues; quick fix
		host: config.localhost,
		port: config.port.webpack,
		historyApiFallback: true, // history api
		compress: true, // enable gzip compression
		headers: {
			"Access-Control-Allow-Origin": "*"
		}
	},

	output: {
		path: path.resolve(__dirname, config.src),
		filename: `${config.assets}/js/[name].bundle.js`,
		publicPath: `//${config.proxy ? ip : config.localhost}:${config.port.webpack}/`
	},

	plugins: [
		// Now the module names in console and in the source will be by name
		new webpack.NamedModulesPlugin(),
		new webpack.ProvidePlugin(config.dependencies),
		new webpack.DefinePlugin({
			'process.env.NODE_ENV': JSON.stringify('development')
		}),

		// new FriendlyErrorsWebpackPlugin(),
		// // fully interactive data visualization of our build
		// new BundleAnalyzerPlugin({
		// 	analyzerMode: 'static'
		// }),

	],

	module: {
		rules: [
			{
				test: /\.(jpg|png|gif|svg|mp4|mp3|ttf|eot|woff|woff2)$/,
				loader: 'url-loader',
				options: {
					limit: 8192, // 10000
					name: '[path][name].[ext]'
				}
			},
			{
				test: /\.scss$/,
				// to include other dir; e.g. ./modules/banners/banner-cta/style
				// include: path.resolve(__dirname, config.src),
				exclude: /node_modules/,
				use: [
					{
						loader: 'style-loader',
						options: {
							// to allow css before js
							// this fixes things like lazyload, animations..
							// singleton: true
						}
					},
					{
						loader: 'css-loader',
						options: {
							sourceMap: true, // if disabled, prevents FOUC/FOUT, sometimes works..
						}
					},
					'postcss-loader',
					{
						loader: 'sass-loader',
						options: {
							sourceMap: true
						}
					}
				]
			},
			{
				test: /\.js$/,
				exclude: /node_modules/,
				use: [
					{
						loader: 'babel-loader',
						options: {
							presets: ['@babel/preset-env']
						}
					}
				]
			}
		]
	}

};