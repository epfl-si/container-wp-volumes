#(c) All rights reserved. ECOLE POLYTECHNIQUE FEDERALE DE LAUSANNE, Switzerland, VPSI, 2017

FROM busybox

MAINTAINER IDEVELOP <personnel.idevelop@epfl.ch>

WORKDIR /var/wordpress

COPY ./plugins ./plugins
COPY ./themes ./themes

VOLUME ["/var/wordpress/plugins", "/var/wordpress/themes"]

CMD [ "/bin/true" ]