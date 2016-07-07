mkdir -p /root/rpmbuild/SOURCES/
spectool -g -R /usr/local/src/airtime/Specfile
rpmbuild -ba /usr/local/src/airtime/Specfile
cd /root/rpmbuild/RPMS/x86_64
createrepo .
