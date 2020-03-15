<?php

return [

    'Project' => [
        'Introduction' => [
            'Alimentalos is a open source project created to bring care and love to abandoned pets.'
        ],
        'Problem and solution' => [
            'Introduction' => 'Every day humans abandon or lose pets in the corners of the earth. Many people are worried daily about the care of these animals. We create a space to make visible these animals in a state of abandonment and allow their insertion in the community.'
        ],
        'Actors and resources' => [
            'Introduction' => 'You and others can be part of the change of consciousness. Find the grain of divinity in the gaze of its creation. The resources required are only food and time. Today there are specialized groups which are organized to provide care for these creatures. Participate and join a group, meet people and discover people with your same interests.'
        ],
        'Terms' => [
            'Introduction' => '...',
            'Meanings' => [
                'Pet' => 'Animal cared by humans.',
                'User' => 'Human who has system access granted by credentials.',
                'Group' => 'System entity that allows you to link other resources.',
                'Location' => 'Physical space represented by a coordinate.',
                'Geofence' => 'Point composed polygon that frame a physical space.',
                'Resource' => 'Is everything that can be systematically registered, listed, edited or deleted.'
            ]
        ],
    ],
    'Developer handbook' => [
        'Introduction' => [
            'This documentation is aimed at providing notions to introduce a PHP code writer to the work of adding new improvements or maintaining existing code.',
            'If you felt identified by the description mentioned above then you have the ability to incorporate new lines of code into our humble book. To collaborate in the construction or improvement of the solution you do not need to have great knowledge in object-oriented programming or mathematics, in most cases the code is prepared in such a way that anyone can add their grain of sand knowing the rules of language of programming and proper English.',
        ],
        'Conventions' => [
            'Resume' => [
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
                'We consume public libraries to not reinvent the wheel, at *all*...',
                [
                    '- The api of reactions is mainly built using the cybercog/laravel-love package.',
                    '- The logic related to the insertion and search of geo-spatial data is implemented from the grimzy/laravel-mysql-spatial package.',
                    '- The barryvdh/laravel-cors package avoids a couple of headaches related to the handling of authorization http headers related to origins (I think).',
                    '- The unique identifiers generation is based on the implementation of webpatser/laravel-uuid package.',
                ],
                'All other dependencies of project are described in composer.json and package.json file.',
                'Thanks to those who contributed. :)'
            ]
        ],
        'Installation' => [
            'Requisites' => [
                '- PHP 7.4 and Composer 1.9.3.',
                '- MySQL 8.0 running with fresh database and authorized access.',
                '- Bash and git.'
            ],
            'Steps' => [
                '1. Clone using bash or github for windows.',
                '2. Install the dependencies using `composer install` command on project folder.',
                '3. Copy and configure the database environment variables from `.env.example` to `.env`.',
                '4. Run local server by running `php artisan serve` or `vendor/bin/phpunit` to run the suit of tests.',
            ]
        ],
        'Project structure' => [
            'Patterns' => [
                'This software was not built from premeditated design. Its structure was built from elaborate patterns along the way.',
                'But it is true that `we respect the existing structures and patterns` developed and recommended by the Laravel community.',
                'The application is built entirely on the app directory. In that directory you will find folders with patterns found and defined in the `master` branch.',
                'Directories' => [
                    '`app` directory at its root includes the application models and a file with helper methods to simplify code development.',
                    '`app/Annotations` directory has the base definition from which the documentation of the API specification is generated.',
                    '`app/Asserts` directory contains traits with logical statements of comparison or verification of models or relationships between models.',
                    '`app/Attributes` directory contains traits with model related attributes of solution.',
                    '`app/Console` directory contains artisan command definitions.',
                    '`app/Contracts` directory contains interfaces of classes.',
                    '`app/Creations` directory contains traits with resource instance creation definitions.',
                    '`app/Events` directory contains solution related events.',
                    '`app/Http` directory contains all logic related to the HTTP layer.',
                    '`app/Lists` directory contains traits with model related indexing logic of solution.',
                    '`app/Observers` directory contains model observers.',
                    '`app/Policies` directory contains model policies.',
                    '`app/Procedures` directory contains model procedures.',
                    '`app/Procedures` directory contains model queries.',
                    '`app/Providers` directory contains the service providers of the application.',
                    '`app/Relationships` directory contains model relationships.',
                    '`app/Reports` directory contains logic responsible for generating reports.',
                    '`app/Repositories` directory contains libraries to easily access and interact with system resources.',
                    '`app/Rules` directory contains custom validation rules for HTTP requests.',
                    '`app/Tools` directory contains custom classes of helpers.',
                ]
            ],
            'Models' => [
                'Location' => ['It is an entity that represents a `geographical point`, you can have extra data such as `speed`, `odometer`, and `altitude` if applicable.'],
                'Pet' => ['It is the main `discrete unit` of the system. It corresponds to the logical entity of a living being listed as an animal. Has a direct relationship with who made the registration.'],
                'Photo' => ['It is the representation of `image` type file. It is directly related to the user who uploaded it and to a photoable resource.'],
                'User' => ['It is the representation of `discrete entity` that can perform operations on the platform.'],
                'Group' => ['It is a logical representation of an entity that allows us to `relate resources`.'],
                'Geofence' => ['Is the logical representation of a `polygon` composed of geo-referenced points. It is related to animal, devices and users. It can also belong to a group.'],
                'Device' => ['Is a logical representation of a traceable element, it can be a cell phone or a specialized device. It belongs to a user and can be `public` or `private`. Its scope can be reduced to the owner user or to the users belonging to a group in common with the device.'],
                'Comment' => ['Is the written presentation of an `idea`, `thought` or `emotion` of a user in the community. It may be related to a resource or another comment. It has an optional title and a mandatory body.'],
                'Access' => ['Is a logical representation of an `in` or `out` of resource in a geofence. Access is directly related to a resource through the accessible relationship. It also belongs to a geofence and has a double relationship with the location model to represent the beginning and end.'],
                'Alert' => ['Is quite similar to a comment, the difference eradicated in the connotation of `urgency` between a simple comment and an announcement or `request for help` addressed to the entire community. It is directly related to a resource and user.'],
                'Action' => ['It represents an `operation executed` in the system. Action has a direct relationship with a user, has parameters and resources referenced.'],
            ],
            'Events' => [
                'Location' => 'The event is triggered when a system-locatable resource creates a new location. It is transmitted on the own resource channel. Inside it has details of the location and the related resource.',
                'GeofenceIn' => 'The event is triggered when it is detected that the resource has just entered in a geo-fence. Inside it has details about the geo-fence, the resource and the location.',
                'GeofenceOut' => 'The event is triggered when it is detected that the resource has came out of a geo-fence. Inside it has details about the geo-fence, the resource and the location.',
            ],
            'Relationships' => [
                'Commons' => [
                ],
                ' BelongsToUser' => [
                    'This trait allows to relate a `resource` to a `user`.',
                    'Making a relationship of `belongs to user`.'
                ],
                ' Commentable' => [
                    'This trait allows to create `comments` of a `resource`.',
                    'Making a relationship of `morph many comments`.'
                ],
                ' Geofenceable' => [
                    'This trait allows to create relationships between a `resource` and a `geofence`.',
                    'Making a relationship of `morph to many geofences`.'
                ],
                ' Groupable' => [
                    'This trait allows to create relationships between a `resource` and a `group`.',
                    'Making a relationship of `morph to many groups`.'
                ],
                ' HasPhoto' => [
                    'This trait allows a `resource` to have one `photo`.',
                    'Making a relationship of `belong to photo`.'
                ],
                ' Photoable' => [
                    'This trait allows a `photo` to be related to `resource`.',
                    'Making a relationship of `morph to many photos`.'
                ],
                ' Trackable' => [
                    'This trait allows a `resource` to be traceable.',
                    'Making a relationship of `morph many locations and accesses`.'
                ],
                'Specified' => [
                ],
                ' AccessRelationships' => [
                    'Related to Access, contains `accessible`, `first location` and `last location` relationships. The first of them is the resource with which access is related, it can be user, pet or device.'
                ],
                ' AlertRelationships' => [
                    'Related to Alert, contains `alert`, the method which must resolve the type of resource with which the alert is associated.'
                ],
                ' CommentRelationships' => [
                    'Related to Comment, contains `commentable`, the method which must resolve the type of resource with which the comment is associated.'
                ],
                ' GeofenceRelationships' => [
                    'Related to Geofence, contains `geofenceable`, the method which must resolve the type of resource with which the geofence is associated. It also have the relationships `pets`, `devices` and `users`, which define the inverse relationship of those resources. `accesses` relationship allows to obtain all the ingress or egress of the resources with respect to the geo-fence.'
                ],
                ' GroupRelationships' => [
                    'Related to Group, contains `groupable`, the method which must resolve the type of resource with which the group is associated. It also have the relationships `pets`, `devices`, `geofences` and `users`, which define the inverse relationship of those resources.'
                ],
                ' LocationRelationships' => [
                    'Related to Location, contains `trackable`, the method which must resolve the type of resource with which the location is associated.'
                ],
                ' PhotoRelationships' => [
                    'Related to Photo, contains `photoable`, the method which must resolve the type of resource with which the group is associated. It also have the relationships `groups`, `users`, `alerts`, `geofences` and `pets`, which define the inverse relationship of those resources. `comment` method resolve the comment associated with the photo.'
                ],
                ' UserRelationships' => [
                    'Related to Photo, contains `photoable`, the method which must resolve the type of resource with which the group is associated. It also have the relationships `groups`, `users`, `alerts`, `geofences` and `pets`, which define the inverse relationship of those resources. `comment` method resolve the comment associated with the photo.'
                ],
            ],
            'Repositories' => [
                'ActionsRepository' => [
                    'Responsible of all operations related to `actions` such as resolution or insertion.',
                    '> This repository is available using `actions()` function.'
                ],
                'AdminRepository' => [
                    'Responsible to list the authorized `administrators` in production, as well as for resolving whether a user has administrator permissions.',
                    '> This repository is available using `admin()` function.'
                ],
                'AlertsRepository' => [
                    'Responsible of all operations related to system `alerts`.',
                    '> This repository is available using `alerts()` function.'
                ],
                'CommentRepository' => [
                    'Responsible of all operations related to `comments`.',
                    '> This repository is available using `comments()` function.'
                ],
                'DevicesRepository' => [
                    'Responsible of all operations related to `devices`.',
                    '> This repository is available using `devices()` function.'
                ],
                'GeofenceRepository' => [
                    'Responsible of all operations related to `geofences`.',
                    '> This repository is available using `geofences()` function.'
                ],
                'GroupsRepository' => [
                    'Responsible of all operations related to `groups`.',
                    '> This repository is available using `groups()` function.'
                ],
                'LocationsRepository' => [
                    'Responsible of all operations related to `locations`.',
                    '> This repository is available using `locations()` function.'
                ],
                'PetsRepository' => [
                    'Responsible of all operations related to `pets`.',
                    '> This repository is available using `pets()` function.'
                ],
                'PhotoRepository' => [
                    'Responsible of all operations related to `photos`.',
                    '> This repository is available using `photos()` function.'
                ],
                'ReactionsRepository' => [
                    'Responsible of all operations related to `reactions`.',
                    '> This repository is available using `reactions()` function.'
                ],
                'ResourceCommentsRepository' => [
                    'Responsible of all operations related to `resource comments`.',
                    '> This repository is available using `resourceComments()` function.'
                ],
                'ResourceLocationsRepository' => [
                    'Responsible of all operations related to `resource locations`.',
                    '> This repository is available using `resourceLocations()` function.'
                ],
                'ResourcePhotosRepository' => [
                    'Responsible of all operations related to `resource photos`.',
                    '> This repository is available using `resourcePhotos()` function.'
                ],
                'ResourceRepository' => [
                    'Responsible of all operations related to `resources`.',
                    '> This repository is available using `resources()` function.'
                ],
                'UsersRepository' => [
                    'Responsible of all operations related to `users`.',
                    '> This repository is available using `users()` function.'
                ],
                'UserGroupsRepository' => [
                    'Responsible of all operations related to `user groups`.',
                    '> This repository is available using `userGroups()` function.'
                ],
            ],
            'Lists' => [
                'ActionList' => ['Contains the methods which resolves the `actions` list depending if is a `child user`.'],
                'AlertList' => ['Contain the method which resolves the list of `alerts`.'],
                'DeviceList' => ['Contains the methods which resolves the `devices` list scoped for `authenticated user`.'],
                'GeofenceAccessesList' => ['Contains the method which retrieve the `accesses` of a specific `geofence`.'],
                'GeofenceList' => ['Contains the two methods which resolves the `geofences` list depending if is a `child user`.'],
                'GroupList' => ['Contains the two methods which resolves the `groups` list depending if is a `admin user`.'],
                'LocationList' => ['Contains the two methods which retrieves `locations` depending if user is `finding` or `indexing`.'],
            ],
            // TODO Add JWT documentation explanation and reference
            'Authentication' => [
                'To obtain an access token you must first create a user using the user registration API.',
                'To perform operations on the system you must log in by sending your credentials to the Token API. You will get two codes, one to access the system and another to refresh the access token.',
                'Sending `Bearer ACCESS_TOKEN` on `Authorization` header of `HTTP` request, header `Accept` with value `application/json` is required.'
            ],
            'Contracts' => [
                'Resource' => [
                    'Ensures the implementation of `getLazyRelationshipsAttribute`, `getInstances`, `getAvailableReactions`, `storeRules` and `updateRules` methods.',
                ],
                'CreateFromRequest' => [
                    'Ensures the implementation of the `createViaRequest` methods.',
                ],
                'UpdateFromRequest' => [
                    'Ensures the implementation of the `updateViaRequest` methods.',
                ],
                'CanCreateReports' => [
                    'Ensures the implementation of `retrieve` and `retrieveRequiredParameters` methods.',
                ],
            ],
            'Attributes' => [
                'AlertAttribute' => [
                    'Contains `types` and `alertTypes` methods, including constant types as attributes.',
                ],
                'PetAttribute' => [
                    'Contains constant `pet` sizes as attributes.',
                ],
            ],
            'Procedures' => [
                'Procedures are `traits` of resource related repositories. Describes common or exclusive `resource type behaviors`.'
            ],
            'Policies' => [
                'Policies are `gates to authorize` actions over resources.',
                'Read more in official [docs](https://laravel.com/docs/6.x/authorization#creating-policies).'
            ],
            'Observers' => [
                'Observers are `lifecycle object events handlers` of resources.',
                'Read more in official [docs](https://laravel.com/docs/6.x/eloquent#observers).'
            ],
            'Asserts' => [
                'Asserts are `common` or `exclusive` logical checks of resources.',
                'This pattern reduces `code complexity` of big files.',
                'This is `project` exclusive pattern.'
            ],
            'Queries' => [
                'Queries are `exclusive` query builder filter of resources.',
                'This pattern reduces `code complexity` of big files.',
                'This is `project` exclusive pattern.'
            ],
            'Creations' => [
                'Creations are `exclusive` instance creation implementations of resources.',
                'This pattern reduces `code complexity` of big files.',
                'This is `project` exclusive pattern.'
            ],
            'Reports' => [
                'This feature is under construction since different types of trackable resources were incorporated.',
                'This is `project` exclusive feature.'
            ],
            'HTTP' => [
                'This folder has common laravel `Http` application structure. `Controllers`, `Requests` and `Resources` of `http` layer are available there.',
                'Code is completely refactored to handle the `index`, `create`, `update` or `delete` of resources and also `their relations with other resources`.'
            ],
            'Annotations' => [
                'The documentation of our API is constructed from the existing OpenApi notations in the `doc blocks` of the application controllers.',
                'In this directory is the base notation from which the documentation is constructed.'
            ],
            'Helpers' => [
                'Helpers are global scoped functions, to make code simple and readable.',
                [
                    '`admin()`' => [
                        'Creates `AdminRepository` instance.',
                    ],
                    '`actions()`' => [
                        'Creates `ActionsRepository` instance.',
                    ],
                    '`devices()`' => [
                        'Creates `DevicesRepository` instance.',
                    ],
                    '`users()`' => [
                        'Creates `UsersRepository` instance.',
                    ],
                    '`pets()`' => [
                        'Creates `PetsRepository` instance.',
                    ],
                    '`comments()`' => [
                        'Creates `CommentsRepository` instance.',
                    ],
                    '`resources()`' => [
                        'Creates `ResourcesRepository` instance.',
                    ],
                    '`alerts()`' => [
                        'Creates `AlertsRepository` instance.',
                    ],
                    '`groups()`' => [
                        'Creates `GroupsRepository` instance.',
                    ],
                    '`geofences()`' => [
                        'Creates `GeofenceRepository` instance.',
                    ],
                    '`geofencesAccesses()`' => [
                        'Creates `GeofenceAccessesRepository` instance.',
                    ],
                    '`resourceComments()`' => [
                        'Creates `ResourceCommentsRepository` instance.',
                    ],
                    '`resourceLocations()`' => [
                        'Creates `ResourceLocationsRepository` instance.',
                    ],
                    '`resourcePhotos()`' => [
                        'Creates `ResourcePhotosRepository` instance.',
                    ],
                    '`reactions()`' => [
                        'Creates `ReactionsRepository` instance.',
                    ],
                    '`resource()`' => [
                        'Retrieve `current resource` class or instance.',
                    ],
                    '`authenticated($guard = "api")`' => [
                        'Wrapper of `auth()->user()`.',
                    ],
                    '`subscriptions()`' => [
                        'Creates `Subscriber` tool instance.',
                    ],
                    '`parameters()`' => [
                        'Creates `Parameterizer` tool instance.',
                    ],
                    '`photos()`' => [
                        'Creates `PhotoRepository` instance.',
                    ],
                    '`locations()`' => [
                        'Creates `LocationsRepository` instance.',
                    ],
                    '`rhas($key)`' => [
                        'Wrapper of `request()->has($key)`.',
                    ],
                    '`einput($delimiter, $key)`' => [
                        'Wrapper of `explode($delimiter, request()->input($key))`.',
                    ],
                    '`uuid()`' => [
                        'Creates unique identifier.',
                    ],
                    '`likes()`' => [
                        'Creates `Liker` tool instance.',
                    ],
                    '`finder()`' => [
                        'Creates `Finder` tool instance.',
                    ],
                    '`cataloger()`' => [
                        'Creates `Cataloger` tool instance.',
                    ],
                    '`upload()`' => [
                        'Creates `Uploader` tool instance.',
                    ],
                    '`reports()`' => [
                        'Creates `Reporter` tool instance.',
                    ],
                    '`measurer()`' => [
                        'Creates `Measurer` tool instance.',
                    ],
                    '`input($key)`' => [
                        'Wrapper of `request()->input($key)`.',
                    ],
                    '`uploaded($key)`' => [
                        'Wrapper of `request()->file($key)`.',
                    ],
                    '`fill($key, $value)`' => [
                        'Checks if request input has key using default value if doesnt exists.',
                    ],
                    '`only($keys)`' => [
                        'Wrapper of `request()->only(func_get_args())`.',
                    ],
                    '`parser()`' => [
                        'Creates `Parser` tool instance.',
                    ],
                ]
            ],
            'Tools' => [
                'Tools are classes with a specific responsibility such as measuring distances or uploading files:',
                'Cataloger' => [
                    'Class with the available alert statuses.',
                ],
                'Filler' => [
                    'Fast function to use request input if has value or apply default value.',
                ],
                'Finder' => [
                    'Resolves `/{resource}/{uuid}` instance or `/{resource}` class.',
                ],
                'Identifier' => [
                    'Generates unique identifiers of resources.',
                ],
                'Liker' => [
                    'Implements `laravel-love` reactions of resources.',
                ],
                'Measurer' => [
                    'Performs distance calculations.',
                ],
                'Parameterizer' => [
                    'Implements a simple method to use `Filler` over an array of attributes.',
                ],
                'Parser' => [
                    'Transform raw data into system readable information, such as converting coordinates into `geo-spatial points`.',
                ],
                'Reporter' => [
                    'Responsible for the generation of reports. This tool is `under construction`.',
                ],
                'Subscriber' => [
                    'Responsible for `checking the limits of user quota`. This tool is `under construction`.',
                ],
                'Uploader' => [
                    'Responsible of `photo uploads`.',
                ],
            ],
            'Rules' => [
                'Rules are `custom validation rules`.',
                'Read more in official [docs](https://laravel.com/docs/6.x/validation#custom-validation-rules).'
            ],
        ],
        'Collaboration' => [
            [
                'This project aims to have an open collaboration with the community.',
                'We are available to answer questions, repair errors and improve the existing code with new features.',
                'Find us in our repositories or send us an email to `iantorres@outlook.com`.',
            ],
        ],
        'Criteria of acceptance' => [
            [
                'Our acceptance criteria are simple, complying with the existing tests is a very important factor.',
                'As already mentioned, the argument used will be decisive when adding new features to the code.',
                'We also expect that the added code meets the language specifications and has a low level of cognitive complexity when it is read.'
            ]
        ],
    ],
    'License' => [
        'About our license concept' => [
            [
                'We do not offer a license to distribute our software.',
                'Our software is under development, most of its components have open source licenses either MIT or Apache.',
                'We believe that the code is free and therefore, you are free to copy, modify and use the code as you see fit. As long as you respect the licenses of the co-authors and make a mention of the authors.'
            ]
        ],
        'Disclaimer of code origins' => [
            [
                'Our code is built with the highest standards we handle, however, we depend on third-party libraries in which we cannot guarantee the security or origin of the files. In spite of this, the repositories have the definition of each one of their dependencies with the digital signatures that correspond to the provider of the code.'
            ]
        ]
    ]
];
