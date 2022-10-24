# Módulo de WebService Complementar

- Neste projeto desenvolvemos alguns métodos de WebServices para suprir a necessidade de: 
  listarProcedimentos, listarDocumentos, listarAndamentos, listarProcessosTramitadosParaArea uma vez que o WebService nativo do SEI não possui esses serviços. 
  
## Requisitos:
- SEI 3.0.0 instalado ou atualizado (verificar valor da constante de versão do SEI no arquivo /sei/web/SEI.php).

## Procedimentos para Instalação:

1. Editar o arquivo "/sei/config/ConfiguracaoSEI.php", tomando o cuidado de usar editor que não altere o charset do arquivo, para adicionar a referência à classe de integração do módulo e seu caminho relativo dentro da pasta "/sei/web/modulos" na array 'Modulos' da chave 'SEI':

		'SEI' => array(
			'URL' => 'http://[Servidor_PHP]/sei',
			'Producao' => false,
			'RepositorioArquivos' => '/var/sei/arquivos',
			'Modulos' => array('MdSeiComplementarWsComplementarIntegracao' => 'ufsc/md-ws-complementar',)
			),

## Documentação
- Para conhecer um pouco mais sobre os serviços deste webservice acesse o documento ManualWebServiceCgu.pdf