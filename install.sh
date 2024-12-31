#!/bin/sh

php composer.phar update

exit_code=$?
echo "EXIT_CODE:$exit_code"
exit $exit_code