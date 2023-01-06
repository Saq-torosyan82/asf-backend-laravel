### ASF Financial Container

1. Make sure "php" points to a PHP8

```bash
alias php='/usr/bin/php8.0'
```

2. Show "import" commands

```bash
php artisan | grep import
```

3. Import data facts. Command is: __financial:import_facts__
```bash
php artisan financial:import_facts [path_to_folder]
```

example

```bash
php artisan financial:import_facts ~/projects/appyventures/Football\ Club\ Facts\ sheet\ structured
```

4. Import financials. Command is: __financial:import_financials__

```bash
php artisan financial:import_financials [path_to_folder]
``` 

example

```bash
php artisan financial:import_financials ~/projects/appyventures/Football\ Financials
``` 


5. Reset whole DB
```bash
php artisan migrate:fresh --seed
```

