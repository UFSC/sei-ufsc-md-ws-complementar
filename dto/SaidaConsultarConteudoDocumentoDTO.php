<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4 REGIO
*
* 13/10/2011 - criado por mga
*
*/

class SaidaConsultarConteudoDocumentoDTO {
  private $IdProcedimento;
  private $ProcedimentoFormatado;
  private $IdDocumento;
  private $DocumentoFormatado;
  private $MimeType;
  private $Conteudo;
  

  /**
   * @return mixed
   */
  public function getIdProcedimento()
  {
    return $this->IdProcedimento;
  }

  /**
   * @param mixed $IdProcedimento
   */
  public function setIdProcedimento($IdProcedimento)
  {
    $this->IdProcedimento = $IdProcedimento;
  }

  /**
   * @return mixed
   */
  public function getProcedimentoFormatado()
  {
    return $this->ProcedimentoFormatado;
  }

  /**
   * @param mixed $ProcedimentoFormatado
   */
  public function setProcedimentoFormatado($ProcedimentoFormatado)
  {
    $this->ProcedimentoFormatado = $ProcedimentoFormatado;
  }

  /**
   * @return mixed
   */
  public function getIdDocumento()
  {
    return $this->IdDocumento;
  }

  /**
   * @param mixed $IdDocumento
   */
  public function setIdDocumento($IdDocumento)
  {
    $this->IdDocumento = $IdDocumento;
  }

  /**
   * @return mixed
   */
  public function getDocumentoFormatado()
  {
    return $this->DocumentoFormatado;
  }

  /**
   * @param mixed $DocumentoFormatado
   */
  public function setDocumentoFormatado($DocumentoFormatado)
  {
    $this->DocumentoFormatado = $DocumentoFormatado;
  }

  /**
   * @return mixed
   */
  public function getMimeType()
  {
    return $this->MimeType;
  }

  /**
   * @param mixed $MimeType
   */
  public function setMimeType($MimeType)
  {
    $this->MimeType = $MimeType;
  }
  
  /**
   * @return mixed
   */
  public function getConteudo()
  {
    return $this->Conteudo;
  }

  /**
   * @param mixed $Conteudo
   */
  public function setConteudo($Conteudo)
  {
    $this->Conteudo = $Conteudo;
  }
}
?>