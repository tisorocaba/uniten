<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style>
.container {
	width: 680px;
	margin: 0px auto;
	height:895px;
	font-family:Arial, Helvetica, sans-serif;
	border:1px solid #fff;
	background:url(modelo/certificado/fundo.jpg) no-repeat;
	text-align: center; }

p{
	width:388px;
	margin:0px auto;
	margin-top:115px;
	text-align:center;
	font-size:12px;
	line-height:13px;
}



p.certifica-se{
	text-align:center;
	float:left;
	margin:0;
	font-size:11px;
	margin-left:250px;
	width:177px;
	margin-top:200px;
	font-family:Arial, Helvetica, sans-serif;
	font-size:18px
}

p.aluno{
	text-align:center;
	float:left;
	margin:0;
	font-size:11px;
	margin-left:190px;
	width:300px;
	margin-top:50px;
	font-family:Arial, Helvetica, sans-serif;
	font-size:15px;
	text-transform:uppercase
}

p.participou{
	text-align:center;
	float:left;
	margin:0;
	font-size:11px;
	margin-left:250px;
	width:195px;
	margin-top:50px;
	font-family:Arial, Helvetica, sans-serif;
	font-size:18px
}

p.curso{
	text-align:center;
	float:left;
	margin:0;
	font-size:11px;
	margin-left:190px;
	width:300px;
	margin-top:50px;
	font-family:Arial, Helvetica, sans-serif;
	font-size:15px;
	text-transform:uppercase;
}
p.carga{
	text-align:center;
	float:left;
	font-size:11px;
	margin-left:200px;
	width:280px;
	margin-top:50px;
	font-family:Arial, Helvetica, sans-serif;
	font-size:18px;
	margin-right: 0;
	margin-bottom: 0;
}

p.data{
	text-align:center;
	float:left;
	font-size:11px;
	margin-left:200px;
	width:280px;
	margin-top:50px;
	font-family:Arial, Helvetica, sans-serif;
	font-size:18px;
	margin-right: 0;
	margin-bottom: 0;
}

@page {
            margin-top: 1em;
            margin-left: 1em;
        }

</style>
</head>

<body>
<div class="container">
	
    
  <p>&nbsp;</p>
<br />

<p class="certifica-se">
Certifica-se que
</p>

<p class="aluno">
{ALUNO}
</p>

<p class="participou">
participou do Curso de
</p>

<p class="curso">{CURSO}</p>
<p class="carga">com carga hor&aacute;ria de {CARGA} horas.</p>
<p class="data">{DATA}.</p>
</div>
</body>
</html>
