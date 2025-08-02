<?php
/* Smarty version 3.1.40, created on 2021-10-23 15:13:38
  from 'C:\wamp64\codespace\local\metis\views\pages\dashboard\main.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.40',
  'unifunc' => 'content_617426a2ed6820_33427981',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '37a1a442256a9fc3d1ed1c17ca0bae3b3a6613d7' => 
    array (
      0 => 'C:\\wamp64\\codespace\\local\\metis\\views\\pages\\dashboard\\main.tpl',
      1 => 1634996597,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_617426a2ed6820_33427981 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1817033913617426a2eccf64_85648995', "content");
$_smarty_tpl->inheritance->endChild($_smarty_tpl, "layouts/page.tpl");
}
/* {block "content"} */
class Block_1817033913617426a2eccf64_85648995 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_1817033913617426a2eccf64_85648995',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div class="row">
        <?php if (!empty($_smarty_tpl->tpl_vars['events']->value)) {?>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['events']->value, 'event');
$_smarty_tpl->tpl_vars['event']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['event']->value) {
$_smarty_tpl->tpl_vars['event']->do_else = false;
?>
                <div class="col-2">
                    <div class="card">
                        <div class="m-2">
                            <?php echo $_smarty_tpl->tpl_vars['event']->value['getId'];?>

                        </div>
                        <div class="m-2">
                            <?php echo $_smarty_tpl->tpl_vars['event']->value['getUserId'];?>

                        </div>
                        <div class="m-2">
                            <?php echo $_smarty_tpl->tpl_vars['event']->value['getEventTypeId'];?>

                        </div>
                        <div class="m-2">
                            <?php echo $_smarty_tpl->tpl_vars['event']->value['getDescription'];?>

                        </div>
                    </div>
                </div>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        <?php }?>
    </div>
<?php
}
}
/* {/block "content"} */
}
