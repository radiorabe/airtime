<?php

/*
* Navigation container (config/array)

* Each element in the array will be passed to
* Zend_Navigation_Page::factory() when constructing
* the navigation container below.
*/
$pages = array(
    array(
        'label'      => _('Now Playing'),
        'module'     => 'default',
        'controller' => 'now-playing',
        'action'     => 'index',
        'resource'   => 'now-playing'
    ),
    array(
        'label'      => _('Add Media'),
        'module'     => 'default',
        'controller' => 'plupload',
        'action'     => 'index',
        'resource'   => 'plupload'
    ),
    array(
        'label'      => _('Library'),
        'module'     => 'default',
        'controller' => 'library',
        'action'     => 'index',
        'resource'   => 'playlist'
    ),
    array(
        'label'      => _('Calendar'),
        'module'     => 'default',
        'controller' => 'calendar',
        'action'     => 'index',
        'resource'   =>    'calendar'
    ),
    array(
        'label' => _('Radio Page'),
        'uri' => '/',
        'resource' => '',
        'pages' => array(
        )
    ),
    array(
        'label'      => _('System'),
        'uri'        => '#',
        'resource'   => 'preferences',
        'pages'      => array(
            array(
                'label'      => _('Preferences'),
                'module'     => 'default',
                'controller' => 'preferences'
            ),
            array(
                'label'      => _('Users'),
                'module'     => 'default',
                'controller' => 'user',
                'action'     => 'add-user',
                'resource'   => 'user'
            ),
            array(
                'label'      => _('Media Folders'),
                'module'     => 'default',
                'controller' => 'preferences',
                'action'     => 'directory-config',
                'id'         => 'manage_folder'
            ),
            array(
                'label'      => _('Streams'),
                'module'     => 'default',
                'controller' => 'preferences',
                'action'     => 'streams'
            ),
            array(
                'label'      => _('Support Feedback'),
                'module'     => 'default',
                'controller' => 'preferences',
                'action'     => 'support-setting'
            ),
            array(
                'label'      => _('Status'),
                'module'     => 'default',
                'controller' => 'system-status',
                'action'     => 'index',
                'resource'   => 'system-status'
            ),
            array(
                'label'      => _('Listener Stats'),
                'module'     => 'default',
                'controller' => 'listener-stats',
                'action'     => 'index',
                'resource'   => 'listener-stats'
            ),
            array(
                'label'      => _('Embeddable Widgets'),
                'module'     => 'default',
                'controller' => 'embeddablewidgets',
                'action'     => 'index'
            )
        )
    ),
	array(
		'label' => _('History'),
		'uri' => '#',
		'resource'   => 'playout-history',
		'pages'      => array(
			array(
				'label'      => _('Playout History'),
				'module'     => 'default',
				'controller' => 'playout-history',
				'action'     => 'index',
				'resource'   => 'playout-history'
			),
			array(
				'label'      => _('History Templates'),
				'module'     => 'default',
				'controller' => 'playout-history-template',
				'action'     => 'index',
				'resource'   => 'playout-history-template'
			),
		)
	),
    array(
        'label'      => _('Help'),
        'uri'     => '#',
        'resource'    =>    'dashboard',
        'pages'      => array(
            array(
                'label'      => _('Help Center'),
                'uri'        => "http://help.sourcefabric.org/",
                'target'     => "_blank"
            ),
            array(
                'label'      => _('Getting Started'),
                'module'     => 'default',
                'controller' => 'dashboard',
                'action'     => 'help',
                'resource'   =>    'dashboard'
            ),
            array(
                'label'      => _('User Manual'),
                'uri'        => "http://sourcefabric.booktype.pro/airtime-pro-for-broadcasters",
                'target'     => "_blank"
            ),
            array(
                'label'      => _('About'),
                'module'     => 'default',
                'controller' => 'dashboard',
                'action'     => 'about',
                'resource'   =>    'dashboard'
            )
        )
    ),
    array(
        'label' => _('Billing'),
        'uri' => '#',
        'resource' => 'billing',
        'pages' => array(
            array(
                'label' => _('Account Details'),
                'module' => 'default',
                'controller' => 'billing',
                'action' => 'client',
                'resource' => 'billing'
            ),
            array(
                'label' => _('Account Plans'),
                'module' => 'default',
                'controller' => 'billing',
                'action' => 'upgrade',
                'resource' => 'billing'
            ),
            array(
                'label' => _('View Invoices'),
                'module' => 'default',
                'controller' => 'billing',
                'action' => 'invoices',
                'resource' => 'billing'
            )
        )
    )
);


// Create container from array
$container = new Zend_Navigation($pages);
$container->id = "nav";

//store it in the registry:
Zend_Registry::set('Zend_Navigation', $container);
