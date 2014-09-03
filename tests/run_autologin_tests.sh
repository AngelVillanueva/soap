#!/bin/bash

# variable definition
# log file
readonly mlog=log_autologin_tests.json
# default db socket for MAMP
readonly local_socket="/Applications/MAMP/tmp/mysql/mysql.sock"
# phpunit configuration file
readonly config_file=../plugins/system/autologinurl/Tests/phpunit.xml
# tests to be run
readonly testSuite=../plugins/system/autologinurl/Tests/.

# delete previous log file
if [ -a "$mlog" ]
then
  rm "$mlog"
fi

# administrator com_content component tests
if [ -a "$local_socket" ]
then
  phpunit --stderr -d mysql.default_socket="$local_socket" --log-json "$mlog"  -c "$config_file" "$testSuite"
else
  phpunit --stderr --log-json "$mlog"  -c "$config_file" "$testSuite"
fi

exit