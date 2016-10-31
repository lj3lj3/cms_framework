<div class="divTitle">
    <span>
        <img id="divTitleImg" src="{$divTitle.img}">
        <a href="{$divTitle.left_link}">{$divTitle.left_title}</a>
        <label>
            {assign var="index" value=0}
            {*{assign var="length" value=$title.right|@count}*}
            {foreach $divTitle.right as $innerTitle => $link}
                {$index = $index + 1}
                <a href="{$link}" target="_blank" title="{$innerTitle}" class="CurrChnlCls">{$innerTitle}</a>
                {if $index < count($divTitle.right)}
                    &nbsp;&gt;&nbsp;
                {/if}
            {/foreach}
            {*<a href="../../" target="_blank" title="首页" class="CurrChnlCls">首页</a>
            &nbsp;&gt;&nbsp;
            <a href="../" target="_blank" title="书香榆林" class="CurrChnlCls">书香榆林</a>*}
        </label>
    </span>
</div>