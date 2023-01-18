#!/usr/bin/env bash

echo "Updating project from $BUILD_ENV ..."

git pull origin $BUILD_ENV

echo "copying env file..."
cp ../../config/.env.example .env

echo "starting container..."
docker-compose -f docker-compose-server.yml up --build -d

echo "done."

