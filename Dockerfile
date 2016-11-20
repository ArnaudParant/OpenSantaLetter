FROM debian:jessie

RUN apt-get update
RUN apt-get install -y apache2 php5 php-pear php5-mysql

ADD docker-entrypoint.sh docker-entrypoint.sh
RUN rm -rf /var/www/html
ADD src /var/www/html

RUN chown -R root:root /var/www/html

ENTRYPOINT ["./docker-entrypoint.sh"]
