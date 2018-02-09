#!/bin/bash

set -eux

BUILD_ID=${DOCKER_BUILD_ID:-latest}
DEST_IMAGE="kisakone"

TMP_DIR="$(mktemp --directory --tmpdir ${DEST_IMAGE}-docker_build-XXXXXX)"
TOP_DIR="$(readlink -f "$(dirname "$0")/..")"

cleanup()
{
    rm -rf "${TMP_DIR}"
}
trap cleanup EXIT

rsync -rt \
    "${TOP_DIR}/packaging/files" \
    "${TOP_DIR}/packaging/Dockerfile" \
    "${TOP_DIR}/packaging/scripts" \
    "${TMP_DIR}/"

# Build the image
docker build ${DOCKER_BUILD_OPT:-} --tag "${DEST_IMAGE}:${BUILD_ID}" "${TMP_DIR}"
