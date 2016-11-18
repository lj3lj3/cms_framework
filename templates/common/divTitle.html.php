<?php defined('IN_CMS') or exit('No direct script access allowed'); ?>
<div class="divTitle">
    <span>
        <img id="divTitleImg" src="<?php echo $data['divTitle']['img'];?>">
        <a href="<?php echo $data['divTitle']['left_link'];?>"><?php echo $data['divTitle']['left_title'];?></a>
        <label>
            <?php $index=0?>
            <?php $n=1; if(is_array($data['divTitle']['right'])) foreach($data['divTitle']['right'] AS $innerTitle => $link) { ?>
                <?php $index = $index + 1?>
                <a href="<?php echo $link;?>" target="_blank" title="<?php echo $innerTitle;?>" class="CurrChnlCls"><?php echo $innerTitle;?></a>
                <?php if($index < count($data['divTitle']['right'])) { ?>
                    &nbsp;&gt;&nbsp;
                <?php } ?>
            <?php $n++;}?>
            <!--{*<a href="../../" target="_blank" title="首页" class="CurrChnlCls">首页</a>
            &nbsp;&gt;&nbsp;
            <a href="../" target="_blank" title="书香榆林" class="CurrChnlCls">书香榆林</a>*}-->
        </label>
    </span>
</div>