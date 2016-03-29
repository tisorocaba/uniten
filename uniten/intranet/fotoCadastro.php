<?php
require_once 'util/config.php';

Security::admSecurity();

$obj = new Galeria();
$obj->get($_GET['id']);

$foto= new GaleriaFoto();
$foto->alias('f')->where('f.galeria=?',$_GET['id'])->find();
logDao::gravaLog($user->login, 'fotoCadastro', 'Acessou: lista de fotos',$_REQUEST,'','Evento: '.$_GET['id']);

?>  
<br />
<script src="scripts/fotoCadastro.js"></script>
<form action="fotoLogic.php" name="form" id="form" method="post" enctype="multipart/form-data">
 
  <input type="hidden" name="galeria" id="galeria" value="<?=$_GET['id']?>">

  <br />

  <br />
  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                                      <tr>
                                        <td valign="top" class="conheca_titulo_1"><span class="conheca_titulo_2"><strong>Eventos  &raquo; <?php echo $obj->titulo?> &raquo; Fotos</strong></span>
                                          <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1">
                                        <tr>
                                          <td width="24%" bgcolor="#E1E1E1" class="normal_home"><strong>Eventos: </strong></td>
                                          <td width="76%" bgcolor="#F3F3F3" class="normal_home">
                                          <?php echo $obj->titulo?></td>
                                        </tr>
                                        <tr>
                                          <td bgcolor="#E1E1E1" class="normal_home"><strong>Comentário: </strong></td>
                                          <td bgcolor="#F3F3F3" class="normal_home"><input name="comentario" type="text" class="internas_normal" id="comentario"  size="70" /></td>
                                        </tr>
                                        <tr>
                                          <td bgcolor="#E1E1E1" class="normal_home"><strong>Foto: </strong></td>
                                          <td bgcolor="#F3F3F3" class="normal_home"><input name="foto" type="file" class="internas_normal" id="fot_imagem" value="" size="70" />
                                          <input type="submit" name="acao" id="btGravar" value="gravar" />
                                          (Somente JPG)</td>
                                        </tr>
                                        <tr>
                                          <td colspan="2" bgcolor="#E1E1E1" class="normal_home">
                                          
                                         
                                          
                                          
                                          <table width="100%" border="0">
                                          
                                            <?php
											
											 $i = 1;
											 $ini = "";
											 $fim ="";
											 while( $foto->fetch() ) { 
											
											 if($i == 1){
											 
											    $i = 2;
											    $ini = "<tr><td>";
											    $fim ="</td>";
											   
											 }elseif($i == 2){
											    $i = 3;
											    $ini = "<td>";
											    $fim ="</td>";
											 }else{
											    $i = 1;
											    $ini = "<td>";
											    $fim ="</td></tr>";
											 }
											  
											 ?>
                                              
                                              <?php echo $ini?>
                                                
                                                <table width="100%" border="0" id="caixa<?php echo $foto->id?>">
                                                  <tr>
                                                    <td width="11%">

                                                        <img alt=""  src="../thumbs.php?img=<?php echo $foto->foto?>&w=80&h=80"/>
                                                    </td>
                                                    <td width="89%"><table width="100%" border="0">
                                                      <tr>
                                                        <td class="normal_home">
                                                        <!--  <input type="radio" name="destacar" id="<?php echo $foto->id?>" value="destacar" class="destaque" 
                                                          <?php if($foto->capa==1){echo "checked=\"checked\""; }?>
                                                           />
                                                        Destaque
                                                        -->
                                                        </td>
                                                      </tr>
                                                      <tr>
                                                        <td><?php echo $foto->comentario?></td>
                                                      </tr>
                                                       <tr>
                                                        <td><input type="button" name="acao" id="<?php echo $foto->id?>" value="remover" class="remover" /></td>
                                                      </tr>
                                                    </table></td>
                                                  </tr>
                                                </table>
                                                 
                                                 <?php echo $fim?>
                                             <?php } ?>
                                           </table>

                                          
                                          
                                          
                                          
                                          </td>
                                          </tr>
                                            <tr>
                                              <td height="40" colspan="2" align="center" class="normal_home">
                                             <!--  <input name="voltar" type="button" value="voltar" onclick="history.go(-1)" />--></td>
                                            </tr>
                                          </table>
                                          
                                        </td>
    </tr>
</table>
</form>
<br />
<br />
<br />
<br />
<br />
