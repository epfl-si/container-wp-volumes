#(c) All rights reserved. ECOLE POLYTECHNIQUE FEDERALE DE LAUSANNE, Switzerland, VPSI, 2017

FROM busybox

MAINTAINER IDEVELOP <personnel.idevelop@epfl.ch>

WORKDIR /var/www/html/wp-content

COPY ./plugins ./plugins
COPY ./themes ./themes

VOLUME ["/var/www/html/wp-content/plugins", "/var/www/html/wp-content/themes"]

CMD [ "/bin/true" ]