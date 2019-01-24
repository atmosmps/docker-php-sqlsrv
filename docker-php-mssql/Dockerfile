FROM ubuntu:18.04

ARG proxy
ARG sproxy
ARG no_proxy

ENV http_proxy="$proxy"
ENV https_proxy="$sproxy"
ENV no_proxy="$no_proxy"

RUN echo Acquire::http::Proxy "$proxy"; > /etc/apt/apt.conf.d/proxy.conf \
 && echo Acquire::https::Proxy "$sproxy"; >> /etc/apt/apt.conf.d/proxy.conf

ENV DEBIAN_FRONTEND noninteractive
RUN apt-get update \
    && apt-get install --no-install-recommends -y \
        curl \
        tzdata \
        gnupg \
        apt-transport-https \
        build-essential \
        unixodbc \
        unixodbc-dev \
        ca-certificates \
        apache2 \
        locales \
        libssl1.0.0 \
        libapache2-mod-php7.2 \
        php7.2 \
        php7.2-mbstring \
        php7.2-dev \
        php7.2-xml \
        php7.2-gd \
        php7.2-opcache \
        php7.2-curl \
        php-pear \
    && ln -fs /usr/share/zoneinfo/America/Fortaleza /etc/localtime && dpkg-reconfigure -f noninteractive tzdata \
    && curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add - \
    && curl https://packages.microsoft.com/config/ubuntu/18.04/prod.list > /etc/apt/sources.list.d/mssql-release.list \
    && apt-get update \
    && ACCEPT_EULA=Y apt-get install -y msodbcsql17 mssql-tools \
    && echo 'export PATH="$PATH:/opt/mssql-tools/bin"' >> ~/.bash_profile \
    && echo 'export PATH="$PATH:/opt/mssql-tools/bin"' >> ~/.bashrc \
    && pear config-set http_proxy $(printenv http_proxy) \
    && pecl install sqlsrv pdo_sqlsrv \
    && echo "extension=pdo_sqlsrv.so" >> /etc/php/7.2/mods-available/pdo_sqlsrv.ini \
    && echo "extension=pdo_sqlsrv.so" >> /etc/php/7.2/apache2/php.ini \
    && echo "extension=sqlsrv.so" >> /etc/php/7.2/mods-available/sqlsrv.ini \
    && echo "extension=sqlsrv.so" >> /etc/php/7.2/apache2/php.ini \
    && echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && locale-gen
ENV DEBIAN_FRONTEND teletype

RUN apt-get autoremove -y \
 && apt-get autoclean -y \
 && apt-get clean -y \
 && rm -rf /tmp/*

COPY configs/000-default.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite && service apache2 restart
EXPOSE 80
WORKDIR /var/www/html/
CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
