<?php
/*
Classe Pdf
Extende métodos a instância principal da classe TCPDF
Autor: Haroldo B Passos / InfinitusWeb
Copyrirght: 2010 / 2020 Versão: 1.01.001
Proximas alterações: Trabalhar com propriedadesanterior, melhorar font e fill, metodo debug
 */

class IWPdf
{
    public $iwPdf;
    private $__numCells;

    //$obj-> Handler do objeto instanciado com a classe TCPDF
    public function __construct($obj)
    {
        $this->iwPdf = $obj;
    }

    //Retorna número de celulas impressas para MUltcell=1 em pCell
    public function getNumCells()
    {
        return $this->numCells;
    }

    // Page footer
    public function pFooter()
    {
        $this->iwPdf->SetY(-5);
        $this->iwPdf->SetFont('helvetica', 'I', 7);
        // $this->iwPdf->getPageHeight()
        $this->iwPdf->Cell(0, 0, 'Página ' . $this->iwPdf->getAliasNumPage() . '/' . $this->iwPdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

    /*Print Cell (txt, 'x=0,y=0,w=0,h=0,align=L,border=0,l=0,font= ; ; ,multCell=N')
    Parâmpetro Posicional:
    txt -> texto a ser impresso
    parametros nomeados:
    x->  distância da margem esquerda para inicio da impressão em milímetros (se 0 pega o último)
    y -> distância da margem superior para inicio da impressão em milímetros (se 0 pega o último)
    w -> largura do elemento impresso em milímetros (se 0 pega o último)
    h -> altura do elemento impresso em  milímetros (se 0 pega o último)
    align -> Alinhamento (*L:à esquerda, R:à direita, C:ao centro, J: Justificado somente para multicell=1)
    J:  padrão para multicell, L: padrão para cell
    border -> Borda na célula(*0: sem borda ou 1: com borda ou (L:esquerda e/ou R:direita e/ou T:superior e/ou B:inferior combinados)
    ln -> Indica para onde a posição atual deve ir (0: para a direita, 1: para o início da próxima linha, 2: abaixo)
    1: default para multcell, 0: default para cell.
    font -> (family; Type; Size) parâmetros internos posicionais, não obrigatórios, se não informados mantém o último utilizado.
    -> family -> times (Times-Roman),timesb (Times-Bold),timesi (Times-Italic),timesbi (Times-BoldItalic)
    ,helvetica (Helvetica),helveticab (Helvetica-Bold),helveticai (Helvetica-Oblique),helveticabi (Helvetica-BoldOblique)
    ,courier (Courier),courierb (Courier-Bold),courieri (Courier-Oblique),courierbi (Courier-BoldOblique)
    ,symbol (Symbol),zapfdingbats (ZapfDingbats)
     * fontes padrões ou fonte adicionada por addFont().
    -> style -> estilo da fonte(*vazio: regular, B: bold e/ou I: italic e/ou U: underline e/ou D: line trough e/ou O: overline
     * combinados
    -> size -> Tamanho da fonte, se não informado pega o último utilizado
    fill -> Cor de preenchimento da célula (0: sem preenchimento, #00000: cor de preenchimento)
    link -> URL para acesso por clique se informado
    stretch -> esticar o caractere conforme o modo (*0:desativado,1:escala horizontal somente se necessário,
    2:escala horizontal forçada,3:espaçamento entre caracteres apenas se necessário,4: espaçamento forçado de caracteres

    calign -> alinhamento vertical do texto relativo a Y (T:parte superior da célula,C:ao centro,B:parte inferior da célula
    A : fonte superior,L:linha de base da fonte,D:parte inferior da fonte
    valign -> alinhamento vertical do texto dentro da célula (T: topo, M: meio,,B: inferior)
    multCell -> Imprime em várias linhas (*0: 1 linha, 1: multiplas linhas)

     ** Para  multcell = 1, parâmetros extras para multcell
     *métoto getMultcell retorna número de células
    reseth -> se verdadeiro redefine a altura da última célula (*1, 0).
    ishtml -> se verdadeiro texto em html,falso: texto simples(0*, 0);
    autopadding -> se verdadeiro, usa preenchimento interno e o ajusta automaticamente para levar em conta a largura da linha (*1,0)
    maxh -> altura máxima. Deve ser> =: he menos que o espaço restante na parte inferior da página, ou 0 para desativar esse recurso. Esse recurso funciona apenas quando: ishtml = 0.

    by Haroldo
     */
    public function pCell($txt, $pars = '', $mCellPars = '')
    {
        $this->numCells = 1;

        $pars      = $this->parsToObj($pars, 'x=0,y=0,w=0,h=0,align=L,border=0,ln=0,font=helvetica; ;10,color=0;-1;-1,fill=0,link= ,stretch=0, calign= , valign= , multCell=0');
        $mCellPars = $this->parsToObj($mCellPars, 'reseth=1,ishtml=0,autopadding=1,maxh=0');

        if ($pars->multCell) {
            $pars->align = 'J';
            $pars->ln    = 1;
        }

        $x = $pars->x;
        $y = $pars->y;

        //echo "$txt<pre>";
        //print_r($pars);
        //echo "</pre>";
        //$align = $pars->align;
        //$align = ($align == '0') ? "L" : $align;

        $x = $x == 0 ? $this->iwPdf->GetX() : $x;
        $y = $y == 0 ? $this->iwPdf->GetY() : $y;

        if (!empty($pars->font)) {
            $fontFamily = isset($pars->font[0]) ? $pars->font[0] : 'helvetica';
            $fontStyle  = isset($pars->font[1]) ? $pars->font[1] : '';
            $fontSize   = isset($pars->font[2]) ? $pars->font[2] : 0;
            $this->iwPdf->SetFont($fontFamily, $fontStyle, $fontSize);
            if (isset($pars->color)) {
                $this->iwPdf->SetTextColor($pars->color[0], $pars->color[1], $pars->color[2]);
            }
        }

        if (is_array($pars->fill)) {

            $this->iwPdf->SetFillColor($pars->fill[0], $pars->fill[1], $pars->fill[2]);
        }

        if (!$pars->multCell) {
            //echo "<br> Cell $x, $y";
            //#Cell(w, h = 0, txt = '', border = 0, ln = 0, align = '', fill = 0, link = nil, stretch = 0, ignore_min_height = false, calign = 'T', valign = 'M')
            $this->iwPdf->SetXY($x, $y);
            $this->iwPdf->Cell($pars->w, $pars->h, $txt, $pars->border, $pars->ln, $pars->align, $pars->fill, $pars->link, $pars->stretch, false, $pars->calign, $pars->valign);
        } else {
            //#MultiCell(w, h, txt, border = 0, align = 'J', fill = 0, ln = 1, x = '', y = '', reseth = true, stretch = 0, ishtml = false, autopadding = true, maxh = 0)            $this->iwPdf->SetXY($x, $y - ($pars->h / 2));
            $pars->reseth      = $pars->reseth ? true : false;
            $pars->ishtml      = $pars->ishtml ? true : false;
            $pars->autopadding = $pars->autopadding ? true : false;

            $this->numCells = $this->iwPdf->MultiCell($pars->w, $pars->h, $txt, $pars->border, $pars->align, $pars->fill, $pars->ln, $pars->x, $pars->y, $pars->reseth, $pars->stretch, $pars->ishtml = 0, $pars->autopadding = 1, $pars->maxh = 0);
        }
    }

    //regua para orientação durante desenvolvimento
    //By Haroldo
    public function regua($pars = '')
    {
        $pars = $this->parsToObj($pars, 'grade=1,l=210,a=297,color=217;121;69');

        //$grade = ($pars->grade) ? false : true;
        $l = $pars->l;
        $a = $pars->a;

        $this->iwPdf->SetTextColor($pars->color[0], $pars->color[1], $pars->color[2]); //(255, 139,71);
        $this->iwPdf->SetLineStyle(array('color' => array(237, 188, 119)));
        $this->iwPdf->SetFont('Courier', '', 6);
        $this->iwPdf->SetMargins(0, 0, 0);

        $m = 0; //esquerda
        for ($i = 1; $i <= $a - 5; $i++) {
            $m++;
            if ($m == 5) {
                $m = 0;
                $t = 3;
                $this->iwPdf->SetXY(1, $i - 2);
                $this->iwPdf->Cell(6, 3, $i, 0, 0, 'R');
                if ($pars->grade && $i >= 8 && $i <= $a - 6) {
                    $this->iwPdf->SetLineStyle(array('width' => 0.1));
                    $this->iwPdf->Line(8, $i, $l - 8, $i);
                }
                $this->iwPdf->SetLineStyle(array('width' => 0.3));
            } else {
                $t = 2;
                $this->iwPdf->SetLineStyle(array('width' => 0.1));
            }
            $this->iwPdf->Line(0, $i, $t, $i);
        }
        $m = 3; //direita
        for ($i = 4; $i <= $a; $i++) {
            $m++;
            if ($m == 5) {
                $m = 0;
                $t = 3;
                $this->iwPdf->SetXY($l - 6, $i - 2);
                if ($i > 5) {
                    $this->iwPdf->Cell(4, 0, $i, 0, 0, 'R');
                }

                $this->iwPdf->SetLineStyle(array('width' => 0.3));
            } else {
                $t = 2;
                $this->iwPdf->SetLineStyle(array('width' => 0.1));
            }
            $this->iwPdf->Line($l - $t, $i, $l, $i);
        }
        $m = 3; //superior
        for ($i = 4; $i <= $l; $i++) {
            $m++;
            if ($m == 5) {
                $m = 0;
                $t = 3;
                $this->iwPdf->SetXY($i - 1, 2);
                if ($i > 5 && $i < $l) {
                    $this->iwPdf->Cell(4, 3, $i, 0, 0, 'R');
                }

                if ($pars->grade && $i >= 8 && $i <= $l - 8) {
                    $this->iwPdf->SetLineStyle(array('width' => 0.1));
                    $this->iwPdf->Line($i, 6, $i, $a - 6);
                }
                $this->iwPdf->SetLineStyle(array('width' => 0.3));
            } else {
                $t = 2;
                $this->iwPdf->SetLineStyle(array('width' => 0.1));
            }
            $this->iwPdf->Line($i, 0, $i, $t);
        }
        $m = 0; //inferior
        for ($i = 1; $i <= $l - 6; $i++) {
            $m++;
            if ($m == 5) {
                $m = 0;
                $t = 3;
                $this->iwPdf->SetXY($i - 1, $a - 5);
                if ($i < $l - 5) {
                    $this->iwPdf->Cell(4, 3, $i, 0, 0, 'R');
                }

                $this->iwPdf->SetLineStyle(array('width' => 0.3));
            } else {
                $t = 2;
                $this->iwPdf->SetLineStyle(array('width' => 0.1));
            }
            $this->iwPdf->Line($i, $a, $i, $a - $t);
        }
    }

    //Método Mágico -> permite utilizar parametros nomeados nos demais métodos da classe
    //By Haroldo
    private function parsToObj($pars, $default)
    {
        $pars = !empty($pars) ? explode(',', $pars) : [];
        $res  = [];
        foreach ($pars as $value) {
            $arr    = explode('=', $value);
            $arr[0] = trim($arr[0]);
            $arr[1] = trim($arr[1]);
            if (strpos($arr[1], ';')) {
                $arr[1] = explode(';', $arr[1]);
            }
            $res[$arr[0]] = $arr[1];
        }
        $pars    = $res;
        $res     = [];
        $default = explode(',', $default);
        foreach ($default as $value) {
            $arr    = explode('=', $value);
            $arr[0] = trim($arr[0]);
            $arr[1] = trim($arr[1]);
            if (strpos($arr[1], ';')) {
                $arr[1] = explode(';', $arr[1]);
            }
            $res[$arr[0]] = $arr[1];
        }
        $json = json_encode(array_merge($res, $pars));
        return json_decode($json);
    }
}
