<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 17/07/2014 - criado por mga
*
*/

require_once dirname(__FILE__).'/../../../../SEI.php';

class WSEntradaListarObterTramitadosDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return null;
  }

  public function montar() {
    $this->adicionarAtributo(InfraDTO::$PREFIXO_ARR, 'RequisicaoConsultaTramiteDTO');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_NUM, 'IdUnidade');
  }
}
?>