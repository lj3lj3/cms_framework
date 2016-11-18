<?php defined('IN_CMS') or exit('No direct script access allowed'); ?>
<div class="artbox">
    <h3><?php echo $data['article']['title'];?></h3>
    <div class="function_tex"><label>发布时间：<?php echo $data['article']['updatetime'];?></label><label>来源：<?php echo $data['article']['copyfrom'];?></label><label
    >责任编辑：<?php echo $data['article']['author'];?></label></div>
    <div id="content" class="content">
        <?php echo $data['article']['content'];?>
    </div>
</div>