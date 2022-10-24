#!/bin/bash

if [ -f ".env" ]; then
    source .env
fi

BASE_IMAGE=${SEI_APP_DOCKER_IMAGE-sei-app:3.1}
TAG_NAME=${SEI_APP_COMPLEMENTAR_DOCKER_IMAGE-sei-app-complementar:3.1}

docker build . --build-arg SEI_APP_DOCKER_IMAGE=$BASE_IMAGE -t "${TAG_NAME}"