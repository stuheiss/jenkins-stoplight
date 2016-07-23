# use "make serve "to start the php server
# to install phpmetrics, run "composer require --dev phpmetrics/phpmetrics"
all:
	@echo 'usage: make { serve | coverage | metrics }'
serve:
	@echo 'open a browser to http://localhost:8080/jenkins/refresh/15'
	php -S localhost:8080 -t public
coverage:
	codecept run unit --coverage --coverage-html
metrics:
	phpmetrics --config=phpmetrics.yml
