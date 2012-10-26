<?php /* Smarty version Smarty-3.1.8, created on 2012-10-25 13:25:04
         compiled from "/Users/antonvaneechaute/Sites/public_html/web/projects/framework-devine/web/../src/Devine/Framework/templates/error500.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1302737610508921901a5d52-84039648%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '69221c9072997dcf1b3e912a56bf0e64feca2e2e' => 
    array (
      0 => '/Users/antonvaneechaute/Sites/public_html/web/projects/framework-devine/web/../src/Devine/Framework/templates/error500.tpl',
      1 => 1337290595,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1302737610508921901a5d52-84039648',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'dev' => 0,
    'error' => 0,
    'trace' => 0,
    'message' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_508921902133b1_91537991',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_508921902133b1_91537991')) {function content_508921902133b1_91537991($_smarty_tpl) {?><div id="error500">
    <h1>Interne server fout.</h1>
    <?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['dev']->value){?><?php $_tmp1=ob_get_clean();?><?php echo $_tmp1;?>

    <p><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['error']->value;?>
<?php $_tmp2=ob_get_clean();?><?php echo $_tmp2;?>
</p>
    <h1>Stack trace</h1>
    <ul>
        <?php ob_start();?><?php  $_smarty_tpl->tpl_vars['message'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['message']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['trace']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['message']->key => $_smarty_tpl->tpl_vars['message']->value){
$_smarty_tpl->tpl_vars['message']->_loop = true;
?><?php $_tmp3=ob_get_clean();?><?php echo $_tmp3;?>

        <li><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['message']->value['file'];?>
<?php $_tmp4=ob_get_clean();?><?php echo $_tmp4;?>
 on line <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['message']->value['line'];?>
<?php $_tmp5=ob_get_clean();?><?php echo $_tmp5;?>
</li>
        <?php ob_start();?><?php } ?><?php $_tmp6=ob_get_clean();?><?php echo $_tmp6;?>

    </ul>
    <?php ob_start();?><?php }else{ ?><?php $_tmp7=ob_get_clean();?><?php echo $_tmp7;?>

    <p>De pagina die u probeert te bereiken kon niet worden geladen.</p>
    <?php ob_start();?><?php }?><?php $_tmp8=ob_get_clean();?><?php echo $_tmp8;?>

</div><?php }} ?>