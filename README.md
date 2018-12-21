# Command Line to Ping with XMLRPC like wordpress (without)

## How to use

Clone this git repo, install composer dependencies, and go :
```
php Ping.php url=https://mydomain.com/ [name="My Site" [feed=https://mydomain.com/feed [source=pinglist.txt]]]
```

## Mass Ping

```
while read p; do php src/Ping.php url="$p"; done <listURL.txt;
```
