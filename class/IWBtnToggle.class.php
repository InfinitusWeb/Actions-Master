<?PHP
/*
Classe Botão Estilo Toggle IOS
Por Haroldo Passos
Copyright© 2018 - Julho

Exemplo de uso:

//Incluindo a classe da biblitoeca externa
sc_include_library('prj','BtnToggle','btntoggle.class.php');

//instanciando a classe
$toggle = new BtnToggle();

// Método echoStyle
//criando estilo para botão:
//Parâmetro 1: tamanho (big, medium, small)
//Oarâmetro 2: nome da classe de estilo (livre, palavra sem espaços)
//Parâmetro 3: côr (pelo nome ou pelo valor #555555)
//Parâmetro 4: velocidade em décimso de segundos da transição dodeslise do botão

//** Todos os parâmetros não são obrigatórios **

$toggle->echoStyle('big', 'big_red','red', '0.5');
$toggle->echoStyle('medium', 'medium_blue','blue', '0.4');
$toggle->echoStyle('small');

//Método generateTag
//gera o html necessário para criação do botão.
//Parâmetro 1: id do seletor
//Parâmetro 2: nome da classe de estilo a ser usado (criado acima)
//Parâmetro 3: valor do evento onclick, geralmente chamada a um método javascript
//Parametro 4: 'checked' para iniciar botão habiolitado ou vazio

echo $toggle->generateTag('idtoggle1','big_red', "alert('big_red');");
echo $toggle->generateTag('idtoggle2','medium_blue', "alert('medium_blue');");
echo $toggle->generateTag('idtoggle3','small', "alert('small default');", 'checked');

//para checar use em jquery:  $(this'#id').is(':checked');

 */

class IWBtnToggle
{

    private $style;
    private $speedTransition;
    private $color;
    private $classNamePrefix;
    private $size;

    public function __construct()
    {
        $this->style['small']  = ".toggle_@prefix@{margin-bottom:3px}.toggle_@prefix@ > input{display:none}.toggle_@prefix@ > label{position:relative;display:block;height:13px;width:26px;background-color:#f7f7f7;border:1px #cacdce solid;border-radius:100px;cursor:pointer;transition:all @temp@s ease}.toggle_@prefix@ > label:after{position:absolute;left:.1px;top:.1px;display:block;width:13px;height:13px;border-radius:100px;background:#fff;box-shadow:0 2px 2px rgba(0,0,0,0.05);content:'';transition:all @temp@s ease}.toggle_@prefix@ > label:active:after{transform:scale(1.15,0.85)}.toggle_@prefix@ > input:checked ~ label{background-color:@color@;border-color:@color@}.toggle_@prefix@ > input:checked ~ label:after{left:13px}.toggle_@prefix@ > input:disabled ~ label{background-color:#d5d5d5;pointer-events:none}.toggle_@prefix@ > input:disabled ~ label:after{background-color:rgba(255,255,255,0.3)}";
        $this->style['medium'] = ".toggle_@prefix@{margin-bottom:3px}.toggle_@prefix@ > input{display:none}.toggle_@prefix@ > label{position:relative;display:block;height:18.5px;width:34.5px;background-color:#f7f7f7;border:1px #cacdce solid;border-radius:100px;cursor:pointer;transition:all @temp@s ease}.toggle_@prefix@ > label:after{position:absolute;left:.5px;top:.1px;display:block;width:18.5px;height:18.56px;border-radius:100px;background:#fff;box-shadow:0 2px 2px rgba(0,0,0,0.05);content:'';transition:all @temp@s ease}.toggle_@prefix@ > label:active:after{transform:scale(1.15,0.85)}.toggle_@prefix@ > input:checked ~ label{background-color:@color@;border-color:@color@}.toggle_@prefix@ > input:checked ~ label:after{left:16.55px}.toggle_@prefix@ > input:disabled ~ label{background-color:#d5d5d5;pointer-events:none}.toggle_@prefix@ > input:disabled ~ label:after{background-color:rgba(255,255,255,0.3)}";
        $this->style['big']    = ".toggle_@prefix@{margin-bottom:4px}.toggle_@prefix@ > input{display:none}.toggle_@prefix@ > label{position:relative;display:block;height:28px;width:52px;background-color:#f7f7f7;border:1px #cacdce solid;border-radius:100px;cursor:pointer;transition:all @temp@s ease}.toggle_@prefix@ > label:after{position:absolute;left:1px;top:1px;display:block;width:26px;height:26px;border-radius:100px;background:#fff;box-shadow:0 3px 3px rgba(0,0,0,0.05);content:'';transition:all @temp@s ease}.toggle_@prefix@> label:active:after{transform:scale(1.15,0.85)}.toggle_@prefix@ > input:checked ~ label{background-color:@color@;border-color:@color@}.toggle_@prefix@ > input:checked ~ label:after{left:25px}.toggle_@prefix@ > input:disabled ~ label{background-color:#d5d5d5;pointer-events:none}.toggle_@prefix@ > input:disabled ~ label:after{background-color:rgba(255,255,255,0.3)}";
        $this->color           = '#4cda64';
        $this->speedTransition = '0.4';
        $this->classNamePrefix = 'small';
        $this->size            = 'small';
    }

    public function echoStyle($size = null, $prefix = null, $color = null, $speed = null)
    {

        $size   = $size == null ? $this->size : $size;
        $prefix = $prefix == null ? $this->classNamePrefix : $prefix;
        $color  = $color == null ? $this->color : $color;
        $speed  = $speed == null ? $this->speedTransition : $speed;

        $style = str_replace('@prefix@', $prefix, $this->style[$size]);
        $style = str_replace('@color@', $color, $style);
        $style = str_replace('@temp@', $speed, $style);

        echo "<style>$style</style>";

    }

    public function generateTag($id, $prefix = 'small', $onclick = '', $checked = '')
    {
        $onclick = $onclick == '' ? '' : ' onclick="' . $onclick . '" ';
        return "<span class=\"toggle_$prefix\"><input type=\"checkbox\" id=\"$id\" $checked><label for=\"$id\" $onclick></label></span>";
    }

}
