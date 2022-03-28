## PROJECT NOTES ##

1. Do not use ISAM DB engine. It doesn't support foreign keys. Project has been updated to use InnoDb engine [see "config/database.php"]

2. Database First Approach - Migration files can be generated automatically from an existing DB. We can generate files for the whole DB or for specific tables (preferred when modifying a schema).  https://www.youtube.com/watch?v=eLybI4WPuWc 

   A. Install migration generator package using composer.
   composer require --dev "kitloong/laravel-migrations-generator"
   (The github for this package is: https://github.com/kitloong/laravel-migrations-generator)

   B. Generate Migration files

   - To create migrations for all the tables, run:
      php artisan migrate:generate

   - [Preferred method for modifying a DB] You can specify the tables you wish to generate using:
      php artisan migrate:generate --tables="table1,table2,table3,table4,table5"

   - You can also ignore tables with:
      php artisan migrate:generate --ignore="table3,table4,table5"
   
   ** If you're updating a schema and you already have files in the "/database/migrations" folder, remove the files for the tables you are changing. The script will view the tables in your DB and generate new migration files based on the current schema. **

   ** The script will create new migration files for the tables you specify, but without data in them.  You will have to do a sql_dump of the data from your old database and insert into the new. **

   3. Recommended Workflow
      1. Create or modify tables in your DB that need changing.
      2. Backup the data from those tables by doing a sql_dump of the data only.
      3. When done run the migration command to create new migration files:
      php artisan migrate:generate --tables="table1,table2...)
      4. Insert backup data into your updated tables.
