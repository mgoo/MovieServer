#MovieServer

This is a website made to be run on a local network that can search up and display information about a movie as well as getting torrent files and displaying the files linked to the page

##requirements

1. apache2 with mod_rewirte enabled
2. transmission-daemon with the webinterface working on port 9091 and no login required


##Installation
1. add the files to the /var/www/html directory
2. sym link the folder with video files in them to the /app/webroot/files/ directory
3. change the ServerName and network locations variables in /app/Config/core.php
