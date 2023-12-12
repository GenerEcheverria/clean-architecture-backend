FROM mysql:8.0

ENV MYSQL_DATABASE clean
ENV MYSQL_ALLOW_EMPTY_PASSWORD=true
COPY ./script.sql /docker-entrypoint-initdb.d/

EXPOSE 3306