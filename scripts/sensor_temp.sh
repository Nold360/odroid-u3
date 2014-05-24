#!/bin/bash

temp=$(( $(cat /sys/devices/virtual/thermal/thermal_zone0/temp) / 1000 ))

echo $temp
