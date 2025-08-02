<?php
/* Smarty version 3.1.40, created on 2021-10-23 16:09:53
  from 'C:\wamp64\codespace\local\metis\views\pages\events\main.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.40',
  'unifunc' => 'content_617433d1178683_07202228',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1475c9a63c00c897191ce291d37ec17cf591aaff' => 
    array (
      0 => 'C:\\wamp64\\codespace\\local\\metis\\views\\pages\\events\\main.tpl',
      1 => 1635001944,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:tiles/event.tpl' => 1,
  ),
),false)) {
function content_617433d1178683_07202228 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1458476714617433d1171d24_02929464', 'content');
$_smarty_tpl->inheritance->endChild($_smarty_tpl, 'layouts/page.tpl');
}
/* {block 'content'} */
class Block_1458476714617433d1171d24_02929464 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_1458476714617433d1171d24_02929464',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


    <div class="container-fluid">
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['eventTypes']->value, 'events', false, 'type');
$_smarty_tpl->tpl_vars['events']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['type']->value => $_smarty_tpl->tpl_vars['events']->value) {
$_smarty_tpl->tpl_vars['events']->do_else = false;
?>
            <div class="fw-bold"><?php echo $_smarty_tpl->tpl_vars['type']->value;?>
</div>
            <div class="event-container">
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['events']->value, 'event');
$_smarty_tpl->tpl_vars['event']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['event']->value) {
$_smarty_tpl->tpl_vars['event']->do_else = false;
?>
                    <?php $_smarty_tpl->_subTemplateRender('file:tiles/event.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('event'=>$_smarty_tpl->tpl_vars['event']->value), 0, true);
?>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            </div>
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    </div>

    <button class="event-canvas-btn">
        Event Canvas
    </button>

<?php
}
}
/* {/block 'content'} */
}
