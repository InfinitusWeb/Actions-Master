<?php
class IWDBMaint
{
    private $dbConn;
    private $rows;
    private $fetchMode;
    private $dbRs = "";
    private $dbSqlRs = "";
    private $dbError = "";

    //fetchMode ADODB_FETCH_[NUM, ASSOC, DEFAULT, BOTH]
    //$this-Db conexão corrente
    //$this->Ini->nm_db_'nome da conexão' conexão alternativa
    function __construct($conn = NULL, $fetchMode = '')
    {
        $this->dbConn = $conn;
        if ($fetchMode) {
            $this->setFetchMode($fetchMode);
            $this->fetchMode = $fetchMode;
        }
    }

    public function setFetchMode($fetchMode = '')
    {
        $this->dbConn->fetchMode = $fetchMode ?: $this->fetchMode;
    }

    public function execute($sql, $type = 'lookup')
    {
        if ($rs = $this->dbConn->Execute($sql)) {
            $this->rows = $rs->FieldCount();
            if ($type == 'lookup') {
                $return = $rs->fields;
                $rs->Close();
            } else {
                $return = $rs;
            }
            $this->setFetchMode();
        } elseif (isset($GLOBALS["NM_ERRO_IBASE"]) && $GLOBALS["NM_ERRO_IBASE"] != 1) {
            $return = false;
            $this->dbError = $this->dbConn->ErrorMsg();
        }
        return $return;
    }

    public function getRows()
    {
        return $this->rows;
    }

    public function getError()
    {
        return $this->dbError;
    }
}
