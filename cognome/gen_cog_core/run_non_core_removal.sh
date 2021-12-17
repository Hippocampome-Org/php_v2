#!/bin/bash

ADDR="localhost"; # db address
DB="cognome_core";   # db name
read -p "Please enter your MySQL username: " USER &&
read -sp "Please enter your MySQL password: " PASS &&

echo "\n\nCreating intial tables" &&
mysql -h $ADDR -u $USER -p$PASS $DB < remove_articles.sql &&
mysql -h $ADDR -u $USER -p$PASS $DB < remove_authors.sql &&
mysql -h $ADDR -u $USER -p$PASS $DB < remove_details.sql &&
mysql -h $ADDR -u $USER -p$PASS $DB < remove_implementations.sql &&
mysql -h $ADDR -u $USER -p$PASS $DB < remove_keywords.sql &&
mysql -h $ADDR -u $USER -p$PASS $DB < remove_neurons.sql &&
mysql -h $ADDR -u $USER -p$PASS $DB < remove_regions.sql &&
mysql -h $ADDR -u $USER -p$PASS $DB < remove_scales.sql &&
mysql -h $ADDR -u $USER -p$PASS $DB < remove_subjects.sql &&
mysql -h $ADDR -u $USER -p$PASS $DB < remove_subjects_evi.sql &&
mysql -h $ADDR -u $USER -p$PASS $DB < remove_theories.sql &&
echo "Completed"