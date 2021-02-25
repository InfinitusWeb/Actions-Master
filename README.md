# IWAction Versão 1.0.05  12/05/2020
**Uma biblioteca para ser usada com Scriptcase.**

Video explicativo [youtube.com](https://youtu.be/3aI-8MgtbYE)

Conheça [Scriptcase](https://scriptcase.com.br)

Discussão em [Fórum](https://forum.scriptcase.com.br/)

Grupo [Telegram](https://t.me/joinchat/F1fMxkV3oNu6JVFxfJ1Xqg)

Grupo [WhatsApp](https://chat.whatsapp.com/I3sg8dHFfQqKJYjVgtQkM8)


# O que é IWAction Classe PHP?

São um conjuntos de scripts php, js, html e css para você poder criar uma barra de ferramentas em linha nas aplicações do tipo Grid no Scripcase.

O que faz essa Biblioteca?

* Adiciona texto, imagem (da Galeria de Imagens do Scriptcase ou de sua própria Galeria),  FontAwaesome 
* Permite link com aplicação Scriptcase ou uma URL abrindo  aplicação sobre a aplicação Grid corrente.
* Permite Link com aplicação Scriptcase ou URL abrindo em modal



# Instalação


**Na aplicação Grid** 

evento **onscriptinit**

```php
sc_include_library('prj','grid','actions-master/IWActions.class.php');
sc_include_library('prj','grid','actions-master/include.php');
```

evento **onrecord**

```php

$line = {sc_seq_register};

// Instanciando a Classe
$tb = new IWActions($line);

// Condição para apresentação da ação/imagem ou não
$tb->setCondition({campo}=='S'); 

// Gera Espaço entre os itens da barra de ferramentas
$tb->setItemSpace(5); 

// Utiliza uma barra separadora entre os itens (dark, light)
// Parâmtro 1 valores dark ou light (padrão)
$tb->setSeparator('dark'); 

// Acrescenta uma borda pontilhada abaixo do texto
// Sem parâmetros
$tb->setBorderBottom();

// Apresenta um texto no item . Parâmetros Posicionais
// Parâmetro 1 para condição verdadeira, 
// Parâmetro 2 para falsa (Opcional).
// Use setColor para atribuir cor as fontes
// Uset setTextStyle para atribuir etilos aos textos
$tb->setText('Linha 1', 'Linha ~'); 

// Atribui cores ao texto ou a Fontes Awesome
// Parâmetro 1 para item apresentado na condição verdadeira, 
// Parâmetro 2 para item apresentado na condição falsa (Opcional).
$tb->setColor('blue','red');

// Atribui estilos ao texto (qualquer estilo CSS aplicável a texto)
// Parâmetro 1 para item apresentado na condição verdadeira, 
// Parâmetro 2 para item apresentado na condição falsa (Opcional).
$tb->setTextStyle('color=blue, font-size=24', 'color=red, font-size=20');

// Muda o estilo do cursor ao item, veja estilos em [W3C](https://www.w3schools.com/cssref/pr_class_cursor.asp)
// Parâmetro 1 para item apresentado na condição verdadeira, 
// Parâmetro 2 para item apresentado na condição falsa (Opcional).
$tb->setCursor('pointer', 'help');

// Apreenta ToolTip acima do item
// Parâmetro 1 para item apresentado na condição verdadeira, 
// Parâmetro 2 para item apresentado na condição falsa (Opcional).
$tb->setToolTip('Texto','Texto');

// Apreenta ToolTip definido pelo método setToolTip a esquerda do item 
// Não utiliza parâmetros
$tb->setToolTipLeft();

// Apreenta ToolTip definido pelo método setToolTip abaixo do item 
// Não utiliza parâmetros
$tb->setToolTipBottom();

// Fecha o item e prepara para novo item na barra
$tb->close(); 

// Determina altura da Imagem
$tb->setImageHeight(24); 

// busca imagem na Galeria de imagens do Scriptcase 
// Parâmetros Posicionais
// Parâmetro 1: Imagem para Condição Verdadeira
// Parâmetro 2: (opcional) (Padrão: grp,img) categoria e tipo da imagem na galeria de Imagens do Scriptcase
// Parâmetro 3: (Opcional) Imagem da Galeria para Condição Falsa 
// Parâmetro 4: (opcional) (Padrão: mesmo do Parâmetro 2) categoria e tipo da imagem na galeria de Imagens do Scriptcase
$tb->setSCImage('carpeta_edita.png','sys,ico','cadeado.jpg');

$tb->close();

// MOnta link para acesso a aplicação baseado no Scriptcase 
$link = sc_make_link(aplicação,par1=val1;paar2=val2);

// Informa que item ser Link de chamada a aplicação, pode ser URL
// Abre no destino atual (_self) **Previsão de melhorias**
// Parâmetros Posicionais
// Parâmetro 1: Link para Condição Verdadeira
// Parâmetro 2: (Opcional) Link para Condição Falsa
$tb->setLink($link);

// Abre Link em Modal e atribue True a propriedade modal [$tb->Modal(true);]
// Parâmetros Nomeados informados por string todos opcionais
// Padrão se não Informado: 'maxWidth=80%, width=80%,background=#000,padding=5px,textAlign=center,height=80%'
// maxWidth (max-width) : Largura máxima da Modal
// width : Largura da Modal
// height : Altura da Modal
// background : Côr em Hexa ou Nominal do fundo da Modal
// padding : Espaçamento entre as margens e o conteúdo da Modal
// textAlign (text-align) : Alinhando do conteúdo da Modal
$tb->setModalStyle('width=40%');

// Informa imagem da Galeria pessoal do desenvolvedor adicionadas a pasta img no raiza da biblioteca externa criada
// Parâmtros posicionais
// Parâmtro 1 : Imagem para Condição Verdadeira
// Parâmtro 2 : (Opcional) Imagem para condição Falsa
$tb->setImage('editar.png');

$tb->close();

// Informa que o item da Barra de Ferramentas terá como exibição uma Fonte Awesome
// Parametros Posicionais
// Parâmetro 1 : Classe de Estilo para fonte em caso de COndição Verdadeira
// Parâmetro 2 :  (Opcional) Fonte Awesome para Concidção Falsa
// User setColor para atribuir cor as fontes
$tb->setAwesome('far fa-thumbs-up','far fa-thumbs-down');

$tb->close();

// Retorno Html da barra de ferramentas
// Fecha a Barra de Ferramentas e Deixa Preparado para crianão de outra Barra.
{action} = $tb->createToolBar();
ou
{action} = $tb->create();
```

# Notas:

**Parâmtros Posicionais** Cada parâmetro tem sua posição determinada conforme seu conteúdo

**Parâmtros Nomeados** O PHP não suporta (ainda parâmtros nomeados), então criei um Método Mágico para possibilitar informar os parâmtros pelos seus nomes sem a obriagação de posição exata (Na Classe o Método se chama `parsToObj($pars, $default)`)


**IMPLEMENTAÇÕES FUTURAS**
* Apresentação de Tooltip ao passar o mouse sobre os itens
* Ação do evento ajax onclick da Grid
* Dialog de Confirmação em SweetAlert antes da execução da Ação em evento Ajax

**Métodos e Bibliotecas de outros autores utilizados**

`get_leaf_dirs($dir)` por [Anton Backer 2006](https://www.php.net/manual/pt_BR/function.dir.php#60374)
Renomeada para `recursiveDir($dir)`

`jquery-modal` por [Kyle Fox](https://github.com/kylefox/jquery-modal)

**NÃO PIRATEIE CÓDIGOS DE OUTROS, RESPEITE OS DIREITOS AUTORAIS**
