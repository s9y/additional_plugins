<h2>{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_NAME}</h2>

<div id="bayesContent">
    <form action="{$serendipityBaseUrl}index.php?/plugin/bayes_recycle" method="post">
        <div id="bayesControls">
                <input type="submit" class="serendipityPrettyButton input_button" value="{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_RESTORE}" name="restore"/>
                <input type="submit" class="serendipityPrettyButton input_button" value="{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_EMPTY}" name="empty" />
        </div>

        <div id="bayesRecycler">

            <ul id="serendipity_comments_list" class="clearfix plainList zebra_list">
            {foreach from=$comments item=comment}
                <li id="comment_{$comment.id}" class="clearfix {cycle values="odd,even"}">
                    <input type="hidden" name="serendipity[comments][{$comment.id}]">
                    <div class="form_check">
                        <input id="serendipity[selected][{$comment.id}]" type="checkbox" class="bayesRecyclerSelectBox" name="serendipity[selected][{$comment.id}]">
                        <label for="serendipity[selected][{$comment.id}]" class="visuallyhidden">{$CONST.TOGGLE_SELECT}</label>
                    </div>
                    <h4 id="c{$comment.id}">{$comment.author|truncate:20:"..."|escape:"html"} {$CONST.IN_REPLY_TO} <a href="{$comment.article_link}" target="_blank">{$comment.article_title}</a> {$CONST.ON} {$comment.timestamp|date_format:"%d.%m.%y, %R"} <button class="toggle_info button_link" type="button" data-href="#comment_data_{$comment.id}"><span class="icon-info-circled" aria-hidden="true"></span><span class="visuallyhidden"> More</span></button></h4>

                    <div id="comment_data_{$comment.id}" class="additional_info">
                        <dl class="comment_data clearfix">
                            <dt>name</dt>
                            <dd>{$comment.author|escape:"html"}</dd>
                            <dt>email</dt>
                            <dd>{$comment.email|escape:"html"}</dd>
                            <dt>url</dt>
                            <dd>{$comment.url|escape:"html"}</dd>
                            <dt>comment</dt>
                            <dd>{$comment.body|escape:"html"}</dd>
                        </dl>
                    </div>
                </li>
            {/foreach}
            </ul>
        </div>
    </form>
</div>