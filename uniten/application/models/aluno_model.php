<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LocaCursoAluno
 *
 * @author rogerio
 */
class Aluno_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function gravar($post) {

        $aLocaCurso = array();
        $aAluno = array();
        $aAluno['nome'] = $post['nome'];
        $aAluno['cpf'] = $post['cpf'];
        $aAluno['rg'] = $post['rg'];
        $aAluno['endereco'] = $post['endereco'];
        $aAluno['numero'] = $post['numero'];
        $aAluno['complemento'] = $post['complemento'];
        $aAluno['bairro'] = $post['bairro'];
        $aAluno['cidade'] = $post['cidade'];
        $aAluno['cep'] = $post['cep'];
        $aAluno['ctps'] = $post['ctps'];
        $aAluno['serie'] = $post['serie'];
        $aAluno['data_nascimento'] = $post['dataNascimento'];
        $aAluno['sexo'] = $post['sexo'];
        $aAluno['desempregado'] = $post['desempregado'];
        $aAluno['estado_civil'] = $post['estadoCivil'];
        $aAluno['possui_imovel'] = $post['possuiImovel'];
        $aAluno['situacao_habitacional'] = $post['situacaoHabitacional'];
        $aAluno['email'] = $post['email'];
        $aAluno['escolaridade'] = $post['escolaridade'];
        $aAluno['bolsa_familia'] = !empty($post['bolsaFamilia']) ? $post['bolsaFamilia'] : '';
        $aAluno['desempregado_tempo'] = $post['desempregadoTempo'];
        $aAluno['ddd'] = $post['ddd'];
        $aAluno['telefone'] = $post['telefone'];
        $aAluno['autonomo'] = $post['autonomo'];
        $aAluno['divulgacao'] = $post['divulgacao'];
        $aAluno['uniteemprega'] = isset($post['uniteemprega']) ? $post['uniteemprega'] : '';
        $aAluno['renda'] = $post['renda'];
        $aAluno['cor'] = $post['cor'];
        $aAluno['possui_deficiencia'] = $post['possuiDeficiencia'];
        $aAluno['tipo_deficiencia'] = $post['tipoDeficiencia'];
        $aAluno['condicao_especial_prova'] = isset($post['condicaoEspecialProva']) ? $post['condicaoEspecialProva'] : '';
        $aAluno['condicao_especial_qual'] = isset($post['condicaoEspecialQual']) ? $post['condicaoEspecialQual'] : '';
        $aAluno['pessoas_moradia'] = $post['pessoasMoradia'];
        $aAluno['dddCelular'] = !empty($post['dddCelular']) ? $post['dddCelular'] : '';
        $aAluno['celular'] = !empty($post['celular']) ? $post['celular'] : '';
        $aAluno['dddContato'] = !empty($post['dddContato']) ? $post['dddContato'] : '';
        $aAluno['telefoneContato'] = !empty($post['telfoneContato']) ? $post['telfoneContato'] : '';
       

        if (empty($post['id'])) {
            $this->db->insert('aluno', $aAluno);
            $codAluno = $this->db->insert_id();
        } else {
            $codAluno = $post['id'];
            $this->db->where('id', $codAluno);
            $this->db->update('aluno', $aAluno);
        }
       
        $aLocaCurso['local_curso_id'] = $post['agendacursos'][0];
        $aLocaCurso['aluno_id'] = $codAluno;
        $aLocaCurso['status'] = 0;
        $this->db->insert('local_curso_aluno', $aLocaCurso);
      
        return $codAluno;
    }

}
