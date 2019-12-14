let mix = require('laravel-mix');

mix
    .js("resources/js/app.js", "dist/js")
    .sass("resources/sass/app.scss", "dist/css")
    .webpackConfig({
        module: {
            rules: [
                {
                    test: /\.tsx?$/,
                    loader: "ts-loader",
                    exclude: /node_modules/
                }
            ]
        },
        resolve: {
            extensions: ["*", ".js", ".jsx", ".vue", ".ts", ".tsx"]
        }
    });

