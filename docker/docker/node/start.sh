#!/bin/sh

echo "Running node-container's entrypoint file..."

echo "Modifying user (hack for mac)..."
usermod -u 1000 www-data #a hack for macs

echo "node-container is ready!"
npm run something-good