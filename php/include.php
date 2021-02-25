<?php
$dirs = recursiveDir('../_lib/libraries');
foreach ($dirs as $path) {
  $pos = strpos($path, 'actions-master');
  if (is_numeric($pos)) {
    break;
  }
}
$path = substr($path, 0,  $pos - 1);
$pathAction = $path . '/actions-master';

echo "<script src={$pathAction}/js/jquery.modal.min.js></script>";
echo "<link rel='stylesheet' href='{$pathAction}/css/jquery.modal.min.css' />";
echo "<link rel='stylesheet' href='{$pathAction}/css/w3.css' />";

echo <<<HTML
<style type="text/css">
a.action-link {
  text-decoration: none;
}

a.action-link:hover {
  text-decoration: none;
  	border-bottom: 1px dotted #7DB6E2;
}

.modal a.close-modal[class*="icon-"] {
  top: -10px;
  right: -10px;
  width: 20px;
  height: 20px;
  color: #fff;
  line-height: 1.25;
  text-align: center;
  text-decoration: none;
  text-indent: 0;
  background: #900;
  border: 2px solid #fff;
  -webkit-border-radius: 26px;
  -moz-border-radius: 26px;
  -o-border-radius: 26px;
  -ms-border-radius: 26px;
  -moz-box-shadow:    1px 1px 5px rgba(0,0,0,0.5);
  -webkit-box-shadow: 1px 1px 5px rgba(0,0,0,0.5);
  box-shadow:         1px 1px 5px rgba(0,0,0,0.5);
}

.tooltip {
	position: relative;
	display: inline-block;
}

.borderBottom {
	border-bottom: 1px dotted black;
}

.tooltip .tooltiptext {
  visibility: hidden;
  width: auto;
  white-space:nowrap;
  background-color: black;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px;
  position: absolute;
  z-index: 1;
  bottom: 150%;
  left: 50%;
  margin-left: -60px;
	opacity: 0;
	transition: opacity 0.7s;
	word-wrap: break-word;
}

.tooltip .tooltiptext::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: black transparent transparent transparent;
}

.tooltip:hover .tooltiptext {
  visibility: visible;
	opacity: 1;
}


.tooltip .tooltiptext_left {
  visibility: hidden;
  width: auto;
  white-space:nowrap;
  background-color: black;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 4px;
  position: absolute;
  z-index: 1;
  top: 0px;
  right: 110%;

}

.tooltip .tooltiptext_left::after {
  content: "";
  position: absolute;
  top: 50%;
  left: 100%;
  margin-top: -5px;
  border-width: 4px;
  border-style: solid;
  border-color: transparent transparent transparent black;
}

.tooltip:hover .tooltiptext_left {
  visibility: visible;
}

.tooltip .tooltiptext_bottom {
  visibility: hidden;
  width: auto;
  white-space:nowrap;
  background-color: black;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px;
  position: absolute;
  z-index: 1;
  top: 150%;
  left: 50%;
  margin-left: -60px;
}

.tooltip .tooltiptext_bottom::after {
  content: "";
  position: absolute;
  bottom: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: transparent transparent black transparent;
}

.tooltip:hover .tooltiptext_bottom {
  visibility: visible;
}
</style>
<div  id="modal-form"  class = "modal">
  <iframe id=modal-form-iframe  style='allowfullscreen:true;border:0;width:100%'></iframe>
</div>
<script>
$(document).ready(function () {
     $('a[href="#login-form"]').click(function(event) {
        event.preventDefault();
        $(this).modal({
            escapeClose: false,
          clickClose: false,
          showClose: true,
          fadeDelay: 0.50
        });
        $('#modal-form-iframe').css('height',$(".modal").height()-40);
    });
});
function modalHtml(html) {
   $('#modal-form').html(html);
}
function modalIframeSrc(src) {
    $('#modal-form-iframe').attr('src', src);
    $('#modal-form').modal();
}

function modalStyle(style) {
    $('#modal-form').attr('style', style);
    $('#modal-form-iframe').css('height', $(".modal").height() - 40);
}
</script>
HTML;

function recursiveDir($dir)
{
  $array = array();
  $d = dir($dir);
  while (false !== ($entry = $d->read())) {
    if ($entry != '.' && $entry != '..') {
      $entry = $dir . '/' . $entry;
      if (is_dir($entry)) {
        $subdirs = recursiveDir($entry);
        if ($subdirs)
          $array = array_merge($array, $subdirs);
        else
          $array[] = $entry;
      }
    }
  }
  $d->close();
  return $array;
}
