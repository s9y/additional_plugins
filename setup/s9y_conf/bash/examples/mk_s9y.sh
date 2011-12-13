#!/bin/bash
#
#
./s9y_conf.sh
if [ "X$?" != "X0" ]; then
    echo "ERROR in Config Script !"
    exit 1
fi
./s9y_install_shared.sh
apache2ctl reload
if [ "X$?" != "X0" ]; then
    echo "ERROR Reloading Apache2 !"
    exit 1
fi
exit 0
