<div id="bayesContent">
    <form id="bayesLearnForm" action="{$serendipityBaseURL}index.php?/plugin/bayesMenuLearn" method="post">
        <table id="bayesLearnTable">
            <tr>
                <td><label for="bayesCommentName">{$CONST.NAME}</label></td>
                <td><input type="text" id="bayesCommentName" name="author"></input></td>
            </tr>
        <tr>
                <td><label for="bayesCommentUrl">{$CONST.HOMEPAGE}</label></td>
                <td>
        <input type="text" id="bayesCommentUrl" name="url"></input></td>
            </tr>
        <tr>
                <td><label for="bayesCommentEmail">{$CONST.EMAIL}</label></td>
                <td>
        <input type="text" id="bayesCommentEmail" name="email"></input></td>
            </tr>
        <tr>
                <td><label for="bayesCommentIp">{$CONST.IP}</label></td>
                <td>
        <input type="text" id="bayesCommentIp" name="ip"></input></td>
            </tr>
        <tr>
                <td><label for="bayesCommentReferrer">{$CONST.REFERER}</label></td>
                <td>
        <input type="text" id="bayesCommentReferrer" name="referrer"></input></td>
            </tr>
        <tr>
                <td><label for="bayesCommentBody">{$CONST.COMMENT}</label></td>
                <td>
        <textarea rows="10" cols="40" id="bayesCommentBody" name="body"></textarea></td>
            </tr>
        <tr>
                <td></td><td><label for="bayesCommentHam">{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_HAM}</label>
        <input class="direction_ltr input_radio" type="radio" id="bayesCommentHam" name="ham" value="true" checked="" title="{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_HAM}">
        <label for="bayesCommentSpam">{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_SPAM}</label>
        <input class="direction_ltr input_radio" type="radio" id="bayesCommentSpam" name="ham" value="false" title="{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_SPAM}"></td>
            </tr>
        </table>
        <input type="submit" class="serendipityPrettyButton input_button" value="{$CONST.SAVE}" name="submit"/>
    </form>
</div>