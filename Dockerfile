ARG SEI_APP_DOCKER_IMAGE=docker-repo.sistemas.ufsc.br/ufsc/sei-app-stock:3.1

FROM $SEI_APP_DOCKER_IMAGE

RUN sed  -i "/'RepositorioArquivos'/a ,'Modulos' => array('MdSeiWsComplementarIntegracao' => 'ufsc/wscomplementar')" /opt/sei/config/ConfiguracaoSEI.php && \
    mkdir -p /opt/sei/web/modulos/ufsc/wscomplementar

COPY *.php /opt/sei/web/modulos/ufsc/wscomplementar
COPY dto /opt/sei/web/modulos/ufsc/wscomplementar/dto
COPY ws /opt/sei/web/modulos/ufsc/wscomplementar/ws