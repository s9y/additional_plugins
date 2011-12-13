#!/bin/bash

TDAY=faq_`date +%Y%m%d%H%M`;
TDIR=`pwd`;
TDIR=`basename $TDIR`;

if [ -d $HOME/tmp ]; then
    mkdir $HOME/tmp/$TDIR;
    cp -R * $HOME/tmp/$TDIR;
    cd $HOME/tmp/;
    find ./$TDIR -type f -name "*~" -delete;
    tar czfv $TDAY.tar.gz $TDIR;
    rm -rf $TDIR;
    if [ ! -d $HOME/s9y/faq ]; then
        mkdir -p $HOME/s9y/faq/;
    fi
    mv $TDAY.tar.gz $HOME/s9y/faq/;
fi
