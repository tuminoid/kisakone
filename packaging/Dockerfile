FROM ubuntu:14.04
MAINTAINER Tuomo Tanskanen <tuomo@tanskanen.org>

RUN mkdir /kisakone
# EXPOSE 8080
# VOLUME /kisakone

COPY scripts /scripts

RUN /scripts/install-basics.sh
RUN /scripts/install-apache.sh
# RUN /scripts/install-nginx-hhvm.sh
RUN /scripts/install-mysql.sh
# RUN /scripts/install-nodejs.sh
# RUN /scripts/install-postfix.sh
# RUN /scripts/install-test-env.sh
RUN /scripts/configure.sh

CMD ["/entrypoint.sh"]
