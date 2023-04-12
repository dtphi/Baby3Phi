#!/bin/bash

VIEW_TEMPLATE_ENV=$1

DIR_ADMIN="f:/gp_phucuong/public/administrator"
DIR_JS="/linhmucadmin-js"
DIR_ADMIN_TARGET="linhmucadmin"
DIR_ADMIN_IMAGES_TARGET="images"
DIR_ADMIN_JS_TARGET="js"
FILE_ADMIN_JS_ALL_TARGET="*.js"

cp ./dist/404.html $DIR_ADMIN$DIR_JS

cp -r ./dist/administrator/linhmucadmin-images/* $DIR_ADMIN/$DIR_ADMIN_TARGET-$DIR_ADMIN_IMAGES_TARGET
#check exist there is any file in the directory
FILE_JS_ALL_TARGET=$DIR_ADMIN/$DIR_ADMIN_TARGET-$DIR_ADMIN_JS_TARGET
if [[ -e  "$FILE_JS_ALL_TARGET" ]]; then
    echo "$FILE_JS_ALL_TARGET exists any the *.js file."
    # look for empty dir 
    if [ "$(ls -A $DIR_ADMIN$DIR_JS)" ]; then
        echo "Take action $DIR_ADMIN$DIR_JS is not Empty"
        rm -r $FILE_JS_ALL_TARGET/*.js
    else
        echo "$DIR_ADMIN$DIR_JS is Empty"
    fi
fi

cp -r ./dist/administrator/linhmucadmin-js/*.js $FILE_JS_ALL_TARGET

#copy to views
FILE_ADMIN_VIEW="f:/gp_phucuong/resources/views/adminlinhmuc-${VIEW_TEMPLATE_ENV}.blade.php"
cp -f ./dist/index.html $FILE_ADMIN_VIEW