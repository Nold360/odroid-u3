#!/bin/bash
#set -x


case $1 in
	"lxc01") PORT=3; ;;
	"lxc02") PORT=2; ;;
	*) echo "usage: $0 <NODE> <off|on|reset>"; exit 1;;
esac

if [ $# -eq 1 ] ; then
	if [ $(cat /sys/class/gpio/gpio${PORT}/value) -eq 1 ] ; then
		echo 0
		exit 0
	else
		echo 1
		exit 1
	fi 
else
	case $2 in
		"on") echo "1" > /sys/class/gpio/gpio${PORT}/value ;;
		"off") echo "0" > /sys/class/gpio/gpio${PORT}/value ;;
		"reset") $0 $1 off; sleep 5; $0 $1 on;;
		*) echo "usage: $0 <NODE> <off|on|reset>"; exit 1;;
	esac
fi

exit 0
