FROM ubuntu:18.04

# Add the ENTRYPOINT script
ADD configs/start.sh /scripts/start.sh
ADD configs/bashrc /home/devceuma/.bashrc

ENV DEBIAN_FRONTEND noninteractive
RUN echo "---> Installing Dependencies..." \
    && apt-get update \
    && apt-get install --no-install-recommends -y \
        curl \
        wget \
        git \
        vim \
        nano \
        tzdata \
        unzip \
        gnupg \
        openssl \
        apt-transport-https \
        build-essential \
        make \
        unixodbc \
        unixodbc-dev \
        ca-certificates \
        apache2 \
        locales \
        libssl1.0.0 \
        libapache2-mod-php7.2 \
        php7.2 \
        php7.2-common \
        php7.2-mbstring \
        php7.2-dev \
        php7.2-xml \
        php7.2-gd \
        php7.2-opcache \
        php7.2-curl \
        php7.2-bz2 \
        php7.2-calendar \
        php7.2-ctype \
        php7.2-fpm \
        php7.2-gmp \
        php7.2-iconv \
        php7.2-imagick \
        php7.2-intl \
        php7.2-json \
        php7.2-mbstring \
        php7.2-mysql \
        php7.2-mongodb \
        php7.2-opcache \
        php7.2-pgsql \
        php7.2-sqlite3 \
        php7.2-xdebug \
        php7.2-xml \
        php7.2-xmlreader \
        php7.2-xsl \
        php7.2-zip \
        php7.2-cgi \
        php7.2-phpdbg \
        php-pear \
    && echo "---> Setting timezone for America / Fortaleza" && \
    && ln -fs /usr/share/zoneinfo/America/Fortaleza /etc/localtime && dpkg-reconfigure -f noninteractive tzdata \
    && echo "---> Configurando chaves do repositorio de instalacao dos Drives do SqlServer" && \
    && curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add - \
    && curl https://packages.microsoft.com/config/ubuntu/18.04/prod.list > /etc/apt/sources.list.d/mssql-release.list \
    && apt-get update \
    && echo "---> Finalizando configuracoes para o PHP" && \
    && ACCEPT_EULA=Y apt-get install -y msodbcsql17 mssql-tools \
    && echo 'export PATH="$PATH:/opt/mssql-tools/bin"' >> ~/.bash_profile \
    && echo 'export PATH="$PATH:/opt/mssql-tools/bin"' >> ~/.bashrc \
    && pecl install sqlsrv pdo_sqlsrv \
    && echo "extension=pdo_sqlsrv.so" >> `php --ini | grep "Scan for additional .ini files" | sed -e "s|.*:\s*||"`/30-pdo_sqlsrv.ini \
    && echo "extension=sqlsrv.so" >> `php --ini | grep "Scan for additional .ini files" | sed -e "s|.*:\s*||"`/20-sqlsrv.ini \
    && echo "extension=pdo_sqlsrv.so" >> /etc/php/7.2/mods-available/pdo_sqlsrv.ini \
    && echo "extension=sqlsrv.so" >> /etc/php/7.2/mods-available/sqlsrv.ini \
    && echo "extension=pdo_sqlsrv.so" >> /etc/php/7.2/apache2/conf.d/30-pdo_sqlsrv.ini \
    && echo "extension=sqlsrv.so" >> /etc/php/7.2/apache2/conf.d/20-sqlsrv.ini \
    && echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && locale-gen
ENV DEBIAN_FRONTEND teletype

RUN echo "---> Adding the devceuma user" \
 && adduser -D -u 1000 devceuma \
 && mkdir -p /var/www/app \
 && chown -R devceuma:devceuma /var/www
 #  && echo "---> Adding the Cygni user" \
 #  && adduser -q -u 1000 cygni \
 #  && usermod -aG www-data cygni \
 #  && mkdir -p /var/www/app \
 #  && chown -R cygni:cygni /var/www \
 #  && chown -R www-data:cygni /var/www \
 #  && chown -R www-data:cygni /etc/apache2 \
 #  && echo "cygni  ALL = ( ALL ) NOPASSWD: ALL" >> /etc/sudoers \
 #  && chown -R cygni:cygni /home/cygni

RUN echo "---> Configuring PHP" \
 && echo "devceuma  ALL = ( ALL ) NOPASSWD: ALL" >> /etc/sudoers \
 && sed -i "/user = .*/c\user = devceuma" /etc/php/7.2/fpm/pool.d/www.conf \
 && sed -i "/^group = .*/c\group = devceuma" /etc/php/7.2/fpm/pool.d/www.conf \
 && sed -i "/listen.owner = .*/c\listen.owner = devceuma" /etc/php/7.2/fpm/pool.d/www.conf \
 && sed -i "/listen.group = .*/c\listen.group = devceuma" /etc/php/7.2/fpm/pool.d/www.conf \
 # && sed -i "/listen = .*/c\listen = [::]:9000" /etc/php/7.2/fpm/pool.d/www.conf \
 # && sed -i "/;access.log = .*/c\access.log = /proc/self/fd/2" /etc/php/7.2/fpm/pool.d/www.conf \
 && sed -i "/;clear_env = .*/c\clear_env = no" /etc/php/7.2/fpm/pool.d/www.conf \
 && sed -i "/;catch_workers_output = .*/c\catch_workers_output = yes" /etc/php/7.2/fpm/pool.d/www.conf \
 && sed -i "/pid = .*/c\;pid = /run/php/php7.2-fpm.pid" /etc/php/7.2/fpm/php-fpm.conf \
 && sed -i "/;daemonize = .*/c\daemonize = yes" /etc/php/7.2/fpm/php-fpm.conf \
 && sed -i "/error_log = .*/c\error_log = /var/log/php7.2-fpm.log" /etc/php/7.2/fpm/php-fpm.conf \

 && echo "---> Configuring PHP Apache" \
 && sed -i "/post_max_size = .*/c\post_max_size = 1000M" /etc/php/7.2/apache2/php.ini \
 && sed -i "/upload_max_filesize = .*/c\upload_max_filesize = 1000M" /etc/php/7.2/apache2/php.ini \
 # && sed -i "/zend_extension=xdebug/c\;zend_extension=xdebug" /etc/php/7.2/apache2/conf.d/00_xdebug.ini \

 && echo "---> Configuring PHP CLI" \
 && sed -i "/post_max_size = .*/c\post_max_size = 1000M" /etc/php/7.2/cli/php.ini \
 && sed -i "/upload_max_filesize = .*/c\upload_max_filesize = 1000M" /etc/php/7.2/cli/php.ini \
 # && sed -i "/zend_extension=xdebug/c\;zend_extension=xdebug" /etc/php/7.2/cli/conf.d/00_xdebug.ini \

 && echo "---> Configuring PHP FPM" \
 && sed -i "/post_max_size = .*/c\post_max_size = 1000M" /etc/php/7.2/fpm/php.ini \
 && sed -i "/upload_max_filesize = .*/c\upload_max_filesize = 1000M" /etc/php/7.2/fpm/php.ini \
 # && sed -i "/zend_extension=xdebug/c\;zend_extension=xdebug" /etc/php/7.2/fpm/conf.d/00_xdebug.ini

RUN echo "---> Installing Composer" \
 && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
 && chmod +x /usr/local/bin/composer


RUN echo "---> Cleaning up" \
 && apt-get autoremove -y \
 && apt-get autoclean -y \
 && apt-get clean -y \
 && rm -rf /tmp/*

COPY configs/000-default.conf /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite && service apache2 restart

# # Define the running user
# USER devceuma

# Application directory
WORKDIR /var/www/html

# # Environment variables
# ENV PATH=/home/devceuma/.composer/vendor/bin:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin

EXPOSE 80

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
