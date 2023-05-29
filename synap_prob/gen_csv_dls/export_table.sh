if [ $# != 4 ]
then
	echo "usage: ./export_table.sh username password database table";
	exit
fi
USER=$1;
PASS=$2;
DB=$3;
TABLE=$4;
ADDR=localhost # db address
CSV_DIR=csv # import csv files location
EXP_DIR="/var/tmp/SynproExports/" # export csv files directory

command="rm /var/tmp/SynproExports/$TABLE.csv";
eval $command;

echo "SET STATEMENT max_statement_time=0 FOR SELECT * FROM \
$DB.$TABLE INTO OUTFILE '$EXP_DIR/$TABLE.csv' FIELDS TERMINATED BY ',' \
OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n';" > export_table.sql &&
mysql -h $ADDR -u $USER -p$PASS $DB < export_table.sql

sudo chmod -R 777 /var/tmp/SynproExports/*