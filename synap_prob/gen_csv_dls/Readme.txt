go to dir gen_csv_dls/

In MySQL Workbench:
1. open then run:
netlist_parcels_create_table.sql
2. run with "run sql script":
netlist_parcels.sql
Alternatively run in a command prompt:
mysql -h localhost -u <username> -p <database> < netlist_parcels.sql

For ADL and SD:
3. open and run:
adl_stats.sql
4. open and run:
adl_values.sql
5. use export button in query results window to export
adl_values.csv

NPS, NOC, and SP, the _values.sql for them can be
directly run and results from that are exported to
csv files.
These files create database views.
The views can be exported into csv files with export_table.sh.
Run in command prompt:
./export_table.sh <username> <password> <database> <view_name>
This will export the data to /var/tmp/SynproExports/

