###
# AUTOCARE SETTLEMENT
##

#!/bin/sh

#set this path to autocare root path
AUTOCARE_HOME='/var/www/autocare-bna'

SP="-----------------------------------------------------------------------------"

dt=$(date +"%Y-%m-%d %H:%M:%S")
echo "$dt AUTOCARE SETTLEMENT"

dt=$(date +"%Y-%m-%d %H:%M:%S")
echo "$dt locating AUTOCARE_HOME : $AUTOCARE_HOME"
cd $AUTOCARE_HOME

#export path to assign php
export PATH=/opt/lampp/bin:$PATH

PS=$(php artisan settlement:daily 2>&1)
echo "$PS"

dt=$(date +"%Y-%m-%d %H:%M:%S")
echo "$dt $SP"

