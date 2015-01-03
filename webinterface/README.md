=== Webinterface for LXC-Pacemaker Cluster Serviceboard
Made for a Raspberry Pi using USB-2-Serial for Serial-
consoles and GPIOs for relay/power-controll.

GPLv3 Licensed

=== lighttpd config
Auth & webconsole for every clusternode:
######
server.modules                += ( "mod_auth" )

$HTTP["host"] =~ "" {
  auth.backend = "htpasswd"
  auth.backend.htpasswd.userfile = "/etc/lighttpd/passwd"
  auth.require = (
      "/"       =>  ("method" => "basic", "realm" => "Anmelden", "require" => "valid-user"),
      "/lxc01"  =>  ("method" => "basic", "realm" => "Anmelden", "require" => "valid-user"),
      "/lxc02"  =>  ("method" => "basic", "realm" => "Anmelden", "require" => "valid-user")
  )
}
####
ShellInABox is running on port 4200
####
server.modules   += ( "mod_proxy" )

$HTTP["url"] =~ "^/lxc01(.*)$" {
        proxy.server  = ("" => (
            ("host" => "127.0.0.1", "port" => 4200)
        ))
}

$HTTP["url"] =~ "^/lxc02(.*)$" {
        proxy.server  = ("" => (
            ("host" => "127.0.0.1", "port" => 4200)
        ))
}
####

=== shellinabox
==== /etc/default/shellinabox
SHELLINABOX_ARGS="--localhost-only --disable-ssl --no-beep -s /lxc01/:root:root:/:/usr/local/bin/serial_lxc01.sh -s /lxc02/:root:root:/:/usr/local/bin/serial_lxc02.sh"

serial_lxc0x.sh just does "minicom lxc0x" with preconfigured serial configuration
