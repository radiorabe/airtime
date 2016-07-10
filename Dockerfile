# This dockerfile contains a runtime for building airtime rpms for centos7

# The resulting image may be used a a one-off build command and creates an rpm
# of airtime prepared in a fashion so it may be installed in a distributed
# fashion on centos using rh-scl http24 and php56-fpm as a backend.

FROM centos:7
RUN yum install -y epel-release
RUN yum install -y \
    rpm-build \
    rpmdevtools \
    createrepo \
    python-setuptools \
    python-pip \
    pytz \
    python-mutagen \
    python-kombu \
    python-anyjson \
    python-amqp \
    python-amqplib \
    python-argcomplete \
    python-six \
    python-docopt

WORKDIR /usr/local/src/airtime

COPY Specfile /root/rpmbuild/SPECS/airtime.spec
COPY build-rpm.sh /usr/local/bin/build-rpm.sh

CMD ["bash", "/usr/local/bin/build-rpm.sh"]
