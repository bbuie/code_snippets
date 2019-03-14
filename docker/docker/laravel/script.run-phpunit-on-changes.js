const chokidar = require('chokidar');
const path = require('path');
const ChildProcess = require('child_process');

const appDir = path.resolve(__dirname, '../../app');
const testDir = path.resolve(__dirname, '../../tests');
const routesDir = path.resolve(__dirname, '../../routes');
const configDir = path.resolve(__dirname, '../../config');

const watchedDirectories = [
    appDir,
    testDir,
    routesDir,
    configDir
];

var watcher = chokidar.watch(watchedDirectories, { usePolling: true, ignoreInitial: true });
watcher.on('add', runPhpUnit).on('change', runPhpUnit).on('unlink', runPhpUnit);

function runPhpUnit(){
    console.log('Files changed, running phpunit...');
    const phpunit = ChildProcess.spawn('vendor/bin/phpunit', [], { cwd: '/var/www/html' });
    phpunit.stdout.on('data', data => {
        process.stdout.write(`${data}`);
    });
    phpunit.stderr.on('data', error => {
        console.error(`${error}`);
    });
    phpunit.on('close', exit_code => {
        console.log('PHPUnit exited with code: '  exit_code);
        console.log('');
    });
}