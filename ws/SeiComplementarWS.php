<?
/**
 * Universidade Federal de Santa Catarina
 *
 * 18/05/2023 - criado por roque.bezerra@ufsc.br
 *
 */

require_once dirname(__FILE__) . '/../../../../SEI.php';

ini_set('memory_limit','1024M');

class SeiComplementarWS extends InfraWS {

    public function consultarConteudoDocumento($SiglaSistema, $IdentificacaoServico, $IdUnidade, $IdDocumento, $ProtocoloDocumento){

        SessaoSEI::getInstance(false);

        $objServicoDTO = $this->obterServico($SiglaSistema, $IdentificacaoServico);

        if ($IdUnidade!=null){
            $objUnidadeDTO = $this->obterUnidade($IdUnidade,null);
        }else{
            $objUnidadeDTO = null;
        }

        $this->validarAcessoAutorizado(explode(',',str_replace(' ','',$objServicoDTO->getStrServidor())));

        if ($objUnidadeDTO==null){
            SessaoSEI::getInstance()->simularLogin(null, SessaoSEI::$UNIDADE_TESTE, $objServicoDTO->getNumIdUsuario(), null);
        }else{
            SessaoSEI::getInstance()->simularLogin(null, null, $objServicoDTO->getNumIdUsuario(), $objUnidadeDTO->getNumIdUnidade());
        }

		try{
			$objEntradaConsultarDocumentoAPI = new EntradaConsultarDocumentoAPI();
            $objEntradaConsultarDocumentoAPI->setIdDocumento($IdDocumento);
			$objEntradaConsultarDocumentoAPI->setProtocoloDocumento($ProtocoloDocumento);
            $objEntradaConsultarDocumentoAPI->setSinRetornarAndamentoGeracao('N');
            $objEntradaConsultarDocumentoAPI->setSinRetornarAssinaturas('N');
            $objEntradaConsultarDocumentoAPI->setSinRetornarPublicacao('N');
            $objEntradaConsultarDocumentoAPI->setSinRetornarCampos('N');

            $objSeiRN = new SeiRN();
            $objDocumento = $objSeiRN->consultarDocumento($objEntradaConsultarDocumentoAPI);

            if ($objDocumento==null){
                throw new InfraException('Documento ['.$ProtocoloDocumento.'] não encontrado.');
            }

            $strConteudo = null;

            $objDocumentoDTO = new DocumentoDTO();
            $objDocumentoDTO->retDblIdProcedimento();
            $objDocumentoDTO->retDblIdDocumento();
            $objDocumentoDTO->retDblIdDocumentoEdoc();
            $objDocumentoDTO->retStrNomeSerie();
            $objDocumentoDTO->retStrStaDocumento();
            $objDocumentoDTO->retStrProtocoloDocumentoFormatado();
            $objDocumentoDTO->retStrProtocoloProcedimentoFormatado();
            $objDocumentoDTO->setDblIdDocumento($objDocumento->getIdDocumento());
      
            $objDocumentoRN = new DocumentoRN();
            $objDocumentoDTO = $objDocumentoRN->consultarRN0005($objDocumentoDTO);

            $strMimeType = null;
            $strConteudo = null;

            if ($objDocumentoDTO == null) {
                $strConteudo = 'Documento não encontrado.';
            } else {
                if ($objDocumentoDTO->getStrStaDocumento() == DocumentoRN::$TD_EDITOR_EDOC) {
                    if ($objDocumentoDTO->getDblIdDocumentoEdoc() == null) {
                        throw new InfraException('Documento ['.$ProtocoloDocumento.'] não possui conteúdo.');
                    }

                    $objEDocRN = new EDocRN();
                    $dto = new DocumentoDTO();
                    $dto->setDblIdDocumentoEdoc($objDocumentoDTO->getDblIdDocumentoEdoc());

                    $strMimeType = 'text/html';
                    $strConteudo = $objEDocRN->consultarHTMLDocumentoRN1204($dto);

                } else if ($objDocumentoDTO->getStrStaDocumento() == DocumentoRN::$TD_EDITOR_INTERNO) {

                    $objEditorDTO = new EditorDTO();
                    $objEditorDTO->setDblIdDocumento($objDocumentoDTO->getDblIdDocumento());
                    $objEditorDTO->setNumIdBaseConhecimento(null);
                    $objEditorDTO->setStrSinCabecalho('S');
                    $objEditorDTO->setStrSinRodape('S');
                    $objEditorDTO->setStrSinCarimboPublicacao('S');
                    $objEditorDTO->setStrSinIdentificacaoVersao('N');

                    $objEditorRN = new EditorRN();

                    $strMimeType = 'text/html';
                    $strConteudo = $objEditorRN->consultarHtmlVersao($objEditorDTO);

                } else if ($objDocumentoDTO->getStrStaDocumento() == DocumentoRN::$TD_FORMULARIO_AUTOMATICO || $objDocumentoDTO->getStrStaDocumento() == DocumentoRN::$TD_FORMULARIO_GERADO) {

                    $strMimeType = 'text/html';
                    $strConteudo = $objDocumentoRN->consultarHtmlFormulario($objDocumentoDTO);

                } else if ($objDocumentoDTO->getStrStaDocumento() == DocumentoRN::$TD_EXTERNO) {

                    $objAnexoDTO = new AnexoDTO();
                    $objAnexoDTO->retNumIdAnexo();
                    $objAnexoDTO->retStrNome();
                    $objAnexoDTO->retNumIdAnexo();
                    $objAnexoDTO->retStrHash();
                    $objAnexoDTO->setDblIdProtocolo($objDocumentoDTO->getDblIdDocumento());
                    $objAnexoDTO->retDblIdProtocolo();
                    $objAnexoDTO->retDthInclusao();
                    $objAnexoDTO->retStrProtocoloFormatadoProtocolo();
                    
                    $objAnexoRN = new AnexoRN();
                    $arrObjAnexoDTO = $objAnexoRN->listarRN0218($objAnexoDTO);

                    $objAnexoDoc = $arrObjAnexoDTO[0];

                    $strNomeArquivo = $objAnexoDoc->getStrNome();
                    $strCaminhoNomeArquivo = $objAnexoRN->obterLocalizacao($objAnexoDoc);

                    $binConteudo = file_get_contents($strCaminhoNomeArquivo);
        
                    if (md5($binConteudo) != $objAnexoDoc->getStrHash()) {
                      throw new InfraException('Conteúdo do arquivo corrompido.', null, $strCaminhoNomeArquivo);
                    }
                    
                    $strMimeType = InfraUtil::getStrMimeType($strNomeArquivo);
                    $strConteudo = base64_encode($binConteudo);
                }
            }

            $objRetorno = new SaidaConsultarConteudoDocumentoDTO();
            $objRetorno->setIdProcedimento($objDocumentoDTO->getDblIdProcedimento());
            $objRetorno->setIdDocumento($objDocumentoDTO->getDblIdDocumento());

            $objRetorno->setProcedimentoFormatado($objDocumentoDTO->getStrProtocoloProcedimentoFormatado());
            $objRetorno->setDocumentoFormatado($objDocumentoDTO->getStrProtocoloDocumentoFormatado());
            $objRetorno->setMimeType($strMimeType);
            $objRetorno->setConteudo($strConteudo);

            return $objRetorno;

		}catch(Exception $e){
            $this->processarExcecao($e);
		}
    }


    private function obterServico($SiglaSistema, $IdentificacaoServico){

        $objUsuarioDTO = new UsuarioDTO();
        $objUsuarioDTO->retNumIdUsuario();
        $objUsuarioDTO->setStrSigla($SiglaSistema);
        $objUsuarioDTO->setStrStaTipo(UsuarioRN::$TU_SISTEMA);

        $objUsuarioRN = new UsuarioRN();
        $objUsuarioDTO = $objUsuarioRN->consultarRN0489($objUsuarioDTO);

        if ($objUsuarioDTO==null){
            throw new InfraException('Sistema ['.$SiglaSistema.'] n?o encontrado.');
        }

        $objServicoDTO = new ServicoDTO();
        $objServicoDTO->retNumIdServico();
        $objServicoDTO->retStrIdentificacao();
        $objServicoDTO->retStrSiglaUsuario();
        $objServicoDTO->retNumIdUsuario();
        $objServicoDTO->retStrServidor();
        $objServicoDTO->retStrSinLinkExterno();
        $objServicoDTO->retNumIdContatoUsuario();
        $objServicoDTO->setNumIdUsuario($objUsuarioDTO->getNumIdUsuario());
        $objServicoDTO->setStrIdentificacao($IdentificacaoServico);

        $objServicoRN = new ServicoRN();
        $objServicoDTO = $objServicoRN->consultar($objServicoDTO);

        if ($objServicoDTO==null){
            throw new InfraException('Servi?o ['.$IdentificacaoServico.'] do sistema ['.$SiglaSistema.'] n?o encontrado.');
        }

        return $objServicoDTO;
    }

    private function obterUnidade($IdUnidade, $SiglaUnidade){

        $objUnidadeDTO = new UnidadeDTO();
        $objUnidadeDTO->retNumIdUnidade();
        $objUnidadeDTO->retStrSigla();
        $objUnidadeDTO->retStrDescricao();

        if($IdUnidade!=null) {
            $objUnidadeDTO->setNumIdUnidade($IdUnidade);
        }
        if($SiglaUnidade!=null){
            $objUnidadeDTO->setStrSigla($SiglaUnidade);
        }

        $objUnidadeRN = new UnidadeRN();
        $objUnidadeDTO = $objUnidadeRN->consultarRN0125($objUnidadeDTO);

        if ($objUnidadeDTO==null){
            throw new InfraException('Unidade ['.$IdUnidade.'] n?o encontrada.');
        }

        return $objUnidadeDTO;
    }
}

/*
 $servidorSoap = new SoapServer("sei.wsdl",array('encoding'=>'ISO-8859-1'));
 $servidorSoap->setClass("SeiWS");

 //S? processa se acessado via POST
 if ($_SERVER['REQUEST_METHOD']=='POST') {
 $servidorSoap->handle();
 }
*/

$servidorSoap = new BeSimple\SoapServer\SoapServer( "sei-complementar.wsdl", array ('encoding'=>'ISO-8859-1',
    'soap_version' => SOAP_1_1,
    'attachment_type'=>BeSimple\SoapCommon\Helper::ATTACHMENTS_TYPE_MTOM));
$servidorSoap->setClass ( "SeiComplementarWS" );

//S? processa se acessado via POST
if ($_SERVER['REQUEST_METHOD']=='POST') {
    $servidorSoap->handle($HTTP_RAW_POST_DATA);
}
