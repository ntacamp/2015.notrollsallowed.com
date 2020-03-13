FROM ubuntu:18.04
RUN apt-get update && apt-get install -y nginx vim nano
COPY nginx.conf /etc/nginx/nginx.conf
ADD conf.d/*.conf /etc/nginx/conf.d/
WORKDIR /srv/www
EXPOSE 80
EXPOSE 443
CMD ["nginx"]
