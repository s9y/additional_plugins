#!/bin/bash
rsync --dry-run \
      --exclude=.project --exclude=.cvsignore --exclude=SerendipityTranslator.zip --exclude=CVS --exclude=.git --exclude=homepage/by*.htm --exclude=homepage/template*.htm --exclude=homepage/box*.htm --exclude=homepage/last.txt \
      --archive --no-t --no-p --checksum -i --delete-after -v -z ~/cvs/serendipity/git/_additional_plugins/ ~/cvs/serendipity/additional_plugins   
            