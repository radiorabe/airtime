from setuptools import setup
from subprocess import call
import sys
import os

script_path = os.path.dirname(os.path.realpath(__file__))
print script_path
os.chdir(script_path)

setup(name='airtime-media-monitor',
      version='1.0',
      description='Airtime Media Monitor',
      url='http://github.com/sourcefabric/Airtime',
      author='sourcefabric',
      license='AGPLv3',
      packages=['media_monitor', 'mm2', 'mm2.configs', 
                'mm2.media', 'mm2.media.monitor', 
                'mm2.media.metadata', 'mm2.media.saas'
                ],
      package_data={'': ['*.cfg']},
      scripts=['bin/airtime-media-monitor'],
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
          'pytz'
      ],
      zip_safe=False,
      data_files=[])
