#!/bin/bash
# [backup.sh]
# written 2005/09/27 by Alexander 'dma147' Mieland <dma147@linux-stats.org>
#

function usage {
	echo "Usage: ${0} <dir_to_backup> <backupdir> [excludes]"
}

if [ ! "${1}" -o "${1}" == "" ]; then
	usage
	exit 1
else
	DIR_TO_BACKUP="${1}"
fi

if [ ! "${2}" -o "${2}" == "" ]; then
	usage
	exit 1
else
	TARGET_DIR="${2}"
fi


OPT=" --exclude=${TARGET_DIR}"
c=0
for arg in "$@"; do
	if [ ${c} -ge 3 ]; then
		OPT="${OPT} --exclude=${arg}"
	fi
	c=$(( ${c} + 1  ))
done


DIR_TO_CHANGE=`echo ${DIR_TO_BACKUP} | sed -e 's/^\(.*\)\/[^\/]*$/\1/'`
DIR_TO_BACKUP=`echo ${DIR_TO_BACKUP} | sed -e 's/^.*\/\([^\/]*\)$/\1/'`

date=`date +%Y-%m-%d-%H-%M`

TAR=`which tar`
PWD=`pwd`

${TAR}${OPT} -czpf ${TARGET_DIR}/${date}_htmlbackup.tar.gz --directory=${DIR_TO_CHANGE} ./${DIR_TO_BACKUP} >/dev/null 2>&1 &
