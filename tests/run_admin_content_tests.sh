#!/bin/bash

# variable definition
# log file
readonly mlog=log_admin_content_tests.json
# default db socket for MAMP
readonly local_socket="/Applications/MAMP/tmp/mysql/mysql.sock"
# phpunit configuration file
readonly config_file=../administrator/components/com_content/Tests/phpunit.xml
# tests to be run
readonly testSuite=../administrator/components/com_content/Tests/.

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