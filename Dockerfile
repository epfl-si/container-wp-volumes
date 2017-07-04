#(c) All rights reserved. ECOLE POLYTECHNIQUE FEDERALE DE LAUSANNE, Switzerland, VPSI, 2017

FROM busybox

MAINTAINER IDEVELOP <personnel.idevelop@epfl.ch>

WORKDIR /var/www/html

COPY ./wp-content ./wp-content

VOLUME ["/var/www/html/wp-content"]

CMD [ "/bin/true" ]