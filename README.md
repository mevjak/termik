Termik
=======

Simple temperature data collecting tool.

## Config

Application configuration file `/var/www/termik/app/config/parameters.yml`:

### Database

Data are stored in SQLite DB

- `database_path: '%kernel.root_dir%/data.db'`

Note: can be replaced by absolute path writable for www-data


### Import from CSV

- `termik.import.file_path: '/home/fwguard'`
- `termik.import.file_regex: '#^tep.*\.txt$#'`
- `termik.import.file_delimiter: ';'`

## Commands

### Drop/Create DB

````
cd /var/www/termik
su www-data -s /bin/bash -c '/usr/bin/php bin/console doctrine:schema:drop --force'
su www-data -s /bin/bash -c '/usr/bin/php bin/console doctrine:schema:create'
````

### Clear cache

````
cd /var/www/termik
su www-data -s /bin/bash -c '/usr/bin/php bin/console ca:c --env=dev'
su www-data -s /bin/bash -c '/usr/bin/php bin/console ca:c --env=prod'
````

### Import data (via cron)

````
su www-data -s /bin/bash -c '/usr/bin/php /var/www/termik/bin/console termik:data-import --env=prod'
````

After import imported file is renamed to `tep_<current-timestamp>.bak`.