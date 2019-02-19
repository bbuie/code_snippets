require('dotenv').config();
const Mustache = require('mustache');
const path = require('path');
const fs = require('fs');

const envOptions = {
    APP_URL: process.env.APP_URL
};
const indexTemplate = fs.readFileSync(path.resolve(__dirname, '../../../resources/views/mobile.index.html'));
const renderedIndexFile = Mustache.render(indexTemplate.toString(), envOptions);
fs.writeFileSync(path.resolve(__dirname, '../../../public/ios_build/index.html'), renderedIndexFile);