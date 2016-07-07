# This dockerfile contains a runtime for building airtime rpms for centos7

# The resulting image may be used a a one-off build command and creates an rpm
# of airtime prepared in a fashion so it may be installed in a distributed
# fashion on centos using rh-scl http24 and php56-fpm as a backend.

FROM centos:7

RUN yum install -y rpm-build rpmdevtools createrepo

WORKDIR /usr/local/src/airtime

COPY Specfile /usr/local/src/airtime/Specfile
COPY build-rpm.sh /usr/local/src/airtime/build-rpm.sh

CMD ["bash", "/usr/local/src/airtime/build-rpm.sh"]
