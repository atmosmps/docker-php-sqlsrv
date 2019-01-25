FROM php:7.3-apache

COPY configs/php.ini /usr/local/etc/php/
COPY configs/000-default.conf /etc/apache2/sites-available/

RUN a2enmod rewrite && \
    service apache2 restart

RUN apt-get update \
    && apt-get install -y \
        curl \
        apt-transport-https \
        unixodbc \
        unixodbc-dev \
        ca-certificates \
        tdsodbc \
        odbcinst \
        freetds-bin \
        freetds-common \
        && docker-php-ext-configure pdo_odbc --with-pdo-odbc=unixODBC,/usr \
        && docker-php-ext-install pdo_odbc

RUN mv /etc/odbcinst.ini /etc/odbcinst.ini.bak && \
    cp /usr/share/tdsodbc/odbcinst.ini /etc/

ENV DEBIAN_FRONTEND noninteractive
RUN apt-get install -y tzdata \
    && ln -fs /usr/share/zoneinfo/America/Fortaleza /etc/localtime && dpkg-reconfigure -f noninteractive tzdata

WORKDIR /var/www/html
