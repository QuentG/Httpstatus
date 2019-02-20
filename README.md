# Httpstatus

## Presentation 

This web application will check the status of any site with a refresh of the status every two minutes + a complete history, and if a site is K.O three times in a row then the admin will receive an email on his mailbox and no sending message if a message has already been sent to the site less than 2 hours ago #NoSpam.

It has an admin space (with connection in advance) that will allow to add sites / edit (url) and delete them.

This web application also has an API.

## Description 

### Update status

Based on HTTP return codes. With 4 status:

- Inaccessible -> 4xx

- Server error -> 5xx

- Accessible -> 2xx

- Unable to join the server -> 999

## API

The site has an API that allows you to:

- List the sites

- Add a site

- Delete a site

- Consult the current status of a site

- View the history of a site

### Different routes

- Home : /api/
- List : '/api/list
- Add : /api/add
- Status : /api/status/{id}
- History : /api/history/{id}
- Delete : /api/delete/{id}

### Example of different requests made to the API

- /api/

```json
{
    'version': 1,
    'list': 'http://example.fr/httpstatus/api/list/'
}
```

- /api/list

```json
{
    'version': 1,
    'websites': [
        {
            'id': 973,
            'url': 'http://toto.com',
            'delete': 'http://example.fr/httpstatus/api/delete/973',
            'status': 'http://example.fr/httpstatus/api/status/973',
            'history': 'http://example.fr/httpstatus/api/history/973',
        },
        ...
    ]
}
```

- /api/add

```json
{
    'success': true,
    'id': 7269,
}
```

- /api/status/973

```json
{
    'id': 973,
    'url': 'http://toto.com',
    'status': {
        'code': 200,
        'at': '2019-02-01 10:00:12'
    }
}
```

- /api/history/973

```json
{
    'id': 973,
    'url': 'http://toto.com',
    'status': [
        {
            'code': 200,
            'at': '2019-01-10 10:00:11'
        },
        {
            'code': 500,
            'at': '2019-01-10 09:58:11'
        },
        {
            'code': 200,
            'at': '2019-01-10 09:56:11'
        },
    ]
}
```

- /api/delete/973

```json
{
    'success': true,
    'id': 973,
}
```

## Authors

**Developed by** - [Lucas Consejo](https://github.com/lucasconsejo) && [Quentin gans](https://github.com/QuentG).
