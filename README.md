# Jenkins Stop Light #

This little toy app will query any number of Jenkins servers and display the last build status for all jobs.

Job status is displayed by a Stop Light image with the appropriate colored light lit up.

The screen will refresh after 10 seconds and repeat until you close the window.

## Use ##

Run the app with php 5.4 or newer built in server.

```php -S 127.0.0.1:8888 -t public```

Feel free to use a real webserver :-)

## Build ##

```composer install```

## Configure ##

Edit app/dependencies.php and set **$container['jenkins-servers']** to an array of servers you wish to monitor.

Ensure `var/` exists and is web writeable.

```mkdir var```

This app does not use a database but you will need to initialize a dummy sqlite database to get it to run.

```mkdir db; touch db/slim_starter.sqlite```

## Credits ##

This project was built using [slim-starter-kit](https://github.com/augusthur/slim-starter-kit) with minor enhancements to support sqlite3 from yours truly. Help yourself to my version of the same which includes my sqlite3 support. You can get it [here](https://github.com/stuheiss/slim-starter-kit).

Stop Light art courtesy of
[green](http://www.clker.com/cliparts/6/e/9/d/11949849761176136192traffic_light_green_dan__01.svg.med.png)
[yellow](http://www.clker.com/cliparts/8/1/7/4/11949849782053089133traffic_light_yellow_dan_01.svg.med.png)
[red](http://www.clker.com/cliparts/1/f/a/2/11949849771043985234traffic_light_red_dan_ge_01.svg.med.png) at [www.clker.com](http://www.clker.com).
