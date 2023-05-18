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
        return 'Módulo de Webservice Complementar para integraç?o com o SEI';
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
//          die('Módulo "'.$this->getNome().'" ('.$this->getVersao().') nðo é compatð­vel com esta versðo do SEI ('.$strVersaoSEI.').');
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