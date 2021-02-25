<?php
/*
Classe Php DataGrid
Por Haroldo Passos
Copyright© 2015
*/

class IWDataGrid {

    private $Style;
    private $StyleCol;
    private $tagName;
    private $Html;
    private $CellCount;
    private $Columns;
    private $ZebraColor;
    private $ZebraFlag;
    private $LineNum;

    public function __construct($Columns = null) {

//        ESTILO PADRÃO DA TABELA
//        $this->Style['Table'] = [];
        $this->Style['Table']['border'] = '1';
        $this->Style['Table']['bordercolor'] = 'LIGHTGRAY';
        $this->Style['Table']['cellspacing'] = '0.1';
        $this->Style['Table']['cellpadding'] = '1';
        $this->Style['Table']['style']['text-align'] = 'left';
        $this->Style['Table']['style']['border-collapse'] = 'collapse';


//        ESTILO PADRÃO DO CABEÇALHO
//        $this->Style['Header'] = [];
//        $this->Style['Header']['bgcolor'] = 'GRAY';
        $this->Style['Header']['style']['background-color'] = 'GRAY';
        $this->Style['Header']['style']['text-align'] = 'center';
        $this->Style['Header']['style']['color'] = 'white';
        $this->Style['Header']['style']['font-size'] = 'x-small';


//        ESTILO PADRÃO DAS LINHAS
        $this->Style['Row']['style']['font-size'] = 'small';
//		$this->Style['Row']['style']['background-color'] = 'WHITE !IMPORTANT';


//        TRADUTOR DE TAGS        
        $this->tagName['Table'] = 'table';
        $this->tagName['Header'] = 'tr';
        $this->tagName['Header_Cell'] = 'th';
        $this->tagName['Row'] = 'tr';
        $this->tagName['Cell'] = 'td';

//        Contadores
        $this->CellCount = 0;
        $this->Columns = $Columns;


//        ZEBRANDO A TABELA
        $this->ZebraColor = 'GhostWhite';
        $this->ZebraFlag = False;
    }

//    ADICIONA ESTILOS__SPC&SPC__ATRIBUTOS A UMA TAG
    public function setStyle($tag, $type, $val, $col = null) {
        $t = strtolower($type);
        $v = $val; //strtolower($val);
        if ($t === 'style'):
            $v = explode(':', $v);
            if ($col === NULL):
                $this->Style[$tag][$t][$v[0]] = $v[1];
            else:
                $this->StyleCol[$tag][$col][$t][$v[0]] = $v[1];
            endif;
        else:
            if ($col === NULL):
                $this->Style[$tag][$t] = $v;
            else:
                $this->StyleCol[$tag][$col][$t] = $v;
            endif;
        endif;
    }

//    RESETA UM ESTILO
    public function resetStyle($tag, $type, $val, $col = null) {
        if (!$col):
            unset($this->Style[$tag][$type][$val]);
        else:
            unset($this->StyleCol[$tag][$col][$type][$val]);
        endif;
    }

//    AGRUPA TIPOS DE ESTILOS AO ATRIBUTO STYLE
    private function agroup_styles($arr) {
        $styles = '';
        while ($val = current($arr)) {
            $styles .= key($arr) . ':' . $val . ';';
            next($arr);
        }
        $styles = ' style="' . $styles . '" ';
        return $styles;
    }

//  ABRINDO TAG
    private function openTag($tagName) {

        if ($tagName == 'Row') {
            $this->LineNum++;
        }

        if ($this->ZebraFlag) {
            $this->applyZebra();
        }

        $tag = "<" . $this->tagName[$tagName];

//        TEM ATRIBUTO PARA TAGNAME
        if (isset($this->Style[$tagName])):
            foreach ($this->Style[$tagName] as $key => $styleVal) {
                if (is_array($styleVal)):
                    $tag .= $this->agroup_styles($styleVal);
                else:
                    $tag .= ' ' . $key . '="' . $styleVal . '" ';
                endif;
            }
        endif;

//        TEM ESTILO/ATRIBUTO PARA A COLUNA
        if (isset($this->StyleCol[$tagName][$this->CellCount])):
            foreach ($this->StyleCol[$tagName][$this->CellCount] as $key => $styleVal) {
                if (is_array($styleVal)):
                    $tag .= $this->agroup_styles($styleVal);
                else:
                    $tag .= ' ' . $key . '="' . $styleVal . '" ';
                endif;
            }
        endif;

        $tag .= ">";

//        RESETANDO BACKGROUND-COLOR
        $this->resetStyle('Row', 'style', 'background-color');
        $this->resetStyle('Row', 'style', 'color');


        return $tag;
    }

//  FECHANDO TAG
    private function closeTag($tagName) {
        return "</" . $this->tagName[$tagName] . ">";
    }

//  ADICIONANDO CABEÇALHO A TABELA
    public function addHeader($val) {

//      ABRINDO A TAG DO CABEÇALHO
        if (!$this->CellCount):
            $this->Html .= $this->openTag('Header');
        endif;

//      ATRIBUINDO VALOR A CÉLULA DO CABEÇALHO
        if (is_array($val)):
            $this->Columns = count($val);
            $this->CellCount = 0;
            while ($content = current($val)) {
                $this->Html .= $this->openTag('Header_Cell');
                $this->Html .= $content;
                $this->Html .= $this->closeTag('Header_Cell');
                $this->CellCount++;
                next($val);
            }
        else:
            $this->Html .= $this->openTag('Header_Cell');
            $this->Html .= $val;
            $this->Html .= $this->closeTag('Header_Cell');
            IF (isset($this->Style['Header_Cell']['colspan']) and $this->Style['Header_Cell']['colspan']):
                $this->CellCount = $this->CellCount + $this->Style['Header_Cell']['colspan'];
                unset($this->Style['Header_Cell']['colspan']);
            else:
                $this->CellCount++;
            endif;
        endif;


//      FECHANDO TAG DO CABEÇALHO
        if ($this->CellCount >= $this->Columns):
            $this->Html .= $this->closeTag('Header');
            $this->CellCount = 0;
        endif;
    }

//    SETANDO INICIO DO ZEBRADO__SPC&SPC__DO FUNDO DA LINHA
    public function setZebraColor($cor = FALSE) {
        if ($cor && $cor !== TRUE) {
            $this->ZebraColor = $cor;
        }
        if ($cor) {
            $this->ZebraFlag = True;
        } else {
            $this->ZebraFlag = False;
        }
    }

    public function applyZebra() {
        if (!isset($this->Style['Row']['style']['background-color'])):
            if (!($this->LineNum % 2)) {
                $this->Style['Row']['style']['background-color'] = $this->ZebraColor;
            } else {
                $this->resetStyle('Row', 'style', 'background-color');
            }
        endif;
    }

    //    ADICIONAR COLUNAS
    public function addCell($val) {
//      ABRINDO A TAG DA LINHA
        if (!$this->CellCount):
            $this->Html .= $this->openTag('Row');
        endif;

//      ATRIBUINDO VALOR A CÉLULA DA LINHA
        if (is_array($val)):
            $this->Columns = count($val);
            //echo  "**** ".$this->Columns ."<hr>";
            $this->CellCount = 0;
            foreach ($val as $content) {
//                echo  "**** ".$this->Columns ." ***" .$this->CellCount."<hr>";
                $this->Html .= $this->openTag('Cell');
                $this->Html .= $content;
                $this->Html .= $this->closeTag('Cell');
                $this->CellCount++;
            }
        else:
            $this->Html .= $this->openTag('Cell');
            $this->Html .= $val;
            $this->Html .= $this->closeTag('Cell');
            IF (isset($this->Style['Cell']['colspan']) and $this->Style['Cell']['colspan'] >= 0):
                $this->CellCount = $this->CellCount + $this->Style['Cell']['colspan'];
                unset($this->Style['Cell']['colspan']);
            else:
                $this->CellCount++;
            endif;

        endif;

//      FECHANDO TAG DA LINHA
        if ($this->CellCount >= $this->Columns):
            $this->Html .= $this->closeTag('Row');
            $this->CellCount = 0;
        endif;
    }

//    FINALIZA HTML
    public function create() {
        $this->Html = $this->openTag('Table') . $this->Html;
        $this->Html .= $this->closeTag('Table');
        return $this->Html;
    }

}