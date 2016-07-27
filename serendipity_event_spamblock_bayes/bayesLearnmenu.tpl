<div id="bayesContent">
    <form id="bayesLearnForm" action="{$serendipityBaseURL}index.php?/plugin/bayesMenuLearn" method="post">
    {if $s9ybackend == 1}
        <table id="bayesLearnTable">
            <tr>
                <td><label for="bayesCommentName">{$CONST.NAME}</label></td>
                <td><input type="text" id="bayesCommentName" name="author"></input></td>
            </tr>
            <tr>
                <td><label for="bayesCommentUrl">{$CONST.HOMEPAGE}</label></td>
                <td><input type="text" id="bayesCommentUrl" name="url"></input></td>
            </tr>
            <tr>
                <td><label for="bayesCommentEmail">{$CONST.EMAIL}</label></td>
                <td><input type="text" id="bayesCommentEmail" name="email"></input></td>
            </tr>
            <tr>
                <td><label for="bayesCommentIp">IP</label></td>
                <td><input type="text" id="bayesCommentIp" name="ip"></input></td>
            </tr>
            <tr>
                <td><label for="bayesCommentReferrer">{$CONST.REFERER}</label></td>
                <td><input type="text" id="bayesCommentReferrer" name="referrer"></input></td>
            </tr>
            <tr>
                <td><label for="bayesCommentBody">{$CONST.COMMENT}</label></td>
                <td><textarea rows="10" cols="40" id="bayesCommentBody" name="body"></textarea></td>
            </tr>
            <tr>
                <td></td>
                <td><label for="bayesCommentHam">{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_HAM}</label>
                    <input class="direction_ltr input_radio" type="radio" id="bayesCommentHam" name="ham" value="true" checked="" title="{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_HAM}">
                    <label for="bayesCommentSpam">{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_SPAM}</label>
                    <input class="direction_ltr input_radio" type="radio" id="bayesCommentSpam" name="ham" value="false" title="{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_SPAM}"></td>
            </tr>
        </table>
        <input type="submit" class="serendipityPrettyButton input_button" value="{$CONST.SAVE}" name="submit"/>
    {else}
        <div class="form_field">
            <label for="bayesCommentName">{$CONST.NAME}</label>
            <input type="text" id="bayesCommentName" name="author">
        </div>

        <div class="form_field">
            <label for="bayesCommentUrl">{$CONST.HOMEPAGE}</label>
            <input type="text" id="bayesCommentUrl" name="url">
        </div>

        <div class="form_field">
            <label for="bayesCommentEmail">{$CONST.EMAIL}</label>
            <input type="text" id="bayesCommentEmail" name="email">
        </div>

        <div class="form_field">
            <label for="bayesCommentIp">IP</label>
            <input type="text" id="bayesCommentIp" name="ip">
        </div>

        <div class="form_field">
            <label for="bayesCommentReferrer">{$CONST.REFERER}</label>
            <input type="text" id="bayesCommentReferrer" name="referrer">
        </div>

        <div class="form_area">
            <label for="bayesCommentBody">{$CONST.COMMENT}</label>
            <textarea rows="10" id="bayesCommentBody" name="body"></textarea>
        </div>

        <div class="clearfix">
            <div class="form_radio">
                <label for="bayesCommentHam">{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_HAM}</label>
                <input class="direction_ltr" type="radio" id="bayesCommentHam" name="ham" value="true" checked="">
            </div>

            <div class="form_radio">
                <label for="bayesCommentSpam">{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_SPAM}</label>
                <input class="direction_ltr" type="radio" id="bayesCommentSpam" name="ham" value="false">
            </div>
        </div>

        <div class="form_buttons">
            <input type="submit" value="{$CONST.SAVE}" name="submit">
        </div>
    {/if}
    </form>
</div>
