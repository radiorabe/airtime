# RaBe Airtime Fork

Welcome to the RaBe Airtime fork. This fork contains fixes to get Airtime
up and running for use at [Radio Bern RaBe](http://rabe.ch) on CentOS 7.

It aims at being organized in a fashion so that the changes done to Airtime
are kept as atomic as possible while still offering a way to build and 
deploy proper, working, Airtime RPMs.

We provide prebuilt binary packages part of the [home:radiorabe:airtime project](https://build.opensuse.org/project/show/home:radiorabe:airtime)
on the [openSUSE Build Service](https://build.opensuse.org/).

The original Airtime README file is available at [README](README).

## Main Features

* Make Airtime work out of the box on CentOS 7.3 and up
* Add missing integration points for the needs of a local community radio station
* Namely these focus on
  * Integration with studio playout equipment
  * Sending streams to an FM transmitter site and multiple DAB+ sites
  * Integration with other systems like Calendaring for a program grid

## Quickstart

The following instructions show how to get up and running quickly. To
deploy these packages on production you will have to review the default
policies of the packages and adapt them to your organizations policies.

### Install repositories

```bash
# install dependencies
yum install epel-release centos-release-scl

yum install http://li.nux.ro/download/nux/dextop/el7/x86_64/nux-dextop-release-0-5.el7.nux.noarch.rpm

curl -o /etc/yum.repos.d/home:radiorabe:liquidsoap.repo \
     http://download.opensuse.org/repositories/home:/radiorabe:/liquidsoap/CentOS_7/home:radiorabe:liquidsoap.repo

# install airtime repo
curl -o /etc/yum.repos.d/home:radiorabe:airtime.repo \
     http://download.opensuse.org/repositories/home:/radiorabe:/airtime/CentOS_7/home:radiorabe:airtime.repo
```

You need to make sure that you are installing the updated versions of 
python-kombu and python-amqp from the airtime repo and not their epel 
equivalents that have stopped working against current versions of 
rabbitmq.

### Database Setup

```bash
yum install postgresql-server

postgresql-setup initdb

patch /var/lib/pgsql/data/pg_hba.conf << EOD
--- /var/lib/pgsql/data/pg_hba.conf.orig2016-09-01 20:45:11.364000000 -0400
+++ /var/lib/pgsql/data/pg_hba.conf2016-09-01 20:46:17.939000000 -0400
@@ -78,10 +78,11 @@
 
 # "local" is for Unix domain socket connections only
 local   all             all                                     peer
+local   all             all                                     md5
 # IPv4 local connections:
-host    all             all             127.0.0.1/32            ident
+host    all             all             127.0.0.1/32            md5
 # IPv6 local connections:
-host    all             all             ::1/128                 ident
+host    all             all             ::1/128                 md5
 # Allow replication connections from localhost, by a user with the
 # replication privilege.
 #local   replication     postgres                                peer
EOD

systemctl enable postgresql
systemctl start postgresql

# create database user airtime with password airtime
useradd airtime
echo "airtime:airtime" | chpasswd

su -l postgres bash -c 'createuser airtime'
su -l postgres bash -c 'createdb -O airtime airtime'

echo "ALTER USER airtime WITH PASSWORD 'airtime';" | su -l postgres bash -c psql
echo "GRANT ALL PRIVILEGES ON DATABASE airtime TO airtime;" | su -l postgres bash -c psql
```

### RabbitMQ Setup

```bash
yum install https://github.com/rabbitmq/rabbitmq-server/releases/download/rabbitmq_v3_6_5/rabbitmq-server-3.6.5-1.noarch.rpm

systemctl enable rabbitmq-server
systemctl start rabbitmq-server

rabbitmqctl add_user airtime airtime
rabbitmqctl add_vhost /airtime
rabbitmqctl set_permissions -p /airtime airtime ".*" ".*" ".*"
```

### Airtime Web

* contains a feature patch to enable the <code>/api/show-playlist/id/<id></code> API.

```bash
yum install airtime-web

setsebool -P httpd_can_network_connect 1
setsebool -P httpd_execmem on # needed by liquidsoap to do stuff when called by php

mkdir /etc/airtime /srv/airtime /var/log/airtime/ /tmp/plupload
chcon -R -t httpd_sys_rw_content_t /etc/airtime/
chcon -R -t httpd_sys_rw_content_t /srv/airtime/
chcon -R -t httpd_sys_rw_content_t /var/log/airtime/
chcon -R -t httpd_sys_rw_content_t /tmp/plupload
chown -R apache /etc/airtime/ /srv/airtime/ /var/log/airtime/ /tmp/plupload

cat > /etc/php.d/99-tz.ini <<EOD
[main]
date.timezone=Europe/Zurich
EOD

systemctl enable httpd
systemctl start httpd

firewall-cmd --zone=public --add-port=80/tcp --permanent
firewall-cmd --reload
```

### Airtime Icecast

```bash
# TBD
```

### Airtime Playout

```bash
# TBD
```

### Airtime Liquidsoap

```bash
# TBD
```

### Airtime Media-Monitor

```bash
yum intall airtime-media-monitor

mkdir /srv/airtime/stor/{problem_files,organize,imported}
chown airtime-media-monitor:apache /srv/airtime/stor/{problem_files,organize,imported}
chmod g+w /srv/airtime/stor/{problem_files,organize,imported}

systemctl enable airtime-media-monitor
systemctl start airtime-media-monitor
```

### Airtime Silan

```bash
yum install airtime-silan

# run it manually
airtime-silan

# or let systemd run it once per hour
systemctl start airtime-silan.timer
systemctl enable airtime-silan.timer
```

## Repo Organization

Since we want to be able to contribute our changes back this repo is organized
in a bunch of branches. New features get integrated onto their proper
`feature/` branch before being integrated with our main branch `rabe`.

We keep the features branches for reference and any fixes to given feature
are landed via those branches. This enables us to rebase feature branches
onto upstream and other interested parties to integrate our work into their
own fork with ease.

We are aware that the contents herein are structured in a rather difficult
to grasp fashion using lots of branches. Please do not hesitate to create
an issue or contact @hairmare if you need help with merging and/or rebasing.

We are actively seeking a community managed upstream. Please open an
issue with a proposal if you feel that you are the right fit for us.

To help you get an overview the branches are listed below.

## Branch Overview

* [main `rabe` branch](https://github.com/radiorabe/airtime/tree/rabe) (you are here)

### Feature Branches

* [tls-support](https://github.com/radiorabe/airtime/tree/feature/tls-support)

  TLS support for secure access to airtime-web in the python api client and in
  API responses used by silan.

* [fix-media-monitor](https://github.com/radiorabe/airtime/tree/feature/fix-media-monitor)

  Lots of small fixes vor various bugs that should have been fixed in upstream ages ago.
  Mostly small stuff like wrong syntax in master and changes to opinionated decisions
  by upstream that do not fly at rabe.

* [remove-pref-cache](https://github.com/radiorabe/airtime/tree/feature/remove-pref-cache)

  The cache was badly broken at some stage and most likely never had any significant
  impact on preformance.

* [python-install](https://github.com/radiorabe/airtime/tree/feature/python-install)

  We remove most of the install routine not strictly doiny pythony stuff. This makes
  the project more portable while shifting the onerous task of maintaining distro
  specifics closer to the distro maintainers. We do this because we support
  CentOS and do not need any upstart files or whatnot.

* [ipa-support](https://github.com/radiorabe/airtime/tree/feature/ipa-support)

  Hacky patchset to switch the auth layer over to a freeIPA instance via some
  apache config. Highly experimental.

* [logging](https://github.com/radiorabe/airtime/tree/feature/logging)

  Fixes and changes to logging. Highly experimental.

* [playlist-api](https://github.com/radiorabe/airtime/tree/feature/playlist-api)

  Simple playlist API that allows other consumers to access complete listings of
  playlists created in airtime. Experimental.

* [systemd-files](https://github.com/radiorabe/airtime/tree/feature/systemd-files)

  SystemD units for running airtime components. All files are under `contrib/systemd`
  where packagers may or may not choose to install them from.

* [rpm-specfile](https://github.com/radiorabe/airtime/tree/feature/rpm-specfile)

  Contains airtime.spec used to build packages on openSUSE Build Service.

### Upstream Branches

We also keep upstream branches for posterity. The following links point to the
interesting branches.

* [upstream tracking `master`](https://github.com/radiorabe/airtime/tree/master)
* [upstream archival `saas`](https://github.com/radiorabe/airtime/tree/saas)

## Developing

Please direct your Pull Requests to the existing feature branches if applicable.

To create a new feature branch you base it on the `master` branch. We will then
merge it into the `rabe` branch and add it to the README in the merge commit.

Any changes on the rabe branch get packaged by the [home:radiorabe:airtime obs project](https://build.opensuse.org/project/show/home:radiorabe:airtime) as soon as they have
been properly released.

## Releasing

1. Bump the version in the Specfile and add a new commit to master with the version bump
2. Use `<airtime-ver>.<next-rabe-ver>` as the version number in a commit message similiar to existing versions
3. Tag the commit with the exact version
4. Push rabe and the tag to github
5. The openSUSE Build Service should get triggered and build a new package automagically

## License

The RaBe Airtime Fork is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, version 3 of the License.

## Copyright

Copyright (c) 2011-2017 Sourcefabric z.ú.

Copyright (c) 2016-2017 Radio Bern RaBe

Please refer to the original [README](README), [CREDITS](CREDITS) and [LICENSE_3RD_PARTY](LICENSE_3RD_PARTY) for more information.
