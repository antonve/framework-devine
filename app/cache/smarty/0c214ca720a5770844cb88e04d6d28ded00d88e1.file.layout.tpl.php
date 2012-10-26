<?php /* Smarty version Smarty-3.1.8, created on 2012-10-23 17:27:09
         compiled from "/Users/antonvaneechaute/Sites/public_html/web/projects/framework-devine/app/templates/layout.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15670131205086b74db5ef79-87343436%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0c214ca720a5770844cb88e04d6d28ded00d88e1' => 
    array (
      0 => '/Users/antonvaneechaute/Sites/public_html/web/projects/framework-devine/app/templates/layout.tpl',
      1 => 1346274657,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15670131205086b74db5ef79-87343436',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'rootDir' => 0,
    'content' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5086b74db77ef0_46808894',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5086b74db77ef0_46808894')) {function content_5086b74db77ef0_46808894($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    
    <link href="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['rootDir']->value;?>
<?php $_tmp1=ob_get_clean();?><?php echo $_tmp1;?>
/css/screen.css" rel="stylesheet" type="text/css" media="all" />
    <script type="text/javascript" src="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['rootDir']->value;?>
<?php $_tmp2=ob_get_clean();?><?php echo $_tmp2;?>
/js/app.js"></script>
</head>

<body>
    <div id="container">
        <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['content']->value;?>
<?php $_tmp3=ob_get_clean();?><?php echo $_tmp3;?>

    </div>
</body>

</html><?php }} ?>