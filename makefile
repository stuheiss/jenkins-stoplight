# use make to start the php server
serve:
	@echo 'open a browser to one of:'
	@echo '  http://localhost:8080/greet/person'
	@echo '  http://localhost:8080/query-db'
	@echo '  http://localhost:8080/send-mail'
	php -S localhost:8080 -t public
coverage:
	codecept run unit --coverage --coverage-html
metrics:
	phpmetrics --config=phpmetrics.yml
