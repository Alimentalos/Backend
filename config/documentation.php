<?php

return [

    'Official documentation' => [
        'Introduction' => 'Alimentalos is a open source project created to bring care and love to abandoned pets.',
        'Meanings' => [
            'Pet' => 'Animal cared by humans.',
            'User' => 'Human who has system access granted by credentials.',
            'Group' => 'System entity that allows you to link other resources.',
            'Location' => 'Physical space represented by a coordinate.',
            'Geofence' => 'Point composed polygon that frame a physical space.',
            'Issue' => 'In a practical sense a issue is something that must be resolved.'
        ],
        'Problem and solution' => [
            'Every day humans abandon or lose pets in the corners of the earth. Many people are worried daily about the care of these animals. We create a space to make visible these animals in a state of abandonment and allow their insertion in the community.'
        ],
        'Actors and resources' => [
            'You and others can be part of the change of consciousness. Find the grain of divinity in the gaze of its creation. The resources required are only food and time. Today there are specialized groups which are organized to provide care for these creatures. Participate and join a group, meet people and discover people with your same interests.'
        ],
    ],
    'Developer guide' => [
        'Introduction' => [
            'This documentation is aimed at providing notions to introduce a PHP code writer to the work of adding new improvements or maintaining existing code.',
            'If you felt identified by the description mentioned above then you have the ability to incorporate new lines of code into our humble book. To collaborate in the construction or improvement of the solution you do not need to have great knowledge in object-oriented programming or mathematics, in most cases the code is prepared in such a way that anyone can add their grain of sand knowing the rules of language of programming and proper English.',
        ],
        'Conventions' => [
            'Introduction' => [
                'A convention is a healthy agreement between two or more parties. For a common understanding. Our main convention is mutual respect and care of the environment.',
            ],
            'Specified' => [
                'Our code aspires to the highest quality, not in terms of performance but readability, although it considers performance in all cases.',
                'Software are built automatically so that all code will be subject to scrutiny of the tests defined according to the version or distribution.',
                'The acceptance of any change will depend mainly on the arguments. Any new addition will require the specification of new tests. Any modification will depend on its compatibility and impact on the system.',
                'The issue is the best way to solve code regarding problems with the community. Repositories are available to resolve conflicts, propose ideas or require help.',
            ]
        ],
        'Language and tools' => [
            'PHP and framework' => [
                'This project is built with Laravel using the latest version of PHP.',
                'We consume public libraries to not reinvent the wheel, at *all*.' => [
                    'The api of reactions is mainly built using the cybercog/laravel-love package.',
                    'The logic related to the insertion and search of geo-spatial data is implemented from the grimzy/laravel-mysql-spatial package.',
                    'The barryvdh/laravel-cors package avoids a couple of headaches related to the handling of authorization http headers related to origins (I think).',
                    'The unique identifiers generation is based on the implementation of webpatser/laravel-uuid package.',
                    'All other dependencies of project are described in composer.json and package.json file. Thanks to those who contributed. :)'
                ],
                ''
            ]
        ],
        'Installation' => [
            'Requisites' => [
                'PHP 7.4 and Composer 1.9.3.',
                'MySQL 8.0 running with fresh database and authorized access.',
                'Bash and git.'
            ],
            'Steps' => [
                'Clone using bash or github for windows.',
                'Install the dependencies using {composer install} command on project folder.',
                'Copy and configure the database environment variables from {.env.example} to {.env}.',
                'Run local server by running {php artisan serve} or {vendor/bin/phpunit} to run the suit of tests.',
            ]
        ],
        'Project structure' => [
            'Patterns' => [
                'This software was not built from premeditated design. Its structure was built from elaborate patterns along the way.',
                'But it is true that we respect the existing structures and patterns developed and recommended by the Laravel community.',
                'The application is built entirely on the app directory. In that directory you will find folders with patterns found and defined in the master branch.',
                'The {app} directory at its root includes the application models and a file with helper methods to simplify code development.',
                'The {app/Annotations} directory has the base definition from which the documentation of the API specification is generated.',
                'The {app/Asserts} directory contains traits with logical statements of comparison or verification of models or relationships between models.',
                'The {app/Attributes} directory contains traits with model related attributes of solution.',
                'The {app/Console} directory contains artisan command definitions.',
                'The {app/Contracts} directory contains interfaces of classes.',
                'The {app/Creations} directory contains traits with resource instance creation definitions.',
                'The {app/Events} directory contains solution related events.',
                'The {app/Http} directory contains all logic related to the HTTP layer.',
                'The {app/Lists} directory contains traits with model related indexing logic of solution.',
                'The {app/Observers} directory contains model observers.',
                'The {app/Policies} directory contains model policies.',
                'The {app/Procedures} directory contains model procedures.',
                'The {app/Procedures} directory contains model queries.',
                'The {app/Providers} directory contains the service providers of the application.',
                'The {app/Relationships} directory contains model relationships.',
                'The {app/Reports} directory contains logic responsible for generating reports.',
                'The {app/Repositories} directory contains libraries to easily access and interact with system resources.',
                'The {app/Rules} directory contains custom validation rules for HTTP requests.',
            ],
            'Models' => '',
            'Events' => '',
            'Relationships' => '',
            'Repositories' => '',
            'Lists' => '',
            'Authentication' => '',
            'Contracts' => '',
            'Attributes' => '',
            'Procedures' => '',
            'Policies' => '',
            'Observers' => '',
            'Asserts' => '',
            'Queries' => '',
            'Creations' => '',
            'Reports' => '',
            'HTTP' => '',
            'Annotations' => '',
            'Helpers' => '',
            'Tools' => '',
        ],
        'Collaboration' => '',
        'Criteria of acceptance' => '',
    ],
    'License' => ''
];
