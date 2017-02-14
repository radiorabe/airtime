Building a RaBe Airtime RPM
===========================

This repo contains a docker environment that may be used to build a airtime rpm based on the source
of the radiorabe/airtime fork.

You can either directly use the Specfile with `spectool` and `rpmbuild` or run the whole shebang
through docker if you are on an environment that oes not have native rpm support.

Native RPM Building
-------------------

Run the following to create some RPMs on a RedHat/CentOS distro.

```bash
spectool -g -R Specfile
rpmbuild -ba Specfile
```

Docker RPM Building
-------------------

Run this agains any docker instance to build a complete yum repo containing the airtime RPMs.

```bash
docker build -t airtime-rpm . 
docker run --rm -ti --volume `pwd`/RPMS:/root/rpmbuild/RPMS airtime-rpm
```

In the above case the yum repo ends up in ./RPMS/x86_64
