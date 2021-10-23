<?php
/* Smarty version 3.1.40, created on 2021-10-23 13:50:26
  from 'C:\wamp64\codespace\local\metis\views\toasts\notice.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.40',
  'unifunc' => 'content_61741322c3fcb8_98181971',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '67d253b0ec45bb2bf416977377b22db37d2a9320' => 
    array (
      0 => 'C:\\wamp64\\codespace\\local\\metis\\views\\toasts\\notice.tpl',
      1 => 1634997023,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_61741322c3fcb8_98181971 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="toast position-absolute top-0 start-50 translate-middle-x align-items-center text-white bg-<?php echo $_smarty_tpl->tpl_vars['notice']->value->getStatus();?>
 bg-gradient border-0 mt-2" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
        <div class="toast-body">
            <?php if (!empty($_smarty_tpl->tpl_vars['notice']->value->getIcon())) {?>
                <?php echo $_smarty_tpl->tpl_vars['notice']->value->getIcon();?>

            <?php }?>
            <?php echo $_smarty_tpl->tpl_vars['notice']->value->getPrevious()->getMessage();?>

        </div>
        <div class="d-flex ms-auto">
            <button type="button" class="btn shadow-none text-light" data-bs-toggle="collapse" data-bs-target="#notice-info">
                <i class="fas fa-binoculars"></i>
            </button>
            <button type="button" class="btn shadow-none text-light" data-bs-dismiss="toast">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="collapse" id="notice-info">
        <div class="notice-info px-4 py-2 d-flex flex-column">
            <span class="text-wrap text-break">Thrown on line <strong><?php echo $_smarty_tpl->tpl_vars['notice']->value->getPrevious()->getLine();?>
</strong> in file <strong><?php echo $_smarty_tpl->tpl_vars['notice']->value->getPrevious()->getFile();?>
</strong></span>
        </div>
    </div>
</div><?php }
}
