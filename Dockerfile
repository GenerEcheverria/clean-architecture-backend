FROM ubuntu:20.04

# Set environment variable to avoid interactive prompts
ENV DEBIAN_FRONTEND=noninteractive

# Install dependencies
RUN apt-get update && apt-get install -y \
    software-properties-common \
    && add-apt-repository ppa:ondrej/php \
    && apt-get update \
    && apt-get install -y \
    nginx \
    php8.2-fpm \
    php8.2-mysql \
    mysql-server


RUN service mysql start \
    && mysql -e "CREATE DATABASE clean;" \
    && mysql -e "CREATE USER 'root'@'%' IDENTIFIED BY '';" \
    && mysql -e "ALTER USER 'root'@'%' IDENTIFIED WITH mysql_native_password BY '';" \
    && mysql -e "GRANT ALL PRIVILEGES ON clean.* TO 'root'@'%' WITH GRANT OPTION;" \
    && mysql -e "FLUSH PRIVILEGES;"


# Copy Nginx configuration file
COPY nginx.conf /etc/nginx/sites-enabled/

# Expose port 80
EXPOSE 80

# Copy MySQL startup script
COPY start-mysql.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/start-mysql.sh

# Run MySQL startup script
CMD start-mysql.sh && service php8.2-fpm start && nginx -g "daemon off;"
