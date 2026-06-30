# Healing SQL Dump Folder

This folder will contain the raw MySQL dump (`healing.sql`) generated after the migrations and seeders run.

## How to import the dump
```bash
# From the project root (c:/xampp/htdocs/aplikasi_healing)
mysql -u <username> -p <database_name> < db/healing.sql
```
Replace `<username>` and `<database_name>` with your MySQL credentials.

The dump will be created with:
```bash
mysqldump -u <username> -p <database_name> > db/healing.sql
```
---
