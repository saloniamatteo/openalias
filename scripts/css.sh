#!/bin/sh
# Re-download CSS (CirrusUI)
CSS_PATH="../resources/css"
CSS_NAME="cirrus.min.css"
CSS_FULL="$CSS_PATH/$CSS_NAME"
CSS_URL="https://cdn.jsdelivr.net/npm/cirrus-ui/dist/$CSS_NAME"

rm "$CSS_FULL"
wget "$CSS_URL" -O "$CSS_FULL"
