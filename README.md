# UNITEN

### Universidade do Trabalhador e do Empreendedor de Sorocaba

## Requisitos

- MySQL
- PHP 5+
- PHP Mail

## Instalação

1) Execute o script de banco **portal_uniten.sql**

2) Altere os dados de conexão com o MySQL nos seguintes arquivos, nos locais indicados:

- {{path}}/uniten/application/config/**database.php**
- {{path}}/uniten/intranet/util/**conn.php**
- {{path}}/uniten/**lumine-conf.php**
- {{path}}/uniten/**lumine-conf_front.php**

3) Rode a aplicação sob um servidor HTTP como Apache, IIS ou outros

4) Configure o PHP mail() (http://www.w3schools.com/php/php_ref_mail.asp)

## Site

- Acesse http://www.sorocaba.sp.gov.br/uniten/

## Intranet / Sistema

- Acesse http://www.sorocaba.sp.gov.br/uniten/intranet/

	**Admin user **

	- Logon: 5
	- Password: 123456

## Exibição de Erros

No arquivo **index.php**:

Exibição desligada:

	ini_set('display_errors', 0);

Exibição ligada

	ini_set('display_errors', 1);

## ERRO SQL

- O erro pode estar associado ao **DEFINER** das *functions* e *procedures* do MySQL.
- Por padrão, esse **DEFINER** é **"root@%"**
- Altere para o mesmo *user* que utiliza para conectar no banco. Exemplo: **myuser@%**