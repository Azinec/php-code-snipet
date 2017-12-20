IP storage
===

### Description

Project contains two parts:

##### Composer package
Storage implementation. Located in a `package`directory. Contains model classes for IPV4/6 addresses, storage interface, B-Tree driver interface.
B-Tree is implemented in a `IpAddressBtree\Tree\FileSystemBtreeDriver` class (file system storage). Linked to application as *path* repository.

##### Symfony application
`app` directory contains Symfony application which integrates `package` and provides CLI and RestAPI interfaces to storage.  

### Installation/configuration
1. `git clone git@bitbucket.org:stas81/ip-store.git ./ip-store` - clone project
2. `cd ./ip-store/app`
3. `composer install` - install dependencies with Composer
4. check path to storage file in `app/config/papameters.yml` under `storage_file` parameter

#### Usage
System supports both IPv4 and IPv6 addresses.
##### CLI interface
Implemented with two Symfony console commands, both takes one IP address as an argument:    
1. `bin/console app:address:query 195.154.2.10` - display a number of times which IP address was added to the storage
2. `bin/console app:address:store 195.154.2.10` - add IP address to the storage and display a number of times which IP address was added

##### Rest interface (JSON-API)
1. Query counter
    * Request`GET /api/address?ip=195.154.2.10`
    * Response
    ```json
    {
        "code": 200,
        "data": {
            "ip": "195.154.2.10",
            "type": "IPv4",
            "count": 2
        }
    }
    ```
2. Store IP address
    * Request
    `POST /api/address`
    ```json
    {
        "ip":"195.154.2.10"
    }
    ```
    * Response
    ```json
    {
        "code": 201,
        "data": {
            "ip": "195.154.2.10",
            "type": "IPv4",
            "count": 3
        }
    }
    ```

#### Running tests
Tests was made separately for `package` and `app`

1. inside a `package` directory:
    `composer install && vendor/bin/phpunit`
2. in `app` directory
    `vendor/bin/phpunit`
