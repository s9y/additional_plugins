<?php 

@define('PLUGIN_BROWSERID_NAME',     'BrowserID Authentification');
@define('PLUGIN_BROWSERID_DESC',     'Allows authors to authenticate using the BrowserID service.');

@define('PLUGIN_BROWSERID_DESCRIPTION', 
'<h3>Using BrwoserID to log into your blog</h3>' .
'<p>BrowserID does not need any configuration. You will login naming the email address associated with <a href="serendipity_admin.php?serendipity[adminModule]=personal">your blog account</a>.<br/> 
If you did not register your email with BrowserID yet, you can do so while login or you can directly do it at <a href="https://browserid.org/" target="_blank">the BrowserID website</a>.<br/>
BrowserID needs to verify first, that you are the owner of this email. After this process you are ready to use your new BrowserID as login.</p>'
);
