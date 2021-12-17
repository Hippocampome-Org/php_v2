#/bin/bash
# reference: https://stackoverflow.com/questions/1521462/looping-through-the-content-of-a-file-in-bash

outputfile="article_citations.csv";
#command="echo \"title,citations,year\" > $outputfile";
vpn="yes";
sleep_active="yes";
eval $command;
i=1;
j=1;
while read title; do
	echo "processing iteration #$i";
	mod_i=$(expr $i % 10); # switch every certain number iteration
	
	if [ $vpn == "yes" ] && [ $mod_i == 0 ]
	# switch vpn
	then
	nordvpn disconnect;
	command="awk 'NR==$j' vpn_list.txt";
	vpnname=$(eval $command);
	nordvpn connect $vpnname;
	j=$(expr $j + 1);
	fi

	if [ $vpn == "yes" ] && [ $i == 1 ]
	# initialize vpn
	then
	nordvpn disconnect;
	command="awk 'NR==$j' vpn_list.txt";
	vpnname=$(eval $command);
	nordvpn connect $vpnname;
	fi		
	
	# collect citation
	command="python3 ./collect_citations.py \"$title\"";
	cites_year=$(eval $command);
	echo "$title,$cites_year" >> $outputfile;
	echo $mod_i;

	i=$(expr $i + 1);

	if [ $sleep_active == "yes" ]
	then
	sleep 30;
	fi
done <articles_list.txt