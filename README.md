# README #

### What is this repository for? ###

This image is a data-only container (with busybox for debug purposes) It contains a selection of plugins and themes provided for EPFL wordpress sites

### How do I set things up ? ###

Simply use the volumes ```/var/www/html/wp-content/plugins```, ```/var/www/html/wp-content/themes``` in your composition, along with a standard wordpress.

Example with local mounted volumes :

```
  wpvolumes:
    build: container-wp-volumes
    volumes:
      - ./container-wp-volumes/plugins:/var/www/html/wp-content/plugins
      - ./container-wp-volumes/themes:/var/www/html/wp-content/themes

  wordpress:
    image: wordpress:4.7.5
    volumes_from:
      - wpvolumes

  ...
```

Or with named volumes :

```
  wpvolumes:
    build: container-wp-volumes
    volumes:
      - wp-plugins:/var/www/html/wp-content/plugins
      - wp-themes:/var/www/html/wp-content/themes

  wordpress:
    image: wordpress:4.7.5
    volumes_from:
      - wpvolumes

  ...

volumes:
  wp-plugins:
  wp-themes:
```

(c) All rights reserved. ECOLE POLYTECHNIQUE FEDERALE DE LAUSANNE, Switzerland, VPSI, 2017
