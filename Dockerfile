FROM tutum/apache-php

MAINTAINER andrewmcghienz@gmail.com

ENV GITHUB_OWNER mgoo
ENV GITHUB_REPO MovieServer
## The token can be obtained from https://github.com/settings/tokens
ENV GITHUB_TOKEN a290173bd91a150bed67ae07a79a26113735f59a
ENV GITHUB_BRANCH master
ENV GITHUB_RELEASE master

## installs curl and downloads the project from Github 
RUN apt-get install -y curl
RUN set -xe ;\
  curl -u $GITHUB_TOKEN:x-oauth-basic \ 
    -O -L https://github.com/$GITHUB_OWNER/$GITHUB_REPO/archive/$GITHUB_RELEASE.tar.gz ;\
    tar -xzvf $GITHUB_RELEASE.tar.gz -C /;\
    mv /MovieServer-$GITHUB_RELEASE /app;\
    mv /app/MovieServer-$GITHUB_RELEASE /app/movieserver;\
    rm $GITHUB_RELEASE.tar.gz    

## should start mod_rewriting
RUN a2enmod rewrite 

RUN chown -R www-data.www-data /var/www/html/*
RUN chmod 777 -R /app/*

EXPOSE 80 3306
CMD ["/run.sh"]

RUN usermod -u 505 www-data
RUN groupmod -g 10024 www-data
RUN chown -R www-data.www-data /app/