<?php return array(
    'root' => array(
        'pretty_version' => '1.0.0',
        'version' => '1.0.0.0',
        'type' => 'kirby-plugin',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'reference' => NULL,
        'name' => 'getkirby/pluginkit',
        'dev' => true,
    ),
    'versions' => array(
        'getkirby/composer-installer' => array(
            'pretty_version' => '1.2.1',
            'version' => '1.2.1.0',
            'type' => 'composer-plugin',
            'install_path' => __DIR__ . '/../getkirby/composer-installer',
            'aliases' => array(),
            'reference' => 'c98ece30bfba45be7ce457e1102d1b169d922f3d',
            'dev_requirement' => false,
        ),
        'getkirby/pluginkit' => array(
            'pretty_version' => '1.0.0',
            'version' => '1.0.0.0',
            'type' => 'kirby-plugin',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'reference' => NULL,
            'dev_requirement' => false,
        ),
    ),
);
