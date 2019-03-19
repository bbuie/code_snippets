### Initial Environment Setup
1. Make sure your Mac device has the [minimum Capacitor dependencies](https://capacitor.ionicframework.com/docs/getting-started/dependencies/) installed
    1. Specifically Node v8.6.9 on your mac, CocoaPods 1.5.3, and Xcode Command Line tools.
1. If you need to monitor network calls, use [Charles](https://www.charlesproxy.com/).
    - You'll need to install the [root certificates for IOS similators](https://www.charlesproxy.com/documentation/using-charles/ssl-certificates/). Then Enable SSL Proxying in the SSL Proxying Settings with a wildcard for both host and port.

### Building for Local iOS Development
1. Start up the docker containers following the steps outlined in the [docker docs](../README.md).
1. Open another terminal on your mac for the following commands
1. Make sure your node depencencies are installed locally on your mac (e.g. `npm install`)
1. Double check your `APP_URL` in your `.env` file and your `server.url` in `capacitor.config.json`
    - With Docker Toolbox, default values are already set
    - With Docker for Mac
        - `APP_URL=http://localhost`
        - `server.url="http://localhost"`
1. Sync project dependencies for the iOS app by running `npx cap sync`
1. Update the iOS build with any front-end file changes by running `npx cap copy`
1. Open the project in Xcode by running `npx cap open ios`
1. Build the application and run the simulator by clicking the "Play button" in Xcode (top left)

### Building Before Submitting for Review
1. Once your changes are ready to be submitted, you'll need to test the final code in the similator
1. Remove the server.url in capacitor.config.json (server.url is only for local development)
1. Update the index file: `node docker/ios/build-scripts/compile-index-file.js` (this step may not be necessary upon further testing)
1. Sync project dependencies for the iOS app by running `npx cap sync`
1. Update the iOS build with any front-end file changes by running `npx cap copy` on your mac
1. Open the project in Xcode by running `npx cap open ios` on your mac
1. Build the application and run the simulator by clicking the "Play button" in Xcode (top left)
1. Test your changes before

### Building for Production (or Staging)
1. Update the APP_URL in your .env file to point to the environment you're trying to build for
1. Update the index file: `node docker/ios/build-scripts/compile-index-file.js`
1. Update the build number
1. Then follow the same steps for "Final Testing for Local Development" except don't build
1. Set your target to "Generic iOS Device" (dropdown ro right of play button) and build
1. Select Product > Archive in Xcode
1. Click distribute app and select the apple store option