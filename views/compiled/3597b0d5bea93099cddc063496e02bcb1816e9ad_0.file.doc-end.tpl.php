<?php
/* Smarty version 3.1.40, created on 2021-10-23 16:09:53
  from 'C:\wamp64\codespace\local\metis\views\framework\doc-end.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.40',
  'unifunc' => 'content_617433d12aef90_55082210',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3597b0d5bea93099cddc063496e02bcb1816e9ad' => 
    array (
      0 => 'C:\\wamp64\\codespace\\local\\metis\\views\\framework\\doc-end.tpl',
      1 => 1634997228,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_617433d12aef90_55082210 (Smarty_Internal_Template $_smarty_tpl) {
?>
    <div class="js-container d-none">
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['js']->value, 'file');
$_smarty_tpl->tpl_vars['file']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['file']->value) {
$_smarty_tpl->tpl_vars['file']->do_else = false;
?>
            <?php echo '<script'; ?>
 src="/assets/js/<?php echo $_smarty_tpl->tpl_vars['file']->value;?>
.js"><?php echo '</script'; ?>
>
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    </div>

</body>
</html><?php }
}
