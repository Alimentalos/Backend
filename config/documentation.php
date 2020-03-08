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
            'Resource' => 'Is everything that can be systematically registered, listed, edited or deleted.'
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
                'Install the dependencies using `composer install` command on project folder.',
                'Copy and configure the database environment variables from `.env.example` to `.env`.',
                'Run local server by running `php artisan serve` or `vendor/bin/phpunit` to run the suit of tests.',
            ]
        ],
        'Project structure' => [
            'Patterns' => [
                'This software was not built from premeditated design. Its structure was built from elaborate patterns along the way.',
                'But it is true that we respect the existing structures and patterns developed and recommended by the Laravel community.',
                'The application is built entirely on the app directory. In that directory you will find folders with patterns found and defined in the master branch.',
                'The `app` directory at its root includes the application models and a file with helper methods to simplify code development.',
                'The `app/Annotations` directory has the base definition from which the documentation of the API specification is generated.',
                'The `app/Asserts` directory contains traits with logical statements of comparison or verification of models or relationships between models.',
                'The `app/Attributes` directory contains traits with model related attributes of solution.',
                'The `app/Console` directory contains artisan command definitions.',
                'The `app/Contracts` directory contains interfaces of classes.',
                'The `app/Creations` directory contains traits with resource instance creation definitions.',
                'The `app/Events` directory contains solution related events.',
                'The `app/Http` directory contains all logic related to the HTTP layer.',
                'The `app/Lists` directory contains traits with model related indexing logic of solution.',
                'The `app/Observers` directory contains model observers.',
                'The `app/Policies` directory contains model policies.',
                'The `app/Procedures` directory contains model procedures.',
                'The `app/Procedures` directory contains model queries.',
                'The `app/Providers` directory contains the service providers of the application.',
                'The `app/Relationships` directory contains model relationships.',
                'The `app/Reports` directory contains logic responsible for generating reports.',
                'The `app/Repositories` directory contains libraries to easily access and interact with system resources.',
                'The `app/Rules` directory contains custom validation rules for HTTP requests.',
                'The `app/Tools` directory contains custom classes of helpers.',
            ],
            'Models' => [
                'Location' => 'It is an entity that represents a geographical point, you can have extra data such as speed, odometer, and altitude if applicable.',
                'Pet' => 'It is the main discrete unit of the system. It corresponds to the logical entity of a living being listed as an animal. Has a direct relationship with who made the registration.',
                'Photo' => 'It is the representation of image type file. It is directly related to the user who uploaded it and to a photoable resource.',
                'User' => 'It is the representation of discrete entity that can perform operations on the platform.',
                'Group' => 'It is a logical representation of an entity that allows us to relate system resources.',
                'Geofence' => 'Is the logical representation of a polygon composed of geo-referenced points. It is related to animal, devices and users. It can also belong to a group.',
                'Device' => 'Is a logical representation of a traceable element, it can be a cell phone or a specialized device. It belongs to a user and can be public or private. Its scope can be reduced to the owner user or to the users belonging to a group in common with the device.',
                'Comment' => 'Is the written presentation of an idea, thought or emotion of a user in the community. It may be related to a resource or another comment. It has an optional title and a mandatory body.',
                'Access' => 'Is a logical representation of an in / out of resource in a geofence. Access is directly related to a resource through the accessible relationship. It also belongs to a geofence and has a double relationship with the location model to represent the beginning and end.',
                'Alert' => 'Is quite similar to a comment, the difference eradicated in the connotation of urgency between a simple comment and an announcement or request for help addressed to the entire community. It is directly related to a resource and user.',
                'Action' => 'It represents an operation executed in the system. Action has a direct relationship with a user, has parameters and resources referenced.',
            ],
            'Events' => [
                'Location' => 'The event is triggered when a system-locatable resource creates a new location. It is transmitted on the own resource channel. Inside it has details of the location and the related resource.',
                'GeofenceIn' => 'The event is triggered when it is detected that the resource has just entered in a geo-fence. Inside it has details about the geo-fence, the resource and the location.',
                'GeofenceOut' => 'The event is triggered when it is detected that the resource has came out of a geo-fence. Inside it has details about the geo-fence, the resource and the location.',
            ],
            'Relationships' => [
                'Commons' => [
                    'BelongsToUser' => 'This trait allows to relate a resource to a user, making a relationship of belongs to user.',
                    'Commentable' => 'This trait allows to create comments about a resource, making a relationship of morph many comments.',
                    'Geofenceable' => 'This trait allows to create relationships between a resource and a geo-fence, making a relationship of morph to many geofences.',
                    'Groupable' => 'This trait allows to create relationships between a resource and a group, making a relationship of morph to many groups.',
                    'HasPhoto' => 'This trait allows a resource to have photo, making a relationship of belong to photo.',
                    'Photoable' => 'This trait allows a photo to be related to a resource, making a relationship of morph to many photos.',
                    'Trackable' => 'This trait allows a resource to be traceable, making a relationship of morph many locations and accesses.',
                ],
                'Specified' => [
                    'AccessRelationships' => 'Related to Access, contains `accessible`, `first location` and `last location` relationships. The first of them is the resource with which access is related, it can be user, pet or device.',
                    'AlertRelationships' => 'Related to Alert, contains `alert`, the method which must resolve the type of resource with which the alert is associated.',
                    'CommentRelationships' => 'Related to Comment, contains `commentable`, the method which must resolve the type of resource with which the comment is associated.',
                    'GeofenceRelationships' => 'Related to Geofence, contains `geofenceable`, the method which must resolve the type of resource with which the geofence is associated. It also have the relationships `pets`, `devices` and `users`, which define the inverse relationship of those resources. The `accesses` relationship allows to obtain all the ingress or egress of the resources with respect to the geo-fence.',
                    'GroupRelationships' => 'Related to Group, contains `groupable`, the method which must resolve the type of resource with which the group is associated. It also have the relationships `pets`, `devices`, `geofences` and `users`, which define the inverse relationship of those resources.',
                    'LocationRelationships' => 'Related to Location, contains `trackable`, the method which must resolve the type of resource with which the location is associated.',
                    'PhotoRelationships' => 'Related to Photo, contains `photoable`, the method which must resolve the type of resource with which the group is associated. It also have the relationships `groups`, `users`, `alerts`, `geofences` and `pets`, which define the inverse relationship of those resources. The `comment` method resolve the comment associated with the photo.',
                    'UserRelationships' => 'Related to Photo, contains `photoable`, the method which must resolve the type of resource with which the group is associated. It also have the relationships `groups`, `users`, `alerts`, `geofences` and `pets`, which define the inverse relationship of those resources. The `comment` method resolve the comment associated with the photo.',
                ]
            ],
            'Repositories' => [
                'ActionsRepository' => 'It is responsible for all operations related to system actions such as resolution or insertion.',
                'AdminRepository' => 'It is responsible for containing the list of authorized administrators in production, as well as for resolving whether a user has administrator permissions.',
                'AlertsRepository' => 'It is responsible for all operations related to system alerts.',
                'CommentRepository' => 'It is responsible for all operations related to comments.',
                'DevicesRepository' => 'It is responsible for all operations related to devices.',
                'GeofenceRepository' => 'It is responsible for all operations related to geofences.',
                'GroupsRepository' => 'It is responsible for all operations related to groups.',
                'LocationsRepository' => 'It is responsible for all operations related to locations.',
                'PetsRepository' => 'It is responsible for all operations related to pets.',
                'PhotoRepository' => 'It is responsible for all operations related to photos.',
                'ReactionsRepository' => 'It is responsible for all operations related to reactions.',
                'ResourceCommentsRepository' => 'It is responsible for all operations related to resource comments.',
                'ResourceLocationsRepository' => 'It is responsible for all operations related to resource locations.',
                'ResourcePhotosRepository' => 'It is responsible for all operations related to resource photos.',
                'ResourceRepository' => 'It is responsible for all operations related to resources.',
                'UsersRepository' => 'It is responsible for all operations related to users.',
                'UserGroupsRepository' => 'It is responsible for all operations related to user groups.',
            ],
            'Lists' => [
                'ActionList' => 'It contains the two types of lists of existing actions in the system depending if it is a child user.',
                'AlertList' => 'It contains the method that resolves the list of alerts.',
                'DeviceList' => 'It contains the methods in charge of listing the information of the devices according to the groups that belong.',
                'GeofenceAccessesList' => 'It contains the method that allows retrieve the accesses corresponding to a specific geo-fence.',
                'GeofenceList' => 'It contains the two types of lists of existing geofences in the system depending if it is a child user.',
                'GroupList' => 'It contains the two types of lists of existing geofences in the system depending if it is a admin user.',
                'LocationList' => 'It contains the two types of lists of existing geofences in the system depending if user is finding or indexing.',
            ],
            'Authentication' => 'TODO (v2.0) will be support JWT',
            'Contracts' => 'TODO',
            'Attributes' => 'TODO',
            'Procedures' => 'TODO',
            'Policies' => 'TODO',
            'Observers' => 'TODO',
            'Asserts' => 'TODO',
            'Queries' => 'TODO',
            'Creations' => 'TODO',
            'Reports' => 'TODO',
            'HTTP' => 'TODO',
            'Annotations' => 'TODO',
            'Helpers' => 'TODO',
            'Tools' => 'TODO',
        ],
        'Collaboration' => '',
        'Criteria of acceptance' => '',
    ],
    'License' => 'MIT'
];
