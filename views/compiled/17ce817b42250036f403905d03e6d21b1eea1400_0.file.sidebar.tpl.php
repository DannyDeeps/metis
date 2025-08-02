<?php
/* Smarty version 3.1.40, created on 2021-10-23 16:05:30
  from 'C:\wamp64\codespace\local\metis\views\framework\sidebar.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.40',
  'unifunc' => 'content_617432ca7808b0_72621509',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '17ce817b42250036f403905d03e6d21b1eea1400' => 
    array (
      0 => 'C:\\wamp64\\codespace\\local\\metis\\views\\framework\\sidebar.tpl',
      1 => 1634999047,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_617432ca7808b0_72621509 (Smarty_Internal_Template $_smarty_tpl) {
?><nav class="sidebar">
    <a href="/" class="sidebar-title mb-md-0 me-md-auto">
        <span class="fs-4">Metis</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['pageLinks']->value, 'pageLink');
$_smarty_tpl->tpl_vars['pageLink']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['pageLink']->value) {
$_smarty_tpl->tpl_vars['pageLink']->do_else = false;
?>
            <li class="nav-item">
                <a href="<?php echo $_smarty_tpl->tpl_vars['pageLink']->value['location'];?>
" class="nav-link" aria-current="page">
                    <?php if ($_smarty_tpl->tpl_vars['pageLink']->value['icon']) {?> <i class="me-1 fas <?php echo $_smarty_tpl->tpl_vars['pageLink']->value['icon'];?>
"></i> <?php }?> <?php echo $_smarty_tpl->tpl_vars['pageLink']->value['title'];?>

                </a>
            </li>
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    </ul>
</nav><?php }
}
