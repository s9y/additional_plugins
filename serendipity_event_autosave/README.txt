*** How to start ***
--------------------

Once installed, there are two configuration variables to setup:

    * - the time interval in seconds between two autosave calls (or 0 to disable it,
        manual save using the hyperlink is still available)
    * - the blog-relative http path to the plugin (default value should work nicely for most people)

Then, you just have to start editing entries :-)

*** Dealing with already published entries ***
----------------------------------------------

It took me some time but I finally found how to deal smartly with already published entries:
I couldn't juste overwrite the existing entry or users would see partial changes, so I use a
"shadow copy", another entry saved as draft, with title starting by '[AUTOSAVED] '. The original
entry is linked to it's shadow copy through a property.

*** Recovering after a browser crash ***
----------------------------------------

If your entry hasn't been published yet, it's easy, just edit the draft and remove the
'[AUTOSAVED] ' string from the title, complete your post and save :-)

If your entry has already been published, then just go back editing it (don't take care of
the associated shadow entry!). You should have a second link as below. Clicking it will
reload the entry being edited with backuped data. Complete your post and submit as usual,
this will save your entry AND delete the shadow copy.

Note: for the moent, I couldn't restore "inline" with an ajax call because of the wysiwyg editors ;-(

*** How does it works internally ?!? ***
----------------------------------------

All the magic stuff is done using an AJAX call in javascript. The Rico library is used for that.
When page has been loaded, the ajax engine is initialized : nothing really exciting here, 
associate each endpoint url with a logical name to simplify calls laters and register an html
element (a span) to receive the result from the call.

Each time the configured period is over (or on user explicit demand), an ajax call is made with
the contents of the being edited post (except the publication status that is set to draft to avoid
publication of partial psots :-)). On server side, data are being saved using the same code as a
"normal" save (i.e. the include/admin/entries.php is "included" with adminAction set to 'save').
If needed (i.e for not-yet-saved posts), the hidden input field entryid is updated with newly
generated id, thus enabling the save button to update backup with final data :-).

*** Requirements ***
--------------------

An ajax-compliant browser, that is to say a browser that provides the XmlHttpRequest object or
equivalent. This has been tested successfully with Firefox 1.5 and IE 6.0 SP2 (see the RICO home
page for supported browsers) and with TinyMCE and HtmlArea, the default editor.

The plugin currently do not work with Xhina (I'm working on it) and has not been tested with the
'versionning' plugin. Any volunteers? :-) However, it now works perfectly with the entrycheck plugin.

Feel free to send any comments, questions, suggestions, translations to me (jay dot bertrand at free dot fr).
