<?php
require_once '../util/config.php';
Security::cursoSecurity();
$user = unserialize($_SESSION['USER']);



$dataini = Empresa::staticGet((int) $_POST['empresa'])->escape(data_us($_POST['data_inicio']));
$datafinal = Empresa::staticGet((int) $_POST['empresa'])->escape(data_us($_POST['data_fim']));


logDao::gravaLog($user->login, 'gastosPesquisa', 'Visualizou: resultado pesquisa relatorio financeiro', $_REQUEST, '', 'Periodo: ' . $_POST['data_inicio'] . ' a ' . $_POST['data_fim'] . ' Empresa: ' . $_POST['empresa']);



$sql = 'SELECT
   
    local_curso_id as id,
    (select nome from curso C, local_curso LC where LC.id = local_curso_id and LC.curso_id = C.id) as curso,
    
(select data_inicio from curso C, local_curso LC where LC.id = local_curso_id and LC.curso_id = C.id) as inicio,
(select periodo from curso C, local_curso LC where LC.id = local_curso_id and LC.curso_id = C.id) as periodo,
 
(select local from local L, local_curso LC where LC.id = local_curso_id and LC.local_id = L.id) as local,
    
    (select 
     (select sum(carga_horaria) as carga  from disciplina D, curso_disciplina CD WHERE CD.curso_id = C.id and CD.disciplina_id = D.id) as carga
      from curso C, local_curso LC where LC.id = local_curso_id and LC.curso_id = C.id)  as carga,
      
      (select valor from local_curso where local_curso_id = id) as valor,
      
      ROUND((select valor from local_curso where local_curso_id = id) / (select 
     (select sum(carga_horaria) as carga  from disciplina D, curso_disciplina CD WHERE CD.curso_id = C.id and CD.disciplina_id = D.id) as carga
      from curso C, local_curso LC where LC.id = local_curso_id and LC.curso_id = C.id),2 ) as valor_hora,
      
     ROUND( ((select valor from local_curso where local_curso_id = id) / (select 
     (select sum(carga_horaria) as carga  from disciplina D, curso_disciplina CD WHERE CD.curso_id = C.id and CD.disciplina_id = D.id) as carga
      from curso C, local_curso LC where LC.id = local_curso_id and LC.curso_id = C.id)  )  * (SEC_TO_TIME( SUM( TIME_TO_SEC( `horas` ) ) )),2) as valor_pagar,
      
      (SEC_TO_TIME( SUM( TIME_TO_SEC( `horas` ) ) )) as horas_completas, 

      (select sum(vale)*2  from diario_classe_aluno where diario_classe_id = id) as vales,
      (select valor_vale from local_curso where local_curso_id = id) as valor_vale,
      
      (select sum(vale)*2  from diario_classe_aluno where diario_classe_id = id)*(select valor_vale from local_curso where local_curso_id = id) as gasto_vale
 

FROM diario_classe 
where  data_aula >= "' . $dataini . '" 
and data_aula <= "' . $datafinal . '" 
and local_curso_id 
in (select id from local_curso where empresa_curso_id = "' . (int) $_POST['empresa'] . '")
group by local_curso_id

';

$_SESSION['SQL'] = $sql;
$_SESSION['DATAINI'] = $_POST['data_inicio'];
$_SESSION['DATAFINAL'] = $_POST['data_fim'];
$_SESSION['EMPRESACOD'] = $_POST['empresa'];

gotox('principal.php?acao=financeiroPesquisaResultado');