#!/bin/sh

echo "Running dym-ios-build-container's entrypoint file..."

echo "Modifying user (hack for mac)..."
usermod -u 1000 www-data #a hack for macs

echo "Copying capacitor config file if it isn't already present...."
cp -n /var/www/html/docker/ios/DEFAULT-capacitor.config.json /var/www/html/capacitor.config.json

echo "Bulding index.html"
node './docker/ios/build.compile-index-file.js'

echo "Running webpack for iOS build..."
npm run sync-ios