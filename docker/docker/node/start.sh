#!/bin/sh

echo "Running company-node-container's entrypoint file..."

echo "Modifying user (hack for mac)..."
usermod -u 1000 www-data #a hack for macs

echo "company-node-container is ready!"
npm run something-good