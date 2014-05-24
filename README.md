odroid-u3
=========

My odroid-u2/3 configs, scripts, sources, ...

Everything made for / tested on:
	- Hardkernel Odroid-U3
	- Debian 7 "wheezy"
	- Kernel 3.8.13.19 (https://github.com/hardkernel/linux/tree/odroid-3.8.y)


My odroid-u3 cluster
=========

The reason for all the modifications and scripts i needed is,
that i use 2 odroid-u3's as an Pacemaker LXC Cluster.
They should been using a Shared-Storage based on ocfs2 or GFS
but that didn't work with LXC, so i switched to ext4 and
one lun per Container.

Since the cgroup support isn't so great in this kernel version
there are still some errors in "lxc-checkconfig" but it works fine 
for me, including CPU mapping and RAM limitations.
But i had to modifie the Pacemaker LXC-Resource-Agent because
"lxc-info" is still saying that cgroups aren't mounted,
but shows that the container is running fine...

For STONITH I'm using an Raspberry PI as a Remote Service Board.
Also it's connected to two relais, which control the power of 
the odroids. So if a Node wants to fence the other one,
it SSH into the Raspberry, and disconnects the power for the
other node. Pretty simple, but it works great so far.
Also the Raspberry is connected to the serial-interface
of both odroids, which allows me to connect to them using
a web browser. 
I will include some of my Raspberry code soon..
