# Airtime RaBe Fork

Welcome to the RaBe Airtime fork. This fork contains fixes to get Airtime
up and running for use at rabe.ch.

It aims at being organized in a fashion so that the changes done to Airtime
are kept as atomic as possible while still offering a way to deploy our
proper Airtime RPMs from https://github.com/radiorabe/centos-rpm-airtime.

If you are looking to deploy Airtime on CentOS you will be better off by
visiting the RPM repo.

The original Airtime README file is available at [README](README).

We are aware that the contents heirein are structured in a rather difficult
to grasp fashion using lots of branches. Please do not hesitate to create
an issue or contact @hairmare if you need help with merging and/or rebasing.

## Main Features

* Make Airtime work out of the box on CentOS 7.3 and up
* Add missing integration points for the needs of a local community radio station
* Namely these focus on
  * Integration with studio playout equipment
  * Sending streams to an FM transmitter site and multiple DAB+ sites
  * Integration with other systems like Calendaring for a program grid

## Repo Organization

Since we want to be able to contribute our changes back this repo is organized
in a bunch of branches. New features get integrated onto their proper
`feature/` branch before being integrated with our main branch `rabe`.

We keep the features branches for reference and any fixes to given feature
are landed via those branches. This enables us to rebase feature branches
onto upstream and other interested parties to integrate our work into their
own fork with ease.

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

### Upstream Branches

We also keep upstream branches for posterity. The following links point to the
interesting branches.

* [upstream tracking `master`](https://github.com/radiorabe/airtime/tree/master)
* [upstream archival `saas`](https://github.com/radiorabe/airtime/tree/saas)

