<?php
/* Smarty version 3.1.40, created on 2021-10-23 16:09:53
  from 'C:\wamp64\codespace\local\metis\views\layouts\page.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.40',
  'unifunc' => 'content_617433d11d2650_31094061',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '53d10d7b0ecd117880686517d455ba5744a137ad' => 
    array (
      0 => 'C:\\wamp64\\codespace\\local\\metis\\views\\layouts\\page.tpl',
      1 => 1635005311,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:framework/doc-start.tpl' => 1,
    'file:framework/sticky-navbar.tpl' => 1,
    'file:framework/doc-end.tpl' => 1,
  ),
),false)) {
function content_617433d11d2650_31094061 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
$_smarty_tpl->_subTemplateRender("file:framework/doc-start.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<main class="ui fluid container">

    <?php $_smarty_tpl->_subTemplateRender("file:framework/sticky-navbar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1815886713617433d11d0ed2_79952412', "content");
?>


</main>

<?php $_smarty_tpl->_subTemplateRender("file:framework/doc-end.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
/* {block "content"} */
class Block_1815886713617433d11d0ed2_79952412 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_1815886713617433d11d0ed2_79952412',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block "content"} */
}
