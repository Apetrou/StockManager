var Encore = require('@symfony/webpack-encore');

Encore
// directory where all compiled assets will be stored
    .setOutputPath('public/build/')

    // what's the public path to this directory (relative to your project's document root dir)
    .setPublicPath('/build')

    // will output as build/app.js
    .addEntry('app', './public/assets/js/app.js')

    .enableBuildNotifications()
    .autoProvidejQuery()
    .enableSassLoader()

;

// export the final configuration
module.exports = Encore.getWebpackConfig();