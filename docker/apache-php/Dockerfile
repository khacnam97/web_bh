FROM centos:7.3.1611

ENV LANG ja_JP.UTF-8
ENV LANGUAGE ja_JP:ja
ENV LC_ALL ja_JP.UTF-8
# Install Apache
RUN yum -y update
RUN unlink /etc/localtime
RUN ln -s /usr/share/zoneinfo/Japan /etc/localtime

RUN localedef -f UTF-8 -i ja_JP ja_JP.UTF-8
RUN yum -y install httpd httpd-tools

# Install EPEL Repo
RUN rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm \
 && rpm -Uvh http://rpms.remirepo.net/enterprise/remi-release-7.rpm

# Install PHP
RUN yum --enablerepo=remi-php74 -y install php php-bcmath php-cli php-common php-gd php-intl php-ldap php-mbstring \
    php-mysqlnd php-pear php-soap php-xml php-xmlrpc php-zip

# Update Apache Configuration
RUN sed -E -i -e '/<Directory "\/var\/www\/html">/,/<\/Directory>/s/AllowOverride None/AllowOverride All/' /etc/httpd/conf/httpd.conf
RUN sed -E -i -e 's/DirectoryIndex (.*)$/DirectoryIndex index.php \1/g' /etc/httpd/conf/httpd.conf

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# UTC Timezone & Networking
RUN ln -sf /usr/share/zoneinfo/Asia/Tokyo /etc/localtime \
	&& echo "Asia/Tokyo" > /etc/timezone \
	&& echo "NETWORKING=yes" > /etc/sysconfig/network
RUN echo date.timezone=Asia/Tokyo >> /etc/php.ini
RUN echo post_max_size=100M >> /etc/php.ini
RUN echo upload_max_filesize=100M >> /etc/php.ini

# install xdebug and enable it. This block of code goes through the installion from source and compiling steps found
# on the xdebug website
# https://xdebug.org/docs/install

RUN yum --enablerepo=remi-php74 -y install php-xdebug


# add xdebug configurations
RUN { \
        echo '[xdebug]'; \
        echo 'zend_extension=/usr/lib64/php/modules/xdebug.so'; \
        echo 'xdebug.start_with_request=yes'; \
        echo 'xdebug.discover_client_host=true'; \
        echo 'xdebug.remote_cookie_expire_time = 3600'; \
		echo 'xdebug.idekey=PHPSTORM'; \
		echo 'xdebug.mode = debug'; \
        echo 'xdebug.remote_handler=dbgp'; \
        echo 'xdebug.profiler_enable=off'; \
        echo 'xdebug.profiler_output_dir="/var/www/html"'; \
        echo 'xdebug.client_port=9001'; \
        echo 'xdebug.client_host=192.168.7.123'; \
    } >> /etc/php.ini

RUN yum -y install python3
RUN yum -y install python3-devel
RUN pip3 install numpy matplotlib
RUN pip3 install openpyxl
EXPOSE 80

RUN export PYTHONIOENCODING=utf8
RUN yum -y install sudo unzip less

# Start Apache
CMD ["/usr/sbin/httpd","-D","FOREGROUND"]
