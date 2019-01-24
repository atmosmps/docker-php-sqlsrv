FROM ubuntu:18.04

# Add the ENTRYPOINT script
ADD configs/bashrc /home/cygni/.bashrc

ENV DEBIAN_FRONTEND noninteractive
RUN apt-get update \
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
        # php7.2-pdo \
        php7.2-mysql \
        php7.2-mongodb \
        php7.2-opcache \
        php7.2-pgsql \
        php7.2-sqlite3 \
        php7.2-xdebug \
        php7.2-xml \
        php7.2-xmlreader \
        # php7.2-openssl \
        php7.2-xsl \
        # php7.2-zlib \
        php7.2-zip \
        # php7.2-pcntl \
        php7.2-cgi \
        php7.2-phpdbg \
        php-pear \
    && ln -fs /usr/share/zoneinfo/America/Fortaleza /etc/localtime && dpkg-reconfigure -f noninteractive tzdata \
    && curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add - \
    && curl https://packages.microsoft.com/config/ubuntu/18.04/prod.list > /etc/apt/sources.list.d/mssql-release.list \
    && apt-get update \
    && ACCEPT_EULA=Y apt-get install -y msodbcsql17 mssql-tools \
    && echo 'export PATH="$PATH:/opt/mssql-tools/bin"' >> ~/.bash_profile \
    && echo 'export PATH="$PATH:/opt/mssql-tools/bin"' >> ~/.bashrc \
    # && pear config-set http_proxy $(printenv http_proxy) \
    && pecl install sqlsrv pdo_sqlsrv \
    && echo "extension=pdo_sqlsrv.so" >> /etc/php/7.2/mods-available/pdo_sqlsrv.ini \
    && echo "extension=pdo_sqlsrv.so" >> /etc/php/7.2/apache2/php.ini \
    && echo "extension=sqlsrv.so" >> /etc/php/7.2/mods-available/sqlsrv.ini \
    && echo "extension=sqlsrv.so" >> /etc/php/7.2/apache2/php.ini \
    && echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && locale-gen
ENV DEBIAN_FRONTEND teletype

RUN echo "---> Installing Composer" \
 && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
 && chmod +x /usr/local/bin/composer \
 && echo "---> Adding the Cygni user" \
 && adduser -q -u 1000 cygni \
 && usermod -aG www-data cygni \
 && mkdir -p /var/www/app \
 && chown -R cygni:cygni /var/www \
 && chown -R www-data:cygni /var/www \
 && chown -R www-data:cygni /etc/apache2 \
 && echo "cygni  ALL = ( ALL ) NOPASSWD: ALL" >> /etc/sudoers \
 && chown -R cygni:cygni /home/cygni

RUN echo "---> Cleaning up" \
 && apt-get autoremove -y \
 && apt-get autoclean -y \
 && apt-get clean -y \
 && rm -rf /tmp/*

COPY configs/000-default.conf /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite && service apache2 restart

# Define the running user
USER cygni

# Application directory
WORKDIR /var/www/app

# Environment variables
ENV PATH=/home/cygni/.composer/vendor/bin:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin

EXPOSE 80

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
