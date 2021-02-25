<?php
$act = new IWActions();
$pathAct = $act->getPathAction();
echo <<<HTML
<div style='top: 49%;left: 49%;position:absolute;'>
<script language="JavaScript" type="text/javascript">
document.write('<div id="loadings"><img src="$pathAct/img/loading.gif"></div>');
window.onload=function() {
document.getElementById("loadings").style.display="none";
}</script></div>
HTML;
