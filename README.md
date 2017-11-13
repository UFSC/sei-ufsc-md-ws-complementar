# M�dulo de WebService Complementar

## Requisitos:
- SEI 3.0.0 instalado ou atualizado (verificar valor da constante de vers�o do SEI no arquivo /sei/web/SEI.php).

## Procedimentos para Instala��o:

1. Editar o arquivo "/sei/config/ConfiguracaoSEI.php", tomando o cuidado de usar editor que n�o altere o charset do arquivo, para adicionar a refer�ncia � classe de integra��o do m�dulo e seu caminho relativo dentro da pasta "/sei/web/modulos" na array 'Modulos' da chave 'SEI':

		'SEI' => array(
			'URL' => 'http://[Servidor_PHP]/sei',
			'Producao' => false,
			'RepositorioArquivos' => '/var/sei/arquivos',
			'Modulos' => array('MdCguWsComplementarIntegracao' => 'cgu/md-ws-complementar',)
			),

## Documenta��o
- Para conhecer um pouco mais sobre os servi�os deste webservice acesse o documento ManualWebServiceCgu.pdf