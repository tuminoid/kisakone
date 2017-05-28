FROM ubuntu:14.04.5

COPY docker /tmp/scripts

RUN /tmp/scripts/install-basics.sh
RUN /tmp/scripts/install-mysql.sh
RUN /tmp/scripts/install-apache.sh
RUN /tmp/scripts/install-postfix.sh
RUN /tmp/scripts/install-nodejs.sh
RUN /tmp/scripts/install-test-env.sh
RUN /tmp/scripts/configure.sh

VOLUME ["/var/lib/mysql"]
VOLUME ["/kisakone"]
EXPOSE 8080 8081

ENTRYPOINT ["/scripts/run_kisakone.sh"]

