# event-statistics-api-on-symfony

## For use this app you should install:
1) php > 8.1
2) composer
3) MySql 8.0
5) git clone https://github.com/zxc3buttons/event-statistics-api-on-symfony.git
6) set .env file for conncetion to DB
7) create DB
8) in project root folder run `composer install`
9) in project root folder run `symfony server:start`
10) in project root folder run `php bin/console doctrine:fixtures:load` for creating of test data

By default your server will run on localhost:8000

## API:

### Examples:
- [POST] /events
request: {
    "name": "Event 1",
    "isAuthorized": true
}
response:
{"message":"Event created."}

- [GET] localhost:8000/events
response:
    {
        "id": 1,
        "name": "Event 0",
        "isAuthorized": false,
        "ipAddress": "192.168.0.227",
        "createdAt": "2023-05-10 16:56:28"
    },
    {
        "id": 2,
        "name": "Event 1",
        "isAuthorized": true,
        "ipAddress": "192.168.0.108",
        "createdAt": "2023-05-10 16:56:28"
    },
}

- [GET] localhost:8000/events?eventName={name} (name = 'Event 1')
response:
    {
        "id": 2,
        "name": "Event 1",
        "isAuthorized": true,
        "ipAddress": "192.168.0.108",
        "createdAt": "2023-05-10 16:56:28"
    },
    {
        "id": 32,
        "name": "Event 1",
        "isAuthorized": true,
        "ipAddress": "::1",
        "createdAt": "2023-05-10 18:27:24"
    },
 
- [GET] localhost:8000/events?groupBy={groupBy} (groupBy = 'isAuthorized') 
response:
[
    {
        "isAuthorized": false,
        "count": 12
    },
    {
        "isAuthorized": true,
        "count": 27
    }
]
