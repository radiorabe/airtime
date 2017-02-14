mkdir -p /root/rpmbuild/SOURCES/
spectool -g -R /root/rpmbuild/SPECS/airtime.spec
rpmbuild -ba /root/rpmbuild/SPECS/airtime.spec
cd /root/rpmbuild/RPMS/x86_64
createrepo .
