Termik
=======

Simple temperature data collecting tool.

## Config

Application configuration file `D:\Proj\termik\app\config\parameters.yml`:

- `termik.import.file_path: '/home/fwguard'`
- `termik.import.file_regex: '#^tep.*\.txt$#'`
- `termik.import.file_delimiter: ';'`

## Commands

### Drop/Create DB

````
su www-data -s /bin/bash -c '/usr/bin/php bin/console doctrine:schema:drop --force'
su www-data -s /bin/bash -c '/usr/bin/php bin/console doctrine:schema:create'
````

### Clear cache

````
su www-data -s /bin/bash -c '/usr/bin/php bin/console ca:c --env=dev'
su www-data -s /bin/bash -c '/usr/bin/php bin/console ca:c --env=prod'
````

### Import data (via cron)

````
su www-data -s /bin/bash -c '/usr/bin/php bin/console termik:data-import --env=prod'
````

After import imported file is renamed to `tep_<current-timestamp>.bak`.