#!/bin/zsh

# ANSI color codes
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
RESET='\033[0m'

if [ "$1" = "setup" ]; then
    echo -e "${YELLOW}[INFO] Running 'composer install'...${RESET}"
    composer install

    echo -e "${YELLOW}[INFO] Running 'pnpm install' on admin...${RESET}"
    cd admin; pnpm install; cd .. 

    if [ $? -eq 0 ]; then
        echo -e "${GREEN}[SUCCESS] Packages install completed successfully.${RESET}"
    else
        echo -e "${RED}[FAILED] Packages install failed. Check the logs for details.${RESET}"
        exit 1
    fi

    ./x.sh build

elif [ "$1" = "install" ]; then
    echo -e "${YELLOW}[INFO] Running 'composer install'...${RESET}"
    composer install --no-dev

    echo -e "${YELLOW}[INFO] Running 'pnpm install' on admin...${RESET}"
    cd admin; pnpm install; cd .. 

    if [ $? -eq 0 ]; then
        echo -e "${GREEN}[SUCCESS] Packages install completed successfully.${RESET}"
    else
        echo -e "${RED}[FAILED] Packages install failed. Check the logs for details.${RESET}"
        exit 1
    fi


elif [ "$1" = "build" ]; then
    echo -e "${YELLOW}[INFO] Running 'pnpm run build' on admin...${RESET}"
    cd admin; pnpm build; cd ..

    if [ $? -eq 0 ]; then
        echo -e "${GREEN}[SUCCESS] Build process completed successfully.${RESET}"
    else
        echo -e "${RED}[FAILED] Build process failed. Check the logs for details.${RESET}"
        exit 1
    fi

elif [ "$1" = "clean" ]; then
    rm -rf .zip.log
    rm -rf .prepare_plugin
    rm -rf vendor 
    rm -rf admin/.idea
    rm -rf admin/dist
    rm -rf admin/node_modules
    rm -rf .DS_Store

elif [ "$1" = "prepare" ]; then
    rm -rf plugin.zip 
    ./x.sh clean

    cp -r . .prepare_plugin
    cd .prepare_plugin

    ./x.sh install
    ./x.sh build 

    rm -rf admin/node_modules
    cd ..
 
elif [ "$1" = "zip" ]; then
    ./x.sh prepare
    ls -al

    echo -e "${YELLOW}[INFO] Zipping the .prepare_plugin...${RESET}"
    cd .prepare_plugin
    zip -r plugin.zip . > ~/.zip.log
    cp plugin.zip ..
    cd ..
    
    echo -e "${GREEN}[SUCCESS] Zipped the .prepare_plugin and created plugin.zip${RESET}"
    ./x.sh clean
    ./x.sh setup 

elif [ "$1" = "format" ]; then
    composer run-script format
    cd admin; pnpm format; cd ..
else
    echo -e "${RED}Invalid argument. Usage: $0 [install|build|clean|prepare|zip|format]${RESET}"
    exit 1
fi
