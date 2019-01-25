FROM ubuntu:18.04

# # Define Config Proxy ENVs
# ARG proxy
# ARG sproxy
# ARG no_proxy

# ENV http_proxy="$proxy"
# ENV https_proxy="$sproxy"
# ENV no_proxy="$no_proxy"

# # Config Proxy For APT
# RUN touch /etc/apt/apt.conf.d/proxy.conf
# RUN echo Acquire::http::Proxy "$proxy"; > /etc/apt/apt.conf.d/proxy.conf
# RUN echo Acquire::https::Proxy "$sproxy"; >> /etc/apt/apt.conf.d/proxy.conf
# # update package list

# install curl and git
RUN apt update && apt install -y curl git

# install apache
RUN apt-get install -y apache2

# RUN add-apt-repository ppa:ondrej/php
# RUN apt-get update

ENV DEBIAN_FRONTEND noninteractive
RUN apt-get install -y tzdata \
    && ln -fs /usr/share/zoneinfo/America/Fortaleza /etc/localtime && dpkg-reconfigure -f noninteractive tzdata

# install php
RUN apt-get -y install php7.2 mcrypt php-mbstring php7.2-mysql php-pear php7.2-dev php7.2-xml php7.2-gd php7.2-opcache php7.2-curl --allow-unauthenticated
RUN apt-get install -y libapache2-mod-php7.2 

# install pre requisites
RUN apt-get update
RUN apt-get install -y apt-transport-https
RUN curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add -
RUN curl https://packages.microsoft.com/config/ubuntu/16.04/prod.list > /etc/apt/sources.list.d/mssql-release.list
RUN apt-get update
RUN ACCEPT_EULA=Y apt-get install -y msodbcsql17 mssql-tools
RUN echo 'export PATH="$PATH:/opt/mssql-tools/bin"' >> ~/.bash_profile
RUN echo 'export PATH="$PATH:/opt/mssql-tools/bin"' >> ~/.bashrc
# RUN source ~/.bashrc
RUN apt-get install unixodbc-dev
# RUN apt-get install -y unixodbc-utf16
# RUN apt-get install -y unixodbc-dev-utf16

#enabling pdo_mysql
# RUN phpenmod pdo_mysql

# install driver sqlsrv
RUN pecl install sqlsrv
RUN pecl install pdo_sqlsrv
# RUN echo extension=pdo_sqlsrv.so >> `php --ini | grep "Scan for additional .ini files" | sed -e "s|.*:\s*||"`/30-pdo_sqlsrv.ini
# RUN echo extension=sqlsrv.so >> `php --ini | grep "Scan for additional .ini files" | sed -e "s|.*:\s*||"`/20-sqlsrv.ini

# # load driver sqlsrv
# RUN echo "extension=/usr/lib/php/20170718/sqlsrv.so" >> /etc/php/7.2/apache2/php.ini
# RUN echo "extension=/usr/lib/php/20170718/pdo_sqlsrv.so" >> /etc/php/7.2/apache2/php.ini
# RUN echo "extension=/usr/lib/php/20170718/sqlsrv.so" >> /etc/php/7.2/cli/php.ini
# RUN echo "extension=/usr/lib/php/20170718/pdo_sqlsrv.so" >> /etc/php/7.2/cli/php.ini
# RUN echo "pdo_sqlsrv.client_buffer_max_kb_size=1000240" >> /etc/php/7.2/cli/php.ini
# RUN echo "sqlsrv.ClientBufferMaxKBSize = 1000240" >> /etc/php/7.2/cli/php.ini
RUN echo "extension=sqlsrv.so" > /etc/php/7.2/mods-available/sqlsrv.ini
RUN ln -s /etc/php/7.2/mods-available/sqlsrv.ini /etc/php/7.2/cli/conf.d/20-sqlsrv.ini
RUN echo "extension=pdo_sqlsrv.so" > /etc/php/7.2/mods-available/pdo_sqlsrv.ini
RUN ln -s /etc/php/7.2/mods-available/pdo_sqlsrv.ini /etc/php/7.2/cli/conf.d/30-pdo_sqlsrv.ini

# install composer
# RUN cd /usr/local/bin && curl -sS https://getcomposer.org/installer | php -- --filename=composer

# # Drush
# RUN cd /usr/local/src && git clone https://github.com/drush-ops/drush.git \
#       && cd /usr/local/src/drush \
#       && git checkout -b 8.x origin/8.x \
#       && composer install

# RUN ln -s /usr/local/src/drush/drush /usr/local/bin/drush

# # install ODBC Driver
# RUN ACCEPT_EULA=Y apt-get install -y msodbcsql
# RUN apt-get install -y mssql-tools
# RUN apt-get install -y unixodbc-dev
# RUN echo 'export PATH="$PATH:/opt/mssql-tools/bin"' >> ~/.bash_profile
# RUN echo 'export PATH="$PATH:/opt/mssql-tools/bin"' >> ~/.bashrc
# RUN exec bash

# install locales
RUN apt-get install -y locales && echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && locale-gen

# change default to port to 81
# RUN sed -i 's/80/81/g' /etc/apache2/ports.conf
#RUN sed -i 's/:80/:81/g' /etc/apache2/sites-available/000-default.conf
COPY configs/000-default.conf /etc/apache2/sites-available/000-default.conf

RUN apt-get install -y nano

# enable mod_rewrite
RUN a2enmod rewrite && service apache2 restart

EXPOSE 80

WORKDIR /var/www/html/

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
