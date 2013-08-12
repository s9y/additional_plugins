<?php # 

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

define('PLUGIN_EVENT_AUTOSAVE_PROP_SHADOW', 'ep_autosave_shadowed');
define('PLUGIN_EVENT_AUTOSAVE_PREFIX', '[AUTOSAVED] ');

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include_once dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_event_autosave extends serendipity_event
{
	var $saveSuccessfull = false;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_AUTOSAVE_TITLE);
        $propbag->add('description',   PLUGIN_EVENT_AUTOSAVE_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Jay Bertrand');
        $propbag->add('requirements',  array(
            'serendipity' => '0.9',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('version',       '0.2.2');
        $propbag->add('configuration', array());
        $propbag->add('event_hooks',    array(
			'backend_entryform' 	=> true,
            'external_plugin'		=> true,
			'backend_entry_presave' => true,
			'backend_save'			=> true
         ));

		$propbag->add('configuration', array('frequency','path'));
        $propbag->add('groups', array('BACKEND_EDITOR'));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'frequency':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_AUTOSAVE_INTERVAL);
                $propbag->add('description', PLUGIN_EVENT_AUTOSAVE_INTERVAL_DESC);
                $propbag->add('validate', '/^[0-9]+$/');
                $propbag->add('validate_error', PLUGIN_EVENT_AUTOSAVE_INTERVAL_ERROR);
                $propbag->add('default', '300');
                break;

            case 'path':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_AUTOSAVE_HTTPATH);
                $propbag->add('description', PLUGIN_EVENT_AUTOSAVE_HTTPATH_DESC);
                $propbag->add('validate', '/[^\\*|]/');
                $propbag->add('validate_error', PLUGIN_EVENT_AUTOSAVE_HTTPATH_ERROR);
                $propbag->add('default', 'plugins/serendipity_event_autosave');
                break;

            default:
                return false;
                break;
        }
        return true;
    }

    function generate_content(&$title) {
        $title = PLUGIN_EVENT_AUTOSAVE_TITLE;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');
        if (isset($hooks[$event])) {
            switch($event) {

				case 'backend_entry_presave':
					if(isset($serendipity['POST']['shadowed']) && is_numeric($serendipity['POST']['shadowed']))
						// update last_modified to make sure the shadow copy is more recent than the original post
						$eventData['last_modified'] = time();
					break;

				case 'backend_save':
					// dirty hack to confirm an entry has been saved
					$this->saveSuccessfull = true;

					// entry has been successfully saved, delete shadow copies of it (if any)
					// REM: this hook is also called when saving the shadow copy
					$ret = serendipity_db_query("SELECT value FROM {$serendipity['dbPrefix']}entryproperties ".
						"WHERE entryid={$eventData['id']} AND property='".PLUGIN_EVENT_AUTOSAVE_PROP_SHADOW."'", true /*single*/);

					if(is_array($ret)) {
						// drop shadow copy and extra properties
						serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}entries WHERE id=".(int)current($ret));
						serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}entryproperties ".
							"WHERE entryid={$eventData['id']} AND property='".PLUGIN_EVENT_AUTOSAVE_PROP_SHADOW."'", true /*single*/);
					}

					break;

				case 'backend_entryform':
					?>
					<script type="text/javascript" src="<?php echo $this->get_config('path') ?>/js/prototype.js"></script>
					<script type="text/javascript" src="<?php echo $this->get_config('path') ?>/js/rico.js"></script>
					<script type="text/javascript">

					// global variables
					var autosaveIsAlreadyRunning = false;
					var autosaveUseShadowCopy    = false;
					var autosaveShadowCanRecover = false;
					var autosaveShadowCopyId     = 0;

					<?php
					// when editing an already published post, autosave shouldn't overwrite the existing entry
					// (because it would toggle the draft status, which would make the entry disappear suddenly
					// from the frontend and it would update post with partial data ... bad trip !)
					// in that case, we use a "shadow copy" of the entry for saving (another entry saved as
					// draft) and attach a property to the real entry in order to link the two
					// (the fake entry will be deleting when saving the real entry)
					if($eventData['isdraft'] !== 'true' && is_numeric($eventData['id'])) {

						// enable shadow copy
						echo("autosaveUseShadowCopy=true;\n");

						// search a shadowed copy of this post if it exists (needed for example when previewing)
						// REM: join on the entries table to make sure this is not garbage data which should have been deleted previously
						$ret = serendipity_db_query(
							"SELECT ep.value, e.id, e.last_modified ".
							"FROM {$serendipity['dbPrefix']}entryproperties ep ".
							"LEFT JOIN {$serendipity['dbPrefix']}entries e ON ep.value=e.id ".
							"WHERE ep.entryid={$eventData['id']} AND ep.property='".PLUGIN_EVENT_AUTOSAVE_PROP_SHADOW."'", true /*single*/);

						// found a matching row, this should be the id of the associated shadow copy ...
						// if no row found, a new shadow entry will be created on first ajax call
						if(is_array($ret)) {
							if($ret[1] == NULL) {
								// oh oh, this was garbage data not linked to any entry, delete it now
								serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}entryproperties ".
									"WHERE entryid={$eventData['id']} AND property='".PLUGIN_EVENT_AUTOSAVE_PROP_SHADOW."'");
							} else {
								// autosaved data exists, recovering is possible ...
								echo("autosaveShadowCopyId=".(int)current($ret).";\n");
								if((!isset($serendipity['POST']['preview']) || $serendipity['POST']['preview'] !== 'true')) {
									// user is not previewing, he must be editing an already published post for the first time
									if((int)$ret[2] > $eventData['last_modified']) {
										// autosaved data are more recent than original post
										// propose a link to recover autosaved data "inline"
										echo('autosaveShadowCanRecover=true;');
									}
								}
							} // end if
						}
					}
					?>

					// helper functions
					function red(mesg) {
						return '<span style="color: red;">' + mesg + '</span>';
					}
					function green(mesg) {
						return '<span style="color: green;">' + mesg + '</span>';
					}

					// register ajax stuff once the page is loaded (addLoadEvent() is provided by serendipity ;-))
					addLoadEvent(function() {

						//--------------------------------------------------------------------------------------
						//--------------------------------------------------------------------------------------
						// This object is a listener that will be used to dynamically
						// update the page when an ajax query (response in fact :-)) comes back
						//--------------------------------------------------------------------------------------
						//--------------------------------------------------------------------------------------
						var AutosaveUpdater = Class.create();
						AutosaveUpdater.prototype = {
							// "constructor"
							initialize: function() {
							},
							// call by the engine when server has replied
							ajaxUpdate: function(ajaxResponse) {

								try {
									var tag = document.getElementById('autosaveResult');
									var obj = ajaxResponse.childNodes[0];
									if(obj == null ||typeof(obj) == 'undefined') {
										tag.innerHTML = red('<?php echo addslashes(PLUGIN_EVENT_AUTOSAVE_AJAX_ERROR) ?>');
									} else {
										// depending on the name of the received xml element,
										// different actions are taken (one object for multiple purpose)
										if(obj.tagName == 'save') {
											//--------------------------------------------------
											// entry has been saved, update important fields
											//--------------------------------------------------
											var entryId = obj.getAttribute('id');
											if(entryId == 0) {
												tag.innerHTML = red('<?php echo addslashes(PLUGIN_EVENT_AUTOSAVE_SAVE_ERROR) ?>');
											} else {
												if(autosaveUseShadowCopy)
													autosaveShadowCopyId = entryId;
												else
													//document.getElementById('entryid').value = entryId;
													document.forms[0].elements['serendipity[id]'].value = entryId;

												// tell the user that save succeeded :-)
												tag.innerHTML = green(entryId + ' : <?php echo addslashes(PLUGIN_EVENT_AUTOSAVE_SAVED) ?>');
											}

										} /*else if(obj.tagName == 'restore') {

											//--------------------------------------------------
											// received the shadow copy for « inline updating »
											//--------------------------------------------------
											var f = document.forms['serendipityEntry'];
											f.elements['serendipity[title]'].value = obj.getAttribute('title');
											f.elements['serendipity[body]'].value = obj.getAttribute('body');
											f.elements['serendipity[extended]'].value = obj.getAttribute('extended');
											// TODO: update other (less important) fields here ...

											// moves the contents from the form elements to the editors
											if(typeof(tinyMCE) != 'undefined') {
												// TinyMCE has some nice helper functions
												tinyMCE.updateContent('serendipity[body]');
												tinyMCE.updateContent('serendipity[extended]');

											} else if(typeof(HTMLArea) != 'undefined') {

												alert(document.getElementsByTagName('iframe').length);

												// HtmlAREA need some tricky coding: the object instances are not
												// stored in variables (arg!) so we must find a way to update editors
												// from fields contents ...
												var f = document.forms['serendipityEntry'];
												try {
													f.onreset();
													// not enough, only the first editor is updated !
												} catch(e) {}

											} else {
												// unknown wysiwyg editor (winha falls here for the moment !)
												tag.innerHTML = red('<?php echo addslashes(PLUGIN_EVENT_AUTOSAVE_UNSUPPORTED_EDITOR) ?>');
												return;
											}

											// warn the user everything went well
											tag.innerHTML = green('<?php echo addslashes(PLUGIN_EVENT_AUTOSAVE_RESTORED) ?>');

										}*/ else {
											//--------------------------------------------------
											// unknown response ...
											//--------------------------------------------------
											tag.innerHTML = red('<?php echo addslashes(PLUGIN_EVENT_AUTOSAVE_BAD_RESPONSE) ?>');

										} // end if
									}
								} catch(e) {}
							}
						};

						<?php
						// build the url for the external_plugin event
						$url = $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?/'.PATH_PLUGIN.'/autosave&amp;';
						?>
						try {
							ajaxEngine.registerRequest('autosave', '<?php echo $url ?>');
							ajaxEngine.registerAjaxObject('autosaveUpdater', new AutosaveUpdater());
							var link = document.getElementById('autosaveLink');
							link.innerHTML = '<a href="javascript:doSave();"><?php echo addslashes(PLUGIN_EVENT_AUTOSAVE_ACTIVATED); ?></a>';
							if(autosaveShadowCanRecover && autosaveShadowCopyId) {
								/*link.innerHTML += '<br /><em><a href="javascript:doRecover(autosaveShadowCopyId);">' +
									'<?php echo addslashes(PLUGIN_EVENT_AUTOSAVE_RECOVER); ?>' + '</a></em>';*/

								// handled by the 'backend_entryform' hook
								link.innerHTML += '<br /><em style="padding-left: 1em;">' +
									'<a href="#" onclick="doRecover(<?php echo((int)$eventData['id']) ?>);">' +
									'<?php echo addslashes(PLUGIN_EVENT_AUTOSAVE_RECOVER); ?>' + '</a></em>';
							}

							// used to enable autosaving periodically
							<?php if(($freq = (int)$this->get_config('frequency'))  != 0){ ?>
							var periodicalExecuter = new PeriodicalExecuter(doSave, <?php echo $freq ?>);
							<?php } ?>

						} catch(e) {
							// AJAX engine is not properly initialized ...
							mesg = '/!\\ <?php echo(addslashes(PLUGIN_EVENT_AUTOSAVE_INIT_FAILED)); ?> :-(';
							alert(mesg + '\r\n' + 'Source: ' + e);

							var link = document.getElementById('autosaveLink');
							link.innerHTML = '<span style="color: red; font-weihgt: bold;">'+mesg+'</span>';
						}
					});

					// do the recovering job
					function doRecover(entryid) {
						if(confirm('<?php echo(addslashes(PLUGIN_EVENT_AUTOSAVE_CONFIRM)) ?>')) {
							document.location.href='<?php echo $serendipity['serendipityHTTPPath'] ?>' + '/' +
								'serendipity_admin.php?serendipity[action]=admin&' +
								'serendipity[adminModule]=entries&serendipity[adminAction]=edit&' +
								'serendipity[id]=' + entryid + '&autosave[id]=' + autosaveShadowCopyId;
						}

						// ARGGG: "inline recovering" is impossible due to some bugs and a lack of support
						// in wysiwyg editors ;-( only TinyMCE handles it nicely ... so give up ajax  for the moment
						/*
						if(autosaveIsAlreadyRunning) return;
						autosaveIsAlreadyRunning = true;

						// some visual feedback for the user
						var resultTag = document.getElementById('autosaveResult');
						resultTag.innerHTML = '<?php echo addslashes(PLUGIN_EVENT_AUTOSAVE_RESTORING) ?>';

						// build query string and send request
						var postData = 'serendipity[adminAction]=restore&serendipity[entryid]=' + parseInt(id);
						ajaxEngine.sendRequest('autosave', {parameters : postData, method: 'post'});

						autosaveIsAlreadyRunning = false;
						return;
						*/
					}

					// do the saving job
					function doSave() {

						// just in case ... (don't return false or
						// the browser will show a blank page with only
						// 'false' written in the upper left corner,
						// simply return from the function)
						if(!checkSave()) return;

						// don't work too much ;-)
						if(autosaveIsAlreadyRunning) return;
						autosaveIsAlreadyRunning = true;

						var resultTag = document.getElementById('autosaveResult');
						resultTag.innerHTML = '<?php echo addslashes(PLUGIN_EVENT_AUTOSAVE_STARTING) ?>';;

						try {
							var f = document.forms['serendipityEntry'];

							// DIRTY HACK : when using a wysiwyg editor, data has to be flushed from
							// the editor to the form element before being submitted. This is usually (always ?)
							// done transparently by the editor that register a function "into" the onsubmit()
							// event of the form (at least, it is the case for the HtmlArea default editor).
							// So we call manually the onsubmit() handler (hoping this won't have
							// some nasty side effect) to flush data before serializing fields.
							// Hint: TinyMCE work slightly differently, if overrides the sumbit() function,
							// not the event handler. This is not very usefull to us since it will force
							// a reload of the whole page ;-(. Happilly, tinyMCE provides a triggerSave()
							// that will do the job ;-) What about Xhina ?!? Duno but don't use ;-)
							// If someone could tell me ...
							if(typeof(tinyMCE) != 'undefined')
								tinyMCE.triggerSave();
							else if(typeof(f.onsubmit) == 'function')
								f.onsubmit();

							// save draft status before serialization and restore just after
							var draftStatus = f.elements['serendipity[isdraft]'].selectedIndex;	// save
							f.elements['serendipity[isdraft]'].selectedIndex = 1;				// tweak
							// prototype knows how to serialize a form ;-)
							// REM: ANY field is serialized, this sould enable "unknown"
							// extensions to be saved properly as well :-) (to be tested though !)
							var postData = Form.serialize('serendipityEntry');
							f.elements['serendipity[isdraft]'].selectedIndex = draftStatus;		// restore

							if(autosaveUseShadowCopy) {
								// we're using a shadow entry for saving purpose
								postData += "&serendipity[shadowed]=" + autosaveShadowCopyId;
							}

							// send (asynchroneous) request
							ajaxEngine.sendRequest('autosave', {parameters : postData, method: 'post'});

						} catch(e) {
							resultTag.innerHTML = red('<?php echo addslashes(PLUGIN_EVENT_AUTOSAVE_AJAX_ERROR) ?>' + ' [' + e + ']');
						}

						autosaveIsAlreadyRunning = false;
						return;
					}
					</script>
					<span id="autosaveLink"><?php echo(PLUGIN_EVENT_AUTOSAVE_ACTIVATING); ?></span><br />
					<span id="autosaveResult"><?php

					// the recover handling (is it really the right place to do this ?!?)
					if(isset($serendipity['GET']) && isset($serendipity['GET']['id']) && is_numeric($serendipity['GET']['id']) &&
							isset($_GET['autosave']['id']) && is_numeric($_GET['autosave']['id'])) {

						// SANITY CHECK: verify $autosave['id'] is really the shadow copy of given entry (just to be sure)
						$ret = serendipity_db_query(
							"SELECT e.id ".
							"FROM {$serendipity['dbPrefix']}entryproperties ep ".
							"LEFT JOIN {$serendipity['dbPrefix']}entries e ON ep.value=e.id ".
							"WHERE ep.entryid={$serendipity['GET']['id']} AND ep.property='".PLUGIN_EVENT_AUTOSAVE_PROP_SHADOW."'", true /*single*/);

						if(!is_array($ret) || current($ret) == NULL || (int)current($ret) != (int)$_GET['autosave']['id']) {
							echo('<span style="color: red;">'.PLUGIN_EVENT_AUTOSAVE_BAD_SHADOW.'</span>');
						} else {

							// fetch the autosaved entry and replace the original one by the shadow copy "on the fly" :-)
							$entry = serendipity_fetchEntry('id', $_GET['autosave']['id'], 1, 1);
							if(is_array($entry)) {
								// modify (partly) the entry on the fly with backed up data :-)
								foreach($entry as $key=>$value)
									if($key != 'id' && $key != 'isdraft') $eventData[$key] = $value;
							} else {
								echo('<span style="color: red;">'.PLUGIN_EVENT_AUTOSAVE_RECOVER_FAILED);
								echo((strlen(trim($entry)) ? ' ('.$entry.')' : '').'</span>');
							}

						}
					} // end if

					?></span><br />
					<?php
					break;

                case 'external_plugin':
					// first check the event is really for us :-)
					// $eventData looks like "autosave&amp;param=value"
					if(strncmp($eventData,'autosave&amp;', 13) != 0) return false;

					// REM: $serendipity['GET']['adminAction'] is always set in
					// serendipity_config.inc.php whatever the http method used
					if(!isset($serendipity['GET']['adminAction'])) return false;

					// IMPORTANT: make sure the client knows it will receive xml
					header('Content-Type: text/xml');

					if(strncmp($serendipity['GET']['adminAction'], 'restore', 7)==0 && is_numeric($serendipity['POST']['entryid'])) {
						//-----------------------------------------------------------
						// restoring an entry from it's shadow copy
						//-----------------------------------------------------------

						// TODO: load the entry using a statement like (see function_entries.inc.php)
						// $entry = serendipity_fetchEntry('id', $serendipity['POST']['entryid'], true /*full*/, true /*drafts*/);

					ob_start();

						// send response
						echo '<ajax-response><response type="object" id="autosaveUpdater">';
						echo '<restore title="from ajax" body="body here" extended="extended here" />';
						echo '</response></ajax-response>';

					$fd = fopen(dirname(__FILE__).'/debug.log', 'w');
					fwrite($fd, ob_get_contents());
					fclose($fd);

					ob_end_flush();

					} elseif(strncmp($serendipity['GET']['adminAction'], 'save', 4)==0) {
						//-----------------------------------------------------------
						// saving an entry
						//-----------------------------------------------------------

						// handling of shadow copies
						if(isset($serendipity['POST']['shadowed']) && is_numeric($serendipity['POST']['shadowed'])) {
							// save the id of the "real" post (should be a valid id !)
							$realEntryId = (int)$serendipity['POST']['id'];
							// prevent overwritting of published post
							$serendipity['POST']['id'] = (int)$serendipity['POST']['shadowed'];
							if($serendipity['POST']['id']==0) $serendipity['POST']['id'] = '';
						}

						// just to be sure the user is aware that it is an autosaved entry :-)
						if(strncmp($serendipity['POST']['title'], PLUGIN_EVENT_AUTOSAVE_PREFIX, strlen(PLUGIN_EVENT_AUTOSAVE_PREFIX)) != 0)
							$serendipity['POST']['title'] = PLUGIN_EVENT_AUTOSAVE_PREFIX.$serendipity['POST']['title'];

						// save entry here (just including the file will do it :-)) but discard output
						// (althoug we won't get a precise message if an error occurs ;-()
						ob_start();
						// /!\ awfull hack: there's no simple way (?) to know if an entry has been
						// successfully saved, so we use a flag that is toggled when backend_save is
						// called since backend_save is the latest event hook called when "upderting"
						// an entry (see serendipity_updertEntry() in functions_entries.inc.php)
						$this->saveSuccessfull = false;
						require_once S9Y_INCLUDE_PATH.'include/admin/entries.inc.php';
						if(false == $this->saveSuccessfull) $entry = array('id' => 0);
						ob_end_clean();

						if(isset($realEntryId) && is_numeric($realEntryId)) {
							// "updert" a property on original entry to link it to the shadow copy
							serendipity_db_query("UPDATE {$serendipity['dbPrefix']}entryproperties SET value=".(int)$entry['id']." ".
								"WHERE entryid=".(int)$realEntryId." AND property='".PLUGIN_EVENT_AUTOSAVE_PROP_SHADOW."'");
							serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}entryproperties (entryid,property,value) ".
								"VALUES (".(int)$realEntryId.", '".PLUGIN_EVENT_AUTOSAVE_PROP_SHADOW."',".(int)$entry['id'].")");
						}

						// send back the generated id to the client (or 0 if save failed, whatever the reason)
						echo '<ajax-response><response type="object" id="autosaveUpdater">';
						echo '<save id="'.(is_array($entry) && isset($entry['id']) && (0 !== (int)$entry['id']) ? $entry['id'] : 0).'" />';
						echo '</response></ajax-response>';

					}
					exit();
                    break;

                default:
                    return false;
                    break;
            }
			// event has been handled :-)
			return true;
        }
        return false;
    }
}

/* vim: set sts=4 ts=4 expandtab : */
