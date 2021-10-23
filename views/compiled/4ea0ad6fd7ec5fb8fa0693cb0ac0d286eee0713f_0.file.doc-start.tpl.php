<?php
/* Smarty version 3.1.40, created on 2021-10-23 16:09:53
  from 'C:\wamp64\codespace\local\metis\views\framework\doc-start.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.40',
  'unifunc' => 'content_617433d1215998_19935593',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4ea0ad6fd7ec5fb8fa0693cb0ac0d286eee0713f' => 
    array (
      0 => 'C:\\wamp64\\codespace\\local\\metis\\views\\framework\\doc-start.tpl',
      1 => 1635004804,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:toasts/notice.tpl' => 1,
  ),
),false)) {
function content_617433d1215998_19935593 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

    <title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>

    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['css']->value, 'file');
$_smarty_tpl->tpl_vars['file']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['file']->value) {
$_smarty_tpl->tpl_vars['file']->do_else = false;
?>
        <link rel="stylesheet" href="/assets/css/<?php echo $_smarty_tpl->tpl_vars['file']->value;?>
.css">
    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

</head>
<body>
    <?php if (!empty($_smarty_tpl->tpl_vars['notices']->value)) {?>
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['notices']->value, 'notice');
$_smarty_tpl->tpl_vars['notice']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['notice']->value) {
$_smarty_tpl->tpl_vars['notice']->do_else = false;
?>
            <?php $_smarty_tpl->_subTemplateRender('file:toasts/notice.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('notice'=>$_smarty_tpl->tpl_vars['notice']->value), 0, true);
?>
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    <?php }
}
}
