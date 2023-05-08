<?php
/**
 * Universidade Federal de Santa Catarina
 *
 * 05/05/2023 - criado por roque.bezerra@ufsc.br
 *
 */

class MdSeiWsComplementarIntegracao extends SeiIntegracao
{

//    public function __construct()
//    {
//    }

    public function getNome()
    {
        return 'M�dulo de Webservice Complementar para consultas no SEI';
    }

    public function getVersao()
    {
        return '1.0.0';
    }

    public function getInstituicao()
    {
        return 'UFSC - Universidade Federal de Santa Catarina';
    }

//    public function inicializar($strVersaoSEI)
//    {
//        /*
//        if (substr($strVersaoSEI, 0, 2) != '3.'){
//          die('M�dulo "'.$this->getNome().'" ('.$this->getVersao().') n�o � compatível com esta vers�o do SEI ('.$strVersaoSEI.').');
//        }
//        */
//    }

    public function processarControladorWebServices($strServico)
    {
        $strArq = null;
        switch ($strServico) {
            case 'ufsc-sei-complementar':
                $strArq = 'sei-complementar.wsdl';
                break;
        }

        if ($strArq!=null){
            $strArq = dirname(__FILE__).'/ws/'.$strArq;
        }
        return $strArq;
    }
}

?>