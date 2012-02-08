<div id="bayesContent">
    {foreach from=$comments item=comment}
        <h3>{$CONST.COMMENT} {$comment.id}</h3>

        <ul class="plainList bayesAnalysis">
            {foreach from=$types item=type}
                <li class="ratingBox"><div class="commentType">{$type}</div>
                    <div class="commentPart">{$comment.$type|escape}</div>
                    <div class="rating">
                        {if $comment.ratings.$type != "-"}
                            {$comment.ratings.$type|regex_replace:"/\..*/":""}%
                        {else}
                            {$comment.ratings.$type}
                        {/if}
                    </div>
                </li>
            {/foreach}
        </ul>
       <div class="finalRating">{$comment.rating|regex_replace:"/\..*/":""}%</div>
    {/foreach}

    <script src="{$path}jquery.excerpt.js" type="text/javascript"></script>
    <script>shortenAll("commentPart", 1)
    colorize()</script>
</div>