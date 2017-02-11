from setuptools import setup
from subprocess import call
import sys
import os

script_path = os.path.dirname(os.path.realpath(__file__))
print script_path
os.chdir(script_path)

# Allows us to avoid installing the upstart init script when deploying on Airtime Pro:
if '--no-init-script' in sys.argv:
    data_files = []
    sys.argv.remove('--no-init-script') # super hax
else:
    pypo_files = []
    for root, dirnames, filenames in os.walk('pypo'):
        for filename in filenames:
            pypo_files.append(os.path.join(root, filename))
        
    data_files = []

setup(name='airtime-playout',
      version='1.0',
      description='Airtime Playout Engine',
      url='http://github.com/sourcefabric/Airtime',
      author='sourcefabric',
      license='AGPLv3',
      packages=['pypo', 'pypo.media', 'pypo.media.update',
                'liquidsoap', 'liquidsoap.library'],
      package_data={'': ['*.liq', '*.cfg']},
      scripts=[
          'bin/airtime-playout',
          'bin/airtime-liquidsoap',
          'bin/pyponotify'
      ],
      install_requires=[
          'amqplib',
          'anyjson',
          'configobj',
          'docopt',
          'kombu',
          'mutagen',
          'poster',
          'PyDispatcher',
          'pyinotify',
          'pytz',
          'requests'
      ],
      zip_safe=False,
      data_files=data_files)

# Reload the initctl config so that playout services works
if data_files:
    print "Reloading initctl configuration"
    #call(['initctl', 'reload-configuration'])
    print "Run \"sudo service airtime-playout start\" and \"sudo service airtime-liquidsoap start\""
