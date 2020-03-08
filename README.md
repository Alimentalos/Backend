## Alimentalos Backend

[![GitHub release](https://img.shields.io/github/release/alimentalos/backend.svg)](https://github.com/alimentalos/backend/releases/) [![Actions Status](https://github.com/alimentalos/backend/workflows/Testing/badge.svg)](https://github.com/alimentalos/backend/actions) [![codecov](https://codecov.io/gh/alimentalos/backend/branch/master/graph/badge.svg)](https://codecov.io/gh/alimentalos/backend) [![Maintainability](https://api.codeclimate.com/v1/badges/ccd2e2ff7f49a0ee6c6f/maintainability)](https://codeclimate.com/github/alimentalos/backend/maintainability) [![Test Coverage](https://api.codeclimate.com/v1/badges/ccd2e2ff7f49a0ee6c6f/test_coverage)](https://codeclimate.com/github/alimentalos/backend/test_coverage)

[**Official website**](https://www.alimentalos.cl) — [**About**](https://www.alimentalos.cl/about) — [**Developer guide**](https://www.alimentalos.cl/about/developer-guide) — [**OpenApi Specification**](https://www.alimentalos.cl/api/documentation)

### Brief

The idea lies in the simplicity that we must raise awareness among other people regarding the moral responsibility of caring for the entities that surround us and that by their nature, do not have the capacity to defend themselves in a world surrounded by evil.

### About

In this repository is the back of the system, that code that allows us to provide a service open to the world. Our source code is open and freely distributed.

### Current features

The following list are detailed those of software features developed and tested:

#### Authentication

We have a specific API to handle new user registrations as well as password recovery using registered mail.

#### Tracker

The system has the ability to receive locations from users, devices or pets. This allows you to find the last location, find resources near your location or generate reports considering the routes drawn.

#### Photos

Most entities of the system have the ability to upload photographs and relate them. The geofences are polygons on a map, so photographs can be uploaded and found by their relationship. It would also apply to the cases of users, pets or groups.

#### Groups

The application has its own system to manage relationships with groups, so that a group can contain other resources such as users, pets, geofences or others. In the specific case of the users, the system allows inviting other users and accepts or rejects such invitation.

#### Accessible

The system has an access control system related to the geofences, each time a user or device enters a zone, it will leave a record in a database relating the first and last point related to said entry or exit.

#### Broadcasting

The platform every time it receives a new location, it is retransmitted by a channel to all users who have access to the resource. So from an application it could be easy to receive information and update in real time.

### Planned

The following list are detailed those of software features what are in development:

#### Alerts

Our system allows users to create georeferenced alerts. In the event that a user loses his pet, he could send a close alert to all connected users and get help finding his friend.
