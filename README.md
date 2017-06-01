# README #

### What is this repository for? ###

This image is a data-only container (with busybox for debug purposes) It contains a selection of plugins and themes provided for EPFL wordpress sites

### How do I set things up ? ###

The volumes `/var/www/html/wp-content/plugins` and `/var/www/html/wp-content/themes` are defined in Dockerfile and thus available to other containers.

Simply use `volumes_from` in your composition, along with a standard wordpress.

### A few examples ###

The simplest usage is to rely on volumes defined in Dockerfile

```
  wpvolumes:
    build: container-wp-volumes

  wordpress:
    image: wordpress:4.7.5
    volumes_from:
      - wpvolumes

  ...
```

If you want to have a bit more control on the content of those volumes, you can make use of **local mounted** volumes :

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

And finally, if you want to re-use it somewhere else, you can make use of  **named** volumes :

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
