#!/bin/bash
#set -x


case $1 in
	"lxc01") PORT=0; ;;
	"lxc02") PORT=1; ;;
	*) echo "usage: $0 <NODE> <off|on|reset>"; exit 1;;
esac

case $2 in
	"on") echo "0" > /sys/class/gpio/gpio${PORT}/value ;;
	"off") echo "1" > /sys/class/gpio/gpio${PORT}/value ;;
	"reset") $0 $1 off; sleep 5; $0 $1 on;;
	*) echo "usage: $0 <NODE> <off|on|reset>"; exit 1;;
esac

exit 0
