# REST API Skeleton
This is a REST API setup with Symfony3.4.  

---
## Installation

### Clone the project
```bash
git clone https://github.com/raghavrach/symfony3.4-rest-api.git {dir_name}
```

### Install dependecies from composer
From the project root directory, run following command (Download composer.phar from https://getcomposer.org/download/)
```bash
php composer.phar install
```

### To run application start the server
After the installation to run the application via Symfony console:

```bash
php bin/console server:start
```

### Test the Installation
Navigate to http://127.0.0.1:8000/ and verify the installation is correct.

## Available endpoints
##### GET API to fetch the filter values
* `/server-information/get-filter-options`

##### GET API to filter data
* `/server-information/search-by-resource`
    ###### GET PARAMS:
    ```bash
    ram - Array of RAM values Ex: ['32GM', '4GB']
    hardDiskType - Array of hard disk type Ex: ['SAS', 'SATA']
    location - Array of locations Ex: [AmsterdamAMS-01]
    storage - Array of storage values Ex: ['300GB', '4TB']
    ```

## Run Test Cases
Test cases are integrated with phpunit bundle and with WebTestCase. Run as below
```bash
php ./vendor/bin/phpunit tests/Functional/
```