<?php 
require_once 'util/config.php';
require_once 'dao/agendaCursoDao.php';
Security::admSecurity();
$agendaDao = new AgendaCursoDao();
$agenda = $agendaDao->escape($_REQUEST['agenda']);
$alunos = $agendaDao->listaAlunoAgenda($agenda);

?>

<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">
 
<head>
<meta http-equiv=Content-Type content="text/html; charset=iso-8859-1">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 14">
<link rel=File-List href="Pagina_arquivos/filelist.xml">
<style id="relatorio_15291_Styles"> 
<!--table
	{mso-displayed-decimal-separator:"\,";
	mso-displayed-thousand-separator:"\.";}
.xl6615291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6715291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6815291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:14.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6915291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:14.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:1.0pt solid black;
	border-right:none;
	border-bottom:none;
	border-left:1.0pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7015291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:14.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:1.0pt solid black;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7115291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:14.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Cambria, serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:1.0pt solid black;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7215291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:14.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:1.0pt solid black;
	border-right:1.0pt solid black;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7315291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:1.0pt solid black;
	border-right:none;
	border-bottom:1.0pt solid black;
	border-left:1.0pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7415291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:1.0pt solid black;
	border-right:none;
	border-bottom:1.0pt solid black;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7515291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:1.0pt solid black;
	border-right:none;
	border-bottom:1.0pt solid black;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7615291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:1.0pt solid black;
	border-right:1.0pt solid black;
	border-bottom:1.0pt solid black;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7715291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:1.0pt solid black;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7815291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:1.0pt solid black;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7915291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:1.0pt solid black;
	border-right:none;
	border-bottom:1.0pt solid black;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8015291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:1.0pt solid black;
	border-right:none;
	border-bottom:1.0pt solid black;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8115291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:1.0pt solid black;
	border-right:1.0pt solid black;
	border-bottom:1.0pt solid black;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8215291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:1.0pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8315291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8415291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	border-bottom:1.0pt solid black;
	border-left:1.0pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8515291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	border-bottom:1.0pt solid black;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8615291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:1.0pt solid black;
	border-right:1.0pt solid black;
	border-bottom:1.0pt solid black;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8715291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8815291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	border-bottom:1.0pt solid black;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8915291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	border-bottom:1.0pt solid black;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9015291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:none;
	border-right:1.0pt solid black;
	border-bottom:1.0pt solid black;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9115291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border-top:1.0pt solid black;
	border-right:1.0pt solid black;
	border-bottom:none;
	border-left:1.0pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9215291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:none;
	border-right:1.0pt solid black;
	border-bottom:1.0pt solid black;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9315291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border:1.0pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9415291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:1.0pt solid black;
	border-right:1.0pt solid black;
	border-bottom:1.0pt solid black;
	border-left:.5pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9515291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:1.0pt solid black;
	border-right:.5pt solid black;
	border-bottom:1.0pt solid black;
	border-left:1.0pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9615291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:1.0pt solid black;
	border-right:.5pt solid black;
	border-bottom:1.0pt solid black;
	border-left:.5pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9715291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:1.0pt solid black;
	border-right:none;
	border-bottom:1.0pt solid black;
	border-left:.5pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9815291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:none;
	border-right:1.0pt solid black;
	border-bottom:1.0pt solid black;
	border-left:1.0pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9915291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:1.0pt solid black;
	border-right:none;
	border-bottom:1.0pt solid black;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10015291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:1.0pt solid black;
	border-right:1.0pt solid black;
	border-bottom:1.0pt solid black;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10115291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid black;
	border-left:1.0pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10215291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:1.0pt solid black;
	border-right:none;
	border-bottom:.5pt solid black;
	border-left:1.0pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10315291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:1.0pt solid black;
	border-right:1.0pt solid black;
	border-bottom:.5pt solid black;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10415291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:none;
	border-right:.5pt solid black;
	border-bottom:.5pt solid black;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10515291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:none;
	border-right:.5pt solid black;
	border-bottom:.5pt solid black;
	border-left:.5pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10615291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid black;
	border-left:.5pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10715291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:1.0pt solid black;
	border-right:1.0pt solid black;
	border-bottom:.5pt solid black;
	border-left:1.0pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10815291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:none;
	border-right:1.0pt solid black;
	border-bottom:.5pt solid black;
	border-left:.5pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10915291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:.5pt solid black;
	border-right:1.0pt solid black;
	border-bottom:.5pt solid black;
	border-left:1.0pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11015291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:.5pt solid black;
	border-right:none;
	border-bottom:.5pt solid black;
	border-left:1.0pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11115291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:.5pt solid black;
	border-right:1.0pt solid black;
	border-bottom:.5pt solid black;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11215291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:.5pt solid black;
	border-right:.5pt solid black;
	border-bottom:.5pt solid black;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11315291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border:.5pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11415291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:.5pt solid black;
	border-right:none;
	border-bottom:.5pt solid black;
	border-left:.5pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11515291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:.5pt solid black;
	border-right:1.0pt solid black;
	border-bottom:.5pt solid black;
	border-left:.5pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11615291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:.5pt solid black;
	border-right:none;
	border-bottom:none;
	border-left:1.0pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11715291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:.5pt solid black;
	border-right:none;
	border-bottom:1.0pt solid black;
	border-left:1.0pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11815291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:.5pt solid black;
	border-right:1.0pt solid black;
	border-bottom:1.0pt solid black;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11915291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:.5pt solid black;
	border-right:.5pt solid black;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl12015291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:.5pt solid black;
	border-right:.5pt solid black;
	border-bottom:none;
	border-left:.5pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl12115291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:.5pt solid black;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl12215291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:.5pt solid black;
	border-right:1.0pt solid black;
	border-bottom:1.0pt solid black;
	border-left:1.0pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl12315291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:.5pt solid black;
	border-right:1.0pt solid black;
	border-bottom:none;
	border-left:.5pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl12415291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:1.0pt solid black;
	border-right:none;
	border-bottom:none;
	border-left:1.0pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl12515291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:1.0pt solid black;
	border-right:1.0pt solid black;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl12615291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:1.0pt solid black;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl12715291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:1.0pt solid black;
	border-right:1.0pt solid black;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl12815291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	border-bottom:1.0pt solid black;
	border-left:1.0pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl12915291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	border-bottom:1.0pt solid black;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl13015291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:1.0pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl13115291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:none;
	border-right:1.0pt solid black;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl13215291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:none;
	border-right:1.0pt solid black;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl13315291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:1.0pt solid black;
	border-right:none;
	border-bottom:none;
	border-left:1.0pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl13415291
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:none;
	border-right:1.0pt solid black;
	border-bottom:1.0pt solid black;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl101152911 {padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid black;
	border-left:1.0pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl74152911 {padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:1.0pt solid black;
	border-right:none;
	border-bottom:1.0pt solid black;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl74152912 {padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:1.0pt solid black;
	border-right:none;
	border-bottom:1.0pt solid black;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl74152913 {padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:1.0pt solid black;
	border-right:none;
	border-bottom:1.0pt solid black;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl741529131 {padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:1.0pt solid black;
	border-right:none;
	border-bottom:1.0pt solid black;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl741529132 {padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:1.0pt solid black;
	border-right:none;
	border-bottom:1.0pt solid black;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl741529133 {padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:1.0pt solid black;
	border-right:none;
	border-bottom:1.0pt solid black;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7415291311 {padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:1.0pt solid black;
	border-right:none;
	border-bottom:1.0pt solid black;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl102152911 {padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:1.0pt solid black;
	border-right:none;
	border-bottom:.5pt solid black;
	border-left:1.0pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
-->
</style>
</head>
 
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

 
<div id="relatorio_15291" align=center x:publishsource="Excel">
 
<table border=0 cellpadding=0 cellspacing=0 width=1081 class=xl6615291
 style='border-collapse:collapse;table-layout:fixed;width:808pt'>
 <col class=xl6615291 width=16 style='mso-width-source:userset;mso-width-alt:
 585;width:12pt'>
 <col class=xl6615291 width=10 style='mso-width-source:userset;mso-width-alt:
 365;width:8pt'>
 <col class=xl6615291 width=29 style='mso-width-source:userset;mso-width-alt:
 1060;width:22pt'>
 <col class=xl6615291 width=250 style='mso-width-source:userset;mso-width-alt:
 9142;width:188pt'>
 <col class=xl6615291 width=35 style='mso-width-source:userset;mso-width-alt:
 1280;width:26pt'>
 <col class=xl6615291 width=19 span=22 style='mso-width-source:userset;
 mso-width-alt:694;width:14pt'>
 <col class=xl6615291 width=170 style='mso-width-source:userset;mso-width-alt:
 6217;width:128pt'>
 <col class=xl6715291 width=26 style='mso-width-source:userset;mso-width-alt:
 950;width:20pt'>
 <col class=xl6715291 width=33 span=2 style='mso-width-source:userset;
 mso-width-alt:1206;width:25pt'>
 <col class=xl6615291 width=61 style='width:46pt'>
 <tr class=xl6815291 height=35 style='mso-height-source:userset;height:26.25pt'>
  <td height=35 class=xl6815291 width=16 style='height:26.25pt;width:12pt'></td>
  <td class=xl6815291 width=10 style='width:8pt'></td>
  <td class=xl6915291 width=29 style='width:22pt'>&nbsp;</td>
  <td class=xl7015291 width=250 style='width:188pt'>&nbsp;</td>
  <td class=xl7015291 width=35 style='width:26pt'>&nbsp;</td>
  <td class=xl7015291 width=19 style='width:14pt'>&nbsp;</td>
  <td class=xl7015291 width=19 style='width:14pt'>&nbsp;</td>
  <td class=xl7115291 colspan=11 width=209 style='width:154pt'>RELAT&Oacute;RIO DE
  CLASSE</td>
  <td class=xl7015291 width=19 style='width:14pt'>&nbsp;</td>
  <td class=xl7015291 width=19 style='width:14pt'>&nbsp;</td>
  <td class=xl7015291 width=19 style='width:14pt'>&nbsp;</td>
  <td class=xl7015291 width=19 style='width:14pt'>&nbsp;</td>
  <td class=xl7015291 width=19 style='width:14pt'>&nbsp;</td>
  <td class=xl7015291 width=19 style='width:14pt'>&nbsp;</td>
  <td class=xl7015291 width=19 style='width:14pt'>&nbsp;</td>
  <td class=xl7015291 width=19 style='width:14pt'>&nbsp;</td>
  <td class=xl7015291 width=19 style='width:14pt'>&nbsp;</td>
  <td class=xl7015291 width=170 style='width:128pt'>&nbsp;</td>
  <td class=xl7015291 width=26 style='width:20pt'>&nbsp;</td>
  <td class=xl7015291 width=33 style='width:25pt'>&nbsp;</td>
  <td class=xl7215291 width=33 style='width:25pt'>&nbsp;</td>
  <td class=xl6815291 width=61 style='width:46pt'></td>
 </tr>
 <tr height=21 style='mso-height-source:userset;height:15.75pt'>
  <td height=21 class=xl6615291 style='height:15.75pt'></td>
  <td class=xl6615291></td>
  <td colspan=2 rowspan="2" class=xl7315291>LOCAL <span >:<?php echo AgendaCurso::staticGet($agenda)->local->local?></span></td>
  <td class=xl7315291 colspan=3>PROJETO:</td>
  <td colspan="14" class=xl7415291><span ><?php echo Projeto::staticGet(AgendaCurso::staticGet($agenda)->local->projeto)->nome?></span></td>
  <td class=xl7415291 colspan=7>CURSO : <span><?php echo AgendaCurso::staticGet($agenda)->curso->nome?></span></td>
  <td class=xl7915291>&nbsp;</td>
  <td class=xl8015291>&nbsp;</td>
  <td class=xl8115291>&nbsp;</td>
  <td class=xl6615291></td>
 </tr>
 <tr height=21 style='mso-height-source:userset;height:15.75pt'>
  <td height=21 class=xl6615291 style='height:15.75pt'></td>
  <td class=xl6615291></td>
  <td class=xl8415291 colspan=3>MONITOR</td>
  <td colspan="20" class=xl8515291>&nbsp;</td>
  <td class=xl741529131><span class="">CARGA HOR&Aacute;RIA</span></td>
  <td class=xl8815291>&nbsp;</td>
  <td class=xl8915291>&nbsp;</td>
  <td class=xl9015291>&nbsp;</td>
  <td class=xl6615291></td>
 </tr>
 <tr height=21 style='mso-height-source:userset;height:15.75pt'>
  <td height=21 class=xl6615291 style='height:15.75pt'></td>
  <td class=xl6615291></td>
  <td class=xl8215291>&nbsp;</td>
  <td class=xl8315291></td>
  <td class=xl7315291 colspan=2>IN&Iacute;CIO</td>
  <td colspan="7" class=xl7415291 style='border-top:none'><span class=""><?php echo data_br(AgendaCurso::staticGet($agenda)->dataInicio)?></span></td>
  <td class=xl7315291 colspan=4>T&Eacute;RMINO</td>
  <td colspan="10" class=xl7415291 style='border-top:none'><span class=""><?php echo data_br(AgendaCurso::staticGet($agenda)->dataTermino)?></span></td>
  <td class=xl9115291>CONTE&Uacute;DO PROGRAM&Aacute;TICO</td>
  <td class=xl8815291 colspan=3 style='border-right:1.0pt solid black'><span
  style='mso-spacerun:yes'>   </span>RESULTADO</td>
  <td class=xl6615291></td>
 </tr>
 <tr height=21 style='mso-height-source:userset;height:15.75pt'>
  <td height=21 class=xl6615291 style='height:15.75pt'></td>
  <td class=xl6615291></td>
  <td class=xl9315291>NR&ordm;</td>
  <td class=xl9315291 style='border-left:none'>ALUNO</td>
  <td class=xl7315291 style='border-top:none;border-left:none'>DIA</td>
  <td class=xl9415291 style='border-top:none'>&nbsp;</td>
  <td class=xl9515291 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl9615291 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl9615291 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl9615291 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl9615291 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl9615291 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl9615291 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl9615291 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl9615291 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl9615291 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl9615291 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl9615291 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl9615291 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl9615291 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl9615291 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl9615291 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl9615291 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl9615291 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl9615291 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl9615291 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl9715291 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl9815291>&nbsp;</td>
  <td class=xl9915291 style='border-top:none'>NR&ordm;</td>
  <td class=xl9915291 style='border-top:none'>FALTA</td>
  <td class=xl10015291 style='border-top:none'>FINAL</td>
  <td class=xl6615291></td>
 </tr>
 
 <?php
     $i = 1;
     foreach($alunos as $aluno){ 
	 
	  ?>
         <tr class=xl6715291 height=16 style='mso-height-source:userset;height:12.0pt'>
          <td height=16 class=xl6715291 style='height:12.0pt'></td>
          <td class=xl6715291></td>
          <td class=xl10115291 align=right><?php echo $i?></td>
          <td class=xl10215291 style='border-top:none;text-transform: uppercase'>
           <?php echo $aluno->aluno?></td>
          <td class=xl10315291 style='border-top:none'><span class="xl102152911" style="border-top:none">
            
          </span></td>
          <td class=xl10415291>
          <?php if($aluno->passe==1){ echo "VT"; }?>
          </td>
          <td class=xl10515291 style='border-left:none'>&nbsp;</td>
          <td class=xl10515291 style='border-left:none'>&nbsp;</td>
          <td class=xl10515291 style='border-left:none'>&nbsp;</td>
          <td class=xl10515291 style='border-left:none'>&nbsp;</td>
          <td class=xl10515291 style='border-left:none'>&nbsp;</td>
          <td class=xl10515291 style='border-left:none'>&nbsp;</td>
          <td class=xl10515291 style='border-left:none'>&nbsp;</td>
          <td class=xl10515291 style='border-left:none'>&nbsp;</td>
          <td class=xl10515291 style='border-left:none'>&nbsp;</td>
          <td class=xl10515291 style='border-left:none'>&nbsp;</td>
          <td class=xl10515291 style='border-left:none'>&nbsp;</td>
          <td class=xl10515291 style='border-left:none'>&nbsp;</td>
          <td class=xl10515291 style='border-left:none'>&nbsp;</td>
          <td class=xl10515291 style='border-left:none'>&nbsp;</td>
          <td class=xl10515291 style='border-left:none'>&nbsp;</td>
          <td class=xl10515291 style='border-left:none'>&nbsp;</td>
          <td class=xl10515291 style='border-left:none'>&nbsp;</td>
          <td class=xl10515291 style='border-left:none'>&nbsp;</td>
          <td class=xl10515291 style='border-left:none'>&nbsp;</td>
          <td class=xl10515291 style='border-left:none'>&nbsp;</td>
          <td class=xl10615291 style='border-left:none'>&nbsp;</td>
          <td class=xl10715291 style='border-top:none'>&nbsp;</td>
          <td class=xl10415291 align=right><span ><?php echo $i?></span></td>
          <td class=xl10515291 style='border-left:none'>&nbsp;</td>
          <td class=xl10815291 style='border-left:none'>&nbsp;</td>
          <td class=xl6715291></td>
         </tr>
 <?php $i++; } ?>
 
 <tr class=xl6715291 height=17 style='mso-height-source:userset;height:12.75pt'>
   <td height=17 class=xl6715291 style='height:12.75pt'></td>
   <td class=xl6715291></td>
   <td class=xl11615291 align=right style='border-top:none'>&nbsp;</td>
   <td class=xl11715291 style='border-top:none'>&nbsp;</td>
   <td class=xl11815291 style='border-top:none'>&nbsp;</td>
   <td class=xl11915291 style='border-top:none'>&nbsp;</td>
   <td class=xl12015291 style='border-top:none;border-left:none'>&nbsp;</td>
   <td class=xl12015291 style='border-top:none;border-left:none'>&nbsp;</td>
   <td class=xl12015291 style='border-top:none;border-left:none'>&nbsp;</td>
   <td class=xl12015291 style='border-top:none;border-left:none'>&nbsp;</td>
   <td class=xl12015291 style='border-top:none;border-left:none'>&nbsp;</td>
   <td class=xl12015291 style='border-top:none;border-left:none'>&nbsp;</td>
   <td class=xl12015291 style='border-top:none;border-left:none'>&nbsp;</td>
   <td class=xl12015291 style='border-top:none;border-left:none'>&nbsp;</td>
   <td class=xl12015291 style='border-top:none;border-left:none'>&nbsp;</td>
   <td class=xl12015291 style='border-top:none;border-left:none'>&nbsp;</td>
   <td class=xl12015291 style='border-top:none;border-left:none'>&nbsp;</td>
   <td class=xl12015291 style='border-top:none;border-left:none'>&nbsp;</td>
   <td class=xl12015291 style='border-top:none;border-left:none'>&nbsp;</td>
   <td class=xl12015291 style='border-top:none;border-left:none'>&nbsp;</td>
   <td class=xl12015291 style='border-top:none;border-left:none'>&nbsp;</td>
   <td class=xl12015291 style='border-top:none;border-left:none'>&nbsp;</td>
   <td class=xl12015291 style='border-top:none;border-left:none'>&nbsp;</td>
   <td class=xl12015291 style='border-top:none;border-left:none'>&nbsp;</td>
   <td class=xl12015291 style='border-top:none;border-left:none'>&nbsp;</td>
   <td class=xl12015291 style='border-top:none;border-left:none'>&nbsp;</td>
   <td class=xl12115291 style='border-top:none;border-left:none'>&nbsp;</td>
   <td class=xl12215291 style='border-top:none'>&nbsp;</td>
   <td class=xl11915291 align=right style='border-top:none'>&nbsp;</td>
   <td class=xl12015291 style='border-top:none;border-left:none'>&nbsp;</td>
   <td class=xl12315291 style='border-top:none;border-left:none'>&nbsp;</td>
   <td class=xl6715291></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6615291 style='height:15.0pt'></td>
  <td class=xl6615291></td>
  <td class=xl12415291 colspan=2>Representante da Entidade</td>
  <td class=xl7815291 style='border-top:none'>&nbsp;</td>
  <td class=xl7815291>&nbsp;</td>
  <td class=xl7815291>&nbsp;</td>
  <td class=xl7815291>&nbsp;</td>
  <td class=xl7815291>&nbsp;</td>
  <td class=xl7815291>&nbsp;</td>
  <td class=xl7815291>&nbsp;</td>
  <td class=xl12415291>&nbsp;</td>
  <td class=xl7715291>&nbsp;</td>
  <td class=xl7715291>&nbsp;</td>
  <td class=xl7715291>&nbsp;</td>
  <td class=xl7715291>&nbsp;</td>
  <td class=xl7715291>&nbsp;</td>
  <td class=xl7715291>&nbsp;</td>
  <td class=xl7715291>&nbsp;</td>
  <td class=xl7715291>&nbsp;</td>
  <td class=xl7715291>&nbsp;</td>
  <td class=xl7715291>&nbsp;</td>
  <td class=xl7815291>&nbsp;</td>
  <td class=xl7815291>&nbsp;</td>
  <td class=xl7815291>&nbsp;</td>
  <td class=xl7815291>&nbsp;</td>
  <td class=xl7815291>&nbsp;</td>
  <td class=xl7715291 colspan=3><span
  style='mso-spacerun:yes'>                   </span>ASSINATURA DO MONITOR</td>
  <td class=xl12715291>&nbsp;</td>
  <td class=xl6615291></td>
 </tr>
 <tr height=21 style='mso-height-source:userset;height:15.75pt'>
  <td height=21 class=xl6615291 style='height:15.75pt'></td>
  <td class=xl6615291></td>
  <td class=xl12815291 colspan=5>O curso foi realizado conforme apontado neste
  relat&oacute;rio</td>
  <td class=xl12915291>&nbsp;</td>
  <td class=xl12915291>&nbsp;</td>
  <td class=xl12915291>&nbsp;</td>
  <td class=xl12915291>&nbsp;</td>
  <td class=xl13015291>&nbsp;</td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl13115291>&nbsp;</td>
  <td class=xl6615291></td>
  <td class=xl6715291></td>
  <td class=xl6715291></td>
  <td class=xl13215291>&nbsp;</td>
  <td class=xl6615291></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6615291 style='height:15.0pt'></td>
  <td class=xl6615291></td>
  <td class=xl13315291 colspan=2>NOME:</td>
  <td class=xl7815291 style='border-top:none'>&nbsp;</td>
  <td class=xl7815291 style='border-top:none'>&nbsp;</td>
  <td class=xl7815291 style='border-top:none'>&nbsp;</td>
  <td class=xl7815291 style='border-top:none'>&nbsp;</td>
  <td class=xl7815291 style='border-top:none'>&nbsp;</td>
  <td class=xl7815291 style='border-top:none'>&nbsp;</td>
  <td class=xl7815291 style='border-top:none'>&nbsp;</td>
  <td class=xl13015291>&nbsp;</td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl13115291>&nbsp;</td>
  <td class=xl6615291></td>
  <td class=xl6715291></td>
  <td class=xl6715291></td>
  <td class=xl13215291>&nbsp;</td>
  <td class=xl6615291></td>
 </tr>
 <tr height=10 style='mso-height-source:userset;height:7.5pt'>
  <td height=10 class=xl6615291 style='height:7.5pt'></td>
  <td class=xl6615291></td>
  <td class=xl12815291>&nbsp;</td>
  <td class=xl12915291>&nbsp;</td>
  <td class=xl12915291>&nbsp;</td>
  <td class=xl12915291>&nbsp;</td>
  <td class=xl12915291>&nbsp;</td>
  <td class=xl12915291>&nbsp;</td>
  <td class=xl12915291>&nbsp;</td>
  <td class=xl12915291>&nbsp;</td>
  <td class=xl12915291>&nbsp;</td>
  <td class=xl13015291>&nbsp;</td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl13115291>&nbsp;</td>
  <td class=xl6615291></td>
  <td class=xl6715291></td>
  <td class=xl6715291></td>
  <td class=xl13215291>&nbsp;</td>
  <td class=xl6615291></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6615291 style='height:15.0pt'></td>
  <td class=xl6615291></td>
  <td class=xl13315291 style='border-top:none'>RG:</td>
  <td class=xl7815291 style='border-top:none'>&nbsp;</td>
  <td class=xl7815291 style='border-top:none'>&nbsp;</td>
  <td class=xl7815291 style='border-top:none'>&nbsp;</td>
  <td class=xl7815291 style='border-top:none'>&nbsp;</td>
  <td class=xl7815291 style='border-top:none'>&nbsp;</td>
  <td class=xl7815291 style='border-top:none'>&nbsp;</td>
  <td class=xl7815291 style='border-top:none'>&nbsp;</td>
  <td class=xl7815291 style='border-top:none'>&nbsp;</td>
  <td class=xl13015291>&nbsp;</td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl6615291></td>
  <td class=xl13115291>&nbsp;</td>
  <td class=xl6615291></td>
  <td class=xl6715291></td>
  <td class=xl6715291></td>
  <td class=xl13215291>&nbsp;</td>
  <td class=xl6615291></td>
 </tr>
 <tr height=10 style='mso-height-source:userset;height:7.5pt'>
  <td height=10 class=xl6615291 style='height:7.5pt'></td>
  <td class=xl6615291></td>
  <td class=xl12815291>&nbsp;</td>
  <td class=xl12915291>&nbsp;</td>
  <td class=xl12915291>&nbsp;</td>
  <td class=xl12915291>&nbsp;</td>
  <td class=xl12915291>&nbsp;</td>
  <td class=xl12915291>&nbsp;</td>
  <td class=xl12915291>&nbsp;</td>
  <td class=xl12915291>&nbsp;</td>
  <td class=xl12915291>&nbsp;</td>
  <td class=xl12815291>&nbsp;</td>
  <td class=xl12915291>&nbsp;</td>
  <td class=xl12915291>&nbsp;</td>
  <td class=xl12915291>&nbsp;</td>
  <td class=xl12915291>&nbsp;</td>
  <td class=xl12915291>&nbsp;</td>
  <td class=xl12915291>&nbsp;</td>
  <td class=xl12915291>&nbsp;</td>
  <td class=xl12915291>&nbsp;</td>
  <td class=xl12915291>&nbsp;</td>
  <td class=xl12915291>&nbsp;</td>
  <td class=xl12915291>&nbsp;</td>
  <td class=xl12915291>&nbsp;</td>
  <td class=xl12915291>&nbsp;</td>
  <td class=xl12915291>&nbsp;</td>
  <td class=xl13415291>&nbsp;</td>
  <td class=xl12915291>&nbsp;</td>
  <td class=xl8915291>&nbsp;</td>
  <td class=xl8915291>&nbsp;</td>
  <td class=xl9015291>&nbsp;</td>
  <td class=xl6615291></td>
 </tr>
 <![if supportMisalignedColumns]>
 <tr height=0 style='display:none'>
  <td width=16 style='width:12pt'></td>
  <td width=10 style='width:8pt'></td>
  <td width=29 style='width:22pt'></td>
  <td width=250 style='width:188pt'></td>
  <td width=35 style='width:26pt'></td>
  <td width=19 style='width:14pt'></td>
  <td width=19 style='width:14pt'></td>
  <td width=209 style='width:14pt'></td>
  <td width=19 style='width:14pt'></td>
  <td width=19 style='width:14pt'></td>
  <td width=19 style='width:14pt'></td>
  <td width=19 style='width:14pt'></td>
  <td width=19 style='width:14pt'></td>
  <td width=19 style='width:14pt'></td>
  <td width=19 style='width:14pt'></td>
  <td width=19 style='width:14pt'></td>
  <td width=19 style='width:14pt'></td>
  <td width=19 style='width:14pt'></td>
  <td width=19 style='width:14pt'></td>
  <td width=19 style='width:14pt'></td>
  <td width=19 style='width:14pt'></td>
  <td width=19 style='width:14pt'></td>
  <td width=19 style='width:14pt'></td>
  <td width=19 style='width:14pt'></td>
  <td width=19 style='width:14pt'></td>
  <td width=19 style='width:14pt'></td>
  <td width=19 style='width:14pt'></td>
  <td width=170 style='width:128pt'></td>
  <td width=26 style='width:20pt'></td>
  <td width=33 style='width:25pt'></td>
  <td width=33 style='width:25pt'></td>
  <td width=61 style='width:46pt'></td>
 </tr>
 <![endif]>
</table>
 
</div>
 
 
<!----------------------------->
<!--FIM DA SA�DA DO 'ASSISTENTE PARA PUBLICA��O COMO P�GINA DA WEB' DO EXCEL-->
<!----------------------------->
</body>
 
</html>

