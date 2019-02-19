### Initial Environment Setup
To get started building an iOS application, make sure your Mac device has the minimum Capacitor dependencies installed as listed in the [online documentation](https://capacitor.ionicframework.com/docs/getting-started/dependencies/)

### Building for iOS Development
1. Start up the docker containers following the steps outlined in the [docker docs.](../docker/README.md)
1. Once the ios-build-container is finished compiling, sync project dependencies for the iOS app by running `npx cap sync`
1. Update the iOS build with any front-end file changes by running `npx cap copy`
1. Open the project in Xcode by running `npx cap open ios`
1. Build the application and run the simulator by clicking the "Play button" in Xcode
1. The ios-build-container will compile any front-end changes you make, re-run `npx cap copy` and restart the simulator as needed to test changes.

For more information on Capacitor, consult the [online documentation](https://capacitor.ionicframework.com/docs/ios/)
**Note:** Make sure your `.env` file is configured with correct APP_URL for the target iOS deployment environment prior to building from docker, and that your copy of `capacitor.config.json` is configured to desired specifications
**Note:** For faster UI prototyping the app can be run from the local Laravel build by setting server.url to the location of your server in capacitor.config.json e.g. `"server": { "url": "192.168.99.100" }` this will allow the use of browsersync to hot reload changes, however, *all final testing and deployment should be done without the `url` field in the config file.*