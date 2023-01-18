FROM speklz/ubuntu-php8

COPY ./docker/run.sh /usr/local/bin/run.sh
RUN chmod +x /usr/local/bin/run.sh

WORKDIR /var/www/html
COPY . .

EXPOSE 80

CMD ["/usr/local/bin/run.sh"]
