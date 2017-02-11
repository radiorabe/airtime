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
* * Integration with studio playout equipment
* * Sending streams to an FM transmitter site and multiple DAB+ sites
* * Integration with other systems like Calendaring for a program grid

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

* [main `rabe` branch](https://github.com/radiorabe/centos/tree/master)

### Feature Branches

* [main `rabe` branch](https://github.com/radiorabe/centos/tree/master)

### Upstream Branches

We also keep upstream branches for posterity. The following links point to the
interesting branches.

* [upstream tracking `master`](https://github.com/radiorabe/centos/tree/master)
* [upstream archival `saas`](https://github.com/radiorabe/centos/tree/saas)

