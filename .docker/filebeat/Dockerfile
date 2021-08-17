FROM docker.elastic.co/beats/filebeat:7.14.0

COPY --chown=root:root filebeat.yml /usr/share/filebeat/filebeat.yml

USER root

RUN chmod go-w /usr/share/filebeat/filebeat.yml
